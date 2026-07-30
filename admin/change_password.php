<?php
/**
 * Zenvora Global Solutions - Admin Password Manager
 */
session_start();
require_once __DIR__ . '/../components/db_connect.php';

// Auth Guard: Admin session must be active
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || !isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit;
}

$adminUsername = $_SESSION['admin_username'] ?? 'admin';
$successMsg = '';
$errorMsg = '';

// Handle Password Update Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $errorMsg = 'All password fields are required.';
    } elseif ($newPassword !== $confirmPassword) {
        $errorMsg = 'New Password and Confirm Password do not match.';
    } elseif (strlen($newPassword) < 6) {
        $errorMsg = 'New password must be at least 6 characters long.';
    } else {
        try {
            // Verify current password first
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->execute([':username' => $adminUsername]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($currentPassword, $user['password'])) {
                // Update with new hashed password
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
                $updateStmt->execute([
                    ':password' => $newHashedPassword,
                    ':id' => $user['id']
                ]);
                $successMsg = 'Admin password has been changed successfully!';
            } else {
                $errorMsg = 'Incorrect current password.';
            }
        } catch (PDOException $e) {
            $errorMsg = 'Database update failed: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Zenvora Admin Console</title>
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
                <a href="seo_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-search text-sm"></i> <span>Page SEO Settings</span>
                </a>
                
                <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mt-6 mb-2 flex items-center gap-1.5"><i class="fa-solid fa-user-shield text-[9px]"></i> Account</span>
                <a href="change_password.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all bg-brand-500/10 text-brand-400 border border-brand-500/20">
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
    <div class="flex-grow flex flex-col min-w-0 overflow-hidden bg-slate-900">
        <!-- Header Bar -->
        <?php include_once 'admin_header.php'; ?>
        
        <!-- Scrollable Workspace Body -->
        <main class="flex-grow overflow-y-auto p-8 sm:p-12">
            <div class="max-w-4xl mx-auto space-y-10 text-left">
            
            <!-- Dashboard Top Meta -->
            <div class="flex items-center justify-between border-b border-slate-800 pb-6">
                <div>
                    <h1 class="text-2xl font-black text-white">Console Security Desk</h1>
                    <p class="text-xs text-slate-400 font-semibold mt-1">Change your administrator login credential key.</p>
                </div>
                <div class="text-right text-[11px] text-slate-500 font-semibold">
                    <span>Account: </span>
                    <span class="text-brand-400"><?php echo htmlspecialchars($adminUsername); ?></span>
                </div>
            </div>

            <!-- Messages Alert -->
            <?php if ($successMsg): ?>
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo htmlspecialchars($successMsg); ?></span>
                </div>
            <?php endif; ?>
            <?php if ($errorMsg): ?>
                <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?php echo htmlspecialchars($errorMsg); ?></span>
                </div>
            <?php endif; ?>

            <!-- Split Form Panel -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Form -->
                <div class="md:col-span-7 bg-slate-950 border border-slate-800 rounded-3xl p-6 space-y-6">
                    <h3 class="text-sm font-extrabold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-lock text-brand-400"></i> Update Password
                    </h3>
                    
                    <form action="change_password.php" method="POST" class="space-y-4">
                        
                        <!-- Current Password -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Current Password *</label>
                            <input type="password" name="current_password" required placeholder="••••••••" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <!-- New Password -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">New Password * (Min 6 chars)</label>
                            <input type="password" name="new_password" required placeholder="••••••••" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Confirm New Password *</label>
                            <input type="password" name="confirm_password" required placeholder="••••••••" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-3 rounded-xl text-xs font-black text-slate-950 bg-brand-500 hover:bg-brand-400 transition-colors uppercase tracking-wider">
                                Save Password Change
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right: Guidelines info -->
                <div class="md:col-span-5 bg-slate-950 border border-slate-800 rounded-3xl p-6 space-y-6">
                    <h3 class="text-sm font-extrabold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-brand-400"></i> Password Guidelines
                    </h3>
                    
                    <ul class="space-y-3.5 text-xs text-slate-400 font-semibold leading-relaxed">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-brand-500 mt-0.5"></i>
                            <span>At least 6 characters long to maintain security.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-brand-500 mt-0.5"></i>
                            <span>Use a combination of upper/lowercase letters and symbols.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-brand-500 mt-0.5"></i>
                            <span>Always secure your password keys: do not share admin credentials.</span>
                        </li>
                    </ul>

                    <div class="p-4 bg-brand-500/10 border border-brand-500/20 text-brand-400 rounded-2xl text-[10px] leading-relaxed font-bold">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        <span>Admin passwords are stored using high-grade secure hashing parameters (bcrypt algorithm). Zenvora developers cannot read plain text admin credentials.</span>
                    </div>
                </div>

            </div>

        </div>
        </main>
    </div>
</body>
</html>
