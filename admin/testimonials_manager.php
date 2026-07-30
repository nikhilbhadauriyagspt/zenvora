<?php
/**
 * Zenvora Global Solutions - Testimonials Manager
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

// Handle save testimonials
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    try {
        $pdo->beginTransaction();
        
        $testimonialsList = [];
        if (isset($_POST['testimonial_names']) && is_array($_POST['testimonial_names'])) {
            for ($i = 0; $i < count($_POST['testimonial_names']); $i++) {
                $name = trim($_POST['testimonial_names'][$i]);
                $role = trim($_POST['testimonial_roles'][$i]);
                $review = trim($_POST['testimonial_reviews'][$i]);
                $rating = (int)($_POST['testimonial_ratings'][$i] ?? 5);
                $initials = trim($_POST['testimonial_initials'][$i]);
                
                if ($name !== '' && $review !== '') {
                    $testimonialsList[] = [
                        'initials' => $initials ?: substr($name, 0, 2),
                        'name' => $name,
                        'role' => $role,
                        'review' => $review,
                        'rating' => $rating
                    ];
                }
            }
        }
        
        // Update database
        $updateStmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('homepage_testimonials', :val) ON DUPLICATE KEY UPDATE setting_value = :val2");
        $updateStmt->execute([
            ':val' => json_encode($testimonialsList),
            ':val2' => json_encode($testimonialsList)
        ]);
        
        $pdo->commit();
        $successMsg = 'Testimonials updated successfully!';
    } catch (PDOException $e) {
        $pdo->rollBack();
        $errorMsg = 'Failed to save testimonials: ' . $e->getMessage();
    }
}

// Fetch Testimonials
$testimonials = [];
if ($pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'homepage_testimonials'");
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $testimonials = json_decode($row['setting_value'], true) ?? [];
        }
    } catch (PDOException $e) {
        // Fallback
    }
}
if (empty($testimonials)) {
    // Standard Fallbacks
    $testimonials = [
        [
            'initials' => 'AM',
            'name' => 'Aarav Mehta',
            'role' => 'Founder, Zephyr Logistics',
            'review' => 'Zenvora got our Private Limited incorporation and trade licenses sorted in exactly 8 days. Direct WhatsApp access to our assigned CA made the entire paperwork process completely effortless.',
            'rating' => 5
        ],
        [
            'initials' => 'NS',
            'name' => 'Neha Sharma',
            'role' => 'Co-Founder, Vedic Retail',
            'review' => 'We outsourced our monthly GST return filings and corporate accounting to Zenvora. Their fixed upfront billing and clean document management saved us from penalty surcharges entirely.',
            'rating' => 5
        ],
        [
            'initials' => 'VA',
            'name' => 'Vikram Aditya',
            'role' => 'Director, Dune Tech Solutions',
            'review' => 'Applied for our trademark registration and ISO certification through Zenvora. The process was 100% digital, and we received our TM application number code in under 24 hours.',
            'rating' => 5
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Testimonials | Zenvora Admin</title>
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
<body class="h-full font-sans antialiased text-slate-650 bg-slate-50 selection:bg-brand-500 selection:text-white">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside id="admin-sidebar" class="w-64 bg-slate-900 flex flex-col justify-between transition-all duration-350 ease-in-out flex-shrink-0 z-30 overflow-hidden relative border-r border-slate-850 p-6">
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
                    <a href="about_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-circle-info text-sm"></i> <span class="whitespace-nowrap">About Page Editor</span>
                    </a>
                    <a href="testimonials_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all bg-brand-500/10 text-brand-400 border border-brand-500/20">
                        <i class="fa-solid fa-star text-sm"></i> <span class="whitespace-nowrap">Testimonials</span>
                    </a>
                    <a href="blog_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
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
            
            <!-- Header bar -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button type="button" id="sidebar-toggle-btn" class="p-2.5 rounded-xl border border-slate-200 text-slate-650 hover:bg-slate-50 transition-colors flex items-center justify-center focus:outline-none">
                        <i class="fa-solid fa-bars-staggered text-sm"></i>
                    </button>
                    <span class="text-sm font-black text-slate-900 hidden sm:inline-block uppercase tracking-wider">Testimonials Manager</span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-500/10 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold text-slate-700">CA Panel Live</span>
                    </div>
                </div>
            </header>

            <!-- Scrollable workspace content -->
            <main class="flex-grow overflow-y-auto p-6 md:p-8 space-y-6">
                <!-- Welcome Title -->
                <div class="text-left space-y-1">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manage Testimonials</h1>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Configure client reviews appearing on the homepage "Trusted by Modern Founders" slider</p>
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

                <!-- Form -->
                <form action="" method="POST" class="space-y-6">
                    <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-3xl space-y-6 text-left">
                        <div class="border-b border-slate-150 pb-3 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-quote-left text-brand-500 text-sm"></i>
                                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider font-sans">Homepage Testimonial Sliders</h3>
                            </div>
                            <button type="button" onclick="addTestimonialRow()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-950 rounded-xl text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5 transition-colors">
                                <i class="fa-solid fa-plus text-[9px]"></i> Add Slide Card
                            </button>
                        </div>

                        <!-- Repeater Container -->
                        <div id="testimonials-container" class="space-y-6">
                            <?php foreach ($testimonials as $t): ?>
                            <div class="bg-slate-50/50 p-5 border border-slate-200 rounded-2xl relative space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Initials (2 chars)</label>
                                        <input type="text" name="testimonial_initials[]" value="<?php echo htmlspecialchars($t['initials'] ?? ''); ?>" required class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg">
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Client Full Name</label>
                                        <input type="text" name="testimonial_names[]" value="<?php echo htmlspecialchars($t['name'] ?? ''); ?>" required class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg">
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Designation / Role</label>
                                        <input type="text" name="testimonial_roles[]" value="<?php echo htmlspecialchars($t['role'] ?? ''); ?>" required class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Rating Stars</label>
                                        <select name="testimonial_ratings[]" class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg text-slate-700">
                                            <option value="5" <?php echo (($t['rating'] ?? 5) == 5) ? 'selected' : ''; ?>>5 Stars</option>
                                            <option value="4" <?php echo (($t['rating'] ?? 5) == 4) ? 'selected' : ''; ?>>4 Stars</option>
                                            <option value="3" <?php echo (($t['rating'] ?? 5) == 3) ? 'selected' : ''; ?>>3 Stars</option>
                                            <option value="2" <?php echo (($t['rating'] ?? 5) == 2) ? 'selected' : ''; ?>>2 Stars</option>
                                            <option value="1" <?php echo (($t['rating'] ?? 5) == 1) ? 'selected' : ''; ?>>1 Star</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Review Text Narrative</label>
                                    <textarea name="testimonial_reviews[]" rows="2" required class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg"><?php echo htmlspecialchars($t['review'] ?? ''); ?></textarea>
                                </div>
                                <button type="button" onclick="this.parentElement.remove()" class="py-1 px-3 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40 flex items-center gap-1">
                                    <i class="fa-solid fa-trash-can"></i> Delete Testimonial
                                </button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Submit Actions -->
                    <div class="flex items-center justify-end pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-4 rounded-full text-xs font-black text-white bg-slate-900 hover:bg-slate-800 transition-colors uppercase tracking-wider">
                            <i class="fa-solid fa-floppy-disk text-sm"></i> Save Testimonials Setup
                        </button>
                    </div>
                </form>
            </main>
        </div>
    </div>

    <!-- Script Helpers -->
    <script>
        // Sidebar Toggle logic
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

        // Helper to add testimonial rows
        function addTestimonialRow() {
            const container = document.getElementById('testimonials-container');
            const div = document.createElement('div');
            div.className = 'bg-slate-50/50 p-5 border border-slate-200 rounded-2xl relative space-y-4';
            div.innerHTML = `
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Initials (2 chars)</label>
                        <input type="text" name="testimonial_initials[]" placeholder="e.g. AM" required class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg">
                    </div>
                    <div class="sm:col-span-4">
                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Client Full Name</label>
                        <input type="text" name="testimonial_names[]" placeholder="Client Name" required class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg">
                    </div>
                    <div class="sm:col-span-4">
                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Designation / Role</label>
                        <input type="text" name="testimonial_roles[]" placeholder="Designation" required class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Rating Stars</label>
                        <select name="testimonial_ratings[]" class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg text-slate-700">
                            <option value="5" selected>5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[8px] font-extrabold uppercase text-slate-400 tracking-wider mb-1">Review Text Narrative</label>
                    <textarea name="testimonial_reviews[]" rows="2" placeholder="Write review details..." required class="w-full text-xs font-semibold px-3 py-2 bg-white border border-slate-200 rounded-lg"></textarea>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="py-1 px-3 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-[10px] font-bold transition-all border border-red-200/40 flex items-center gap-1">
                    <i class="fa-solid fa-trash-can"></i> Delete Testimonial
                </button>
            `;
            container.appendChild(div);
        }
    </script>
</body>
</html>
