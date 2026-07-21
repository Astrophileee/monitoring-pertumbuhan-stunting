@extends('layouts.app')

@section('title', 'Laporan Analisis')

@section('content')
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-xl">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-100">Laporan Analisis Pertumbuhan</h2>
            <p class="text-sm text-gray-500">Rekapitulasi data monitoring balita di posyandu</p>
        </div>
        <a href="{{ route('laporans.cetak') }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-sm font-medium transition-colors">
            <i class="fas fa-print mr-2"></i>Cetak PDF
        </a>
    </div>

    <div class="overflow-x-auto">
        <table id="dataTable" class="w-full text-left text-sm text-gray-400">
            <thead class="text-xs text-gray-300 uppercase bg-gray-800/50 border-b border-gray-700">
                <tr>
                    <th class="px-4 py-3 rounded-tl-lg">Tanggal</th>
                    <th class="px-4 py-3">Nama Balita</th>
                    <th class="px-4 py-3">Umur</th>
                    <th class="px-4 py-3">BB (kg) / TB (cm)</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 rounded-tr-lg">Kader</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($pemeriksaans as $item)
                <tr class="hover:bg-gray-800/20 transition-colors">
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-200">{{ $item->balita->nama }}</div>
                        <div class="text-xs text-gray-500">{{ $item->balita->nik }}</div>
                    </td>
                    <td class="px-4 py-3">{{ $item->umur_bulan }} bulan</td>
                    <td class="px-4 py-3">{{ $item->berat_badan }} / {{ $item->tinggi_badan }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($item->status_pertumbuhan)
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $item->status_pertumbuhan == 'normal' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : '' }}
                                {{ in_array($item->status_pertumbuhan, ['gizi kurang', 'gizi buruk']) ? 'bg-red-500/10 text-red-400 border border-red-500/20' : '' }}
                                {{ $item->status_pertumbuhan == 'gizi lebih' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : '' }}
                            ">
                                {{ strtoupper($item->status_pertumbuhan) }}
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-500/10 text-gray-400 border border-gray-500/30">Menunggu</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $item->user->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": { "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            "order": [[ 0, "desc" ]]
        });
        $('.dataTables_length select').addClass('bg-gray-800 border-gray-700 text-gray-200 rounded-lg text-sm ml-2');
        $('.dataTables_filter input').addClass('bg-gray-800 border-gray-700 text-gray-200 rounded-lg text-sm ml-2');
    });
</script>
<style>
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { color: #9ca3af; margin: 1rem 0; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { color: #9ca3af !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #059669; color: white !important; border: none; border-radius: 0.5rem; }
</style>
@endpush
