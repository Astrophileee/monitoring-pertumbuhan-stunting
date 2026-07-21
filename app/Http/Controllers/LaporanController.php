<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $pemeriksaans = \App\Models\Pemeriksaan::with(['balita.orangTua', 'user'])->orderBy('tanggal_pemeriksaan', 'desc')->get();
        return view('laporans.index', compact('pemeriksaans'));
    }

    public function cetak()
    {
        $pemeriksaans = \App\Models\Pemeriksaan::with(['balita.orangTua', 'user'])->orderBy('tanggal_pemeriksaan', 'desc')->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporans.cetak', compact('pemeriksaans'));
        return $pdf->stream('laporan_pemeriksaan_balita.pdf');
    }
}
