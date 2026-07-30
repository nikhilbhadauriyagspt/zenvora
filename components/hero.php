<!-- Slider Hero Section (Dark Theme, Space Grotesk Font, Font Awesome Icons) -->
<section class="relative h-[550px] sm:h-[650px] lg:h-[92vh] min-h-[500px] sm:min-h-[720px] w-full overflow-hidden bg-slate-950 flex items-center">
    <!-- Carousel Slides Wrapper -->
    <div class="relative w-full h-full flex items-center" id="hero-carousel">
        
        <?php 
        $heroSlides = getWebSlides();
        $slideIdx = 0;
        foreach ($heroSlides as $slide): 
            $isActive = ($slideIdx === 0);
        ?>
        <!-- Slide <?php echo $slideIdx + 1; ?>: <?php echo htmlspecialchars($slide['badge']); ?> -->
        <div class="carousel-slide absolute inset-0 w-full h-full <?php echo $isActive ? 'opacity-100 z-10 active-slide' : 'opacity-0 pointer-events-none z-0'; ?> transition-opacity duration-1000 ease-in-out flex items-center" data-index="<?php echo $slideIdx; ?>">
            <!-- Background Image -->
            <div class="absolute inset-0 bg-cover bg-center hero-bg-img" style="background-image: url('<?php echo htmlspecialchars($slide['image']); ?>');"></div>
            <!-- Slide Dark Overlay (Strong dark overlay on left for text readability, completely transparent on the right to keep image clear) -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/80 to-transparent"></div>
            <!-- Glowing Gold Orb for premium visual appeal -->
            <div class="absolute top-1/4 left-[8%] w-80 h-80 rounded-full bg-brand-500/10 blur-[130px] pointer-events-none animate-pulse-slow"></div>
            
            <!-- Slide Content -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-20">
                <div class="max-w-3xl space-y-4 md:space-y-8">
                    <span class="slide-badge inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] sm:text-xs font-extrabold bg-brand-500/10 border border-brand-500/30 text-brand-400 tracking-wider uppercase">
                        <i class="fa-solid fa-rocket mr-1 text-[8px] sm:text-[10px]"></i> <?php echo htmlspecialchars($slide['badge']); ?>
                    </span>
                    <!-- Smaller Headings on Mobile -->
                    <h1 class="slide-title text-3xl sm:text-4xl lg:text-6xl font-extrabold text-slate-50 leading-tight tracking-tight">
                        <?php echo $slide['title']; ?>
                    </h1>
                    
                    <!-- Points Layout: Large Icon, Heading + Subcontent (Hidden on mobile) -->
                    <div class="slide-points grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl pt-2 hidden sm:grid">
                        <!-- Point 1 -->
                        <div class="glass-card p-4 rounded-xl border border-slate-800/80 flex flex-col items-start space-y-3 hover:-translate-y-1 hover:border-brand-500/40 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300 cursor-pointer">
                            <div class="w-10 h-10 rounded-lg bg-brand-500/15 text-brand-400 flex items-center justify-center text-base">
                                <i class="<?php echo htmlspecialchars($slide['p1_icon']); ?>"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-100"><?php echo htmlspecialchars($slide['p1_title']); ?></h3>
                                <p class="text-xs text-slate-400 mt-1 leading-relaxed"><?php echo htmlspecialchars($slide['p1_desc']); ?></p>
                            </div>
                        </div>

                        <!-- Point 2 -->
                        <div class="glass-card p-4 rounded-xl border border-slate-800/80 flex flex-col items-start space-y-3 hover:-translate-y-1 hover:border-brand-500/40 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300 cursor-pointer">
                            <div class="w-10 h-10 rounded-lg bg-brand-500/15 text-brand-400 flex items-center justify-center text-base">
                                <i class="<?php echo htmlspecialchars($slide['p2_icon']); ?>"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-100"><?php echo htmlspecialchars($slide['p2_title']); ?></h3>
                                <p class="text-xs text-slate-400 mt-1 leading-relaxed"><?php echo htmlspecialchars($slide['p2_desc']); ?></p>
                            </div>
                        </div>

                        <!-- Point 3 -->
                        <div class="glass-card p-4 rounded-xl border border-slate-800/80 flex flex-col items-start space-y-3 hover:-translate-y-1 hover:border-brand-500/40 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300 cursor-pointer">
                            <div class="w-10 h-10 rounded-lg bg-brand-500/15 text-brand-400 flex items-center justify-center text-base">
                                <i class="<?php echo htmlspecialchars($slide['p3_icon']); ?>"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-100"><?php echo htmlspecialchars($slide['p3_title']); ?></h3>
                                <p class="text-xs text-slate-400 mt-1 leading-relaxed"><?php echo htmlspecialchars($slide['p3_desc']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Highlights (Visible only on mobile/tabs) -->
                    <div class="slide-points flex flex-wrap items-center gap-x-3.5 gap-y-1.5 sm:hidden text-slate-300 text-[10px] font-extrabold pt-1">
                        <span class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-brand-500 text-[9px]"></i> <?php echo htmlspecialchars($slide['p1_title']); ?></span>
                        <span class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-brand-500 text-[9px]"></i> <?php echo htmlspecialchars($slide['p2_title']); ?></span>
                        <span class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-brand-500 text-[9px]"></i> <?php echo htmlspecialchars($slide['p3_title']); ?></span>
                    </div>

                    <?php if (!empty($slide['btn1_text']) || !empty($slide['btn2_text'])): ?>
                    <div class="slide-buttons flex items-center gap-2.5 pt-2">
                        <?php if (!empty($slide['btn1_text'])): ?>
                        <a href="<?php echo htmlspecialchars($slide['btn1_url'] ?? '#'); ?>" class="px-4 py-2.5 rounded-full text-[10px] sm:text-sm sm:px-7 sm:py-3.5 font-bold text-white accent-gradient hover:shadow-lg hover:shadow-brand-500/25 transition-all duration-300 hover:-translate-y-0.5">
                            <?php echo htmlspecialchars($slide['btn1_text']); ?>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($slide['btn2_text'])): ?>
                        <a href="<?php echo htmlspecialchars($slide['btn2_url'] ?? '#'); ?>" class="px-4 py-2.5 rounded-full text-[10px] sm:text-sm sm:px-7 sm:py-3.5 font-bold text-slate-200 bg-slate-900/60 border border-slate-800/80 shadow-sm hover:bg-slate-850 hover:text-white hover:border-brand-500/40 transition-all duration-300">
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
    <div class="absolute bottom-10 sm:bottom-28 right-8 z-30 flex items-center gap-3">
        <!-- Prev Button -->
        <button id="carousel-prev" class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-900/80 border border-slate-800 text-slate-300 hover:text-brand-400 hover:bg-slate-850 shadow-sm transition-all duration-200 focus:outline-none" aria-label="Previous slide">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <!-- Next Button -->
        <button id="carousel-next" class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-900/80 border border-slate-800 text-slate-300 hover:text-brand-400 hover:bg-slate-850 shadow-sm transition-all duration-200 focus:outline-none" aria-label="Next slide">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <!-- Sleek Floating Trust Logo Strip -->
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 w-[92%] max-w-7xl z-20 bg-slate-950/75 backdrop-blur-xl border border-slate-900/80 py-4 px-6 rounded-2xl hidden md:block shadow-xl shadow-black/40">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Trust badge label -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-brand-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-200 uppercase tracking-widest">Government Approved Registrations:</span>
            </div>
            <!-- Trust Items -->
            <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-2 text-xs sm:text-[13px] font-extrabold text-slate-400">
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-building text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_mca'); ?></span>
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-receipt text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_gst'); ?></span>
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-briefcase text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_msme'); ?></span>
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-flag text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_dpiit'); ?></span>
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-utensils text-brand-500 text-sm"></i> <?php echo getWebSetting('badge_fssai'); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- Carousel JavaScript Handler -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.carousel-slide');
        const prevBtn = document.getElementById('carousel-prev');
        const nextBtn = document.getElementById('carousel-next');
        
        if (slides.length === 0) return;
        
        let currentIndex = 0;
        let autoplayTimer = null;
        const intervalDuration = 5500; // 5.5 seconds per slide

        function showSlide(index) {
            slides[currentIndex].classList.remove('opacity-100', 'z-10', 'active-slide');
            slides[currentIndex].classList.add('opacity-0', 'pointer-events-none', 'z-0');

            currentIndex = index;

            slides[currentIndex].classList.add('opacity-100', 'z-10', 'active-slide');
            slides[currentIndex].classList.remove('opacity-0', 'pointer-events-none', 'z-0');
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

        startAutoplay();
    });
</script>
