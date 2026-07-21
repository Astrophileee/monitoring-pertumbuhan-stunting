<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Monitoring Balita Posyandu">
    <title>@yield('title', 'Dashboard') | PosyanduCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-950 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- ═══════════════════════════════════════ SIDEBAR ═══════════════════════════════════════ --}}
        @include('layouts.partials.sidebar')

        {{-- ═══════════════════════════════════════ MAIN AREA ═══════════════════════════════════════ --}}
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            {{-- HEADER --}}
            @include('layouts.partials.header')

            {{-- FLASH MESSAGES FOR SWEETALERT --}}
            @if(session('success'))
                <div id="flash-message" data-type="success" data-message="{{ session('success') }}" class="hidden"></div>
            @endif

            @if(session('error'))
                <div id="flash-message" data-type="error" data-message="{{ session('error') }}" class="hidden"></div>
            @endif

            {{-- CONTENT --}}
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

        </div>
    </div>

    @stack('scripts')


</body>
</html>
