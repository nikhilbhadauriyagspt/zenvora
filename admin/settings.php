<?php
/**
 * Zenvora Global Solutions - Admin Settings Panel
 */
session_start();
require_once '../components/db_connect.php';

// 1. Session verification: Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || !isset($_SESSION['admin_username'])) {
    header('Location: login.php');
    exit;
}

$adminUsername = $_SESSION['admin_username'] ?? 'Admin';
$adminRole = $_SESSION['admin_role'] ?? 'admin';

$successMsg = '';
$errorMsg = '';

// 2. Form submission updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    try {
        $pdo->beginTransaction();
        
        // Handle logo file upload if provided
        if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['logo_file']['tmp_name'];
            $fileName = $_FILES['logo_file']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $uploadFileDir = '../assets/images/logo/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }
                $newFileName = 'uploaded_logo_' . time() . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $_POST['logo_url'] = 'assets/images/logo/' . $newFileName;
                }
            }
        }

        // Handle favicon file upload if provided
        if (isset($_FILES['favicon_file']) && $_FILES['favicon_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['favicon_file']['tmp_name'];
            $fileName = $_FILES['favicon_file']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $uploadFileDir = '../assets/images/logo/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }
                $newFileName = 'uploaded_favicon_' . time() . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $_POST['favicon'] = 'assets/images/logo/' . $newFileName;
                }
            }
        }

        // Handle standard settings
        $settingsToUpdate = [
            'logo_url',
            'favicon',
            'email_1',
            'email_2',
            'phone_1',
            'address_noida',
            'map_iframe',
            'working_hours',
            'whatsapp_number',
            'social_facebook',
            'social_twitter',
            'social_linkedin',
            'social_instagram',
            'social_youtube',
            'stat_ops_count',
            'stat_ops_label',
            'stat_accuracy_count',
            'stat_accuracy_label',
            'stat_panel_count',
            'stat_panel_label',
            'stat_speed_count',
            'stat_speed_label'
        ];
        
        $updateStmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :val) ON DUPLICATE KEY UPDATE setting_value = :val");
        
        foreach ($settingsToUpdate as $key) {
            if (isset($_POST[$key])) {
                $updateStmt->execute([
                    ':val' => trim($_POST[$key]),
                    ':key' => $key
                ]);
            }
        }
        
        // Handle Phone Numbers Array (Dynamic)
        $phonesList = [];
        if (isset($_POST['phone_labels']) && is_array($_POST['phone_labels'])) {
            for ($i = 0; $i < count($_POST['phone_labels']); $i++) {
                $label = trim($_POST['phone_labels'][$i]);
                $val = trim($_POST['phone_values'][$i]);
                if ($label !== '' && $val !== '') {
                    $visible = isset($_POST['phone_visibilities'][$i]) ? 1 : 0;
                    $phonesList[] = [
                        'label' => $label,
                        'value' => $val,
                        'visible' => $visible
                    ];
                }
            }
        }
        $updateStmt->execute([
            ':val' => json_encode($phonesList),
            ':key' => 'phone_numbers'
        ]);

        // Handle Office Addresses Array (Dynamic)
        $addressesList = [];
        if (isset($_POST['address_labels']) && is_array($_POST['address_labels'])) {
            for ($i = 0; $i < count($_POST['address_labels']); $i++) {
                $label = trim($_POST['address_labels'][$i]);
                $val = trim($_POST['address_values'][$i]);
                if ($label !== '' && $val !== '') {
                    $visible = isset($_POST['address_visibilities'][$i]) ? 1 : 0;
                    $addressesList[] = [
                        'label' => $label,
                        'value' => $val,
                        'visible' => $visible
                    ];
                }
            }
        }
        $updateStmt->execute([
            ':val' => json_encode($addressesList),
            ':key' => 'office_addresses'
        ]);
        
        $pdo->commit();
        $successMsg = 'Website settings updated successfully!';
    } catch (PDOException $e) {
        $pdo->rollBack();
        $errorMsg = 'Failed to save configurations: ' . $e->getMessage();
    }
}

// 3. Fetch Settings for form values
$webSettings = [];
if ($pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM settings");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $webSettings[$row['setting_key']] = $row['setting_value'];
        }
    } catch (PDOException $e) {
        // Fallback
    }
}

// Decode lists or default to empty arrays
$phones = json_decode($webSettings['phone_numbers'] ?? '[]', true);
$addresses = json_decode($webSettings['office_addresses'] ?? '[]', true);
$testimonials = json_decode($webSettings['homepage_testimonials'] ?? '[]', true);
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Settings | Zenvora Global Solutions</title>
    
    <!-- Load Head dependencies (Tailwind CDN, Fonts, Font Awesome) -->
    <?php include_once '../components/head.php'; ?>
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
                <!-- Toggle Button -->
                <div class="flex items-center gap-4">
                    <button type="button" id="sidebar-toggle-btn" class="p-2.5 rounded-xl border border-slate-200 text-slate-650 hover:bg-slate-50 transition-colors flex items-center justify-center focus:outline-none">
                        <i class="fa-solid fa-bars-staggered text-sm"></i>
                    </button>
                    <span class="text-sm font-black text-slate-900 hidden sm:inline-block uppercase tracking-wider">Compliance Settings Desk</span>
                </div>

                <!-- Admin Action items -->
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
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Website Settings</h1>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Customize brand logo, contact directories, addresses, and maps dynamically</p>
                </div>

                <!-- Feedback Alerts -->
                <?php if (!empty($successMsg)): ?>
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs p-4 rounded-xl flex items-center gap-3 text-left font-semibold">
                        <i class="fa-solid fa-circle-check text-base flex-shrink-0 text-emerald-600"></i>
                        <span><?php echo htmlspecialchars($successMsg); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errorMsg)): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 text-xs p-4 rounded-xl flex items-center gap-3 text-left font-semibold">
                        <i class="fa-solid fa-circle-exclamation text-base flex-shrink-0 text-red-600"></i>
                        <span><?php echo htmlspecialchars($errorMsg); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Settings Form -->
                <form action="settings.php" method="POST" enctype="multipart/form-data" class="space-y-8">
                    
                    <!-- Section 1: Logo & Branding -->
                    <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-3xl space-y-6 text-left">
                        <div class="border-b border-slate-150 pb-3 flex items-center gap-2.5">
                            <i class="fa-solid fa-image text-brand-500 text-sm"></i>
                            <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Branding & Identity</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Logo URL & Upload -->
                            <div class="space-y-4">
                                <div class="space-y-1.5">
                                    <label for="logo_url" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Corporate Logo File Path / URL</label>
                                    <input type="text" id="logo_url" name="logo_url" required 
                                           value="<?php echo htmlspecialchars($webSettings['logo_url'] ?? ''); ?>"
                                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Upload New Logo</label>
                                    <input type="file" name="logo_file" accept="image/*"
                                           class="w-full text-xs font-semibold px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-all">
                                </div>
                                <?php if (!empty($webSettings['logo_url'])): ?>
                                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                    <span class="text-[9px] font-black uppercase text-slate-400 block mb-2">Current Logo Preview</span>
                                    <img src="../<?php echo htmlspecialchars($webSettings['logo_url']); ?>" alt="Logo Preview" class="h-12 w-auto object-contain bg-slate-800 p-2 rounded-lg">
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Favicon URL & Upload -->
                            <div class="space-y-4">
                                <div class="space-y-1.5">
                                    <label for="favicon" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Favicon File Path / URL</label>
                                    <input type="text" id="favicon" name="favicon" required 
                                           value="<?php echo htmlspecialchars($webSettings['favicon'] ?? ''); ?>"
                                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Upload New Favicon</label>
                                    <input type="file" name="favicon_file" accept="image/*"
                                           class="w-full text-xs font-semibold px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-all">
                                </div>
                                <?php if (!empty($webSettings['favicon'])): ?>
                                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                    <span class="text-[9px] font-black uppercase text-slate-400 block mb-2">Current Favicon Preview</span>
                                    <img src="../<?php echo htmlspecialchars($webSettings['favicon']); ?>" alt="Favicon Preview" class="h-8 w-8 object-contain bg-slate-800 p-1 rounded-lg">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: DYNAMIC Phone Numbers Directory -->
                    <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-3xl space-y-6 text-left">
                        <div class="flex items-center justify-between border-b border-slate-150 pb-3 flex-wrap gap-4">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-phone text-brand-500 text-sm"></i>
                                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Dynamic Helplines Directory</h3>
                            </div>
                            <!-- Add dynamic helpline button -->
                            <button type="button" onclick="addNewPhoneRow()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-[10px] font-black uppercase tracking-wider transition-colors">
                                <i class="fa-solid fa-plus mr-1"></i> Add New Phone Number
                            </button>
                        </div>
                        
                        <!-- List container -->
                        <div class="space-y-4" id="phones-container">
                            <!-- Dynamic rows will be inserted here -->
                        </div>
                    </div>

                    <!-- Section 3: DYNAMIC Office Addresses Directory -->
                    <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-3xl space-y-6 text-left">
                        <div class="flex items-center justify-between border-b border-slate-150 pb-3 flex-wrap gap-4">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-location-dot text-brand-500 text-sm"></i>
                                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Dynamic Office Addresses Directory</h3>
                            </div>
                            <!-- Add dynamic address button -->
                            <button type="button" onclick="addNewAddressRow()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-[10px] font-black uppercase tracking-wider transition-colors">
                                <i class="fa-solid fa-plus mr-1"></i> Add New Office Address
                            </button>
                        </div>
                        
                        <!-- List container -->
                        <div class="space-y-4" id="addresses-container">
                            <!-- Dynamic rows will be inserted here -->
                        </div>
                    </div>

                    <!-- Section 4: Email, Primary Contacts, Maps & Timings -->
                    <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-3xl space-y-6 text-left">
                        <div class="border-b border-slate-150 pb-3 flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-brand-500 text-sm"></i>
                            <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Primary Helplines, Timings & Maps</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Email 1 -->
                            <div class="space-y-1.5">
                                <label for="email_1" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Contact Email 1 (Support Desk)</label>
                                <input type="email" id="email_1" name="email_1" required 
                                       value="<?php echo htmlspecialchars($webSettings['email_1'] ?? ''); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>

                            <!-- Email 2 -->
                            <div class="space-y-1.5">
                                <label for="email_2" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Contact Email 2 (General Enquiries)</label>
                                <input type="email" id="email_2" name="email_2" required 
                                       value="<?php echo htmlspecialchars($webSettings['email_2'] ?? ''); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Phone 1 (Primary Helpline) -->
                            <div class="space-y-1.5">
                                <label for="phone_1" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Primary Call Helpline (phone_1)</label>
                                <input type="text" id="phone_1" name="phone_1" required 
                                       value="<?php echo htmlspecialchars($webSettings['phone_1'] ?? ''); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>

                            <!-- Noida Head Office Address -->
                            <div class="space-y-1.5">
                                <label for="address_noida" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Noida Head Office Address (address_noida)</label>
                                <textarea id="address_noida" name="address_noida" rows="2" required 
                                          class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all resize-none"><?php echo htmlspecialchars($webSettings['address_noida'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                            <!-- Support Timings -->
                            <div class="space-y-1.5">
                                <label for="working_hours" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Business Working Hours</label>
                                <input type="text" id="working_hours" name="working_hours" required 
                                       value="<?php echo htmlspecialchars($webSettings['working_hours'] ?? ''); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>

                            <!-- WhatsApp number -->
                            <div class="space-y-1.5">
                                <label for="whatsapp_number" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">WhatsApp Support Number</label>
                                <input type="text" id="whatsapp_number" name="whatsapp_number" required 
                                       value="<?php echo htmlspecialchars($webSettings['whatsapp_number'] ?? ''); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>

                            <!-- Map Iframe Link -->
                            <div class="space-y-1.5">
                                <label for="map_iframe" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Google Map Embed src URL</label>
                                <input type="text" id="map_iframe" name="map_iframe" required 
                                       value="<?php echo htmlspecialchars($webSettings['map_iframe'] ?? ''); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Social Media Links -->
                    <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-3xl space-y-6 text-left">
                        <div class="border-b border-slate-150 pb-3 flex items-center gap-2.5">
                            <i class="fa-solid fa-share-nodes text-brand-500 text-sm"></i>
                            <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Social Media Channels</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <!-- Facebook -->
                            <div class="space-y-1.5">
                                <label for="social_facebook" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Facebook URL</label>
                                <input type="text" id="social_facebook" name="social_facebook" required 
                                       value="<?php echo htmlspecialchars($webSettings['social_facebook'] ?? '#'); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>

                            <!-- Twitter -->
                            <div class="space-y-1.5">
                                <label for="social_twitter" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Twitter / X URL</label>
                                <input type="text" id="social_twitter" name="social_twitter" required 
                                       value="<?php echo htmlspecialchars($webSettings['social_twitter'] ?? '#'); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>

                            <!-- LinkedIn -->
                            <div class="space-y-1.5">
                                <label for="social_linkedin" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">LinkedIn URL</label>
                                <input type="text" id="social_linkedin" name="social_linkedin" required 
                                       value="<?php echo htmlspecialchars($webSettings['social_linkedin'] ?? '#'); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>

                            <!-- Instagram -->
                            <div class="space-y-1.5">
                                <label for="social_instagram" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Instagram URL</label>
                                <input type="text" id="social_instagram" name="social_instagram" required 
                                       value="<?php echo htmlspecialchars($webSettings['social_instagram'] ?? '#'); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>

                            <!-- YouTube -->
                            <div class="space-y-1.5">
                                <label for="social_youtube" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">YouTube URL</label>
                                <input type="text" id="social_youtube" name="social_youtube" required 
                                       value="<?php echo htmlspecialchars($webSettings['social_youtube'] ?? '#'); ?>"
                                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:bg-white focus:outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Trust Statistics Metrics -->
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 space-y-6">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                            <i class="fa-solid fa-chart-simple text-brand-500 text-sm"></i>
                            <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Dynamic Trust Statistics</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Operations count / Label -->
                            <div class="space-y-4 p-4 border border-slate-200/60 rounded-xl bg-slate-50/40">
                                <h4 class="text-[10px] font-black uppercase text-slate-900 tracking-wider"><i class="fa-solid fa-chart-simple text-brand-500 mr-1.5"></i> Metric 1: Scale of Operations</h4>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-1 space-y-1.5">
                                        <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Value</label>
                                        <input type="text" name="stat_ops_count" value="<?php echo htmlspecialchars($webSettings['stat_ops_count'] ?? '1,200+'); ?>" required class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div class="col-span-2 space-y-1.5">
                                        <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Description Label</label>
                                        <input type="text" name="stat_ops_label" value="<?php echo htmlspecialchars($webSettings['stat_ops_label'] ?? ''); ?>" required class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                </div>
                            </div>

                            <!-- Accuracy count / Label -->
                            <div class="space-y-4 p-4 border border-slate-200/60 rounded-xl bg-slate-50/40">
                                <h4 class="text-[10px] font-black uppercase text-slate-900 tracking-wider"><i class="fa-solid fa-circle-check text-brand-500 mr-1.5"></i> Metric 2: Accuracy SLA</h4>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-1 space-y-1.5">
                                        <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Value</label>
                                        <input type="text" name="stat_accuracy_count" value="<?php echo htmlspecialchars($webSettings['stat_accuracy_count'] ?? '99.8%'); ?>" required class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div class="col-span-2 space-y-1.5">
                                        <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Description Label</label>
                                        <input type="text" name="stat_accuracy_label" value="<?php echo htmlspecialchars($webSettings['stat_accuracy_label'] ?? ''); ?>" required class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                </div>
                            </div>

                            <!-- Panel count / Label -->
                            <div class="space-y-4 p-4 border border-slate-200/60 rounded-xl bg-slate-50/40">
                                <h4 class="text-[10px] font-black uppercase text-slate-900 tracking-wider"><i class="fa-solid fa-user-tie text-brand-500 mr-1.5"></i> Metric 3: Expert Panel Size</h4>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-1 space-y-1.5">
                                        <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Value</label>
                                        <input type="text" name="stat_panel_count" value="<?php echo htmlspecialchars($webSettings['stat_panel_count'] ?? '45+'); ?>" required class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div class="col-span-2 space-y-1.5">
                                        <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Description Label</label>
                                        <input type="text" name="stat_panel_label" value="<?php echo htmlspecialchars($webSettings['stat_panel_label'] ?? ''); ?>" required class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                </div>
                            </div>

                            <!-- Speed count / Label -->
                            <div class="space-y-4 p-4 border border-slate-200/60 rounded-xl bg-slate-50/40">
                                <h4 class="text-[10px] font-black uppercase text-slate-900 tracking-wider"><i class="fa-solid fa-bolt text-brand-500 mr-1.5"></i> Metric 4: Turnaround Speed</h4>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-1 space-y-1.5">
                                        <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Value</label>
                                        <input type="text" name="stat_speed_count" value="<?php echo htmlspecialchars($webSettings['stat_speed_count'] ?? '24 Hours'); ?>" required class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                    <div class="col-span-2 space-y-1.5">
                                        <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Description Label</label>
                                        <input type="text" name="stat_speed_label" value="<?php echo htmlspecialchars($webSettings['stat_speed_label'] ?? ''); ?>" required class="w-full text-xs font-semibold px-4 py-2 border border-slate-200 rounded-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Submit Actions -->
                    <div class="flex items-center justify-end pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-4 rounded-full text-xs font-black text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                            <i class="fa-solid fa-floppy-disk text-sm"></i> Save Website Settings
                        </button>
                    </div>

                </form>

            </main>

        </div>

    </div>

    <!-- Sidebar toggle & Dynamic Form scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Toggle
            const sidebar = document.getElementById('admin-sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-0');
            });

            // Load Existing Dynamic Phones
            <?php foreach ($phones as $p): ?>
                addNewPhoneRow(
                    "<?php echo htmlspecialchars($p['label']); ?>",
                    "<?php echo htmlspecialchars($p['value']); ?>",
                    <?php echo (int)($p['visible'] ?? 1); ?>
                );
            <?php endforeach; ?>
            
            // Load Existing Dynamic Addresses
            <?php foreach ($addresses as $a): ?>
                addNewAddressRow(
                    "<?php echo htmlspecialchars($a['label']); ?>",
                    "<?php echo htmlspecialchars($a['value']); ?>",
                    <?php echo (int)($a['visible'] ?? 1); ?>
                );
            <?php endforeach; ?>
        });

        // Add New Dynamic Phone Input Row
        let phoneIndex = 0;
        function addNewPhoneRow(label = '', value = '', visible = 1) {
            const container = document.getElementById('phones-container');
            const rowId = 'phone-row-' + phoneIndex;
            
            const div = document.createElement('div');
            div.id = rowId;
            div.className = 'grid grid-cols-1 sm:grid-cols-12 gap-4 items-center bg-slate-50 p-4 border border-slate-200 rounded-xl text-xs font-semibold relative';
            
            div.innerHTML = `
                <!-- Label field (col-span-3) -->
                <div class="sm:col-span-3 space-y-1">
                    <label class="text-[9px] font-black uppercase text-slate-400 block">Phone Label</label>
                    <input type="text" name="phone_labels[]" value="${label}" required placeholder="e.g. Hotline, Office Desk" 
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:outline-none focus:border-brand-500">
                </div>
                
                <!-- Value field (col-span-4) -->
                <div class="sm:col-span-4 space-y-1">
                    <label class="text-[9px] font-black uppercase text-slate-400 block">Phone Number</label>
                    <input type="text" name="phone_values[]" value="${value}" required placeholder="e.g. +91 98765 43210" 
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:outline-none focus:border-brand-500">
                </div>

                <!-- Visibility switch (col-span-3) -->
                <div class="sm:col-span-3 flex items-center justify-start gap-2 pt-4 sm:pt-0 pl-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="phone_visibilities[${phoneIndex}]" value="1" ${visible == 1 ? 'checked' : ''} 
                               class="rounded border-slate-200 text-brand-500 focus:ring-brand-500 w-4 h-4">
                        <span class="text-xs text-slate-700 font-bold">Show on Frontend</span>
                    </label>
                </div>

                <!-- Delete button (col-span-2) -->
                <div class="sm:col-span-2 flex justify-end pt-2 sm:pt-0">
                    <button type="button" onclick="removeRow('${rowId}')" class="px-3 py-2 border border-red-200 text-red-500 hover:bg-red-50 rounded-lg transition-colors flex items-center justify-center gap-1.5 w-full sm:w-auto">
                        <i class="fa-solid fa-trash"></i> Remove
                    </button>
                </div>
            `;
            
            // Adjust visibilities checkbox naming convention on submit
            const form = container.closest('form');
            form.addEventListener('submit', () => {
                const checkbox = div.querySelector('input[type="checkbox"]');
                checkbox.name = `phone_visibilities[${Array.from(container.children).indexOf(div)}]`;
            });
            
            container.appendChild(div);
            phoneIndex++;
        }

        // Add New Dynamic Address Input Row
        let addressIndex = 0;
        function addNewAddressRow(label = '', value = '', visible = 1) {
            const container = document.getElementById('addresses-container');
            const rowId = 'address-row-' + addressIndex;
            
            const div = document.createElement('div');
            div.id = rowId;
            div.className = 'grid grid-cols-1 sm:grid-cols-12 gap-4 items-start bg-slate-50 p-4 border border-slate-200 rounded-xl text-xs font-semibold relative';
            
            div.innerHTML = `
                <!-- Label field (col-span-3) -->
                <div class="sm:col-span-3 space-y-1">
                    <label class="text-[9px] font-black uppercase text-slate-400 block">Office Location Name</label>
                    <input type="text" name="address_labels[]" value="${label}" required placeholder="e.g. Pune Desk, Mumbai HQ" 
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:outline-none focus:border-brand-500">
                </div>
                
                <!-- Value field (col-span-5) -->
                <div class="sm:col-span-5 space-y-1">
                    <label class="text-[9px] font-black uppercase text-slate-400 block">Full Office Address Coordinates</label>
                    <textarea name="address_values[]" rows="2" required placeholder="Paste full office address..." 
                              class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:outline-none focus:border-brand-500 resize-none">${value}</textarea>
                </div>

                <!-- Visibility switch (col-span-2) -->
                <div class="sm:col-span-2 flex items-center justify-start gap-2 pt-4 sm:pt-0 pl-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="address_visibilities[${addressIndex}]" value="1" ${visible == 1 ? 'checked' : ''} 
                               class="rounded border-slate-200 text-brand-500 focus:ring-brand-500 w-4 h-4">
                        <span class="text-xs text-slate-700 font-bold">Show on Frontend</span>
                    </label>
                </div>

                <!-- Delete button (col-span-2) -->
                <div class="sm:col-span-2 flex justify-end pt-2 sm:pt-0">
                    <button type="button" onclick="removeRow('${rowId}')" class="px-3 py-2 border border-red-200 text-red-500 hover:bg-red-50 rounded-lg transition-colors flex items-center justify-center gap-1.5 w-full sm:w-auto">
                        <i class="fa-solid fa-trash"></i> Remove
                    </button>
                </div>
            `;
            
            // Adjust visibilities checkbox naming convention on submit
            const form = container.closest('form');
            form.addEventListener('submit', () => {
                const checkbox = div.querySelector('input[type="checkbox"]');
                checkbox.name = `address_visibilities[${Array.from(container.children).indexOf(div)}]`;
            });
            
            container.appendChild(div);
            addressIndex++;
        }

        // Helper to remove dynamic rows
        function removeRow(rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                row.remove();
            }
        }

    </script>

</body>

</html>
