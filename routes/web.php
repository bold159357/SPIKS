<?php

use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ShowPdfController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserController::class, 'index'])->name('index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('home', [\App\Http\Controllers\Controller::class, 'authenticated'])->name('home');

    Route::prefix('admin')->middleware('can:asAdmin')->group(function () {
        Route::get('beranda', [BerandaController::class, 'index'])->name('admin.beranda');
        Route::prefix('kepribadian')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\kepribadianController::class, 'index'])->name('admin.kepribadian');
            Route::get('tambah', [\App\Http\Controllers\Admin\kepribadianController::class, 'create'])->name('admin.kepribadian.tambah');
            Route::post('store', [\App\Http\Controllers\Admin\kepribadianController::class, 'store'])->name('admin.kepribadian.store');
            Route::get('edit/{id}', [\App\Http\Controllers\Admin\kepribadianController::class, 'edit'])->name('admin.kepribadian.edit');
            Route::put('update/{id}', [\App\Http\Controllers\Admin\kepribadianController::class, 'update'])->name('admin.kepribadian.update');
            Route::delete('destroy/{id}', [\App\Http\Controllers\Admin\kepribadianController::class, 'destroy'])->name('admin.kepribadian.destroy');
            Route::get('pdf', [ShowPdfController::class, 'kepribadianPdf'])->name('kepribadian.pdf');
        });
        Route::prefix('indikasi')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\indikasiController::class, 'index'])->name('admin.indikasi');
            Route::get('tambah', [\App\Http\Controllers\Admin\indikasiController::class, 'create'])->name('admin.indikasi.tambah');
            Route::post('store', [\App\Http\Controllers\Admin\indikasiController::class, 'store'])->name('admin.indikasi.store');
            Route::get('edit/{id}', [\App\Http\Controllers\Admin\indikasiController::class, 'edit'])->name('admin.indikasi.edit');
            Route::put('update/{id}', [\App\Http\Controllers\Admin\indikasiController::class, 'update'])->name('admin.indikasi.update');
            Route::delete('destroy/{id}', [\App\Http\Controllers\Admin\indikasiController::class, 'destroy'])->name('admin.indikasi.destroy');
            Route::get('pdf', [ShowPdfController::class, 'indikasiPdf'])->name('indikasi.pdf');
        });
        Route::prefix('rule')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\RuleController::class, 'index'])->name('admin.rule');
            Route::get('tambah', [\App\Http\Controllers\Admin\RuleController::class, 'create'])->name('admin.rule.tambah');
            Route::post('store', [\App\Http\Controllers\Admin\RuleController::class, 'store'])->name('admin.rule.store');
            Route::get('edit/{id}', [\App\Http\Controllers\Admin\RuleController::class, 'edit'])->name('admin.rule.edit');
            Route::put('update/{id}', [\App\Http\Controllers\Admin\RuleController::class, 'update'])->name('admin.rule.update');
            Route::delete('destroy/{id}', [\App\Http\Controllers\Admin\RuleController::class, 'destroy'])->name('admin.rule.destroy');
            Route::get('pdf', [ShowPdfController::class, 'rulePdf'])->name('rule.pdf');
        });
        Route::prefix('cek')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\CekController::class, 'index'])->name('admin.cek');
            Route::get('tambah', [\App\Http\Controllers\Admin\CekController::class, 'create'])->name('admin.cek.tambah');
            Route::post('store', [\App\Http\Controllers\Admin\CekController::class, 'store'])->name('admin.cek.store');
            Route::get('edit/{id}', [\App\Http\Controllers\Admin\CekController::class, 'edit'])->name('admin.cek.edit');
            Route::put('update/{id}', [\App\Http\Controllers\Admin\CekController::class, 'update'])->name('admin.cek.update');
            Route::delete('destroy/{id}', [\App\Http\Controllers\Admin\CekController::class, 'destroy'])->name('admin.cek.destroy');
            Route::get('pdf', [ShowPdfController::class, 'cekPdf'])->name('cek.pdf');
        });
        Route::prefix('histori-diagnosis')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\HistoriDiagnosisController::class, 'index'])->name('admin.histori.diagnosis');
            Route::get('detail/{id}', [\App\Http\Controllers\Admin\HistoriDiagnosisController::class, 'detail'])->name('admin.histori.diagnosis.detail');
            Route::delete('destroy', [\App\Http\Controllers\Admin\HistoriDiagnosisController::class, 'destroy'])->name('admin.diagnosis.destroy');
            Route::get('pdf', [ShowPdfController::class, 'historiDiagnosisPdf'])->name('histori.diagnosis.pdf');
        });
    });

    Route::middleware('can:asUser')->group(function () {
        Route::post('diagnosis', [DiagnosisController::class, 'diagnosis'])
            ->middleware('can:hasUserProfile')
            ->name('user.diagnosis');
        Route::put('edit-profile', [\App\Http\Controllers\UserProfileController::class, 'updateUser'])->name('update-profile');
        Route::delete('histori-diagnosis-user', [\App\Http\Controllers\UserController::class, 'historiDiagnosis'])->name('histori-diagnosis-user.delete');
        Route::middleware('check.direct.access')->group(function () {
            Route::middleware('can:hasUserProfile')->group(function () {
                Route::get('get-indikasi', [UserController::class, 'getindikasi'])->name('get-indikasi');
                Route::get('detail-diagnosis', [UserController::class, 'detailDiagnosis'])->name('detail-diagnosis');
                Route::get('chart-diagnosis-kepribadian', [UserController::class, 'chartDiagnosiskepribadian'])->name('chart-diagnosis-kepribadian');
            });
            Route::get('/show-view', [\App\Http\Controllers\DiagnosisController::class, 'showView'])->name('show.view');
            Route::get('histori-diagnosis-user', [\App\Http\Controllers\UserController::class, 'historiDiagnosis'])->name('histori-diagnosis-user');
            Route::get('edit-profile', [\App\Http\Controllers\UserProfileController::class, 'index'])->name('edit-profile');
            Route::get('sekolah', [\App\Http\Controllers\sekolahController::class, 'indexgender'])->name('sekolah');
            Route::get('edit-profile/lokasi/kota/{id}', [\App\Http\Controllers\sekolahController::class, 'indexCity'])->name('kota');
        });
    });

    Route::middleware('can:asGuru')->group(function () {
        Route::get('beranda', [BerandaController::class, 'index'])->name('guru.beranda');
    });
});

Route::post('/auth/google', [SocialAuthController::class, 'redirectToProvider'])->name('google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleProviderCallback'])
    ->name('google.callback');

    
