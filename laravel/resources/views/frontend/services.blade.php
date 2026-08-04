@extends('layouts.app')

@section('title', 'Our Services | Zenvora Global Solutions')
@section('meta_description', "Browse Zenvora's full catalog of business startup formation, tax compliance, municipal licensing, trademark registration, and NGO setup services.")

@section('content')
<main>
    <!-- Hero Section -->
    <section class="relative py-28 bg-slate-50 border-b border-slate-100 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                <i class="fa-solid fa-layer-group text-[10px]"></i> Service Catalog
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none max-w-4xl mx-auto">
                Outsourced Compliance <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Pipelines & Deliverables.</span>
            </h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold max-w-2xl mx-auto">
                Select a category below to explore specific process checklists, deliverables, and guidelines managed directly by our panel of CAs and legal advisors.
            </p>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-24 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                @foreach ($categories as $idx => $cat)
                    @php
                        $desc = "Obtain professional CA/CS assistance for " . $cat->name . " registrations, approvals, and legal compliance.";
                        $deliverables = ['Official Registration Certificate', 'Complimentary CA consultation call', 'Government challan records'];
                        if (!$cat->services->isEmpty()) {
                            $firstSrv = $cat->services->first();
                            if ($firstSrv && !empty($firstSrv->deliverables_json)) {
                                $deliverables = array_slice($firstSrv->deliverables_json, 0, 3);
                            }
                        }
                    @endphp
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 flex flex-col justify-between hover:border-brand-500 transition-all duration-300">
                        <div class="space-y-6">
                            <!-- Image -->
                            <div class="relative w-full aspect-[16/10] bg-slate-100 rounded-2xl overflow-hidden border border-slate-100">
                                <img src="{{ asset($cat->image_url) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded">
                                    {{ sprintf("%02d", $idx + 1) }}. {{ strtoupper($cat->slug) }}
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2 text-left">
                                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="{{ $cat->icon }} text-brand-500 text-sm"></i> {{ $cat->name }}
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed font-semibold">
                                    {{ $desc }}
                                </p>
                            </div>

                            <!-- Services List -->
                            <div class="space-y-1 pt-4 border-t border-slate-100 text-left">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Available Setup Types:</span>
                                <div class="space-y-0.5">
                                    @if($cat->services->isEmpty())
                                        <span class="text-[11px] text-slate-450 font-semibold block italic py-2">No active services setup.</span>
                                    @endif
                                    @foreach ($cat->services as $srv)
                                        <a href="{{ route('services.detail', $srv->slug) }}" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors font-bold">
                                            <span>{{ $srv->title }}</span>
                                            <i class="fa-solid fa-chevron-right text-[8px] text-slate-450"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Deliverables Checklists -->
                            <div class="pt-4 border-t border-slate-100 space-y-3 text-left">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Deliverables Include:</span>
                                <ul class="space-y-2.5 text-xs text-slate-600 font-bold">
                                    @foreach ($deliverables as $deliv)
                                        <li class="flex items-start gap-2">
                                            <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                            <span>{{ $deliv }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div class="mt-8 pt-5 border-t border-slate-100">
                            <a href="{{ route('contact') }}?category={{ $cat->slug }}" class="block w-full text-center py-3 rounded-full text-[11px] font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                Inquire Details <i class="fa-solid fa-chevron-right ml-1.5 text-[9px] text-slate-450"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection
