<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

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

// Tambahkan rute berdasarkan role
Route::middleware(['auth'])->group(function () {
    Route::get('/mahasiswa/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');

    Route::get('/kaprodi/dashboard', function () {
        return view('kaprodi.dashboard');
    })->name('kaprodi.dashboard');

    Route::get('/mo/dashboard', function () {
        return view('mo.dashboard');
    })->name('mo.dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';
