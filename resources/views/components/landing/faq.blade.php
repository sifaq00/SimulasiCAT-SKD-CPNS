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
            {{-- FAQ Item 1 --}}
            <div class="overflow-hidden border rounded-xl border-slate-200">
                <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                    <span class="text-lg font-semibold text-slate-900">Apakah soalnya sesuai dengan tes CPNS asli?</span>
                    <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="hidden px-6 pb-6 faq-content text-slate-600">
                    Ya, soal-soal kami disusun berdasarkan pola dan kisi-kisi tes SKD CPNS tahun-tahun sebelumnya. Tim kami terus mengupdate bank soal sesuai dengan perkembangan terbaru dari BKN.
                </div>
            </div>

            {{-- FAQ Item 2 --}}
            <div class="overflow-hidden border rounded-xl border-slate-200">
                <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                    <span class="text-lg font-semibold text-slate-900">Berapa lama akses paket yang sudah dibeli?</span>
                    <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="hidden px-6 pb-6 faq-content text-slate-600">
                    Setiap paket yang Anda beli dapat diakses secara unlimited tanpa batas waktu. Anda bisa mengulang simulasi berkali-kali untuk meningkatkan skor.
                </div>
            </div>

            {{-- FAQ Item 3 --}}
            <div class="overflow-hidden border rounded-xl border-slate-200">
                <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                    <span class="text-lg font-semibold text-slate-900">Bagaimana cara pembayaran?</span>
                    <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="hidden px-6 pb-6 faq-content text-slate-600">
                    Kami menerima berbagai metode pembayaran melalui Midtrans, termasuk transfer bank, e-wallet (GoPay, OVO, DANA), dan kartu kredit. Proses pembayaran aman dan otomatis.
                </div>
            </div>

            {{-- FAQ Item 4 --}}
            <div class="overflow-hidden border rounded-xl border-slate-200">
                <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                    <span class="text-lg font-semibold text-slate-900">Apakah ada pembahasan untuk setiap soal?</span>
                    <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="hidden px-6 pb-6 faq-content text-slate-600">
                    Tentu! Setiap soal dilengkapi dengan pembahasan detail yang mudah dipahami. Anda bisa belajar dari kesalahan dan memahami konsep dengan lebih baik.
                </div>
            </div>

            {{-- FAQ Item 5 --}}
            <div class="overflow-hidden border rounded-xl border-slate-200">
                <button class="flex items-center justify-between w-full p-6 text-left transition faq-button hover:bg-slate-50" onclick="toggleFAQ(this)">
                    <span class="text-lg font-semibold text-slate-900">Bisa diakses dari HP?</span>
                    <svg class="flex-shrink-0 w-5 h-5 transition-transform text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="hidden px-6 pb-6 faq-content text-slate-600">
                    Ya, platform kami fully responsive dan bisa diakses dari HP, tablet, atau komputer. Namun kami merekomendasikan menggunakan laptop/PC untuk pengalaman simulasi yang lebih mirip dengan tes asli.
                </div>
            </div>
        </div>
    </div>
</section>

@once
<script>
    function toggleFAQ(button) {
        const content = button.nextElementSibling;
        const icon = button.querySelector('svg');
        content.classList.toggle('hidden');
        if(icon) icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }
</script>
@endonce
