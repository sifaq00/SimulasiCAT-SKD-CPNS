<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Simulasi CPNS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="antialiased bg-slate-900">
        @if (request()->routeIs('register', 'login', 'forgot-password', 'reset-password'))
            {{-- Include Navbar --}}
            @include('livewire.layout.navbar')

            <div class="min-h-screen pt-16">
                {{ $slot }}
            </div>

            {{-- Include Footer --}}
            @include('livewire.layout.footer')
        @else
            <div class="">
                {{-- Include Navbar --}}
                @include('livewire.layout.navbar')
            </div>
                <div class="">
                    {{ $slot }}
                </div>
            </div>
            {{-- Include Footer --}}
            @include('livewire.layout.footer')
            
        @endif
    </body>
</html>
