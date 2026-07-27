<?php
// Standalone About Us Page for Zenvora Global Solutions
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Zenvora Global Solutions</title>
    <meta name="description" content="Learn about Zenvora Global Solutions, our mission, vision, history, and the qualified CA panel behind our premium compliance infrastructure.">
    
    <!-- Load Head dependencies (Tailwind CDN, Fonts, Font Awesome) -->
    <?php include_once 'components/head.php'; ?>
</head>

<body class="bg-white font-sans text-slate-600 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Global Header Navigation -->
    <?php include_once 'components/header.php'; ?>

    <main>
        
        <!-- Hero Section -->
        <section class="relative py-28 bg-slate-50 border-b border-slate-100 overflow-hidden">
            <!-- Subtle Grid Background -->
            <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                    <i class="fa-solid fa-building text-[10px]"></i> Our Identity
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none max-w-4xl mx-auto">
                    We Are Redefining <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Compliance Infrastructure.</span>
                </h1>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold max-w-2xl mx-auto">
                    Zenvora replaces slow legal delays with streamlined, digitized compliance pipelines. We empower modern founders to scale legally without a dedicated in-house compliance team.
                </p>
            </div>
        </section>

        <!-- Our Story & Mission Split Section (No Shadows) -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    
                    <!-- Left Column: Visual Leaf Frame Image -->
                    <div class="lg:col-span-6 relative">
                        <!-- Curved Organic Frame (Leaf Shape) with Gold Offset Frame -->
                        <div class="absolute inset-0 border border-brand-500/30 rounded-[3rem] rounded-tr-none rounded-bl-none translate-x-4 translate-y-4"></div>
                        <div class="relative rounded-[3rem] rounded-tr-none rounded-bl-none overflow-hidden aspect-[4/3] bg-slate-100 border border-slate-200">
                            <img src="assets/images/hero_illustration.jpg" 
                                 alt="Zenvora 3D Corporate Compliance Workspace" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Right Column: Mission Content -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                            <i class="fa-solid fa-bullseye text-[9px]"></i> Our Purpose
                        </span>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            Built for finance teams operating internationally.
                        </h2>
                        <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                            Founded in 2018, Zenvora Global Solutions began with a simple belief: registering a company, filing taxes, and managing global subsidiaries shouldn't require weeks of document exchanges and confusing government portals.
                        </p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                            <div class="space-y-2">
                                <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-eye text-brand-500"></i> Our Vision
                                </h4>
                                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                    To create a global operations platform that handles entity management, indirect tax, and transfer pricing across all jurisdictions automatically.
                                </p>
                            </div>
                            <div class="space-y-2">
                                <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-compass text-brand-500"></i> Our Mission
                                </h4>
                                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                    To provide transparent pricing, rapid MCA name approvals, and direct access to qualified CAs for maximum filing accuracy.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Balanced Zig-Zag Timeline Section (Resolves Empty Space Issue) -->
        <section class="py-24 bg-slate-50 border-b border-slate-100 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="max-w-3xl text-left mb-20 space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-timeline text-[9px]"></i> Our Timeline
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        How We Grew to Support 1,200+ Startups
                    </h2>
                    <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                        A quick look at Zenvora's milestone milestones and structural expansion.
                    </p>
                </div>

                <!-- Balanced Zig-Zag Timeline Container -->
                <div class="relative w-full max-w-5xl mx-auto mt-16">
                    <!-- Central Vertical Axis Line (Visible on desktop) -->
                    <div class="absolute left-1/2 top-0 bottom-0 w-0.5 bg-slate-200 -translate-x-1/2 hidden md:block"></div>

                    <div class="space-y-16 relative">
                        
                        <!-- Milestone 1: 2018 (Content Left, Year Right) -->
                        <div class="flex flex-col md:flex-row items-center justify-between relative group">
                            <!-- Center bullet dot -->
                            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-4.5 h-4.5 rounded-full border-2 border-brand-500 bg-white group-hover:bg-brand-500 transition-colors z-20 hidden md:block"></div>
                            
                            <!-- Left Side (Content Card) -->
                            <div class="w-full md:w-[45%] text-left md:text-right pr-0 md:pr-10 space-y-2">
                                <span class="text-xs font-bold text-brand-600 block md:hidden">2018</span>
                                <h3 class="text-base font-extrabold text-slate-900">Noida HQ Establishment</h3>
                                <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                                    Zenvora was incorporated at Noida, UP, starting as a traditional boutique advisory firm with a panel of 3 Chartered Accountants and 2 corporate lawyers.
                                </p>
                            </div>
                            
                            <!-- Right Side (Year Label) -->
                            <div class="w-full md:w-[45%] text-left md:pl-10 hidden md:block">
                                <span class="text-3xl font-black text-slate-300 group-hover:text-brand-500 transition-colors uppercase tracking-widest">2018</span>
                            </div>
                        </div>

                        <!-- Milestone 2: 2020 (Year Left, Content Right) -->
                        <div class="flex flex-col md:flex-row items-center justify-between relative group">
                            <!-- Center bullet dot -->
                            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-4.5 h-4.5 rounded-full border-2 border-brand-500 bg-white group-hover:bg-brand-500 transition-colors z-20 hidden md:block"></div>
                            
                            <!-- Left Side (Year Label) -->
                            <div class="w-full md:w-[45%] text-right pr-10 hidden md:block">
                                <span class="text-3xl font-black text-slate-300 group-hover:text-brand-500 transition-colors uppercase tracking-widest">2020</span>
                            </div>

                            <!-- Right Side (Content Card) -->
                            <div class="w-full md:w-[45%] text-left pl-0 md:pl-10 space-y-2">
                                <span class="text-xs font-bold text-brand-650 block md:hidden">2020</span>
                                <h3 class="text-base font-extrabold text-slate-900">Digitization of MCA Pipelines</h3>
                                <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                                    Launched our digital documents dashboard. Allowed clients to upload KYC records and track name approvals online, shortening company setups to under 10 days.
                                </p>
                            </div>
                        </div>

                        <!-- Milestone 3: 2023 (Content Left, Year Right) -->
                        <div class="flex flex-col md:flex-row items-center justify-between relative group">
                            <!-- Center bullet dot -->
                            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-4.5 h-4.5 rounded-full border-2 border-brand-500 bg-white group-hover:bg-brand-500 transition-colors z-20 hidden md:block"></div>
                            
                            <!-- Left Side (Content Card) -->
                            <div class="w-full md:w-[45%] text-left md:text-right pr-0 md:pr-10 space-y-2">
                                <span class="text-xs font-bold text-brand-650 block md:hidden">2023</span>
                                <h3 class="text-base font-extrabold text-slate-900">Global Infrastructure Expansion</h3>
                                <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                                    Scaled entity registration and indirect tax services (VAT/GST filing) across 70+ countries. Formed dedicated desks for Transfer Pricing and international subsidiaries.
                                </p>
                            </div>
                            
                            <!-- Right Side (Year Label) -->
                            <div class="w-full md:w-[45%] text-left md:pl-10 hidden md:block">
                                <span class="text-3xl font-black text-slate-300 group-hover:text-brand-500 transition-colors uppercase tracking-widest">2023</span>
                            </div>
                        </div>

                        <!-- Milestone 4: 2026 (Year Left, Content Right) -->
                        <div class="flex flex-col md:flex-row items-center justify-between relative group">
                            <!-- Center bullet dot -->
                            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-4.5 h-4.5 rounded-full border-2 border-brand-500 bg-white group-hover:bg-brand-500 transition-colors z-20 hidden md:block"></div>
                            
                            <!-- Left Side (Year Label) -->
                            <div class="w-full md:w-[45%] text-right pr-10 hidden md:block">
                                <span class="text-3xl font-black text-slate-300 group-hover:text-brand-500 transition-colors uppercase tracking-widest">2026</span>
                            </div>

                            <!-- Right Side (Content Card) -->
                            <div class="w-full md:w-[45%] text-left pl-0 md:pl-10 space-y-2">
                                <span class="text-xs font-bold text-brand-650 block md:hidden">2026</span>
                                <h3 class="text-base font-extrabold text-slate-900">Supporting 1,200+ Startups</h3>
                                <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                                    Zenvora is recognized as one of India's fastest-growing digital compliance partners for high-growth tech firms, with a legal network of 45+ professionals.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- New Value-Add Section 1: Accreditations & Trust Partners (Banners of Credibility) -->
        <section class="py-20 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
                <div class="max-w-2xl mx-auto space-y-3">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Accreditations</span>
                    <h3 class="text-2xl font-extrabold text-slate-900">Verified and Fully Compliant Infrastructure</h3>
                    <p class="text-slate-500 text-xs font-semibold leading-relaxed">
                        Zenvora is recognized and approved by key regulatory authorities and bodies to coordinate national and global filings safely.
                    </p>
                </div>

                <!-- Credibility badges grid (Flat panels, No Shadows) -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    <div class="bg-slate-50/50 border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="fa-solid fa-building-shield text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">MCA Approved</span>
                    </div>
                    <div class="bg-slate-50/50 border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="fa-solid fa-stamp text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">DPIIT Partner</span>
                    </div>
                    <div class="bg-slate-50/50 border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="fa-solid fa-receipt text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">GSTN Authorized</span>
                    </div>
                    <div class="bg-slate-50/50 border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="fa-solid fa-ribbon text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">ISO 9001:2015</span>
                    </div>
                    <div class="bg-slate-50/50 border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3 col-span-2 md:col-span-1">
                        <i class="fa-solid fa-circle-check text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">MSME Registered</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- New Value-Add Section 2: Technology-Enabled Compliance (Features Bento Grid style) -->
        <section class="py-24 bg-slate-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="max-w-3xl text-left mb-16 space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-code text-[9px]"></i> Our Stack
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Software Engineered for Corporate Oversight
                    </h2>
                    <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                        Unlike traditional offline consultants, we replace friction with software pipelines to give you real-time visibility.
                    </p>
                </div>

                <!-- 3-Column Technology Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Tech Item 1 -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-200/55 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-base">
                                <i class="fa-solid fa-vault"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Encrypted Document Vault</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                Manage and access company formation deeds, share certificates, and director DSC keys safely in your secure cloud vault backed by bank-grade encryption.
                            </p>
                        </div>
                    </div>

                    <!-- Tech Item 2 -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-200/55 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-base">
                                <i class="fa-solid fa-bell"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Proactive Compliance Alerts</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                Our platform tracks filing dates for ROC, GST returns, and TDS deposits, automatically alerting you and our CA team well ahead of deadlines.
                            </p>
                        </div>
                    </div>

                    <!-- Tech Item 3 -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-200/55 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-base">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Itemized Cost Transparency</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                Every single government fee challan and professional service receipt is uploaded directly to your ledger to eliminate unannounced surcharges.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Core Values Grid (Flat Cards) -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="max-w-3xl text-left mb-16 space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-heart text-[9px]"></i> Core values
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Built on absolute trust.
                    </h2>
                </div>

                <!-- 3-Column Values Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Value 1 -->
                    <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-200/50">
                        <div class="w-9 h-9 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-sm mb-4">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900">Absolute Transparency</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            No hidden professional charges. Every government challan, registration receipt, and MCA fee filing is uploaded directly to your panel for absolute audit trails.
                        </p>
                    </div>

                    <!-- Value 2 -->
                    <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-200/50">
                        <div class="w-9 h-9 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-sm mb-4">
                            <i class="fa-solid fa-gauge-high"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900">Execution Speed</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Your filings are processed through digital conduits. We secure PAN/TAN allocations in 2 days and deliver final MCA incorporation certificates in under 7 days.
                        </p>
                    </div>

                    <!-- Value 3 -->
                    <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-200/50">
                        <div class="w-9 h-9 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-sm mb-4">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900">Direct CA Supervision</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Every compliance return, trademark application, and subsidy claim is reviewed and signed off by qualified Chartered Accountants and CS professionals.
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Leadership Advising Panel Grid -->
        <section class="py-24 bg-slate-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="max-w-3xl text-left mb-16 space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-users text-[9px]"></i> Corporate Panel
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Advisors Who Understand Startup Scaling
                    </h2>
                </div>

                <!-- Leaders Grid (3-column layout, no shadows) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Advisor 1 -->
                    <div class="bg-white rounded-3xl p-5 border border-slate-200/50 group hover:border-brand-500/30 transition-all duration-300">
                        <div class="relative w-full aspect-square rounded-2xl overflow-hidden mb-4 bg-slate-100">
                            <img src="assets/images/about_us.jpg" 
                                 alt="Priyanka Sharma Zenvora Advisor" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="text-left space-y-1">
                            <h3 class="text-sm font-extrabold text-slate-900">Priyanka Sharma</h3>
                            <span class="text-[10px] text-brand-600 font-extrabold uppercase tracking-wider block">Senior Startup Legal Advisor</span>
                            <p class="text-xs text-slate-500 leading-normal pt-2 border-t border-slate-100 mt-2 font-medium">
                                Directs legal formation frameworks, shareholder agreements, and DPIIT tax exemption approvals for tech startups.
                            </p>
                        </div>
                    </div>

                    <!-- Advisor 2 -->
                    <div class="bg-white rounded-3xl p-5 border border-slate-200/50 group hover:border-brand-500/30 transition-all duration-300">
                        <div class="relative w-full aspect-square rounded-2xl overflow-hidden mb-4 bg-slate-100">
                            <img src="assets/images/hero_bg.jpg" 
                                 alt="Tushar Sudheesh Zenvora CFO Advisor" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="text-left space-y-1">
                            <h3 class="text-sm font-extrabold text-slate-900">Tushar Sudheesh</h3>
                            <span class="text-[10px] text-brand-600 font-extrabold uppercase tracking-wider block">Managing CFO Partner</span>
                            <p class="text-xs text-slate-500 leading-normal pt-2 border-t border-slate-100 mt-2 font-medium">
                                Qualified Chartered Accountant managing corporate auditing, monthly accounting systems, and global taxation filings.
                            </p>
                        </div>
                    </div>

                    <!-- Advisor 3 -->
                    <div class="bg-white rounded-3xl p-5 border border-slate-200/50 group hover:border-brand-500/30 transition-all duration-300">
                        <div class="relative w-full aspect-square rounded-2xl overflow-hidden mb-4 bg-slate-100">
                            <img src="assets/images/hero_bg_3.jpg" 
                                 alt="Aditya Varma Trademark Lawyer" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="text-left space-y-1">
                            <h3 class="text-sm font-extrabold text-slate-900">Aditya Varma</h3>
                            <span class="text-[10px] text-brand-600 font-extrabold uppercase tracking-wider block">Senior IP & Trademark Counsel</span>
                            <p class="text-xs text-slate-500 leading-normal pt-2 border-t border-slate-100 mt-2 font-medium">
                                Trademark attorney managing patent searches, brand registrations, municipal licensing, and labor law filings.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Standalone CTA Section (No Shadows) -->
        <section class="py-24 bg-white text-center">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Ready to streamline your legal compliance?</h2>
                <p class="text-slate-500 text-sm max-w-xl mx-auto font-semibold">
                    Get in touch with Priyanka or Tushar to schedule a free 15-minute consultation. We'll map out your custom compliance roadmap.
                </p>
                <div class="pt-4">
                    <a href="contact.php" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full text-xs font-bold text-white accent-gradient hover:opacity-95 transition-all">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Book Free Consultation Call
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer Navigation -->
    <?php include_once 'components/footer.php'; ?>

</body>

</html>
