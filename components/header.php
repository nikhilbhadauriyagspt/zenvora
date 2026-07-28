<?php
// Dynamic Navigation Megamenu
$nav_categories = [];
$search_services = [];
if (isset($pdo) && $pdo !== null) {
    try {
        $nav_categories = $pdo->query("SELECT * FROM service_categories ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
        $search_services = $pdo->query("SELECT title, slug, tagline FROM services ORDER BY title ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $nav_categories = [];
        $search_services = [];
    }
}

if (empty($nav_categories)) {
    // Dynamic Fallback Megamenu configuration
    $nav_categories = [
        [
            'name' => 'Business Setup',
            'slug' => 'business-startup',
            'icon' => 'fa-solid fa-rocket',
            'services' => [
                ['title' => 'Private Limited Company', 'slug' => 'private-limited-company', 'icon' => 'fa-solid fa-building'],
                ['title' => 'Limited Liability Partnership (LLP)', 'slug' => 'limited-liability-partnership', 'icon' => 'fa-solid fa-people-carry-box'],
                ['title' => 'One Person Company (OPC)', 'slug' => 'one-person-company', 'icon' => 'fa-solid fa-user-tie'],
                ['title' => 'Partnership Firm Setup', 'slug' => 'partnership-firm', 'icon' => 'fa-solid fa-user-group'],
                ['title' => 'Proprietorship Registration', 'slug' => 'proprietorship-registration', 'icon' => 'fa-solid fa-user']
            ]
        ],
        [
            'name' => 'Registrations',
            'slug' => 'registrations',
            'icon' => 'fa-solid fa-receipt',
            'services' => [
                ['title' => 'GST Registration', 'slug' => 'gst-registration', 'icon' => 'fa-solid fa-receipt'],
                ['title' => 'MSME (Udyam) Registration', 'slug' => 'msme-udyam', 'icon' => 'fa-solid fa-briefcase'],
                ['title' => 'Startup India DPIIT Recognition', 'slug' => 'startup-india', 'icon' => 'fa-solid fa-flag'],
                ['title' => 'Import Export Code (IEC)', 'slug' => 'import-export-code', 'icon' => 'fa-solid fa-globe'],
                ['title' => 'PF & ESI Registration', 'slug' => 'pf-esi-registration', 'icon' => 'fa-solid fa-users']
            ]
        ],
        [
            'name' => 'Licenses & IPR',
            'slug' => 'licenses',
            'icon' => 'fa-solid fa-scale-balanced',
            'services' => [
                ['title' => 'FSSAI Food License', 'slug' => 'fssai-food-license', 'icon' => 'fa-solid fa-utensils'],
                ['title' => 'Trade License (Municipal)', 'slug' => 'trade-license', 'icon' => 'fa-solid fa-scale-balanced'],
                ['title' => 'Shop & Establishment (Shop Act)', 'slug' => 'shop-establishment', 'icon' => 'fa-solid fa-store'],
                ['title' => 'Trademark (TM) Registration', 'slug' => 'trademark-registration', 'icon' => 'fa-solid fa-copyright']
            ]
        ],
        [
            'name' => 'NGO & Taxation',
            'slug' => 'tax-compliance',
            'icon' => 'fa-solid fa-calculator',
            'services' => [
                ['title' => 'Trust Registration', 'slug' => 'trust-registration', 'icon' => 'fa-solid fa-handshake-angle'],
                ['title' => 'Society Registration', 'slug' => 'society-registration', 'icon' => 'fa-solid fa-users-rectangle'],
                ['title' => 'Section 8 Company Setup', 'slug' => 'section-8-company', 'icon' => 'fa-solid fa-heart-solid'],
                ['title' => 'Income Tax Return (ITR) Filing', 'slug' => 'itr-filing', 'icon' => 'fa-solid fa-calculator'],
                ['title' => 'GST Return Filing', 'slug' => 'gst-return', 'icon' => 'fa-solid fa-file-invoice-dollar']
            ]
        ]
    ];
    $search_services = [
        ['title' => 'Private Limited Company', 'slug' => 'private-limited-company', 'tagline' => 'Registration in India'],
        ['title' => 'Limited Liability Partnership (LLP)', 'slug' => 'limited-liability-partnership', 'tagline' => 'Incorporate your LLP online'],
        ['title' => 'One Person Company (OPC)', 'slug' => 'one-person-company', 'tagline' => 'Perfect setup for solo founders'],
        ['title' => 'GST Registration', 'slug' => 'gst-registration', 'tagline' => 'Secure your Tax Identification ID'],
        ['title' => 'MSME (Udyam) Registration', 'slug' => 'msme-udyam', 'tagline' => 'Claim central startup benefits'],
        ['title' => 'Trademark (TM) Registration', 'slug' => 'trademark-registration', 'tagline' => 'Secure brand logo and company names'],
        ['title' => 'FSSAI Food License', 'slug' => 'fssai-food-license', 'tagline' => 'Food Safety registry clearance'],
        ['title' => 'Income Tax Return (ITR) Filing', 'slug' => 'itr-filing', 'tagline' => 'Personal & corporate tax filings']
    ];
} else {
    foreach ($nav_categories as &$cat) {
        $srvStmt = $pdo->prepare("SELECT title, slug FROM services WHERE category_id = :cat_id ORDER BY id ASC");
        $srvStmt->execute([':cat_id' => $cat['id']]);
        $cat['services'] = $srvStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($cat);
}
?>
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
                <a href="<?php echo htmlspecialchars(getWebSetting('social_facebook')); ?>" target="_blank" class="hover:text-brand-400 transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="<?php echo htmlspecialchars(getWebSetting('social_twitter')); ?>" target="_blank" class="hover:text-brand-400 transition-colors"><i class="fa-brands fa-twitter"></i></a>
                <a href="<?php echo htmlspecialchars(getWebSetting('social_linkedin')); ?>" target="_blank" class="hover:text-brand-400 transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="<?php echo htmlspecialchars(getWebSetting('social_instagram')); ?>" target="_blank" class="hover:text-brand-400 transition-colors"><i class="fa-brands fa-instagram"></i></a>
                <?php if (getWebSetting('social_youtube') !== '#' && getWebSetting('social_youtube') !== ''): ?>
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_youtube')); ?>" target="_blank" class="hover:text-brand-400 transition-colors"><i class="fa-brands fa-youtube"></i></a>
                <?php endif; ?>
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
                    <img class="h-20 w-auto "
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
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-12 gap-8 text-left">

                            <?php foreach ($nav_categories as $n_cat): ?>
                                <!-- Col: <?php echo htmlspecialchars($n_cat['name']); ?> -->
                                <div class="col-span-12 sm:col-span-6 lg:col-span-3 space-y-4">
                                    <h3 class="text-xs font-extrabold text-brand-600 hover:text-brand-500 uppercase tracking-widest border-b border-slate-100 pb-2 transition-colors">
                                        <a href="category.php?slug=<?php echo htmlspecialchars($n_cat['slug'] ?? ''); ?>" class="block flex items-center justify-between">
                                            <span><?php echo htmlspecialchars($n_cat['name']); ?></span>
                                            <i class="fa-solid fa-chevron-right text-[8px] opacity-75"></i>
                                        </a>
                                    </h3>
                                    <div class="space-y-3">
                                        <?php if (empty($n_cat['services'])): ?>
                                            <span class="text-[10px] text-slate-400 font-semibold block italic">Coming soon...</span>
                                        <?php endif; ?>
                                        <?php foreach ($n_cat['services'] as $n_srv): ?>
                                            <a href="service-detail.php?slug=<?php echo htmlspecialchars($n_srv['slug']); ?>" class="flex items-start gap-2.5 text-slate-700 hover:text-brand-600 transition-colors group/link">
                                                <i class="fa-solid fa-circle-check text-slate-350 group-hover/link:text-brand-500 mt-0.5 text-xs"></i>
                                                <span class="text-xs font-semibold"><?php echo htmlspecialchars($n_srv['title']); ?></span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

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
                    <input type="text" id="site-search" placeholder="Search services..."
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
                <input type="text" id="site-search-mobile" placeholder="Search services..."
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

                <?php foreach ($nav_categories as $m_cat): ?>
                    <div class="space-y-1.5 pl-3 text-left">
                        <a href="category.php?slug=<?php echo htmlspecialchars($m_cat['slug'] ?? ''); ?>" class="block px-3 py-0.5 text-xs font-bold text-brand-600 uppercase hover:text-brand-500 transition-colors"><?php echo htmlspecialchars($m_cat['name']); ?></a>
                        <?php if (empty($m_cat['services'])): ?>
                            <span class="block pl-6 pr-3 py-0.5 text-xs text-slate-400 italic">Coming soon...</span>
                        <?php endif; ?>
                        <?php foreach (($m_cat['services'] ?? []) as $m_srv): ?>
                            <a href="service-detail.php?slug=<?php echo htmlspecialchars($m_srv['slug']); ?>" class="block pl-6 pr-3 py-1 text-sm text-slate-655 hover:text-slate-900">
                                <?php echo htmlspecialchars($m_srv['title']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
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
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_facebook')); ?>" target="_blank" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center text-xs transition-all"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_twitter')); ?>" target="_blank" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center text-xs transition-all"><i class="fa-brands fa-twitter"></i></a>
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_linkedin')); ?>" target="_blank" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center text-xs transition-all"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_instagram')); ?>" target="_blank" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center text-xs transition-all"><i class="fa-brands fa-instagram"></i></a>
                    <?php if (getWebSetting('social_youtube') !== '#' && getWebSetting('social_youtube') !== ''): ?>
                        <a href="<?php echo htmlspecialchars(getWebSetting('social_youtube')); ?>" target="_blank" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center text-xs transition-all"><i class="fa-brands fa-youtube"></i></a>
                    <?php endif; ?>
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

                    <?php foreach ($nav_categories as $t_idx => $t_cat):
                        $target_id = 'drawer-tab-' . htmlspecialchars($t_cat['slug']);
                    ?>
                        <button class="drawer-tab-btn <?php echo $t_idx === 0 ? 'active text-brand-400' : 'text-slate-300 hover:text-white'; ?> text-left text-lg font-bold transition-all flex items-center justify-between group/tab" data-target="<?php echo $target_id; ?>">
                            <span><?php echo htmlspecialchars($t_cat['name']); ?></span>
                            <i class="fa-solid fa-arrow-right text-xs <?php echo $t_idx === 0 ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-2 group-hover/tab:opacity-100 group-hover/tab:translate-x-0'; ?> transition-all duration-300"></i>
                        </button>
                    <?php endforeach; ?>

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
                    </div> <!-- Close Trust card -->
                </div> <!-- Close Left Side col-span-4 -->

                <!-- Right: Active Category Inclusions (col-span-8 - Expanded & Filled with checklists/notes) -->
                <div class="col-span-8 relative min-h-[380px]">

                    <?php foreach ($nav_categories as $t_idx => $t_cat):
                        $target_id = 'drawer-tab-' . htmlspecialchars($t_cat['slug']);
                    ?>
                        <!-- Tab Content: <?php echo htmlspecialchars($t_cat['name']); ?> -->
                        <div class="drawer-tab-content <?php echo $t_idx === 0 ? 'block' : 'hidden'; ?> transition-all duration-300" id="<?php echo $target_id; ?>">
                            <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-6">
                                <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest"><?php echo htmlspecialchars($t_cat['name']); ?> Directory</h4>
                                <a href="category.php?slug=<?php echo htmlspecialchars($t_cat['slug'] ?? ''); ?>" class="text-[10px] font-black uppercase tracking-wider text-brand-400 hover:text-brand-300 flex items-center gap-1.5 transition-colors">
                                    Category Hub <i class="fa-solid fa-up-right-from-square text-[8px]"></i>
                                </a>
                            </div>
                            <div class="space-y-5 text-left">
                                <?php if (empty($t_cat['services'])): ?>
                                    <span class="text-xs text-slate-400 italic block">No services configured under this category yet.</span>
                                <?php endif; ?>
                                <?php foreach (($t_cat['services'] ?? []) as $t_srv): ?>
                                    <a href="service-detail.php?slug=<?php echo htmlspecialchars($t_srv['slug']); ?>" class="group flex items-start gap-3.5">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-1.5 text-base"></i>
                                        <div>
                                            <h5 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors leading-snug"><?php echo htmlspecialchars($t_srv['title']); ?></h5>
                                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Dynamic corporate processing page. Outsource your application pipeline to our panel of CA advisors.</p>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

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
            // Home page sections
            { id: '#about', title: 'About Zenvora / Compliance Partner', desc: 'Overview of CA/CS team & legal partner history', keys: ['about', 'partner', 'trusted', 'expert', 'history', 'lawyer', 'legal'] },
            { id: '#process', title: 'Simplified Onboarding / 4 Steps', desc: 'Timeline showing document submission & delivery', keys: ['process', 'onboarding', 'how it works', 'steps', 'workflow', 'filing', 'delivery'] },
            { id: '#why-choose-us', title: 'Why Zenvora / Growth Benefits', desc: 'Startup-engineered speed, cloud vault & CA advisory', keys: ['why', 'benefits', 'speed', 'incorporation', 'vault', 'billing', 'growth'] },
            { id: '#stats', title: 'Zenvora Metrics / Compliance Score', desc: '99.8% filing accuracy and active users', keys: ['stats', 'metrics', 'numbers', 'accuracy', 'turnaround', 'experts'] },
            { id: '#pricing', title: 'Pricing Packages / Flat Fees', desc: 'Flexible packages for early and scaling startups', keys: ['pricing', 'pricing plans', 'packages', 'fees', 'costs', 'charges'] },
            { id: '#contact', title: 'Book Consultation / Help Desk', desc: 'Capture form to speak directly with an advisor', keys: ['contact', 'book call', 'phone', 'email', 'support', 'help', 'advisory'] },
            
            // Dynamic services
            <?php foreach ($search_services as $s_item): ?>
            {
                slug: '<?php echo addslashes($s_item['slug']); ?>',
                title: '<?php echo addslashes($s_item['title']); ?>',
                desc: '<?php echo addslashes($s_item['tagline']); ?>',
                keys: ['service', '<?php echo strtolower(addslashes($s_item['title'])); ?>', '<?php echo strtolower(addslashes($s_item['tagline'])); ?>']
            },
            <?php endforeach; ?>
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
                        No matching services or sections found.
                    </div>
                `;
            } else {
                resultsEl.innerHTML = matches.map(match => {
                    const isService = !!match.slug;
                    const iconHtml = isService 
                        ? `<i class="fa-solid fa-gears text-brand-500 text-[10px]"></i>` 
                        : `<i class="fa-solid fa-arrow-turn-up text-brand-500 text-[9px] rotate-90"></i>`;
                    const typeLabel = isService ? 'Service' : 'Section';
                    return `
                        <button type="button" class="search-result-btn w-full text-left p-2.5 hover:bg-slate-50 rounded-xl transition-colors flex flex-col" 
                                data-type="${isService ? 'service' : 'section'}" 
                                data-target="${isService ? match.slug : match.id}">
                            <span class="text-[11px] font-extrabold text-slate-900 flex items-center gap-1.5">
                                ${iconHtml} ${match.title}
                                <span class="ml-auto text-[8px] text-slate-400 border border-slate-200 px-1.5 py-0.5 rounded uppercase font-semibold">${typeLabel}</span>
                            </span>
                            <span class="text-[9px] text-slate-400 font-semibold mt-0.5">${match.desc}</span>
                        </button>
                    `;
                }).join('');

                resultsEl.querySelectorAll('.search-result-btn').forEach(btn => {
                    btn.addEventListener('mousedown', (e) => {
                        e.preventDefault();
                        const type = btn.getAttribute('data-type');
                        const target = btn.getAttribute('data-target');
                        inputEl.value = '';
                        resultsEl.classList.add('hidden');
                        
                        if (type === 'service') {
                            window.location.href = 'service-detail.php?slug=' + encodeURIComponent(target);
                        } else {
                            navigateToSection(target);
                        }
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
                    targetEl.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

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

        // Mobile Menu Toggle logic
        const mobileMenuBtn = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIconOpen = document.getElementById('menu-icon-open');
        const menuIconClose = document.getElementById('menu-icon-close');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
                mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
                
                // Toggle mobile menu visibility
                mobileMenu.classList.toggle('hidden');
                
                // Toggle hamburger and close icons
                if (menuIconOpen && menuIconClose) {
                    menuIconOpen.classList.toggle('hidden');
                    menuIconClose.classList.toggle('hidden');
                }
            });
        }
    });
</script>