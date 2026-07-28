<?php
// Zenvora Customer Testimonials Section (Clean Light Theme, Dynamic Slider, No Shadows)
$testimonialsJson = getWebSetting('homepage_testimonials');
$testimonialsList = json_decode($testimonialsJson, true);
if (!is_array($testimonialsList) || empty($testimonialsList)) {
    $testimonialsList = [
        [
            'initials' => 'AM',
            'name' => 'Aarav Mehta',
            'role' => 'Founder, Zephyr Logistics',
            'review' => 'Zenvora got our Private Limited incorporation and trade licenses sorted in exactly 8 days. Direct WhatsApp access to our assigned CA made the entire paperwork process completely effortless.',
            'rating' => 5
        ],
        [
            'initials' => 'NS',
            'name' => 'Neha Sharma',
            'role' => 'Co-Founder, Vedic Retail',
            'review' => 'We outsourced our monthly GST return filings and corporate accounting to Zenvora. Their fixed upfront billing and clean document management saved us from penalty surcharges entirely.',
            'rating' => 5
        ],
        [
            'initials' => 'VA',
            'name' => 'Vikram Aditya',
            'role' => 'Director, Dune Tech Solutions',
            'review' => 'Applied for our trademark registration and ISO certification through Zenvora. The process was 100% digital, and we received our TM application number code in under 24 hours.',
            'rating' => 5
        ]
    ];
}
?>
<!-- Zenvora Customer Testimonials Section -->
<section id="testimonials" class="relative py-24 bg-slate-50 border-b border-slate-100 overflow-hidden">
    <!-- Subtle Background Decorators -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto mb-16 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                <i class="fa-solid fa-star text-[9px]"></i> Client Reviews
            </span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Trusted by Modern Founders
            </h2>
            <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                See how Indian startups and enterprises accelerate their registrations and scale compliance with Zenvora.
            </p>
        </div>

        <!-- Slider viewport -->
        <div class="w-full max-w-3xl mx-auto overflow-hidden bg-white rounded-3xl border border-slate-200/50">
            
            <!-- Sliding Track -->
            <div id="testimonial-track" class="flex transition-transform duration-500 ease-in-out" style="transform: translateX(0%);">
                
                <?php foreach ($testimonialsList as $test): ?>
                <!-- Slide -->
                <div class="w-full flex-shrink-0 p-8 sm:p-12 flex flex-col items-center justify-between">
                    <div class="space-y-6">
                        <i class="fa-solid fa-quote-left text-brand-500/20 text-4xl block mx-auto"></i>
                        <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-medium italic max-w-2xl mx-auto">
                            "<?php echo htmlspecialchars($test['review']); ?>"
                        </p>
                    </div>
                    
                    <!-- Client Details -->
                    <div class="flex flex-col items-center mt-8 pt-6 border-t border-slate-105 w-full">
                        <div class="w-10 h-10 rounded-full bg-brand-500/10 flex items-center justify-center text-xs font-black text-brand-700 mb-3 uppercase">
                            <?php echo htmlspecialchars($test['initials'] ?: substr($test['name'], 0, 2)); ?>
                        </div>
                        <h4 class="text-xs font-extrabold text-slate-900"><?php echo htmlspecialchars($test['name']); ?></h4>
                        <span class="text-[10px] text-slate-400 block mt-0.5"><?php echo htmlspecialchars($test['role']); ?></span>
                        
                        <!-- Rating Stars -->
                        <div class="flex gap-0.5 text-brand-500 text-[9px] mt-2.5">
                            <?php 
                            $stars = (int)($test['rating'] ?? 5);
                            for ($i = 0; $i < $stars; $i++): ?>
                                <i class="fa-solid fa-star"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>

        </div>

        <!-- Slider Navigation Controls (Arrows & Dot Indicators) -->
        <div class="flex items-center justify-center gap-6 mt-8">
            <!-- Left Arrow -->
            <button id="test-prev-btn" class="w-10 h-10 rounded-full border border-slate-250 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            
            <!-- Dots Indicators -->
            <div class="flex gap-2" id="test-dots-container">
                <?php foreach ($testimonialsList as $idx => $test): ?>
                <button class="test-dot w-2 h-2 rounded-full bg-slate-300 transition-all duration-300" data-slide="<?php echo $idx; ?>"></button>
                <?php endforeach; ?>
            </div>

            <!-- Right Arrow -->
            <button id="test-next-btn" class="w-10 h-10 rounded-full border border-slate-250 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </div>

    </div>
</section>

<!-- Testimonials Slider Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.getElementById('testimonial-track');
        const dots = document.querySelectorAll('.test-dot');
        const prevBtn = document.getElementById('test-prev-btn');
        const nextBtn = document.getElementById('test-next-btn');
        
        let currentSlide = 0;
        const totalSlides = dots.length;
        let autoRotateTimer = null;

        if (totalSlides === 0) return;

        function showSlide(index) {
            if (index >= totalSlides) index = 0;
            if (index < 0) index = totalSlides - 1;
            
            currentSlide = index;
            track.style.transform = `translateX(-${currentSlide * 100}%)`;

            dots.forEach((dot, i) => {
                if (i === currentSlide) {
                    dot.classList.remove('bg-slate-300', 'w-2');
                    dot.classList.add('bg-brand-500', 'w-4');
                } else {
                    dot.classList.remove('bg-brand-500', 'w-4');
                    dot.classList.add('bg-slate-300', 'w-2');
                }
            });
        }

        // Initialize first slide dot layout
        showSlide(0);

        function startAutoRotate() {
            stopAutoRotate();
            autoRotateTimer = setInterval(() => {
                showSlide(currentSlide + 1);
            }, 5000);
        }

        function stopAutoRotate() {
            if (autoRotateTimer) {
                clearInterval(autoRotateTimer);
                autoRotateTimer = null;
            }
        }

        nextBtn.addEventListener('click', () => {
            showSlide(currentSlide + 1);
            startAutoRotate();
        });

        prevBtn.addEventListener('click', () => {
            showSlide(currentSlide - 1);
            startAutoRotate();
        });

        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const targetSlide = parseInt(dot.getAttribute('data-slide'));
                showSlide(targetSlide);
                startAutoRotate();
            });
        });

        startAutoRotate();

        const viewport = document.getElementById('testimonials');
        if (viewport) {
            viewport.addEventListener('mouseenter', stopAutoRotate);
            viewport.addEventListener('mouseleave', startAutoRotate);
        }
    });
</script>
