{{-- Mobile overlay --}}
<div id="overlay" onclick="closeSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 hidden lg:hidden"></div>

{{-- ═══════════════════════ SIDEBAR ═══════════════════════ --}}
<aside id="sidebar" class="fixed z-40 top-0 left-0 h-full w-64 bg-gray-900 border-r border-gray-800 flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:z-auto lg:flex-shrink-0">

    {{-- Logo / Brand --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-800">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/30">
            <i class="fas fa-baby text-white text-sm"></i>
        </div>
        <div>
            <span class="font-bold text-white text-base tracking-tight">Posyandu</span><span class="text-emerald-400 font-bold text-base">Care</span>
            <p class="text-gray-500 text-xs mt-0.5">Sistem Monitoring Balita</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">

        @php
            $navItems = [
                ['route' => 'dashboard', 'pattern' => 'dashboard', 'icon' => 'fa-gauge', 'label' => 'Dashboard', 'role' => 'any'],
            ];

            if(Auth::user()->hasRole('Kader Posyandu')) {
                $navItems = array_merge($navItems, [
                    ['route' => 'users.index', 'pattern' => 'users.*', 'icon' => 'fa-user-shield', 'label' => 'Kelola User', 'role' => 'Kader Posyandu'],
                    ['route' => 'orang_tuas.index', 'pattern' => 'orang_tuas.*', 'icon' => 'fa-users', 'label' => 'Data Orang Tua', 'role' => 'Kader Posyandu'],
                    ['route' => 'balitas.index', 'pattern' => 'balitas.*', 'icon' => 'fa-child', 'label' => 'Data Balita', 'role' => 'Kader Posyandu'],
                    ['route' => 'pemeriksaans.index', 'pattern' => 'pemeriksaans.*', 'icon' => 'fa-stethoscope', 'label' => 'Data Pemeriksaan', 'role' => 'Kader Posyandu'],
                ]);
            }

            if(Auth::user()->hasRole('Pimpinan Pustu')) {
                $navItems = array_merge($navItems, [
                    ['route' => 'laporans.index', 'pattern' => 'laporans.*', 'icon' => 'fa-chart-pie', 'label' => 'Laporan Analisis', 'role' => 'Pimpinan Pustu'],
                ]);
            }
        @endphp

        @foreach($navItems as $item)
            @php $active = request()->routeIs($item['pattern']); @endphp
            <a href="{{ route($item['route']) }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                      {{ $active
                            ? 'bg-emerald-600/20 text-emerald-300 border border-emerald-500/30 shadow-sm'
                            : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200 border border-transparent' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors duration-200
                             {{ $active ? 'bg-emerald-500/30 text-emerald-300' : 'bg-gray-800 text-gray-500 group-hover:bg-gray-700 group-hover:text-gray-300' }}">
                    <i class="fas {{ $item['icon'] }} text-sm"></i>
                </span>
                <span class="truncate">{{ $item['label'] }}</span>
                @if($active)
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>
                @endif
            </a>
        @endforeach

    </nav>

    {{-- User info at bottom --}}
    <div class="border-t border-gray-800 px-4 py-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center flex-shrink-0">
                <span class="text-white font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-gray-200 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.add('-translate-x-full');
        document.getElementById('overlay').classList.add('hidden');
    }
</script>
