{{-- Footer --}}
<footer class="py-12 bg-slate-900 border-t border-slate-800">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="grid gap-8 mb-8 md:grid-cols-4">
            {{-- Brand Section --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('assets/logo.png') }}" alt="Simulasi CPNS" class="w-10 h-10">
                    <span class="text-lg font-bold text-white">Simulasi CPNS</span>
                </div>
                <p class="text-sm text-slate-400">Platform simulasi tes SKD CPNS online terpercaya dengan ribuan soal berkualitas.</p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="font-semibold text-white mb-4">Navigasi</h3>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="{{ route('packages') }}" class="hover:text-white transition">Paket</a></li>
                    <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div>
                <h3 class="font-semibold text-white mb-4">Dukungan</h3>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-white transition">Syarat Layanan</a></li>
                    <li><a href="#" class="hover:text-white transition">Hubungi Kami</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="font-semibold text-white mb-4">Hubungi Kami</h3>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li>Email: <a href="mailto:support@simulasicpns.com" class="text-blue-400 hover:text-blue-300">support@simulasicpns.com</a></li>
                    <li>WhatsApp: <a href="https://wa.me/628xx" class="text-blue-400 hover:text-blue-300">+62 8xx xxx xxx</a></li>
                    <li>Jam Operasional: Senin - Jumat<br/>09:00 - 17:00 WIB</li>
                </ul>
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-slate-800 pt-8">
            <div class="flex flex-col items-center justify-between md:flex-row">
                <p class="text-sm text-slate-400">
                    © {{ date('Y') }} Simulasi CPNS. Semua hak dilindungi.
                </p>

                {{-- Social Links --}}
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="text-slate-400 hover:text-blue-400 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-blue-400 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7"/>
                        </svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-blue-400 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1112.63 8" stroke="white" stroke-width="2" fill="none"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
