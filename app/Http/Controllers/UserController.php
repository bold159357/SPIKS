<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\indikasi;
use App\Models\kepribadian;
use App\Models\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $kepribadian = kepribadian::get(['id', 'name', 'reason', 'solution']);

        return view('user.user', compact('kepribadian'));
    }


    public function historiDiagnosis(Request $request)
    {
        if ($request->isMethod('delete')) {
            $diagnosis = Diagnosis::find($request->id);
            $diagnosis->delete();
            return response()->json([
                'message' => 'Berhasil menghapus data',
            ]);
        }

        $user = auth()->user();

        $query = Diagnosis::with(['kepribadian' => function ($query) {
            $query->select('id', 'name');
        }])->where('user_id', $user->id ?? null);

        if ($request->has('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where(function ($q) use ($searchValue) {
                $q->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('kepribadian', function ($q) use ($searchValue) {
                        $q->where('name', 'like', '%' . $searchValue . '%');
                    });
            });
        }

        $totalData = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 5);

        $orderColumn = $request->input('order.0.column', 0);
        $orderDirection = $request->input('order.0.dir', 'asc');

        $orderColumns = [
            0 => 'id',
            1 => 'created_at',
        ];

        if (array_key_exists($orderColumn, $orderColumns)) {
            $orderBy = $orderColumns[$orderColumn];
            $query->orderBy($orderBy, $orderDirection);

            $no = ($orderDirection == 'asc') ? $totalData - $start : $start + 1;
        }

        $historiDiagnosis = $query
            ->offset($start)
            ->limit($length)
            ->get(['id', 'created_at', 'kepribadian_id']);

        $data = $historiDiagnosis->map(function ($item) use (&$no, $orderDirection) {
            $kepribadian = kepribadian::find($item->kepribadian_id, ['name']);
            $item->kepribadian = $kepribadian ? $kepribadian->name : 'Tidak Diketahui';
            $item->no = ($orderDirection == 'asc') ? $no-- : $no++;
            return $item;
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $data,
        ]);
    }

    public function detailDiagnosis(Request $request)
    {
        $kepribadian = kepribadian::find(
            Diagnosis::find($request->id_diagnosis, ['kepribadian_id'])->kepribadian_id,
            ['name', 'reason', 'solution']
        );

        $diagnosis = Diagnosis::find($request->id_diagnosis, ['answer_log']);
        $answerLog = json_decode($diagnosis->answer_log, true);
        foreach ($answerLog as $key => $value) {
            $answerLog[$key] = $value == 1 ? 'Ya' : 'Tidak';
        }
        $indikasi = indikasi::whereIn('id', array_keys($answerLog))->get(['id', 'name']);
        foreach ($indikasi as $item) {
            $item->answer = $answerLog[$item->id];
        }
        $answerLog = $indikasi->map(function ($item) use ($request) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'answer' => $item->answer,
            ];
        });

        return response()->json(
            [
                'kepribadian' => $kepribadian,
                'answerLog' => $answerLog,
            ]
        );
    }

    public function getindikasi()
    {
        $indikasi = indikasi::get(['id', 'name']);
        return response()->json($indikasi);
    }


    public function chartDiagnosiskepribadian(Request $request)
    {
        // Mengumpulkan aturan-aturan berdasarkan kepribadian dan indikasi
        $rule = Rule::get(['kepribadian_id', 'indikasi_id']);
        $aturan = [];
        foreach ($rule as $value) {
            $aturan[$value->kepribadian_id][] = $value->indikasi_id;
        }

        // Mendapatkan data diagnosis dan log jawaban
        $diagnosis = Diagnosis::find($request->id_diagnosis, ['answer_log']);
        $answerLog = json_decode($diagnosis->answer_log, true);

        // Menghitung bobot untuk setiap kepribadian
        $bobot = [];
        foreach ($aturan as $idkepribadian => $idindikasi) {
            $bobot[$idkepribadian] = 0;
            foreach ($answerLog as $key => $value) {
                if (in_array($key, $idindikasi)) {
                    $bobot[$idkepribadian] += $value;
                }
            }
        }

        // Menghitung persentase bobot untuk setiap kepribadian
        foreach ($bobot as $key => $value) {
            $jumlahindikasi = count($aturan[$key]);
            $bobot[$key] = ($jumlahindikasi > 0) ? round(($value / $jumlahindikasi) * 100, 2) : 0;
        }

        // Melakukan pemetaan bobot ke nama kepribadian
        $bobot = collect($bobot)->mapWithKeys(function ($item, $key) {
            $kepribadian = kepribadian::find($key, ['id', 'name']);
            return [$kepribadian->name => $item];
        });

        return response()->json($bobot);
    }
}
