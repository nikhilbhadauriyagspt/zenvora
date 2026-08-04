@extends('layouts.app')

@section('title', 'Contact Us | Zenvora Global Solutions')
@section('meta_description', 'Get in touch with Zenvora Global Solutions. Speak directly with CAs, CSs, and attorneys regarding company registrations, GST filings, and licensing.')

@section('content')
@php
    $contactAddresses = getWebAddresses();
    $hqDesk = !empty($contactAddresses) ? array_shift($contactAddresses) : ['label' => 'Noida Head Office', 'value' => 'Office Suite 508, Block A, The iThum Towers, Sector 62, Noida, Uttar Pradesh - 201301'];
    
    $contactPhones = getWebPhones();
    $firstPhoneVal = !empty($contactPhones) ? reset($contactPhones)['value'] : '+91 98765 43210';
@endphp

<main>
    <!-- Hero Section -->
    <section class="relative py-28 bg-slate-50 border-b border-slate-100 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                <i class="fa-solid fa-headset text-[10px]"></i> Advisory Desk
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none max-w-4xl mx-auto">
                Get in Touch. Speak <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Directly with a CA.</span>
            </h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold max-w-2xl mx-auto">
                Outsource your startup formation, licensing, and compliance tracking. Our qualified panel of Chartered Accountants and corporate attorneys is ready to call you back.
            </p>
        </div>
    </section>

    <!-- Main Contact & Offices Grid -->
    <section class="py-24 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left Column: Noida HQ, Regional Offices, & WhatsApp Support Card -->
                <div class="lg:col-span-5 space-y-8 text-left">
                    
                    <!-- Main Corporate Head Office Address & Integrated Map -->
                    <div class="space-y-4">
                        <span class="text-xs font-extrabold text-slate-400 uppercase tracking-widest block">Main Corporate Headquarters</span>
                        <div class="bg-slate-50/50 border border-slate-200 p-6 rounded-3xl space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-base flex-shrink-0">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-extrabold text-slate-900">{{ $hqDesk['label'] }}</h3>
                                    <p class="text-xs text-slate-500 mt-1 font-semibold leading-relaxed">
                                        {{ $hqDesk['value'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="border-t border-slate-200 pt-4 grid grid-cols-2 gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <span class="text-slate-400 block text-[9px] uppercase tracking-wider">Direct Hotline</span>
                                    <span class="text-slate-900 font-extrabold mt-0.5 block">{{ $firstPhoneVal }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[9px] uppercase tracking-wider">Help Email</span>
                                    <span class="text-slate-900 font-extrabold mt-0.5 block">{{ getWebSetting('email_1') }}</span>
                                </div>
                            </div>

                            <!-- Integrated Google Map Embed -->
                            <div class="border-t border-slate-200 pt-4">
                                <iframe src="{{ getWebSetting('map_iframe') }}" 
                                        width="100%" 
                                        height="200" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade"
                                        class="rounded-2xl border border-slate-200">
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Regional Advisory Desks -->
                    <div class="space-y-4">
                        <span class="text-xs font-extrabold text-slate-400 uppercase tracking-widest block">Regional Advisory Desks</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($contactAddresses as $regDesk)
                                <div class="bg-slate-50/50 border border-slate-200 p-5 rounded-2xl space-y-2">
                                    <h4 class="text-xs font-extrabold text-slate-900 flex items-center gap-2">
                                        <i class="fa-solid fa-building text-[10px] text-brand-500"></i> {{ $regDesk['label'] }}
                                    </h4>
                                    <p class="text-[10px] text-slate-500 leading-normal font-semibold">
                                        {{ $regDesk['value'] }}
                                    </p>
                                </div>
                            @endforeach
                            
                            <!-- Support Hours -->
                            <div class="bg-slate-50/50 border border-slate-200 p-5 rounded-2xl space-y-2">
                                <h4 class="text-xs font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-[10px] text-brand-500"></i> Support Hours
                                </h4>
                                <p class="text-[10px] text-slate-500 leading-normal font-semibold">
                                    {{ getWebSetting('working_hours') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Live WhatsApp Advisor Card -->
                    <div class="bg-white border border-slate-200 p-5 rounded-2xl flex items-center gap-4 text-left">
                        <img src="{{ asset('assets/images/about_us.jpg') }}" alt="Advisor" class="w-16 h-16 rounded-full object-cover border-2 border-brand-500/30 flex-shrink-0">
                        <div class="space-y-2 flex-grow">
                            <span class="text-xs font-extrabold text-slate-900 block leading-tight">Need immediate CA assistance?</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', getWebSetting('whatsapp_number')) }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-full text-[10px] font-black text-white bg-emerald-600 hover:bg-emerald-700 transition-colors w-full">
                                <i class="fa-brands fa-whatsapp text-xs"></i> WhatsApp Chat
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Consultation Schedule Form -->
                <div class="lg:col-span-7 bg-slate-50/50 border border-slate-200 p-6 sm:p-8 rounded-3xl">
                    <div class="mb-6 space-y-1.5 pb-4 border-b border-slate-200">
                        <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane text-brand-500"></i> Request a Call Back
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-semibold leading-relaxed">
                            Fill out the details below. A dedicated compliance CA or legal advisor will review your requirement and call you back within 15 minutes.
                        </p>
                    </div>
                    
                    <form id="contact-enquiry-form" method="POST" action="{{ route('enquiry.submit') }}" class="space-y-5 text-left">
                        @csrf
                        <input type="hidden" name="source_page" value="Contact Page">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Full Name</label>
                                <input type="text" name="name" required placeholder="Aarav Sharma" class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Phone Number</label>
                                <input type="tel" name="phone" required placeholder="+91 99999 88888" class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Email Address</label>
                                <input type="email" name="email" required placeholder="email@address.com" class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Target Setup Type</label>
                                <select name="service" class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none">
                                    <option value="General Query">General Query / Advisory Call</option>
                                    @foreach ($search_services as $s)
                                        <option value="{{ $s->title }}">{{ $s->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Organization Size</label>
                                <select name="org_size" class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none">
                                    <option value="1-10">1 - 10 Members (Startup)</option>
                                    <option value="10-50">10 - 50 Members (Medium)</option>
                                    <option value="50+">50+ Members (Enterprise)</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Timeline</label>
                                <select name="timeline" class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none">
                                    <option value="Immediate">Immediate (Within 7 days)</option>
                                    <option value="1 Month">Inside 30 Days</option>
                                    <option value="Planning">Just planning / research</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Requirement description</label>
                            <textarea name="message" rows="3" placeholder="Explain your target startup project or legal query..." class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none"></textarea>
                        </div>

                        <button type="submit" class="w-full py-4 rounded-xl text-xs font-bold text-white accent-gradient transition-all duration-300">
                            Book Free Advisory Consultation
                        </button>
                    </form>
                    <div id="contact-form-status" class="mt-4 text-xs font-bold text-center hidden"></div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('contact-enquiry-form');
        const statusBox = document.getElementById('contact-form-status');

        if (form && statusBox) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                statusBox.classList.remove('hidden', 'text-green-600', 'text-red-600');
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
                        statusBox.classList.replace('text-brand-500', 'text-red-600');
                        statusBox.textContent = res.message || 'Submission failed.';
                    }
                } catch (err) {
                    statusBox.classList.replace('text-brand-500', 'text-red-600');
                    statusBox.textContent = 'An error occurred. Please try again.';
                }
            });
        }
    });
</script>
@endsection
