<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemeriksaan;
use App\Models\Balita;

class LaporanController extends Controller
{
    public function index()
    {
        $pemeriksaans = Pemeriksaan::with(['balita.orangTua', 'user'])->orderBy('tanggal_pemeriksaan', 'desc')->get();
        
        // Data statistik untuk pimpinan
        $totalPemeriksaan = $pemeriksaans->count();
        $totalBalita = Balita::count();
        
        $statusCounts = $pemeriksaans->groupBy('status_pertumbuhan')->map->count();
        
        $totalNormal = $statusCounts->get('Normal', 0) + $statusCounts->get('normal', 0);
        $totalStunting = $statusCounts->get('Stunting', 0) + $statusCounts->get('stunting', 0);
        $totalGiziBuruk = $statusCounts->get('Gizi Buruk', 0) + $statusCounts->get('gizi buruk', 0) + $statusCounts->get('gizi kurang', 0);
        $totalGiziLebih = $statusCounts->get('Gizi Lebih', 0) + $statusCounts->get('gizi lebih', 0);

        $stuntingPercentage = $totalPemeriksaan > 0 ? round(($totalStunting / $totalPemeriksaan) * 100, 1) : 0;

        return view('laporans.index', compact(
            'pemeriksaans', 'totalPemeriksaan', 'totalBalita', 
            'totalNormal', 'totalStunting', 'totalGiziBuruk', 'totalGiziLebih', 'stuntingPercentage'
        ));
    }

    public function cetak()
    {
        $pemeriksaans = Pemeriksaan::with(['balita.orangTua', 'user'])->orderBy('tanggal_pemeriksaan', 'desc')->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporans.cetak', compact('pemeriksaans'));
        return $pdf->stream('laporan_pemeriksaan_balita.pdf');
    }
}
