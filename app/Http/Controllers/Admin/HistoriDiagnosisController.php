<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\indikasi;
use Illuminate\Http\Request;

class HistoriDiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'loginDuration' => $this->LoginDuration(),
            'diagnosis' => $this->getHistoryDiagnosis(),
        ];

        return view('admin.histori-diagnosis.histori-diagnosis', $data);
    }

    public function getHistoryDiagnosis()
    {
        $diagnosis = Diagnosis::with(['user' => function ($query) {
            $query->select('id', 'name', 'email');
        }, 'kepribadian' => function ($query) {
            $query->select('id', 'name');
        }])->get(['id', 'user_id', 'kepribadian_id', 'updated_at'])->map(function ($diagnosis) {
            if ($diagnosis['kepribadian'] == null) {
                $diagnosis['kepribadian'] = [
                    'id' => null,
                    'name' => 'Lihat Detail',
                ];
            }
            $diagnosis['updated_at'] = $diagnosis['updated_at'];
            $diagnosis['user'] = $diagnosis['user']->toArray();
            $diagnosis['kepribadian'] = $diagnosis['kepribadian'];
            return [
                'id' => $diagnosis['id'],
                'updated_at' => $diagnosis['updated_at'],
                'user' => $diagnosis['user'],
                'kepribadian' => $diagnosis['kepribadian'],
            ];
        })->values()->toArray();

        return $diagnosis;
    }

    public function detail($id)
    {
        $diagnosis = Diagnosis::find($id, ['answer_log']);
        $answerLog = json_decode($diagnosis->answer_log, true);
        foreach ($answerLog as $key => $value) {
            $answerLog[$key] = $value == 1 ? 'Ya' : 'Tidak';
        }
        $indikasi = indikasi::whereIn('id', array_keys($answerLog))->get(['id', 'name']);
        foreach ($indikasi as $item) {
            $item->answer = $answerLog[$item->id];
        }
        $answerLog = $indikasi->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'answer' => $item->answer,
            ];
        });

        $data = [
            'loginDuration' => $this->LoginDuration(),
            'detailDiagnosis' => $answerLog->toArray(),
        ];

        return view('admin.histori-diagnosis.detail', $data);
    }
}
