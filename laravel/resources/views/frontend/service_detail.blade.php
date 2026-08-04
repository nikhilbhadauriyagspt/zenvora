@extends('layouts.app')

@section('title', $service->title . ' Registration | Zenvora Global Solutions')
@section('meta_description', 'Incorporate your ' . $service->title . ' in India. CA-assisted process, transparent government fees, 100% online setup.')
@section('meta_keywords', $service->title . ' Registration, Legal Compliance, Zenvora')

@section('body_class', 'subpage-theme')

@section('content')
<div class="py-12 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="lg:flex lg:items-center lg:justify-between border-b border-slate-800 pb-12">
            <div class="lg:w-2/3 space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brand-500/10 text-brand-400 border border-brand-500/20">
                    <i class="fa-solid fa-folder-open"></i> {{ $service->category->name }}
                </span>
                <h1 class="text-4xl sm:text-5xl font-black text-white leading-tight">
                    {{ $service->title }}
                </h1>
                <p class="text-lg text-slate-400 font-semibold max-w-2xl leading-relaxed">
                    {{ $service->tagline }}
                </p>
                <div class="flex flex-wrap items-center gap-6 pt-4 text-xs font-bold text-slate-300">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-tag text-brand-400"></i> Price Starts: {{ $service->starting_price }}</span>
                    <span class="flex items-center gap-2"><i class="fa-solid fa-clock text-brand-400"></i> Avg Duration: {{ $service->average_duration }}</span>
                </div>
            </div>
            
            <!-- Quick Inquiry Box -->
            <div class="mt-8 lg:mt-0 lg:w-1/3 max-w-sm w-full mx-auto">
                <div class="glass-card p-6 rounded-2xl relative overflow-hidden">
                    <h3 class="text-sm font-black text-slate-200 uppercase tracking-widest border-b border-slate-800 pb-2 mb-4">Quick Advisor Call</h3>
                    <form id="service-enquiry-form" method="POST" action="{{ route('enquiry.submit') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="service" value="{{ $service->title }} (Detail Page)">
                        <input type="hidden" name="org_size" value="1-10">
                        <input type="hidden" name="timeline" value="Immediate">
                        
                        <div>
                            <input type="text" name="name" required placeholder="Your Name" class="w-full text-xs font-semibold px-4 py-2.5 rounded-xl border border-slate-800 bg-slate-950 focus:outline-none focus:border-brand-500 text-white">
                        </div>
                        <div>
                            <input type="tel" name="phone" required placeholder="Phone Number" class="w-full text-xs font-semibold px-4 py-2.5 rounded-xl border border-slate-800 bg-slate-950 focus:outline-none focus:border-brand-500 text-white">
                        </div>
                        <div>
                            <input type="email" name="email" required placeholder="Email Address" class="w-full text-xs font-semibold px-4 py-2.5 rounded-xl border border-slate-800 bg-slate-950 focus:outline-none focus:border-brand-500 text-white">
                        </div>
                        <div>
                            <textarea name="message" rows="2" placeholder="Tell us about your requirements" class="w-full text-xs font-semibold px-4 py-2.5 rounded-xl border border-slate-800 bg-slate-950 focus:outline-none focus:border-brand-500 text-white"></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 rounded-xl text-xs font-bold text-white accent-gradient transition-all duration-300">
                            Book Free Call Back
                        </button>
                    </form>
                    <div id="service-form-status" class="mt-3 text-[11px] font-bold text-center hidden"></div>
                </div>
            </div>
        </div>

        <!-- Pillars Section (Core benefits) -->
        @if (!empty($service->pillars_json))
            <div class="py-12 border-b border-slate-800">
                <h2 class="text-sm font-extrabold uppercase text-slate-400 tracking-wider mb-8">Key Business Advantages</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($service->pillars_json as $pillar)
                        <div class="bg-slate-900 border border-slate-800/60 p-6 rounded-2xl">
                            <span class="w-10 h-10 rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-400 flex items-center justify-center text-sm mb-4">
                                <i class="{{ $pillar['icon'] ?? 'fa-solid fa-circle-check' }}"></i>
                            </span>
                            <h3 class="text-sm font-bold text-slate-100 mb-2">{{ $pillar['title'] }}</h3>
                            <p class="text-xs text-slate-450 leading-relaxed">{{ $pillar['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Steps Section (Process timeline) -->
        @if (!empty($service->steps_json))
            <div class="py-12 border-b border-slate-800">
                <h2 class="text-sm font-extrabold uppercase text-slate-400 tracking-wider mb-8">Detailed Setup Process</h2>
                <div class="relative pl-6 border-l-2 border-slate-800 space-y-8">
                    @foreach ($service->steps_json as $step)
                        <div class="relative space-y-2">
                            <span class="absolute -left-[35px] top-0 w-6 h-6 rounded-full bg-slate-950 border-2 border-brand-500 flex items-center justify-center text-[9px] font-bold text-brand-400">
                                {{ $step['number'] ?? '0' }}
                            </span>
                            <h3 class="text-sm font-bold text-slate-100">{{ $step['title'] }}</h3>
                            <p class="text-xs text-slate-450 leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Pricing Packages Section -->
        @if (!empty($service->pricing_packages_json))
            <div class="py-12 border-b border-slate-800">
                <h2 class="text-sm font-extrabold uppercase text-slate-400 tracking-wider mb-8">Transparent Packages</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($service->pricing_packages_json as $package)
                        <div class="bg-slate-900 border border-slate-800/80 p-6 rounded-3xl relative overflow-hidden flex flex-col justify-between">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-slate-200">{{ $package['name'] }}</h3>
                                    <span class="text-2xl font-black text-brand-400">{{ $package['price'] }}</span>
                                </div>
                                <p class="text-xs text-slate-450">{{ $package['desc'] ?? '' }}</p>
                            </div>
                            <div class="pt-6 mt-6 border-t border-slate-800/60">
                                <a href="{{ route('contact') }}?service={{ urlencode($service->title) }}&package={{ urlencode($package['name']) }}" class="block text-center w-full py-2.5 rounded-xl text-xs font-bold text-slate-900 bg-brand-400 hover:bg-brand-350 transition-colors">
                                    Select Package
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- FAQs Section -->
        @if (!empty($service->faqs_json))
            <div class="py-12">
                <h2 class="text-sm font-extrabold uppercase text-slate-400 tracking-wider mb-8">Frequently Asked Questions</h2>
                <div class="space-y-4">
                    @foreach ($service->faqs_json as $faq)
                        <div class="bg-slate-900 border border-slate-850 p-5 rounded-2xl">
                            <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2">
                                <span class="text-brand-400">Q.</span> {{ $faq['q'] }}
                            </h3>
                            <p class="text-xs text-slate-450 leading-relaxed mt-2 pl-4">
                                {{ $faq['a'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('service-enquiry-form');
        const statusBox = document.getElementById('service-form-status');

        if (form && statusBox) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                statusBox.classList.remove('hidden', 'text-green-500', 'text-red-500');
                statusBox.classList.add('text-brand-400');
                statusBox.textContent = 'Submitting...';

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
                        statusBox.classList.replace('text-brand-400', 'text-green-500');
                        statusBox.textContent = res.message;
                        form.reset();
                    } else {
                        statusBox.classList.replace('text-brand-400', 'text-red-500');
                        statusBox.textContent = res.message || 'Submission failed.';
                    }
                } catch (err) {
                    statusBox.classList.replace('text-brand-400', 'text-red-500');
                    statusBox.textContent = 'An error occurred. Please try again.';
                }
            });
        }
    });
</script>
@endsection
