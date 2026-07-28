<?php
/**
 * Zenvora Global Solutions - Dynamic Services Directory Page
 * Renders all categories and associated sub-services dynamically from SQL database.
 * Integrates secure fallbacks in case database has not been initialized.
 */
require_once 'components/db_connect.php';
require_once 'components/settings_helper.php';

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
            'name' => 'Business Startup Setup',
            'slug' => 'business-startup',
            'icon' => 'fa-solid fa-rocket',
            'image_url' => 'assets/images/service_incorporation.jpg',
            'desc' => 'Form your legal business structure in India. We coordinate MCA name approvals, draft MoA/AoA bylaws, secure director DINs, and handle ROC submissions.',
            'deliverables' => ['MCA Certificate of Incorporation (COI)', 'Director Identification Numbers (DIN)', 'Company PAN & TAN allocation codes'],
            'services' => [
                ['title' => 'Private Limited Company', 'slug' => 'private-limited-company'],
                ['title' => 'Limited Liability Partnership (LLP)', 'slug' => 'limited-liability-partnership'],
                ['title' => 'One Person Company (OPC)', 'slug' => 'one-person-company'],
                ['title' => 'Partnership Firm Setup', 'slug' => 'partnership-firm'],
                ['title' => 'Proprietorship Registration', 'slug' => 'proprietorship-registration']
            ]
        ],
        [
            'name' => 'Business Registrations',
            'slug' => 'registrations',
            'icon' => 'fa-solid fa-receipt',
            'image_url' => 'assets/images/hero_bg.jpg',
            'desc' => 'Secure your government registrations and tax identification codes to trade legally across states, bid for tenders, and claim startup benefits.',
            'deliverables' => ['GST Registration & HSN classifications', 'MSME Udyam Enrollment Certificate', 'DPIIT Startup Recognition Certificate'],
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
            'name' => 'Operational Licenses',
            'slug' => 'licenses',
            'icon' => 'fa-solid fa-scale-balanced',
            'image_url' => 'assets/images/hero_bg_4.jpg',
            'desc' => 'Obtain operational clearances, municipal licenses, and labor department permits needed to open physically, distribute food, or employ contract staff.',
            'deliverables' => ['FSSAI Food Business License clearance', 'Shop & Establishment Act registration', 'Municipal Trade License approvals'],
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
            'name' => 'Quality Certifications',
            'slug' => 'certifications',
            'icon' => 'fa-solid fa-certificate',
            'image_url' => 'assets/images/service_trademark.jpg',
            'desc' => 'Protect your brand assets and qualify for corporate contracts by securing internationally recognized ISO certificates and active trademark claims.',
            'deliverables' => ['Class 3 Digital Signature (DSC) keys', 'Trademark Application Form-A filing', 'ISO Audit & Certification release'],
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
            'slug' => 'tax-compliance',
            'icon' => 'fa-solid fa-calculator',
            'image_url' => 'assets/images/service_taxation.jpg',
            'desc' => 'Maintain flawless corporate books. We process monthly ledgers, file TDS returns, deposit GST monthly returns, and coordinate ROC filings.',
            'deliverables' => ['Income Tax Return (ITR-6) filings', 'GST return filing reports (GSTR-1/3B)', 'ROC AOC-4 & MGT-7 corporate filings'],
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
            'slug' => 'ngo-registration',
            'icon' => 'fa-solid fa-handshake-angle',
            'image_url' => 'assets/images/hero_bg_5.jpg',
            'desc' => 'Incorporate non-profit organizations. We setup Section 8 companies, draft public charitable trust deeds, and secure 12A/80G tax exemptions.',
            'deliverables' => ['Section 8 MCA Certificate of Incorporation', 'NGO Darpan NITI Aayog enrollment ID', 'Income Tax 12A & 80G approvals'],
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
    // Populate services and mock details description/deliverables for each DB category
    foreach ($db_categories as &$cat) {
        $srvStmt = $pdo->prepare("SELECT * FROM services WHERE category_id = :cat_id ORDER BY id ASC");
        $srvStmt->execute([':cat_id' => $cat['id']]);
        $cat['services'] = $srvStmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($cat['services'])) {
            $cat['desc'] = "Obtain professional CA/CS assistance for " . $cat['name'] . " registrations, approvals, and legal compliance. Simple process, fast TAT.";
            $firstSrv = $cat['services'][0];
            $firstDelivs = json_decode($firstSrv['deliverables_json'], true) ?: [];
            $cat['deliverables'] = array_slice($firstDelivs, 0, 3);
        } else {
            $cat['desc'] = "Outsource your company setup, compliance registers, tax returns, and licensing to Zenvora. Select a category below.";
            $cat['deliverables'] = ['Official Registration Certificate', 'Complimentary CA consultation call', 'Government challan records'];
        }
    }
    unset($cat);
}
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
                    <?php foreach ($db_categories as $idx => $cat): ?>
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 flex flex-col justify-between hover:border-brand-500 transition-all duration-300">
                        <div class="space-y-6">
                            <!-- Header Image & Badge -->
                            <div class="relative w-full aspect-[16/10] bg-slate-100 rounded-2xl overflow-hidden border border-slate-100">
                                <img src="<?php echo htmlspecialchars($cat['image_url']); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>" class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded">
                                    <?php echo sprintf("%02d", $idx + 1); ?>. <?php echo strtoupper(htmlspecialchars($cat['slug'])); ?>
                                </div>
                            </div>

                            <!-- Title & Short Describe -->
                            <div class="space-y-2 text-left">
                                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="<?php echo htmlspecialchars($cat['icon']); ?> text-brand-500 text-sm"></i> <?php echo htmlspecialchars($cat['name']); ?>
                                </h3>
                                <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                                    <?php echo htmlspecialchars($cat['desc']); ?>
                                </p>
                            </div>

                            <!-- Sub-categories List -->
                            <div class="space-y-1 pt-4 border-t border-slate-100 text-left">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Available Setup Types:</span>
                                <div class="space-y-0.5">
                                    <?php if (empty($cat['services'])): ?>
                                    <span class="text-[11px] text-slate-400 font-semibold block italic py-2">No active services setup.</span>
                                    <?php endif; ?>
                                    <?php foreach ($cat['services'] as $srv): ?>
                                    <a href="service-detail.php?slug=<?php echo htmlspecialchars($srv['slug']); ?>" class="flex items-center justify-between py-1.5 text-xs text-slate-700 hover:text-brand-500 border-b border-slate-100/60 transition-colors">
                                        <span class="font-medium"><?php echo htmlspecialchars($srv['title']); ?></span>
                                        <i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Deliverables points (checklists) -->
                            <div class="pt-4 border-t border-slate-100 space-y-3 text-left">
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Deliverables Include:</span>
                                <ul class="space-y-2.5 text-xs text-slate-650 font-semibold">
                                    <?php foreach (($cat['deliverables'] ?? []) as $deliv): ?>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-check text-brand-500 mt-0.5 text-[11px]"></i>
                                        <span><?php echo htmlspecialchars($deliv); ?></span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- CTA button -->
                        <div class="mt-8 pt-5 border-t border-slate-100">
                            <a href="contact.php" class="block w-full text-center py-3 rounded-full text-[11px] font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                Inquire Details <i class="fa-solid fa-chevron-right ml-1.5 text-[9px] text-slate-400"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

    </main>

    <!-- Global Footer -->
    <?php include_once 'components/footer.php'; ?>

</body>
</html>
