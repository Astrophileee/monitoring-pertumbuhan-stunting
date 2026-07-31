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
    $totalBalita = \App\Models\Balita::count();
    $totalOrangTua = \App\Models\OrangTua::count();
    $totalPemeriksaan = \App\Models\Pemeriksaan::count();

    // Gender breakdown
    $balitaLaki = \App\Models\Balita::where('jenis_kelamin', 'L')->count();
    $balitaPerempuan = \App\Models\Balita::where('jenis_kelamin', 'P')->count();

    // Pemeriksaan bulan ini
    $pemeriksaanBulanIni = \App\Models\Pemeriksaan::whereMonth('tanggal_pemeriksaan', now()->month)
        ->whereYear('tanggal_pemeriksaan', now()->year)
        ->count();

    // Status pertumbuhan distribution
    $statusDistribusi = \App\Models\Pemeriksaan::selectRaw('status_pertumbuhan, COUNT(*) as total')
        ->whereNotNull('status_pertumbuhan')
        ->groupBy('status_pertumbuhan')
        ->pluck('total', 'status_pertumbuhan');

    $stunting   = $statusDistribusi->get('Stunting', 0);
    $normal     = $statusDistribusi->get('Normal', 0);
    $gizi_buruk = $statusDistribusi->get('Gizi Buruk', 0);
    $gizi_lebih = $statusDistribusi->get('Gizi Lebih', 0);

    // Persentase stunting dari total pemeriksaan yang ada status
    $totalDenganStatus = $statusDistribusi->sum();
    $persenStunting = $totalDenganStatus > 0 ? round(($stunting / $totalDenganStatus) * 100, 1) : 0;

    // Pemeriksaan terbaru (5 data)
    $pemeriksaanTerbaru = \App\Models\Pemeriksaan::with(['balita', 'user'])
        ->orderByDesc('tanggal_pemeriksaan')
        ->limit(5)
        ->get();

    // Data chart 6 bulan terakhir
    $chartData = [];
    for ($i = 5; $i >= 0; $i--) {
        $bulan = now()->subMonths($i);
        $chartData[] = [
            'label' => $bulan->translatedFormat('M Y'),
            'total' => \App\Models\Pemeriksaan::whereMonth('tanggal_pemeriksaan', $bulan->month)
                ->whereYear('tanggal_pemeriksaan', $bulan->year)
                ->count(),
        ];
    }

    return view('dashboard', compact(
        'totalBalita', 'totalOrangTua', 'totalPemeriksaan',
        'balitaLaki', 'balitaPerempuan',
        'pemeriksaanBulanIni',
        'stunting', 'normal', 'gizi_buruk', 'gizi_lebih',
        'persenStunting', 'totalDenganStatus',
        'pemeriksaanTerbaru',
        'chartData'
    ));
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
