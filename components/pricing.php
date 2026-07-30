<?php
/**
 * Zenvora Premium Pricing Section - Dynamic Slider/Carousel Component (Dark Theme)
 * Loads pricing tiers dynamically from the MySQL database with mobile carousel fallback.
 */

$db_packages = [];
if (isset($pdo) && $pdo !== null) {
    try {
        $db_packages = $pdo->query("SELECT * FROM pricing_packages WHERE status = 'Active' ORDER BY sort_order ASC, id ASC LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $db_packages = [];
    }
}

// Fallback pricing packages if database query is empty
if (empty($db_packages)) {
    $db_packages = [
        [
            'title' => 'Startup Registry',
            'subtitle' => 'For Early Stage Founders',
            'price' => '₹4,999',
            'tax_note' => '+ Gov Challan',
            'description' => 'Complete legal setup to get your corporate identity registered with MCA and tax hubs in days.',
            'deliverables' => "2 Director DINs & DSC Digital Keys\nMCA Name Approval Filing (RUN)\nMoA / AoA Drafting & Filing\nPAN & TAN Cards Allocation\nZero-Balance Current Bank Account",
            'badge' => '',
            'sort_order' => 1
        ],
        [
            'title' => 'Scale & Compliancy',
            'subtitle' => 'For Funded & Scaling Startups',
            'price' => '₹9,999',
            'tax_note' => '+ Gov Challan',
            'description' => 'Complete corporate incorporation combined with operational tax registrations and corporate advisor check-ins.',
            'deliverables' => "Everything in Startup Registry\nMSME (Udyam) Registration\nGST Registration & HSN Codes Setup\n1-Year Compliance Calendar Consult\nFirst Board Resolution Draft",
            'badge' => 'Most Popular',
            'sort_order' => 2
        ],
        [
            'title' => 'Enterprise Suite',
            'subtitle' => 'For Subsidiaries & MNCs',
            'price' => '₹24,999',
            'tax_note' => 'All-Inclusive Fee',
            'description' => 'End-to-end setup coordination for foreign subsidiaries, joint ventures, and custom capital structures.',
            'deliverables' => "Foreign Direct Investment (FDI) reporting\nRBI FEMA compliance checks\nCustom drafted Shareholder agreements\nDedicated Corporate Secretary support\nRegistered Office Address setup (1 Year)",
            'badge' => '',
            'sort_order' => 3
        ]
    ];
}
?>
<!-- Zenvora Premium Pricing Section (Dark Theme, 3-Tier Spotlight Grid, Dynamic Carousel Slider) -->
<section id="pricing" class="relative py-24 bg-slate-950 border-b border-slate-900 overflow-hidden">
    <!-- Subtle Background Decorators -->
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="max-w-3xl text-left mb-16 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/30 text-brand-400 uppercase tracking-widest">
                <i class="fa-solid fa-tags text-[9px]"></i> Flat Pricing
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-50 tracking-tight leading-tight">
                Transparent Packages. Zero Hidden Fees.
            </h2>
            <p class="text-slate-400 text-sm leading-relaxed font-semibold">
                Select a compliance tier designed for your company stage. All government challans are itemized and shared directly.
            </p>
        </div>

        <!-- Swipeable Pricing Slider Wrapper (Grid on desktop, Carousel on mobile/tablet) -->
        <div class="relative w-full overflow-hidden" id="pricing-slider-container">
            
            <!-- Sliding Track -->
            <div id="pricing-track" class="flex md:grid md:grid-cols-3 gap-8 transition-transform duration-500 ease-in-out md:transform-none select-none" style="transform: translateX(0%);">
                
                <?php foreach ($db_packages as $idx => $pkg): 
                    $isFeatured = ($pkg['badge'] === 'Most Popular');
                    $lines = explode("\n", str_replace("\r", "", $pkg['deliverables']));
                ?>
                <!-- Pricing Card slide -->
                <div class="w-full flex-shrink-0 md:w-auto md:flex-shrink-1 p-1">
                    <div class="h-full rounded-3xl p-8 border flex flex-col justify-between relative <?php echo $isFeatured ? 'bg-slate-900 text-white border-2 border-brand-500 shadow-xl shadow-brand-500/15 transform md:-translate-y-2 z-10 hover:shadow-brand-500/25 transition-all duration-300' : 'bg-slate-900/40 text-slate-300 border-slate-800 hover:border-brand-500/30 hover:-translate-y-1 hover:shadow-lg shadow-black/10 transition-all duration-300'; ?>">
                        
                        <?php if ($pkg['badge']): ?>
                        <!-- Most Popular Tag -->
                        <span class="absolute top-0 right-8 -translate-y-1/2 px-3 py-1 bg-brand-500 text-slate-950 text-[9px] font-black uppercase tracking-widest rounded-full z-20 shadow">
                            <?php echo htmlspecialchars($pkg['badge']); ?>
                        </span>
                        <?php endif; ?>
                        
                        <div class="space-y-6">
                            <!-- Package Name & Target -->
                            <div class="space-y-1 text-left">
                                <h3 class="text-base font-extrabold text-white"><?php echo htmlspecialchars($pkg['title']); ?></h3>
                                <p class="text-[11px] <?php echo $isFeatured ? 'text-brand-400' : 'text-brand-400/80'; ?> font-semibold uppercase tracking-wider"><?php echo htmlspecialchars($pkg['subtitle']); ?></p>
                            </div>

                            <!-- Price -->
                            <div class="mt-6 flex items-baseline text-white gap-1 text-left">
                                <span class="text-3xl font-black text-brand-400"><?php echo htmlspecialchars($pkg['price']); ?></span>
                                <span class="text-slate-500 text-[10px] font-semibold tracking-wider uppercase"><?php echo htmlspecialchars($pkg['tax_note']); ?></span>
                            </div>

                            <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium text-left font-medium">
                                <?php echo htmlspecialchars($pkg['description']); ?>
                            </p>

                            <!-- Deliverables Checklist -->
                            <ul class="mt-8 space-y-4 text-xs font-semibold <?php echo $isFeatured ? 'text-slate-200' : 'text-slate-350'; ?> text-left">
                                <?php foreach ($lines as $ln): 
                                    if (trim($ln) === '') continue;
                                ?>
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 rounded-full <?php echo $isFeatured ? 'bg-brand-500/25 text-brand-400' : 'bg-brand-500/15 text-brand-400'; ?> flex items-center justify-center text-[10px] mt-0.5 flex-shrink-0"><i class="fa-solid fa-check"></i></span>
                                    <span><?php echo htmlspecialchars($ln); ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="mt-8 pt-6 border-t border-slate-800">
                            <a href="#contact" class="block w-full text-center py-3.5 rounded-xl text-xs font-black <?php echo $isFeatured ? 'text-slate-950 bg-brand-500 hover:bg-brand-400' : 'text-slate-200 bg-slate-950 hover:bg-slate-900 border border-slate-800 hover:border-brand-500/30 hover:text-white shadow-sm'; ?> transition-all duration-200 hover:-translate-y-0.5">
                                Select <?php echo htmlspecialchars($pkg['title']); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>

        <!-- Slider controls for mobile/tablet (Hidden on desktop) -->
        <div class="flex items-center justify-center gap-6 mt-8 md:hidden">
            <!-- Left Arrow -->
            <button id="price-prev-btn" class="w-10 h-10 rounded-full border border-slate-800 bg-slate-900 hover:bg-slate-850 text-slate-300 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            
            <!-- Dots Indicators -->
            <div class="flex gap-2" id="price-dots-container">
                <?php foreach ($db_packages as $idx => $pkg): ?>
                <button class="<?php echo $idx === 0 ? 'w-6 h-1.5 bg-brand-500' : 'w-1.5 h-1.5 bg-slate-700'; ?> rounded-full transition-all duration-300" data-index="<?php echo $idx; ?>" aria-label="Go to pricing slide <?php echo $idx + 1; ?>"></button>
                <?php endforeach; ?>
            </div>

            <!-- Right Arrow -->
            <button id="price-next-btn" class="w-10 h-10 rounded-full border border-slate-800 bg-slate-900 hover:bg-slate-850 text-slate-300 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </div>

    </div>
</section>

<!-- Pricing Slider JS Handler -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.getElementById('pricing-track');
        const dots = document.querySelectorAll('#price-dots-container button');
        const prevBtn = document.getElementById('price-prev-btn');
        const nextBtn = document.getElementById('price-next-btn');

        if (!track || dots.length === 0) return;

        let currentIndex = 0;
        const totalSlides = dots.length;

        function updateSlider(index) {
            if (window.innerWidth >= 768) {
                track.style.transform = '';
                return; 
            }

            currentIndex = index;
            track.style.transform = `translateX(-${currentIndex * 100}%)`;

            // Update indicators
            dots.forEach((dot, idx) => {
                if (idx === currentIndex) {
                    dot.className = 'w-6 h-1.5 bg-brand-500 rounded-full transition-all duration-300';
                } else {
                    dot.className = 'w-1.5 h-1.5 bg-slate-700 rounded-full transition-all duration-300';
                }
            });
        }

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => {
                let nextIdx = currentIndex - 1;
                if (nextIdx < 0) nextIdx = totalSlides - 1;
                updateSlider(nextIdx);
            });

            nextBtn.addEventListener('click', () => {
                let nextIdx = currentIndex + 1;
                if (nextIdx >= totalSlides) nextIdx = 0;
                updateSlider(nextIdx);
            });
        }

        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const idx = parseInt(dot.getAttribute('data-index'), 10);
                updateSlider(idx);
            });
        });

        // Reset slide transform on resize if switching to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                track.style.transform = '';
            } else {
                updateSlider(currentIndex);
            }
        });
    });
</script>
