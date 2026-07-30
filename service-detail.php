<?php
/**
 * Zenvora Global Solutions - Dynamic Service Detail Template
 * Renders all services dynamically based on slug using the premium user interface.
 */
session_start();
require_once 'components/db_connect.php';
require_once 'components/settings_helper.php';

$slug = trim($_GET['slug'] ?? '');

if (empty($slug) || $pdo === null) {
    header("Location: services.php");
    exit;
}

// Fetch service details from database
try {
    $stmt = $pdo->prepare("SELECT s.*, c.name as category_name, c.slug as category_slug FROM services s JOIN service_categories c ON s.category_id = c.id WHERE s.slug = :slug");
    $stmt->execute([':slug' => $slug]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$service) {
        // Fallback for demo if the database has not been seeded yet via browser visit
        header("Location: services.php");
        exit;
    }
} catch (PDOException $e) {
    die("Database query error: " . $e->getMessage());
}

// Decode JSON parameters
$pillars = json_decode($service['pillars_json'], true) ?? [];
$steps = json_decode($service['steps_json'], true) ?? [];
$deliverables = json_decode($service['deliverables_json'], true) ?? [];

$docs_list = json_decode($service['docs_json'] ?? '[]', true) ?: [];
if (empty($docs_list)) {
    $docs_list = [
        [
            'section_title' => 'Filing Guidelines & Tips',
            'icon' => 'fa-solid fa-circle-info',
            'items' => [
                ['title' => 'Name Consistency Check', 'desc' => 'Ensure spelling matches exactly across PAN and Aadhaar cards to prevent MCA rejection.'],
                ['title' => 'Utility Bill Validity', 'desc' => 'Registered office Electricity/Gas bills must not be older than 2 months from submission.'],
                ['title' => 'Digital Scans Only', 'desc' => 'High-resolution color scans or mobile PDF scanner outputs are 100% accepted. No physical copies needed.']
            ]
        ],
        [
            'section_title' => 'Requirements for Promoters',
            'icon' => 'fa-solid fa-id-card',
            'items' => [
                ['title' => 'PAN Card & Aadhaar Card', 'desc' => 'Mandatory identity proof documents for Indian founders.'],
                ['title' => 'Director Address Proof', 'desc' => 'Latest Bank Statement, Mobile, or Electricity Bill (under 2 months old).'],
                ['title' => 'Passport Photograph', 'desc' => 'Clear digital photo against a white background.']
            ]
        ],
        [
            'section_title' => 'Premises Proof Details',
            'icon' => 'fa-solid fa-house-chimney',
            'items' => [
                ['title' => 'Registered Utility Bill', 'desc' => 'Electricity bill, gas connection, or landline phone bill (under 2 months old).'],
                ['title' => 'NOC from Property Owner', 'desc' => 'No Objection Certificate signed by the title holder of the premises.'],
                ['title' => 'Rent/Lease Agreement', 'desc' => 'Required if the office location is rented. Commercial/residential both accepted.']
            ]
        ]
    ];
}
$pricing_packages = json_decode($service['pricing_packages_json'], true) ?? [];
$faqs = json_decode($service['faqs_json'], true) ?? [];

$successMsg = '';
$errorMsg = '';

// Handle lead capture submission directly to enquiries table
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $serviceName = $service['title'] . ' (Service Page)';
    $org_size = trim($_POST['org_size'] ?? '1-10');
    $timeline = trim($_POST['timeline'] ?? 'Immediate');
    $message = trim($_POST['message'] ?? 'Inquiry submitted from dynamic service detail page.');
    
    if (empty($name) || empty($phone) || empty($email)) {
        $errorMsg = 'Please fill out your Name, Phone Number, and Email Address.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO enquiries (name, phone, email, service, org_size, timeline, message, status) VALUES (:name, :phone, :email, :service, :org_size, :timeline, :message, 'Pending')");
            $stmt->execute([
                ':name' => $name,
                ':phone' => $phone,
                ':email' => $email,
                ':service' => $serviceName,
                ':org_size' => $org_size,
                ':timeline' => $timeline,
                ':message' => $message
            ]);
            $successMsg = 'Thank you! Your setup request has been logged. A CA will call you back in under 15 minutes to initiate your verification.';
        } catch (PDOException $e) {
            $errorMsg = 'Failed to log setup request: ' . $e->getMessage();
        }
    }
}

// Define custom SEO metadata variables for head.php inclusion (Automatic generation from service details)
$custom_page_title = htmlspecialchars($service['title']) . ' Registration | Zenvora Global Solutions';
$custom_page_desc = 'Incorporate your ' . htmlspecialchars($service['title']) . ' in India. CA-assisted process, transparent government fees, 100% online setup.';
$custom_page_keys = htmlspecialchars($service['title']) . ' Registration, ' . htmlspecialchars($service['category_name']) . ', Legal Compliance, Zenvora';
$custom_page_canonical = 'http://localhost/commanpro/service-detail.php?slug=' . htmlspecialchars($service['slug']);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Load Head dependencies (Tailwind CDN, Fonts, Font Awesome) -->
    <?php include_once 'components/head.php'; ?>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fdfbf7',
                            100: '#f9f3e6',
                            200: '#f1e2c5',
                            300: '#e5ca97',
                            400: '#d7ac63',
                            500: '#bc8731',
                            600: '#a36d26',
                            700: '#83521d',
                            900: '#573316',
                        }
                    },
                    fontFamily: {
                        sans: ['"Space Grotesk"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="subpage-theme bg-white font-sans text-slate-650 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Global Header Navigation -->
    <?php include_once 'components/header.php'; ?>

    <main>
        
        <!-- Hero Section with Dual Layout (Text vs Main Image) -->
        <section class="relative py-20 lg:py-28 bg-slate-900 text-white overflow-hidden border-b border-slate-800">
            <!-- Background Radial Blur -->
            <div class="absolute top-1/4 right-0 w-[450px] h-[450px] bg-brand-500/10 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[350px] h-[350px] bg-brand-600/5 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left: Details -->
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-400 uppercase tracking-widest">
                            <i class="fa-solid fa-bolt text-[9px]"></i> Fast-Track <?php echo htmlspecialchars($service['category_name']); ?>
                        </span>
                        
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                            <?php echo htmlspecialchars($service['title']); ?> <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-brand-300"><?php echo htmlspecialchars($service['tagline']); ?>.</span>
                        </h1>
                        
                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-semibold">
                            <?php echo htmlspecialchars($service['description']); ?>
                        </p>

                        <!-- Highlights list -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-800">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-brand-500/10 text-brand-400 flex items-center justify-center text-xs border border-brand-500/20">
                                    <i class="fa-solid fa-fingerprint"></i>
                                </span>
                                <span class="text-xs font-bold text-slate-300">All Registration Fees Included</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-brand-500/10 text-brand-400 flex items-center justify-center text-xs border border-brand-500/20">
                                    <i class="fa-solid fa-briefcase"></i>
                                </span>
                                <span class="text-xs font-bold text-slate-300">Zero Physical Visit Required</span>
                            </div>
                        </div>

                        <!-- Price & Duration Badges -->
                        <div class="flex flex-wrap items-center gap-4 pt-4">
                            <div class="bg-slate-800/80 border border-slate-700 px-5 py-3 rounded-2xl flex items-center gap-3">
                                <div>
                                    <span class="text-[9px] font-black text-slate-400 block uppercase tracking-wider">Starting Price</span>
                                    <span class="text-lg font-black text-white"><?php echo htmlspecialchars($service['starting_price']); ?></span>
                                </div>
                            </div>
                            <div class="bg-slate-800/80 border border-slate-700 px-5 py-3 rounded-2xl flex items-center gap-3">
                                <div>
                                    <span class="text-[9px] font-black text-slate-400 block uppercase tracking-wider">Average Duration</span>
                                    <span class="text-lg font-black text-white"><?php echo htmlspecialchars($service['average_duration']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Main generated Image -->
                    <div class="lg:col-span-5 flex justify-center">
                        <div class="relative w-full max-w-md rounded-3xl overflow-hidden border border-white/10 aspect-[4/3] shadow-2xl bg-slate-950/20">
                            <img src="<?php echo htmlspecialchars($service['hero_image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?> illustration" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/50 to-transparent"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Briefing Section: What is it? -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    
                    <!-- Left: Briefing explanation text -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                            <i class="fa-solid fa-circle-info text-[9px]"></i> The Core Concept
                        </span>
                        
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            Understanding <?php echo htmlspecialchars($service['title']); ?>
                        </h2>
                        
                        <p class="text-slate-655 text-sm leading-relaxed font-semibold">
                            <?php echo nl2br(htmlspecialchars($service['what_is_brief'])); ?>
                        </p>
                    </div>

                    <!-- Right: The 3 Core Pillars -->
                    <div class="lg:col-span-6 space-y-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest block w-fit">
                            <i class="fa-solid fa-star text-[9px]"></i> Key Advantages
                        </span>
                        
                        <div class="space-y-4">
                            <?php foreach ($pillars as $pillar): ?>
                            <div class="flex items-start gap-4 p-5 bg-white border border-slate-200 rounded-2xl hover:border-slate-350 transition-colors">
                                <span class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-600 flex items-center justify-center text-sm border border-brand-500/20 flex-shrink-0">
                                    <i class="<?php echo htmlspecialchars($pillar['icon'] ?? 'fa-solid fa-check'); ?>"></i>
                                </span>
                                <div class="text-left space-y-1">
                                    <h4 class="text-sm font-black text-slate-900"><?php echo htmlspecialchars($pillar['title'] ?? ''); ?></h4>
                                    <p class="text-xs text-slate-500 leading-relaxed font-semibold"><?php echo htmlspecialchars($pillar['desc'] ?? ''); ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Execution Timeline Section: How it works -->
        <section class="py-24 bg-slate-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-16">
                
                <div class="max-w-2xl mx-auto space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-list-ol text-[9px]"></i> Simple Process
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        How We Setup Your Service
                    </h2>
                    <p class="text-slate-500 text-sm font-semibold">
                        Here is the brief setup pipeline we manage entirely for you.
                    </p>
                </div>

                <!-- Process Steps Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                    <?php foreach ($steps as $idx => $step): ?>
                    <div class="bg-white border border-slate-200 rounded-3xl p-8 relative flex flex-col justify-between hover:border-slate-350 transition-all">
                        <div class="space-y-4">
                            <span class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-655 text-sm font-black flex items-center justify-center">
                                <?php echo htmlspecialchars($step['number'] ?? '0' . ($idx + 1)); ?>
                            </span>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider"><?php echo htmlspecialchars($step['title'] ?? ''); ?></h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-semibold">
                                <?php echo htmlspecialchars($step['desc'] ?? ''); ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Deliverables list: What you get inside the kit -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-16">
                
                <div class="max-w-2xl mx-auto space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-box-open text-[9px]"></i> Deliverables Kit
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        What's Included in Your Package?
                    </h2>
                    <p class="text-slate-500 text-sm font-semibold">
                        After registration, you will receive all official credentials and legal papers compiled.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-left">
                    <?php foreach ($deliverables as $item): ?>
                    <div class="bg-slate-50 border border-slate-200/60 p-5 rounded-2xl flex items-start gap-3">
                        <span class="text-brand-500 mt-0.5"><i class="fa-solid fa-circle-check text-xs"></i></span>
                        <span class="text-xs font-bold text-slate-700 leading-normal"><?php echo htmlspecialchars($item); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Document checklist component -->
        <section class="py-24 bg-slate-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-16">
                
                <div class="max-w-2xl mx-auto space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-file-invoice text-[9px]"></i> Document Registry
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        <?php echo htmlspecialchars($service['docs_title'] ?? 'Documents Needed. Keep Them Ready.'); ?>
                    </h2>
                    <p class="text-slate-500 text-sm font-semibold">
                        <?php echo htmlspecialchars($service['docs_subtitle'] ?? 'Scanned copies are sufficient. No physical originals are required for submission.'); ?>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 text-left">
                    <?php foreach ($docs_list as $col_idx => $doc_col): ?>
                    <div class="bg-white rounded-3xl border border-slate-200 p-8 space-y-6">
                        <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                            <i class="<?php echo htmlspecialchars($doc_col['icon'] ?? 'fa-solid fa-circle-info'); ?> text-brand-500"></i>
                            <?php echo htmlspecialchars($doc_col['section_title'] ?? 'Documents Needed'); ?>
                        </h3>
                        <ul class="grid grid-cols-1 gap-4 text-xs font-semibold text-slate-655">
                            <?php foreach (($doc_col['items'] ?? []) as $item_idx => $doc_item): ?>
                            <li class="flex items-start gap-3">
                                <?php if ($col_idx === 0): ?>
                                <span class="w-5 h-5 rounded-full bg-brand-500/10 text-brand-700 flex items-center justify-center text-[10px] mt-0.5"><i class="fa-solid fa-check"></i></span>
                                <?php else: ?>
                                <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-[10px] mt-0.5"><?php echo $item_idx + 1; ?></span>
                                <?php endif; ?>
                                <div>
                                    <span class="font-bold text-slate-900 block"><?php echo htmlspecialchars($doc_item['title'] ?? ''); ?></span>
                                    <span class="text-[10px] text-slate-450 block mt-0.5"><?php echo htmlspecialchars($doc_item['desc'] ?? ''); ?></span>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Pricing Packages Section -->
        <section class="py-24 bg-white border-b border-slate-100" id="pricing-plans">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-16">
                <div class="max-w-3xl mx-auto space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-tags text-[9px]"></i> Pricing Packages
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Transparent Pricing. No Hidden Charges.
                    </h2>
                    <p class="text-slate-500 text-sm font-semibold">
                        Select a package tailored for your venture. Government fee variables apply based on capital and state dynamics.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left items-stretch">
                    <?php foreach ($pricing_packages as $pkg): ?>
                    <div class="rounded-3xl border p-8 flex flex-col justify-between transition-all duration-300 hover:scale-[1.02] <?php echo !empty($pkg['best_value']) ? 'bg-slate-900 border-brand-500/20 text-white shadow-xl relative' : 'bg-white border-slate-200 text-slate-900'; ?>">
                        <?php if (!empty($pkg['best_value'])): ?>
                        <div class="absolute top-0 right-0 bg-brand-500 text-slate-900 text-[8px] font-black uppercase tracking-widest px-4 py-1.5 rounded-bl-2xl">
                            Best Value
                        </div>
                        <?php endif; ?>
                        
                        <div class="space-y-6">
                            <span class="text-[9px] font-black uppercase tracking-widest block <?php echo !empty($pkg['best_value']) ? 'text-brand-400' : 'text-slate-455'; ?>">
                                <?php echo htmlspecialchars($pkg['name'] ?? ''); ?>
                            </span>
                            <h3 class="text-lg font-black <?php echo !empty($pkg['best_value']) ? 'text-white' : 'text-slate-900'; ?>">
                                <?php echo htmlspecialchars($pkg['title'] ?? ''); ?>
                            </h3>
                            <p class="text-xs font-semibold <?php echo !empty($pkg['best_value']) ? 'text-slate-400' : 'text-slate-500'; ?>">
                                <?php echo htmlspecialchars($pkg['desc'] ?? ''); ?>
                            </p>
                            
                            <div class="py-4 border-y flex items-baseline gap-1 <?php echo !empty($pkg['best_value']) ? 'border-slate-800' : 'border-slate-100'; ?>">
                                <span class="text-3xl font-black <?php echo !empty($pkg['best_value']) ? 'text-white' : 'text-slate-900'; ?>">
                                    <?php echo htmlspecialchars($pkg['price'] ?? ''); ?>
                                </span>
                                <span class="text-[10px] font-extrabold uppercase text-slate-450">+ Govt Fees</span>
                            </div>

                            <ul class="space-y-3.5 text-xs font-semibold <?php echo !empty($pkg['best_value']) ? 'text-slate-300' : 'text-slate-655'; ?>">
                                <?php foreach (($pkg['bullets'] ?? []) as $bullet): ?>
                                <li class="flex items-start gap-2.5">
                                    <i class="mt-0.5 text-sm <?php echo !empty($pkg['best_value']) ? 'fa-solid fa-circle-check text-brand-400' : 'fa-solid fa-circle-check text-brand-500'; ?>"></i>
                                    <span><?php echo htmlspecialchars($bullet); ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                        <a href="#contact-bottom-anchor" class="block text-center w-full py-3.5 mt-8 rounded-xl text-xs transition-colors uppercase tracking-widest <?php echo !empty($pkg['best_value']) ? 'bg-brand-500 hover:bg-brand-400 text-slate-900 font-black' : 'border border-slate-200 hover:border-slate-800 text-slate-800 hover:bg-slate-50 font-bold'; ?>">
                            Get Started
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- FAQs Section -->
        <section class="py-24 bg-slate-50 border-b border-slate-100">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-16">
                
                <div class="space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-circle-question text-[9px]"></i> FAQ Desk
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Common Queries Solved
                    </h2>
                </div>

                <!-- Accordion details tag list -->
                <div class="space-y-4 text-left">
                    <?php foreach ($faqs as $faq): ?>
                    <details class="group bg-white border border-slate-200 rounded-2xl p-5 hover:border-slate-350 transition-all [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center justify-between cursor-pointer select-none">
                            <span class="text-sm font-black text-slate-900"><?php echo htmlspecialchars($faq['q'] ?? ''); ?></span>
                            <span class="w-6 h-6 rounded-full bg-slate-50 text-slate-500 flex items-center justify-center group-open:rotate-180 transition-transform">
                                <i class="fa-solid fa-chevron-down text-[9px]"></i>
                            </span>
                        </summary>
                        <p class="text-xs text-slate-550 leading-relaxed font-semibold mt-4 pt-4 border-t border-slate-100">
                            <?php echo nl2br(htmlspecialchars($faq['a'] ?? '')); ?>
                        </p>
                    </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Bottom Call to action Lead Form -->
        <section class="py-24 bg-slate-900 text-white text-center relative overflow-hidden" id="contact-bottom-anchor">
            <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left info -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Ready to incorporate? Speak to our CA.</h2>
                        <p class="text-slate-300 text-sm font-semibold">
                            Get complete assistance in business registration. Speak directly with a CA regarding state duties, name guidelines, and tax structures.
                        </p>
                        
                        <?php 
                        $bottomPhones = getWebPhones();
                        $firstBottomPhone = !empty($bottomPhones) ? reset($bottomPhones) : ['label' => 'Hotline', 'value' => '+91 98765 43210'];
                        ?>
                        <div class="flex items-center gap-4">
                            <a href="tel:<?php echo htmlspecialchars($firstBottomPhone['value']); ?>" class="inline-flex items-center gap-2 px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-xs font-bold text-white rounded-xl transition-all">
                                <i class="fa-solid fa-phone text-brand-500"></i> Call Support: <?php echo htmlspecialchars($firstBottomPhone['value']); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Right Form -->
                    <div class="lg:col-span-6">
                        <div class="bg-white/5 border border-white/10 p-6 sm:p-8 rounded-3xl text-left space-y-4">
                            <h3 class="text-sm font-black text-white uppercase tracking-wider">Book Free CA Consultation</h3>

                            <!-- Success/Error Message display -->
                            <?php if (!empty($successMsg)): ?>
                                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold flex items-start gap-2.5">
                                    <i class="fa-solid fa-circle-check text-sm mt-0.5"></i>
                                    <span><?php echo htmlspecialchars($successMsg); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errorMsg)): ?>
                                <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold flex items-start gap-2.5">
                                    <i class="fa-solid fa-triangle-exclamation text-sm mt-0.5"></i>
                                    <span><?php echo htmlspecialchars($errorMsg); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <form action="" method="POST" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <input type="text" name="name" placeholder="Your Name" required 
                                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-800 border border-slate-700 text-white rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                    <input type="tel" name="phone" placeholder="Phone Number" required 
                                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-800 border border-slate-700 text-white rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                </div>
                                <input type="email" name="email" placeholder="Email Address" required 
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-800 border border-slate-700 text-white rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                <button type="submit" class="w-full py-3.5 rounded-xl text-xs font-black text-slate-900 bg-brand-400 hover:bg-brand-300 transition-colors uppercase tracking-widest">
                                    Submit Request
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer -->
    <?php include_once 'components/footer.php'; ?>

</body>
</html>
