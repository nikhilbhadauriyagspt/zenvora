<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Zenvora Global Solutions | Premium Legal, Tax & Compliance Partner')</title>
    <link rel="icon" type="image/png" href="{{ asset(getWebSetting('favicon')) }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Zenvora Global Solutions is your premier partner for business setup, company registration, compliance, and growth.')">
    <meta name="keywords" content="@yield('meta_keywords', 'Company Registration, GST Filing, Trademark, compliance')">

    <!-- Google Fonts - Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fdfbf7',
                            100: '#f9f3e6',
                            200: '#f1e2c5',
                            300: '#e5ca97',
                            400: '#d7ac63',
                            500: '#bc8731', // Gold from logo
                            600: '#a36d26',
                            700: '#83521d',
                            800: '#693f18',
                            900: '#573316',
                            950: '#321c0b',
                        },
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['"Space Grotesk"', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(25px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Utilities styling -->
    <style type="text/css">
        .subpage-theme {
            background-color: #020617 !important;
            color: #cbd5e1 !important;
        }
        
        .subpage-theme main,
        .subpage-theme section,
        .subpage-theme section.bg-white,
        .subpage-theme section.bg-slate-50,
        .subpage-theme section.bg-slate-100,
        .subpage-theme section.bg-slate-900,
        .subpage-theme section.bg-gradient-to-br {
            background-color: #020617 !important;
            background-image: none !important;
            border-color: #1e293b !important;
        }
        
        .subpage-theme h1,
        .subpage-theme h2,
        .subpage-theme h3,
        .subpage-theme h4,
        .subpage-theme h5,
        .subpage-theme h6,
        .subpage-theme .text-slate-900,
        .subpage-theme .text-slate-800,
        .subpage-theme .text-slate-700 {
            color: #ffffff !important;
        }
        
        .subpage-theme p,
        .subpage-theme li,
        .subpage-theme label,
        .subpage-theme .text-slate-500,
        .subpage-theme .text-slate-650 {
            color: #94a3b8 !important;
        }
        
        .subpage-theme .text-brand-500,
        .subpage-theme .text-brand-600,
        .subpage-theme .text-brand-700,
        .subpage-theme .text-brand-850 {
            color: #d7ac63 !important;
        }
        
        .subpage-theme .bg-brand-500\/10,
        .subpage-theme .bg-brand-500\/20 {
            background-color: rgba(215, 172, 99, 0.1) !important;
            border-color: rgba(215, 172, 99, 0.2) !important;
            color: #d7ac63 !important;
        }

        .subpage-theme .bg-white,
        .subpage-theme .bg-slate-50,
        .subpage-theme .bg-slate-100,
        .subpage-theme .bg-slate-900 {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        
        .subpage-theme .bg-slate-100 {
            background-color: #020617 !important;
        }
        
        .subpage-theme .border-slate-100,
        .subpage-theme .border-slate-200 {
            border-color: #1e293b !important;
        }
        
        .subpage-theme input,
        .subpage-theme select,
        .subpage-theme textarea {
            background-color: #020617 !important;
            border-color: #1e293b !important;
            color: #f1f5f9 !important;
        }

        html {
            scrollbar-width: thin;
            scrollbar-color: #bc8731 #090f1d;
        }
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        ::-webkit-scrollbar-track {
            background: #090f1d;
        }
        ::-webkit-scrollbar-thumb {
            background: #bc8731;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d7ac63;
        }

        .glass-panel {
            background: rgba(9, 15, 29, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 40px -10px rgba(188, 135, 49, 0.15);
        }
        
        .accent-gradient {
            background: linear-gradient(135deg, #bc8731 0%, #d7ac63 100%);
        }

        @keyframes sectionGlow {
            0%, 100% { outline: 0px solid transparent; box-shadow: none; }
            50% { outline: 4px solid #bc8731; box-shadow: 0 0 35px rgba(188, 135, 49, 0.5); }
        }
        .glow-section {
            animation: sectionGlow 2.5s ease-in-out forwards;
            border-radius: 1.5rem;
        }

        /* Hero Slider Ken Burns background zoom */
        @keyframes kenBurns {
            0% { transform: scale(1); }
            100% { transform: scale(1.06); }
        }
        .active-slide .hero-bg-img {
            animation: kenBurns 7.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        /* Staggered slide elements entry transitions */
        .carousel-slide {
            transition: opacity 1000ms ease-in-out;
        }
        .carousel-slide .slide-badge {
            transform: translateY(12px);
            opacity: 0;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease;
            transition-delay: 100ms;
        }
        .carousel-slide .slide-title {
            transform: translateY(18px);
            opacity: 0;
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.7s ease;
            transition-delay: 220ms;
        }
        .carousel-slide .slide-points {
            transform: translateY(22px);
            opacity: 0;
            transition: transform 0.75s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.75s ease;
            transition-delay: 350ms;
        }
        .carousel-slide .slide-buttons {
            transform: translateY(25px);
            opacity: 0;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.8s ease;
            transition-delay: 480ms;
        }

        /* Trigger animations when slide becomes active */
        .carousel-slide.active-slide .slide-badge,
        .carousel-slide.active-slide .slide-title,
        .carousel-slide.active-slide .slide-points,
        .carousel-slide.active-slide .slide-buttons {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans selection:bg-brand-100 selection:text-brand-900 overflow-x-hidden @yield('body_class')">

    <!-- Top Contact Bar -->
    <div class="accent-gradient text-white py-2 text-xs border-b border-brand-600 relative z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
            <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-1 font-bold">
                @php
                    $phones = getWebPhones();
                    $firstPhone = !empty($phones) ? reset($phones) : ['label' => 'Hotline', 'value' => '+91 98765 43210'];
                @endphp
                <a href="tel:{{ $firstPhone['value'] }}" class="hover:text-slate-950 transition-colors flex items-center gap-1.5 text-white drop-shadow-sm">
                    <i class="fa-solid fa-phone text-white text-[11px]"></i>
                    {{ $firstPhone['value'] }}
                </a>
                <a href="mailto:{{ getWebSetting('email_1') }}" class="hover:text-slate-950 transition-colors flex items-center gap-1.5 text-white drop-shadow-sm">
                    <i class="fa-solid fa-envelope text-white text-[11px]"></i>
                    {{ getWebSetting('email_1') }}
                </a>
            </div>
            <div class="flex items-center gap-5">
                <span class="hidden md:inline-flex items-center gap-1.5 text-white/90 font-bold drop-shadow-sm">
                    <i class="fa-solid fa-clock text-white/90 text-[11px]"></i>
                    {{ getWebSetting('working_hours') }}
                </span>
                <div class="flex items-center gap-3.5 text-white drop-shadow-sm">
                    <a href="{{ getWebSetting('social_facebook') }}" target="_blank" class="hover:text-slate-950 transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ getWebSetting('social_twitter') }}" target="_blank" class="hover:text-slate-950 transition-colors"><i class="fa-brands fa-twitter"></i></a>
                    <a href="{{ getWebSetting('social_linkedin') }}" target="_blank" class="hover:text-slate-950 transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="{{ getWebSetting('social_instagram') }}" target="_blank" class="hover:text-slate-950 transition-colors"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Navigation Bar -->
    <header class="sticky top-0 left-0 right-0 z-40 transition-all duration-300 glass-panel" id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <img class="h-20 w-auto" src="{{ asset(getWebSetting('logo_url')) }}" alt="Zenvora Logo">
                    </a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ route('home') }}" class="text-slate-300 hover:text-brand-400 px-3 py-2 rounded-md text-sm font-bold transition-colors">Home</a>
                    
                    <!-- Services Dropdown (Megamenu) -->
                    <div class="group static">
                        <a href="{{ route('services.index') }}" class="text-slate-300 hover:text-brand-400 px-3 py-2 rounded-md text-sm font-bold transition-colors flex items-center gap-1 group/btn">
                            Services
                            <i class="fa-solid fa-chevron-down text-[9px] text-slate-400 group-hover/btn:text-brand-400 group-hover:rotate-180 transition-transform duration-300"></i>
                        </a>

                        <div class="absolute left-0 right-0 w-full mt-2 bg-slate-950 border-y border-slate-800 shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 z-50">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-12 gap-8 text-left">
                                @foreach ($nav_categories as $n_cat)
                                    <div class="col-span-12 sm:col-span-6 lg:col-span-3 space-y-4">
                                        <h3 class="text-xs font-extrabold text-brand-400 hover:text-brand-300 uppercase tracking-widest border-b border-slate-800 pb-2 transition-colors">
                                            <a href="{{ route('services.index') }}#{{ $n_cat->slug }}" class="block flex items-center justify-between">
                                                <span>{{ $n_cat->name }}</span>
                                                <i class="fa-solid fa-chevron-right text-[8px] opacity-75"></i>
                                            </a>
                                        </h3>
                                        <div class="space-y-3">
                                            @if($n_cat->services->isEmpty())
                                                <span class="text-[10px] text-slate-500 font-semibold block italic">Coming soon...</span>
                                            @endif
                                            @foreach ($n_cat->services as $n_srv)
                                                <a href="{{ route('services.detail', $n_srv->slug) }}" class="flex items-start gap-2.5 text-slate-300 hover:text-brand-400 transition-colors group/link">
                                                    <i class="fa-solid fa-circle-check text-slate-600 group-hover/link:text-brand-500 mt-0.5 text-xs"></i>
                                                    <span class="text-xs font-semibold">{{ $n_srv->title }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('about') }}" class="text-slate-300 hover:text-brand-400 px-3 py-2 rounded-md text-sm font-bold transition-colors">About Us</a>
                    <a href="{{ route('blog.index') }}" class="text-slate-300 hover:text-brand-400 px-3 py-2 rounded-md text-sm font-bold transition-colors">Blog</a>
                    <a href="{{ route('faqs') }}" class="text-slate-300 hover:text-brand-400 px-3 py-2 rounded-md text-sm font-bold transition-colors">FAQs</a>
                    <a href="{{ route('contact') }}" class="text-slate-300 hover:text-brand-400 px-3 py-2 rounded-md text-sm font-bold transition-colors">Contact Us</a>
                </nav>

                <!-- Call to Action -->
                <div class="hidden md:flex items-center gap-3">
                    <div class="relative w-40 lg:w-48 focus-within:w-60 transition-all duration-300">
                        <input type="text" id="site-search" placeholder="Search services..."
                            class="w-full text-[10px] font-semibold pl-8 pr-3 py-2 border border-slate-800 rounded-full focus:outline-none focus:border-brand-500 bg-slate-900 focus:bg-slate-950 text-slate-200 transition-all">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-[10px]"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <div id="search-results" class="absolute right-0 top-full mt-2 w-72 bg-slate-900 border border-slate-800 rounded-2xl shadow-xl hidden z-50 p-2 text-left space-y-0.5"></div>
                    </div>

                    <a href="{{ route('contact') }}" class="px-5 py-3 rounded-full text-xs font-bold text-white accent-gradient hover:shadow-lg hover:shadow-brand-500/10 transition-all duration-300 hover:-translate-y-0.5">Free Consultation</a>
                    <button type="button" id="mega-drawer-toggle" class="p-2.5 rounded-full border border-slate-800 hover:border-brand-500 text-slate-300 hover:text-brand-400 hover:bg-slate-900 transition-colors flex items-center justify-center focus:outline-none">
                        <i class="fa-solid fa-bars-staggered text-sm"></i>
                    </button>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-400 hover:text-brand-400 hover:bg-slate-900 focus:outline-none">
                        <svg class="block h-6 w-6" id="menu-icon-open" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="hidden h-6 w-6" id="menu-icon-close" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div class="hidden md:hidden border-t border-slate-800 bg-slate-950 shadow-xl" id="mobile-menu">
            <div class="px-4 pt-3 pb-6 space-y-4 max-h-[85vh] overflow-y-auto">
                <div class="relative px-3 py-1">
                    <input type="text" id="site-search-mobile" placeholder="Search services..."
                        class="w-full text-xs font-semibold pl-9 pr-3 py-2.5 border border-slate-800 rounded-full focus:outline-none focus:border-brand-500 bg-slate-900 focus:bg-slate-950 text-slate-200 transition-all">
                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-500 text-[11px]"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <div id="search-results-mobile" class="absolute left-3 right-3 top-full mt-1 bg-slate-900 border border-slate-800 rounded-xl shadow-lg hidden z-50 p-2 text-left space-y-0.5"></div>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-bold text-slate-200 hover:bg-slate-900 rounded-lg">Home</a>
                    <a href="{{ route('services.index') }}" class="block px-3 py-2 text-base font-bold text-slate-200 hover:bg-slate-900 rounded-lg">Services</a>
                    <a href="{{ route('about') }}" class="block px-3 py-2 text-base font-bold text-slate-200 hover:bg-slate-900 rounded-lg">About Us</a>
                    <a href="{{ route('blog.index') }}" class="block px-3 py-2 text-base font-bold text-slate-200 hover:bg-slate-900 rounded-lg">Blog</a>
                    <a href="{{ route('faqs') }}" class="block px-3 py-2 text-base font-bold text-slate-200 hover:bg-slate-900 rounded-lg">FAQs</a>
                    <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-bold text-slate-200 hover:bg-slate-900 rounded-lg">Contact Us</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Full-Screen Drawer Overlay -->
    <div id="mega-drawer" class="fixed inset-0 w-screen h-screen bg-slate-900 z-[100] transition-all duration-500 ease-in-out transform -translate-y-full opacity-0 pointer-events-none flex flex-col justify-between overflow-y-auto">
        <div class="w-full border-b border-brand-600 accent-gradient flex-shrink-0 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-24 flex items-center justify-between gap-4">
                <div class="bg-slate-950 px-5 py-2 rounded-2xl border border-white/10">
                    <img class="h-14 w-auto object-contain" src="{{ asset(getWebSetting('logo_url')) }}" alt="Logo">
                </div>
                <div class="hidden md:flex items-center gap-8 text-white">
                    @foreach ($phones as $hp)
                        <a href="tel:{{ $hp['value'] }}" class="flex items-center gap-2.5 text-sm font-bold hover:text-slate-950 transition-colors">
                            <span class="w-8 h-8 rounded-lg bg-slate-950 text-brand-400 flex items-center justify-center text-xs"><i class="fa-solid fa-phone"></i></span>
                            <div class="text-left leading-none">
                                <span class="text-[9px] text-white/70 font-bold block mb-0.5 uppercase tracking-wider">{{ $hp['label'] }}</span>
                                <span>{{ $hp['value'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
                <button type="button" id="mega-drawer-close" class="w-12 h-12 rounded-full border border-white/10 text-white bg-slate-950 hover:bg-slate-900 transition-all duration-300 flex items-center justify-center focus:outline-none text-xl group">
                    <i class="fa-solid fa-xmark group-hover:rotate-90 transition-transform duration-300"></i>
                </button>
            </div>
        </div>

        <div class="flex-grow overflow-y-auto py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col h-full justify-start">
                <div class="grid grid-cols-12 gap-12 items-start w-full">
                    <div class="col-span-4 flex flex-col space-y-4 pr-8 border-r border-slate-800">
                        <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2 px-1">Service Categories</span>
                        @foreach ($nav_categories as $t_idx => $t_cat)
                            <button class="drawer-tab-btn {{ $t_idx === 0 ? 'active text-brand-400' : 'text-slate-300 hover:text-white' }} text-left text-lg font-bold transition-all flex items-center justify-between" data-target="drawer-tab-{{ $t_cat->slug }}">
                                <span>{{ $t_cat->name }}</span>
                                <i class="fa-solid fa-arrow-right text-xs transition-all"></i>
                            </button>
                        @endforeach
                    </div>

                    <div class="col-span-8 relative min-h-[380px]">
                        @foreach ($nav_categories as $t_idx => $t_cat)
                            <div class="drawer-tab-content {{ $t_idx === 0 ? 'block' : 'hidden' }} transition-all duration-300" id="drawer-tab-{{ $t_cat->slug }}">
                                <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-6">{{ $t_cat->name }} Services Directory</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($t_cat->services as $srv)
                                        <a href="{{ route('services.detail', $srv->slug) }}" class="p-3 bg-slate-900 border border-slate-800 hover:border-brand-500 rounded-xl block transition-all group">
                                            <span class="text-xs font-bold text-slate-200 group-hover:text-brand-400 block">{{ $srv->title }}</span>
                                            <span class="text-[10px] text-slate-500 mt-1 block leading-tight">{{ $srv->tagline }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Yield -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="relative bg-slate-900 text-slate-400 text-xs py-16 border-t border-slate-800 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-slate-800 items-start">
                <div class="md:col-span-4 space-y-4 text-left">
                    <img class="h-16 w-auto object-contain" src="{{ asset(getWebSetting('logo_url')) }}" alt="Zenvora Logo">
                    <p class="text-slate-500 leading-relaxed">Streamlined, software-enabled corporate compliance and subsidiary management advisory panels.</p>
                </div>
                <div class="md:col-span-8 grid grid-cols-2 sm:grid-cols-3 gap-6 text-left">
                    <div>
                        <h4 class="font-extrabold uppercase text-slate-200 tracking-wider mb-3">Links</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                            <li><a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                            <li><a href="{{ route('faqs') }}" class="hover:text-white transition-colors">FAQs</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-extrabold uppercase text-slate-200 tracking-wider mb-3">Contact</h4>
                        <ul class="space-y-2 text-slate-500">
                            <li>Email: {{ getWebSetting('email_1') }}</li>
                            <li>Hours: {{ getWebSetting('working_hours') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center text-slate-600 text-[10px]">
                &copy; {{ date('Y') }} {{ getWebSetting('APP_NAME', 'Zenvora Global Solutions') }}. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Global Javascript Modules -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mega Drawer togglers
            const toggleBtn = document.getElementById('mega-drawer-toggle');
            const closeBtn = document.getElementById('mega-drawer-close');
            const drawer = document.getElementById('mega-drawer');

            if (toggleBtn && drawer) {
                toggleBtn.addEventListener('click', () => {
                    drawer.classList.remove('-translate-y-full', 'opacity-0', 'pointer-events-none');
                    drawer.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
                });
            }
            if (closeBtn && drawer) {
                closeBtn.addEventListener('click', () => {
                    drawer.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
                    drawer.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
                });
            }

            // Mega Drawer category tab swapper
            const tabButtons = document.querySelectorAll('.drawer-tab-btn');
            const tabContents = document.querySelectorAll('.drawer-tab-content');

            tabButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    tabButtons.forEach(b => b.classList.remove('active', 'text-brand-400'));
                    tabContents.forEach(c => c.classList.replace('block', 'hidden'));

                    btn.classList.add('active', 'text-brand-400');
                    const targetId = btn.getAttribute('data-target');
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.replace('hidden', 'block');
                    }
                });
            });

            // Dynamic Search Engine Autocomplete list
            const searchIndex = [
                { url: "{{ route('about') }}", title: 'About Zenvora', desc: 'Expert corporate compliance panels', keys: ['about', 'history', 'lawyer', 'legal'] },
                { url: "{{ route('faqs') }}", title: 'Faqs Directory', desc: 'Frequently asked questions', keys: ['faqs', 'help', 'question'] },
                { url: "{{ route('contact') }}", title: 'Contact Us / Support Desk', desc: 'Inquiry forms and location desk details', keys: ['contact', 'email', 'phone'] },
                @foreach($search_services as $s_item)
                    { url: "{{ route('services.detail', $s_item->slug) }}", title: "{{ $s_item->title }}", desc: "{{ $s_item->tagline }}", keys: ['service', "{{ strtolower($s_item->title) }}"] },
                @endforeach
            ];

            const searchInput = document.getElementById('site-search');
            const resultsBox = document.getElementById('search-results');

            if (searchInput && resultsBox) {
                searchInput.addEventListener('input', () => {
                    const query = searchInput.value.toLowerCase().trim();
                    if (query === '') {
                        resultsBox.classList.add('hidden');
                        return;
                    }
                    const matches = searchIndex.filter(item => {
                        return item.title.toLowerCase().includes(query) || 
                               item.desc.toLowerCase().includes(query) || 
                               item.keys.some(k => k.includes(query));
                    });

                    if (matches.length === 0) {
                        resultsBox.innerHTML = '<div class="p-3 text-[10px] text-slate-500 font-bold text-center">No results found</div>';
                    } else {
                        resultsBox.innerHTML = matches.slice(0, 5).map(match => `
                            <a href="${match.url}" class="block p-2.5 hover:bg-slate-800 rounded-xl transition-colors">
                                <span class="text-[11px] font-extrabold text-slate-200 block">${match.title}</span>
                                <span class="text-[9px] text-slate-500 block truncate">${match.desc}</span>
                            </a>
                        `).join('');
                    }
                    resultsBox.classList.remove('hidden');
                });

                searchInput.addEventListener('blur', () => setTimeout(() => resultsBox.classList.add('hidden'), 200));
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
