@extends('layouts.app')

@section('title', 'Frequently Asked Questions | Zenvora Global Solutions')
@section('meta_description', 'Search and browse frequently asked questions about startup registrations, tax compliance, municipal licensing, trademarks, and NGO setups in India.')

@section('content')
@php
    $categoriesList = \App\Models\ServiceCategory::orderBy('sort_order', 'asc')->get();
    
    $allFaqs = [];
    $servicesList = \App\Models\Service::with('category')->get();
    foreach ($servicesList as $service) {
        $faqs_arr = $service->faqs_json;
        if (is_array($faqs_arr)) {
            foreach ($faqs_arr as $faq) {
                if (!empty($faq['q']) && !empty($faq['a'])) {
                    $allFaqs[] = [
                        'question' => $faq['q'],
                        'answer' => $faq['a'],
                        'service_title' => $service->title,
                        'category_slug' => $service->category->slug ?? '',
                        'category_name' => $service->category->name ?? ''
                    ];
                }
            }
        }
    }

    // Fallback if no database records
    if (empty($allFaqs)) {
        $allFaqs = [
            [
                'question' => 'How long does the Private Limited registration process take?',
                'answer' => 'The complete registration cycle usually takes 5 to 7 business days. This timeframe is dependent on government verification cycles and includes name approval, MoA/AoA submission, and certificate of incorporation issuance by the MCA.',
                'service_title' => 'Pvt Ltd Registration',
                'category_slug' => 'business-startup',
                'category_name' => 'Business Startup Setup'
            ],
            [
                'question' => 'What is the minimum capital required to register a Private Limited company?',
                'answer' => 'There is no minimum authorized capital requirement mandated by the Ministry of Corporate Affairs (MCA) to start a Private Limited company in India. You can begin incorporation with an authorized share capital of even ₹10,000.',
                'service_title' => 'Pvt Ltd Registration',
                'category_slug' => 'business-startup',
                'category_name' => 'Business Startup Setup'
            ]
        ];
    }
@endphp

<main>
    <!-- Hero Section -->
    <section class="relative py-24 bg-slate-50 border-b border-slate-100 overflow-hidden">
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
                       class="w-full text-xs sm:text-sm font-semibold pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-full focus:border-brand-500 focus:outline-none shadow-none">
            </div>
        </div>
    </section>

    <!-- Main FAQs Area -->
    <section class="py-24 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left Column: Filtering Tabs -->
                <div class="lg:col-span-4 space-y-6 text-left lg:sticky lg:top-24">
                    <div class="bg-slate-50/50 border border-slate-200/50 p-5 rounded-2xl space-y-3">
                        <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest block mb-1">Filter Categories</span>
                        
                        <button class="faq-filter-btn active w-full text-left text-xs font-black uppercase tracking-wider py-2.5 px-3.5 rounded-lg transition-all flex items-center justify-between bg-brand-500/10 text-brand-700 border border-brand-500/20" data-category="all">
                            <span>All Categories</span>
                            <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </button>
                        
                        @foreach ($categoriesList as $cat)
                            <button class="faq-filter-btn w-full text-left text-xs font-black uppercase tracking-wider py-2.5 px-3.5 rounded-lg transition-all flex items-center justify-between text-slate-650 hover:bg-slate-100 border border-transparent" data-category="{{ $cat->slug }}">
                                <span>{{ $cat->name }}</span>
                                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </button>
                        @endforeach
                    </div>

                    <!-- Live WhatsApp Support Card -->
                    <div class="bg-white border border-slate-200/60 p-5 rounded-2xl flex items-center gap-4 text-left">
                        <img src="{{ asset('assets/images/about_us.jpg') }}" alt="Advisor" class="w-16 h-16 rounded-full object-cover border-2 border-brand-500/30 flex-shrink-0">
                        <div class="space-y-2 flex-grow">
                            <span class="text-xs font-extrabold text-slate-900 block leading-tight">Need immediate CA assistance?</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', getWebSetting('whatsapp_number')) }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-full text-[10px] font-black text-white bg-emerald-600 hover:bg-emerald-700 transition-colors w-full">
                                <i class="fa-brands fa-whatsapp text-xs"></i> WhatsApp Chat
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Accordions -->
                <div class="lg:col-span-8 space-y-4" id="faq-accordions-container">
                    @foreach ($allFaqs as $faqItem)
                        <div class="faq-page-item border border-slate-200/60 bg-white rounded-2xl p-5 transition-all duration-300 cursor-pointer" data-category="{{ $faqItem['category_slug'] }}">
                            <div class="flex items-center justify-between gap-4">
                                <div class="space-y-1 text-left">
                                    <span class="text-[9px] font-black text-brand-600 uppercase tracking-widest block">
                                        {{ $faqItem['service_title'] }} &bull; {{ $faqItem['category_name'] }}
                                    </span>
                                    <h3 class="text-sm font-extrabold text-slate-900">{{ $faqItem['question'] }}</h3>
                                </div>
                                <div class="faq-page-icon w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center text-xs flex-shrink-0 transition-colors">
                                    <i class="fa-solid fa-plus transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div class="faq-page-content overflow-hidden transition-all duration-350 max-h-0 text-xs text-slate-500 leading-relaxed mt-0">
                                <p class="pt-3 border-t border-slate-100/60 mt-3 text-left">
                                    {!! nl2br(e($faqItem['answer'])) !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const faqItems = document.querySelectorAll('.faq-page-item');
        const filterBtns = document.querySelectorAll('.faq-filter-btn');
        const searchInput = document.getElementById('faq-search-input');

        // Accordion Toggle
        faqItems.forEach(item => {
            item.addEventListener('click', () => {
                const content = item.querySelector('.faq-page-content');
                const icon = item.querySelector('.faq-page-icon i');
                const isOpen = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';

                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.querySelector('.faq-page-content').style.maxHeight = '0px';
                        otherItem.querySelector('.faq-page-icon i').className = 'fa-solid fa-plus transition-transform duration-300';
                        otherItem.classList.remove('border-brand-500/65');
                    }
                });

                if (isOpen) {
                    content.style.maxHeight = '0px';
                    icon.className = 'fa-solid fa-plus transition-transform duration-300';
                    item.classList.remove('border-brand-500/65');
                } else {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    icon.className = 'fa-solid fa-minus transition-transform duration-300 rotate-180';
                    item.classList.add('border-brand-500/65');
                }
            });
        });

        // Search & Category Filtering
        function filterFaqs() {
            const query = searchInput.value.toLowerCase().trim();
            const activeFilter = document.querySelector('.faq-filter-btn.active').getAttribute('data-category');

            faqItems.forEach(item => {
                const itemCat = item.getAttribute('data-category');
                const title = item.querySelector('h3').textContent.toLowerCase();
                const content = item.querySelector('.faq-page-content').textContent.toLowerCase();
                
                const matchesCategory = (activeFilter === 'all' || itemCat === activeFilter);
                const matchesSearch = (title.includes(query) || content.includes(query));

                if (matchesCategory && matchesSearch) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                    item.querySelector('.faq-page-content').style.maxHeight = '0px';
                    item.querySelector('.faq-page-icon i').className = 'fa-solid fa-plus transition-transform duration-300';
                    item.classList.remove('border-brand-500/65');
                }
            });
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                filterBtns.forEach(b => {
                    b.className = 'faq-filter-btn w-full text-left text-xs font-black uppercase tracking-wider py-2.5 px-3.5 rounded-lg transition-all flex items-center justify-between text-slate-650 hover:bg-slate-100 border border-transparent';
                });
                btn.className = 'faq-filter-btn active w-full text-left text-xs font-black uppercase tracking-wider py-2.5 px-3.5 rounded-lg transition-all flex items-center justify-between bg-brand-500/10 text-brand-700 border border-brand-500/20';
                filterFaqs();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', filterFaqs);
        }
    });
</script>
@endsection
