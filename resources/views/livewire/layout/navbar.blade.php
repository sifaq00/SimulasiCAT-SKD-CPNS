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
