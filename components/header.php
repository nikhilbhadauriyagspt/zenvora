<!-- Top Contact & Social Bar (Default state: clean dark slate style) -->
<div class="bg-slate-900 text-slate-300 py-2.5 text-xs border-b border-slate-800 relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
        <!-- Contact details -->
        <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-1 font-medium">
            <?php 
            $topPhones = getWebPhones();
            $firstPhone = !empty($topPhones) ? reset($topPhones) : ['label' => 'Hotline', 'value' => '+91 98765 43210'];
            ?>
            <a href="tel:<?php echo htmlspecialchars($firstPhone['value']); ?>" class="hover:text-brand-400 transition-colors flex items-center gap-1.5 text-slate-300">
                <i class="fa-solid fa-phone text-brand-500 text-[11px]"></i>
                <?php echo htmlspecialchars($firstPhone['value']); ?>
            </a>
            <a href="mailto:<?php echo getWebSetting('email_1'); ?>" class="hover:text-brand-400 transition-colors flex items-center gap-1.5 text-slate-300">
                <i class="fa-solid fa-envelope text-brand-500 text-[11px]"></i>
                <?php echo getWebSetting('email_1'); ?>
            </a>
        </div>
        <!-- Right side timing & socials -->
        <div class="flex items-center gap-5">
            <span class="hidden md:inline-flex items-center gap-1.5 text-slate-400">
                <i class="fa-solid fa-clock text-brand-500 text-[11px]"></i>
                <?php echo getWebSetting('working_hours'); ?>
            </span>
            <div class="flex items-center gap-3.5 text-slate-400">
                <a href="#facebook" class="hover:text-brand-400 transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#twitter" class="hover:text-brand-400 transition-colors"><i class="fa-brands fa-twitter"></i></a>
                <a href="#linkedin" class="hover:text-brand-400 transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#instagram" class="hover:text-brand-400 transition-colors"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Header Navigation -->
<header class="sticky top-0 left-0 right-0 z-40 transition-all duration-300 glass-panel" id="main-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo Section -->
            <div class="flex-shrink-0 flex items-center">
                <a href="index.php" class="flex items-center group">
                    <img class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                        src="<?php echo getWebSetting('logo_url'); ?>"
                        alt="Zenvora Global Solutions Logo">
                </a>
            </div>

            <!-- Desktop Nav Items with a Single Full-Width Services MegaMenu -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                <a href="index.php" class="text-slate-600 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-bold transition-colors">
                    Home
                </a>

                <!-- Services Tab: Static wrapper ensures child spans header width -->
                <div class="group static">
                    <a href="services.php" class="text-slate-600 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-bold transition-colors flex items-center gap-1 group/btn">
                        Services
                        <i class="fa-solid fa-chevron-down text-[9px] text-slate-400 group-hover/btn:text-slate-900 group-hover:rotate-180 transition-transform duration-300"></i>
                    </a>

                    <!-- Full-Width Megamenu Panel: Spans 100% of viewport width -->
                    <div class="absolute left-0 right-0 w-full mt-2 bg-white border-y border-slate-100 shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 z-50">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-12 gap-8">

                            <!-- Col 1: Business Setup -->
                            <div class="col-span-3 space-y-4">
                                <h3 class="text-xs font-extrabold text-brand-600 uppercase tracking-widest border-b border-slate-100 pb-2">Business Setup</h3>
                                <div class="space-y-3">
                                    <a href="#pvt-ltd" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-building text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Private Limited Company</span>
                                    </a>
                                    <a href="#llp" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-people-carry-box text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Limited Liability (LLP)</span>
                                    </a>
                                    <a href="#opc" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-user-tie text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">One Person Company</span>
                                    </a>
                                    <a href="#partnership-firm" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-user-group text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Partnership Firm</span>
                                    </a>
                                    <a href="#proprietorship" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-user text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Proprietorship Registration</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Col 2: Registrations -->
                            <div class="col-span-3 space-y-4">
                                <h3 class="text-xs font-extrabold text-brand-600 uppercase tracking-widest border-b border-slate-100 pb-2">Registrations</h3>
                                <div class="space-y-3">
                                    <a href="#gst-reg" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-receipt text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">GST Registration</span>
                                    </a>
                                    <a href="#msme-reg" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-briefcase text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">MSME Registration</span>
                                    </a>
                                    <a href="#startup-india" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-flag text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Startup India Registration</span>
                                    </a>
                                    <a href="#iec" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-globe text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Import Export Code (IEC)</span>
                                    </a>
                                    <a href="#pf-esi-reg" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-users text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">PF & ESI Registration</span>
                                    </a>
                                    <a href="#gem-reg" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-cart-shopping text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">GeM Portal Registration</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Col 3: Licenses & IPR -->
                            <div class="col-span-3 space-y-4">
                                <h3 class="text-xs font-extrabold text-brand-600 uppercase tracking-widest border-b border-slate-100 pb-2">Licenses & IPR</h3>
                                <div class="space-y-3">
                                    <a href="#fssai" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-utensils text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">FSSAI License (Food Safety)</span>
                                    </a>
                                    <a href="#trade-license" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-scale-balanced text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Trade License</span>
                                    </a>
                                    <a href="#shop-est" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-store text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Shop & Establishment Act</span>
                                    </a>
                                    <a href="#trademark" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link pt-2.5 border-t border-slate-100">
                                        <i class="fa-solid fa-trademark text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Trademark & Logo Filing</span>
                                    </a>
                                    <a href="#iso" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-certificate text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">ISO Quality Certification</span>
                                    </a>
                                    <a href="#bis" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-shield-halved text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">BIS Certification</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Col 4: Tax & Compliance -->
                            <div class="col-span-3 space-y-4">
                                <h3 class="text-xs font-extrabold text-brand-600 uppercase tracking-widest border-b border-slate-100 pb-2">Tax & Compliance</h3>
                                <div class="space-y-3">
                                    <a href="#itr-filing" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-calculator text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">ITR Filing (Corporate/Personal)</span>
                                    </a>
                                    <a href="#gst-returns" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-file-invoice text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">GST Return Filing</span>
                                    </a>
                                    <a href="#roc" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-gavel text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">ROC Annual Compliances</span>
                                    </a>
                                    <a href="#accounting" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-book text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Accounting & Bookkeeping</span>
                                    </a>
                                    <a href="#pf-esi-returns" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-users-gear text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">PF & ESI Return Filing</span>
                                    </a>
                                    <a href="#winding-up" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                        <i class="fa-solid fa-ban text-slate-400 group-hover/link:text-brand-500 mt-0.5 text-sm"></i>
                                        <span class="text-xs font-semibold">Winding Up of Company</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <a href="about.php" class="text-slate-600 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-bold transition-colors">
                    About Us
                </a>
                <a href="blog.php" class="text-slate-600 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-bold transition-colors">
                    Blog
                </a>
                <a href="faqs.php" class="text-slate-600 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-bold transition-colors">
                    FAQs
                </a>
                <a href="contact.php" class="text-slate-600 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-bold transition-colors">
                    Contact Us
                </a>
            </nav>

            <!-- Call to Action & Slide Toggler Button -->
            <div class="hidden md:flex items-center gap-3">
                <!-- Desktop Search Bar -->
                <div class="relative w-40 lg:w-48 focus-within:w-60 transition-all duration-300">
                    <input type="text" id="site-search" placeholder="Search homepage..." 
                           class="w-full text-[10px] font-semibold pl-8 pr-3 py-2 border border-slate-200 rounded-full focus:outline-none focus:border-brand-500 bg-slate-50 hover:bg-slate-100/50 focus:bg-white transition-all">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[10px]"><i class="fa-solid fa-magnifying-glass"></i></span>
                    
                    <!-- Search Results Dropdown -->
                    <div id="search-results" class="absolute right-0 top-full mt-2 w-72 bg-white border border-slate-200 rounded-2xl shadow-xl hidden z-50 p-2 text-left space-y-0.5"></div>
                </div>

                <a href="contact.php" class="px-5 py-3 rounded-full text-xs font-bold text-white accent-gradient hover:shadow-lg hover:shadow-brand-500/10 transition-all duration-300 hover:-translate-y-0.5">
                    Free Consultation
                </a>
                <!-- Toggler button for Full-Screen Slide-down Overlay Panel -->
                <button type="button" id="mega-drawer-toggle" class="p-2.5 rounded-full border border-slate-200 hover:border-brand-500 text-slate-600 hover:text-brand-600 hover:bg-slate-50 transition-colors flex items-center justify-center focus:outline-none" aria-label="Toggle Fullscreen Panel">
                    <i class="fa-solid fa-bars-staggered text-sm"></i>
                </button>
            </div>

            <!-- Mobile Hamburger Menu Button -->
            <div class="flex items-center md:hidden">
                <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon Open Menu -->
                    <svg class="block h-6 w-6" id="menu-icon-open" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <!-- Icon Close Menu -->
                    <svg class="hidden h-6 w-6" id="menu-icon-close" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div class="hidden md:hidden border-t border-slate-100 bg-white/98 backdrop-blur-2xl transition-all duration-300 shadow-xl" id="mobile-menu">
        <div class="px-4 pt-3 pb-6 space-y-4 max-h-[85vh] overflow-y-auto">
            <!-- Mobile search input -->
            <div class="relative px-3 py-1">
                <input type="text" id="site-search-mobile" placeholder="Search homepage..." 
                       class="w-full text-xs font-semibold pl-9 pr-3 py-2.5 border border-slate-200 rounded-full focus:outline-none focus:border-brand-500 bg-slate-50 focus:bg-white transition-all">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 text-[11px]"><i class="fa-solid fa-magnifying-glass"></i></span>
                
                <!-- Mobile Search Results Dropdown -->
                <div id="search-results-mobile" class="absolute left-3 right-3 top-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg hidden z-50 p-2 text-left space-y-0.5"></div>
            </div>

            <!-- Mobile Menu Links -->
            <div class="space-y-1">
                <a href="index.php" class="block px-3 py-2 text-base font-bold text-slate-800 hover:bg-slate-50 rounded-lg">Home</a>
                <a href="services.php" class="block px-3 py-2 text-base font-bold text-slate-800 hover:bg-slate-50 rounded-lg">Services</a>
                <a href="about.php" class="block px-3 py-2 text-base font-bold text-slate-800 hover:bg-slate-50 rounded-lg">About Us</a>
                <a href="blog.php" class="block px-3 py-2 text-base font-bold text-slate-800 hover:bg-slate-50 rounded-lg">Blog</a>
                <a href="faqs.php" class="block px-3 py-2 text-base font-bold text-slate-800 hover:bg-slate-50 rounded-lg">FAQs</a>
                <a href="contact.php" class="block px-3 py-2 text-base font-bold text-slate-800 hover:bg-slate-50 rounded-lg">Contact Us</a>
            </div>

            <!-- Mobile Services Collapse List -->
            <div class="border-t border-slate-100 pt-3 space-y-3">
                <span class="block px-3 py-1 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Our Services</span>

                <div class="space-y-1.5 pl-3">
                    <span class="block px-3 py-0.5 text-xs font-bold text-brand-600 uppercase">Business Setup</span>
                    <a href="#pvt-ltd" class="block pl-6 pr-3 py-1 text-sm text-slate-600 hover:text-slate-900">Private Limited Company</a>
                    <a href="#llp" class="block pl-6 pr-3 py-1 text-sm text-slate-600 hover:text-slate-900">LLP Registration</a>
                </div>

                <div class="space-y-1.5 pl-3">
                    <span class="block px-3 py-0.5 text-xs font-bold text-brand-600 uppercase">Registrations</span>
                    <a href="#gst-reg" class="block pl-6 pr-3 py-1 text-sm text-slate-600 hover:text-slate-900">GST Registration</a>
                    <a href="#msme-reg" class="block pl-6 pr-3 py-1 text-sm text-slate-600 hover:text-slate-900">MSME Registration</a>
                </div>

                <div class="space-y-1.5 pl-3">
                    <span class="block px-3 py-0.5 text-xs font-bold text-brand-600 uppercase">Licenses & IPR</span>
                    <a href="#fssai" class="block pl-6 pr-3 py-1 text-sm text-slate-600 hover:text-slate-900">FSSAI License</a>
                    <a href="#trademark" class="block pl-6 pr-3 py-1 text-sm text-slate-600 hover:text-slate-900">Trademark Filing</a>
                </div>
            </div>

            <div class="mt-4 px-3">
                <a href="contact.php" class="block w-full text-center px-4 py-3 rounded-full text-sm font-bold text-white accent-gradient shadow-lg">
                    Get Free Consultation
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Full-Screen Slide-Down Mega Drawer Overlay (Matches bg-slate-900 with backdrop blur) -->
<div id="mega-drawer" class="fixed inset-0 w-screen h-screen bg-slate-900  z-[100] transition-all duration-500 ease-in-out transform -translate-y-full opacity-0 pointer-events-none flex flex-col justify-between overflow-y-auto">

    <!-- Mega Drawer Top Header (Logo + Contact Details (Phone & Email) + Close Button) -->
    <div class="w-full border-b border-slate-800 bg-slate-900 flex-shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-24 flex items-center justify-between gap-4">
            <!-- Brand Logo (Left) -->
            <div class="flex-shrink-0">
                <img class="h-12 w-auto object-contain" src="<?php echo getWebSetting('logo_url'); ?>" alt="Zenvora Logo">
            </div>

            <!-- Contact Details: Phone & Email (Center - Positioned between Logo and Close Button) -->
            <div class="hidden md:flex items-center gap-8 text-slate-300">
                <?php 
                $hdrPhones = getWebPhones();
                foreach ($hdrPhones as $hp): 
                ?>
                <a href="tel:<?php echo htmlspecialchars($hp['value']); ?>" class="flex items-center gap-2.5 text-sm font-bold hover:text-brand-400 transition-colors group/tel-hdr">
                    <span class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-xs group-hover/tel-hdr:bg-brand-500 group-hover/tel-hdr:text-white transition-colors"><i class="fa-solid fa-phone"></i></span>
                    <div class="text-left leading-none">
                        <span class="text-[9px] text-slate-500 font-bold block mb-0.5 uppercase tracking-wider"><?php echo htmlspecialchars($hp['label']); ?></span>
                        <span><?php echo htmlspecialchars($hp['value']); ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
                <a href="mailto:<?php echo getWebSetting('email_1'); ?>" class="flex items-center gap-2.5 text-sm font-bold hover:text-brand-400 transition-colors group/mail-hdr">
                    <span class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-xs group-hover/mail-hdr:bg-brand-500 group-hover/mail-hdr:text-white transition-colors"><i class="fa-solid fa-envelope"></i></span>
                    <div class="text-left leading-none">
                        <span class="text-[9px] text-slate-500 font-bold block mb-0.5 uppercase tracking-wider">Email Us</span>
                        <span><?php echo getWebSetting('email_1'); ?></span>
                    </div>
                </a>
            </div>

            <!-- Large Close Button (Right) -->
            <button type="button" id="mega-drawer-close" class="w-12 h-12 rounded-full border border-slate-700 hover:border-brand-500 text-slate-300 hover:text-brand-400 hover:bg-slate-800 transition-all duration-300 flex items-center justify-center focus:outline-none text-xl group" aria-label="Close Menu">
                <i class="fa-solid fa-xmark group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
        </div>
    </div>

    <!-- Mega Drawer Content Area -->
    <div class="flex-grow overflow-y-auto py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col h-full justify-start">

            <!-- Full-Width Flex Contact details row (Includes Office Location, Social Icons, & CA Notice) -->
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6 border-b border-slate-800 pb-8 mb-8 w-full">
                <!-- Location Address block -->
                <div class="flex items-center gap-3.5 max-w-md">
                    <img src="assets/images/hero_bg_5.jpg" class="w-12 h-12 object-cover rounded-lg border border-slate-700 flex-shrink-0">
                    <div>
                        <h5 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Zenvora Head Office</h5>
                        <p class="text-xs text-slate-200 mt-1 font-semibold leading-relaxed">
                            <?php echo getWebSetting('address_noida'); ?>
                        </p>
                    </div>
                </div>

                <!-- Social Media Icons (Centered in this flex row) -->
                <div class="flex items-center gap-3.5 text-slate-400 border-t lg:border-t-0 border-slate-800 pt-3 lg:pt-0">
                    <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mr-1.5">Connect With Us:</span>
                    <a href="#facebook" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center text-xs transition-all"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#twitter" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center text-xs transition-all"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#linkedin" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center text-xs transition-all"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#instagram" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center text-xs transition-all"><i class="fa-brands fa-instagram"></i></a>
                </div>

                <!-- CA Advisory notice card -->
                <div class="p-3 rounded-xl bg-brand-500/5 border border-brand-500/20 text-[10px] text-brand-400 leading-relaxed font-semibold max-w-sm">
                    <i class="fa-solid fa-circle-info mr-1 text-xs"></i> Outsource your legal, tax, and NGO registrations to our panel of CAs & lawyers.
                </div>
            </div>

            <!-- Services Directory Area: Vertical Tabs (Left) & Active Category details content (Right) -->
            <div class="grid grid-cols-12 gap-12 items-start w-full">

                <!-- Left Side: Clean Category Menu Links & Trust/Support Widget -->
                <div class="col-span-4 flex flex-col space-y-4 pr-8 border-r border-slate-800">
                    <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2 px-1">Service Categories</span>

                    <button class="drawer-tab-btn active text-left text-lg font-bold transition-all flex items-center justify-between group/tab text-brand-400" data-target="drawer-tab-startup">
                        <span>Business Startup</span>
                        <i class="fa-solid fa-arrow-right text-xs opacity-100 translate-x-0 transition-all duration-300"></i>
                    </button>
                    <button class="drawer-tab-btn text-left text-lg font-bold transition-all flex items-center justify-between group/tab text-slate-300 hover:text-white" data-target="drawer-tab-registrations">
                        <span>Registrations</span>
                        <i class="fa-solid fa-arrow-right text-xs opacity-0 -translate-x-2 group-hover/tab:opacity-100 group-hover/tab:translate-x-0 transition-all duration-300"></i>
                    </button>
                    <button class="drawer-tab-btn text-left text-lg font-bold transition-all flex items-center justify-between group/tab text-slate-300 hover:text-white" data-target="drawer-tab-licenses">
                        <span>Licenses</span>
                        <i class="fa-solid fa-arrow-right text-xs opacity-0 -translate-x-2 group-hover/tab:opacity-100 group-hover/tab:translate-x-0 transition-all duration-300"></i>
                    </button>
                    <button class="drawer-tab-btn text-left text-lg font-bold transition-all flex items-center justify-between group/tab text-slate-300 hover:text-white" data-target="drawer-tab-certifications">
                        <span>Certifications</span>
                        <i class="fa-solid fa-arrow-right text-xs opacity-0 -translate-x-2 group-hover/tab:opacity-100 group-hover/tab:translate-x-0 transition-all duration-300"></i>
                    </button>
                    <button class="drawer-tab-btn text-left text-lg font-bold transition-all flex items-center justify-between group/tab text-slate-300 hover:text-white" data-target="drawer-tab-taxation">
                        <span>Tax & Compliance</span>
                        <i class="fa-solid fa-arrow-right text-xs opacity-0 -translate-x-2 group-hover/tab:opacity-100 group-hover/tab:translate-x-0 transition-all duration-300"></i>
                    </button>
                    <button class="drawer-tab-btn text-left text-lg font-bold transition-all flex items-center justify-between group/tab text-slate-300 hover:text-white" data-target="drawer-tab-ngo">
                        <span>NGO Setup</span>
                        <i class="fa-solid fa-arrow-right text-xs opacity-0 -translate-x-2 group-hover/tab:opacity-100 group-hover/tab:translate-x-0 transition-all duration-300"></i>
                    </button>

                    <!-- Trust and Support Widgets -->
                    <div class="mt-8 pt-6 border-t border-slate-800 space-y-4 flex flex-col">
                        <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest block">Trust & Verification</span>
                        <div class="grid grid-cols-2 gap-3 text-[10px] text-slate-400 font-semibold">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-shield text-brand-500"></i> MCA Approved</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-stamp text-brand-500"></i> 100% Tax Legal</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-shield text-brand-500"></i> ISO Certified</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-star text-brand-500"></i> 4.9/5 Rating</span>
                        </div>
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', getWebSetting('whatsapp_number')); ?>" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 bg-green-600/10 hover:bg-green-600 text-green-500 hover:text-white rounded-lg text-xs font-bold transition-all border border-green-500/20">
                            <i class="fa-brands fa-whatsapp text-sm"></i> Chat on WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Right: Active Category Inclusions (col-span-8 - Expanded & Filled with checklists/notes) -->
                <div class="col-span-8 relative min-h-[380px]">

                    <!-- Tab Content 1: Business Startup -->
                    <div class="drawer-tab-content block transition-all duration-300" id="drawer-tab-startup">
                        <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-6">Incorporation Directory</h4>
                        <div class="space-y-5">
                            <a href="#pvt-ltd" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Private Limited Company</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Direct MCA certificate setup including DIN, DSC, PAN, and TAN generation in 7-10 days.</p>
                                </div>
                            </a>
                            <a href="#llp" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Limited Liability Partnership (LLP)</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Lower compliance company setup best for consulting, advisory, and service partners.</p>
                                </div>
                            </a>
                            <a href="#opc" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">One Person Company (OPC)</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Single founder corporate legal entity with complete limited liability benefits.</p>
                                </div>
                            </a>
                            <a href="#partnership-firm" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Partnership Firm</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Drafted partnership deeds and registration under State Registrar guidelines.</p>
                                </div>
                            </a>
                            <a href="#proprietorship" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Proprietorship Setup</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Fast-track setup with GST and MSME credentials to open current accounts.</p>
                                </div>
                            </a>

                            <!-- Checklist / Notes Panel -->
                            <div class="mt-8 p-4 rounded-xl bg-slate-950 border border-slate-850 text-slate-400 space-y-2">
                                <h6 class="text-[10px] font-extrabold text-white uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-file-invoice text-brand-500"></i> Required Documents for Setup:</h6>
                                <p class="text-[10px] leading-relaxed">Aadhaar Card, PAN Card, Passport Size Photo, Utility Bill (Electricity/Water) of business address, and Rent Agreement.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content 2: Registrations -->
                    <div class="drawer-tab-content hidden transition-all duration-300" id="drawer-tab-registrations">
                        <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-6">Core Registrations</h4>
                        <div class="space-y-5">
                            <a href="#gst-reg" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">GST Registration</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Registration for CGST, SGST, IGST, and composition schemes for retail and e-commerce.</p>
                                </div>
                            </a>
                            <a href="#msme-reg" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">MSME / Udyam Certificate</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Claim interest concessions, credit guarantees, and government vendor privileges.</p>
                                </div>
                            </a>
                            <a href="#startup-india" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Startup India DPIIT Registration</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Get recognized by DPIIT to obtain income tax exemptions and patent subsidies.</p>
                                </div>
                            </a>
                            <a href="#iec" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Import Export Code (IEC)</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">DGFT registration code mandatory for cross-border trading and global logistics.</p>
                                </div>
                            </a>
                            <a href="#pf-esi-reg" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">PF & ESI Corporate Registration</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Provident fund and state health insurance portal registrations for staff.</p>
                                </div>
                            </a>
                            <a href="#gem-reg" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">GeM Portal Registration</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Register as a seller to participate in central and state government e-tenders.</p>
                                </div>
                            </a>

                            <!-- Checklist / Notes Panel -->
                            <div class="mt-8 p-4 rounded-xl bg-slate-950 border border-slate-850 text-slate-400 space-y-2">
                                <h6 class="text-[10px] font-extrabold text-white uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-clock text-brand-500"></i> Turnaround Timelines:</h6>
                                <p class="text-[10px] leading-relaxed">GST Registration: 3-5 days | MSME Udyam: 1 day | Import Export Code: 2 days. Fast digital delivery.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content 3: Licenses -->
                    <div class="drawer-tab-content hidden transition-all duration-300" id="drawer-tab-licenses">
                        <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-6">Government Permits</h4>
                        <div class="space-y-5">
                            <a href="#fssai" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">FSSAI License</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Food business registrations, state licenses, and central manufacturing approvals.</p>
                                </div>
                            </a>
                            <a href="#trade-license" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Trade License</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Municipal approvals ensuring your commercial facility is legal to operate.</p>
                                </div>
                            </a>
                            <a href="#shop-est" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Shop & Establishment Act</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Labor board registrations verifying employment and holiday rules compliance.</p>
                                </div>
                            </a>
                            <a href="#clra" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">CLRA Labour License</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Labor registration mandated for agencies hiring contractual workers.</p>
                                </div>
                            </a>
                            <a href="#lwf" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Labour Welfare Fund (LWF)</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">State welfare board filings mandatory for factories and retail businesses.</p>
                                </div>
                            </a>

                            <!-- Checklist / Notes Panel -->
                            <div class="mt-8 p-4 rounded-xl bg-slate-950 border border-slate-850 text-slate-400 space-y-2">
                                <h6 class="text-[10px] font-extrabold text-white uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-circle-info text-brand-500"></i> Important Regulatory Note:</h6>
                                <p class="text-[10px] leading-relaxed">FSSAI food licenses are graded as Basic, State, or Central based on annual turnover thresholds. Consult our legal expert for the correct class selection.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content 4: Certifications -->
                    <div class="drawer-tab-content hidden transition-all duration-300" id="drawer-tab-certifications">
                        <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-6">IPR & Quality Marks</h4>
                        <div class="space-y-5">
                            <a href="#trademark" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Trademark Registration</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Secure exclusive ownership of corporate logos, names, slogans, and symbols.</p>
                                </div>
                            </a>
                            <a href="#iso" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">ISO Quality Certificate</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">ISO 9001, 14001, and 27001 standard audits and certificates for businesses.</p>
                                </div>
                            </a>
                            <a href="#bis" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">BIS Certification</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">ISI product testing standards approval and licensing from BIS boards.</p>
                                </div>
                            </a>
                            <a href="#dsc" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Digital Signature (DSC)</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Secure Class 3 DSC keys mandatory for director signings and filings.</p>
                                </div>
                            </a>
                            <a href="#make-in-india" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Make in India</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Manufacturing credentials, subsidies, and global trading recognition.</p>
                                </div>
                            </a>

                            <!-- Checklist / Notes Panel -->
                            <div class="mt-8 p-4 rounded-xl bg-slate-950 border border-slate-850 text-slate-400 space-y-2">
                                <h6 class="text-[10px] font-extrabold text-white uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-shield text-brand-500"></i> Quality Audit Standards:</h6>
                                <p class="text-[10px] leading-relaxed">ISO quality audits are conducted by IRCA certified lead auditors. Full documentation support is provided by our compliance managers.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content 5: Taxation -->
                    <div class="drawer-tab-content hidden transition-all duration-300" id="drawer-tab-taxation">
                        <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-6">Filings & Regulatory Compliance</h4>
                        <div class="space-y-5">
                            <a href="#itr-filing" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Income Tax Return (ITR)</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Annual corporate taxes filing, profit audit preparation, and personal ITR filing.</p>
                                </div>
                            </a>
                            <a href="#gst-returns" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">GST Returns Filing</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Monthly GSTR-1 sales uploads, GSTR-3B tax challans, and annual GST audits.</p>
                                </div>
                            </a>
                            <a href="#roc" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">ROC Annual Compliances</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Annual MCA filings (AOC-4, MGT-7) ensuring your company stays active.</p>
                                </div>
                            </a>
                            <a href="#accounting" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Outsourced Bookkeeping</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Outsource ledger entries, monthly banking reconciliation, and balance sheets to CAs.</p>
                                </div>
                            </a>
                            <a href="#winding-up" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Winding Up of Company</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Dissolve and strike off your inactive company from MCA registers legally.</p>
                                </div>
                            </a>

                            <!-- Checklist / Notes Panel -->
                            <div class="mt-8 p-4 rounded-xl bg-slate-950 border border-slate-850 text-slate-400 space-y-2">
                                <h6 class="text-[10px] font-extrabold text-white uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-calendar-days text-brand-500"></i> Annual Compliance Calendar:</h6>
                                <p class="text-[10px] leading-relaxed">Corporate ROC annual returns filing due dates generally fall within 30 days of the AGM. Late filings attract penalty fees of ₹100/day.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content 6: NGO Setup -->
                    <div class="drawer-tab-content hidden transition-all duration-300" id="drawer-tab-ngo">
                        <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-6">NGO & Charitable Formations</h4>
                        <div class="space-y-5">
                            <a href="#section8" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Section 8 Company Setup</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Non-profit corporate structure registration with MCA and license approvals.</p>
                                </div>
                            </a>
                            <a href="#trust" class="group flex items-start gap-3.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">Trust & Society Registration</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Trust deeds drafting, society bylaws, and registration with sub-registrars.</p>
                                </div>
                            </a>
                            <a href="#12a-80g" class="group flex items-start gap-2.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">12A & 80G Tax Exemption</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Obtain tax-exempt credentials to receive donations and CSR grants.</p>
                                </div>
                            </a>
                            <a href="#csr-reg" class="group flex items-start gap-2.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">CSR-1 Registration</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Register with MCA to receive Corporate Social Responsibility funds.</p>
                                </div>
                            </a>
                            <a href="#fcra" class="group flex items-start gap-2.5">
                                <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                <div>
                                    <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug">FCRA Registration</h5>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Ministry of Home Affairs permit required to receive foreign donations.</p>
                                </div>
                            </a>

                            <!-- Checklist / Notes Panel -->
                            <div class="mt-8 p-4 rounded-xl bg-slate-950 border border-slate-850 text-slate-400 space-y-2">
                                <h6 class="text-[10px] font-extrabold text-white uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-hands-holding-child text-brand-500"></i> Deductions and Tax Exemptions:</h6>
                                <p class="text-[10px] leading-relaxed">Obtaining both 12A and 80G registrations allows donors to deduct up to 50% of charitable donations from their taxable income.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Bottom Accent Border -->
    <div class="h-1.5 w-full accent-gradient flex-shrink-0"></div>
</div>

<!-- Mega Drawer Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('mega-drawer-toggle');
        const closeBtn = document.getElementById('mega-drawer-close');
        const drawer = document.getElementById('mega-drawer');
        let isOpen = false;

        function openDrawer() {
            isOpen = true;
            drawer.classList.remove('-translate-y-full', 'opacity-0', 'pointer-events-none');
            drawer.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
            document.body.classList.add('overflow-hidden'); // Disable body scroll when full screen opens
        }

        function closeDrawer() {
            isOpen = false;
            drawer.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
            drawer.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
            document.body.classList.remove('overflow-hidden');
        }

        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (isOpen) closeDrawer();
            else openDrawer();
        });

        closeBtn.addEventListener('click', () => {
            closeDrawer();
        });

        // Close drawer when clicking outside content area
        drawer.addEventListener('click', (e) => {
            if (isOpen && e.target === drawer) {
                closeDrawer();
            }
        });

        // Tab Switching Hover Logic inside the Mega Drawer
        const tabBtns = document.querySelectorAll('.drawer-tab-btn');
        const tabContents = document.querySelectorAll('.drawer-tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                const targetId = btn.getAttribute('data-target');

                // Reset all tab headers (Clean menu text, no boxes/borders)
                tabBtns.forEach(b => {
                    b.classList.remove('text-brand-400');
                    b.classList.add('text-slate-300');
                    const icon = b.querySelector('.fa-arrow-right');
                    if (icon) {
                        icon.classList.remove('opacity-100', 'translate-x-0');
                        icon.classList.add('opacity-0', '-translate-x-2');
                    }
                });

                // Activate hovered tab
                btn.classList.add('text-brand-400');
                btn.classList.remove('text-slate-300');
                const activeIcon = btn.querySelector('.fa-arrow-right');
                if (activeIcon) {
                    activeIcon.classList.remove('opacity-0', '-translate-x-2');
                    activeIcon.classList.add('opacity-100', 'translate-x-0');
                }

                // Toggle visibility of panels
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('block');
                });

                const activeContent = document.getElementById(targetId);
                if (activeContent) {
                    activeContent.classList.remove('hidden');
                    activeContent.classList.add('block');
                }
            });
        });

        // Search Autocomplete and Scroll-To Logic
        const searchSections = [
            { id: '#about', title: 'About Zenvora / Compliance Partner', desc: 'Overview of CA/CS team & legal partner history', keys: ['about', 'partner', 'trusted', 'expert', 'history', 'lawyer', 'legal'] },
            { id: '#process', title: 'Simplified Onboarding / 4 Steps', desc: 'Timeline showing document submission & delivery', keys: ['process', 'onboarding', 'how it works', 'steps', 'workflow', 'filing', 'delivery'] },
            { id: '#why-choose-us', title: 'Why Zenvora / Growth Benefits', desc: 'Startup-engineered speed, cloud vault & CA advisory', keys: ['why', 'benefits', 'speed', 'incorporation', 'vault', 'billing', 'growth'] },
            { id: '#stats', title: 'Zenvora Metrics / Compliance Score', desc: '99.8% filing accuracy and active users', keys: ['stats', 'metrics', 'numbers', 'accuracy', 'turnaround', 'experts'] },
            { id: '#pricing', title: 'Pricing Packages / Flat Fees', desc: 'Flexible packages for early and scaling startups', keys: ['pricing', 'pricing plans', 'packages', 'fees', 'costs', 'charges'] },
            { id: '#contact', title: 'Book Consultation / Help Desk', desc: 'Capture form to speak directly with an advisor', keys: ['contact', 'book call', 'phone', 'email', 'support', 'help', 'advisory'] }
        ];

        function handleSearchInput(inputEl, resultsEl) {
            const query = inputEl.value.toLowerCase().trim();
            if (query === '') {
                resultsEl.classList.add('hidden');
                return;
            }

            const matches = searchSections.filter(sec => {
                return sec.title.toLowerCase().includes(query) ||
                       sec.desc.toLowerCase().includes(query) ||
                       sec.keys.some(k => k.includes(query));
            });

            if (matches.length === 0) {
                resultsEl.innerHTML = `
                    <div class="p-3 text-[10px] text-slate-450 font-bold text-center">
                        No matching sections found.
                    </div>
                `;
            } else {
                resultsEl.innerHTML = matches.map(match => `
                    <button type="button" class="search-result-btn w-full text-left p-2.5 hover:bg-slate-50 rounded-xl transition-colors flex flex-col" data-target="${match.id}">
                        <span class="text-[11px] font-extrabold text-slate-900 flex items-center gap-1.5">
                            <i class="fa-solid fa-arrow-turn-up text-brand-500 text-[9px] rotate-90"></i> ${match.title}
                        </span>
                        <span class="text-[9px] text-slate-400 font-semibold mt-0.5">${match.desc}</span>
                    </button>
                `).join('');

                resultsEl.querySelectorAll('.search-result-btn').forEach(btn => {
                    btn.addEventListener('mousedown', (e) => {
                        e.preventDefault();
                        const targetId = btn.getAttribute('data-target');
                        inputEl.value = '';
                        resultsEl.classList.add('hidden');
                        navigateToSection(targetId);
                    });
                });
            }
            resultsEl.classList.remove('hidden');
        }

        function navigateToSection(targetId) {
            const path = window.location.pathname;
            const isHomePage = path.endsWith('index.php') || path.endsWith('/') || !path.includes('.php');
            
            if (!isHomePage) {
                window.location.href = 'index.php' + targetId;
            } else {
                const targetEl = document.querySelector(targetId);
                if (targetEl) {
                    targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    targetEl.classList.remove('glow-section');
                    void targetEl.offsetWidth; // Reflow
                    targetEl.classList.add('glow-section');
                    
                    setTimeout(() => {
                        targetEl.classList.remove('glow-section');
                    }, 2500);
                }
            }
        }

        const dInput = document.getElementById('site-search');
        const dResults = document.getElementById('search-results');
        if (dInput && dResults) {
            dInput.addEventListener('input', () => handleSearchInput(dInput, dResults));
            dInput.addEventListener('blur', () => setTimeout(() => dResults.classList.add('hidden'), 200));
            dInput.addEventListener('focus', () => {
                if (dInput.value.trim() !== '') dResults.classList.remove('hidden');
            });
        }

        const mInput = document.getElementById('site-search-mobile');
        const mResults = document.getElementById('search-results-mobile');
        if (mInput && mResults) {
            mInput.addEventListener('input', () => handleSearchInput(mInput, mResults));
            mInput.addEventListener('blur', () => setTimeout(() => mResults.classList.add('hidden'), 200));
            mInput.addEventListener('focus', () => {
                if (mInput.value.trim() !== '') mResults.classList.remove('hidden');
            });
        }
    });
</script>