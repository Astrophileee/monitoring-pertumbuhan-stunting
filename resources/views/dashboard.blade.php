@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ═══════════════════ HEADER ═══════════════════ --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h2 class="text-2xl font-bold text-gray-100">Dashboard</h2>
        <p class="text-gray-400 text-sm mt-0.5">Ringkasan data sistem monitoring balita · <span class="text-emerald-400">{{ now()->translatedFormat('l, d F Y') }}</span></p>
    </div>
    <div class="flex items-center gap-2 bg-gray-900 border border-gray-800 rounded-xl px-4 py-2.5">
        <i class="fas fa-user-circle text-emerald-400 text-sm"></i>
        <span class="text-sm text-gray-300 font-medium">{{ Auth::user()->name }}</span>
        <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/15 border border-emerald-500/25 text-emerald-400">{{ Auth::user()->roles->first()->name ?? 'Pengguna' }}</span>
    </div>
</div>

{{-- ═══════════════════ STATS CARDS ROW 1 ═══════════════════ --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">

    {{-- Total Balita --}}
    <div class="col-span-2 md:col-span-1 lg:col-span-1 bg-gray-900 border border-gray-800 rounded-2xl p-5 flex flex-col gap-3 hover:border-emerald-500/40 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Balita</p>
            <div class="w-8 h-8 rounded-lg bg-emerald-500/15 border border-emerald-500/20 flex items-center justify-center group-hover:bg-emerald-500/25 transition-colors">
                <i class="fas fa-baby text-sm text-emerald-400"></i>
            </div>
        </div>
        <div>
            <h3 class="text-3xl font-bold text-white">{{ $totalBalita }}</h3>
            <p class="text-xs text-gray-500 mt-1">Terdaftar di sistem</p>
        </div>
        <div class="flex gap-2 text-xs text-gray-500">
            <span><i class="fas fa-mars text-blue-400 mr-1"></i>{{ $balitaLaki }} L</span>
            <span><i class="fas fa-venus text-pink-400 mr-1"></i>{{ $balitaPerempuan }} P</span>
        </div>
    </div>

    {{-- Total Orang Tua --}}
    <div class="col-span-2 md:col-span-1 lg:col-span-1 bg-gray-900 border border-gray-800 rounded-2xl p-5 flex flex-col gap-3 hover:border-blue-500/40 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Orang Tua</p>
            <div class="w-8 h-8 rounded-lg bg-blue-500/15 border border-blue-500/20 flex items-center justify-center group-hover:bg-blue-500/25 transition-colors">
                <i class="fas fa-users text-sm text-blue-400"></i>
            </div>
        </div>
        <div>
            <h3 class="text-3xl font-bold text-white">{{ $totalOrangTua }}</h3>
            <p class="text-xs text-gray-500 mt-1">Keluarga terdaftar</p>
        </div>
        <div class="h-1 w-full bg-gray-800 rounded-full overflow-hidden">
            @php $ratioOT = $totalOrangTua > 0 ? min(100, ($totalOrangTua / max($totalBalita, 1)) * 100) : 0; @endphp
            <div class="h-1 bg-blue-500 rounded-full" style="width: {{ $ratioOT }}%"></div>
        </div>
    </div>

    {{-- Total Pemeriksaan --}}
    <div class="col-span-2 md:col-span-1 lg:col-span-1 bg-gray-900 border border-gray-800 rounded-2xl p-5 flex flex-col gap-3 hover:border-purple-500/40 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Pemeriksaan</p>
            <div class="w-8 h-8 rounded-lg bg-purple-500/15 border border-purple-500/20 flex items-center justify-center group-hover:bg-purple-500/25 transition-colors">
                <i class="fas fa-notes-medical text-sm text-purple-400"></i>
            </div>
        </div>
        <div>
            <h3 class="text-3xl font-bold text-white">{{ $totalPemeriksaan }}</h3>
            <p class="text-xs text-gray-500 mt-1">Total seluruh waktu</p>
        </div>
        <div class="flex items-center gap-1 text-xs text-purple-400">
            <i class="fas fa-calendar-check"></i>
            <span>{{ $pemeriksaanBulanIni }} bulan ini</span>
        </div>
    </div>

    {{-- Status Normal --}}
    <div class="col-span-1 lg:col-span-1 bg-gray-900 border border-gray-800 rounded-2xl p-5 flex flex-col gap-3 hover:border-teal-500/40 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Normal</p>
            <div class="w-8 h-8 rounded-lg bg-teal-500/15 border border-teal-500/20 flex items-center justify-center group-hover:bg-teal-500/25 transition-colors">
                <i class="fas fa-check-circle text-sm text-teal-400"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-white">{{ $normal }}</h3>
        <p class="text-xs text-gray-500">Status tumbuh normal</p>
    </div>

    {{-- Stunting --}}
    <div class="col-span-1 lg:col-span-1 bg-gray-900 border border-red-900/40 rounded-2xl p-5 flex flex-col gap-3 hover:border-red-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Stunting</p>
            <div class="w-8 h-8 rounded-lg bg-red-500/15 border border-red-500/20 flex items-center justify-center group-hover:bg-red-500/25 transition-colors">
                <i class="fas fa-triangle-exclamation text-sm text-red-400"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-red-400">{{ $stunting }}</h3>
        <div class="flex items-center gap-1 text-xs text-red-400">
            <i class="fas fa-percent text-xs"></i>
            <span>{{ $persenStunting }}% dari pemeriksaan</span>
        </div>
    </div>

    {{-- Gizi Buruk --}}
    <div class="col-span-1 lg:col-span-1 bg-gray-900 border border-gray-800 rounded-2xl p-5 flex flex-col gap-3 hover:border-orange-500/40 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Gizi Buruk</p>
            <div class="w-8 h-8 rounded-lg bg-orange-500/15 border border-orange-500/20 flex items-center justify-center group-hover:bg-orange-500/25 transition-colors">
                <i class="fas fa-circle-xmark text-sm text-orange-400"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-orange-400">{{ $gizi_buruk }}</h3>
        <p class="text-xs text-gray-500">Perlu penanganan</p>
    </div>

</div>

{{-- ═══════════════════ CHARTS & TABLE ROW ═══════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Chart: Tren Pemeriksaan 6 Bulan --}}
    <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h4 class="text-base font-semibold text-gray-100">Tren Pemeriksaan</h4>
                <p class="text-xs text-gray-500 mt-0.5">6 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-500 bg-gray-800 rounded-lg px-3 py-1.5 border border-gray-700">
                <i class="fas fa-chart-line text-emerald-400"></i>
                <span>Bulanan</span>
            </div>
        </div>
        <div class="relative h-52">
            <canvas id="trenChart"></canvas>
        </div>
    </div>

    {{-- Chart: Distribusi Status Pertumbuhan --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <div class="mb-5">
            <h4 class="text-base font-semibold text-gray-100">Status Pertumbuhan</h4>
            <p class="text-xs text-gray-500 mt-0.5">Distribusi hasil pemeriksaan</p>
        </div>
        <div class="relative h-36 flex items-center justify-center">
            <canvas id="statusChart"></canvas>
        </div>
        {{-- Legend --}}
        <div class="mt-4 space-y-2">
            <div class="flex items-center justify-between text-xs">
                <span class="flex items-center gap-2 text-gray-400"><span class="w-2.5 h-2.5 rounded-full bg-teal-400 flex-shrink-0"></span>Normal</span>
                <span class="text-gray-200 font-semibold">{{ $normal }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="flex items-center gap-2 text-gray-400"><span class="w-2.5 h-2.5 rounded-full bg-red-400 flex-shrink-0"></span>Stunting</span>
                <span class="text-gray-200 font-semibold">{{ $stunting }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="flex items-center gap-2 text-gray-400"><span class="w-2.5 h-2.5 rounded-full bg-orange-400 flex-shrink-0"></span>Gizi Buruk</span>
                <span class="text-gray-200 font-semibold">{{ $gizi_buruk }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="flex items-center gap-2 text-gray-400"><span class="w-2.5 h-2.5 rounded-full bg-amber-400 flex-shrink-0"></span>Gizi Lebih</span>
                <span class="text-gray-200 font-semibold">{{ $gizi_lebih }}</span>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════════════ BOTTOM ROW ═══════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Pemeriksaan Terbaru --}}
    <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h4 class="text-base font-semibold text-gray-100">Pemeriksaan Terbaru</h4>
                <p class="text-xs text-gray-500 mt-0.5">5 data pemeriksaan terakhir</p>
            </div>
            @role('Kader Posyandu')
            <a href="{{ route('pemeriksaans.index') }}" class="text-xs text-emerald-400 hover:text-emerald-300 flex items-center gap-1 transition-colors">
                Lihat semua <i class="fas fa-arrow-right text-xs"></i>
            </a>
            @endrole
        </div>

        @if($pemeriksaanTerbaru->isEmpty())
            <div class="flex flex-col items-center justify-center py-10 text-gray-600">
                <i class="fas fa-notes-medical text-3xl mb-3"></i>
                <p class="text-sm">Belum ada data pemeriksaan</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-gray-500 uppercase tracking-wider border-b border-gray-800">
                            <th class="pb-3 text-left font-medium">Nama Balita</th>
                            <th class="pb-3 text-left font-medium">Tanggal</th>
                            <th class="pb-3 text-right font-medium">BB/TB</th>
                            <th class="pb-3 text-right font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($pemeriksaanTerbaru as $p)
                        <tr class="hover:bg-gray-800/50 transition-colors">
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg {{ $p->balita?->jenis_kelamin === 'L' ? 'bg-blue-500/15 text-blue-400' : 'bg-pink-500/15 text-pink-400' }} flex items-center justify-center flex-shrink-0">
                                        <i class="fas {{ $p->balita?->jenis_kelamin === 'L' ? 'fa-mars' : 'fa-venus' }} text-xs"></i>
                                    </div>
                                    <span class="text-gray-200 font-medium truncate max-w-[110px]">{{ $p->balita?->nama ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-gray-400">{{ \Carbon\Carbon::parse($p->tanggal_pemeriksaan)->format('d M Y') }}</td>
                            <td class="py-3 text-right text-gray-300">
                                <span class="text-white font-semibold">{{ $p->berat_badan }}</span>kg /
                                <span class="text-white font-semibold">{{ $p->tinggi_badan }}</span>cm
                            </td>
                            <td class="py-3 text-right">
                                @php
                                    $badgeClass = match($p->status_pertumbuhan) {
                                        'Normal'     => 'bg-teal-500/15 text-teal-400 border-teal-500/25',
                                        'Stunting'   => 'bg-red-500/15 text-red-400 border-red-500/25',
                                        'Gizi Buruk' => 'bg-orange-500/15 text-orange-400 border-orange-500/25',
                                        'Gizi Lebih' => 'bg-amber-500/15 text-amber-400 border-amber-500/25',
                                        default      => 'bg-gray-700/50 text-gray-400 border-gray-600/25',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border {{ $badgeClass }}">
                                    {{ $p->status_pertumbuhan ?? 'Belum ada' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Info & Quick Actions --}}
    <div class="flex flex-col gap-4">

        {{-- Gender Donut --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5">
            <h4 class="text-sm font-semibold text-gray-100 mb-4">Balita per Gender</h4>
            <div class="flex items-center gap-4">
                <div class="relative w-20 h-20 flex-shrink-0">
                    <canvas id="genderChart" width="80" height="80"></canvas>
                </div>
                <div class="flex flex-col gap-2 flex-1">
                    <div class="flex items-center justify-between text-xs">
                        <span class="flex items-center gap-2 text-gray-400"><span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span>Laki-laki</span>
                        <span class="font-semibold text-gray-200">{{ $balitaLaki }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="flex items-center gap-2 text-gray-400"><span class="w-2.5 h-2.5 rounded-full bg-pink-400"></span>Perempuan</span>
                        <span class="font-semibold text-gray-200">{{ $balitaPerempuan }}</span>
                    </div>
                    @if($totalBalita > 0)
                    <div class="mt-1">
                        <div class="h-1.5 w-full bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-1.5 bg-gradient-to-r from-blue-500 to-pink-400 rounded-full"
                                 style="width: {{ $totalBalita > 0 ? round(($balitaLaki / $totalBalita) * 100) : 50 }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-600 mt-1">
                            <span>{{ $totalBalita > 0 ? round(($balitaLaki / $totalBalita) * 100) : 0 }}%</span>
                            <span>{{ $totalBalita > 0 ? round(($balitaPerempuan / $totalBalita) * 100) : 0 }}%</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 flex-1">
            <h4 class="text-sm font-semibold text-gray-100 mb-4">Aksi Cepat</h4>
            <div class="flex flex-col gap-2">
                @role('Kader Posyandu')
                <a href="{{ route('pemeriksaans.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-600/10 border border-emerald-600/20 text-emerald-400 hover:bg-emerald-600/20 transition-all text-sm group">
                    <i class="fas fa-plus-circle w-4 text-center group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Tambah Pemeriksaan</span>
                </a>
                <a href="{{ route('balitas.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-blue-600/10 border border-blue-600/20 text-blue-400 hover:bg-blue-600/20 transition-all text-sm group">
                    <i class="fas fa-baby w-4 text-center group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Daftarkan Balita</span>
                </a>
                <a href="{{ route('orang_tuas.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-purple-600/10 border border-purple-600/20 text-purple-400 hover:bg-purple-600/20 transition-all text-sm group">
                    <i class="fas fa-user-plus w-4 text-center group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Tambah Orang Tua</span>
                </a>
                @endrole

                @role('Pimpinan Pustu')
                <a href="{{ route('laporans.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-600/10 border border-emerald-600/20 text-emerald-400 hover:bg-emerald-600/20 transition-all text-sm group">
                    <i class="fas fa-chart-pie w-4 text-center group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Lihat Laporan</span>
                </a>
                <a href="{{ route('laporans.cetak') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-blue-600/10 border border-blue-600/20 text-blue-400 hover:bg-blue-600/20 transition-all text-sm group">
                    <i class="fas fa-print w-4 text-center group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Cetak Laporan</span>
                </a>
                @endrole
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.color = '#9ca3af';
Chart.defaults.borderColor = '#1f2937';
Chart.defaults.font.family = "'Inter', sans-serif";

// ──── Tren Pemeriksaan Chart ────
const trenCtx = document.getElementById('trenChart');
if (trenCtx) {
    const chartData = @json($chartData);
    new Chart(trenCtx, {
        type: 'line',
        data: {
            labels: chartData.map(d => d.label),
            datasets: [{
                label: 'Pemeriksaan',
                data: chartData.map(d => d.total),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#064e3b',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#111827',
                    borderColor: '#374151',
                    borderWidth: 1,
                    padding: 10,
                    titleColor: '#e5e7eb',
                    bodyColor: '#10b981',
                    callbacks: {
                        label: ctx => ` ${ctx.raw} pemeriksaan`
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(55,65,81,0.5)' },
                    ticks: { color: '#6b7280', font: { size: 11 } }
                },
                y: {
                    grid: { color: 'rgba(55,65,81,0.5)' },
                    ticks: { color: '#6b7280', font: { size: 11 }, stepSize: 1, precision: 0 },
                    beginAtZero: true,
                }
            }
        }
    });
}

// ──── Status Pertumbuhan Doughnut ────
const statusCtx = document.getElementById('statusChart');
if (statusCtx) {
    const normal    = {{ $normal }};
    const stunting  = {{ $stunting }};
    const giziBuruk = {{ $gizi_buruk }};
    const giziLebih = {{ $gizi_lebih }};
    const hasData   = (normal + stunting + giziBuruk + giziLebih) > 0;

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Normal', 'Stunting', 'Gizi Buruk', 'Gizi Lebih'],
            datasets: [{
                data: hasData ? [normal, stunting, giziBuruk, giziLebih] : [1],
                backgroundColor: hasData
                    ? ['#2dd4bf', '#f87171', '#fb923c', '#fbbf24']
                    : ['#1f2937'],
                borderColor: '#111827',
                borderWidth: 3,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: hasData,
                    backgroundColor: '#111827',
                    borderColor: '#374151',
                    borderWidth: 1,
                    padding: 10,
                    titleColor: '#e5e7eb',
                    bodyColor: '#d1d5db',
                }
            }
        }
    });
}

// ──── Gender Doughnut ────
const genderCtx = document.getElementById('genderChart');
if (genderCtx) {
    const laki      = {{ $balitaLaki }};
    const perempuan = {{ $balitaPerempuan }};
    const hasData   = (laki + perempuan) > 0;

    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: hasData ? [laki, perempuan] : [1],
                backgroundColor: hasData ? ['#60a5fa', '#f472b6'] : ['#1f2937'],
                borderColor: '#111827',
                borderWidth: 3,
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: hasData,
                    backgroundColor: '#111827',
                    borderColor: '#374151',
                    borderWidth: 1,
                    padding: 8,
                }
            },
            cutout: '65%',
        }
    });
}
</script>
@endpush
