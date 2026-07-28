<?php
/**
 * Zenvora Global Solutions - About Us Page Dynamic Content Manager
 */
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

// Handle settings updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    try {
        $pdo->beginTransaction();
        
        // 1. Handle General Settings updates
        $generalSettings = [
            'about_hero_title',
            'about_hero_subtitle',
            'about_purpose_badge',
            'about_purpose_title',
            'about_purpose_desc',
            'about_vision_icon',
            'about_vision_title',
            'about_vision_desc',
            'about_mission_icon',
            'about_mission_title',
            'about_mission_desc',
            'about_timeline_badge',
            'about_timeline_title',
            'about_timeline_desc',
            'about_accreditations_badge',
            'about_accreditations_title',
            'about_accreditations_desc',
            'about_tech_badge',
            'about_tech_title',
            'about_tech_desc',
            'about_values_badge',
            'about_values_title',
            'about_advisors_badge',
            'about_advisors_title',
            'about_cta_title',
            'about_cta_desc',
            'about_cta_btn_text',
            'about_cta_btn_url'
        ];
        
        $updateStmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :val) 
                                     ON DUPLICATE KEY UPDATE setting_value = :val");
        
        foreach ($generalSettings as $key) {
            if (isset($_POST[$key])) {
                $updateStmt->execute([
                    ':key' => $key,
                    ':val' => $_POST[$key]
                ]);
            }
        }
        
        // 2. Handle Purpose image upload
        if (isset($_FILES['purpose_image_file']) && $_FILES['purpose_image_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['purpose_image_file']['tmp_name'];
            $fileName = $_FILES['purpose_image_file']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $uploadFileDir = '../assets/images/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }
                $newFileName = 'about_purpose_' . time() . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $updateStmt->execute([
                        ':key' => 'about_purpose_image',
                        ':val' => 'assets/images/' . $newFileName
                    ]);
                }
            }
        }
        
        // 3. Compile and save Timeline milestones
        $timelineMilestones = [];
        if (isset($_POST['timeline_years']) && is_array($_POST['timeline_years'])) {
            for ($i = 0; $i < count($_POST['timeline_years']); $i++) {
                $timelineMilestones[] = [
                    'year' => trim($_POST['timeline_years'][$i] ?? ''),
                    'title' => trim($_POST['timeline_titles'][$i] ?? ''),
                    'desc' => trim($_POST['timeline_descs'][$i] ?? '')
                ];
            }
        }
        $updateStmt->execute([
            ':key' => 'about_timeline_milestones',
            ':val' => json_encode($timelineMilestones)
        ]);

        // 4. Compile and save Accreditations badges
        $accreditationsList = [];
        if (isset($_POST['accreditation_titles']) && is_array($_POST['accreditation_titles'])) {
            for ($i = 0; $i < count($_POST['accreditation_titles']); $i++) {
                $accreditationsList[] = [
                    'title' => trim($_POST['accreditation_titles'][$i] ?? ''),
                    'icon' => trim($_POST['accreditation_icons'][$i] ?? 'fa-solid fa-circle-check')
                ];
            }
        }
        $updateStmt->execute([
            ':key' => 'about_accreditations_badges',
            ':val' => json_encode($accreditationsList)
        ]);

        // 5. Compile and save Technology features
        $techFeaturesList = [];
        if (isset($_POST['tech_titles']) && is_array($_POST['tech_titles'])) {
            for ($i = 0; $i < count($_POST['tech_titles']); $i++) {
                $techFeaturesList[] = [
                    'title' => trim($_POST['tech_titles'][$i] ?? ''),
                    'desc' => trim($_POST['tech_descs'][$i] ?? ''),
                    'icon' => trim($_POST['tech_icons'][$i] ?? 'fa-solid fa-code')
                ];
            }
        }
        $updateStmt->execute([
            ':key' => 'about_tech_features',
            ':val' => json_encode($techFeaturesList)
        ]);

        // 6. Compile and save Core Values
        $valuesList = [];
        if (isset($_POST['value_titles']) && is_array($_POST['value_titles'])) {
            for ($i = 0; $i < count($_POST['value_titles']); $i++) {
                $valuesList[] = [
                    'title' => trim($_POST['value_titles'][$i] ?? ''),
                    'desc' => trim($_POST['value_descs'][$i] ?? ''),
                    'icon' => trim($_POST['value_icons'][$i] ?? 'fa-solid fa-heart')
                ];
            }
        }
        $updateStmt->execute([
            ':key' => 'about_values_list',
            ':val' => json_encode($valuesList)
        ]);

        // 7. Compile and save Advisors Panel
        $advisorsList = [];
        if (isset($_POST['advisor_names']) && is_array($_POST['advisor_names'])) {
            for ($i = 0; $i < count($_POST['advisor_names']); $i++) {
                $name = trim($_POST['advisor_names'][$i] ?? '');
                $role = trim($_POST['advisor_roles'][$i] ?? '');
                $desc = trim($_POST['advisor_descs'][$i] ?? '');
                $existingImage = trim($_POST['advisor_existing_images'][$i] ?? 'assets/images/about_us.jpg');
                
                $imagePath = $existingImage;
                
                if (isset($_FILES['advisor_image_files']['name'][$i]) && $_FILES['advisor_image_files']['error'][$i] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['advisor_image_files']['tmp_name'][$i];
                    $fileName = $_FILES['advisor_image_files']['name'][$i];
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
                    
                    if (in_array($fileExtension, $allowedExtensions)) {
                        $uploadFileDir = '../assets/images/';
                        if (!is_dir($uploadFileDir)) {
                            mkdir($uploadFileDir, 0777, true);
                        }
                        $newFileName = 'advisor_' . $i . '_' . time() . '.' . $fileExtension;
                        $dest_path = $uploadFileDir . $newFileName;
                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $imagePath = 'assets/images/' . $newFileName;
                        }
                    }
                }
                
                $advisorsList[] = [
                    'name' => $name,
                    'role' => $role,
                    'desc' => $desc,
                    'image' => $imagePath
                ];
            }
        }
        $updateStmt->execute([
            ':key' => 'about_advisors_list',
            ':val' => json_encode($advisorsList)
        ]);
        
        $pdo->commit();
        $message = "About Us Page configurations saved successfully!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Database Save Error: " . $e->getMessage();
        $messageType = 'error';
    }
}

// Reload current states from helpers
$timeline = json_decode(getWebSetting('about_timeline_milestones'), true) ?? [];
$accreditations = json_decode(getWebSetting('about_accreditations_badges'), true) ?? [];
$techFeatures = json_decode(getWebSetting('about_tech_features'), true) ?? [];
$values = json_decode(getWebSetting('about_values_list'), true) ?? [];
$advisors = json_decode(getWebSetting('about_advisors_list'), true) ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Page Editor | Zenvora Admin</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
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
        <!-- Sidebar Navigation -->
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
                    <a href="admin.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-chart-line text-sm"></i> <span class="whitespace-nowrap">Dashboard Overview</span>
                    </a>
                    <a href="enquiries.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-envelope-open-text text-sm"></i> <span class="whitespace-nowrap">Customer Enquiries</span>
                    </a>
                    
                    <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mt-6 mb-2 whitespace-nowrap">Website Settings</span>
                    <a href="settings.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-sliders text-sm"></i> <span class="whitespace-nowrap">General Configurations</span>
                    </a>
                    <a href="homepage.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-rectangle-ad text-sm"></i> <span class="whitespace-nowrap">Hero Slider Manager</span>
                    </a>
                    <a href="services_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-folder-open text-sm"></i> <span class="whitespace-nowrap">Services & Catalog</span>
                    </a>
                    <a href="about_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all bg-brand-500/10 text-brand-400 border border-brand-500/20">
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
                </nav>
            </div>

            <!-- Footer Account logout -->
            <div class="border-t border-slate-800 pt-4 flex items-center justify-between flex-shrink-0">
                <div class="text-left overflow-hidden">
                    <span class="text-[10px] font-black text-slate-455 block uppercase">Logged in as</span>
                    <span class="text-[11px] font-bold text-slate-200 block truncate"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
                </div>
                <a href="logout.php" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-red-500/10 text-slate-400 hover:text-red-400 flex items-center justify-center transition-colors flex-shrink-0" title="Log Out Session">
                    <i class="fa-solid fa-power-off text-xs"></i>
                </a>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-grow flex flex-col min-w-0 bg-slate-50 overflow-hidden">
            
            <!-- Header bar -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button type="button" id="sidebar-toggle-btn" class="p-2.5 rounded-xl border border-slate-200 text-slate-650 hover:bg-slate-50 transition-colors flex items-center justify-center focus:outline-none">
                        <i class="fa-solid fa-bars-staggered text-sm"></i>
                    </button>
                    <span class="text-sm font-black text-slate-900 hidden sm:inline-block uppercase tracking-wider">About Us Page Editor</span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-500/10 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold text-slate-700">CA Panel Live</span>
                    </div>
                    <a href="../about.php" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-full text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5 transition-colors">
                        <i class="fa-solid fa-eye text-[9px]"></i> Live Preview
                    </a>
                </div>
            </header>

            <!-- Scrollable workspace content -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 max-w-5xl w-full mx-auto space-y-6">
                
                <?php if ($message): ?>
                <div class="p-4 border rounded-2xl flex items-center gap-3 text-xs font-bold <?php echo ($messageType === 'success') ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-red-50 border-red-200 text-red-700'; ?>">
                    <i class="<?php echo ($messageType === 'success') ? 'fa-solid fa-circle-check' : 'fa-solid fa-triangle-exclamation'; ?> text-base"></i>
                    <span><?php echo htmlspecialchars($message); ?></span>
                </div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data" class="space-y-12 pb-16">
                    
                    <!-- Section 1: Hero Setup -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6">
                        <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-brand-500/15 text-brand-700 text-[10px] font-black flex items-center justify-center">1</span> 
                            Hero Section Configs
                        </h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Main Headline (HTML Supported)</label>
                                <textarea name="about_hero_title" rows="2" required class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all font-mono"><?php echo htmlspecialchars(getWebSetting('about_hero_title')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Sub-Headline (Brief Intro Text)</label>
                                <textarea name="about_hero_subtitle" rows="3" required class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all"><?php echo htmlspecialchars(getWebSetting('about_hero_subtitle')); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Purpose and Image Split -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6">
                        <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-brand-500/15 text-brand-700 text-[10px] font-black flex items-center justify-center">2</span> 
                            Corporate Story & Main Visual
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <div class="md:col-span-8 space-y-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Corporate Purpose Badge</label>
                                        <input type="text" name="about_purpose_badge" value="<?php echo htmlspecialchars(getWebSetting('about_purpose_badge')); ?>" required class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Section Headline Title</label>
                                        <input type="text" name="about_purpose_title" value="<?php echo htmlspecialchars(getWebSetting('about_purpose_title')); ?>" required class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all bg-white">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Description Narrative (The Story)</label>
                                    <textarea name="about_purpose_desc" rows="4" required class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-brand-500 transition-all"><?php echo htmlspecialchars(getWebSetting('about_purpose_desc')); ?></textarea>
                                </div>
                            </div>
                            <div class="md:col-span-4 flex flex-col justify-between border border-slate-200/80 p-4 rounded-2xl bg-slate-50 space-y-4">
                                <div>
                                    <span class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">Main Visual Image</span>
                                    <img src="../<?php echo htmlspecialchars(getWebSetting('about_purpose_image')); ?>" class="w-full aspect-[4/3] object-cover rounded-xl border border-slate-200">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1.5">Change Image File</label>
                                    <input type="file" name="purpose_image_file" accept="image/*" class="w-full text-[10px] bg-white border border-slate-200 rounded-lg p-1.5">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Vision & Mission Parameters -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6">
                        <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-brand-500/15 text-brand-700 text-[10px] font-black flex items-center justify-center">3</span> 
                            Vision & Mission Inclusions
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Vision Box -->
                            <div class="space-y-4 p-5 border border-slate-200/70 rounded-2xl bg-slate-50/50">
                                <h4 class="text-[10px] font-extrabold uppercase tracking-widest text-slate-900 border-b border-slate-200/60 pb-2"><i class="fa-solid fa-eye text-brand-500 mr-1.5"></i> Vision Coordinates</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                                        <input type="text" name="about_vision_icon" value="<?php echo htmlspecialchars(getWebSetting('about_vision_icon')); ?>" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Title</label>
                                        <input type="text" name="about_vision_title" value="<?php echo htmlspecialchars(getWebSetting('about_vision_title')); ?>" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Description Paragraph</label>
                                    <textarea name="about_vision_desc" rows="3" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white"><?php echo htmlspecialchars(getWebSetting('about_vision_desc')); ?></textarea>
                                </div>
                            </div>

                            <!-- Mission Box -->
                            <div class="space-y-4 p-5 border border-slate-200/70 rounded-2xl bg-slate-50/50">
                                <h4 class="text-[10px] font-extrabold uppercase tracking-widest text-slate-900 border-b border-slate-200/60 pb-2"><i class="fa-solid fa-compass text-brand-500 mr-1.5"></i> Mission Coordinates</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                                        <input type="text" name="about_mission_icon" value="<?php echo htmlspecialchars(getWebSetting('about_mission_icon')); ?>" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Title</label>
                                        <input type="text" name="about_mission_title" value="<?php echo htmlspecialchars(getWebSetting('about_mission_title')); ?>" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Description Paragraph</label>
                                    <textarea name="about_mission_desc" rows="3" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white"><?php echo htmlspecialchars(getWebSetting('about_mission_desc')); ?></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Section 4: Timeline Milestones Repeaters -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-500/15 text-brand-700 text-[10px] font-black flex items-center justify-center">4</span> 
                                Corporate Timeline Milestones
                            </h3>
                            <button type="button" onclick="addTimelineRow()" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[9px]"></i> Add Milestone
                            </button>
                        </div>
                        <div class="grid grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Timeline Section Badge</label>
                                <input type="text" name="about_timeline_badge" value="<?php echo htmlspecialchars(getWebSetting('about_timeline_badge')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Timeline Title</label>
                                <input type="text" name="about_timeline_title" value="<?php echo htmlspecialchars(getWebSetting('about_timeline_title')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Timeline Short Description</label>
                            <input type="text" name="about_timeline_desc" value="<?php echo htmlspecialchars(getWebSetting('about_timeline_desc')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                        </div>

                        <!-- Repeaters container -->
                        <div id="timeline-container" class="space-y-4 pt-3">
                            <?php foreach ($timeline as $m): ?>
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-slate-50 p-4 border border-slate-200/60 rounded-2xl relative group">
                                <div class="md:col-span-2">
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Milestone Year</label>
                                    <input type="text" name="timeline_years[]" value="<?php echo htmlspecialchars($m['year']); ?>" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Milestone Heading</label>
                                    <input type="text" name="timeline_titles[]" value="<?php echo htmlspecialchars($m['title']); ?>" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div class="md:col-span-6">
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Brief Narrative Details</label>
                                    <input type="text" name="timeline_descs[]" value="<?php echo htmlspecialchars($m['desc']); ?>" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div class="md:col-span-1 text-center">
                                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-500 text-red-500 hover:text-white flex items-center justify-center transition-colors text-xs border border-red-200/50 mt-4 md:mt-3">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Section 5: Accreditations (Banners of Credibility) -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-500/15 text-brand-700 text-[10px] font-black flex items-center justify-center">5</span> 
                                Accreditations & Badges
                            </h3>
                            <button type="button" onclick="addAccreditationRow()" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[9px]"></i> Add Accreditation
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Accreditations Section Badge</label>
                                <input type="text" name="about_accreditations_badge" value="<?php echo htmlspecialchars(getWebSetting('about_accreditations_badge')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Headline</label>
                                <input type="text" name="about_accreditations_title" value="<?php echo htmlspecialchars(getWebSetting('about_accreditations_title')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Short Description</label>
                            <input type="text" name="about_accreditations_desc" value="<?php echo htmlspecialchars(getWebSetting('about_accreditations_desc')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                        </div>

                        <!-- Repeaters container -->
                        <div id="accreditation-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-3">
                            <?php foreach ($accreditations as $acc): ?>
                            <div class="bg-slate-50 p-4 border border-slate-200/60 rounded-2xl relative group space-y-3">
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Accreditation Title</label>
                                    <input type="text" name="acreditation_titles[]" value="<?php echo htmlspecialchars($acc['title']); ?>" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                                    <input type="text" name="acreditation_icons[]" value="<?php echo htmlspecialchars($acc['icon']); ?>" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <button type="button" onclick="this.parentElement.remove()" class="w-full py-1 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Remove Badge
                                </button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Section 6: Tech Stack Bento Features -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-500/15 text-brand-700 text-[10px] font-black flex items-center justify-center">6</span> 
                                Technology Stack Features (3-Columns Grid)
                            </h3>
                            <button type="button" onclick="addTechFeatureRow()" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[9px]"></i> Add Feature Card
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Stack Section Badge</label>
                                <input type="text" name="about_tech_badge" value="<?php echo htmlspecialchars(getWebSetting('about_tech_badge')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Headline Title</label>
                                <input type="text" name="about_tech_title" value="<?php echo htmlspecialchars(getWebSetting('about_tech_title')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Subtitle</label>
                            <input type="text" name="about_tech_desc" value="<?php echo htmlspecialchars(getWebSetting('about_tech_desc')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                        </div>

                        <!-- Repeaters container -->
                        <div id="tech-features-container" class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-3">
                            <?php foreach ($techFeatures as $f): ?>
                            <div class="bg-slate-50 p-5 border border-slate-200/60 rounded-2xl relative group space-y-3">
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Feature Title</label>
                                    <input type="text" name="tech_titles[]" value="<?php echo htmlspecialchars($f['title']); ?>" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                                    <input type="text" name="tech_icons[]" value="<?php echo htmlspecialchars($f['icon']); ?>" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Short Description</label>
                                    <textarea name="tech_descs[]" rows="3" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white"><?php echo htmlspecialchars($f['desc']); ?></textarea>
                                </div>
                                <button type="button" onclick="this.parentElement.remove()" class="w-full py-1 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Remove Feature Card
                                </button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Section 7: Core Values Repeaters -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-500/15 text-brand-700 text-[10px] font-black flex items-center justify-center">7</span> 
                                Core Values Configuration
                            </h3>
                            <button type="button" onclick="addValueRow()" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[9px]"></i> Add Value
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Values Section Badge</label>
                                <input type="text" name="about_values_badge" value="<?php echo htmlspecialchars(getWebSetting('about_values_badge')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Headline Title</label>
                                <input type="text" name="about_values_title" value="<?php echo htmlspecialchars(getWebSetting('about_values_title')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                        </div>

                        <!-- Repeaters container -->
                        <div id="values-container" class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-3">
                            <?php foreach ($values as $val): ?>
                            <div class="bg-slate-50 p-5 border border-slate-200/60 rounded-2xl relative group space-y-3">
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Value Title</label>
                                    <input type="text" name="value_titles[]" value="<?php echo htmlspecialchars($val['title']); ?>" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                                    <input type="text" name="value_icons[]" value="<?php echo htmlspecialchars($val['icon']); ?>" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Description Paragraph</label>
                                    <textarea name="value_descs[]" rows="3" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white"><?php echo htmlspecialchars($val['desc']); ?></textarea>
                                </div>
                                <button type="button" onclick="this.parentElement.remove()" class="w-full py-1 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Remove Value
                                </button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Section 8: Advisors Repeaters (Include picture file upload!) -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-500/15 text-brand-700 text-[10px] font-black flex items-center justify-center">8</span> 
                                Corporate Advising Panel / Advisors
                            </h3>
                            <button type="button" onclick="addAdvisorRow()" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[9px]"></i> Add Advisor Card
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Advisors Panel Badge</label>
                                <input type="text" name="about_advisors_badge" value="<?php echo htmlspecialchars(getWebSetting('about_advisors_badge')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Headline</label>
                                <input type="text" name="about_advisors_title" value="<?php echo htmlspecialchars(getWebSetting('about_advisors_title')); ?>" required class="w-full text-xs font-semibold px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                        </div>

                        <!-- Repeaters container -->
                        <div id="advisors-container" class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-3">
                            <?php foreach ($advisors as $idx => $adv): ?>
                            <div class="bg-slate-50 p-5 border border-slate-200/60 rounded-2xl relative group space-y-3">
                                <div class="text-center relative">
                                    <img src="../<?php echo htmlspecialchars($adv['image']); ?>" class="w-24 h-24 rounded-full mx-auto object-cover border border-slate-200 bg-white">
                                    <input type="hidden" name="advisor_existing_images[]" value="<?php echo htmlspecialchars($adv['image']); ?>">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Change Advisor Photo</label>
                                    <input type="file" name="advisor_image_files[<?php echo $idx; ?>]" accept="image/*" class="w-full text-[10px] bg-white border border-slate-200 rounded-lg p-1.5">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Advisor Full Name</label>
                                    <input type="text" name="advisor_names[]" value="<?php echo htmlspecialchars($adv['name']); ?>" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Role / Designation</label>
                                    <input type="text" name="advisor_roles[]" value="<?php echo htmlspecialchars($adv['role']); ?>" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Bio / Profile Description</label>
                                    <textarea name="advisor_descs[]" rows="3" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white"><?php echo htmlspecialchars($adv['desc']); ?></textarea>
                                </div>
                                <button type="button" onclick="this.parentElement.remove()" class="w-full py-1 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Remove Advisor
                                </button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Section 9: CTA Configs -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6">
                        <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-brand-500/15 text-brand-700 text-[10px] font-black flex items-center justify-center">9</span> 
                            Call to Action Section Configurations
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">CTA Headline Title</label>
                                <input type="text" name="about_cta_title" value="<?php echo htmlspecialchars(getWebSetting('about_cta_title')); ?>" required class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl">
                            </div>
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">CTA Description Paragraph</label>
                                <input type="text" name="about_cta_desc" value="<?php echo htmlspecialchars(getWebSetting('about_cta_desc')); ?>" required class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">CTA Button text</label>
                                <input type="text" name="about_cta_btn_text" value="<?php echo htmlspecialchars(getWebSetting('about_cta_btn_text')); ?>" required class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl">
                            </div>
                            <div>
                                <label class="block text-[9px] font-extrabold uppercase text-slate-450 tracking-wider mb-2">CTA Button Target URL</label>
                                <input type="text" name="about_cta_btn_url" value="<?php echo htmlspecialchars(getWebSetting('about_cta_btn_url')); ?>" required class="w-full text-xs font-semibold px-4 py-3 border border-slate-200 rounded-xl">
                            </div>
                        </div>
                    </div>

                    <!-- Sticky Bottom Action Bar -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200/80">
                        <a href="about_manager.php" class="px-5 py-3 border border-slate-200 hover:border-slate-800 rounded-full text-xs font-bold text-slate-700 transition-all bg-white hover:bg-slate-50">Cancel Changes</a>
                        <button type="submit" class="px-7 py-3 rounded-full text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 transition-all shadow-lg hover:-translate-y-0.5">Save Changes</button>
                    </div>

                </form>

            </main>
        </div>
    </div>

    <!-- Dynamic Repeater Generation Javascript Script Helpers -->
    <script>
        // Sidebar collapse control
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        const sidebar = document.getElementById('admin-sidebar');
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-0');
                sidebar.classList.toggle('p-6');
                sidebar.classList.toggle('p-0');
            });
        }

        // 1. Add Timeline Milestone Card
        function addTimelineRow() {
            const container = document.getElementById('timeline-container');
            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-slate-50 p-4 border border-slate-200/60 rounded-2xl relative group';
            row.innerHTML = `
                <div class="md:col-span-2">
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Milestone Year</label>
                    <input type="text" name="timeline_years[]" value="2026" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Milestone Heading</label>
                    <input type="text" name="timeline_titles[]" placeholder="Heading Title" required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                </div>
                <div class="md:col-span-6">
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Brief Narrative Details</label>
                    <input type="text" name="timeline_descs[]" placeholder="Milestone description details..." required class="w-full text-[11px] font-semibold px-3 py-2 border border-slate-200 rounded-lg bg-white">
                </div>
                <div class="md:col-span-1 text-center">
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-500 text-red-500 hover:text-white flex items-center justify-center transition-colors text-xs border border-red-200/50 mt-4 md:mt-3">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            `;
            container.appendChild(row);
        }

        // 2. Add Accreditation Badge
        function addAccreditationRow() {
            const container = document.getElementById('accreditation-container');
            const idx = container.children.length;
            const card = document.createElement('div');
            card.className = 'bg-slate-50 p-4 border border-slate-200/60 rounded-2xl relative group space-y-3';
            card.innerHTML = `
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Accreditation Title</label>
                    <input type="text" name="acreditation_titles[]" placeholder="e.g. ISO 9001" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                    <input type="text" name="acreditation_icons[]" value="fa-solid fa-circle-check" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="w-full py-1 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40">
                    <i class="fa-solid fa-trash-can mr-1"></i> Remove Badge
                </button>
            `;
            container.appendChild(card);
        }

        // 3. Add Tech Feature Card
        function addTechFeatureRow() {
            const container = document.getElementById('tech-features-container');
            const card = document.createElement('div');
            card.className = 'bg-slate-50 p-5 border border-slate-200/60 rounded-2xl relative group space-y-3';
            card.innerHTML = `
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Feature Title</label>
                    <input type="text" name="tech_titles[]" placeholder="Title" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                    <input type="text" name="tech_icons[]" value="fa-solid fa-vault" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Short Description</label>
                    <textarea name="tech_descs[]" rows="3" placeholder="Brief feature info..." required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white"></textarea>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="w-full py-1 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40">
                    <i class="fa-solid fa-trash-can mr-1"></i> Remove Feature Card
                </button>
            `;
            container.appendChild(card);
        }

        // 4. Add Value Card
        function addValueRow() {
            const container = document.getElementById('values-container');
            const card = document.createElement('div');
            card.className = 'bg-slate-50 p-5 border border-slate-200/60 rounded-2xl relative group space-y-3';
            card.innerHTML = `
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Value Title</label>
                    <input type="text" name="value_titles[]" placeholder="Value Title" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">FA Icon Class</label>
                    <input type="text" name="value_icons[]" value="fa-solid fa-check" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Description Paragraph</label>
                    <textarea name="value_descs[]" rows="3" placeholder="Brief values description..." required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white"></textarea>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="w-full py-1 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40">
                    <i class="fa-solid fa-trash-can mr-1"></i> Remove Value
                </button>
            `;
            container.appendChild(card);
        }

        // 5. Add Advisor Card (Photo upload field named dynamically with index!)
        function addAdvisorRow() {
            const container = document.getElementById('advisors-container');
            const idx = container.children.length;
            const card = document.createElement('div');
            card.className = 'bg-slate-50 p-5 border border-slate-200/60 rounded-2xl relative group space-y-3';
            card.innerHTML = `
                <div class="text-center relative">
                    <img src="../assets/images/about_us.jpg" class="w-24 h-24 rounded-full mx-auto object-cover border border-slate-200 bg-white">
                    <input type="hidden" name="advisor_existing_images[]" value="assets/images/about_us.jpg">
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Upload Advisor Photo</label>
                    <input type="file" name="advisor_image_files[${idx}]" accept="image/*" class="w-full text-[10px] bg-white border border-slate-200 rounded-lg p-1.5">
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Advisor Full Name</label>
                    <input type="text" name="advisor_names[]" placeholder="Advisor Name" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Role / Designation</label>
                    <input type="text" name="advisor_roles[]" placeholder="Designation" required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white">
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Bio / Profile Description</label>
                    <textarea name="advisor_descs[]" rows="3" placeholder="Advisor brief bio..." required class="w-full text-[11px] font-semibold px-3 py-1.5 border border-slate-200 rounded-lg bg-white"></textarea>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="w-full py-1 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40">
                    <i class="fa-solid fa-trash-can mr-1"></i> Remove Advisor
                </button>
            `;
            container.appendChild(card);
        }
    </script>
</body>
</html>
