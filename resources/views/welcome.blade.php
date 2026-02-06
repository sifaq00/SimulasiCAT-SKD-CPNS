<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Simulasi CPNS') }} - Latihan SKD CPNS Online</title>
    <meta name="description" content="Platform simulasi tes SKD CPNS terlengkap. Latihan soal TWK, TIU, TKP dengan pembahasan lengkap.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }

        .landing-hero {
            background: radial-gradient(circle at 0% 0%, #0f172a 0%, #020617 100%);
            min-height: 100vh;
        }

        .gradient-text {
            background: linear-gradient(to right, #60a5fa, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(120px);
            opacity: 0.2;
            pointer-events: none;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .btn-primary {
            background: linear-gradient(to right, #2563eb, #9333ea);
            color: white;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.25);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            opacity: 0.9;
            box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.4);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .pulse-badge {
            animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="antialiased">
    <x-landing.navbar />

    <main>
        {{-- OUR PREMIUM HERO SECTION --}}
        <x-landing.hero :package="$packages->where('is_free', false)->first()" />

        {{-- Statistics Section --}}
        <x-landing.stats />

        {{-- Our Premium Features Section --}}
        <x-landing.features />

        {{-- Testimonials Section --}}
        <x-landing.testimonials />

        {{-- OUR BENTO PRICING SECTION --}}
        <x-landing.pricing :packages="$packages" :bundles="$bundles" />

        {{-- FAQ Section --}}
        <x-landing.faq />

        {{-- CTA Section --}}
        <x-landing.cta />
    </main>

    {{-- Shared Footer --}}
    <x-landing.footer />
</body>
</html>
