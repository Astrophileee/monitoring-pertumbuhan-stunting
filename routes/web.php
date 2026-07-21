<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::post('/cari-balita', [PublicController::class, 'cari'])->name('cari.balita');
Route::get('/hasil-balita/{nik}', [PublicController::class, 'hasil'])->name('hasil.balita');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Kader Posyandu Routes
    Route::middleware(['role:Kader Posyandu'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('orang_tuas', OrangTuaController::class);
        Route::resource('balitas', BalitaController::class);
        Route::resource('pemeriksaans', PemeriksaanController::class);
    });

    // Pimpinan Pustu Routes
    Route::middleware(['role:Pimpinan Pustu'])->group(function () {
        Route::get('/laporans', [LaporanController::class, 'index'])->name('laporans.index');
        Route::get('/laporans/cetak', [LaporanController::class, 'cetak'])->name('laporans.cetak');
    });
});

require __DIR__.'/auth.php';
