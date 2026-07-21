<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function cari(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
        ]);

        $balita = \App\Models\Balita::where('nik', $request->nik)->first();
        if($balita) {
            return redirect()->route('hasil.balita', $balita->nik);
        }

        return back()->with('error', 'Data balita dengan NIK tersebut tidak ditemukan.');
    }

    public function hasil($nik)
    {
        $balita = \App\Models\Balita::with(['orangTua', 'pemeriksaans' => function($q) {
            $q->orderBy('tanggal_pemeriksaan', 'desc');
        }])->where('nik', $nik)->firstOrFail();

        return view('public.hasil', compact('balita'));
    }
}
