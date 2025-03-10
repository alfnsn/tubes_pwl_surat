<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\KeteranganAktifController;
use App\Models\KeteranganAktif;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/Mahasiswa/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('Mahasiswa.dashboard');

    Route::get('/Kaprodi/dashboard', function () {
        return view('kaprodi.dashboard');
    })->name('Kaprodi.dashboard');

    Route::get('/MO/dashboard', function () {
        return view('mo.dashboard');
    })->name('MO.dashboard');

    Route::get('/Admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('Admin.dashboard');
});

require __DIR__.'/auth.php';
