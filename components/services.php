<?php
/**
 * Zenvora Global Solutions - Services Cards Component
 * Renders categories and associated sub-services dynamically from the database.
 * Integrates bulletproof PHP static fallback array if DB connection is empty.
 */

// Dynamic Catalog query
$db_categories = [];
if (isset($pdo) && $pdo !== null) {
    try {
        $db_categories = $pdo->query("SELECT * FROM service_categories ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $db_categories = [];
    }
}

if (empty($db_categories)) {
    // Dynamic Fallback in case database is empty or not loaded yet
    $db_categories = [
        [
            'name' => 'Business Startup',
            'icon' => 'fa-solid fa-rocket',
            'image_url' => 'assets/images/service_incorporation.jpg',
            'services' => [
                ['title' => 'Private Limited Company', 'slug' => 'private-limited-company'],
                ['title' => 'Limited Liability Partnership (LLP)', 'slug' => 'limited-liability-partnership'],
                ['title' => 'One Person Company (OPC)', 'slug' => 'one-person-company'],
                ['title' => 'Partnership Firm Setup', 'slug' => 'partnership-firm'],
                ['title' => 'Proprietorship Registration', 'slug' => 'proprietorship-registration']
            ]
        ],
        [
            'name' => 'Registrations',
            'icon' => 'fa-solid fa-receipt',
            'image_url' => 'assets/images/hero_bg.jpg',
            'services' => [
                ['title' => 'GST Registration', 'slug' => 'gst-registration'],
                ['title' => 'MSME (Udyam) Registration', 'slug' => 'msme-udyam'],
                ['title' => 'Startup India DPIIT Recognition', 'slug' => 'startup-india'],
                ['title' => 'Import Export Code (IEC)', 'slug' => 'import-export-code'],
                ['title' => 'PF & ESI Registration', 'slug' => 'pf-esi-registration'],
                ['title' => 'GEM Portal Registration', 'slug' => 'gem-portal-registration']
            ]
        ],
        [
            'name' => 'Licenses',
            'icon' => 'fa-solid fa-scale-balanced',
            'image_url' => 'assets/images/hero_bg_4.jpg',
            'services' => [
                ['title' => 'FSSAI Food License', 'slug' => 'fssai-food-license'],
                ['title' => 'Trade License (Municipal)', 'slug' => 'trade-license'],
                ['title' => 'Shop & Establishment (Shop Act)', 'slug' => 'shop-establishment'],
                ['title' => 'CLRA Contract Labour License', 'slug' => 'clra-contract-labour'],
                ['title' => 'LWF Labour Welfare Fund', 'slug' => 'lwf-labour-welfare'],
                ['title' => 'Professional Tax Registration', 'slug' => 'professional-tax']
            ]
        ],
        [
            'name' => 'Certifications',
            'icon' => 'fa-solid fa-certificate',
            'image_url' => 'assets/images/service_trademark.jpg',
            'services' => [
                ['title' => 'ISO 9001/14001 Certification', 'slug' => 'iso-certification'],
                ['title' => 'Trademark (TM) Registration', 'slug' => 'trademark-registration'],
                ['title' => 'BIS Certification & ISI Mark', 'slug' => 'bis-certification'],
                ['title' => 'Fire Safety NOC Certificate', 'slug' => 'fire-safety-noc'],
                ['title' => 'Class 3 Digital Signature (DSC)', 'slug' => 'dsc-class-3'],
                ['title' => 'Make in India Certification', 'slug' => 'make-in-india']
            ]
        ],
        [
            'name' => 'Tax & Compliance',
            'icon' => 'fa-solid fa-calculator',
            'image_url' => 'assets/images/service_taxation.jpg',
            'services' => [
                ['title' => 'Income Tax Return (ITR) Filing', 'slug' => 'itr-filing'],
                ['title' => 'GST Return Filing', 'slug' => 'gst-return'],
                ['title' => 'ROC Annual Compliances', 'slug' => 'roc-annual-compliances'],
                ['title' => 'Corporate Accounting & Bookkeeping', 'slug' => 'accounting-bookkeeping'],
                ['title' => 'Company Winding Up', 'slug' => 'company-winding-up']
            ]
        ],
        [
            'name' => 'NGO Registration',
            'icon' => 'fa-solid fa-handshake-angle',
            'image_url' => 'assets/images/hero_bg_5.jpg',
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
    // Populate services for each active DB category
    foreach ($db_categories as &$cat) {
        $srvStmt = $pdo->prepare("SELECT title, slug FROM services WHERE category_id = :cat_id ORDER BY id ASC");
        $srvStmt->execute([':cat_id' => $cat['id']]);
        $cat['services'] = $srvStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($cat);
}
?>
<!-- Services Section (6 Categories, Simple Flat Cards, Full Images, No Shadows) -->
<section id="services" class="relative py-20 bg-slate-50 border-b border-slate-100 overflow-hidden">
    <!-- Ambient Blur Background -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-500/5 rounded-full blur-[130px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header with Content, Icons & Quick Link -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 pb-8 border-b border-slate-200/60">
            <div class="max-w-2xl text-left space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                    <i class="fa-solid fa-layer-group text-[9px]"></i> Service Catalog
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Corporate Legal, Tax & NGO Solutions
                </h2>
                <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                    Outsource your company setup, compliance registers, tax returns, and licensing to Zenvora. Select a category below to view specific packages and process checkmarks.
                </p>
            </div>
            <!-- Quick Link with Icon -->
            <div class="flex-shrink-0">
                <a href="services.php" class="inline-flex items-center gap-2 px-5 py-3 rounded-full text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 transition-colors group">
                    <i class="fa-solid fa-layer-group text-brand-500"></i> View Complete Service Catalog
                    <i class="fa-solid fa-arrow-right text-[10px] text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
        
        <!-- Grid Layout for Categories list -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($db_categories as $idx => $cat): ?>
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/60 hover:border-brand-500/30 transition-all duration-300 group flex flex-col justify-between">
                <div>
                    <!-- Category Image -->
                    <div class="relative w-full h-44 overflow-hidden bg-slate-100">
                        <img src="<?php echo htmlspecialchars($cat['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($cat['name']); ?> Services" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded">
                            <?php echo sprintf("%02d", $idx + 1); ?>. <?php echo htmlspecialchars($cat['name']); ?>
                        </div>
                    </div>
                    
                    <div class="p-6 text-left">
                        <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="<?php echo htmlspecialchars($cat['icon']); ?> text-brand-500 text-sm"></i> <?php echo htmlspecialchars($cat['name']); ?>
                        </h3>
                        
                        <!-- List of services -->
                        <div class="space-y-1">
                            <?php if (empty($cat['services'])): ?>
                            <span class="text-[11px] text-slate-400 font-semibold block italic py-2">No active services setup.</span>
                            <?php endif; ?>
                            <?php foreach ($cat['services'] as $srv_item): ?>
                            <a href="service-detail.php?slug=<?php echo htmlspecialchars($srv_item['slug']); ?>" class="flex items-center justify-between py-2 text-xs text-slate-655 hover:text-brand-500 border-b border-slate-100 transition-colors">
                                <span><?php echo htmlspecialchars($srv_item['title']); ?></span>
                                <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
