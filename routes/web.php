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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MataKuliahController;

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan');

Route::post('/notifications/{id}/markAsRead', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::post('/pengajuan/{id}/upload', [PengajuanController::class, 'upload'])->name('pengajuan-upload');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:1'])->group(function (){
        Route::get('/Mahasiswa/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('Mahasiswa.dashboard');

        Route::get('/mahasiswa/profile', function () {
            return view('mahasiswa.profile');
        })->name('mahasiswa.profile');

        Route::get('/mahasiswa/dashboard/pengajuan', [PengajuanController::class, 'showPengajuanMahasiswa'])->name('pengajuan-mahasiswa');Route::get('/mahasiswa/keterangan-aktif', function () {
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
    });

    Route::middleware(['role:2'])->group(function (){
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
        Route::get('/kaprodi/profile', function () {
            return view('mahasiswa.profile');
        })->name('kaprodi.profile');
    });
    // Route::get('/Kaprodi/dashboard', function () {
    //     return view('kaprodi.dashboard');
    // })->name('Kaprodi.dashboard');

    Route::middleware(['role:3'])->group(function (){
        Route::get('/MO/dashboard', [PengajuanController::class, 'showPengajuanMo'])->name('MO.dashboard');
        Route::get('/MO/dashboard/pengajuan-riwayat-detail-mo/{id}', [PengajuanController::class, 'showPengajuanDetailRiwayatMo'])->name('pengajuan-riwayat-detail-mo');
        Route::get('/MO/dashboard/pengajuan-riwayat-mo', [PengajuanController::class, 'showRiwayatPengajuanMO'])->name('pengajuan-riwayat-mo');
        Route::get('/MO/dashboard/pengajuan-detail-mo/{id}', [PengajuanController::class, 'showPengajuanDetailMO'])->name('pengajuan-detail-mo');
        
        Route::get('/MO/profile', function () {
            return view('mahasiswa.profile');
        })->name('mo.profile');
    });

    
    Route::middleware(['role:4'])->group(function (){
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
            Route::get('/dosen', [PenggunaController::class, 'showDosen'])->name('pengguna.dosen');
        });

        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('Admin.dashboard');
        Route::get('/admin/studyProgram', [App\Http\Controllers\StudyProgramController::class, 'index'])->name('admin.studyProgram');
        Route::get('/admin/studyProgram/create', [App\Http\Controllers\StudyProgramController::class, 'create'])->name('admin.studyProgram.create');
        Route::post('/admin/studyProgram', [App\Http\Controllers\StudyProgramController::class, 'store'])->name('admin.studyProgram.store');
        Route::get('/admin/studyProgram/{id}/edit', [App\Http\Controllers\StudyProgramController::class, 'edit'])->name('admin.studyProgram.edit');
        Route::put('/admin/studyProgram/{id}', [App\Http\Controllers\StudyProgramController::class, 'update'])->name('admin.studyProgram.update');
        Route::delete('/admin/studyProgram/{id}', [App\Http\Controllers\StudyProgramController::class, 'destroy'])->name('admin.studyProgram.destroy');
    
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('mata-kuliah', [MataKuliahController::class, 'index'])->name('mataKuliah');
            Route::get('mata-kuliah/create', [MataKuliahController::class, 'create'])->name('mataKuliah.create');
            Route::post('mata-kuliah', [MataKuliahController::class, 'store'])->name('mataKuliah.store');
            Route::get('mata-kuliah/{id}/edit', [MataKuliahController::class, 'edit'])->name('mataKuliah.edit');
            Route::put('mata-kuliah/{id}', [MataKuliahController::class, 'update'])->name('mataKuliah.update');
            Route::delete('mata-kuliah/{id}', [MataKuliahController::class, 'destroy'])->name('mataKuliah.destroy');
            
        });

        Route::get('/admin/keterangan-lulus', [KeteranganLulusController::class, 'index'])->name('keterangan-lulus-admin');
        Route::get('/admin/keterangan-lulus/create', [KeteranganLulusController::class, 'create'])->name('admin.createKeteranganLulus');
        Route::post('/admin/keterangan-lulus/store', [KeteranganLulusController::class, 'store'])->name('admin.storeKeteranganLulus');
        
        Route::get('/admin/keterangan-aktif', [KeteranganAktifController::class, 'index'])->name('keterangan-aktif-admin');
        Route::get('/admin/keterangan-aktif/create', [KeteranganAktifController::class, 'create'])->name('admin.createKeteranganAktif');
        Route::post('/admin/keterangan-aktif/store', [KeteranganAktifController::class, 'store'])->name('admin.storeKeteranganAktif');
        
        Route::get('/admin/keterangan-lulus', [KeteranganLulusController::class, 'index'])->name('keterangan-lulus-admin');

        Route::get('/admin/profile', [AdminController::class, 'editProfile'])->name('admin.profile');
        Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    
        Route::get('/admin/laporan-hasil-studi', [App\Http\Controllers\LaporanHasilStudiController::class, 'index'])->name('laporan-hasil-studi-admin');
        Route::get('/admin/laporan-hasil-studi/create', [App\Http\Controllers\LaporanHasilStudiController::class, 'create'])->name('admin.createLaporanHasilStudi');
        Route::post('/admin/laporan-hasil-studi/store', [App\Http\Controllers\LaporanHasilStudiController::class, 'store'])->name('admin.storeLaporanHasilStudi');
    
        Route::get('/admin/pengantar-tugas-mata-kuliah', [App\Http\Controllers\PengantarTugasMataKuliahController::class, 'index'])->name('pengantar-tugas-mata-kuliah-admin');
        Route::get('/admin/pengantar-tugas-mata-kuliah/create', [App\Http\Controllers\PengantarTugasMataKuliahController::class, 'create'])->name('admin.createPengantarTugasMataKuliah');
        Route::post('/admin/pengantar-tugas-mata-kuliah/store', [App\Http\Controllers\PengantarTugasMataKuliahController::class, 'store'])->name('admin.storePengantarTugasMataKuliah');
    
    });
    
    Route::get('/riwayat-pengajuan', [PengajuanController::class, 'showPengajuan'])->name('riwayat-pengajuan');
    Route::get('/riwayat-pengajuan-detail/{id}', [PengajuanController::class, 'showPengajuanDetail'])->name('riwayat-pengajuan-detail');
});
require __DIR__.'/auth.php';
