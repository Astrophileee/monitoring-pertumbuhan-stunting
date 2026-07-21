<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Monitoring Balita | PosyanduCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-950 font-sans antialiased text-gray-200">

    <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <i class="fas fa-baby text-white text-xs"></i>
                </div>
                <span class="font-bold text-white tracking-tight">Posyandu<span class="text-emerald-400">Care</span></span>
            </div>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-emerald-400 hover:text-emerald-300">Ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-sm font-medium transition-colors">Login Kader</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center py-16 lg:py-24">
                <h1 class="text-4xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-500 tracking-tight mb-6">
                    Pantau Tumbuh Kembang<br>Buah Hati Anda
                </h1>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-10">
                    Sistem informasi Posyandu terpadu untuk memonitor pertumbuhan balita secara digital dan cerdas. Masukkan NIK balita Anda untuk melihat hasil pemeriksaan.
                </p>

                <div class="max-w-xl mx-auto bg-gray-900 p-6 rounded-2xl border border-gray-800 shadow-2xl shadow-emerald-900/20">
                    <form action="{{ route('cari.balita') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                        @csrf
                        <div class="flex-1 relative">
                            <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                            <input type="text" name="nik" placeholder="Masukkan NIK Balita..." required
                                   class="w-full pl-11 pr-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                        </div>
                        <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-xl transition-colors shadow-lg shadow-emerald-500/30 flex justify-center items-center gap-2">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </form>
                    @if(session('error'))
                        <p class="text-red-400 text-sm mt-3 text-left"><i class="fas fa-exclamation-circle mr-1"></i>{{ session('error') }}</p>
                    @endif
                </div>
            </div>

            <!-- Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                <div class="bg-gray-900/50 p-6 rounded-2xl border border-gray-800 text-center">
                    <div class="w-12 h-12 rounded-full bg-blue-500/10 text-blue-400 mx-auto flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-200 mb-2">Riwayat Terpantau</h3>
                    <p class="text-sm text-gray-400">Seluruh data pemeriksaan dari berat badan, tinggi, hingga LILA tersimpan dengan aman.</p>
                </div>
                <div class="bg-gray-900/50 p-6 rounded-2xl border border-gray-800 text-center">
                    <div class="w-12 h-12 rounded-full bg-purple-500/10 text-purple-400 mx-auto flex items-center justify-center mb-4">
                        <i class="fas fa-brain text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-200 mb-2">Analisis Cerdas</h3>
                    <p class="text-sm text-gray-400">Didukung oleh algoritma Machine Learning (Random Forest) untuk deteksi dini stunting.</p>
                </div>
                <div class="bg-gray-900/50 p-6 rounded-2xl border border-gray-800 text-center">
                    <div class="w-12 h-12 rounded-full bg-rose-500/10 text-rose-400 mx-auto flex items-center justify-center mb-4">
                        <i class="fas fa-mobile-screen text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-200 mb-2">Akses Mudah</h3>
                    <p class="text-sm text-gray-400">Orang tua dapat memantau perkembangan anak kapan saja dan di mana saja tanpa perlu login.</p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
