<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\KeteranganAktifController;
use App\Models\KeteranganAktif;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeteranganLulusController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/mahasiswa/keterangan-aktif', function () {
    return view('mahasiswa.keterangan-aktif');
})->name('mahasiswa.keterangan-aktif');

Route::get('/mahasiswa/pengantar-mata-kuliah', function () {
    return view('mahasiswa.pengantar-mata-kuliah');
})->name('mahasiswa.pengantar-mata-kuliah');

Route::get('/mahasiswa/keterangan-lulus', function () {
    return view('mahasiswa.keterangan-lulus');
})->name('mahasiswa.keterangan-lulus');

Route::get('/mahasiswa/laporan-hasil-studi', function () {
    return view('mahasiswa.laporan-hasil-studi');
})->name('mahasiswa.laporan-hasil-studi');

Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan');

Route::post('/notifications/{id}/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::post('/pengajuan/{id}/upload', [PengajuanController::class, 'upload'])->name('pengajuan-upload');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/Mahasiswa/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('Mahasiswa.dashboard');

    // Route::get('/Kaprodi/dashboard', function () {
    //     return view('kaprodi.dashboard');
    // })->name('Kaprodi.dashboard');

    Route::get('/MO/dashboard', [PengajuanController::class, 'showPengajuanMo'])->name('MO.dashboard');

    Route::get('/admin/pengguna', [App\Http\Controllers\AdminController::class, 'pengguna'])->name('admin.pengguna');
    Route::get('/admin/pengguna/create', [PenggunaController::class, 'create'])->name('admin.pengguna.create');
    Route::post('/admin/pengguna', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.pengguna.store');
    Route::get('/admin/pengguna/{id}/edit', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.pengguna.edit');
    Route::put('/admin/pengguna/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.pengguna.update');
    Route::delete('/admin/pengguna/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.pengguna.destroy');

    Route::prefix('pengguna')->group(function () {
        Route::get('/mahasiswa', [PenggunaController::class, 'showMahasiswa'])->name('pengguna.mahasiswa');
        Route::get('/kaprodi', [PenggunaController::class, 'showKaprodi'])->name('pengguna.kaprodi');
        Route::get('/mo', [PenggunaController::class, 'showMo'])->name('pengguna.mo');
        Route::get('/admin', [PenggunaController::class, 'showAdmin'])->name('pengguna.admin');
    });

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('Admin.dashboard');
    Route::get('/admin/studyProgram', [App\Http\Controllers\StudyProgramController::class, 'index'])->name('admin.studyProgram');
    Route::get('/admin/studyProgram/create', [App\Http\Controllers\StudyProgramController::class, 'create'])->name('admin.studyProgram.create');
    Route::post('/admin/studyProgram', [App\Http\Controllers\StudyProgramController::class, 'store'])->name('admin.studyProgram.store');
    Route::get('/admin/studyProgram/{id}/edit', [App\Http\Controllers\StudyProgramController::class, 'edit'])->name('admin.studyProgram.edit');
    Route::put('/admin/studyProgram/{id}', [App\Http\Controllers\StudyProgramController::class, 'update'])->name('admin.studyProgram.update');
    Route::delete('/admin/studyProgram/{id}', [App\Http\Controllers\StudyProgramController::class, 'destroy'])->name('admin.studyProgram.destroy');

    Route::get('/riwayat-pengajuan', [PengajuanController::class, 'showPengajuan'])->name('riwayat-pengajuan');
    Route::get('/riwayat-pengajuan-detail/{id}', [PengajuanController::class, 'showPengajuanDetail'])->name('riwayat-pengajuan-detail');
    Route::get('/admin/keterangan-lulus', [KeteranganLulusController::class, 'index'])->name('keterangan-lulus-admin');
    
    Route::get('/kaprodi/dashboard', [PengajuanController::class, 'showPengajuanKaprodi'])->name('Kaprodi.dashboard');
    Route::get('/kaprodi/dashboard/pengajuan-detail/{id}', [PengajuanController::class, 'showPengajuanDetailKaprodi'])->name('pengajuan-detail');
    Route::post('/kaprodi/dashboard/pengajuan-accept/{id}', [PengajuanController::class, 'update'])->name('pengajuan-accept');
    Route::post('/kaprodi/dashboard/pengajuan-reject/{id}', [PengajuanController::class, 'update'])->name('pengajuan-reject');
    Route::get('/kaprodi/dashboard/pengajuan-riwayat', [PengajuanController::class, 'showRiwayatPengajuanKaprodi'])->name('pengajuan-riwayat');
    
    Route::get('/kaprodi/dashboard', [PengajuanController::class, 'showPengajuanKaprodi'])->name('Kaprodi.dashboard');
    Route::get('/kaprodi/dashboard/pengajuan-detail/{id}', [PengajuanController::class, 'showPengajuanDetailKaprodi'])->name('pengajuan-detail');
    Route::post('/kaprodi/dashboard/pengajuan-accept/{id}', [PengajuanController::class, 'update'])->name('pengajuan-accept');
    Route::post('/kaprodi/dashboard/pengajuan-reject/{id}', [PengajuanController::class, 'update'])->name('pengajuan-reject');
    Route::get('/kaprodi/dashboard/pengajuan-riwayat', [PengajuanController::class, 'showRiwayatPengajuanKaprodi'])->name('pengajuan-riwayat');
    
    Route::get('/admin/keterangan-lulus', [KeteranganLulusController::class, 'index'])->name('keterangan-lulus-admin');
    
    Route::get('/MO/dashboard/pengajuan-riwayat-mo', [PengajuanController::class, 'showRiwayatPengajuanMO'])->name('pengajuan-riwayat-mo');
    Route::get('/MO/dashboard/pengajuan-detail-mo/{id}', [PengajuanController::class, 'showPengajuanDetailMO'])->name('pengajuan-detail-mo');


    // Template



});
require __DIR__.'/auth.php';
