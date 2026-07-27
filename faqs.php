<?php
// Standalone FAQs Directory Page for Zenvora Global Solutions
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions | Zenvora Global Solutions</title>
    <meta name="description" content="Search and browse frequently asked questions about startup registrations, tax compliance, municipal licensing, trademarks, and NGO setups in India.">
    
    <!-- Load Head dependencies (Tailwind CDN, Fonts, Font Awesome) -->
    <?php include_once 'components/head.php'; ?>
</head>

<body class="bg-white font-sans text-slate-600 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Global Header Navigation -->
    <?php include_once 'components/header.php'; ?>

    <main>
        
        <!-- Hero Section -->
        <section class="relative py-24 bg-slate-50 border-b border-slate-100 overflow-hidden">
            <!-- Subtle Grid Background -->
            <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                    <i class="fa-solid fa-circle-question text-[10px]"></i> Help Center
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none max-w-4xl mx-auto">
                    Frequently Asked <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Questions Directory.</span>
                </h1>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold max-w-2xl mx-auto">
                    Search or browse through our comprehensive compliance directory to get answers on incorporation, accounting, licensing, and corporate law.
                </p>
                
                <!-- Search Box -->
                <div class="max-w-xl mx-auto mt-8 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                    </div>
                    <input type="text" id="faq-search-input" placeholder="Search compliance questions (e.g. GST, Trademark, OPC)..." 
                           class="w-full text-xs sm:text-sm font-semibold pl-11 pr-4 py-3.5 bg-white border border-slate-250 rounded-full focus:border-brand-500 focus:outline-none transition-colors shadow-none">
                </div>
            </div>
        </section>

        <!-- Main FAQs Area (Categories Tab + Accordion Grid) -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                    
                    <!-- Left Column: Filtering Tabs & Representative Card (col-span-4) -->
                    <div class="lg:col-span-4 space-y-6 text-left lg:sticky lg:top-24">
                        <div class="bg-slate-50/50 border border-slate-200/50 p-5 rounded-2xl space-y-3">
                            <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest block mb-1">Filter Categories</span>
                            
                            <!-- Category Filter Buttons -->
                            <button class="faq-filter-btn active w-full text-left text-xs font-black uppercase tracking-wider py-2.5 px-3.5 rounded-lg transition-all flex items-center justify-between bg-brand-500/10 text-brand-700 border border-brand-500/20" data-category="all">
                                <span>All Categories</span>
                                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </button>
                            <button class="faq-filter-btn w-full text-left text-xs font-black uppercase tracking-wider py-2.5 px-3.5 rounded-lg transition-all flex items-center justify-between text-slate-600 hover:bg-slate-100 border border-transparent" data-category="startup">
                                <span>Business Startup</span>
                                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </button>
                            <button class="faq-filter-btn w-full text-left text-xs font-black uppercase tracking-wider py-2.5 px-3.5 rounded-lg transition-all flex items-center justify-between text-slate-600 hover:bg-slate-100 border border-transparent" data-category="tax">
                                <span>Tax & GST</span>
                                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </button>
                            <button class="faq-filter-btn w-full text-left text-xs font-black uppercase tracking-wider py-2.5 px-3.5 rounded-lg transition-all flex items-center justify-between text-slate-600 hover:bg-slate-100 border border-transparent" data-category="licenses">
                                <span>Licenses & IPR</span>
                                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </button>
                            <button class="faq-filter-btn w-full text-left text-xs font-black uppercase tracking-wider py-2.5 px-3.5 rounded-lg transition-all flex items-center justify-between text-slate-600 hover:bg-slate-100 border border-transparent" data-category="ngo">
                                <span>NGO & Trust</span>
                                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </button>
                        </div>

                        <!-- Support Representative Info Card -->
                        <div class="bg-white border border-slate-200/60 p-5 rounded-2xl flex items-center gap-4 text-left">
                            <img src="assets/images/about_us.jpg" 
                                 alt="Priyanka Sharma Zenvora Advisor" 
                                 class="w-16 h-16 rounded-full object-cover border-2 border-brand-500/30 flex-shrink-0">
                            <div class="space-y-2 flex-grow">
                                <span class="text-xs font-extrabold text-slate-900 block leading-tight">Need immediate CA assistance?</span>
                                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', getWebSetting('whatsapp_number')); ?>" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-full text-[10px] font-black text-white bg-emerald-600 hover:bg-emerald-700 transition-colors w-full">
                                    <i class="fa-brands fa-whatsapp text-xs"></i> WhatsApp Chat
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Accordions (col-span-8) -->
                    <div class="lg:col-span-8 space-y-4" id="faq-accordions-container">
                        
                        <!-- FAQ 1 (Startup) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="startup">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">How long does the Private Limited registration process take?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    The complete registration cycle usually takes 5 to 7 business days. This timeframe is dependent on government verification cycles and includes name approval, MoA/AoA submission, and certificate of incorporation issuance by the MCA.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 2 (Startup) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="startup">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">What is the minimum capital required to register a Private Limited company?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    There is no minimum authorized capital requirement mandated by the Ministry of Corporate Affairs (MCA) to start a Private Limited company in India. You can begin incorporation with an authorized share capital of even ₹10,000.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 3 (Startup) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="startup">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">Can a single person register a corporate entity in India?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    Yes. Under the Companies Act, a single founder can register a One Person Company (OPC), which provides corporate status and limited liability. Alternatively, you can start a Sole Proprietorship if you do not want incorporation status.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 4 (Tax) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="tax">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">When is GST registration mandatory for a business?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    GST registration is mandatory if your annual aggregate turnover exceeds ₹40 Lakhs for goods suppliers (₹20 Lakhs for North-Eastern states) or ₹20 Lakhs for service providers. Regardless of turnover, it is mandatory if you engage in e-commerce, inter-state trade, or sell via digital aggregators.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 5 (Tax) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="tax">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">What is the penalty for late filing of monthly GST returns?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    The government charges a late fee of ₹50 per day (₹20 per day for Nil returns) for late filings of GSTR-3B and GSTR-1. In addition, an interest of 18% per annum is applicable on the outstanding tax liability amount if paid after the due date.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 6 (Tax) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="tax">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">How often do I need to file corporate Income Tax Returns (ITR)?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    All registered companies (Pvt Ltd, OPC, Section 8) must file their Income Tax Return (ITR-6) annually, even if there was zero commercial transaction during the fiscal year. The due date is usually October 31st for audited corporations.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 7 (Licenses) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="licenses">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">Who needs an FSSAI Food License, and what are its types?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    Any food business operator (FBO) involved in manufacturing, processing, packaging, distributing, or selling food items needs FSSAI registration. It is graded into three types: Basic registration (turnover under ₹12 Lakhs), State License (turnover between ₹12 Lakhs and ₹20 Crores), and Central License (turnover above ₹20 Crores).
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 8 (Licenses) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="licenses">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">Can I use the 'TM' symbol immediately after filing a trademark?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    Yes. Once your trademark application is successfully filed with the IPR Registry and an application number is generated, you can legally start using the "TM" symbol beside your logo or brand name. You can only use the registered "®" symbol after the trademark certificate is issued.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 9 (Licenses) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="licenses">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">What is an ISO Certification, and how does it benefit my startup?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    ISO certification (like ISO 9001:2015 for Quality Management Systems) certifies that your company operates under standardized operational controls. It improves vendor onboarding rates, makes your company eligible to bid for government tenders, and enhances global client trust.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 10 (NGO) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="ngo">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">What is a Section 8 Company, and how does it differ from a Trust?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    A Section 8 Company is registered under the Central Companies Act with the MCA, offering high transparency, a corporate structure, and limited liability (perfect for CSR funding). A Trust is created under state trust deeds and registered with local Sub-Registrars under provincial laws, typically involving simpler compliance.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 11 (NGO) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="ngo">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">What are 12A and 80G registrations, and why does my NGO need them?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    12A registration exempts the NGO's surplus income from annual taxation under the Income Tax Act. 80G registration allows donors (individuals/corporates) to claim up to a 50% tax deduction on their donations, making it highly attractive for securing sponsorships and donations.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ 12 (NGO) -->
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="ngo">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-sm font-extrabold text-slate-900">What is NITI Aayog Darpan registration?</h3>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3">
                                    NGO Darpan is a portal operated by NITI Aayog that assigns a unique ID tracking system to NGOs. Registration is mandatory to apply for any central government grants, CSR funding from public sector undertakings, or central welfare schemes.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer Navigation -->
    <?php include_once 'components/footer.php'; ?>

    <!-- FAQ Search and Filter JS Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const faqItems = document.querySelectorAll('.faq-page-item');
            const filterBtns = document.querySelectorAll('.faq-filter-btn');
            const searchInput = document.getElementById('faq-search-input');

            // 1. Accordion Toggle Logic
            faqItems.forEach(item => {
                item.addEventListener('click', () => {
                    const content = item.querySelector('.faq-page-content');
                    const icon = item.querySelector('.faq-page-icon i');
                    const isOpen = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';

                    // Close other active visible FAQs
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            const otherContent = otherItem.querySelector('.faq-page-content');
                            const otherIcon = otherItem.querySelector('.faq-page-icon i');
                            otherContent.style.maxHeight = '0px';
                            otherIcon.classList.remove('fa-minus', 'rotate-[180deg]');
                            otherIcon.classList.add('fa-plus');
                            otherItem.classList.remove('border-brand-500/40');
                            otherItem.classList.add('border-slate-200/60');
                        }
                    });

                    // Toggle selected FAQ
                    if (isOpen) {
                        content.style.maxHeight = '0px';
                        icon.classList.remove('fa-minus', 'rotate-[180deg]');
                        icon.classList.add('fa-plus');
                        item.classList.remove('border-brand-500/40');
                        item.classList.add('border-slate-200/60');
                    } else {
                        content.style.maxHeight = content.scrollHeight + 'px';
                        icon.classList.remove('fa-plus');
                        icon.classList.add('fa-minus', 'rotate-[180deg]');
                        item.classList.remove('border-slate-200/60');
                        item.classList.add('border-brand-500/40');
                    }
                });
            });

            // 2. Filter Tab Logic
            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Reset active class on buttons
                    filterBtns.forEach(b => {
                        b.classList.remove('active', 'bg-brand-500/10', 'text-brand-700', 'border-brand-500/20');
                        b.classList.add('text-slate-600', 'border-transparent');
                    });

                    // Activate clicked button
                    btn.classList.add('active', 'bg-brand-500/10', 'text-brand-700', 'border-brand-500/20');
                    btn.classList.remove('text-slate-600', 'border-transparent');

                    const category = btn.getAttribute('data-category');

                    // Filter items
                    filterAndSearch(category, searchInput.value.trim().toLowerCase());
                });
            });

            // 3. Live Search Input Logic
            searchInput.addEventListener('input', () => {
                const activeBtn = document.querySelector('.faq-filter-btn.active');
                const category = activeBtn ? activeBtn.getAttribute('data-category') : 'all';
                const query = searchInput.value.trim().toLowerCase();

                filterAndSearch(category, query);
            });

            // Unified filter and search handler
            function filterAndSearch(category, query) {
                faqItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    const question = item.querySelector('h3').textContent.toLowerCase();
                    const answer = item.querySelector('.faq-page-content p').textContent.toLowerCase();
                    
                    const matchesCategory = (category === 'all' || itemCategory === category);
                    const matchesSearch = (question.includes(query) || answer.includes(query));

                    // Close accordion details first to prevent visual bugs
                    const content = item.querySelector('.faq-page-content');
                    const icon = item.querySelector('.faq-page-icon i');
                    content.style.maxHeight = '0px';
                    icon.classList.remove('fa-minus', 'rotate-[180deg]');
                    icon.classList.add('fa-plus');
                    item.classList.remove('border-brand-500/40');
                    item.classList.add('border-slate-200/60');

                    if (matchesCategory && matchesSearch) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
