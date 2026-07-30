<?php
/**
 * Zenvora Global Solutions - Services & Catalog Manager Admin Panel
 * Manages Service Categories and Services dynamically.
 * Features collapsible accordion lists, upload modules and JSON repeaters.
 */
session_start();
require_once '../components/db_connect.php';
require_once '../components/settings_helper.php';

// Auth Guard Check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$successMsg = '';
$errorMsg = '';
$action = $_GET['action'] ?? 'list';
$editId = $_GET['id'] ?? null;

// File Upload Handler Helper
function handleUpload($fileKey, $destDir = '../assets/images/') {
    if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }
    
    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES[$fileKey]['name']);
    $destPath = $destDir . $filename;
    
    if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $destPath)) {
        return 'assets/images/' . $filename; // Relative path stored in DB
    }
    return null;
}

// -------------------------------------------------------------
// POST ROUTINES: CREATE / UPDATE
// -------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. ADD / EDIT CATEGORY
    if (isset($_POST['category_action'])) {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $icon = trim($_POST['icon'] ?? 'fa-solid fa-rocket');
        $sort_order = intval($_POST['sort_order'] ?? 0);
        $imageUrl = '';
        
        if (empty($name) || empty($slug)) {
            $errorMsg = 'Category Name and Slug are required.';
        } else {
            // Process upload
            $uploadedPath = handleUpload('image_file');
            
            if ($_POST['category_action'] === 'add') {
                $imageUrl = $uploadedPath ?: 'assets/images/hero_bg.jpg';
                try {
                    $stmt = $pdo->prepare("INSERT INTO service_categories (name, slug, icon, image_url, sort_order) VALUES (:name, :slug, :icon, :image, :sort)");
                    $stmt->execute([
                        ':name' => $name,
                        ':slug' => $slug,
                        ':icon' => $icon,
                        ':image' => $imageUrl,
                        ':sort' => $sort_order
                    ]);
                    $successMsg = 'Category added successfully!';
                    header("Location: services_manager.php?success=" . urlencode($successMsg));
                    exit;
                } catch (PDOException $e) {
                    $errorMsg = 'Failed to add category: ' . $e->getMessage();
                }
            } elseif ($_POST['category_action'] === 'edit') {
                $existingImage = $_POST['existing_image'] ?? '';
                $imageUrl = $uploadedPath ?: $existingImage;
                try {
                    $stmt = $pdo->prepare("UPDATE service_categories SET name = :name, slug = :slug, icon = :icon, image_url = :image, sort_order = :sort WHERE id = :id");
                    $stmt->execute([
                        ':name' => $name,
                        ':slug' => $slug,
                        ':icon' => $icon,
                        ':image' => $imageUrl,
                        ':sort' => $sort_order,
                        ':id' => $editId
                    ]);
                    $successMsg = 'Category updated successfully!';
                    header("Location: services_manager.php?success=" . urlencode($successMsg));
                    exit;
                } catch (PDOException $e) {
                    $errorMsg = 'Failed to update category: ' . $e->getMessage();
                }
            }
        }
    }
    
    // 2. ADD / EDIT SERVICE DETAIL PAGE
    if (isset($_POST['service_action'])) {
        $catId = intval($_POST['category_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $tagline = trim($_POST['tagline'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $starting_price = trim($_POST['starting_price'] ?? '');
        $average_duration = trim($_POST['average_duration'] ?? '');
        $what_is_brief = trim($_POST['what_is_brief'] ?? '');
        $docs_title = trim($_POST['docs_title'] ?? 'Documents Needed. Keep Them Ready.');
        $docs_subtitle = trim($_POST['docs_subtitle'] ?? 'Scanned copies are sufficient. No physical originals are required for submission.');
        
        // Dynamic repeaters parsed from POST inputs
        $pillars = $_POST['pillars'] ?? [];
        $steps = $_POST['steps'] ?? [];
        $deliverables = $_POST['deliverables'] ?? [];
        $pricing = $_POST['pricing'] ?? [];
        $faqs = $_POST['faqs'] ?? [];
        
        // Documents columns parsing
        $docs_col1_title = trim($_POST['docs_col1_title'] ?? 'Filing Guidelines & Tips');
        $docs_col1_icon = trim($_POST['docs_col1_icon'] ?? 'fa-solid fa-circle-info');
        $docs_col1 = $_POST['docs_col1'] ?? [];
        
        $docs_col2_title = trim($_POST['docs_col2_title'] ?? 'Requirements for Promoters');
        $docs_col2_icon = trim($_POST['docs_col2_icon'] ?? 'fa-solid fa-id-card');
        $docs_col2 = $_POST['docs_col2'] ?? [];
        
        $docs_col3_title = trim($_POST['docs_col3_title'] ?? 'Premises Proof Details');
        $docs_col3_icon = trim($_POST['docs_col3_icon'] ?? 'fa-solid fa-house-chimney');
        $docs_col3 = $_POST['docs_col3'] ?? [];

        // Clean docs columns
        $col1_clean = [];
        if (isset($docs_col1['title'])) {
            for ($i = 0; $i < count($docs_col1['title']); $i++) {
                if (!empty($docs_col1['title'][$i])) {
                    $col1_clean[] = [
                        'title' => $docs_col1['title'][$i],
                        'desc' => $docs_col1['desc'][$i] ?? ''
                    ];
                }
            }
        }
        
        $col2_clean = [];
        if (isset($docs_col2['title'])) {
            for ($i = 0; $i < count($docs_col2['title']); $i++) {
                if (!empty($docs_col2['title'][$i])) {
                    $col2_clean[] = [
                        'title' => $docs_col2['title'][$i],
                        'desc' => $docs_col2['desc'][$i] ?? ''
                    ];
                }
            }
        }

        $col3_clean = [];
        if (isset($docs_col3['title'])) {
            for ($i = 0; $i < count($docs_col3['title']); $i++) {
                if (!empty($docs_col3['title'][$i])) {
                    $col3_clean[] = [
                        'title' => $docs_col3['title'][$i],
                        'desc' => $docs_col3['desc'][$i] ?? ''
                    ];
                }
            }
        }

        $docs_json_compiled = json_encode([
            [
                'section_title' => $docs_col1_title,
                'icon' => $docs_col1_icon,
                'items' => $col1_clean
            ],
            [
                'section_title' => $docs_col2_title,
                'icon' => $docs_col2_icon,
                'items' => $col2_clean
            ],
            [
                'section_title' => $docs_col3_title,
                'icon' => $docs_col3_icon,
                'items' => $col3_clean
            ]
        ]);
        
        // Clean repeaters structures
        $pillars_clean = [];
        if (isset($pillars['title'])) {
            for ($i = 0; $i < count($pillars['title']); $i++) {
                if (!empty($pillars['title'][$i])) {
                    $pillars_clean[] = [
                        'icon' => $pillars['icon'][$i] ?? 'fa-solid fa-check',
                        'title' => $pillars['title'][$i],
                        'desc' => $pillars['desc'][$i] ?? ''
                    ];
                }
            }
        }
        
        $steps_clean = [];
        if (isset($steps['title'])) {
            for ($i = 0; $i < count($steps['title']); $i++) {
                if (!empty($steps['title'][$i])) {
                    $steps_clean[] = [
                        'number' => sprintf("%02d", $i + 1),
                        'title' => $steps['title'][$i],
                        'desc' => $steps['desc'][$i] ?? ''
                    ];
                }
            }
        }
        
        $deliverables_clean = array_filter(array_map('trim', $deliverables));
        
        $pricing_clean = [];
        if (isset($pricing['title'])) {
            for ($i = 0; $i < count($pricing['title']); $i++) {
                if (!empty($pricing['title'][$i])) {
                    $bullets = array_filter(array_map('trim', explode("\n", $pricing['bullets'][$i] ?? '')));
                    $pricing_clean[] = [
                        'name' => $pricing['name'][$i] ?? 'Plan',
                        'title' => $pricing['title'][$i],
                        'price' => $pricing['price'][$i] ?? '₹0',
                        'desc' => $pricing['desc'][$i] ?? '',
                        'bullets' => array_values($bullets),
                        'best_value' => isset($pricing['best_value'][$i]) && $pricing['best_value'][$i] == 1 ? true : false
                    ];
                }
            }
        }
        
        $faqs_clean = [];
        if (isset($faqs['q'])) {
            for ($i = 0; $i < count($faqs['q']); $i++) {
                if (!empty($faqs['q'][$i])) {
                    $faqs_clean[] = [
                        'q' => $faqs['q'][$i],
                        'a' => $faqs['a'][$i] ?? ''
                    ];
                }
            }
        }
        
        if ($catId === 0 || empty($title) || empty($slug)) {
            $errorMsg = 'Category, Service Title and Slug are required.';
        } else {
            $uploadedHero = handleUpload('hero_file');
            
            if ($_POST['service_action'] === 'add') {
                $heroUrl = $uploadedHero ?: 'assets/images/incorporation_hero.jpg';
                try {
                    $stmt = $pdo->prepare("INSERT INTO services (category_id, title, slug, tagline, description, starting_price, average_duration, hero_image, what_is_brief, docs_title, docs_subtitle, pillars_json, steps_json, deliverables_json, pricing_packages_json, faqs_json, docs_json) VALUES (:cat, :title, :slug, :tagline, :desc, :price, :duration, :hero, :brief, :docs_title, :docs_subtitle, :pillars, :steps, :deliv, :pricing, :faqs, :docs_json)");
                    $stmt->execute([
                        ':cat' => $catId,
                        ':title' => $title,
                        ':slug' => $slug,
                        ':tagline' => $tagline,
                        ':desc' => $description,
                        ':price' => $starting_price,
                        ':duration' => $average_duration,
                        ':hero' => $heroUrl,
                        ':brief' => $what_is_brief,
                        ':docs_title' => $docs_title,
                        ':docs_subtitle' => $docs_subtitle,
                        ':pillars' => json_encode($pillars_clean),
                        ':steps' => json_encode($steps_clean),
                        ':deliv' => json_encode(array_values($deliverables_clean)),
                        ':pricing' => json_encode($pricing_clean),
                        ':faqs' => json_encode($faqs_clean),
                        ':docs_json' => $docs_json_compiled
                    ]);
                    $successMsg = 'Service details page added successfully!';
                    header("Location: services_manager.php?success=" . urlencode($successMsg));
                    exit;
                } catch (PDOException $e) {
                    $errorMsg = 'Failed to add service: ' . $e->getMessage();
                }
            } elseif ($_POST['service_action'] === 'edit') {
                $existingHero = $_POST['existing_hero'] ?? '';
                $heroUrl = $uploadedHero ?: $existingHero;
                try {
                    $stmt = $pdo->prepare("UPDATE services SET category_id = :cat, title = :title, slug = :slug, tagline = :tagline, description = :desc, starting_price = :price, average_duration = :duration, hero_image = :hero, what_is_brief = :brief, docs_title = :docs_title, docs_subtitle = :docs_subtitle, pillars_json = :pillars, steps_json = :steps, deliverables_json = :deliv, pricing_packages_json = :pricing, faqs_json = :faqs, docs_json = :docs_json WHERE id = :id");
                    $stmt->execute([
                        ':cat' => $catId,
                        ':title' => $title,
                        ':slug' => $slug,
                        ':tagline' => $tagline,
                        ':desc' => $description,
                        ':price' => $starting_price,
                        ':duration' => $average_duration,
                        ':hero' => $heroUrl,
                        ':brief' => $what_is_brief,
                        ':docs_title' => $docs_title,
                        ':docs_subtitle' => $docs_subtitle,
                        ':pillars' => json_encode($pillars_clean),
                        ':steps' => json_encode($steps_clean),
                        ':deliv' => json_encode(array_values($deliverables_clean)),
                        ':pricing' => json_encode($pricing_clean),
                        ':faqs' => json_encode($faqs_clean),
                        ':docs_json' => $docs_json_compiled,
                        ':id' => $editId
                    ]);
                    $successMsg = 'Service details page updated successfully!';
                    header("Location: services_manager.php?success=" . urlencode($successMsg));
                    exit;
                } catch (PDOException $e) {
                    $errorMsg = 'Failed to update service: ' . $e->getMessage();
                }
            }
        }
    }
}

// -------------------------------------------------------------
// GET ROUTINES: DELETE ACTION
// -------------------------------------------------------------
if ($action === 'delete_category' && $editId !== null) {
    try {
        $stmt = $pdo->prepare("DELETE FROM service_categories WHERE id = :id");
        $stmt->execute([':id' => $editId]);
        $successMsg = 'Category deleted successfully!';
        header("Location: services_manager.php?success=" . urlencode($successMsg));
        exit;
    } catch (PDOException $e) {
        $errorMsg = 'Failed to delete category: ' . $e->getMessage();
    }
}

if ($action === 'delete_service' && $editId !== null) {
    try {
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = :id");
        $stmt->execute([':id' => $editId]);
        $successMsg = 'Service deleted successfully!';
        header("Location: services_manager.php?success=" . urlencode($successMsg));
        exit;
    } catch (PDOException $e) {
        $errorMsg = 'Failed to delete service: ' . $e->getMessage();
    }
}

// Fetch general success notifications
if (isset($_GET['success'])) {
    $successMsg = $_GET['success'];
}

// Fetch DB queries for lists
$categories = $pdo->query("SELECT * FROM service_categories ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
$services = $pdo->query("SELECT s.*, c.name as category_name FROM services s JOIN service_categories c ON s.category_id = c.id ORDER BY s.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services & Catalog Manager | Zenvora Admin</title>
    
    <!-- Tailwind CDN + Space Grotesk + FA Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

<body class="h-full font-sans antialiased text-slate-600 selection:bg-brand-500 selection:text-white">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside id="admin-sidebar" class="w-64 bg-slate-900 flex flex-col justify-between transition-all duration-300 ease-in-out flex-shrink-0 z-30 overflow-hidden relative border-r border-slate-850 p-6">
            <div class="flex flex-col flex-grow space-y-8">
                <div class="flex items-center gap-3">
                    <img class="h-9 w-auto object-contain bg-white/5 p-1 rounded-lg" src="../<?php echo htmlspecialchars(getWebSetting('logo_url') ?: 'assets/images/logo/Zenvora_Global_Solutions_Logo.png'); ?>" alt="Logo">
                    <div>
                        <span class="text-xs font-black tracking-widest text-brand-400 block uppercase">Zenvora</span>
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Admin Control</span>
                    </div>
                </div>

                <nav class="flex-1 space-y-1">
                    <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mb-2 whitespace-nowrap">Metrics & Leads</span>
                    <a href="admin.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'admin.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-chart-line text-sm"></i> <span class="whitespace-nowrap">Dashboard Overview</span>
                    </a>
                    <a href="enquiries.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'enquiries.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-envelope-open-text text-sm"></i> <span class="whitespace-nowrap">Customer Enquiries</span>
                    </a>
                    
                    <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mt-6 mb-2 whitespace-nowrap">Website Settings</span>
                    <a href="settings.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'settings.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-sliders text-sm"></i> <span class="whitespace-nowrap">General Configurations</span>
                    </a>
                    <a href="homepage.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'homepage.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-rectangle-ad text-sm"></i> <span class="whitespace-nowrap">Hero Slider Manager</span>
                    </a>
                    <a href="services_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'services_manager.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-folder-open text-sm"></i> <span class="whitespace-nowrap">Services & Catalog</span>
                    </a>
                    <a href="about_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'about_manager.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-circle-info text-sm"></i> <span class="whitespace-nowrap">About Page Editor</span>
                    </a>
                    <a href="testimonials_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'testimonials_manager.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-star text-sm"></i> <span class="whitespace-nowrap">Testimonials</span>
                    </a>
                    <a href="blog_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'blog_manager.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-newspaper text-sm"></i> <span class="whitespace-nowrap">Blog Manager</span>
                    </a>
                    <a href="pricing_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'pricing_manager.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-tags text-sm"></i> <span class="whitespace-nowrap">Pricing Packages</span>
                    </a>
                    <a href="platform_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'platform_manager.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-earth-americas text-sm"></i> <span class="whitespace-nowrap">Global Operations</span>
                    </a>
                    <a href="seo_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'seo_manager.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-search text-sm"></i> <span class="whitespace-nowrap">Page SEO Settings</span>
                    </a>
                    
                    <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mt-6 mb-2 flex items-center gap-1.5"><i class="fa-solid fa-user-shield text-[9px]"></i> Account</span>
                    <a href="change_password.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all <?php echo (basename($_SERVER['PHP_SELF']) === 'change_password.php') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400'; ?>">
                        <i class="fa-solid fa-key text-sm"></i> <span class="whitespace-nowrap">Change Password</span>
                    </a>
                </nav>
            </div>

            <div class="border-t border-slate-800 pt-4 flex items-center justify-between flex-shrink-0">
                <div class="text-left overflow-hidden">
                    <span class="text-[10px] font-black text-slate-450 block uppercase">Logged in as</span>
                    <span class="text-[11px] font-bold text-slate-200 block truncate"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
                </div>
                <a href="logout.php" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-red-500/10 text-slate-400 hover:text-red-400 flex items-center justify-center transition-colors flex-shrink-0" title="Log Out Session">
                    <i class="fa-solid fa-power-off text-sm"></i>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden bg-slate-50">
            <!-- Header bar -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-8 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="w-10 h-10 rounded-xl hover:bg-slate-100 flex items-center justify-center text-slate-500">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>
                    <h1 class="text-base font-black text-slate-900 tracking-tight">Services & Catalog Manager</h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="../services.php" target="_blank" class="px-4 py-2 border border-slate-200 hover:border-slate-800 rounded-full text-[10px] font-bold text-slate-700 transition-all uppercase tracking-wider">
                        <i class="fa-solid fa-globe mr-1.5"></i> Visit Catalog Page
                    </a>
                </div>
            </header>

            <!-- Scrollable Content workspace -->
            <div class="flex-1 p-8 lg:p-12 overflow-y-auto w-full">
                
                <!-- Notifications alerts -->
                <?php if (!empty($successMsg)): ?>
                    <div class="p-4 mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                        <span><?php echo htmlspecialchars($successMsg); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errorMsg)): ?>
                    <div class="p-4 mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold flex items-center gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-base text-red-500"></i>
                        <span><?php echo htmlspecialchars($errorMsg); ?></span>
                    </div>
                <?php endif; ?>

                <!-- -------------------------------------------------------------
                     MODE 1: MAIN LIST (Categories & Services)
                     ------------------------------------------------------------- -->
                <?php if ($action === 'list'): ?>
                <div class="space-y-12">
                    
                    <!-- Top Actions -->
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-black text-slate-900 tracking-tight">Active Categories & Services</h2>
                        <div class="flex items-center gap-3">
                            <a href="services_manager.php?action=add_category" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-[10px] font-black text-white uppercase tracking-wider transition-colors">
                                <i class="fa-solid fa-folder-plus mr-1"></i> Add Category
                            </a>
                            <a href="services_manager.php?action=add_service" class="px-4 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-[10px] font-black text-slate-950 uppercase tracking-wider transition-colors">
                                <i class="fa-solid fa-circle-plus mr-1"></i> Create Service Page
                            </a>
                        </div>
                    </div>

                    <!-- Dynamic Categories with their sub-services -->
                    <div class="space-y-8">
                        <?php foreach ($categories as $cat): 
                            // Filter services belonging to this category
                            $catServices = array_filter($services, function($s) use ($cat) {
                                return $s['category_id'] == $cat['id'];
                            });
                        ?>
                        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 space-y-6">
                            
                            <!-- Category Header Banner -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                                <div class="flex items-center gap-4 text-left">
                                    <span class="w-12 h-12 rounded-2xl bg-brand-500/10 text-brand-600 flex items-center justify-center text-base border border-brand-500/20 flex-shrink-0">
                                        <i class="<?php echo htmlspecialchars($cat['icon']); ?>"></i>
                                    </span>
                                    <div>
                                        <h3 class="text-base font-black text-slate-900 leading-tight"><?php echo htmlspecialchars($cat['name']); ?></h3>
                                        <span class="text-[9px] font-mono text-slate-400">Slug: <?php echo htmlspecialchars($cat['slug']); ?></span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <a href="services_manager.php?action=edit_category&id=<?php echo $cat['id']; ?>" class="px-3.5 py-2 border border-slate-200 hover:border-slate-800 rounded-xl text-[10px] font-bold text-slate-700 transition-colors uppercase tracking-wider">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Category
                                    </a>
                                    <a href="services_manager.php?action=delete_category&id=<?php echo $cat['id']; ?>" onclick="return confirm('Deleting a category will delete all associated service detail pages! Proceed?')" class="px-3.5 py-2 bg-red-50 hover:bg-red-100 border border-red-100 text-[10px] font-bold text-red-600 rounded-xl transition-colors uppercase tracking-wider">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Delete
                                    </a>
                                </div>
                            </div>

                            <!-- List of Services under this category -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-left">
                                <?php if (empty($catServices)): ?>
                                <div class="col-span-full py-8 text-center text-slate-400 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-solid fa-folder-open text-xl text-slate-300"></i>
                                    <span class="text-[11px] font-bold">No service pages created under this category yet.</span>
                                    <a href="services_manager.php?action=add_service&category_id=<?php echo $cat['id']; ?>" class="text-[10px] font-black text-brand-600 hover:underline uppercase tracking-wide">
                                        Create one now <i class="fa-solid fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                                <?php endif; ?>
                                
                                <?php foreach ($catServices as $srv): ?>
                                <div class="bg-slate-50 border border-slate-200/50 p-5 rounded-2xl flex flex-col justify-between hover:border-slate-350 transition-all group">
                                    <div class="space-y-3">
                                        <div class="flex items-start justify-between">
                                            <h4 class="text-xs font-black text-slate-900 leading-snug group-hover:text-brand-600 transition-colors"><?php echo htmlspecialchars($srv['title']); ?></h4>
                                            <span class="text-[8px] font-black bg-white px-2 py-0.5 rounded text-slate-450 border border-slate-200/40 uppercase tracking-widest shrink-0"><?php echo htmlspecialchars($srv['average_duration']); ?></span>
                                        </div>
                                        <p class="text-[10px] text-slate-450 font-semibold leading-relaxed line-clamp-2"><?php echo htmlspecialchars($srv['description']); ?></p>
                                        
                                        <div class="flex items-center justify-between pt-2">
                                            <span class="text-[10px] font-bold text-slate-900">Price: <span class="text-brand-600"><?php echo htmlspecialchars($srv['starting_price']); ?></span></span>
                                            <span class="text-[9px] font-mono text-slate-400">slug: <?php echo htmlspecialchars($srv['slug']); ?></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 pt-4 mt-4 border-t border-slate-200/60">
                                        <a href="../service-detail.php?slug=<?php echo $srv['slug']; ?>" target="_blank" class="text-[9px] font-black text-brand-600 hover:text-brand-700 uppercase tracking-wider flex items-center gap-1">
                                            <i class="fa-solid fa-eye"></i> View Live
                                        </a>
                                        <a href="services_manager.php?action=edit_service&id=<?php echo $srv['id']; ?>" class="text-[9px] font-black text-slate-600 hover:text-slate-950 ml-auto flex items-center gap-1 uppercase tracking-wider">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <a href="services_manager.php?action=delete_service&id=<?php echo $srv['id']; ?>" onclick="return confirm('Are you sure you want to delete this service page?')" class="text-[9px] font-black text-red-500 hover:text-red-700 flex items-center gap-1 uppercase tracking-wider">
                                            <i class="fa-solid fa-trash-can"></i> Delete
                                        </a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
                <?php endif; ?>

                <!-- -------------------------------------------------------------
                     MODE 2: ADD / EDIT CATEGORY FORM
                     ------------------------------------------------------------- -->
                <?php 
                if ($action === 'add_category' || $action === 'edit_category'): 
                    $catData = ['name' => '', 'slug' => '', 'icon' => 'fa-solid fa-rocket', 'image_url' => '', 'sort_order' => 0];
                    if ($action === 'edit_category' && $editId !== null) {
                        $stmt = $pdo->prepare("SELECT * FROM service_categories WHERE id = :id");
                        $stmt->execute([':id' => $editId]);
                        $catData = $stmt->fetch(PDO::FETCH_ASSOC) ?: $catData;
                    }
                ?>
                <div class="max-w-2xl bg-white border border-slate-200 rounded-3xl p-8 space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <h2 class="text-base font-black text-slate-900 uppercase tracking-wider">
                            <?php echo $action === 'add_category' ? 'Add Service Category' : 'Edit Category Pillar'; ?>
                        </h2>
                        <a href="services_manager.php" class="text-xs text-slate-450 hover:text-slate-900 font-bold"><i class="fa-solid fa-chevron-left mr-1"></i> Back to list</a>
                    </div>

                    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 text-left">
                        <input type="hidden" name="category_action" value="<?php echo $action === 'add_category' ? 'add' : 'edit'; ?>">
                        <?php if ($action === 'edit_category'): ?>
                        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($catData['image_url']); ?>">
                        <?php endif; ?>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Category Name</label>
                                <input type="text" name="name" id="cat-name" value="<?php echo htmlspecialchars($catData['name']); ?>" required placeholder="e.g. Business Startup"
                                       class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">URL Slug</label>
                                <input type="text" name="slug" id="cat-slug" value="<?php echo htmlspecialchars($catData['slug']); ?>" required placeholder="e.g. business-startup"
                                       class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all bg-slate-50">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">FontAwesome Icon Class</label>
                                <input type="text" name="icon" value="<?php echo htmlspecialchars($catData['icon']); ?>" required placeholder="fa-solid fa-rocket"
                                       class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Sort Display Order</label>
                                <input type="number" name="sort_order" value="<?php echo htmlspecialchars($catData['sort_order']); ?>" required
                                       class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Upload Cover Image</label>
                            <input type="file" name="image_file" accept="image/*"
                                   class="w-full text-xs px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                            <?php if (!empty($catData['image_url'])): ?>
                            <div class="mt-3 flex items-center gap-3">
                                <img src="../<?php echo htmlspecialchars($catData['image_url']); ?>" class="w-20 h-12 object-cover rounded-lg border border-slate-200">
                                <span class="text-[10px] text-slate-400 font-mono">Current: <?php echo htmlspecialchars($catData['image_url']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="w-full py-3.5 mt-2 rounded-xl text-xs font-black text-slate-900 bg-brand-500 hover:bg-brand-650 transition-colors uppercase tracking-widest">
                            Save Category Changes
                        </button>
                    </form>
                </div>

                <script>
                    const catName = document.getElementById('cat-name');
                    const catSlug = document.getElementById('cat-slug');
                    if (catName && catSlug) {
                        catName.addEventListener('input', () => {
                            if ('<?php echo $action; ?>' === 'add_category') {
                                catSlug.value = catName.value
                                    .toLowerCase()
                                    .replace(/[^a-z0-9]+/g, '-')
                                    .replace(/(^-|-$)+/g, '');
                            }
                        });
                    }
                </script>
                <?php endif; ?>

                <!-- -------------------------------------------------------------
                     MODE 3: CREATE / EDIT SERVICE DETAIL PAGE (High Complexity Repeater Form)
                     ------------------------------------------------------------- -->
                <?php 
                if ($action === 'add_service' || $action === 'edit_service'):
                    $srvData = [
                        'category_id' => 0, 'title' => '', 'slug' => '', 'tagline' => '', 
                        'description' => '', 'starting_price' => '', 'average_duration' => '', 
                        'hero_image' => '', 'what_is_brief' => '',
                        'docs_title' => 'Documents Needed. Keep Them Ready.',
                        'docs_subtitle' => 'Scanned copies are sufficient. No physical originals are required for submission.',
                        'pillars_json' => '[]', 'steps_json' => '[]', 'deliverables_json' => '[]', 
                        'pricing_packages_json' => '[]', 'faqs_json' => '[]', 'docs_json' => '[]'
                    ];
                    if ($action === 'edit_service' && $editId !== null) {
                        $stmt = $pdo->prepare("SELECT * FROM services WHERE id = :id");
                        $stmt->execute([':id' => $editId]);
                        $srvData = $stmt->fetch(PDO::FETCH_ASSOC) ?: $srvData;
                    }
                    
                    // Parse values
                    $srvPillars = json_decode($srvData['pillars_json'], true) ?: [];
                    $srvSteps = json_decode($srvData['steps_json'], true) ?: [];
                    $srvDeliverables = json_decode($srvData['deliverables_json'], true) ?: [];
                    $srvPricing = json_decode($srvData['pricing_packages_json'], true) ?: [];
                    $srvFaqs = json_decode($srvData['faqs_json'], true) ?: [];
                    $srvDocs = json_decode($srvData['docs_json'] ?? '[]', true) ?: [];
                    if (empty($srvDocs)) {
                        $srvDocs = [
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
                ?>
                <div class="bg-white border border-slate-200 rounded-3xl p-8 lg:p-10 space-y-8 text-left">
                    
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <h2 class="text-base font-black text-slate-900 uppercase tracking-wider">
                            <?php echo $action === 'add_service' ? 'Create Dynamic Service Page' : 'Edit Service Page Settings'; ?>
                        </h2>
                        <a href="services_manager.php" class="text-xs text-slate-450 hover:text-slate-900 font-bold"><i class="fa-solid fa-chevron-left mr-1"></i> Back to list</a>
                    </div>

                    <form action="" method="POST" enctype="multipart/form-data" class="space-y-12">
                        <input type="hidden" name="service_action" value="<?php echo $action === 'add_service' ? 'add' : 'edit'; ?>">
                        <?php if ($action === 'edit_service'): ?>
                        <input type="hidden" name="existing_hero" value="<?php echo htmlspecialchars($srvData['hero_image']); ?>">
                        <?php endif; ?>

                        <!-- 1. GENERAL INFORMATION -->
                        <div class="space-y-6">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block border-b border-slate-100 pb-3">1. General Setup Credentials</span>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Category Pillar</label>
                                    <select name="category_id" required
                                            class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all bg-white">
                                        <option value="">Select Category...</option>
                                        <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo $srvData['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Service Title</label>
                                    <input type="text" name="title" id="srv-title" value="<?php echo htmlspecialchars($srvData['title']); ?>" required placeholder="e.g. Private Limited Company"
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">URL Slug</label>
                                    <input type="text" name="slug" id="srv-slug" value="<?php echo htmlspecialchars($srvData['slug']); ?>" required placeholder="e.g. private-limited-company"
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all bg-slate-50">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Tagline (Hero Highlight)</label>
                                    <input type="text" name="tagline" value="<?php echo htmlspecialchars($srvData['tagline']); ?>" required placeholder="e.g. Registration in India"
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Starting Price Tag</label>
                                    <input type="text" name="starting_price" value="<?php echo htmlspecialchars($srvData['starting_price']); ?>" required placeholder="e.g. ₹4,999"
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Average Completion Duration</label>
                                    <input type="text" name="average_duration" value="<?php echo htmlspecialchars($srvData['average_duration']); ?>" required placeholder="e.g. 7 Days"
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Short Brief Description (Hero Section)</label>
                                <textarea name="description" rows="3" required placeholder="Describe details to showcase in the dark banner section..."
                                          class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all"><?php echo htmlspecialchars($srvData['description']); ?></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                                <div class="md:col-span-8">
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Upload Hero Presentation Image</label>
                                    <input type="file" name="hero_file" accept="image/*"
                                           class="w-full text-xs px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                </div>
                                <div class="md:col-span-4">
                                    <?php if (!empty($srvData['hero_image'])): ?>
                                    <div class="flex items-center gap-3 border border-slate-200 p-3 rounded-2xl">
                                        <img src="../<?php echo htmlspecialchars($srvData['hero_image']); ?>" class="w-20 h-12 object-cover rounded-lg border border-slate-100">
                                        <span class="text-[9px] font-mono text-slate-400 truncate max-w-[120px]"><?php echo basename($srvData['hero_image']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- 2. NARRATIVE BRIEFING (What is it?) -->
                        <div class="space-y-6">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block border-b border-slate-100 pb-3">2. Detailed Concept & Documents Section Headings</span>
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Friendly Customer Description (Briefing)</label>
                                <textarea name="what_is_brief" rows="4" required placeholder="Write a simplified explanation as if a company is briefing a customer in person..."
                                          class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all"><?php echo htmlspecialchars($srvData['what_is_brief']); ?></textarea>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Documents Section Title</label>
                                    <input type="text" name="docs_title" value="<?php echo htmlspecialchars($srvData['docs_title'] ?? 'Documents Needed. Keep Them Ready.'); ?>" required placeholder="e.g. Documents Needed. Keep Them Ready."
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Documents Section Subtitle</label>
                                    <input type="text" name="docs_subtitle" value="<?php echo htmlspecialchars($srvData['docs_subtitle'] ?? 'Scanned copies are sufficient. No physical originals are required for submission.'); ?>" required placeholder="e.g. Scanned copies are sufficient..."
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- 2b. DYNAMIC DOCUMENTS REGISTRY COLUMNS -->
                        <div class="space-y-8 border-t border-slate-100 pt-8">
                            <div class="space-y-2">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">2b. Documents Required Registry (3 Columns Grid)</span>
                                <p class="text-[10px] text-slate-450 font-semibold leading-relaxed">Customize the three document requirement columns shown on the frontend landing page. Add, edit, or delete items inside each column.</p>
                            </div>
                            
                            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                                
                                <!-- Column 1 -->
                                <div class="bg-slate-50 border border-slate-200/60 p-6 rounded-2xl space-y-4">
                                    <div class="space-y-3">
                                        <h4 class="text-[11px] font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5 border-b border-slate-200 pb-2">
                                            <span class="w-5 h-5 rounded-full bg-brand-500/10 text-brand-655 text-[10px] font-bold flex items-center justify-center border border-brand-500/20">1</span> Column 1 Setup
                                        </h4>
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Column Title</label>
                                            <input type="text" name="docs_col1_title" value="<?php echo htmlspecialchars($srvDocs[0]['section_title'] ?? 'Filing Guidelines & Tips'); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FontAwesome Icon Class</label>
                                            <input type="text" name="docs_col1_icon" value="<?php echo htmlspecialchars($srvDocs[0]['icon'] ?? 'fa-solid fa-circle-info'); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between border-t border-slate-200/60 pt-3">
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Checklist Items</span>
                                            <button type="button" onclick="addDocColRow(1)" class="px-2 py-0.5 bg-white border border-slate-200 hover:border-slate-800 rounded text-[9px] font-bold text-slate-700 flex items-center gap-1">
                                                <i class="fa-solid fa-plus text-[8px]"></i> Add
                                            </button>
                                        </div>
                                        <div id="doc-col1-container" class="space-y-3">
                                            <?php 
                                            $col1_items = $srvDocs[0]['items'] ?? [];
                                            foreach ($col1_items as $idx => $item):
                                            ?>
                                            <div class="bg-white border border-slate-200/60 p-3 rounded-xl space-y-2 relative group">
                                                <input type="text" name="docs_col1[title][]" value="<?php echo htmlspecialchars($item['title']); ?>" required placeholder="Item Title" class="w-full text-[11px] font-bold px-2 py-1.5 border border-slate-150 rounded">
                                                <textarea name="docs_col1[desc][]" rows="2" placeholder="Item short description..." class="w-full text-[10px] px-2 py-1.5 border border-slate-150 rounded"><?php echo htmlspecialchars($item['desc']); ?></textarea>
                                                <button type="button" onclick="this.parentElement.remove()" class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-red-50 text-red-500 border border-red-200 flex items-center justify-center text-[9px] opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="bg-slate-50 border border-slate-200/60 p-6 rounded-2xl space-y-4">
                                    <div class="space-y-3">
                                        <h4 class="text-[11px] font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5 border-b border-slate-200 pb-2">
                                            <span class="w-5 h-5 rounded-full bg-brand-500/10 text-brand-655 text-[10px] font-bold flex items-center justify-center border border-brand-500/20">2</span> Column 2 Setup
                                        </h4>
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Column Title</label>
                                            <input type="text" name="docs_col2_title" value="<?php echo htmlspecialchars($srvDocs[1]['section_title'] ?? 'Requirements for Promoters'); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FontAwesome Icon Class</label>
                                            <input type="text" name="docs_col2_icon" value="<?php echo htmlspecialchars($srvDocs[1]['icon'] ?? 'fa-solid fa-id-card'); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between border-t border-slate-200/60 pt-3">
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Checklist Items</span>
                                            <button type="button" onclick="addDocColRow(2)" class="px-2 py-0.5 bg-white border border-slate-200 hover:border-slate-800 rounded text-[9px] font-bold text-slate-700 flex items-center gap-1">
                                                <i class="fa-solid fa-plus text-[8px]"></i> Add
                                            </button>
                                        </div>
                                        <div id="doc-col2-container" class="space-y-3">
                                            <?php 
                                            $col2_items = $srvDocs[1]['items'] ?? [];
                                            foreach ($col2_items as $idx => $item):
                                            ?>
                                            <div class="bg-white border border-slate-200/60 p-3 rounded-xl space-y-2 relative group">
                                                <input type="text" name="docs_col2[title][]" value="<?php echo htmlspecialchars($item['title']); ?>" required placeholder="Item Title" class="w-full text-[11px] font-bold px-2 py-1.5 border border-slate-150 rounded">
                                                <textarea name="docs_col2[desc][]" rows="2" placeholder="Item short description..." class="w-full text-[10px] px-2 py-1.5 border border-slate-150 rounded"><?php echo htmlspecialchars($item['desc']); ?></textarea>
                                                <button type="button" onclick="this.parentElement.remove()" class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-red-50 text-red-500 border border-red-200 flex items-center justify-center text-[9px] opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 3 -->
                                <div class="bg-slate-50 border border-slate-200/60 p-6 rounded-2xl space-y-4">
                                    <div class="space-y-3">
                                        <h4 class="text-[11px] font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5 border-b border-slate-200 pb-2">
                                            <span class="w-5 h-5 rounded-full bg-brand-500/10 text-brand-655 text-[10px] font-bold flex items-center justify-center border border-brand-500/20">3</span> Column 3 Setup
                                        </h4>
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Column Title</label>
                                            <input type="text" name="docs_col3_title" value="<?php echo htmlspecialchars($srvDocs[2]['section_title'] ?? 'Premises Proof Details'); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FontAwesome Icon Class</label>
                                            <input type="text" name="docs_col3_icon" value="<?php echo htmlspecialchars($srvDocs[2]['icon'] ?? 'fa-solid fa-house-chimney'); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between border-t border-slate-200/60 pt-3">
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Checklist Items</span>
                                            <button type="button" onclick="addDocColRow(3)" class="px-2 py-0.5 bg-white border border-slate-200 hover:border-slate-800 rounded text-[9px] font-bold text-slate-700 flex items-center gap-1">
                                                <i class="fa-solid fa-plus text-[8px]"></i> Add
                                            </button>
                                        </div>
                                        <div id="doc-col3-container" class="space-y-3">
                                            <?php 
                                            $col3_items = $srvDocs[2]['items'] ?? [];
                                            foreach ($col3_items as $idx => $item):
                                            ?>
                                            <div class="bg-white border border-slate-200/60 p-3 rounded-xl space-y-2 relative group">
                                                <input type="text" name="docs_col3[title][]" value="<?php echo htmlspecialchars($item['title']); ?>" required placeholder="Item Title" class="w-full text-[11px] font-bold px-2 py-1.5 border border-slate-150 rounded">
                                                <textarea name="docs_col3[desc][]" rows="2" placeholder="Item short description..." class="w-full text-[10px] px-2 py-1.5 border border-slate-150 rounded"><?php echo htmlspecialchars($item['desc']); ?></textarea>
                                                <button type="button" onclick="this.parentElement.remove()" class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-red-50 text-red-500 border border-red-200 flex items-center justify-center text-[9px] opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- 3. REPEATER: PILLARS / BENEFITS -->
                        <div class="space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">3. Corporate Pillars / Core Benefits</span>
                                <button type="button" onclick="addPillarRow()" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-plus text-[9px]"></i> Add Pillar
                                </button>
                            </div>
                            
                            <div id="pillars-container" class="space-y-4">
                                <?php if (empty($srvPillars)): ?>
                                    <!-- Seed default empty structure if new -->
                                    <script>window.addEventListener('load', () => { addPillarRow(); });</script>
                                <?php endif; ?>
                                <?php foreach ($srvPillars as $i => $plr): ?>
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-slate-50 p-4 border border-slate-200/60 rounded-2xl relative">
                                    <div class="md:col-span-2">
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                                        <input type="text" name="pillars[icon][]" value="<?php echo htmlspecialchars($plr['icon'] ?? 'fa-solid fa-check'); ?>"
                                               class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Pillar Title</label>
                                        <input type="text" name="pillars[title][]" value="<?php echo htmlspecialchars($plr['title'] ?? ''); ?>" required
                                               class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                    </div>
                                    <div class="md:col-span-6">
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Brief Description</label>
                                        <input type="text" name="pillars[desc][]" value="<?php echo htmlspecialchars($plr['desc'] ?? ''); ?>" required
                                               class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                    </div>
                                    <div class="md:col-span-1 text-center pt-4">
                                        <button type="button" onclick="this.parentElement.parentElement.remove()" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition-colors">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- 4. REPEATER: STEPS PROCESS -->
                        <div class="space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">4. Timeline / Form Filling Steps</span>
                                <button type="button" onclick="addStepRow()" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-plus text-[9px]"></i> Add Step
                                </button>
                            </div>
                            
                            <div id="steps-container" class="space-y-4">
                                <?php if (empty($srvSteps)): ?>
                                    <script>window.addEventListener('load', () => { addStepRow(); });</script>
                                <?php endif; ?>
                                <?php foreach ($srvSteps as $i => $step): ?>
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-slate-50 p-4 border border-slate-200/60 rounded-2xl relative">
                                    <div class="md:col-span-3">
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Step Heading</label>
                                        <input type="text" name="steps[title][]" value="<?php echo htmlspecialchars($step['title'] ?? ''); ?>" required
                                               class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                    </div>
                                    <div class="md:col-span-8">
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Detailed description of what gets done</label>
                                        <input type="text" name="steps[desc][]" value="<?php echo htmlspecialchars($step['desc'] ?? ''); ?>" required
                                               class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                    </div>
                                    <div class="md:col-span-1 text-center pt-4">
                                        <button type="button" onclick="this.parentElement.parentElement.remove()" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition-colors">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- 5. DELIVERABLES TAGS -->
                        <div class="space-y-6">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block border-b border-slate-100 pb-3">5. Deliverables Kit List (One per line)</span>
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">List of Deliverables</label>
                                <textarea name="deliverables[]" rows="5" placeholder="e.g. Certificate of Incorporation&#10;Company PAN & TAN&#10;EPFO Code allocation..."
                                          class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all font-mono"><?php echo htmlspecialchars(implode("\n", $srvDeliverables)); ?></textarea>
                            </div>
                        </div>

                        <!-- 6. REPEATER: PRICING PACKAGES -->
                        <div class="space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">6. Pricing Packages / Rates Options</span>
                                <button type="button" onclick="addPricingRow()" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-plus text-[9px]"></i> Add Package
                                </button>
                            </div>
                            
                            <div id="pricing-container" class="space-y-6">
                                <?php if (empty($srvPricing)): ?>
                                    <script>window.addEventListener('load', () => { addPricingRow(); });</script>
                                <?php endif; ?>
                                <?php foreach ($srvPricing as $idx => $pkg): ?>
                                <div class="bg-slate-50 p-6 border border-slate-200/60 rounded-3xl space-y-4 relative">
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Badge Name</label>
                                            <input type="text" name="pricing[name][]" value="<?php echo htmlspecialchars($pkg['name'] ?? ''); ?>" required placeholder="e.g. Standard Plan"
                                                   class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Package Title</label>
                                            <input type="text" name="pricing[title][]" value="<?php echo htmlspecialchars($pkg['title'] ?? ''); ?>" required placeholder="e.g. Basic Startup"
                                                   class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Starting Cost</label>
                                            <input type="text" name="pricing[price][]" value="<?php echo htmlspecialchars($pkg['price'] ?? ''); ?>" required placeholder="e.g. ₹4,999"
                                                   class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                        <div class="flex items-center gap-2 pt-5">
                                            <input type="checkbox" name="pricing[best_value_check][<?php echo $idx; ?>]" value="1" <?php echo !empty($pkg['best_value']) ? 'checked' : ''; ?> id="best-value-<?php echo $idx; ?>"
                                                   class="w-4 h-4 rounded text-brand-500 focus:ring-brand-500 border-slate-300">
                                            <label for="best-value-<?php echo $idx; ?>" class="text-[10px] font-black text-slate-700 uppercase tracking-wide cursor-pointer">Best Value Highlight</label>
                                            <input type="hidden" name="pricing[best_value][]" value="<?php echo !empty($pkg['best_value']) ? '1' : '0'; ?>" class="hidden-best-value">
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Package Description</label>
                                            <input type="text" name="pricing[desc][]" value="<?php echo htmlspecialchars($pkg['desc'] ?? ''); ?>" required placeholder="Short summary..."
                                                   class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Checklist Bullets (One per line)</label>
                                            <textarea name="pricing[bullets][]" rows="3" placeholder="Bullet 1&#10;Bullet 2&#10;Bullet 3..."
                                                      class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white font-mono"><?php echo htmlspecialchars(implode("\n", $pkg['bullets'] ?? [])); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- 7. REPEATER: FAQS ACCORDION -->
                        <div class="space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">7. FAQs Accordion desk</span>
                                <button type="button" onclick="addFaqRow()" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-plus text-[9px]"></i> Add FAQ
                                </button>
                            </div>
                            
                            <div id="faqs-container" class="space-y-4">
                                <?php if (empty($srvFaqs)): ?>
                                    <script>window.addEventListener('load', () => { addFaqRow(); });</script>
                                <?php endif; ?>
                                <?php foreach ($srvFaqs as $faq): ?>
                                <div class="bg-slate-50 p-4 border border-slate-200/60 rounded-2xl space-y-3 relative">
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-trash-can text-[10px]"></i>
                                    </button>
                                    
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Question</label>
                                        <input type="text" name="faqs[q][]" value="<?php echo htmlspecialchars($faq['q'] ?? ''); ?>" required
                                               class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Answer</label>
                                        <textarea name="faqs[a][]" rows="2" required
                                                  class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white"><?php echo htmlspecialchars($faq['a'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- SUBMIT -->
                        <div class="border-t border-slate-100 pt-6">
                            <button type="submit" class="w-full py-4 rounded-xl text-xs font-black text-slate-900 bg-brand-500 hover:bg-brand-600 transition-colors uppercase tracking-widest">
                                Save Dynamic Page Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Repeaters Javascript Templates -->
                <script>
                    function addPillarRow() {
                        const container = document.getElementById('pillars-container');
                        const div = document.createElement('div');
                        div.className = 'grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-slate-50 p-4 border border-slate-200/60 rounded-2xl relative';
                        div.innerHTML = `
                            <div class="md:col-span-2">
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                                <input type="text" name="pillars[icon][]" value="fa-solid fa-check"
                                       class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Pillar Title</label>
                                <input type="text" name="pillars[title][]" required
                                       class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                            </div>
                            <div class="md:col-span-6">
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Brief Description</label>
                                <input type="text" name="pillars[desc][]" required
                                       class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                            </div>
                            <div class="md:col-span-1 text-center pt-4">
                                <button type="button" onclick="this.parentElement.parentElement.remove()" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        `;
                        container.appendChild(div);
                    }

                    function addStepRow() {
                        const container = document.getElementById('steps-container');
                        const div = document.createElement('div');
                        div.className = 'grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-slate-50 p-4 border border-slate-200/60 rounded-2xl relative';
                        div.innerHTML = `
                            <div class="md:col-span-3">
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Step Heading</label>
                                <input type="text" name="steps[title][]" required
                                       class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                            </div>
                            <div class="md:col-span-8">
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Detailed description of what gets done</label>
                                <input type="text" name="steps[desc][]" required
                                       class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                            </div>
                            <div class="md:col-span-1 text-center pt-4">
                                <button type="button" onclick="this.parentElement.parentElement.remove()" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        `;
                        container.appendChild(div);
                    }

                    function addPricingRow() {
                        const container = document.getElementById('pricing-container');
                        const index = container.children.length;
                        const div = document.createElement('div');
                        div.className = 'bg-slate-50 p-6 border border-slate-200/60 rounded-3xl space-y-4 relative';
                        div.innerHTML = `
                            <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Badge Name</label>
                                    <input type="text" name="pricing[name][]" required placeholder="e.g. Standard Plan"
                                           class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Package Title</label>
                                    <input type="text" name="pricing[title][]" required placeholder="e.g. Basic Startup"
                                           class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Starting Cost</label>
                                    <input type="text" name="pricing[price][]" required placeholder="e.g. ₹4,999"
                                           class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                </div>
                                <div class="flex items-center gap-2 pt-5">
                                    <input type="checkbox" name="pricing[best_value_check][${index}]" value="1" id="best-value-${index}"
                                           class="w-4 h-4 rounded text-brand-500 focus:ring-brand-500 border-slate-300">
                                    <label for="best-value-${index}" class="text-[10px] font-black text-slate-700 uppercase tracking-wide cursor-pointer">Best Value Highlight</label>
                                    <input type="hidden" name="pricing[best_value][]" value="0" class="hidden-best-value">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Package Description</label>
                                    <input type="text" name="pricing[desc][]" required placeholder="Short summary..."
                                           class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Checklist Bullets (One per line)</label>
                                    <textarea name="pricing[bullets][]" rows="3" placeholder="Bullet 1&#10;Bullet 2&#10;Bullet 3..."
                                              class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white font-mono"></textarea>
                                </div>
                            </div>
                        `;
                        container.appendChild(div);
                        setupCheckboxesListener();
                    }

                    function addFaqRow() {
                        const container = document.getElementById('faqs-container');
                        const div = document.createElement('div');
                        div.className = 'bg-slate-50 p-4 border border-slate-200/60 rounded-2xl space-y-3 relative';
                        div.innerHTML = `
                            <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                            </button>
                            
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Question</label>
                                <input type="text" name="faqs[q][]" required
                                       class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Answer</label>
                                <textarea name="faqs[a][]" rows="2" required
                                          class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-brand-500 bg-white"></textarea>
                            </div>
                        `;
                        container.appendChild(div);
                    }

                    // Synchronize checkbox state to hidden input array so order matches indexes in POST
                    function setupCheckboxesListener() {
                        const containers = document.querySelectorAll('#pricing-container > div');
                        containers.forEach((el, idx) => {
                            const checkbox = el.querySelector('input[type="checkbox"]');
                            const hiddenInput = el.querySelector('.hidden-best-value');
                            if (checkbox && hiddenInput) {
                                // Rename checkbox name index dynamically
                                checkbox.name = `pricing[best_value_check][${idx}]`;
                                checkbox.addEventListener('change', () => {
                                    hiddenInput.value = checkbox.checked ? '1' : '0';
                                });
                                // init current state
                                hiddenInput.value = checkbox.checked ? '1' : '0';
                            }
                        });
                    }
                    
                    document.addEventListener('DOMContentLoaded', setupCheckboxesListener);

                    function addDocColRow(colIdx) {
                        const container = document.getElementById(`doc-col${colIdx}-container`);
                        if (!container) return;
                        
                        const div = document.createElement('div');
                        div.className = 'bg-white border border-slate-200/60 p-3 rounded-xl space-y-2 relative group';
                        div.innerHTML = `
                            <input type="text" name="docs_col${colIdx}[title][]" required placeholder="Item Title" class="w-full text-[11px] font-bold px-2 py-1.5 border border-slate-150 rounded">
                            <textarea name="docs_col${colIdx}[desc][]" rows="2" placeholder="Item short description..." class="w-full text-[10px] px-2 py-1.5 border border-slate-150 rounded"></textarea>
                            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-red-50 text-red-500 border border-red-200 flex items-center justify-center text-[9px] opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        `;
                        container.appendChild(div);
                    }

                    // Auto slug listener
                    const srvTitle = document.getElementById('srv-title');
                    const srvSlug = document.getElementById('srv-slug');
                    if (srvTitle && srvSlug) {
                        srvTitle.addEventListener('input', () => {
                            if ('<?php echo $action; ?>' === 'add_service') {
                                srvSlug.value = srvTitle.value
                                    .toLowerCase()
                                    .replace(/[^a-z0-9]+/g, '-')
                                    .replace(/(^-|-$)+/g, '');
                            }
                        });
                    }
                </script>
                <?php endif; ?>

            </div>
        </main>
    </div>

    <!-- Responsive sidebar JS toggler -->
    <script>
        const btnToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('admin-sidebar');

        if (btnToggle && sidebar) {
            btnToggle.addEventListener('click', () => {
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-0');
                sidebar.classList.toggle('p-6');
                sidebar.classList.toggle('border-r');
            });
        }
    </script>

</body>
</html>
