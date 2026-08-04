@extends('layouts.app')

@section('title', 'Zenvora Global Solutions | Premium Legal, Tax & Compliance Partner')

@section('content')
<!-- Slider Hero Section (Dark Theme, Space Grotesk Font, Font Awesome Icons) -->
<section class="relative h-[550px] sm:h-[650px] lg:h-[92vh] min-h-[500px] sm:min-h-[720px] w-full overflow-hidden bg-slate-950 flex items-center">
    <!-- Carousel Slides Wrapper -->
    <div class="relative w-full h-full flex items-center" id="hero-carousel">
        @php
            $heroSlides = getWebSlides();
        @endphp
        @foreach ($heroSlides as $idx => $slide)
            @php $isActive = ($idx === 0); @endphp
            <!-- Slide {{ $idx + 1 }}: {{ $slide['badge'] }} -->
            <div class="carousel-slide absolute inset-0 w-full h-full {{ $isActive ? 'opacity-100 z-10 active-slide' : 'opacity-0 pointer-events-none z-0' }} transition-opacity duration-1000 ease-in-out flex items-center" data-index="{{ $idx }}">
                <!-- Background Image -->
                <div class="absolute inset-0 bg-cover bg-center hero-bg-img" style="background-image: url('{{ asset($slide['image']) }}');"></div>
                <!-- Slide Dark Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/80 to-transparent"></div>
                <!-- Glowing Gold Orb -->
                <div class="absolute top-1/4 left-[8%] w-80 h-80 rounded-full bg-brand-500/10 blur-[130px] pointer-events-none animate-pulse-slow"></div>
                
                <!-- Slide Content -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-20">
                    <div class="max-w-3xl space-y-4 md:space-y-8 text-left">
                        <span class="slide-badge inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] sm:text-xs font-extrabold bg-brand-500/10 border border-brand-500/30 text-brand-400 tracking-wider uppercase">
                            <i class="fa-solid fa-rocket mr-1 text-[8px] sm:text-[10px]"></i> {{ $slide['badge'] }}
                        </span>
                        
                        <h1 class="slide-title text-3xl sm:text-4xl lg:text-6xl font-extrabold text-slate-50 leading-tight tracking-tight">
                            {!! $slide['title'] !!}
                        </h1>
                        
                        <!-- Points Layout -->
                        <div class="slide-points grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl pt-2 hidden sm:grid">
                            <!-- Point 1 -->
                            <div class="glass-card p-4 rounded-xl border border-slate-800/80 flex flex-col items-start space-y-3 hover:-translate-y-1 hover:border-brand-500/40 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300 cursor-pointer">
                                <div class="w-10 h-10 rounded-lg bg-brand-500/15 text-brand-400 flex items-center justify-center text-base">
                                    <i class="{{ $slide['p1_icon'] }}"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-100">{{ $slide['p1_title'] }}</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $slide['p1_desc'] }}</p>
                                </div>
                            </div>

                            <!-- Point 2 -->
                            <div class="glass-card p-4 rounded-xl border border-slate-800/80 flex flex-col items-start space-y-3 hover:-translate-y-1 hover:border-brand-500/40 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300 cursor-pointer">
                                <div class="w-10 h-10 rounded-lg bg-brand-500/15 text-brand-400 flex items-center justify-center text-base">
                                    <i class="{{ $slide['p2_icon'] }}"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-100">{{ $slide['p2_title'] }}</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $slide['p2_desc'] }}</p>
                                </div>
                            </div>

                            <!-- Point 3 -->
                            <div class="glass-card p-4 rounded-xl border border-slate-800/80 flex flex-col items-start space-y-3 hover:-translate-y-1 hover:border-brand-500/40 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300 cursor-pointer">
                                <div class="w-10 h-10 rounded-lg bg-brand-500/15 text-brand-400 flex items-center justify-center text-base">
                                    <i class="{{ $slide['p3_icon'] }}"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-100">{{ $slide['p3_title'] }}</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $slide['p3_desc'] }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Highlights -->
                        <div class="slide-points flex flex-wrap items-center gap-x-3.5 gap-y-1.5 sm:hidden text-slate-300 text-[10px] font-extrabold pt-1">
                            <span class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-brand-500 text-[9px]"></i> {{ $slide['p1_title'] }}</span>
                            <span class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-brand-500 text-[9px]"></i> {{ $slide['p2_title'] }}</span>
                            <span class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-brand-500 text-[9px]"></i> {{ $slide['p3_title'] }}</span>
                        </div>

                        @if (!empty($slide['btn1_text']) || !empty($slide['btn2_text']))
                            <div class="slide-buttons flex items-center gap-2.5 pt-2">
                                @if (!empty($slide['btn1_text']))
                                    <a href="{{ $slide['btn1_url'] ?? '#' }}" class="px-4 py-2.5 rounded-full text-[10px] sm:text-sm sm:px-7 sm:py-3.5 font-bold text-white accent-gradient hover:shadow-lg hover:shadow-brand-500/25 transition-all duration-300 hover:-translate-y-0.5">
                                        {{ $slide['btn1_text'] }}
                                    </a>
                                @endif
                                @if (!empty($slide['btn2_text']))
                                    <a href="{{ $slide['btn2_url'] ?? '#' }}" class="px-4 py-2.5 rounded-full text-[10px] sm:text-sm sm:px-7 sm:py-3.5 font-bold text-slate-200 bg-slate-900/60 border border-slate-800/80 shadow-sm hover:bg-slate-850 hover:text-white hover:border-brand-500/40 transition-all duration-300 font-bold">
                                        {{ $slide['btn2_text'] }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Carousel Controls -->
    <div class="absolute bottom-10 sm:bottom-28 right-8 z-30 flex items-center gap-3">
        <button id="carousel-prev" class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-900/80 border border-slate-800 text-slate-300 hover:text-brand-400 hover:bg-slate-850 shadow-sm transition-all duration-200 focus:outline-none" aria-label="Previous slide">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button id="carousel-next" class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-900/80 border border-slate-800 text-slate-300 hover:text-brand-400 hover:bg-slate-850 shadow-sm transition-all duration-200 focus:outline-none" aria-label="Next slide">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <!-- Sleek Floating Trust Logo Strip -->
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 w-[92%] max-w-7xl z-20 bg-slate-950/75 backdrop-blur-xl border border-slate-900/80 py-4 px-6 rounded-2xl hidden md:block shadow-xl shadow-black/40">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-brand-500 animate-pulse"></span>
                <span class="text-xs font-extrabold text-slate-200 uppercase tracking-widest">Government Approved Registrations:</span>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-2 text-xs sm:text-[13px] font-extrabold text-slate-400">
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-building text-brand-500 text-sm"></i> {{ getWebSetting('badge_mca') }}</span>
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-receipt text-brand-500 text-sm"></i> {{ getWebSetting('badge_gst') }}</span>
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-briefcase text-brand-500 text-sm"></i> {{ getWebSetting('badge_msme') }}</span>
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-flag text-brand-500 text-sm"></i> {{ getWebSetting('badge_dpiit') }}</span>
                <span class="flex items-center gap-2 hover:text-white transition-colors"><i class="fa-solid fa-utensils text-brand-500 text-sm"></i> {{ getWebSetting('badge_fssai') }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
        <div class="space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brand-500/10 text-brand-500 border border-brand-500/20">
                Our Services
            </span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900">Explore Compliance Solutions</h2>
            <p class="text-slate-500 max-w-xl mx-auto text-sm">Select a category below to view specific registration workflows, cost lists, and legal deliverables.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <div class="bg-slate-50 border border-slate-200/50 p-6 rounded-3xl hover:border-brand-300 transition-all text-left space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="w-12 h-12 rounded-2xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-lg">
                            <i class="{{ $category->icon }}"></i>
                        </span>
                        <span class="text-[10px] font-bold text-slate-400 border border-slate-200 px-2 py-0.5 rounded uppercase">{{ $category->services->count() }} Items</span>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-base font-extrabold text-slate-900">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Dynamic filings and certifications under the {{ $category->name }} board guidelines.</p>
                    </div>
                    <div class="space-y-2.5 pt-2 border-t border-slate-200/60">
                        @foreach($category->services->take(4) as $service)
                            <a href="{{ route('services.detail', $service->slug) }}" class="flex items-center justify-between group/link text-xs font-bold text-slate-700 hover:text-brand-600 transition-colors">
                                <span>{{ $service->title }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px] opacity-0 group-hover/link:opacity-100 transition-all transform -translate-x-1 group-hover/link:translate-x-0"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Trust Metrics Section -->
<section class="py-20 bg-slate-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div class="space-y-2">
            <span class="text-3xl sm:text-4xl font-black text-brand-400">{{ getWebSetting('stat_ops_count') }}</span>
            <p class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">{{ getWebSetting('stat_ops_label') }}</p>
        </div>
        <div class="space-y-2">
            <span class="text-3xl sm:text-4xl font-black text-brand-400">{{ getWebSetting('stat_accuracy_count') }}</span>
            <p class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">{{ getWebSetting('stat_accuracy_label') }}</p>
        </div>
        <div class="space-y-2">
            <span class="text-3xl sm:text-4xl font-black text-brand-400">{{ getWebSetting('stat_panel_count') }}</span>
            <p class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">{{ getWebSetting('stat_panel_label') }}</p>
        </div>
        <div class="space-y-2">
            <span class="text-3xl sm:text-4xl font-black text-brand-400">{{ getWebSetting('stat_speed_count') }}</span>
            <p class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">{{ getWebSetting('stat_speed_label') }}</p>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section id="contact" class="py-20 bg-slate-50 border-t border-slate-200/50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
        <div class="space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brand-500/10 text-brand-500 border border-brand-500/20">
                Book Consultation
            </span>
            <h2 class="text-3xl font-black text-slate-900">Request a CA Call Back</h2>
            <p class="text-slate-500 text-xs font-semibold">Our Chartered Accountants will evaluate your checklist files and call you in under 15 minutes.</p>
        </div>

        <div class="bg-white border border-slate-200/60 p-8 rounded-3xl shadow-xl shadow-slate-100 text-left">
            <form id="homepage-enquiry-form" method="POST" action="{{ route('enquiry.submit') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-2">Full Name</label>
                        <input type="text" name="name" required class="w-full text-xs font-bold px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 bg-slate-50">
                    </div>
                    <div>
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-2">Phone Number</label>
                        <input type="tel" name="phone" required class="w-full text-xs font-bold px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 bg-slate-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-2">Email Address</label>
                        <input type="email" name="email" required class="w-full text-xs font-bold px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 bg-slate-50">
                    </div>
                    <div>
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-2">Service Required</label>
                        <select name="service" required class="w-full text-xs font-bold px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 bg-slate-50">
                            <option value="General Query">General Query / Advisory Call</option>
                            @foreach($search_services as $s)
                                <option value="{{ $s->title }}">{{ $s->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-2">Organization Size</label>
                        <select name="org_size" class="w-full text-xs font-bold px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 bg-slate-50">
                            <option value="1-10">1 - 10 Members (Startup)</option>
                            <option value="10-50">10 - 50 Members (Medium)</option>
                            <option value="50+">50+ Members (Enterprise)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-2">Launch Timeline</label>
                        <select name="timeline" class="w-full text-xs font-bold px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 bg-slate-50">
                            <option value="Immediate">Immediate (Within 7 days)</option>
                            <option value="1 Month">Inside 30 Days</option>
                            <option value="Planning">Just planning / research</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-2">Message or Requirement Description</label>
                    <textarea name="message" rows="3" placeholder="Explain your target startup project or legal query..." class="w-full text-xs font-bold px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 bg-slate-50"></textarea>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl text-xs font-bold text-white accent-gradient transition-all duration-300">
                    Book Free Consultation
                </button>
            </form>
            <div id="homepage-form-status" class="mt-4 text-xs font-bold text-center hidden"></div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('homepage-enquiry-form');
        const statusBox = document.getElementById('homepage-form-status');

        if (form && statusBox) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                statusBox.classList.remove('hidden', 'text-green-600', 'text-red-650');
                statusBox.classList.add('text-brand-500');
                statusBox.textContent = 'Submitting your request...';

                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const res = await response.json();
                    if (res.success) {
                        statusBox.classList.replace('text-brand-500', 'text-green-600');
                        statusBox.textContent = res.message;
                        form.reset();
                    } else {
                        statusBox.classList.replace('text-brand-500', 'text-red-650');
                        statusBox.textContent = res.message || 'Submission failed.';
                    }
                } catch (err) {
                    statusBox.classList.replace('text-brand-500', 'text-red-650');
                    statusBox.textContent = 'An error occurred. Please try again.';
                }
            });
        }

        // 2. Carousel Slide Logic
        const slides = document.querySelectorAll('.carousel-slide');
        const prevBtn = document.getElementById('carousel-prev');
        const nextBtn = document.getElementById('carousel-next');
        
        if (slides.length > 0) {
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
        }
    });
</script>
@endsection
