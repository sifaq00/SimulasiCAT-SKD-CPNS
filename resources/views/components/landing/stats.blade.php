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

@once
<script>
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

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('.counter');
                counters.forEach(counter => {
                    if (counter.textContent === '0') animateCounter(counter);
                });
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.addEventListener('DOMContentLoaded', () => {
        const statsSection = document.querySelector('.counter')?.closest('section');
        if (statsSection) counterObserver.observe(statsSection);
    });
</script>
@endonce
