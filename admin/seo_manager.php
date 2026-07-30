<?php
/**
 * Zenvora Global Solutions - Per-Page SEO Metadata Manager
 */
session_start();
require_once __DIR__ . '/../components/db_connect.php';
require_once __DIR__ . '/../components/settings_helper.php';

// Auth Guard: Admin session must be active
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || !isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit;
}

$adminUsername = $_SESSION['admin_username'] ?? 'Admin';
$successMsg = '';
$errorMsg = '';

// Check and initialize page_seo table if not exists (Auto-Migration)
if ($pdo !== null) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS page_seo (
            id INT AUTO_INCREMENT PRIMARY KEY,
            page_key VARCHAR(50) UNIQUE NOT NULL,
            page_name VARCHAR(100) NOT NULL,
            meta_title VARCHAR(255) NOT NULL,
            meta_description TEXT NOT NULL,
            meta_keywords TEXT DEFAULT NULL,
            canonical_url VARCHAR(255) DEFAULT NULL,
            schema_markup TEXT DEFAULT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB");

        // Seed default SEO configurations if empty
        $check = $pdo->query("SELECT COUNT(*) FROM page_seo")->fetchColumn();
        if ($check == 0) {
            $default_seos = [
                [
                    'page_key' => 'home',
                    'page_name' => 'Home Page (index.php)',
                    'meta_title' => 'Zenvora Global Solutions | Premier Legal, Tax & Compliance Partner',
                    'meta_description' => 'Zenvora Global Solutions is your premier partner for business setup, company registration, legal compliance, accounting, and growth services. Clean, modern, and compliant.',
                    'meta_keywords' => 'Company Registration, GST Filing, Trademark Registration, Bookkeeping, Legal Compliance, Startup Consulting, Zenvora',
                    'canonical_url' => 'http://localhost/commanpro/index.php',
                    'schema_markup' => '{"@context":"https://schema.org","@type":"Organization","name":"Zenvora Global Solutions","url":"http://localhost/commanpro/"}'
                ],
                [
                    'page_key' => 'about',
                    'page_name' => 'About Us (about.php)',
                    'meta_title' => 'About Our CA Advisory Firm | Zenvora Global Solutions',
                    'meta_description' => 'Outsource your startup formation, licensing, and compliance tracking to Zenvora. Learn about our qualified panel of Chartered Accountants and corporate attorneys.',
                    'meta_keywords' => 'Chartered Accountants, Corporate Attorneys, Noida Legal Desk, Zenvora Team',
                    'canonical_url' => 'http://localhost/commanpro/about.php',
                    'schema_markup' => ''
                ],
                [
                    'page_key' => 'services',
                    'page_name' => 'Services Catalog (services.php)',
                    'meta_title' => 'Corporate Services Catalog | Zenvora Global Solutions',
                    'meta_description' => 'Explore corporate legal, tax, and licensing services managed by Chartered Accountants and CS desks. Flat rates, clear deliverables, zero surprises.',
                    'meta_keywords' => 'Filing Services, GST Registrations, FSSAI Licenses, IEC Code, Trademark Filing',
                    'canonical_url' => 'http://localhost/commanpro/services.php',
                    'schema_markup' => ''
                ],
                [
                    'page_key' => 'contact',
                    'page_name' => 'Contact Advisory (contact.php)',
                    'meta_title' => 'Contact Advisory Desk | Zenvora Global Solutions',
                    'meta_description' => 'Get in touch with Zenvora Global Solutions. Speak directly with CAs, CSs, and attorneys regarding company registrations, GST filings, and licensing.',
                    'meta_keywords' => 'CA Helpline Noida, Call a CA, Compliance Advisory, Zenvora Phone Support',
                    'canonical_url' => 'http://localhost/commanpro/contact.php',
                    'schema_markup' => ''
                ],
                [
                    'page_key' => 'blog',
                    'page_name' => 'Advisory Blog (blog.php)',
                    'meta_title' => 'Corporate Advisory Articles & Insights | Zenvora Blog',
                    'meta_description' => 'Read standard insights on GST updates, startup funding structures, operational corporate licenses, and statutory tax calculations written by CAs.',
                    'meta_keywords' => 'GST News, Private Limited Setup, LLP Compliance Guide, Zenvora Advisory Blog',
                    'canonical_url' => 'http://localhost/commanpro/blog.php',
                    'schema_markup' => ''
                ],
                [
                    'page_key' => 'faqs',
                    'page_name' => 'FAQs Helpdesk (faqs.php)',
                    'meta_title' => 'Legal & Taxation FAQs Helpdesk | Zenvora',
                    'meta_description' => 'Browse answers to common questions about company incorporations, operational licenses, and corporate compliance audit timelines.',
                    'meta_keywords' => 'Compliance Help, Company Setup FAQ, GST Registration Help, Zenvora Support',
                    'canonical_url' => 'http://localhost/commanpro/faqs.php',
                    'schema_markup' => ''
                ]
            ];

            $stmt = $pdo->prepare("INSERT INTO page_seo (page_key, page_name, meta_title, meta_description, meta_keywords, canonical_url, schema_markup) VALUES (:page_key, :page_name, :meta_title, :meta_description, :meta_keywords, :canonical_url, :schema_markup)");
            foreach ($default_seos as $seo) {
                $stmt->execute($seo);
            }
        }
    } catch (PDOException $e) {
        $errorMsg = 'Failed to initialize database table: ' . $e->getMessage();
    }
}

// Edit Mode detection
$editSeo = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id']) && $pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM page_seo WHERE id = :id");
        $stmt->execute([':id' => (int)$_GET['id']]);
        $editSeo = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errorMsg = 'Error loading SEO configuration: ' . $e->getMessage();
    }
}

// Handle Form Submission (Add / Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    $action = $_POST['action'] ?? '';
    $page_key = trim($_POST['page_key'] ?? '');
    $page_name = trim($_POST['page_name'] ?? '');
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $meta_keywords = trim($_POST['meta_keywords'] ?? '');
    $canonical_url = trim($_POST['canonical_url'] ?? '');
    $schema_markup = trim($_POST['schema_markup'] ?? '');
    $seoId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($page_key === '' || $page_name === '' || $meta_title === '' || $meta_description === '') {
        $errorMsg = 'Key, Name, Title, and Description are required fields.';
    } else {
        try {
            if ($action === 'add') {
                $stmt = $pdo->prepare("INSERT INTO page_seo (page_key, page_name, meta_title, meta_description, meta_keywords, canonical_url, schema_markup) VALUES (:page_key, :page_name, :meta_title, :meta_description, :meta_keywords, :canonical_url, :schema_markup)");
                $stmt->execute([
                    ':page_key' => strtolower($page_key),
                    ':page_name' => $page_name,
                    ':meta_title' => $meta_title,
                    ':meta_description' => $meta_description,
                    ':meta_keywords' => $meta_keywords ?: null,
                    ':canonical_url' => $canonical_url ?: null,
                    ':schema_markup' => $schema_markup ?: null
                ]);
                $successMsg = 'SEO metadata added successfully!';
            } elseif ($action === 'edit' && $seoId > 0) {
                $stmt = $pdo->prepare("UPDATE page_seo SET page_key = :page_key, page_name = :page_name, meta_title = :meta_title, meta_description = :meta_description, meta_keywords = :meta_keywords, canonical_url = :canonical_url, schema_markup = :schema_markup WHERE id = :id");
                $stmt->execute([
                    ':page_key' => strtolower($page_key),
                    ':page_name' => $page_name,
                    ':meta_title' => $meta_title,
                    ':meta_description' => $meta_description,
                    ':meta_keywords' => $meta_keywords ?: null,
                    ':canonical_url' => $canonical_url ?: null,
                    ':schema_markup' => $schema_markup ?: null,
                    ':id' => $seoId
                ]);
                $successMsg = 'SEO metadata updated successfully!';
                
                header("Location: seo_manager.php?success=" . urlencode($successMsg));
                exit;
            }
        } catch (PDOException $e) {
            $errorMsg = 'Database operation failed: ' . $e->getMessage();
        }
    }
}

// Handle Delete Action (Only for custom pages)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && $pdo !== null) {
    try {
        $stmt = $pdo->prepare("DELETE FROM page_seo WHERE id = :id");
        $stmt->execute([':id' => (int)$_GET['id']]);
        $successMsg = 'SEO configuration deleted successfully!';
        header("Location: seo_manager.php?success=" . urlencode($successMsg));
        exit;
    } catch (PDOException $e) {
        $errorMsg = 'Failed to delete configuration: ' . $e->getMessage();
    }
}

// Fetch all SEO configurations
$seoConfigs = [];
if ($pdo !== null) {
    try {
        $seoConfigs = $pdo->query("SELECT * FROM page_seo ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Safe fail
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO Metadata Desk | Zenvora Admin Console</title>
    <!-- Google Fonts - Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    
    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style type="text/css">
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
    </style>
</head>
<body class="bg-slate-900 text-slate-100 flex min-h-screen">

    <!-- Admin Console Sidebar -->
    <div class="w-64 bg-slate-950 border-r border-slate-800 p-6 flex flex-col justify-between flex-shrink-0">
        <div class="space-y-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-400 flex items-center justify-center font-black">Z</div>
                <span class="text-xs font-black uppercase tracking-widest text-white">Console Panel</span>
            </div>

            <!-- Nav list -->
            <nav class="space-y-1">
                <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-1.5"><i class="fa-solid fa-chart-line text-[9px]"></i> Metrics & Leads</span>
                <a href="admin.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-chart-line text-sm"></i> <span>Dashboard Overview</span>
                </a>
                <a href="enquiries.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-envelope-open-text text-sm"></i> <span>Customer Enquiries</span>
                </a>
                
                <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mt-6 mb-2 flex items-center gap-1.5"><i class="fa-solid fa-sliders text-[9px]"></i> Website Settings</span>
                <a href="settings.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-sliders text-sm"></i> <span>General Configurations</span>
                </a>
                <a href="homepage.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-rectangle-ad text-sm"></i> <span>Hero Slider Manager</span>
                </a>
                <a href="services_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-folder-open text-sm"></i> <span>Services & Catalog</span>
                </a>
                <a href="about_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-circle-info text-sm"></i> <span>About Page Editor</span>
                </a>
                <a href="testimonials_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-star text-sm"></i> <span>Testimonials</span>
                </a>
                <a href="blog_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-newspaper text-sm"></i> <span>Blog Manager</span>
                </a>
                <a href="pricing_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-tags text-sm"></i> <span>Pricing Packages</span>
                </a>
                <a href="platform_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-earth-americas text-sm"></i> <span>Global Operations</span>
                </a>
                <a href="seo_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all bg-brand-500/10 text-brand-400 border border-brand-500/20">
                    <i class="fa-solid fa-search text-sm"></i> <span>Page SEO Settings</span>
                </a>
                
                <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mt-6 mb-2 flex items-center gap-1.5"><i class="fa-solid fa-user-shield text-[9px]"></i> Account</span>
                <a href="change_password.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-key text-sm"></i> <span>Change Password</span>
                </a>
            </nav>
        </div>

        <!-- Footer Account logout -->
        <div class="border-t border-slate-800 pt-4 flex items-center justify-between">
            <div class="text-left overflow-hidden">
                <span class="text-[10px] font-black text-slate-500 block uppercase">Logged in as</span>
                <span class="text-[11px] font-bold text-slate-200 block truncate"><?php echo htmlspecialchars($adminUsername); ?></span>
            </div>
            <a href="logout.php" title="Sign out" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-red-950 text-slate-400 hover:text-red-400 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-sign-out-alt text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Main Workspace -->
    <div class="flex-1 bg-slate-900 p-8 sm:p-12 overflow-y-auto">
        <div class="max-w-6xl mx-auto space-y-10 text-left">
            
            <!-- Dashboard Top Meta -->
            <div class="flex items-center justify-between border-b border-slate-800 pb-6">
                <div>
                    <h1 class="text-2xl font-black text-white">Page SEO Metadata Desk</h1>
                    <p class="text-xs text-slate-400 font-semibold mt-1">Configure Meta Titles, Descriptions, Canonical URLs, and JSON-LD schemas per page.</p>
                </div>
                <div class="text-right text-[11px] text-slate-500 font-semibold">
                    <span>Database: </span>
                    <span class="text-green-500"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Connected</span>
                </div>
            </div>

            <!-- Messages Alert -->
            <?php if ($successMsg || isset($_GET['success'])): ?>
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo htmlspecialchars($successMsg ?: ($_GET['success'] ?? '')); ?></span>
                </div>
            <?php endif; ?>
            <?php if ($errorMsg): ?>
                <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?php echo htmlspecialchars($errorMsg); ?></span>
                </div>
            <?php endif; ?>

            <!-- Split Panel: Form on left, SEO listing on right -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Card Editor Form (Col span 5) -->
                <div class="lg:col-span-5 bg-slate-950 border border-slate-800 rounded-3xl p-6 space-y-6">
                    <h3 class="text-sm font-extrabold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-search text-brand-400"></i>
                        <?php echo $editSeo ? 'Edit SEO Metadata' : 'Create Custom Page SEO'; ?>
                    </h3>
                    
                    <form action="seo_manager.php" method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="<?php echo $editSeo ? 'edit' : 'add'; ?>">
                        <?php if ($editSeo): ?>
                            <input type="hidden" name="id" value="<?php echo (int)$editSeo['id']; ?>">
                        <?php endif; ?>

                        <!-- Page Key -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Page Key * (Unique identifier, e.g. 'home')</label>
                            <input type="text" name="page_key" required placeholder="home" value="<?php echo htmlspecialchars($editSeo['page_key'] ?? ''); ?>" 
                                   <?php echo ($editSeo && in_array($editSeo['page_key'], ['home', 'about', 'services', 'contact', 'blog', 'faqs'])) ? 'readonly class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-500 focus:outline-none cursor-not-allowed"' : 'class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200"'; ?>>
                        </div>

                        <!-- Page Name -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Page Label/Title *</label>
                            <input type="text" name="page_name" required placeholder="Home Page (index.php)" value="<?php echo htmlspecialchars($editSeo['page_name'] ?? ''); ?>" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <!-- Meta Title -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Meta Title Tag * (Max 60 chars recommended)</label>
                            <input type="text" name="meta_title" required placeholder="Zenvora | Corporate advisory..." value="<?php echo htmlspecialchars($editSeo['meta_title'] ?? ''); ?>" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <!-- Canonical URL -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Canonical URL (Canonical Link tag)</label>
                            <input type="url" name="canonical_url" placeholder="http://localhost/commanpro/index.php" value="<?php echo htmlspecialchars($editSeo['canonical_url'] ?? ''); ?>" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <!-- Meta Description -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Meta Description * (Max 160 chars recommended)</label>
                            <textarea name="meta_description" rows="3" required placeholder="Zenvora Global Solutions is your premier..."
                                      class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200 resize-none"><?php echo htmlspecialchars($editSeo['meta_description'] ?? ''); ?></textarea>
                        </div>

                        <!-- Meta Keywords -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Meta Keywords (Comma-separated)</label>
                            <textarea name="meta_keywords" rows="2" placeholder="Company Setup, GST registration, tax compliance..."
                                      class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200 resize-none"><?php echo htmlspecialchars($editSeo['meta_keywords'] ?? ''); ?></textarea>
                        </div>

                        <!-- Schema Markup -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">JSON-LD Schema Markup (Inside &lt;script type="application/ld+json"&gt;)</label>
                            <textarea name="schema_markup" rows="4" placeholder='{"@context":"https://schema.org","@type":"Organization",...}'
                                      class="w-full text-xs font-mono px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200 resize-none"><?php echo htmlspecialchars($editSeo['schema_markup'] ?? ''); ?></textarea>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="submit" class="flex-1 text-center py-2.5 rounded-xl text-xs font-black text-slate-950 bg-brand-500 hover:bg-brand-400 transition-colors uppercase tracking-wider">
                                <?php echo $editSeo ? 'Update SEO' : 'Save SEO'; ?>
                            </button>
                            <?php if ($editSeo): ?>
                                <a href="seo_manager.php" class="px-4 py-2.5 text-center bg-slate-850 hover:bg-slate-800 text-slate-300 border border-slate-800 rounded-xl text-xs font-black uppercase tracking-wider transition-colors">
                                    Cancel
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- Card List Table (Col span 7) -->
                <div class="lg:col-span-7 bg-slate-950 border border-slate-800 rounded-3xl overflow-hidden p-6 space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                        <h3 class="text-sm font-extrabold text-white uppercase tracking-wider">
                            <i class="fa-solid fa-search-plus text-brand-400"></i> Active Page SEO Settings
                        </h3>
                        <span class="text-[10px] text-slate-400 font-extrabold uppercase"><?php echo count($seoConfigs); ?> Pages</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-slate-800 text-[10px] text-slate-500 font-extrabold uppercase tracking-wider">
                                    <th class="py-3">Page Name</th>
                                    <th class="py-3">Title Tag</th>
                                    <th class="py-3 text-center">Schema</th>
                                    <th class="py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60 font-medium">
                                <?php foreach ($seoConfigs as $cfg): ?>
                                    <tr class="hover:bg-slate-900/30 transition-colors">
                                        <td class="py-4 space-y-1">
                                            <span class="font-extrabold text-white block"><?php echo htmlspecialchars($cfg['page_name']); ?></span>
                                            <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider inline-block bg-brand-500/10 text-brand-400 border border-brand-500/20">
                                                Key: <?php echo htmlspecialchars($cfg['page_key']); ?>
                                            </span>
                                        </td>
                                        <td class="py-4 text-slate-400 max-w-[200px] truncate" title="<?php echo htmlspecialchars($cfg['meta_title']); ?>">
                                            <?php echo htmlspecialchars($cfg['meta_title']); ?>
                                        </td>
                                        <td class="py-4 text-center">
                                            <?php if (trim($cfg['schema_markup'] ?? '') !== ''): ?>
                                                <span class="text-green-400" title="JSON-LD Configured"><i class="fa-solid fa-circle-check"></i></span>
                                            <?php else: ?>
                                                <span class="text-slate-600">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 text-right space-x-2 whitespace-nowrap">
                                            <a href="seo_manager.php?action=edit&id=<?php echo $cfg['id']; ?>" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-slate-850 text-brand-400 flex items-center justify-center inline-flex transition-colors border border-slate-800 hover:border-brand-500/30" title="Edit Metadata">
                                                <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                            </a>
                                            <?php if (!in_array($cfg['page_key'], ['home', 'about', 'services', 'contact', 'blog', 'faqs'])): ?>
                                                <a href="seo_manager.php?action=delete&id=<?php echo $cfg['id']; ?>" onclick="return confirm('Are you sure you want to delete this custom SEO page?');" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-red-950/20 text-red-400 flex items-center justify-center inline-flex transition-colors border border-slate-800 hover:border-red-500/30" title="Delete">
                                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</body>
</html>
