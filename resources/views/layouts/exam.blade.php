<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Simulasi CPNS') }} - Ujian</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Anti-screenshot styles */
        .exam-container {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 4rem;
            color: rgba(0, 0, 0, 0.03);
            pointer-events: none;
            z-index: 1000;
            white-space: nowrap;
        }

        /* Blur overlay when tab is not active */
        .blur-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .blur-overlay.active {
            display: flex;
        }
    </style>
</head>
<body class="h-full bg-gray-50 exam-container" oncontextmenu="return false;">
    <!-- User Watermark - DISABLED FOR DEVELOPMENT -->
    <!--
    <div class="watermark">
        {{ auth()->user()->name ?? 'User' }} - {{ auth()->id() ?? '0' }}
    </div>
    -->

    <!-- Blur Overlay for Tab Switch -->
    <div id="blur-overlay" class="blur-overlay">
        <svg class="w-24 h-24 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Peringatan!</h2>
        <p class="text-gray-600 text-center max-w-md">
            Anda terdeteksi membuka tab atau aplikasi lain.<br>
            Kembali ke halaman ini untuk melanjutkan ujian.
        </p>
    </div>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Anti-Cheat Scripts - DISABLED FOR DEVELOPMENT -->
    <!--
    <script>
        // Disabled for development - enable in production
    </script>
    -->

    @livewireScripts
</body>
</html>
