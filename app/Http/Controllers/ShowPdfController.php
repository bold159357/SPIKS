<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\indikasiController;
use App\Http\Controllers\Admin\HistoriDiagnosisController;
use App\Http\Controllers\Admin\kepribadianController;
use App\Http\Controllers\Admin\RuleController;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;

class ShowPdfController extends Controller
{

    public function kepribadianPdf()
    {
        $data = new kepribadianController();
        $data = $data->index();
        $data = $data['kepribadian'];
        $data = $data->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('d-m-Y');
        }
        $data = ['kepribadian' => $data];
        $pdf = Pdf::loadView('pdf.kepribadian', $data);
        return $pdf->stream('kepribadian_SPDHTC.pdf');
    }

    public function indikasiPdf()
    {
        $data = new indikasiController();
        $data = $data->index();
        $data = $data['indikasi'];
        $data = $data->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('d-m-Y');
        }
        $data = ['indikasi' => $data];
        $pdf = Pdf::loadView('pdf.indikasi', $data);
        return $pdf->stream('indikasi_SPDHTC.pdf');
    }

    public function rulePdf()
    {
        $data = new RuleController();
        $data = $data->index();
        $data = $data['rules'];
        foreach ($data as $key => $value) {
            $data[$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('d-m-Y');
        }
        $data = ['rules' => $data];
        $pdf = Pdf::loadView('pdf.rule', $data);
        return $pdf->stream('rule_SPDHTC.pdf');
    }

    public function historiDiagnosisPdf()
    {
        $data = new HistoriDiagnosisController();
        $data = $data->index();
        $data = $data['diagnosis'];
        foreach ($data as $key => $value) {
            $data[$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('d-m-Y');
        }
        $data = ['historiDiagnosis' => $data];
        $pdf = Pdf::loadView('pdf.histori-diagnosis', $data);
        return $pdf->stream('histori-diagnosis_SPDHTC.pdf');
    }
}
