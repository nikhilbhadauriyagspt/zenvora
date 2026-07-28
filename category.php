<?php
/**
 * Zenvora Global Solutions - Category Landing Page
 */
require_once 'components/db_connect.php';
require_once 'components/settings_helper.php';

// Get category slug from GET parameter
$catSlug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($catSlug)) {
    header("Location: services.php");
    exit;
}

$category = null;
$services = [];

// 1. Query Category Details from DB
if (isset($pdo) && $pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM service_categories WHERE slug = :slug");
        $stmt->execute([':slug' => $catSlug]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($category) {
            // Fetch services in this category
            $srvStmt = $pdo->prepare("SELECT * FROM services WHERE category_id = :catId ORDER BY id ASC");
            $srvStmt->execute([':catId' => $category['id']]);
            $services = $srvStmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        $category = null;
    }
}

// 2. Dynamic Fallback mapping in case DB doesn't have it or is empty
if (!$category) {
    $fallback_categories = [
        'business-startup' => [
            'name' => 'Business Startup Setup',
            'slug' => 'business-startup',
            'icon' => 'fa-solid fa-rocket',
            'image_url' => 'assets/images/startup_category.jpg',
            'desc' => 'Form your legal business structure in India. We coordinate MCA name approvals, draft MoA/AoA bylaws, secure director DINs, and handle ROC submissions.',
            'services' => [
                ['title' => 'Private Limited Company', 'slug' => 'private-limited-company', 'tagline' => 'Registration in India', 'description' => 'Launch your startup with India\'s most trusted legal structure. PAN, TAN, and bank account in 7 days.', 'starting_price' => '₹4,999', 'average_duration' => '7 Days', 'hero_image' => 'assets/images/startup_category.jpg'],
                ['title' => 'Limited Liability Partnership (LLP)', 'slug' => 'limited-liability-partnership', 'tagline' => 'Incorporate your LLP online', 'description' => 'Perfect blend of a partnership and private limited company. Offers limited liability with less compliance overhead.', 'starting_price' => '₹3,999', 'average_duration' => '8 Days', 'hero_image' => 'assets/images/startup_category.jpg'],
                ['title' => 'One Person Company (OPC)', 'slug' => 'one-person-company', 'tagline' => 'Perfect setup for solo founders', 'description' => 'Run a corporate structure solo with 100% control while enjoying limited liability protection.', 'starting_price' => '₹4,499', 'average_duration' => '6 Days', 'hero_image' => 'assets/images/startup_category.jpg'],
                ['title' => 'Partnership Firm Setup', 'slug' => 'partnership-firm', 'tagline' => 'Registered Partnership Deeds', 'description' => 'Register your partnership agreement formally with corporate registrar permissions.', 'starting_price' => '₹1,999', 'average_duration' => '4 Days', 'hero_image' => 'assets/images/startup_category.jpg'],
                ['title' => 'Proprietorship Registration', 'slug' => 'proprietorship-registration', 'tagline' => 'Sole Proprietor setups', 'description' => 'Simplest form of business setup to start invoicing client accounts instantly.', 'starting_price' => '₹999', 'average_duration' => '2 Days', 'hero_image' => 'assets/images/startup_category.jpg']
            ]
        ],
        'registrations' => [
            'name' => 'Business Registrations',
            'slug' => 'registrations',
            'icon' => 'fa-solid fa-receipt',
            'image_url' => 'assets/images/registration_category.jpg',
            'desc' => 'Secure your government registrations and tax identification codes to trade legally across states, bid for tenders, and claim startup benefits.',
            'services' => [
                ['title' => 'GST Registration', 'slug' => 'gst-registration', 'tagline' => 'Secure your Tax Identification ID', 'description' => 'Obtain your Goods and Services Tax identifier to start inter-state sales legally.', 'starting_price' => '₹499', 'average_duration' => '2 Days', 'hero_image' => 'assets/images/registration_category.jpg'],
                ['title' => 'MSME (Udyam) Registration', 'slug' => 'msme-udyam', 'tagline' => 'Claim central startup benefits', 'description' => 'Register under MSME to claim state incentives, cheaper loans, and faster invoice payments.', 'starting_price' => '₹299', 'average_duration' => '1 Day', 'hero_image' => 'assets/images/registration_category.jpg'],
                ['title' => 'Startup India DPIIT Recognition', 'slug' => 'startup-india', 'tagline' => 'Get tax holidays and DPIIT recognition', 'description' => 'Gain access to government tax exemptions, startup hubs, and patent filing subsidies.', 'starting_price' => '₹4,999', 'average_duration' => '10 Days', 'hero_image' => 'assets/images/registration_category.jpg'],
                ['title' => 'Import Export Code (IEC)', 'slug' => 'import-export-code', 'tagline' => 'Export-Import license setup', 'description' => 'Mandatory registry key needed to export goods/services or import packages to India.', 'starting_price' => '₹999', 'average_duration' => '2 Days', 'hero_image' => 'assets/images/registration_category.jpg']
            ]
        ],
        'licenses' => [
            'name' => 'Operational Licenses',
            'slug' => 'licenses',
            'icon' => 'fa-solid fa-scale-balanced',
            'image_url' => 'assets/images/licenses_category.jpg',
            'desc' => 'Obtain operational clearances, municipal licenses, and labor department permits needed to open physically, distribute food, or employ contract staff.',
            'services' => [
                ['title' => 'FSSAI Food License', 'slug' => 'fssai-food-license', 'tagline' => 'Food Safety registry clearance', 'description' => 'Mandatory food safety permit for cloud kitchens, restaurants, food manufacturers, and repackers.', 'starting_price' => '₹1,999', 'average_duration' => '5 Days', 'hero_image' => 'assets/images/licenses_category.jpg'],
                ['title' => 'Trade License (Municipal)', 'slug' => 'trade-license', 'tagline' => 'Municipal trade setup permits', 'description' => 'Commercial certificate issued by municipal corporations to operate local offices.', 'starting_price' => '₹2,499', 'average_duration' => '7 Days', 'hero_image' => 'assets/images/licenses_category.jpg'],
                ['title' => 'Shop & Establishment (Shop Act)', 'slug' => 'shop-establishment', 'tagline' => 'Commercial shop establishment act licenses', 'description' => 'Mandatory state labor permit required for opening any shop, commercial kitchen, or office desk.', 'starting_price' => '₹999', 'average_duration' => '2 Days', 'hero_image' => 'assets/images/licenses_category.jpg']
            ]
        ],
        'certifications' => [
            'name' => 'Quality Certifications',
            'slug' => 'certifications',
            'icon' => 'fa-solid fa-certificate',
            'image_url' => 'assets/images/certifications_category.jpg',
            'desc' => 'Protect your brand assets and qualify for corporate contracts by securing internationally recognized ISO certificates and active trademark claims.',
            'services' => [
                ['title' => 'ISO Certification', 'slug' => 'iso-certification', 'tagline' => 'ISO 9001 quality standards', 'description' => 'Establish global credibility with quality, safety, and IT data protection certificates.', 'starting_price' => '₹2,999', 'average_duration' => '4 Days', 'hero_image' => 'assets/images/certifications_category.jpg'],
                ['title' => 'Trademark (TM) Registration', 'slug' => 'trademark-registration', 'tagline' => 'Secure brand logo and company names', 'description' => 'Protect your corporate name, slogan, or design logo from copycats.', 'starting_price' => '₹1,999', 'average_duration' => '3 Days', 'hero_image' => 'assets/images/certifications_category.jpg']
            ]
        ],
        'tax-compliance' => [
            'name' => 'Tax & Compliance',
            'slug' => 'tax-compliance',
            'icon' => 'fa-solid fa-calculator',
            'image_url' => 'assets/images/tax_category.jpg',
            'desc' => 'Maintain flawless corporate books. We process monthly ledgers, file TDS returns, deposit GST monthly returns, and coordinate ROC filings.',
            'services' => [
                ['title' => 'Income Tax Return (ITR) Filing', 'slug' => 'itr-filing', 'tagline' => 'Personal & corporate annual tax filings', 'description' => 'Get corporate CAs to file your annual returns securely while optimizing deductions.', 'starting_price' => '₹499', 'average_duration' => '2 Days', 'hero_image' => 'assets/images/tax_category.jpg'],
                ['title' => 'GST Return Filing', 'slug' => 'gst-return', 'tagline' => 'Monthly and quarterly tax registers filing', 'description' => 'Filing monthly GST returns (GSTR-1 & GSTR-3B) with precision bookkeeping.', 'starting_price' => '₹499', 'average_duration' => '2 Days', 'hero_image' => 'assets/images/tax_category.jpg'],
                ['title' => 'ROC Annual Compliances', 'slug' => 'roc-annual-compliances', 'tagline' => 'Filings & MCA resolutions bookkeeping', 'description' => 'Complete corporate maintenance package containing mandatory AGMs and ROC documentation.', 'starting_price' => '₹4,999', 'average_duration' => '10 Days', 'hero_image' => 'assets/images/tax_category.jpg']
            ]
        ],
        'ngo-registration' => [
            'name' => 'NGO Registration',
            'slug' => 'ngo-registration',
            'icon' => 'fa-solid fa-handshake-angle',
            'image_url' => 'assets/images/ngo_category.jpg',
            'desc' => 'Register your social cause organization formally through trusts, society bylaws, Section 8 structures, and secure tax exemption certificates.',
            'services' => [
                ['title' => 'Trust Registration', 'slug' => 'trust-registration', 'tagline' => 'NGO Trust deeds setup and filing', 'description' => 'Create a public or private charitable trust with formal trust deed compiling.', 'starting_price' => '₹5,999', 'average_duration' => '10 Days', 'hero_image' => 'assets/images/ngo_category.jpg'],
                ['title' => 'Society Registration', 'slug' => 'society-registration', 'tagline' => 'Registered bylaws and societies setups', 'description' => 'Register an association of members under the Societies Registration Act.', 'starting_price' => '₹7,999', 'average_duration' => '12 Days', 'hero_image' => 'assets/images/ngo_category.jpg'],
                ['title' => 'Section 8 Company Setup', 'slug' => 'section-8-company', 'tagline' => 'Non-profit company setups under MCA', 'description' => 'Perfect non-profit structure with corporate backing, corporate donors, and global reputation.', 'starting_price' => '₹9,999', 'average_duration' => '8 Days', 'hero_image' => 'assets/images/ngo_category.jpg']
            ]
        ]
    ];

    if (isset($fallback_categories[$catSlug])) {
        $category = $fallback_categories[$catSlug];
        $services = $category['services'];
    }
}

if (!$category) {
    header("Location: services.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['name']); ?> Services | Zenvora Global Solutions</title>
    <meta name="description" content="<?php echo htmlspecialchars($category['desc'] ?? ''); ?>">
    
    <!-- Load Head dependencies -->
    <?php include_once 'components/head.php'; ?>
</head>
<body class="bg-white font-sans text-slate-600 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Global Header Navigation -->
    <?php include_once 'components/header.php'; ?>

    <main>
        
        <!-- Category Banner Hero Section -->
        <section class="relative py-28 bg-slate-900 text-white overflow-hidden">
            <!-- Background Image Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="<?php echo htmlspecialchars($category['image_url'] ?: 'assets/images/hero_bg.jpg'); ?>" alt="<?php echo htmlspecialchars($category['name']); ?> banner" class="w-full h-full object-cover opacity-25">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/90 to-slate-900/60"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6 text-center lg:text-left">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="space-y-4 max-w-3xl">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black bg-brand-500/10 border border-brand-500/20 text-brand-400 uppercase tracking-widest">
                            <i class="<?php echo htmlspecialchars($category['icon'] ?: 'fa-solid fa-circle-check'); ?> text-[10px]"></i> Category Catalog
                        </span>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-none text-white">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </h1>
                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-semibold">
                            <?php echo htmlspecialchars($category['desc'] ?? ''); ?>
                        </p>
                    </div>

                    <div class="flex-shrink-0 flex items-center justify-center">
                        <div class="w-20 h-20 rounded-3xl bg-brand-500/10 border border-brand-500/20 text-brand-400 text-3xl flex items-center justify-center shadow-2xl">
                            <i class="<?php echo htmlspecialchars($category['icon'] ?: 'fa-solid fa-folder'); ?>"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sub Services List Cards (Grid, No Shadows) -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                
                <div class="text-center space-y-3">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Available Compliance Setup Structures</h2>
                    <p class="text-slate-400 text-xs font-extrabold uppercase tracking-widest">Direct professional filing and registrations catalog</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                    <?php foreach ($services as $srv): ?>
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 flex flex-col justify-between hover:border-brand-500 transition-all duration-300">
                        <div>
                            <!-- Cover thumbnail -->
                            <div class="relative w-full aspect-[4/3] bg-slate-100 rounded-2xl overflow-hidden mb-5 border border-slate-150">
                                <img src="<?php echo htmlspecialchars($srv['hero_image'] ?: 'assets/images/hero_bg.jpg'); ?>" alt="<?php echo htmlspecialchars($srv['title']); ?>" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 to-transparent"></div>
                            </div>

                            <!-- Meta Price Tags -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[9px] font-black text-brand-700 bg-brand-500/10 border border-brand-500/20 px-2.5 py-1 rounded-full uppercase tracking-wider">
                                    <?php echo htmlspecialchars($srv['average_duration']); ?> TAT
                                </span>
                                <span class="text-xs font-black text-slate-900">
                                    Starts at <span class="text-brand-600 font-extrabold"><?php echo htmlspecialchars($srv['starting_price']); ?></span>
                                </span>
                            </div>

                            <h3 class="text-base font-extrabold text-slate-900 leading-snug">
                                <?php echo htmlspecialchars($srv['title']); ?>
                            </h3>
                            <span class="text-[10px] text-brand-600 font-extrabold uppercase tracking-widest mt-1 block"><?php echo htmlspecialchars($srv['tagline']); ?></span>

                            <p class="text-xs text-slate-500 mt-4 leading-relaxed font-semibold">
                                <?php echo htmlspecialchars($srv['description']); ?>
                            </p>
                        </div>

                        <!-- CTA Action -->
                        <div class="mt-8 pt-5 border-t border-slate-150 flex items-center justify-between">
                            <span class="text-[10px] text-slate-400 font-bold">100% Online process</span>
                            <a href="service-detail.php?slug=<?php echo htmlspecialchars($srv['slug']); ?>" class="px-5 py-2.5 rounded-full text-[10px] font-black uppercase tracking-wider text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                View Details & Pricing <i class="fa-solid fa-arrow-right text-[8px] ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- Dynamic Intake Lead Form -->
        <section class="py-24 bg-slate-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
                <div class="space-y-3">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[9px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        🎯 Get Started Now
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Need expert help with <?php echo htmlspecialchars($category['name']); ?>?</h2>
                    <p class="text-slate-500 text-xs sm:text-sm font-semibold max-w-lg mx-auto">
                        Submit your details below. Our corporate attorneys and CAs will review your requirement and call you back in 15 minutes.
                    </p>
                </div>

                <!-- Custom mapped source parameter triggers proper dashboard source tracking -->
                <div class="bg-white border border-slate-200 p-6 sm:p-10 rounded-3xl">
                    <?php 
                    // Override contact source dynamically for this category landing page
                    $categoryContactSource = htmlspecialchars($category['name']) . " (Category Landing Page)";
                    ?>
                    <!-- Simplified Inline Intake Form -->
                    <form action="contact.php" method="POST" class="space-y-4 text-left">
                        <input type="hidden" name="source_page" value="<?php echo $categoryContactSource; ?>">
                        <input type="hidden" name="service_interest" value="<?php echo htmlspecialchars($category['slug']); ?>">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Your Name</label>
                                <input type="text" name="name" required placeholder="Enter full name" class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Phone Number</label>
                                <input type="tel" name="phone" required placeholder="e.g. +91 99999 88888" class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Email Address</label>
                                <input type="email" name="email" required placeholder="name@company.com" class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Briefly describe your requirements</label>
                            <textarea name="message" rows="3" required placeholder="I am looking to incorporate a business with 2 directors..." class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors resize-none"></textarea>
                        </div>

                        <div class="pt-2 text-right">
                            <button type="submit" name="submit_contact" class="px-8 py-3.5 rounded-full text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors uppercase tracking-wider">
                                Request Callback <i class="fa-solid fa-paper-plane text-[9px] ml-1.5"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer Navigation -->
    <?php include_once 'components/footer.php'; ?>

</body>
</html>
