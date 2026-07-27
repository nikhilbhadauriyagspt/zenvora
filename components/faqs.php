<!-- Zenvora Frequently Asked Questions Summary Widget (Home Page Component, 6 Key FAQs, No Shadows) -->
<section id="faqs" class="relative py-20 bg-slate-50 border-b border-slate-100 overflow-hidden">
    <!-- Subtle Background Decorators -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            
            <!-- Left Column: Title & Call to Action (col-span-4) -->
            <div class="lg:col-span-4 space-y-6 text-left">
                <div class="space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-circle-info text-[9px]"></i> FAQ Summary
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Frequently Asked <br>Questions.
                    </h2>
                    <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                        A quick summary of our 6 most common client enquiries. Click the directory button to browse all categories.
                    </p>
                </div>

                <!-- Advisory Help Card with Lady Representative Photo -->
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

                <!-- View All FAQs standalone link -->
                <div class="bg-white border border-slate-200/60 p-5 rounded-2xl text-left space-y-3">
                    <span class="text-xs font-bold text-slate-900 block">Looking for more answers?</span>
                    <a href="faqs.php" class="inline-flex items-center justify-center gap-1.5 w-full text-center py-2.5 rounded-full text-[11px] font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                        View All FAQs <i class="fa-solid fa-arrow-right text-[10px] text-slate-400"></i>
                    </a>
                </div>
            </div>

            <!-- Right Column: Short Accordion Stack (col-span-8 - Exactly 6 items to maintain perfect balance) -->
            <div class="lg:col-span-8 space-y-4">
                
                <!-- FAQ Item 1 -->
                <div class="faq-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-sm font-extrabold text-slate-900">How long does the Private Limited registration process take?</h3>
                        <div class="faq-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                            <i class="fa-solid fa-plus transition-transform duration-300"></i>
                        </div>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="faq-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                        <p class="pt-3 border-t border-slate-100/60 mt-3">
                            The complete registration cycle usually takes 5 to 7 business days. This timeframe is dependent on government verification cycles and includes name approval, MoA/AoA submission, and certificate of incorporation issuance by the MCA.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-sm font-extrabold text-slate-900">What documents are required to start a company setup?</h3>
                        <div class="faq-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                            <i class="fa-solid fa-plus transition-transform duration-300"></i>
                        </div>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="faq-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                        <p class="pt-3 border-t border-slate-100/60 mt-3">
                            To begin, directors need to provide passport-size photographs, PAN cards, Aadhaar cards (or Voter ID/Passport), and bank statements/utility bills as identity/address proofs. For the registered corporate office address, a utility bill along with a No Objection Certificate (NOC) from the property owner is needed.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-sm font-extrabold text-slate-900">Are there any hidden costs or billing surcharges?</h3>
                        <div class="faq-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                            <i class="fa-solid fa-plus transition-transform duration-300"></i>
                        </div>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="faq-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                        <p class="pt-3 border-t border-slate-100/60 mt-3">
                            No. Zenvora operates with absolute pricing transparency. All professional packages are charged upfront, and official government payment receipts (MCA, GSTN, MSME, Trademark challans) are logged directly to your account.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="faq-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-sm font-extrabold text-slate-900">When is GST registration mandatory for a business?</h3>
                        <div class="faq-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                            <i class="fa-solid fa-plus transition-transform duration-300"></i>
                        </div>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="faq-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                        <p class="pt-3 border-t border-slate-100/60 mt-3">
                            GST registration is mandatory if your annual aggregate turnover exceeds ₹40 Lakhs for goods suppliers (₹20 Lakhs for North-Eastern states) or ₹20 Lakhs for service providers. Regardless of turnover, it is mandatory if you engage in e-commerce, inter-state trade, or sell via digital aggregators.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-sm font-extrabold text-slate-900">Can I register my home address as the corporate office?</h3>
                        <div class="faq-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                            <i class="fa-solid fa-plus transition-transform duration-300"></i>
                        </div>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="faq-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                        <p class="pt-3 border-t border-slate-100/60 mt-3">
                            Yes. The Ministry of Corporate Affairs allows residential properties (including rented houses) to be used as registered corporate office addresses. All you need is a utility bill and an NOC from the owner.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="faq-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="text-sm font-extrabold text-slate-900">How do I get in touch with my assigned CA advisory panel?</h3>
                        <div class="faq-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                            <i class="fa-solid fa-plus transition-transform duration-300"></i>
                        </div>
                    </div>
                    <!-- Collapsible Content -->
                    <div class="faq-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                        <p class="pt-3 border-t border-slate-100/60 mt-3">
                            Once you select a service pack, Zenvora automatically assigns a dedicated qualified Chartered Accountant (CA) or corporate lawyer to your file. You get direct mobile hotline access and a dedicated WhatsApp group for real-time document reviews.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- Simple Accordion JS Toggle Logic -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            item.addEventListener('click', () => {
                const content = item.querySelector('.faq-content');
                const icon = item.querySelector('.faq-icon i');
                const isOpen = !content.classList.contains('overflow-hidden') || content.style.maxHeight !== '0px' && content.style.maxHeight !== '';

                // Close all other FAQs first
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        const otherContent = otherItem.querySelector('.faq-content');
                        const otherIcon = otherItem.querySelector('.faq-icon i');
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
                    // Expand smoothly to its scroll height
                    content.style.maxHeight = content.scrollHeight + 'px';
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus', 'rotate-[180deg]');
                    item.classList.remove('border-slate-200/60');
                    item.classList.add('border-brand-500/40');
                }
            });
        });
    });
</script>
