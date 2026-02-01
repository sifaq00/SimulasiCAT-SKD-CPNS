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
    <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/80 backdrop-blur-lg border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">S</span>
                    </div>
                    <span class="text-white font-bold text-xl">Simulasi CPNS</span>
                </div>
                
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-white transition">Dashboard</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-slate-300 hover:text-white transition">Admin</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-slate-300 hover:text-white transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero-gradient min-h-screen flex items-center relative overflow-hidden">
        {{-- Background blobs --}}
        <div class="blob w-96 h-96 bg-blue-600 -top-20 -left-20"></div>
        <div class="blob w-80 h-80 bg-purple-600 top-1/2 right-0"></div>
        <div class="blob w-64 h-64 bg-cyan-500 bottom-20 left-1/3"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full mb-6">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-blue-400 text-sm font-medium">Update soal terbaru 2024</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                        Raih Skor <span class="gradient-text">Tertinggi</span> di Tes SKD CPNS
                    </h1>
                    
                    <p class="text-xl text-slate-400 mb-8 leading-relaxed">
                        Latihan soal SKD CPNS dengan sistem seperti CAT BKN. 
                        Tersedia ribuan soal TWK, TIU, dan TKP dengan pembahasan lengkap.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mb-10">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold text-lg hover:opacity-90 transition flex items-center gap-2">
                            Mulai Latihan
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('packages') }}" class="px-8 py-4 bg-white/10 text-white rounded-xl font-semibold text-lg hover:bg-white/20 transition border border-white/20">
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
                    <div class="bg-slate-800/50 backdrop-blur-xl rounded-3xl p-8 border border-slate-700/50">
                        <div class="text-center mb-6">
                            <h3 class="text-white text-xl font-semibold mb-2">Passing Grade SKD CPNS</h3>
                            <p class="text-slate-400 text-sm">Minimal skor per kategori</p>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-slate-700/50 rounded-xl p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-slate-300 font-medium">TWK (Wawasan Kebangsaan)</span>
                                    <span class="text-blue-400 font-bold">65/150</span>
                                </div>
                                <div class="h-2 bg-slate-600 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full" style="width: 43%"></div>
                                </div>
                            </div>
                            
                            <div class="bg-slate-700/50 rounded-xl p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-slate-300 font-medium">TIU (Intelegensia Umum)</span>
                                    <span class="text-purple-400 font-bold">80/175</span>
                                </div>
                                <div class="h-2 bg-slate-600 rounded-full overflow-hidden">
                                    <div class="h-full bg-purple-500 rounded-full" style="width: 46%"></div>
                                </div>
                            </div>
                            
                            <div class="bg-slate-700/50 rounded-xl p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-slate-300 font-medium">TKP (Karakteristik Pribadi)</span>
                                    <span class="text-cyan-400 font-bold">166/225</span>
                                </div>
                                <div class="h-2 bg-slate-600 rounded-full overflow-hidden">
                                    <div class="h-full bg-cyan-500 rounded-full" style="width: 74%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-slate-700">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-300 font-medium">Total Passing Grade</span>
                                <span class="text-2xl font-bold text-white">311/550</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
                    Kenapa Pilih Simulasi CPNS?
                </h2>
                <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                    Platform terlengkap untuk persiapan tes SKD CPNS dengan fitur unggulan
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover border border-slate-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Soal Berkualitas</h3>
                    <p class="text-slate-600">Soal disusun berdasarkan pola tes CPNS tahun-tahun sebelumnya dengan tingkat kesulitan yang sesuai.</p>
                </div>
                
                {{-- Feature 2 --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover border border-slate-100">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Timer Realistis</h3>
                    <p class="text-slate-600">Simulasi dengan timer 100 menit seperti tes sesungguhnya. Latih manajemen waktu Anda!</p>
                </div>
                
                {{-- Feature 3 --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover border border-slate-100">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Pembahasan Lengkap</h3>
                    <p class="text-slate-600">Setiap soal dilengkapi pembahasan detail untuk membantu Anda memahami materi lebih baik.</p>
                </div>
                
                {{-- Feature 4 --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover border border-slate-100">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Anti-Cheating</h3>
                    <p class="text-slate-600">Sistem deteksi kecurangan untuk memastikan hasil simulasi mencerminkan kemampuan sebenarnya.</p>
                </div>
                
                {{-- Feature 5 --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover border border-slate-100">
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Analisis Skor</h3>
                    <p class="text-slate-600">Dapatkan analisis detail per kategori dan lihat perkembangan skor Anda dari waktu ke waktu.</p>
                </div>
                
                {{-- Feature 6 --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover border border-slate-100">
                    <div class="w-14 h-14 bg-cyan-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Akses Fleksibel</h3>
                    <p class="text-slate-600">Latihan kapan saja dan di mana saja melalui browser. Tidak perlu install aplikasi!</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Siap Menjadi PNS?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Mulai latihan sekarang dan tingkatkan peluang lolos tes SKD CPNS
            </p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 rounded-xl font-semibold text-lg hover:bg-blue-50 transition">
                Daftar Sekarang - Gratis!
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-2 mb-4 md:mb-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">S</span>
                    </div>
                    <span class="text-white font-bold text-xl">Simulasi CPNS</span>
                </div>
                
                <p class="text-slate-400 text-sm">
                    © {{ date('Y') }} Simulasi CPNS. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
