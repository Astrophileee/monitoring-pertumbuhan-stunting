<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function index()
    {
        $balitas = \App\Models\Balita::with('orangTua')->latest()->get();
        $orang_tuas = \App\Models\OrangTua::all();
        return view('balitas.index', compact('balitas', 'orang_tuas'));
    }
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'orang_tua_id' => 'required|exists:orang_tuas,id',
            'nik' => 'required|string|max:20|unique:balitas',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        \App\Models\Balita::create($request->all());
        return redirect()->route('balitas.index')->with('success', 'Data balita berhasil ditambahkan.');
    }

    public function show(\App\Models\Balita $balita)
    {
        $balita->load(['orangTua', 'pemeriksaans' => function($q) {
            $q->orderBy('tanggal_pemeriksaan', 'desc');
        }]);
        return view('balitas.show', compact('balita'));
    }
    public function update(\Illuminate\Http\Request $request, \App\Models\Balita $balita)
    {
        $request->validate([
            'orang_tua_id' => 'required|exists:orang_tuas,id',
            'nik' => 'required|string|max:20|unique:balitas,nik,'.$balita->id,
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $balita->update($request->all());
        return redirect()->route('balitas.index')->with('success', 'Data balita berhasil diperbarui.');
    }

    public function destroy(\App\Models\Balita $balita)
    {
        $balita->delete();
        return redirect()->route('balitas.index')->with('success', 'Data balita berhasil dihapus.');
    }
}
