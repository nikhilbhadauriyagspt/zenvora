<?php
// Standalone Services Directory Page for Zenvora Global Solutions
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Zenvora Global Solutions</title>
    <meta name="description" content="Browse Zenvora's full catalog of business startup formation, tax compliance, municipal licensing, trademark registration, and NGO setup services.">
    
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

        <!-- Services Detailed Grid Section (No Shadows) -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                    
                    <!-- Service 1: Business Startup Setup -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 flex flex-col justify-between hover:border-brand-500 transition-all duration-300">
                        <div class="space-y-6">
                            <!-- Header Image & Badge -->
                            <div class="relative w-full aspect-[16/10] bg-slate-100 rounded-2xl overflow-hidden border border-slate-100">
                                <img src="assets/images/service_incorporation.jpg" alt="Business Startup Incorporation" class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded">
                                    01. SETUP
                                </div>
                            </div>

                            <!-- Title & Short Describe -->
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-rocket text-brand-500 text-sm"></i> Business Startup Setup
                                </h3>
                                <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                                    Form your legal business structure in India. We coordinate MCA name approvals, draft MoA/AoA bylaws, secure director DINs, and handle ROC submissions.
                                </p>
                            </div>

                            <!-- Sub-categories List (Same as home page component) -->
                            <div class="space-y-1 pt-4 border-t border-slate-100">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Available Setup Types:</span>
                                <div class="space-y-0.5">
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Private Limited Company</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Limited Liability Partnership (LLP)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">One Person Company (OPC)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Partnership Firm Setup</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 transition-colors">
                                        <span class="font-medium">Proprietorship Registration</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Deliverables points (checklists) -->
                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Deliverables Include:</span>
                                <ul class="space-y-2.5 text-xs text-slate-650 font-semibold">
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>MCA Certificate of Incorporation (COI)</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>Director Identification Numbers (DIN)</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>Company PAN & TAN allocation codes</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- CTA button -->
                        <div class="mt-8 pt-5 border-t border-slate-100">
                            <a href="contact.php" class="block w-full text-center py-3 rounded-full text-[11px] font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                Inquire Setup Services <i class="fa-solid fa-chevron-right ml-1.5 text-[9px] text-slate-400"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Service 2: Business Registrations -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 flex flex-col justify-between hover:border-brand-500 transition-all duration-300">
                        <div class="space-y-6">
                            <!-- Header Image & Badge -->
                            <div class="relative w-full aspect-[16/10] bg-slate-100 rounded-2xl overflow-hidden border border-slate-100">
                                <img src="assets/images/hero_bg.jpg" alt="Business Registrations" class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded">
                                    02. REGISTRATION
                                </div>
                            </div>

                            <!-- Title & Short Describe -->
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-receipt text-brand-500 text-sm"></i> Business Registrations
                                </h3>
                                <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                                    Secure your government registrations and tax identification codes to trade legally across states, bid for tenders, and claim startup benefits.
                                </p>
                            </div>

                            <!-- Sub-categories List (Same as home page component) -->
                            <div class="space-y-1 pt-4 border-t border-slate-100">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Available Tax Registrations:</span>
                                <div class="space-y-0.5">
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">GST Registration</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">MSME (Udyam) Registration</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Startup India DPIIT Recognition</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Import Export Code (IEC)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 transition-colors">
                                        <span class="font-medium">PF, ESI & GEM Portal Registration</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Deliverables points (checklists) -->
                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Deliverables Include:</span>
                                <ul class="space-y-2.5 text-xs text-slate-650 font-semibold">
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>GST Registration & HSN classifications</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>MSME Udyam Enrollment Certificate</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>DPIIT Startup Recognition Certificate</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- CTA button -->
                        <div class="mt-8 pt-5 border-t border-slate-100">
                            <a href="contact.php" class="block w-full text-center py-3 rounded-full text-[11px] font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                Inquire Registrations <i class="fa-solid fa-chevron-right ml-1.5 text-[9px] text-slate-400"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Service 3: Operational Licenses -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 flex flex-col justify-between hover:border-brand-500 transition-all duration-300">
                        <div class="space-y-6">
                            <!-- Header Image & Badge -->
                            <div class="relative w-full aspect-[16/10] bg-slate-100 rounded-2xl overflow-hidden border border-slate-100">
                                <img src="assets/images/hero_bg_4.jpg" alt="Business Licenses" class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded">
                                    03. LICENSING
                                </div>
                            </div>

                            <!-- Title & Short Describe -->
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-scale-balanced text-brand-500 text-sm"></i> Operational Licenses
                                </h3>
                                <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                                    Obtain operational clearances, municipal licenses, and labor department permits needed to open physically, distribute food, or employ contract staff.
                                </p>
                            </div>

                            <!-- Sub-categories List (Same as home page component) -->
                            <div class="space-y-1 pt-4 border-t border-slate-100">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Available Licenses:</span>
                                <div class="space-y-0.5">
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">FSSAI Food License</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Trade License (Municipal)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Shop & Establishment (Shop Act)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Contract Labour (CLRA) License</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 transition-colors">
                                        <span class="font-medium">PT & Labour Welfare Fund (LWF)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Deliverables points (checklists) -->
                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Deliverables Include:</span>
                                <ul class="space-y-2.5 text-xs text-slate-650 font-semibold">
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>FSSAI Food Business License clearance</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>Shop & Establishment Act registration</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>Municipal Trade License approvals</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- CTA button -->
                        <div class="mt-8 pt-5 border-t border-slate-100">
                            <a href="contact.php" class="block w-full text-center py-3 rounded-full text-[11px] font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                Inquire Licensing <i class="fa-solid fa-chevron-right ml-1.5 text-[9px] text-slate-400"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Service 4: Certifications & Brand IP -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 flex flex-col justify-between hover:border-brand-500 transition-all duration-300">
                        <div class="space-y-6">
                            <!-- Header Image & Badge -->
                            <div class="relative w-full aspect-[16/10] bg-slate-100 rounded-2xl overflow-hidden border border-slate-100">
                                <img src="assets/images/service_trademark.jpg" alt="Trademark & Certifications" class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded">
                                    04. BRAND & IP
                                </div>
                            </div>

                            <!-- Title & Short Describe -->
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-certificate text-brand-500 text-sm"></i> Quality Certifications
                                </h3>
                                <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                                    Protect your brand assets and qualify for corporate contracts by securing internationally recognized ISO certificates and active trademark claims.
                                </p>
                            </div>

                            <!-- Sub-categories List (Same as home page component) -->
                            <div class="space-y-1 pt-4 border-t border-slate-100">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Available Certifications:</span>
                                <div class="space-y-0.5">
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">ISO 9001, 14001, 27001</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Trademark (TM) Registration</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">BIS Certification & ISI Mark</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Class 3 Digital Signature (DSC)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 transition-colors">
                                        <span class="font-medium">Fire NOC & Make in India certification</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Deliverables points (checklists) -->
                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Deliverables Include:</span>
                                <ul class="space-y-2.5 text-xs text-slate-650 font-semibold">
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>Trademark (TM) filing & objection responses</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>ISO Quality Management audit credentials</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>BIS Certification & ISI Mark filings</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- CTA button -->
                        <div class="mt-8 pt-5 border-t border-slate-100">
                            <a href="contact.php" class="block w-full text-center py-3 rounded-full text-[11px] font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                Inquire Brand IP <i class="fa-solid fa-chevron-right ml-1.5 text-[9px] text-slate-400"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Service 5: Tax & Compliances -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 flex flex-col justify-between hover:border-brand-500 transition-all duration-300">
                        <div class="space-y-6">
                            <!-- Header Image & Badge -->
                            <div class="relative w-full aspect-[16/10] bg-slate-100 rounded-2xl overflow-hidden border border-slate-100">
                                <img src="assets/images/service_taxation.jpg" alt="Taxation compliances" class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded">
                                    05. TAX & AUDIT
                                </div>
                            </div>

                            <!-- Title & Short Describe -->
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-calculator text-brand-500 text-sm"></i> Tax & Compliance
                                </h3>
                                <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                                    Outsource bookkeeping, monthly payroll tax deductions, corporate income tax filing, and annual ROC disclosures to our expert team of CAs.
                                </p>
                            </div>

                            <!-- Sub-categories List (Same as home page component) -->
                            <div class="space-y-1 pt-4 border-t border-slate-100">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Available Compliance Programs:</span>
                                <div class="space-y-0.5">
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Income Tax Return (ITR) Filing</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">GST Return Filing (Monthly/Quarterly)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">ROC Annual Compliances (MCA)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Corporate Accounting & Bookkeeping</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 transition-colors">
                                        <span class="font-medium">PF & ESI Monthly Returns & Winding Up</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Deliverables points (checklists) -->
                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Deliverables Include:</span>
                                <ul class="space-y-2.5 text-xs text-slate-650 font-semibold">
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>Monthly/Quarterly GST filings (GSTR-1/3B)</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>Annual Corporate Income Tax (ITR-6) filing</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>ROC Annual Filings (Form AOC-4 & MGT-7)</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- CTA button -->
                        <div class="mt-8 pt-5 border-t border-slate-100">
                            <a href="contact.php" class="block w-full text-center py-3 rounded-full text-[11px] font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                Inquire Tax Filings <i class="fa-solid fa-chevron-right ml-1.5 text-[9px] text-slate-400"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Service 6: NGO & Social Sectors Setup -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 flex flex-col justify-between hover:border-brand-500 transition-all duration-300">
                        <div class="space-y-6">
                            <!-- Header Image & Badge -->
                            <div class="relative w-full aspect-[16/10] bg-slate-100 rounded-2xl overflow-hidden border border-slate-100">
                                <img src="assets/images/hero_bg_5.jpg" alt="NGO Incorporation" class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded">
                                    06. NON-PROFIT
                                </div>
                            </div>

                            <!-- Title & Short Describe -->
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-handshake-angle text-brand-500 text-sm"></i> NGO Registration
                                </h3>
                                <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                                    Register non-profit entities, public trusts, and social welfare societies. We handle tax exclusions, NGO Darpan IDs, and CSR project setups.
                                </p>
                            </div>

                            <!-- Sub-categories List (Same as home page component) -->
                            <div class="space-y-1 pt-4 border-t border-slate-100">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Available Non-Profit Types:</span>
                                <div class="space-y-0.5">
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Section 8 Company Incorporation</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Trust Registration (Deed draft)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">Society Registration (Bylaws setup)</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium">12A & 80G Tax Exemption Certificates</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <a href="contact.php" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 transition-colors">
                                        <span class="font-medium">Darpan ID, CSR-1 & FCRA Registration</span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Deliverables points (checklists) -->
                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Deliverables Include:</span>
                                <ul class="space-y-2.5 text-xs text-slate-650 font-semibold">
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>Section 8 Company Incorporation certificate</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>Public/Private Trust Deed registration</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span>12A & 80G Tax Exemption certification</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- CTA button -->
                        <div class="mt-8 pt-5 border-t border-slate-100">
                            <a href="contact.php" class="block w-full text-center py-3 rounded-full text-[11px] font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                Inquire NGO Services <i class="fa-solid fa-chevron-right ml-1.5 text-[9px] text-slate-400"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Advisory Call section (No Shadows) -->
        <section class="py-24 bg-slate-50 text-center">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Need a custom compliance scope?</h2>
                <p class="text-slate-500 text-sm max-w-xl mx-auto font-semibold">
                    Schedule a free 15-minute scoping call with Priyanka or CA Tushar. We'll map out your company registration, municipal licenses, and ROC filing milestones.
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
