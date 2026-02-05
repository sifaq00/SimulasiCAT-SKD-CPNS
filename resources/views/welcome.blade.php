<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Simulasi CPNS') }} - Latihan SKD CPNS Online</title>
    <meta name="description" content="Platform simulasi tes SKD CPNS terlengkap. Latihan soal TWK, TIU, TKP dengan pembahasan lengkap.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
        }
    </style>
</head>
<body class="antialiased">
    {{-- Navigation --}}
    <nav class="fixed top-0 left-0 right-0 z-50 border-b bg-slate-900/80 backdrop-blur-lg border-slate-800">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/logo.png') }}" alt="Simulasi CPNS" class="w-10 h-10">
                    <span class="text-xl font-bold text-white">Simulasi CPNS</span>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="transition text-slate-300 hover:text-white">Dashboard</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="transition text-slate-300 hover:text-white">Admin</a>
                        @endif
                    @else
                        {{-- Mobile View --}}
                        <a href="{{ route('login') }}" class="px-6 py-2 font-semibold text-white transition rounded-lg shadow-lg md:hidden bg-gradient-to-r from-blue-600 to-purple-600 hover:opacity-90">
                            Masuk
                        </a>

                        {{-- Desktop View --}}
                        <div class="items-center hidden gap-3 md:flex">
                            <a href="{{ route('login') }}" class="font-medium transition text-slate-300 hover:text-white">Masuk</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 font-medium text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                                Daftar Gratis
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative flex items-center min-h-screen overflow-hidden hero-gradient">
        {{-- Background blobs --}}
        <div class="bg-blue-600 blob w-96 h-96 -top-20 -left-20"></div>
        <div class="right-0 bg-purple-600 blob w-80 h-80 top-1/2"></div>
        <div class="w-64 h-64 blob bg-cyan-500 bottom-20 left-1/3"></div>

        <div class="relative z-10 px-4 py-20 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 mb-6 border rounded-full bg-blue-500/10 border-blue-500/20">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-sm font-medium text-blue-400">Update soal terbaru 2025</span>
                    </div>

                    <h1 class="mb-6 text-4xl font-extrabold leading-tight text-white md:text-5xl lg:text-6xl">
                        Raih Skor <span class="gradient-text">Tertinggi</span> di Tes SKD CPNS
                    </h1>

                    <p class="mb-8 text-xl leading-relaxed text-slate-400">
                        Latihan soal SKD CPNS dengan sistem seperti CAT BKN.
                        Tersedia ribuan soal TWK, TIU, dan TKP dengan pembahasan lengkap.
                    </p>

                    <div class="flex flex-wrap gap-4 mb-10">
                        <a href="{{ route('register') }}" class="flex items-center gap-2 px-8 py-4 text-lg font-semibold text-white transition bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl hover:opacity-90">
                            Mulai Latihan
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('packages') }}" class="px-8 py-4 text-lg font-semibold text-white transition border bg-white/10 rounded-xl hover:bg-white/20 border-white/20">
                            Lihat Paket
                        </a>
                    </div>

                    <div class="flex items-center gap-8 text-slate-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>110 soal/paket</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Timer realistis</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Pembahasan</span>
                        </div>
                    </div>
                </div>

                {{-- Hero Image/Stats Card --}}
                <div class="relative">
                    <div class="p-8 border bg-slate-800/50 backdrop-blur-xl rounded-3xl border-slate-700/50">
                        <div class="mb-6 text-center">
                            <h3 class="mb-2 text-xl font-semibold text-white">Passing Grade SKD CPNS</h3>
                            <p class="text-sm text-slate-400">Minimal skor per kategori</p>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-slate-700/50 rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-slate-300">TWK (Wawasan Kebangsaan)</span>
                                    <span class="font-bold text-blue-400">65/150</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-slate-600">
                                    <div class="h-full bg-blue-500 rounded-full" style="width: 43%"></div>
                                </div>
                            </div>

                            <div class="p-4 bg-slate-700/50 rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-slate-300">TIU (Intelegensia Umum)</span>
                                    <span class="font-bold text-purple-400">80/175</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-slate-600">
                                    <div class="h-full bg-purple-500 rounded-full" style="width: 46%"></div>
                                </div>
                            </div>

                            <div class="p-4 bg-slate-700/50 rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-slate-300">TKP (Karakteristik Pribadi)</span>
                                    <span class="font-bold text-cyan-400">166/225</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-slate-600">
                                    <div class="h-full rounded-full bg-cyan-500" style="width: 74%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 mt-6 border-t border-slate-700">
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-slate-300">Total Passing Grade</span>
                                <span class="text-2xl font-bold text-white">311/550</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics Section --}}
    <section class="py-20 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full">Dipercaya Ribuan Peserta</span>
                <h2 class="mb-4 text-3xl font-bold md:text-4xl text-slate-900">
                    Bersama Kami, Mereka Berhasil!
                </h2>
            </div>

            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-transparent md:text-5xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text">
                        <span class="counter" data-target="15420">0</span>+
                    </div>
                    <p class="text-slate-600">Peserta Aktif</p>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-transparent md:text-5xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text">
                        <span class="counter" data-target="5500">0</span>+
                    </div>
                    <p class="text-slate-600">Bank Soal</p>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-transparent md:text-5xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text">
                        <span class="counter" data-target="8734">0</span>+
                    </div>
                    <p class="text-slate-600">Peserta Lulus</p>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-transparent md:text-5xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text">
                        <span class="counter" data-target="98">0</span>%
                    </div>
                    <p class="text-slate-600">Kepuasan User</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-20 bg-slate-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-3xl font-bold md:text-4xl text-slate-900">
                    Kenapa Pilih Simulasi CPNS?
                </h2>
                <p class="max-w-2xl mx-auto text-xl text-slate-600">
                    Platform terlengkap untuk persiapan tes SKD CPNS dengan fitur unggulan
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                {{-- Feature 1 --}}
                <div class="p-8 bg-white border shadow-lg rounded-2xl card-hover border-slate-100">
                    <div class="flex items-center justify-center mb-6 bg-blue-100 w-14 h-14 rounded-xl">
                        <svg class="text-blue-600 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-slate-900">Soal Berkualitas</h3>
                    <p class="text-slate-600">Soal disusun berdasarkan pola tes CPNS tahun-tahun sebelumnya dengan tingkat kesulitan yang sesuai.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="p-8 bg-white border shadow-lg rounded-2xl card-hover border-slate-100">
                    <div class="flex items-center justify-center mb-6 bg-purple-100 w-14 h-14 rounded-xl">
                        <svg class="text-purple-600 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-slate-900">Timer Realistis</h3>
                    <p class="text-slate-600">Simulasi dengan timer 100 menit seperti tes sesungguhnya. Latih manajemen waktu Anda!</p>
                </div>

                {{-- Feature 3 --}}
                <div class="p-8 bg-white border shadow-lg rounded-2xl card-hover border-slate-100">
                    <div class="flex items-center justify-center mb-6 bg-green-100 w-14 h-14 rounded-xl">
                        <svg class="text-green-600 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-slate-900">Pembahasan Lengkap</h3>
                    <p class="text-slate-600">Setiap soal dilengkapi pembahasan detail untuk membantu Anda memahami materi lebih baik.</p>
                </div>

                {{-- Feature 4 --}}
                <div class="p-8 bg-white border shadow-lg rounded-2xl card-hover border-slate-100">
                    <div class="flex items-center justify-center mb-6 bg-red-100 w-14 h-14 rounded-xl">
                        <svg class="text-red-600 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-slate-900">Anti-Cheating</h3>
                    <p class="text-slate-600">Sistem deteksi kecurangan untuk memastikan hasil simulasi mencerminkan kemampuan sebenarnya.</p>
                </div>

                {{-- Feature 5 --}}
                <div class="p-8 bg-white border shadow-lg rounded-2xl card-hover border-slate-100">
                    <div class="flex items-center justify-center mb-6 bg-yellow-100 w-14 h-14 rounded-xl">
                        <svg class="text-yellow-600 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-slate-900">Analisis Skor</h3>
                    <p class="text-slate-600">Dapatkan analisis detail per kategori dan lihat perkembangan skor Anda dari waktu ke waktu.</p>
                </div>

                {{-- Feature 6 --}}
                <div class="p-8 bg-white border shadow-lg rounded-2xl card-hover border-slate-100">
                    <div class="flex items-center justify-center mb-6 w-14 h-14 bg-cyan-100 rounded-xl">
                        <svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-slate-900">Akses Fleksibel</h3>
                    <p class="text-slate-600">Latihan kapan saja dan di mana saja melalui browser. Tidak perlu install aplikasi!</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section class="py-20 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-purple-600 bg-purple-100 rounded-full">Testimoni Nyata</span>
                <h2 class="mb-4 text-3xl font-bold md:text-4xl text-slate-900">
                    Kata Mereka yang Telah Lulus
                </h2>
                <p class="max-w-2xl mx-auto text-xl text-slate-600">
                    Ribuan peserta telah merasakan manfaat platform kami
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                {{-- Testimonial 1 --}}
                <div class="p-8 transition-all duration-300 bg-white border shadow-lg rounded-2xl border-slate-100 hover:shadow-xl hover:-translate-y-2">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="mb-6 text-slate-600">"Simulasi CPNS benar-benar membantu saya lolos SKD! Soal-soalnya mirip dengan ujian asli. Saya berhasil melewati passing grade dengan skor 385. Terima kasih!"</p>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-12 h-12 font-bold text-white rounded-full bg-gradient-to-br from-blue-500 to-blue-600">
                            AS
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Anisa Safitri</p>
                            <p class="text-sm text-slate-500">Lulus CPNS 2025 - Kemenkeu</p>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 2 --}}
                <div class="p-8 transition-all duration-300 bg-white border shadow-lg rounded-2xl border-slate-100 hover:shadow-xl hover:-translate-y-2">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="mb-6 text-slate-600">"Platform yang sangat worth it! Timer dan interface nya persis seperti CAT BKN asli. Saya jadi lebih siap mental saat ujian. Pembahasan soalnya juga detail banget."</p>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-12 h-12 font-bold text-white rounded-full bg-gradient-to-br from-purple-500 to-purple-600">
                            BP
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Budi Prasetyo</p>
                            <p class="text-sm text-slate-500">Lulus CPNS 2025 - Kemendagri</p>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 3 --}}
                <div class="p-8 transition-all duration-300 bg-white border shadow-lg rounded-2xl border-slate-100 hover:shadow-xl hover:-translate-y-2">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="mb-6 text-slate-600">"Harga paket sangat terjangkau dibanding bimbel offline. Bank soalnya update terus dan banyak variasi. Saya berlatih 2 bulan dan berhasil dapat skor 410!"</p>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-12 h-12 font-bold text-white rounded-full bg-gradient-to-br from-cyan-500 to-cyan-600">
                            CR
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Citra Rahmawati</p>
                            <p class="text-sm text-slate-500">Lulus CPNS 2025 - Kemenkes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Package Preview Section --}}
    <section class="py-20 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        @php
            $samplePackage = \App\Models\Package::where('is_active', true)->first();
            $sampleBundle = \App\Models\Bundle::where('is_active', true)->first();
            $predictionPackage = \App\Models\Package::where('is_active', true)->where('year', 2026)->first();
            $packagePrice = $samplePackage ? $samplePackage->price : 25000;
            $bundlePrice = $sampleBundle ? $sampleBundle->discount_price : 99000;
            $bundleOriginalPrice = $sampleBundle ? $sampleBundle->original_price : 125000;
            $bundlePackagesCount = $sampleBundle ? $sampleBundle->packages()->count() : 5;
            $bundleDiscount = $sampleBundle && $bundleOriginalPrice > 0 ? round((($bundleOriginalPrice - $bundlePrice) / $bundleOriginalPrice) * 100) : 40;

            // Prediction package for ultimate
            $predictionPrice = $predictionPackage ? $predictionPackage->price : 35000;
        @endphp
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-blue-400 border rounded-full bg-blue-500/10 border-blue-500/20">Paket Terbaik</span>
                <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">
                    Pilih Paket yang Sesuai Kebutuhanmu
                </h2>
                <p class="max-w-2xl mx-auto text-xl text-slate-400">
                    Investasi terbaik untuk masa depan karirmu sebagai ASN
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                {{-- Basic Package --}}
                <div class="relative p-8 transition-all duration-300 border bg-slate-800/50 backdrop-blur-xl rounded-2xl border-slate-700/50 hover:border-blue-500/50 hover:-translate-y-2">
                    <div class="mb-6">
                        <h3 class="mb-2 text-2xl font-bold text-white">Paket Basic</h3>
                        <p class="text-white">Cocok untuk latihan awal</p>
                    </div>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-white">Rp {{ number_format($packagePrice / 1000, 0) }}K</span>
                        <span class="text-white">/paket</span>
                    </div>
                    <ul class="mb-8 space-y-3 text-white">
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            110 soal (TWK, TIU, TKP)
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Timer 100 menit
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Pembahasan lengkap
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Analisis skor detail
                        </li>
                    </ul>
                    <a href="{{ route('packages') }}" class="block w-full py-3 font-semibold text-center text-white transition border rounded-xl bg-slate-700 border-slate-600 hover:bg-slate-600">
                        Lihat Detail
                    </a>
                </div>

                {{-- Premium Package (Popular) --}}
                <div class="relative p-8 transition-all duration-300 border border-blue-500 shadow-2xl bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl hover:-translate-y-2">
                    <div class="absolute top-0 -translate-y-1/2 right-6">
                        <span class="px-4 py-1 text-xs font-bold text-blue-600 bg-yellow-400 rounded-full shadow-lg">⭐ TERPOPULER</span>
                    </div>
                    <div class="mb-6">
                        <h3 class="mb-2 text-2xl font-bold text-white">Bundle Hemat</h3>
                        <p class="text-blue-100">Paket paling diminati</p>
                    </div>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-white">Rp {{ number_format($bundlePrice / 1000, 0) }}K</span>
                        <span class="text-blue-100">/{{ $bundlePackagesCount }} paket</span>
                        <div class="mt-2">
                            <span class="px-3 py-1 text-sm font-semibold text-blue-600 bg-yellow-400 rounded-full">Hemat {{ $bundleDiscount }}%</span>
                        </div>
                    </div>
                    <ul class="mb-8 space-y-3 text-white">
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $bundlePackagesCount * 110 }} soal ({{ $bundlePackagesCount }} paket simulasi)
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Sistem CAT like BKN
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Pembahasan super lengkap
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Progress tracking
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Tips & trik lolos SKD
                        </li>
                    </ul>
                    <a href="{{ route('packages') }}" class="block w-full py-3 font-semibold text-center text-blue-600 transition bg-white rounded-xl hover:bg-blue-50">
                        Beli Sekarang
                    </a>
                </div>

                {{-- Ultimate Package --}}
                <div class="relative p-8 transition-all duration-300 border bg-slate-800/50 backdrop-blur-xl rounded-2xl border-slate-700/50 hover:border-purple-500/50 hover:-translate-y-2">
                    <div class="mb-6">
                        <h3 class="mb-2 text-2xl font-bold text-white">Simulasi SKD CPNS 2026</h3>
                        <p class="text-white">Prediksi soal terbaru</p>
                    </div>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-white">Rp {{ number_format($predictionPrice / 1000, 0) }}K</span>
                        <span class="text-white">/paket</span>
                    </div>
                    <ul class="mb-8 space-y-3 text-white">
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            110 soal prediksi terbaru
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Soal prediksi FR 2025/2026
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Kisi-kisi Permenpan RB terbaru
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Pembahasan mendalam
                        </li>
                    </ul>
                    <a href="{{ route('packages') }}" class="block w-full py-3 font-semibold text-center text-white transition border rounded-xl bg-slate-700 border-slate-600 hover:bg-slate-600">
                        Lihat Detail
                    </a>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="mb-4 text-slate-400">Semua paket sudah termasuk akses unlimited dan pembahasan lengkap</p>
                <a href="{{ route('packages') }}" class="inline-flex items-center gap-2 text-blue-400 transition hover:text-blue-300">
                    Lihat semua paket tersedia
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="py-20 bg-white">
        <div class="max-w-4xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-green-600 bg-green-100 rounded-full">FAQ</span>
                <h2 class="mb-4 text-3xl font-bold md:text-4xl text-slate-900">
                    Pertanyaan yang Sering Ditanyakan
                </h2>
            </div>

            <div class="space-y-4">
                <div class="overflow-hidden border rounded-xl border-slate-200">
                    <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                        <span class="text-lg font-semibold text-slate-900">Apakah soalnya sesuai dengan tes CPNS asli?</span>
                        <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-6 faq-content text-slate-600">
                        Ya, soal-soal kami disusun berdasarkan pola dan kisi-kisi tes SKD CPNS tahun-tahun sebelumnya. Tim kami terus mengupdate bank soal sesuai dengan perkembangan terbaru dari BKN.
                    </div>
                </div>

                <div class="overflow-hidden border rounded-xl border-slate-200">
                    <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                        <span class="text-lg font-semibold text-slate-900">Berapa lama akses paket yang sudah dibeli?</span>
                        <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-6 faq-content text-slate-600">
                        Setiap paket yang Anda beli dapat diakses secara unlimited tanpa batas waktu. Anda bisa mengulang simulasi berkali-kali untuk meningkatkan skor.
                    </div>
                </div>

                <div class="overflow-hidden border rounded-xl border-slate-200">
                    <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                        <span class="text-lg font-semibold text-slate-900">Bagaimana cara pembayaran?</span>
                        <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-6 faq-content text-slate-600">
                        Kami menerima berbagai metode pembayaran melalui Midtrans, termasuk transfer bank, e-wallet (GoPay, OVO, DANA), dan kartu kredit. Proses pembayaran aman dan otomatis.
                    </div>
                </div>

                <div class="overflow-hidden border rounded-xl border-slate-200">
                    <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                        <span class="text-lg font-semibold text-slate-900">Apakah ada pembahasan untuk setiap soal?</span>
                        <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-6 faq-content text-slate-600">
                        Tentu! Setiap soal dilengkapi dengan pembahasan detail yang mudah dipahami. Anda bisa belajar dari kesalahan dan memahami konsep dengan lebih baik.
                    </div>
                </div>

                <div class="overflow-hidden border rounded-xl border-slate-200">
                    <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                        <span class="text-lg font-semibold text-slate-900">Bisa diakses dari HP?</span>
                        <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-6 faq-content text-slate-600">
                        Ya, platform kami fully responsive dan bisa diakses dari HP, tablet, atau komputer. Namun kami merekomendasikan menggunakan laptop/PC untuk pengalaman simulasi yang lebih mirip dengan tes asli.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="max-w-4xl px-4 mx-auto text-center sm:px-6 lg:px-8">
            <h2 class="mb-6 text-3xl font-bold text-white md:text-4xl">
                Siap Menjadi PNS?
            </h2>
            <p class="mb-8 text-xl text-blue-100">
                Mulai latihan sekarang dan tingkatkan peluang lolos tes SKD CPNS
            </p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 text-lg font-semibold text-blue-600 transition bg-white rounded-xl hover:bg-blue-50">
                Daftar Sekarang - Gratis!
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-12 bg-slate-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between md:flex-row">
                <div class="flex items-center gap-2 mb-4 md:mb-0">
                    <img src="{{ asset('assets/logo.png') }}" alt="Simulasi CPNS" class="w-10 h-10">
                    <span class="text-xl font-bold text-white">Simulasi CPNS</span>
                </div>

                <p class="text-sm text-slate-400">
                    © {{ date('Y') }} Simulasi CPNS. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Counter Animation
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    element.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            };

            updateCounter();
        }

        // Intersection Observer for counter animation
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.counter');
                    counters.forEach(counter => {
                        if (counter.textContent === '0') {
                            animateCounter(counter);
                        }
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            const statsSection = document.querySelector('.counter')?.closest('section');
            if (statsSection) {
                observer.observe(statsSection);
            }
        });

        // FAQ Toggle
        function toggleFAQ(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');

            content.classList.toggle('hidden');
            icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }
    </script>
</body>
</html>
