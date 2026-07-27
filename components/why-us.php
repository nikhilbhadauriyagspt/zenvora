<!-- Why Choose Us Section (Interactive Vertical Accordion, Image Swap Layout, Light Theme, No Shadows) -->
<section id="why-choose-us" class="relative py-24 bg-slate-50 border-b border-slate-100 overflow-hidden">
    <!-- Subtle Grid Background -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="max-w-3xl text-left mb-16 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                <i class="fa-solid fa-circle-question text-[9px]"></i> Why Zenvora
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Engineered for Startup Growth
            </h2>
            <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                We replace slow, traditional legal setups with streamlined, digital compliance pipelines. Here is why modern founders choose Zenvora.
            </p>
        </div>

        <!-- Split Grid: Accordion Left, Image Swap Right -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Side: Interactive Accordions (col-span-5) -->
            <div class="lg:col-span-5 space-y-4">
                
                <!-- Accordion Item 1 (Active by default) -->
                <div class="why-acc-item active border border-brand-500/30 bg-white rounded-2xl p-6 transition-all duration-300 cursor-pointer" data-image="assets/images/hero_bg_5.jpg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-xs flex-shrink-0">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-900">Direct Advisor Communication</h3>
                        </div>
                        <i class="why-acc-chevron fa-solid fa-chevron-up text-xs text-slate-400 transition-transform duration-300"></i>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="why-acc-content mt-4 text-xs text-slate-500 leading-relaxed overflow-hidden transition-all duration-300 max-h-[100px]">
                        Talk directly to qualified CAs, CSs, and corporate lawyers assigned to your company. Skip intermediate sales agents and get expert legal guidance instantly.
                    </div>
                </div>

                <!-- Accordion Item 2 -->
                <div class="why-acc-item border border-slate-200/60 bg-white/60 hover:bg-white rounded-2xl p-6 transition-all duration-300 cursor-pointer" data-image="assets/images/service_incorporation.jpg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-555 flex items-center justify-center text-xs flex-shrink-0">
                                <i class="fa-solid fa-gauge-high"></i>
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-700">7-Days Incorporation</h3>
                        </div>
                        <i class="why-acc-chevron fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-300"></i>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="why-acc-content mt-0 text-xs text-slate-500 leading-relaxed overflow-hidden transition-all duration-300 max-h-0">
                        Our digitized MCA pipelines guarantee official name approvals in 24 hours and complete incorporation certificate delivery in under 7 business days.
                    </div>
                </div>

                <!-- Accordion Item 3 -->
                <div class="why-acc-item border border-slate-200/60 bg-white/60 hover:bg-white rounded-2xl p-6 transition-all duration-300 cursor-pointer" data-image="assets/images/hero_illustration.jpg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-555 flex items-center justify-center text-xs flex-shrink-0">
                                <i class="fa-solid fa-vault"></i>
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-700">Encrypted Document Vault</h3>
                        </div>
                        <i class="why-acc-chevron fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-300"></i>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="why-acc-content mt-0 text-xs text-slate-500 leading-relaxed overflow-hidden transition-all duration-300 max-h-0">
                        Manage business registration files, statutory registers, and director DSC keys inside our secure cloud vault with bank-grade encryption.
                    </div>
                </div>

                <!-- Accordion Item 4 -->
                <div class="why-acc-item border border-slate-200/60 bg-white/60 hover:bg-white rounded-2xl p-6 transition-all duration-300 cursor-pointer" data-image="assets/images/service_taxation.jpg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-555 flex items-center justify-center text-xs flex-shrink-0">
                                <i class="fa-solid fa-scale-balanced"></i>
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-700">100% Itemized Billing</h3>
                        </div>
                        <i class="why-acc-chevron fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-300"></i>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="why-acc-content mt-0 text-xs text-slate-500 leading-relaxed overflow-hidden transition-all duration-300 max-h-0">
                        Flat upfront packages. No hidden fees or sudden processing charges. We provide complete ledger breakdowns of government challans and fees.
                    </div>
                </div>

            </div>

            <!-- Right Side: Dynamic Image Display Panel (col-span-7) -->
            <div class="lg:col-span-7">
                <div class="relative rounded-3xl overflow-hidden border border-slate-200/60 aspect-[16/10] bg-slate-100">
                    <img id="why-choose-image" 
                         src="assets/images/hero_bg_5.jpg" 
                         alt="Zenvora Legal Dashboard" 
                         class="w-full h-full object-cover transition-all duration-500 scale-100 hover:scale-102">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 via-transparent to-transparent pointer-events-none"></div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Accordion Toggle & Live Image Swap JavaScript Logic -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const accItems = document.querySelectorAll('.why-acc-item');
        const displayImage = document.getElementById('why-choose-image');

        accItems.forEach(item => {
            item.addEventListener('click', () => {
                // Ignore clicks if already active
                if (item.classList.contains('active')) return;

                // Deactivate current active item
                const currentActive = document.querySelector('.why-acc-item.active');
                if (currentActive) {
                    currentActive.classList.remove('active', 'border-brand-500/30');
                    currentActive.classList.add('border-slate-200/60', 'bg-white/60');
                    
                    const activeContent = currentActive.querySelector('.why-acc-content');
                    activeContent.style.maxHeight = '0px';
                    activeContent.classList.remove('mt-4');

                    const activeIcon = currentActive.querySelector('.why-acc-chevron');
                    activeIcon.classList.remove('fa-chevron-up');
                    activeIcon.classList.add('fa-chevron-down');

                    const activeBrandIcon = currentActive.querySelector('.w-8');
                    activeBrandIcon.classList.remove('bg-brand-500/10', 'text-brand-500');
                    activeBrandIcon.classList.add('bg-slate-100', 'text-slate-555');

                    const activeHeading = currentActive.querySelector('h3');
                    activeHeading.classList.remove('text-slate-900');
                    activeHeading.classList.add('text-slate-700');
                }

                // Activate selected item
                item.classList.add('active', 'border-brand-500/30');
                item.classList.remove('border-slate-200/60', 'bg-white/60');

                const content = item.querySelector('.why-acc-content');
                content.style.maxHeight = content.scrollHeight + 'px';
                content.classList.add('mt-4');

                const icon = item.querySelector('.why-acc-chevron');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');

                const brandIcon = item.querySelector('.w-8');
                brandIcon.classList.add('bg-brand-500/10', 'text-brand-500');
                brandIcon.classList.remove('bg-slate-100', 'text-slate-555');

                const heading = item.querySelector('h3');
                heading.classList.remove('text-slate-700');
                heading.classList.add('text-slate-900');

                // Swap image smoothly (Fade out, swap source, fade in)
                const targetImageSrc = item.getAttribute('data-image');
                displayImage.classList.add('opacity-0');
                setTimeout(() => {
                    displayImage.src = targetImageSrc;
                    displayImage.classList.remove('opacity-0');
                }, 200);
            });
        });
    });
</script>
