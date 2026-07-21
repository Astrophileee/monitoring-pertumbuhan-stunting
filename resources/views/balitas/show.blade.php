@extends('layouts.app')

@section('title', 'Detail Balita')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Info Balita -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden col-span-1 h-fit">
        <div class="p-6 border-b border-gray-800">
            <h3 class="text-lg font-bold text-gray-100">Informasi Balita</h3>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">NIK</p>
                <p class="font-medium text-gray-200 mt-1">{{ $balita->nik }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Nama Lengkap</p>
                <p class="font-medium text-gray-200 mt-1">{{ $balita->nama }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Tanggal Lahir</p>
                <p class="font-medium text-gray-200 mt-1">{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Jenis Kelamin</p>
                <p class="font-medium text-gray-200 mt-1">{{ $balita->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
            </div>
            <hr class="border-gray-800">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Nama Ibu</p>
                <p class="font-medium text-gray-200 mt-1">{{ $balita->orangTua->nama_ibu }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">No HP (WA)</p>
                <p class="font-medium text-gray-200 mt-1">{{ $balita->orangTua->no_hp ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Riwayat Pemeriksaan -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden col-span-1 lg:col-span-2">
        <div class="p-6 border-b border-gray-800 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-100">Riwayat Pemeriksaan</h3>
        </div>
        <div class="p-6">
            @if($balita->pemeriksaans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-400">
                        <thead class="text-xs text-gray-300 uppercase bg-gray-800/50">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Umur</th>
                                <th class="px-4 py-3">BB (kg)</th>
                                <th class="px-4 py-3">TB (cm)</th>
                                <th class="px-4 py-3">LILA (cm)</th>
                                <th class="px-4 py-3 text-center">Status Gizi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($balita->pemeriksaans as $pemeriksaan)
                            <tr class="hover:bg-gray-800/20">
                                <td class="px-4 py-3 text-gray-200">{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d M Y') }}</td>
                                <td class="px-4 py-3">{{ $pemeriksaan->umur_bulan }} bln</td>
                                <td class="px-4 py-3">{{ $pemeriksaan->berat_badan }}</td>
                                <td class="px-4 py-3">{{ $pemeriksaan->tinggi_badan }}</td>
                                <td class="px-4 py-3">{{ $pemeriksaan->lila ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($pemeriksaan->status_pertumbuhan)
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $pemeriksaan->status_pertumbuhan == 'normal' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : '' }}
                                            {{ in_array($pemeriksaan->status_pertumbuhan, ['gizi kurang', 'gizi buruk']) ? 'bg-red-500/10 text-red-400 border border-red-500/30' : '' }}
                                            {{ $pemeriksaan->status_pertumbuhan == 'gizi lebih' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/30' : '' }}
                                        ">{{ strtoupper($pemeriksaan->status_pertumbuhan) }}</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-500/10 text-gray-400 border border-gray-500/30">Menunggu Analisis</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-clipboard-list text-4xl text-gray-600 mb-4"></i>
                    <p class="text-gray-400">Belum ada riwayat pemeriksaan untuk balita ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
