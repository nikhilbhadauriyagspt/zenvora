@extends('layouts.app')

@section('title', 'About Us | Zenvora Global Solutions')
@section('meta_description', 'Learn about Zenvora Global Solutions, our mission, vision, history, and the qualified CA panel behind our premium compliance infrastructure.')

@section('content')
@php
    $timeline = json_decode(getWebSetting('about_timeline_milestones'), true) ?? [];
    $accreditations = json_decode(getWebSetting('about_accreditations_badges'), true) ?? [];
    $techFeatures = json_decode(getWebSetting('about_tech_features'), true) ?? [];
    $values = json_decode(getWebSetting('about_values_list'), true) ?? [];
    $advisors = json_decode(getWebSetting('about_advisors_list'), true) ?? [];
@endphp

<main>
    <!-- Hero Section -->
    <section class="relative py-28 bg-slate-50 border-b border-slate-100 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                <i class="fa-solid fa-building text-[10px]"></i> Our Identity
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none max-w-4xl mx-auto">
                {!! getWebSetting('about_hero_title') !!}
            </h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold max-w-2xl mx-auto">
                {{ getWebSetting('about_hero_subtitle') }}
            </p>
        </div>
    </section>

    <!-- Story Split Section -->
    <section class="py-24 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <div class="lg:col-span-6 relative">
                    <div class="absolute inset-0 border border-brand-500/30 rounded-[3rem] rounded-tr-none rounded-bl-none translate-x-4 translate-y-4"></div>
                    <div class="relative rounded-[3rem] rounded-tr-none rounded-bl-none overflow-hidden aspect-[4/3] bg-slate-100 border border-slate-200">
                        <img src="{{ asset(getWebSetting('about_purpose_image')) }}" alt="Zenvora Work" class="w-full h-full object-cover">
                    </div>
                </div>

                <div class="lg:col-span-6 space-y-6 text-left">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-bullseye text-[9px]"></i> {{ getWebSetting('about_purpose_badge') }}
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ getWebSetting('about_purpose_title') }}
                    </h2>
                    <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                        {{ getWebSetting('about_purpose_desc') }}
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                        <div class="space-y-2">
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 flex items-center gap-2">
                                <i class="{{ getWebSetting('about_vision_icon') }} text-brand-500"></i> {{ getWebSetting('about_vision_title') }}
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                {{ getWebSetting('about_vision_desc') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 flex items-center gap-2">
                                <i class="{{ getWebSetting('about_mission_icon') }} text-brand-500"></i> {{ getWebSetting('about_mission_title') }}
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                {{ getWebSetting('about_mission_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Zig-Zag Timeline -->
    <section class="py-24 bg-slate-50 border-b border-slate-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl text-left mb-20 space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                    <i class="fa-solid fa-timeline text-[9px]"></i> {{ getWebSetting('about_timeline_badge') }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ getWebSetting('about_timeline_title') }}
                </h2>
                <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                    {{ getWebSetting('about_timeline_desc') }}
                </p>
            </div>

            <div class="relative w-full max-w-5xl mx-auto mt-16">
                <div class="absolute left-1/2 top-0 bottom-0 w-0.5 bg-slate-200 -translate-x-1/2 hidden md:block"></div>
                <div class="space-y-16 relative">
                    @foreach ($timeline as $idx => $milestone)
                        @php $isEven = ($idx % 2 === 0); @endphp
                        <div class="flex flex-col md:flex-row items-center justify-between relative group">
                            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-4.5 h-4.5 rounded-full border-2 border-brand-500 bg-white group-hover:bg-brand-500 transition-colors z-20 hidden md:block"></div>
                            
                            @if ($isEven)
                                <div class="w-full md:w-[45%] text-left md:text-right pr-0 md:pr-10 space-y-2">
                                    <span class="text-xs font-bold text-brand-600 block md:hidden">{{ $milestone['year'] }}</span>
                                    <h3 class="text-base font-extrabold text-slate-900">{{ $milestone['title'] }}</h3>
                                    <p class="text-xs text-slate-500 font-semibold leading-relaxed">{{ $milestone['desc'] }}</p>
                                </div>
                                <div class="w-full md:w-[45%] text-left md:pl-10 hidden md:block">
                                    <span class="text-3xl font-black text-slate-300 group-hover:text-brand-500 transition-colors tracking-widest">{{ $milestone['year'] }}</span>
                                </div>
                            @else
                                <div class="w-full md:w-[45%] text-right pr-10 hidden md:block">
                                    <span class="text-3xl font-black text-slate-300 group-hover:text-brand-500 transition-colors tracking-widest">{{ $milestone['year'] }}</span>
                                </div>
                                <div class="w-full md:w-[45%] text-left pl-0 md:pl-10 space-y-2">
                                    <span class="text-xs font-bold text-brand-650 block md:hidden">{{ $milestone['year'] }}</span>
                                    <h3 class="text-base font-extrabold text-slate-900">{{ $milestone['title'] }}</h3>
                                    <p class="text-xs text-slate-500 font-semibold leading-relaxed">{{ $milestone['desc'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Accreditations -->
    <section class="py-20 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="max-w-2xl mx-auto space-y-3">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">{{ getWebSetting('about_accreditations_badge') }}</span>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ getWebSetting('about_accreditations_title') }}</h3>
                <p class="text-slate-500 text-xs font-semibold leading-relaxed">{{ getWebSetting('about_accreditations_desc') }}</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                @foreach ($accreditations as $acc)
                    <div class="bg-slate-50/50 border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="{{ $acc['icon'] }} text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">{{ $acc['title'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Leadership Section -->
    @if(!empty($advisors))
        <section class="py-24 bg-slate-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl text-left mb-16 space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-users text-[9px]"></i> {{ getWebSetting('about_advisors_badge') }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ getWebSetting('about_advisors_title') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($advisors as $adv)
                        <div class="bg-white rounded-3xl p-5 border border-slate-200/50 group hover:border-brand-500/30 transition-all duration-300">
                            <div class="relative w-full aspect-square rounded-2xl overflow-hidden mb-4 bg-slate-100">
                                <img src="{{ asset($adv['image']) }}" alt="{{ $adv['name'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            <div class="text-left space-y-1">
                                <h3 class="text-sm font-extrabold text-slate-900">{{ $adv['name'] }}</h3>
                                <span class="text-[10px] text-brand-600 font-extrabold uppercase tracking-wider block">{{ $adv['role'] }}</span>
                                <p class="text-xs text-slate-500 leading-normal pt-2 border-t border-slate-100 mt-2 font-medium">
                                    {{ $adv['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>
@endsection
