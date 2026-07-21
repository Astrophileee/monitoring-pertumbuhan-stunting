<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $pemeriksaans = \App\Models\Pemeriksaan::with(['balita', 'user'])->latest()->get();
        $balitas = \App\Models\Balita::all();
        return view('pemeriksaans.index', compact('pemeriksaans', 'balitas'));
    }
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'balita_id' => 'required|exists:balitas,id',
            'tanggal_pemeriksaan' => 'required|date',
            'umur_bulan' => 'required|integer|min:0',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lila' => 'nullable|numeric|min:0',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        
        $balita = \App\Models\Balita::find($request->balita_id);
        if ($balita) {
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(5)->post('http://127.0.0.1:8000/predict', [
                    'umur_bulan' => (int) $request->umur_bulan,
                    'jenis_kelamin' => $balita->jenis_kelamin == 'L' ? 'laki-laki' : 'perempuan',
                    'berat_badan' => (float) $request->berat_badan,
                    'tinggi_badan' => (float) $request->tinggi_badan,
                    'lila' => (float) ($request->lila ?? 0)
                ]);

                if ($response->successful()) {
                    $data['status_pertumbuhan'] = $response->json('status_gizi');
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('API ML Error: ' . $e->getMessage());
            }
        }

        \App\Models\Pemeriksaan::create($data);
        return redirect()->route('pemeriksaans.index')->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }
    public function update(\Illuminate\Http\Request $request, \App\Models\Pemeriksaan $pemeriksaan)
    {
        $request->validate([
            'balita_id' => 'required|exists:balitas,id',
            'tanggal_pemeriksaan' => 'required|date',
            'umur_bulan' => 'required|integer|min:0',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lila' => 'nullable|numeric|min:0',
        ]);

        $data = $request->all();
        $balita = \App\Models\Balita::find($request->balita_id);
        if ($balita) {
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(5)->post('http://127.0.0.1:8000/predict', [
                    'umur_bulan' => (int) $request->umur_bulan,
                    'jenis_kelamin' => $balita->jenis_kelamin == 'L' ? 'laki-laki' : 'perempuan',
                    'berat_badan' => (float) $request->berat_badan,
                    'tinggi_badan' => (float) $request->tinggi_badan,
                    'lila' => (float) ($request->lila ?? 0)
                ]);

                if ($response->successful()) {
                    $data['status_pertumbuhan'] = $response->json('status_gizi');
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('API ML Error: ' . $e->getMessage());
            }
        }

        $pemeriksaan->update($data);
        return redirect()->route('pemeriksaans.index')->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroy(\App\Models\Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->delete();
        return redirect()->route('pemeriksaans.index')->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
}
