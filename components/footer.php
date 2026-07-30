<?php
/**
 * Zenvora Global Solutions - Premium Dynamic Directory Footer Component
 * Renders all 6 service categories, contact details, social links, and quick page links dynamically from database.
 */

// Dynamic Navigation Footer Categories (Fetch all 6 categories)
$footer_categories = [];
if (isset($pdo) && $pdo !== null) {
    try {
        $footer_categories = $pdo->query("SELECT * FROM service_categories ORDER BY sort_order ASC, id ASC LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $footer_categories = [];
    }
}

if (empty($footer_categories)) {
    // Dynamic Fallback Footer configuration
    $footer_categories = [
        [
            'name' => 'Business Setup',
            'services' => [
                ['title' => 'Private Limited Company', 'slug' => 'private-limited-company'],
                ['title' => 'Limited Liability Partnership', 'slug' => 'limited-liability-partnership'],
                ['title' => 'One Person Company (OPC)', 'slug' => 'one-person-company'],
                ['title' => 'Partnership Firm Setup', 'slug' => 'partnership-firm'],
                ['title' => 'Proprietorship Registration', 'slug' => 'proprietorship-registration']
            ]
        ],
        [
            'name' => 'Registrations',
            'services' => [
                ['title' => 'GST Registration', 'slug' => 'gst-registration'],
                ['title' => 'MSME (Udyam) Registration', 'slug' => 'msme-udyam'],
                ['title' => 'Startup India DPIIT', 'slug' => 'startup-india'],
                ['title' => 'Import Export Code (IEC)', 'slug' => 'import-export-code'],
                ['title' => 'PF & ESI Registration', 'slug' => 'pf-esi-registration']
            ]
        ],
        [
            'name' => 'Licenses',
            'services' => [
                ['title' => 'FSSAI Food License', 'slug' => 'fssai-food-license'],
                ['title' => 'Trade License (Municipal)', 'slug' => 'trade-license'],
                ['title' => 'Shop & Establishment', 'slug' => 'shop-establishment'],
                ['title' => 'CLRA Labour License', 'slug' => 'clra-contract-labour'],
                ['title' => 'Professional Tax', 'slug' => 'professional-tax']
            ]
        ],
        [
            'name' => 'Certifications',
            'services' => [
                ['title' => 'ISO Certification', 'slug' => 'iso-certification'],
                ['title' => 'Trademark Registration', 'slug' => 'trademark-registration'],
                ['title' => 'BIS Certification', 'slug' => 'bis-certification'],
                ['title' => 'Fire Safety NOC', 'slug' => 'fire-safety-noc'],
                ['title' => 'DSC Class 3 Sign', 'slug' => 'dsc-class-3']
            ]
        ],
        [
            'name' => 'Tax & Compliance',
            'services' => [
                ['title' => 'Income Tax Return (ITR)', 'slug' => 'itr-filing'],
                ['title' => 'GST Return Filing', 'slug' => 'gst-return'],
                ['title' => 'ROC Annual Compliances', 'slug' => 'roc-annual-compliances'],
                ['title' => 'Accounting & Bookkeeping', 'slug' => 'accounting-bookkeeping'],
                ['title' => 'Company Winding Up', 'slug' => 'company-winding-up']
            ]
        ],
        [
            'name' => 'NGO Registration',
            'services' => [
                ['title' => 'Trust Registration', 'slug' => 'trust-registration'],
                ['title' => 'Society Registration', 'slug' => 'society-registration'],
                ['title' => 'Section 8 Company Setup', 'slug' => 'section-8-company'],
                ['title' => '12A & 80G Tax Exemptions', 'slug' => '12a-80g-exemption'],
                ['title' => 'CSR-1 Registration', 'slug' => 'csr-1-registration']
            ]
        ]
    ];
} else {
    foreach ($footer_categories as &$cat) {
        $srvStmt = $pdo->prepare("SELECT title, slug FROM services WHERE category_id = :cat_id ORDER BY id ASC LIMIT 5");
        $srvStmt->execute([':cat_id' => $cat['id']]);
        $cat['services'] = $srvStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($cat);
}
?>
<!-- Zenvora Global Solutions Footer Component (Dark Slate Theme, Multi-Column, Flat Design, Huge Watermark) -->
<footer class="relative bg-slate-900 text-slate-400 text-xs py-16 border-t border-slate-800 overflow-hidden">
    
    <!-- Content Wrapper -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 relative z-10">
        
        <!-- Top Row: Branding Info + Quick Navigation Links + Contact Support Info Desk -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-slate-800 items-start">
            
            <!-- Brand Info (Col span 4) -->
            <div class="md:col-span-4 space-y-4 text-left">
                <div class="flex items-center gap-3">
                    <img class="h-8 w-auto opacity-95" src="<?php echo getWebSetting('logo_url'); ?>" alt="Zenvora Logo">
                    <span class="font-extrabold text-brand-400 tracking-widest text-sm">ZENVORA</span>
                </div>
                <p class="leading-relaxed text-slate-400 text-[11px] max-w-sm">
                    Unified legal, tax, and NGO compliance infrastructure engineered for modern Indian startups and global enterprises. Direct online access to CA panel desks.
                </p>
                <!-- Social media icons -->
                <div class="flex gap-2">
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_facebook')); ?>" target="_blank" class="w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-facebook-f text-[10px]"></i>
                    </a>
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_twitter')); ?>" target="_blank" class="w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-twitter text-[10px]"></i>
                    </a>
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_linkedin')); ?>" target="_blank" class="w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-linkedin-in text-[10px]"></i>
                    </a>
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_instagram')); ?>" target="_blank" class="w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-instagram text-[10px]"></i>
                    </a>
                    <?php if (getWebSetting('social_youtube') !== '#' && getWebSetting('social_youtube') !== ''): ?>
                    <a href="<?php echo htmlspecialchars(getWebSetting('social_youtube')); ?>" target="_blank" class="w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-youtube text-[10px]"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Col 2: Quick Links (Col span 3) -->
            <div class="md:col-span-3 space-y-4 text-left">
                <h4 class="text-xs font-extrabold uppercase tracking-widest text-brand-400 border-b border-slate-850 pb-2">
                    Quick Navigation
                </h4>
                <ul class="space-y-2 text-[11px]">
                    <li><a href="index.php" class="hover:text-brand-400 transition-colors">Home Page</a></li>
                    <li><a href="about.php" class="hover:text-brand-400 transition-colors">About Zenvora</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Services Directory</a></li>
                    <li><a href="blog.php" class="hover:text-brand-400 transition-colors">Compliance Blog</a></li>
                    <li><a href="faqs.php" class="hover:text-brand-400 transition-colors">FAQs Desk</a></li>
                    <li><a href="contact.php" class="hover:text-brand-400 transition-colors">Contact Support</a></li>
                </ul>
            </div>

            <!-- Col 3: Contact Info Desk (Col span 5) -->
            <div class="md:col-span-5 space-y-4 text-left">
                <h4 class="text-xs font-extrabold uppercase tracking-widest text-brand-400 border-b border-slate-850 pb-2">
                    Get In Touch
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-[11px] leading-relaxed">
                    <!-- Column Left: Phone & Email -->
                    <div class="space-y-3.5">
                        <?php 
                        $footerPhones = getWebPhones();
                        if (!empty($footerPhones)): 
                        ?>
                        <div class="space-y-1">
                            <span class="text-[9px] font-bold text-slate-550 block uppercase tracking-wider">Phone Support</span>
                            <?php foreach ($footerPhones as $phone): ?>
                                <a href="tel:<?php echo htmlspecialchars($phone['value']); ?>" class="block hover:text-brand-400 transition-colors font-semibold text-slate-300">
                                    <i class="fa-solid fa-phone text-brand-500 mr-1 text-[10px]"></i> <?php echo htmlspecialchars($phone['value']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <div class="space-y-1">
                            <span class="text-[9px] font-bold text-slate-550 block uppercase tracking-wider">Official Email</span>
                            <a href="mailto:<?php echo getWebSetting('email_1'); ?>" class="block hover:text-brand-400 transition-colors font-semibold text-slate-300">
                                <i class="fa-solid fa-envelope text-brand-500 mr-1 text-[10px]"></i> <?php echo getWebSetting('email_1'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Column Right: Addresses -->
                    <div>
                        <?php 
                        $footerAddresses = getWebAddresses();
                        if (!empty($footerAddresses)): 
                        ?>
                        <div class="space-y-2">
                            <span class="text-[9px] font-bold text-slate-550 block uppercase tracking-wider">Office Location</span>
                            <?php foreach ($footerAddresses as $addr): ?>
                                <div class="text-slate-300 leading-normal">
                                    <strong class="text-slate-450"><?php echo htmlspecialchars($addr['label']); ?>:</strong>
                                    <span class="text-slate-400 block text-[10px] mt-0.5"><?php echo htmlspecialchars($addr['value']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- Middle Row: 6-Column Service Categories Directory Grid -->
        <div class="space-y-6">
            <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest block text-left">Complete Compliance Services Directory</span>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-8 text-left">
                <?php foreach ($footer_categories as $f_cat): ?>
                <!-- Category Column -->
                <div class="space-y-4">
                    <h4 class="text-[11px] font-extrabold uppercase tracking-widest text-brand-400 border-b border-slate-850 pb-2">
                        <?php echo htmlspecialchars($f_cat['name']); ?>
                    </h4>
                    <ul class="space-y-2.5 text-[11px]">
                        <?php if (empty($f_cat['services'])): ?>
                        <li class="italic text-slate-550">Coming soon...</li>
                        <?php endif; ?>
                        <?php foreach (($f_cat['services'] ?? []) as $f_srv): ?>
                        <li>
                            <a href="service-detail.php?slug=<?php echo htmlspecialchars($f_srv['slug']); ?>" class="hover:text-brand-400 text-slate-450 transition-colors">
                                <?php echo htmlspecialchars($f_srv['title']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Bottom Row: Copyright & CIN -->
        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 text-[10px] text-slate-500 relative z-10">
            <div class="space-y-1 text-left">
                <p>&copy; 2026 Zenvora Global Solutions Private Limited. All rights reserved.</p>
                <p class="text-slate-650">CIN: U74999UP2018PTC105187 | MCA Registered Corporate Agent</p>
                <p class="text-slate-650 mt-1.5 leading-normal max-w-3xl">
                    <strong class="text-brand-400">CA Advisory Note:</strong> Outsource your legal, tax, and NGO registrations to our panel of CAs & lawyers. Every process is supervised and verified directly by qualified professionals.
                </p>
            </div>
            
            <div class="flex-shrink-0 text-left md:text-right space-y-1">
                <span class="text-[9px] font-bold text-slate-450 block uppercase tracking-widest">Client Desk Support</span>
                <span class="text-slate-300 block">Mon - Sat: 9:30 AM - 6:30 PM</span>
            </div>
        </div>

    </div>

    <!-- Massive decorative background watermark (Centered & Perfectly Visible) -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-slate-950/30 text-[16vw] font-black tracking-widest uppercase select-none pointer-events-none z-0">
        ZENVORA
    </div>
</footer>

<!-- Floating CA/CS Advisory Action Desk -->
<div class="fixed bottom-6 right-6 z-50 flex flex-col gap-3.5 items-end">
    
    <!-- Call Helpline Action Button -->
    <?php
    $webPhones = getWebPhones();
    $callPhone = !empty($webPhones) ? reset($webPhones)['value'] : '+91 98765 43210';
    $whatsappNum = getWebSetting('whatsapp_number') ?: '9876543210';
    ?>
    <div class="relative group">
        <!-- Floating Tooltip -->
        <span class="absolute right-14 top-1/2 -translate-y-1/2 px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-[9px] font-black text-white uppercase tracking-wider opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-300 shadow-xl whitespace-nowrap font-sans">
            Call a CA Helpline
        </span>
        <!-- Pulsing Wave Ring behind button -->
        <span class="absolute inset-0 rounded-full bg-brand-500/40 animate-ping opacity-75"></span>
        <!-- Main Floating Button -->
        <a href="tel:<?php echo htmlspecialchars($callPhone); ?>" 
           class="relative w-12 h-12 rounded-full accent-gradient border border-brand-400 hover:border-brand-300 text-white flex items-center justify-center shadow-lg transition-transform duration-300 hover:scale-110 hover:-rotate-12 group-hover:shadow-brand-500/20">
            <i class="fa-solid fa-phone text-sm animate-bounce-slow"></i>
        </a>
    </div>

    <!-- WhatsApp Support Action Button -->
    <div class="relative group">
        <!-- Floating Tooltip -->
        <span class="absolute right-14 top-1/2 -translate-y-1/2 px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-[9px] font-black text-white uppercase tracking-wider opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-300 shadow-xl whitespace-nowrap font-sans">
            Chat on WhatsApp
        </span>
        <!-- Pulsing Wave Ring behind button -->
        <span class="absolute inset-0 rounded-full bg-emerald-500/40 animate-ping opacity-75"></span>
        <!-- Main Floating Button -->
        <a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $whatsappNum)); ?>" target="_blank"
           class="relative w-12 h-12 rounded-full bg-emerald-600 border border-emerald-500 hover:border-emerald-400 text-white flex items-center justify-center shadow-lg transition-transform duration-300 hover:scale-110 hover:rotate-12 group-hover:shadow-emerald-500/20">
            <i class="fa-brands fa-whatsapp text-lg"></i>
        </a>
    </div>

</div>

<!-- Additional custom styles for Floating FAB elements -->
<style>
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-2px);
        }
    }
    .animate-bounce-slow {
        animation: bounce-slow 2s infinite ease-in-out;
    }
</style>

<?php
// Load global welcome lead generation popup modal (shows once per device)
include_once 'components/welcome-popup.php';

// Custom Footer Scripts (For chatbot integrations, body trackers, etc.)
$custom_footer = getWebSetting('seo_custom_footer');
if (!empty($custom_footer)) {
    echo $custom_footer . "\n";
}
?>
