<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian | PosyanduCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-950 font-sans antialiased text-gray-200 min-h-screen flex flex-col">

    <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-105 transition-transform">
                    <i class="fas fa-arrow-left text-white text-xs"></i>
                </div>
                <span class="font-bold text-white tracking-tight">Kembali</span>
            </a>
            <div class="font-bold text-white tracking-tight text-lg">Posyandu<span class="text-emerald-400">Care</span></div>
        </div>
    </nav>

    <main class="flex-1 py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-white mb-6">Hasil Monitoring Balita</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Info Balita -->
                <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden col-span-1 h-fit">
                    <div class="p-6 border-b border-gray-800 bg-gray-800/30">
                        <h3 class="text-lg font-bold text-gray-100 flex items-center gap-2">
                            <i class="fas fa-id-card text-emerald-400"></i> Informasi Balita
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
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
                    </div>
                </div>

                <!-- Riwayat Pemeriksaan -->
                <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden col-span-1 lg:col-span-2">
                    <div class="p-6 border-b border-gray-800 bg-gray-800/30">
                        <h3 class="text-lg font-bold text-gray-100 flex items-center gap-2">
                            <i class="fas fa-chart-line text-emerald-400"></i> Riwayat Pemeriksaan
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($balita->pemeriksaans->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-gray-400">
                                    <thead class="text-xs text-gray-300 uppercase bg-gray-800/50">
                                        <tr>
                                            <th class="px-4 py-3">Tanggal</th>
                                            <th class="px-4 py-3">Umur</th>
                                            <th class="px-4 py-3">BB</th>
                                            <th class="px-4 py-3">TB</th>
                                            <th class="px-4 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @foreach($balita->pemeriksaans as $pemeriksaan)
                                        <tr class="hover:bg-gray-800/20">
                                            <td class="px-4 py-3 text-gray-200">{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d M Y') }}</td>
                                            <td class="px-4 py-3">{{ $pemeriksaan->umur_bulan }} bln</td>
                                            <td class="px-4 py-3">{{ $pemeriksaan->berat_badan }} kg</td>
                                            <td class="px-4 py-3">{{ $pemeriksaan->tinggi_badan }} cm</td>
                                            <td class="px-4 py-3">
                                                @if($pemeriksaan->status_pertumbuhan)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/30">{{ $pemeriksaan->status_pertumbuhan }}</span>
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
        </div>
    </main>

    <footer class="border-t border-gray-800 bg-gray-900 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} PosyanduCare. Sistem Monitoring Balita Terpadu.
        </div>
    </footer>
</body>
</html>
