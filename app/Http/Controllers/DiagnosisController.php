<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\indikasi;
use App\Models\kepribadian;
use App\Models\Rule;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function diagnosis(Request $request)
    {
        $allindikasi = indikasi::get('id')->count();

        $request->validate([
            'idindikasi' => ['required', 'numeric', 'max:' . $allindikasi, 'min:1'],
        ]);

        $requestFakta = [
            $request->idindikasi => filter_var($request->value, FILTER_VALIDATE_BOOLEAN)
        ];

        $diagnosisCheck = Diagnosis::where('user_id', auth()->user()->id)->get()->last();
        if ($diagnosisCheck == null) {
            $modelDiagnosis = new Diagnosis();
            $modelDiagnosis->user_id = auth()->user()->id;
        } else if ($diagnosisCheck->kepribadian_id == null) {
            $maxAnswerlog = max(array_keys(json_decode($diagnosisCheck->answer_log, true) ?? []));
            if ($maxAnswerlog == $allindikasi) {
                $modelDiagnosis = new Diagnosis();
                $modelDiagnosis->user_id = auth()->user()->id;
            } else {
                $modelDiagnosis = $diagnosisCheck;
            }
        } else if ($diagnosisCheck->kepribadian_id != null) {
            $modelDiagnosis = new Diagnosis();
            $modelDiagnosis->user_id = auth()->user()->id;
        }
        $decodeAnswerLog = json_decode($modelDiagnosis->answer_log, true) ?? [];
        $answerLog = $decodeAnswerLog + $requestFakta;
        $modelDiagnosis->answer_log = json_encode($answerLog);
        $modelDiagnosis->save();

        //Aturan
        $rule = Rule::get(['kepribadian_id', 'indikasi_id']);
        $aturan = [];
        foreach ($rule as $key => $value) {
            $aturan[$value->kepribadian_id][] = $value->indikasi_id;
        }

        //Basis Fakta
        $fakta = $answerLog;

        //Inferensi
        $terdeteksi = false;
        foreach ($aturan as $kepribadianId => $indikasi) {
            $apakahkepribadian = true;
            foreach ($indikasi as $indikasikepribadian) {
                $fakta[$indikasikepribadian] = $fakta[$indikasikepribadian] ?? false;
                if (!$fakta[$indikasikepribadian]) {
                    $apakahkepribadian = false;
                    break;
                }
            }
            if ($apakahkepribadian) {
                if ($modelDiagnosis->kepribadian_id == null) {
                    $modelDiagnosis->kepribadian_id = $kepribadianId;
                    $modelDiagnosis->save();
                }
                $kepribadian = kepribadian::where('id', $modelDiagnosis->kepribadian_id)->first('id');
                $terdeteksi = true;
            }
        }

        // Tidak ada kepribadian yang terdeteksi
        if (!$terdeteksi && $request->idindikasi == $allindikasi) {
            return response()->json([
                'kepribadianUnidentified' => true,
                'idkepribadian' => null,
                'idDiagnosis' => $modelDiagnosis->id,
            ]);
        }

        return response()->json([
            'idDiagnosis' => $modelDiagnosis->id,
            'idkepribadian' => $kepribadian ?? null
        ]);
    }
}
