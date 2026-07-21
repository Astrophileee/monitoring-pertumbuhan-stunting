<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function index()
    {
        $orang_tuas = \App\Models\OrangTua::latest()->get();
        return view('orang_tuas.index', compact('orang_tuas'));
    }


    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        \App\Models\OrangTua::create($request->all());
        return redirect()->route('orang_tuas.index')->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\OrangTua $orangTua)
    {
        $request->validate([
            'no_kk' => 'required|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $orangTua->update($request->all());
        return redirect()->route('orang_tuas.index')->with('success', 'Data orang tua berhasil diperbarui.');
    }

    public function destroy(\App\Models\OrangTua $orangTua)
    {
        $orangTua->delete();
        return redirect()->route('orang_tuas.index')->with('success', 'Data orang tua berhasil dihapus.');
    }
}
