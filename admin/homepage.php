<?php
session_start();
require_once __DIR__ . '/../components/db_connect.php';
require_once __DIR__ . '/../components/settings_helper.php';

// Auth Guard: Admin session must be active
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || !isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit;
}

$message = '';
$messageType = 'success';

// Handle Slide updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedSlides = [];
    
    // Read from POST arrays
    if (isset($_POST['slides']) && is_array($_POST['slides'])) {
        foreach ($_POST['slides'] as $index => $slideData) {
            // Basic fields validation
            $badge = trim($slideData['badge'] ?? 'New Slide');
            $title = trim($slideData['title'] ?? '');
            $image = trim($slideData['image'] ?? 'assets/images/hero_bg.jpg');
            
            // Handle uploaded image for this slide if present
            if (isset($_FILES['slide_image_files']['name'][$index]) && $_FILES['slide_image_files']['error'][$index] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['slide_image_files']['tmp_name'][$index];
                $fileName = $_FILES['slide_image_files']['name'][$index];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $uploadFileDir = '../assets/images/';
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0777, true);
                    }
                    $newFileName = 'hero_slide_uploaded_' . $index . '_' . time() . '.' . $fileExtension;
                    $dest_path = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $image = 'assets/images/' . $newFileName;
                    }
                }
            }
            
            $btn1_text = trim($slideData['btn1_text'] ?? '');
            $btn1_url = trim($slideData['btn1_url'] ?? '#contact');
            $btn2_text = trim($slideData['btn2_text'] ?? '');
            $btn2_url = trim($slideData['btn2_url'] ?? '#services');
            $visible = isset($slideData['visible']) ? 1 : 0;
            
            // Point 1
            $p1_icon = trim($slideData['p1_icon'] ?? 'fa-solid fa-rocket');
            $p1_title = trim($slideData['p1_title'] ?? '');
            $p1_desc = trim($slideData['p1_desc'] ?? '');

            // Point 2
            $p2_icon = trim($slideData['p2_icon'] ?? 'fa-solid fa-rocket');
            $p2_title = trim($slideData['p2_title'] ?? '');
            $p2_desc = trim($slideData['p2_desc'] ?? '');

            // Point 3
            $p3_icon = trim($slideData['p3_icon'] ?? 'fa-solid fa-rocket');
            $p3_title = trim($slideData['p3_title'] ?? '');
            $p3_desc = trim($slideData['p3_desc'] ?? '');

            $submittedSlides[] = [
                'badge' => $badge,
                'title' => $title,
                'image' => $image,
                'btn1_text' => $btn1_text,
                'btn1_url' => $btn1_url,
                'btn2_text' => $btn2_text,
                'btn2_url' => $btn2_url,
                'visible' => $visible,
                'p1_icon' => $p1_icon,
                'p1_title' => $p1_title,
                'p1_desc' => $p1_desc,
                'p2_icon' => $p2_icon,
                'p2_title' => $p2_title,
                'p2_desc' => $p2_desc,
                'p3_icon' => $p3_icon,
                'p3_title' => $p3_title,
                'p3_desc' => $p3_desc
            ];
        }
    }

    // Save back to settings table as JSON
    try {
        $jsonSlides = json_encode($submittedSlides);
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('homepage_hero_slides', :val) 
                               ON DUPLICATE KEY UPDATE setting_value = :val");
        $stmt->execute([':val' => $jsonSlides]);
        $message = "Homepage Carousel Slides updated successfully!";
        // Reload settings array
        $webSettings['homepage_hero_slides'] = $jsonSlides;
    } catch (PDOException $e) {
        $message = "Database Save Error: " . $e->getMessage();
        $messageType = 'error';
    }
}

// Fetch all slides (visible + hidden)
$json = getWebSetting('homepage_hero_slides');
$allSlides = json_decode($json, true);
if (!is_array($allSlides)) {
    $allSlides = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Slider Manager | Zenvora Admin</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind CSS -->
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
</head>
<body class="h-full font-sans antialiased text-slate-650 selection:bg-brand-500 selection:text-white">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation (Collapsible, w-64 -> w-0) -->
        <aside id="admin-sidebar" class="w-64 bg-slate-900 flex flex-col justify-between transition-all duration-300 ease-in-out flex-shrink-0 z-30 overflow-hidden relative border-r border-slate-850 p-6">
            <div class="flex flex-col flex-grow space-y-8">
                <!-- Branding -->
                <div class="flex items-center gap-3">
                    <img class="h-9 w-auto object-contain bg-white/5 p-1 rounded-lg" src="../<?php echo htmlspecialchars(getWebSetting('logo_url') ?: 'assets/images/logo/Zenvora_Global_Solutions_Logo.png'); ?>" alt="Logo">
                    <div>
                        <span class="text-xs font-black tracking-widest text-brand-400 block uppercase">Zenvora</span>
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Admin Control</span>
                    </div>
                </div>

                <!-- Nav list -->
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

            <!-- Footer Account logout -->
            <div class="border-t border-slate-800 pt-4 flex items-center justify-between flex-shrink-0">
                <div class="text-left overflow-hidden">
                    <span class="text-[10px] font-black text-slate-450 block uppercase">Logged in as</span>
                    <span class="text-[11px] font-bold text-slate-200 block truncate"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
                </div>
                <a href="logout.php" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-red-500/10 text-slate-400 hover:text-red-400 flex items-center justify-center transition-colors flex-shrink-0" title="Log Out Session">
                    <i class="fa-solid fa-power-off text-xs"></i>
                </a>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-grow flex flex-col min-w-0 bg-slate-50 overflow-hidden">
            
            <!-- Header bar with Sidebar Toggle & Logout -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button type="button" id="sidebar-toggle-btn" class="p-2.5 rounded-xl border border-slate-200 text-slate-650 hover:bg-slate-50 transition-colors flex items-center justify-center focus:outline-none">
                        <i class="fa-solid fa-bars-staggered text-sm"></i>
                    </button>
                    <span class="text-sm font-black text-slate-900 hidden sm:inline-block uppercase tracking-wider">Hero Slider Manager</span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-500/10 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold text-slate-700">CA Panel Live</span>
                    </div>
                    
                    <a href="logout.php" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-[10px] font-black text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </header>

            <!-- Scrollable Workspace Body -->
            <main class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-8">
                
                <!-- Welcome Title -->
                <div class="text-left space-y-1">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Hero Slider Manager</h1>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Manage, add, delete, and customize slides inside the homepage carousel dynamically</p>
                </div>

                <!-- Status Alert Notifications -->
                <?php if (!empty($message)): ?>
                    <div class="p-4 rounded-2xl border text-xs font-bold flex items-center gap-3 <?php echo ($messageType === 'success') ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-700' : 'bg-red-500/10 border-red-500/20 text-red-700'; ?>">
                        <i class="fa-solid <?php echo ($messageType === 'success') ? 'fa-circle-check' : 'fa-circle-exclamation'; ?> text-base"></i>
                        <span><?php echo htmlspecialchars($message); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Slide list manager Form -->
                <form method="POST" id="slides-form" enctype="multipart/form-data" class="space-y-6">
                
                <!-- Dynamic Container -->
                <div id="slides-container" class="space-y-6">
                    <?php 
                    $idx = 0;
                    foreach ($allSlides as $slide): 
                        $visible = isset($slide['visible']) && ($slide['visible'] == 1 || $slide['visible'] === true || $slide['visible'] === 'true');
                    ?>
                    <!-- Slide Panel -->
                    <div class="slide-card bg-white border border-slate-200 rounded-3xl p-6 relative transition-all hover:border-slate-350" data-idx="<?php echo $idx; ?>">
                        <!-- Close / Remove Slide button -->
                        <button type="button" class="btn-remove-slide absolute top-6 right-6 w-8 h-8 rounded-full border border-slate-200 hover:border-red-500 text-slate-400 hover:text-red-500 flex items-center justify-center transition-all bg-white z-10" title="Delete Slide">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                        </button>
 
                        <div class="relative">
                            <!-- Card Header Info (Collapsible Click Target) -->
                            <div class="flex items-center justify-between border-b border-slate-150 pb-4 pr-16 cursor-pointer select-none slide-header-toggle" title="Click to Expand/Collapse">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-xl bg-brand-500/10 text-brand-600 font-extrabold text-xs flex items-center justify-center">
                                        #<span class="slide-number-label"><?php echo $idx + 1; ?></span>
                                    </span>
                                    <div>
                                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2 flex-wrap sm:flex-nowrap">
                                            <span>Carousel Frame:</span>
                                            <span class="text-brand-600 slide-title-preview font-extrabold normal-case truncate max-w-[200px] sm:max-w-md"><?php echo htmlspecialchars($slide['badge'] . ' - ' . strip_tags($slide['title'])); ?></span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-slate-400">
                                    <span class="text-[9px] font-extrabold uppercase tracking-wider hidden sm:inline-block">Edit Slide</span>
                                    <i class="fa-solid fa-chevron-down transition-transform duration-300 toggle-arrow"></i>
                                </div>
                            </div>
 
                            <!-- Slide Content (Hidden by default) -->
                            <div class="slide-body-content space-y-6 pt-6 hidden">
 
                            <!-- Row 1: Badge, BG Image, Visibility -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-[10px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Category Badge Text</label>
                                    <input type="text" name="slides[<?php echo $idx; ?>][badge]" value="<?php echo htmlspecialchars($slide['badge']); ?>" required 
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 bg-slate-50 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Background Image Path</label>
                                    <input type="text" name="slides[<?php echo $idx; ?>][image]" value="<?php echo htmlspecialchars($slide['image']); ?>" required 
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 bg-slate-50 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Upload Slide Image</label>
                                    <input type="file" name="slide_image_files[<?php echo $idx; ?>]" accept="image/*"
                                           class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 bg-slate-50 focus:bg-white transition-all">
                                </div>
                                <div class="flex items-center pt-6">
                                    <label class="inline-flex items-center gap-2.5 cursor-pointer">
                                        <input type="checkbox" name="slides[<?php echo $idx; ?>][visible]" <?php echo $visible ? 'checked' : ''; ?> class="rounded text-brand-500 focus:ring-brand-500 w-4.5 h-4.5">
                                        <span class="text-xs font-bold text-slate-700">Slide is Active & Visible</span>
                                    </label>
                                </div>
                                
                                <?php if (!empty($slide['image'])): ?>
                                <div class="md:col-span-4 mt-2 p-2 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3">
                                    <img src="../<?php echo htmlspecialchars($slide['image']); ?>" class="w-20 h-10 object-cover rounded-lg border border-slate-200">
                                    <span class="text-[10px] text-slate-400 font-bold">Current Slide Image Preview</span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Row 2: Slide Title -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Main Heading (HTML supported)</label>
                                <textarea name="slides[<?php echo $idx; ?>][title]" rows="2" required 
                                          class="w-full text-xs font-bold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 bg-slate-50 focus:bg-white transition-all"><?php echo htmlspecialchars($slide['title']); ?></textarea>
                                <span class="text-[9px] text-slate-400 font-semibold mt-1 block">Tip: Use `&lt;br&gt;` for lines, and `&lt;span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400"&gt;Text&lt;/span&gt;` for gold accent text.</span>
                            </div>

                            <!-- Row 3: CTAs -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200/50">
                                <div class="md:col-span-4 border-b border-slate-200/60 pb-2">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Call-To-Action Actions</span>
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 mb-1.5">Button 1 Title</label>
                                    <input type="text" name="slides[<?php echo $idx; ?>][btn1_text]" value="<?php echo htmlspecialchars($slide['btn1_text']); ?>" 
                                           class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 bg-white rounded-lg focus:outline-none focus:border-brand-500">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 mb-1.5">Button 1 Link / Target</label>
                                    <input type="text" name="slides[<?php echo $idx; ?>][btn1_url]" value="<?php echo htmlspecialchars($slide['btn1_url']); ?>" 
                                           class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 bg-white rounded-lg focus:outline-none focus:border-brand-500">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 mb-1.5">Button 2 Title</label>
                                    <input type="text" name="slides[<?php echo $idx; ?>][btn2_text]" value="<?php echo htmlspecialchars($slide['btn2_text']); ?>" 
                                           class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 bg-white rounded-lg focus:outline-none focus:border-brand-500">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 mb-1.5">Button 2 Link / Target</label>
                                    <input type="text" name="slides[<?php echo $idx; ?>][btn2_url]" value="<?php echo htmlspecialchars($slide['btn2_url']); ?>" 
                                           class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 bg-white rounded-lg focus:outline-none focus:border-brand-500">
                                </div>
                            </div>

                            <!-- Row 4: 3 Advantages points columns -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                                
                                <!-- Point 1 fields -->
                                <div class="space-y-3 p-4 border border-slate-200 rounded-2xl">
                                    <span class="text-[9px] font-extrabold text-brand-600 uppercase tracking-wider block">Advantage Point #1</span>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">FA Icon Class</label>
                                        <input type="text" name="slides[<?php echo $idx; ?>][p1_icon]" value="<?php echo htmlspecialchars($slide['p1_icon']); ?>" 
                                               class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Point Title</label>
                                        <input type="text" name="slides[<?php echo $idx; ?>][p1_title]" value="<?php echo htmlspecialchars($slide['p1_title']); ?>" 
                                               class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Short Description</label>
                                        <textarea name="slides[<?php echo $idx; ?>][p1_desc]" rows="2" 
                                                  class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg"><?php echo htmlspecialchars($slide['p1_desc']); ?></textarea>
                                    </div>
                                </div>

                                <!-- Point 2 fields -->
                                <div class="space-y-3 p-4 border border-slate-200 rounded-2xl">
                                    <span class="text-[9px] font-extrabold text-brand-600 uppercase tracking-wider block">Advantage Point #2</span>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">FA Icon Class</label>
                                        <input type="text" name="slides[<?php echo $idx; ?>][p2_icon]" value="<?php echo htmlspecialchars($slide['p2_icon']); ?>" 
                                               class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Point Title</label>
                                        <input type="text" name="slides[<?php echo $idx; ?>][p2_title]" value="<?php echo htmlspecialchars($slide['p2_title']); ?>" 
                                               class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Short Description</label>
                                        <textarea name="slides[<?php echo $idx; ?>][p2_desc]" rows="2" 
                                                  class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg"><?php echo htmlspecialchars($slide['p2_desc']); ?></textarea>
                                    </div>
                                </div>

                                <!-- Point 3 fields -->
                                <div class="space-y-3 p-4 border border-slate-200 rounded-2xl">
                                    <span class="text-[9px] font-extrabold text-brand-600 uppercase tracking-wider block">Advantage Point #3</span>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">FA Icon Class</label>
                                        <input type="text" name="slides[<?php echo $idx; ?>][p3_icon]" value="<?php echo htmlspecialchars($slide['p3_icon']); ?>" 
                                               class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Point Title</label>
                                        <input type="text" name="slides[<?php echo $idx; ?>][p3_title]" value="<?php echo htmlspecialchars($slide['p3_title']); ?>" 
                                               class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Short Description</label>
                                        <textarea name="slides[<?php echo $idx; ?>][p3_desc]" rows="2" 
                                                  class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg"><?php echo htmlspecialchars($slide['p3_desc']); ?></textarea>
                                    </div>
                                </div>

                            </div> <!-- slide-body-content -->
                        </div> <!-- relative wrapper -->
                    </div> <!-- slide-card -->
                    <?php 
                        $idx++;
                    endforeach; 
                    ?>
                </div>

                <!-- Add & Save buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-200">
                    <button type="button" id="btn-add-slide" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full text-xs font-bold text-slate-800 bg-white border border-slate-200 hover:bg-slate-50 transition-all shadow-sm">
                        <i class="fa-solid fa-plus text-brand-500"></i> Add New Slide Frame
                    </button>

                    <button type="submit" class="w-full sm:w-auto inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-xs font-black text-white bg-slate-900 hover:bg-slate-800 transition-all">
                        <i class="fa-solid fa-circle-check text-brand-400"></i> Save Slides Configuration
                    </button>
                </div>

            </form>
        </main>
    </div>

    <!-- JavaScript to Handle Dynamic Row additions and removals -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('slides-container');
            const addBtn = document.getElementById('btn-add-slide');

            // Handle Slide Removals
            container.addEventListener('click', (e) => {
                const removeBtn = e.target.closest('.btn-remove-slide');
                if (removeBtn) {
                    const card = removeBtn.closest('.slide-card');
                    if (confirm('Are you sure you want to delete this slide? It will be removed permanently upon saving.')) {
                        card.remove();
                        reindexSlides();
                    }
                }
            });

            // Handle Slide Additions
            addBtn.addEventListener('click', () => {
                const nextIdx = container.querySelectorAll('.slide-card').length;
                const template = `
                <div class="slide-card bg-white border border-slate-200 rounded-3xl p-6 relative transition-all hover:border-slate-350" data-idx="${nextIdx}">
                    <button type="button" class="btn-remove-slide absolute top-6 right-6 w-8 h-8 rounded-full border border-slate-200 hover:border-red-500 text-slate-400 hover:text-red-500 flex items-center justify-center transition-all bg-white z-10" title="Delete Slide">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
 
                    <div class="relative">
                        <!-- Card Header Info (Collapsible Click Target) -->
                        <div class="flex items-center justify-between border-b border-slate-150 pb-4 pr-16 cursor-pointer select-none slide-header-toggle" title="Click to Expand/Collapse">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-xl bg-brand-500/10 text-brand-600 font-extrabold text-xs flex items-center justify-center">
                                    #<span class="slide-number-label">${nextIdx + 1}</span>
                                </span>
                                <div>
                                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2 flex-wrap sm:flex-nowrap">
                                        <span>Carousel Frame:</span>
                                        <span class="text-brand-600 slide-title-preview font-extrabold normal-case truncate max-w-[200px] sm:max-w-md">Business Setup - Launch Your Venture With Digital Ease.</span>
                                    </h3>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-slate-400">
                                <span class="text-[9px] font-extrabold uppercase tracking-wider hidden sm:inline-block">Edit Slide</span>
                                <i class="fa-solid fa-chevron-down transition-transform duration-300 toggle-arrow rotate-180"></i>
                            </div>
                        </div>
 
                        <!-- Slide Content (Expanded by default for new slides) -->
                        <div class="slide-body-content space-y-6 pt-6">
 
                            <!-- Row 1: Badge, BG Image, Visibility -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-[10px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Category Badge Text</label>
                                    <input type="text" name="slides[${nextIdx}][badge]" value="Business Setup" required 
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 bg-slate-50 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Background Image Path</label>
                                    <input type="text" name="slides[${nextIdx}][image]" value="assets/images/hero_bg.jpg" required 
                                           class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 bg-slate-50 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Upload Slide Image</label>
                                    <input type="file" name="slide_image_files[${nextIdx}]" accept="image/*"
                                           class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 bg-slate-50 focus:bg-white transition-all">
                                </div>
                                <div class="flex items-center pt-6">
                                    <label class="inline-flex items-center gap-2.5 cursor-pointer">
                                        <input type="checkbox" name="slides[${nextIdx}][visible]" checked class="rounded text-brand-500 focus:ring-brand-500 w-4.5 h-4.5">
                                        <span class="text-xs font-bold text-slate-700">Slide is Active & Visible</span>
                                    </label>
                                </div>
                            </div>
 
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Main Heading (HTML supported)</label>
                                <textarea name="slides[${nextIdx}][title]" rows="2" required 
                                          class="w-full text-xs font-bold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 bg-slate-50 focus:bg-white transition-all">Launch Your Venture &lt;br&gt; &lt;span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400"&gt;With Digital Ease.&lt;/span&gt;</textarea>
                            </div>
 
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200/50">
                                <div class="md:col-span-4 border-b border-slate-200/60 pb-2">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Call-To-Action Actions</span>
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 mb-1.5">Button 1 Title</label>
                                    <input type="text" name="slides[${nextIdx}][btn1_text]" value="Book Free Call" 
                                           class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 bg-white rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 mb-1.5">Button 1 Link</label>
                                    <input type="text" name="slides[${nextIdx}][btn1_url]" value="#contact" 
                                           class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 bg-white rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 mb-1.5">Button 2 Title</label>
                                    <input type="text" name="slides[${nextIdx}][btn2_text]" value="View Startup Packages" 
                                           class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 bg-white rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 mb-1.5">Button 2 Link</label>
                                    <input type="text" name="slides[${nextIdx}][btn2_url]" value="#services" 
                                           class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 bg-white rounded-lg">
                                </div>
                            </div>
 
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                                <div class="space-y-3 p-4 border border-slate-200 rounded-2xl">
                                    <span class="text-[9px] font-extrabold text-brand-600 uppercase tracking-wider block">Advantage Point #1</span>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">FA Icon Class</label>
                                        <input type="text" name="slides[${nextIdx}][p1_icon]" value="fa-solid fa-building" class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Point Title</label>
                                        <input type="text" name="slides[${nextIdx}][p1_title]" value="Pvt Ltd Incorporation" class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Short Description</label>
                                        <textarea name="slides[${nextIdx}][p1_desc]" rows="2" class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">Incorporated in 7 days.</textarea>
                                    </div>
                                </div>
 
                                <div class="space-y-3 p-4 border border-slate-200 rounded-2xl">
                                    <span class="text-[9px] font-extrabold text-brand-600 uppercase tracking-wider block">Advantage Point #2</span>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-450 mb-1">FA Icon Class</label>
                                        <input type="text" name="slides[${nextIdx}][p2_icon]" value="fa-solid fa-user-tie" class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Point Title</label>
                                        <input type="text" name="slides[${nextIdx}][p2_title]" value="OPC Setup" class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Short Description</label>
                                        <textarea name="slides[${nextIdx}][p2_desc]" rows="2" class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">Ideal for solo founders.</textarea>
                                    </div>
                                </div>
 
                                <div class="space-y-3 p-4 border border-slate-200 rounded-2xl">
                                    <span class="text-[9px] font-extrabold text-brand-600 uppercase tracking-wider block">Advantage Point #3</span>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">FA Icon Class</label>
                                        <input type="text" name="slides[${nextIdx}][p3_icon]" value="fa-solid fa-user-group" class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Point Title</label>
                                        <input type="text" name="slides[${nextIdx}][p3_title]" value="Partnerships" class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 mb-1">Short Description</label>
                                        <textarea name="slides[${nextIdx}][p3_desc]" rows="2" class="w-full text-[11px] font-bold px-3 py-2 border border-slate-200 rounded-lg">Partnerships done online.</textarea>
                                    </div>
                                </div>
                            </div>
 
                        </div>
                    </div>
                </div>`;
                
                const div = document.createElement('div');
                div.innerHTML = template.trim();
                container.appendChild(div.firstChild);
            });
 
            // Toggle slide card body
            container.addEventListener('click', (e) => {
                const header = e.target.closest('.slide-header-toggle');
                if (header) {
                    const card = header.closest('.slide-card');
                    const body = card.querySelector('.slide-body-content');
                    const arrow = card.querySelector('.toggle-arrow');
                    
                    body.classList.toggle('hidden');
                    arrow.classList.toggle('rotate-180');
                }
            });
 
            // Dynamic Title Preview Update
            container.addEventListener('input', (e) => {
                const input = e.target;
                const card = input.closest('.slide-card');
                if (card) {
                    const badgeInput = card.querySelector('[name$="[badge]"]');
                    const titleInput = card.querySelector('[name$="[title]"]');
                    const previewSpan = card.querySelector('.slide-title-preview');
                    if (previewSpan && badgeInput && titleInput) {
                        const cleanTitle = titleInput.value.replace(/<\/?[^>]+(>|$)/g, "");
                        previewSpan.textContent = badgeInput.value + ' - ' + cleanTitle;
                    }
                }
            });
 
            // Re-order index indices
            function reindexSlides() {
                const cards = container.querySelectorAll('.slide-card');
                cards.forEach((card, newIdx) => {
                    card.setAttribute('data-idx', newIdx);
                    card.querySelector('.slide-number-label').textContent = newIdx + 1;
 
                    // Update input names indices
                    card.querySelectorAll('[name^="slides["]').forEach(input => {
                        const nameAttr = input.getAttribute('name');
                        const updatedName = nameAttr.replace(/slides\[\d+\]/, `slides[${newIdx}]`);
                        input.setAttribute('name', updatedName);
                    });
                });
            // Sidebar Toggle
            const sidebar = document.getElementById('admin-sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('w-64');
                    sidebar.classList.toggle('w-0');
                });
            }
        });
    </script>
            </div> <!-- Main Workspace flex-grow wrapper -->
        </div> <!-- Outer h-screen flex wrapper -->
</body>
</html>
