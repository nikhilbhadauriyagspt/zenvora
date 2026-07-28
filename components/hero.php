<!-- Slider Hero Section (Light Theme, Space Grotesk Font, Font Awesome Icons) -->
<section class="relative h-[550px] sm:h-[650px] lg:h-[92vh] min-h-[500px] sm:min-h-[720px] w-full overflow-hidden bg-slate-50 flex items-center">
    <!-- Carousel Slides Wrapper -->
    <div class="relative w-full h-full flex items-center" id="hero-carousel">
        
        <?php 
        $heroSlides = getWebSlides();
        $slideIdx = 0;
        foreach ($heroSlides as $slide): 
            $isActive = ($slideIdx === 0);
        ?>
        <!-- Slide <?php echo $slideIdx + 1; ?>: <?php echo htmlspecialchars($slide['badge']); ?> -->
        <div class="carousel-slide absolute inset-0 w-full h-full <?php echo $isActive ? 'opacity-100 z-10' : 'opacity-0 pointer-events-none z-0'; ?> transition-opacity duration-1000 ease-in-out flex items-center" data-index="<?php echo $slideIdx; ?>">
            <!-- Background Image -->
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($slide['image']); ?>');"></div>
            <!-- Slide White Overlay (Minimal light overlay on mobile to keep text legible, gradient on desktop) -->
            <div class="absolute inset-0 bg-white/20 md:bg-gradient-to-r md:from-white md:via-white/92 md:to-transparent"></div>
            
            <!-- Slide Content -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-20">
                <div class="max-w-3xl space-y-4 md:space-y-8 animate-fade-in-up">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] sm:text-xs font-extrabold bg-brand-550/15 border border-brand-500/20 text-brand-700 tracking-wider uppercase">
                        <i class="fa-solid fa-rocket mr-1 text-[8px] sm:text-[10px]"></i> <?php echo htmlspecialchars($slide['badge']); ?>
                    </span>
                    <!-- Smaller Headings on Mobile -->
                    <h1 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold text-slate-900 leading-tight tracking-tight">
                        <?php echo $slide['title']; ?>
                    </h1>
                    
                    <!-- Points Layout: Large Icon, Heading + Subcontent (Hidden on mobile) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl pt-2 hidden sm:grid">
                        <!-- Point 1 -->
                        <div class="glass-card p-4 rounded-xl border border-slate-200/50 flex flex-col items-start space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-brand-500/10 text-brand-600 flex items-center justify-center text-base">
                                <i class="<?php echo htmlspecialchars($slide['p1_icon']); ?>"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($slide['p1_title']); ?></h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed"><?php echo htmlspecialchars($slide['p1_desc']); ?></p>
                            </div>
                        </div>

                        <!-- Point 2 -->
                        <div class="glass-card p-4 rounded-xl border border-slate-200/50 flex flex-col items-start space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-brand-500/10 text-brand-600 flex items-center justify-center text-base">
                                <i class="<?php echo htmlspecialchars($slide['p2_icon']); ?>"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($slide['p2_title']); ?></h3>
                                <p class="text-xs text-slate-550 mt-1 leading-relaxed"><?php echo htmlspecialchars($slide['p2_desc']); ?></p>
                            </div>
                        </div>

                        <!-- Point 3 -->
                        <div class="glass-card p-4 rounded-xl border border-slate-200/50 flex flex-col items-start space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-brand-500/10 text-brand-600 flex items-center justify-center text-base">
                                <i class="<?php echo htmlspecialchars($slide['p3_icon']); ?>"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($slide['p3_title']); ?></h3>
                                <p class="text-xs text-slate-550 mt-1 leading-relaxed"><?php echo htmlspecialchars($slide['p3_desc']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Highlights (Visible only on mobile/tabs) -->
                    <div class="flex flex-wrap items-center gap-x-3.5 gap-y-1.5 sm:hidden text-slate-800 text-[10px] font-extrabold pt-1">
                        <span class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-brand-500 text-[9px]"></i> <?php echo htmlspecialchars($slide['p1_title']); ?></span>
                        <span class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-brand-500 text-[9px]"></i> <?php echo htmlspecialchars($slide['p2_title']); ?></span>
                        <span class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-brand-500 text-[9px]"></i> <?php echo htmlspecialchars($slide['p3_title']); ?></span>
                    </div>

                    <?php if (!empty($slide['btn1_text']) || !empty($slide['btn2_text'])): ?>
                    <div class="flex items-center gap-2.5 pt-2">
                        <?php if (!empty($slide['btn1_text'])): ?>
                        <a href="<?php echo htmlspecialchars($slide['btn1_url'] ?? '#'); ?>" class="px-4 py-2.5 rounded-full text-[10px] sm:text-sm sm:px-7 sm:py-3.5 font-bold text-white accent-gradient hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                            <?php echo htmlspecialchars($slide['btn1_text']); ?>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($slide['btn2_text'])): ?>
                        <a href="<?php echo htmlspecialchars($slide['btn2_url'] ?? '#'); ?>" class="px-4 py-2.5 rounded-full text-[10px] sm:text-sm sm:px-7 sm:py-3.5 font-bold text-slate-700 bg-white border border-slate-200 shadow-sm hover:bg-slate-50 transition-all duration-300">
                            <?php echo htmlspecialchars($slide['btn2_text']); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php 
            $slideIdx++;
        endforeach; 
        ?>
    </div>

    <!-- Carousel Controls -->
    <div class="absolute bottom-8 sm:bottom-24 right-8 z-30 flex items-center gap-3">
        <!-- Prev Button -->
        <button id="carousel-prev" class="w-10 h-10 rounded-full flex items-center justify-center bg-white/80 border border-slate-200 text-slate-650 hover:text-brand-600 hover:bg-white shadow-sm transition-all duration-200 focus:outline-none" aria-label="Previous slide">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <!-- Next Button -->
        <button id="carousel-next" class="w-10 h-10 rounded-full flex items-center justify-center bg-white/80 border border-slate-200 text-slate-650 hover:text-brand-600 hover:bg-white shadow-sm transition-all duration-200 focus:outline-none" aria-label="Next slide">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <!-- Indicator Dots (Dynamic) -->
    <div class="absolute bottom-8 sm:bottom-24 left-8 z-30 flex items-center gap-2" id="carousel-indicators">
        <?php for ($i = 0; $i < count($heroSlides); $i++): ?>
        <button class="<?php echo ($i === 0) ? 'w-8 h-2' : 'w-2.5 h-2.5'; ?> rounded-full <?php echo ($i === 0) ? 'bg-brand-500' : 'bg-slate-300 hover:bg-slate-400'; ?> transition-all duration-300" data-slide="<?php echo $i; ?>" aria-label="Go to slide <?php echo $i + 1; ?>"></button>
        <?php endfor; ?>
    </div>

    <!-- Sleek Floating Trust Logo Strip -->
    <div class="absolute bottom-0 left-0 right-0 w-full z-20 bg-white/90 backdrop-blur-xl border-t border-slate-200/60 py-5 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Trust badge label -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-brand-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-800 uppercase tracking-widest">Government Approved Registrations:</span>
            </div>
            <!-- Trust Items -->
            <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-2 text-xs sm:text-[13px] font-extrabold text-slate-700">
                <span class="flex items-center gap-2 hover:text-slate-900 transition-colors"><i class="fa-solid fa-building text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_mca'); ?></span>
                <span class="flex items-center gap-2 hover:text-slate-900 transition-colors"><i class="fa-solid fa-receipt text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_gst'); ?></span>
                <span class="flex items-center gap-2 hover:text-slate-900 transition-colors"><i class="fa-solid fa-briefcase text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_msme'); ?></span>
                <span class="flex items-center gap-2 hover:text-slate-900 transition-colors"><i class="fa-solid fa-flag text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_dpiit'); ?></span>
                <span class="flex items-center gap-2 hover:text-slate-900 transition-colors"><i class="fa-solid fa-utensils text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_fssai'); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- Carousel JavaScript Handler -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('#carousel-indicators button');
        const prevBtn = document.getElementById('carousel-prev');
        const nextBtn = document.getElementById('carousel-next');
        
        if (slides.length === 0) return;
        
        let currentIndex = 0;
        let autoplayTimer = null;
        const intervalDuration = 5500; // 5.5 seconds per slide

        function showSlide(index) {
            slides[currentIndex].classList.remove('opacity-100', 'z-10');
            slides[currentIndex].classList.add('opacity-0', 'pointer-events-none', 'z-0');
            
            if (indicators[currentIndex]) {
                indicators[currentIndex].classList.remove('w-8', 'bg-brand-500');
                indicators[currentIndex].classList.add('w-2.5', 'h-2.5', 'bg-slate-300');
            }

            currentIndex = index;

            slides[currentIndex].classList.add('opacity-100', 'z-10');
            slides[currentIndex].classList.remove('opacity-0', 'pointer-events-none', 'z-0');

            if (indicators[currentIndex]) {
                indicators[currentIndex].classList.add('w-8', 'bg-brand-500');
                indicators[currentIndex].classList.remove('w-2.5', 'h-2.5', 'bg-slate-300');
            }
        }

        function nextSlide() {
            let nextIndex = (currentIndex + 1) % slides.length;
            showSlide(nextIndex);
        }

        function prevSlide() {
            let prevIndex = (currentIndex - 1 + slides.length) % slides.length;
            showSlide(prevIndex);
        }

        function startAutoplay() {
            stopAutoplay();
            autoplayTimer = setInterval(nextSlide, intervalDuration);
        }

        function stopAutoplay() {
            if (autoplayTimer) {
                clearInterval(autoplayTimer);
            }
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                startAutoplay();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                startAutoplay();
            });
        }

        indicators.forEach((indicator, idx) => {
            indicator.addEventListener('click', () => {
                showSlide(idx);
                startAutoplay();
            });
        });

        startAutoplay();
    });
</script>
