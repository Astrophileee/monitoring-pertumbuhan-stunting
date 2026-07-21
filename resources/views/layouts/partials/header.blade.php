<header class="bg-gray-900 border-b border-gray-800 px-6 py-4 flex items-center justify-between flex-shrink-0">

    {{-- Left: Hamburger + Page Title --}}
    <div class="flex items-center gap-4">
        {{-- Hamburger (mobile) --}}
        <button onclick="toggleSidebar()"
                class="p-2 rounded-lg text-gray-400 hover:text-gray-200 hover:bg-gray-800 transition-colors duration-200 lg:hidden"
                aria-label="Toggle sidebar">
            <i class="fas fa-bars text-lg"></i>
        </button>

        {{-- Page Title --}}
        <div>
            <h1 class="text-base font-semibold text-gray-100">@yield('title', 'Dashboard')</h1>
            <p class="text-xs text-gray-500 mt-0.5">Sistem Monitoring Balita</p>
        </div>
    </div>

    {{-- Right: User Dropdown --}}
    <div class="relative" id="user-dropdown-wrapper">
        <button onclick="toggleDropdown()"
                class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-800 transition-colors duration-200 focus:outline-none group"
                aria-label="User menu">
            {{-- Avatar --}}
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center flex-shrink-0">
                <span class="text-white font-semibold text-xs">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <div class="hidden sm:block text-left">
                <p class="text-sm font-medium text-gray-200 leading-none">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 mt-0.5 truncate max-w-32">{{ Auth::user()->email }}</p>
            </div>
            <i class="fas fa-chevron-down text-xs text-gray-500 group-hover:text-gray-300 transition-colors hidden sm:block"></i>
        </button>

        {{-- Dropdown Panel --}}
        <div id="dropdownMenu"
             class="absolute right-0 top-full mt-2 w-64 bg-gray-900 border border-gray-700 rounded-2xl shadow-2xl shadow-black/50 hidden z-50 overflow-hidden">

            {{-- User Info --}}
            <div class="flex items-center gap-3 px-4 py-4 border-b border-gray-800 bg-gray-800/50">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-sm text-gray-100 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="p-2">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-300 hover:bg-gray-800 rounded-xl transition-colors duration-150">
                    <i class="fas fa-user-pen w-4 text-gray-500"></i>
                    Edit Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-400 hover:bg-red-500/10 rounded-xl transition-colors duration-150">
                        <i class="fas fa-arrow-right-from-bracket w-4"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleDropdown() {
        document.getElementById('dropdownMenu').classList.toggle('hidden');
    }

    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('user-dropdown-wrapper');
        const menu = document.getElementById('dropdownMenu');
        if (wrapper && menu && !wrapper.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>
