<?php
/**
 * Zenvora Global Solutions - Global Operations (Platform Cards) Manager
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

// Check and initialize platform_cards table if not exists (Auto-Migration)
if ($pdo !== null) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS platform_cards (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            slug VARCHAR(100) UNIQUE NOT NULL,
            subtitle VARCHAR(100) DEFAULT NULL,
            description TEXT NOT NULL,
            image_url VARCHAR(255) NOT NULL,
            points TEXT NOT NULL,
            detailed_content LONGTEXT NOT NULL,
            status VARCHAR(20) DEFAULT 'Active',
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB");
    } catch (PDOException $e) {
        $errorMsg = 'Failed to initialize database table: ' . $e->getMessage();
    }
}

// Edit Mode detection
$editCard = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id']) && $pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM platform_cards WHERE id = :id");
        $stmt->execute([':id' => (int)$_GET['id']]);
        $editCard = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errorMsg = 'Error loading card for editing: ' . $e->getMessage();
    }
}

// Handle Form Submission (Add / Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    $action = $_POST['action'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $points = trim($_POST['points'] ?? '');
    $detailed_content = trim($_POST['detailed_content'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $cardId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    // Generate slug from title if empty
    if ($slug === '' && $title !== '') {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }

    if ($title === '' || $slug === '' || $description === '') {
        $errorMsg = 'Title, Slug, and Description are required fields.';
    } else {
        try {
            if ($action === 'add') {
                $stmt = $pdo->prepare("INSERT INTO platform_cards (title, slug, subtitle, description, image_url, points, detailed_content, status, sort_order) VALUES (:title, :slug, :subtitle, :description, :image_url, :points, :detailed_content, :status, :sort_order)");
                $stmt->execute([
                    ':title' => $title,
                    ':slug' => $slug,
                    ':subtitle' => $subtitle ?: null,
                    ':description' => $description,
                    ':image_url' => $image_url,
                    ':points' => $points,
                    ':detailed_content' => $detailed_content,
                    ':status' => $status,
                    ':sort_order' => $sort_order
                ]);
                $successMsg = 'Platform card added successfully!';
            } elseif ($action === 'edit' && $cardId > 0) {
                $stmt = $pdo->prepare("UPDATE platform_cards SET title = :title, slug = :slug, subtitle = :subtitle, description = :description, image_url = :image_url, points = :points, detailed_content = :detailed_content, status = :status, sort_order = :sort_order WHERE id = :id");
                $stmt->execute([
                    ':title' => $title,
                    ':slug' => $slug,
                    ':subtitle' => $subtitle ?: null,
                    ':description' => $description,
                    ':image_url' => $image_url,
                    ':points' => $points,
                    ':detailed_content' => $detailed_content,
                    ':status' => $status,
                    ':sort_order' => $sort_order,
                    ':id' => $cardId
                ]);
                $successMsg = 'Platform card updated successfully!';
                
                // Clear edit mode URL parameters
                header("Location: platform_manager.php?success=" . urlencode($successMsg));
                exit;
            }
        } catch (PDOException $e) {
            $errorMsg = 'Database operation failed: ' . $e->getMessage();
        }
    }
}

// Handle Delete Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && $pdo !== null) {
    try {
        $stmt = $pdo->prepare("DELETE FROM platform_cards WHERE id = :id");
        $stmt->execute([':id' => (int)$_GET['id']]);
        $successMsg = 'Platform card deleted successfully!';
        header("Location: platform_manager.php?success=" . urlencode($successMsg));
        exit;
    } catch (PDOException $e) {
        $errorMsg = 'Failed to delete card: ' . $e->getMessage();
    }
}

// Fetch all Platform Cards
$platformCards = [];
if ($pdo !== null) {
    try {
        $platformCards = $pdo->query("SELECT * FROM platform_cards ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Global Operations | Zenvora Admin Console</title>
    
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
                <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Metrics & Leads</span>
                <a href="admin.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-chart-line text-sm"></i> <span>Dashboard Overview</span>
                </a>
                <a href="enquiries.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                    <i class="fa-solid fa-envelope-open-text text-sm"></i> <span>Customer Enquiries</span>
                </a>
                
                <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mt-6 mb-2">Website Settings</span>
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
                <a href="platform_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all bg-brand-500/10 text-brand-400 border border-brand-500/20">
                    <i class="fa-solid fa-earth-americas text-sm"></i> <span>Global Operations</span>
                </a>
                <a href="seo_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
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
                    <h1 class="text-2xl font-black text-white">Global Operations (Platform Showcase)</h1>
                    <p class="text-xs text-slate-400 font-semibold mt-1">Configure columns, points, description, images, and detail page layouts for the international platform.</p>
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

            <!-- Split Panel: Form on left, card listing on right -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Card Editor Form (Col span 5) -->
                <div class="lg:col-span-5 bg-slate-950 border border-slate-800 rounded-3xl p-6 space-y-6">
                    <h3 class="text-sm font-extrabold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-brand-400"></i>
                        <?php echo $editCard ? 'Edit Platform Card' : 'Create New Card'; ?>
                    </h3>
                    
                    <form action="platform_manager.php" method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="<?php echo $editCard ? 'edit' : 'add'; ?>">
                        <?php if ($editCard): ?>
                            <input type="hidden" name="id" value="<?php echo (int)$editCard['id']; ?>">
                        <?php endif; ?>

                        <!-- Title -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Card Title *</label>
                            <input type="text" name="title" required placeholder="Entity Management" value="<?php echo htmlspecialchars($editCard['title'] ?? ''); ?>" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <!-- Slug -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Unique Slug * (URL identifier)</label>
                            <input type="text" name="slug" placeholder="entity-management" value="<?php echo htmlspecialchars($editCard['slug'] ?? ''); ?>" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <!-- Subtitle -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Subtitle (Detail Page Header)</label>
                            <input type="text" name="subtitle" placeholder="Global Subsidiary Operations" value="<?php echo htmlspecialchars($editCard['subtitle'] ?? ''); ?>" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <!-- Image URL -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Card Image path *</label>
                            <input type="text" name="image_url" required placeholder="assets/images/hero_bg_5.jpg" value="<?php echo htmlspecialchars($editCard['image_url'] ?? ''); ?>" 
                                   class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                        </div>

                        <!-- Short Description -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Short Card Description *</label>
                            <textarea name="description" rows="3" required placeholder="Formation, maintenance, and oversight for subsidiaries across 70+ countries."
                                      class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200 resize-none"><?php echo htmlspecialchars($editCard['description'] ?? ''); ?></textarea>
                        </div>

                        <!-- Bullet Points -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Features Checklist * (One item per line)</label>
                            <textarea name="points" rows="4" required placeholder="70+ Countries subsidiary setup&#10;Local registered agent service&#10;Annual secretary oversight"
                                      class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200 resize-none"><?php echo htmlspecialchars($editCard['points'] ?? ''); ?></textarea>
                        </div>

                        <!-- Detailed Content -->
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Detail Page HTML Content *</label>
                            <textarea name="detailed_content" rows="6" required placeholder="<h3>Unified Subsidiary Operations</h3><p>Establish and maintain...</p>"
                                      class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200 font-mono"><?php echo htmlspecialchars($editCard['detailed_content'] ?? ''); ?></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Status -->
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Status</label>
                                <select name="status" class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                                    <option value="Active" <?php echo (isset($editCard['status']) && $editCard['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="Inactive" <?php echo (isset($editCard['status']) && $editCard['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Sort Order -->
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Sort Order</label>
                                <input type="number" name="sort_order" placeholder="0" value="<?php echo htmlspecialchars($editCard['sort_order'] ?? 0); ?>" 
                                       class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none text-slate-200">
                            </div>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="submit" class="flex-1 text-center py-2.5 rounded-xl text-xs font-black text-slate-950 bg-brand-500 hover:bg-brand-400 transition-colors uppercase tracking-wider">
                                <?php echo $editCard ? 'Update Card' : 'Save Card'; ?>
                            </button>
                            <?php if ($editCard): ?>
                                <a href="platform_manager.php" class="px-4 py-2.5 text-center bg-slate-850 hover:bg-slate-800 text-slate-300 border border-slate-800 rounded-xl text-xs font-black uppercase tracking-wider transition-colors">
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
                            <i class="fa-solid fa-list-check text-brand-400"></i> Active Platform Cards
                        </h3>
                        <span class="text-[10px] text-slate-400 font-extrabold uppercase"><?php echo count($platformCards); ?> Entries</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-slate-800 text-[10px] text-slate-500 font-extrabold uppercase tracking-wider">
                                    <th class="py-3">Details</th>
                                    <th class="py-3">Points</th>
                                    <th class="py-3 text-center">Order</th>
                                    <th class="py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60 font-medium">
                                <?php if (empty($platformCards)): ?>
                                    <tr>
                                        <td colspan="4" class="py-10 text-center text-slate-500">
                                            No platform cards created yet.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($platformCards as $card): ?>
                                    <tr class="hover:bg-slate-900/30 transition-colors">
                                        <td class="py-4 space-y-1 max-w-[200px]">
                                            <div class="flex items-center gap-2">
                                                <img src="../<?php echo htmlspecialchars($card['image_url']); ?>" class="w-8 h-8 rounded object-cover border border-slate-800">
                                                <span class="font-extrabold text-white block truncate"><?php echo htmlspecialchars($card['title']); ?></span>
                                            </div>
                                            <span class="text-[10px] text-slate-400 block truncate">Slug: <?php echo htmlspecialchars($card['slug']); ?></span>
                                            <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider inline-block <?php echo ($card['status'] === 'Active') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-500'; ?>">
                                                <?php echo htmlspecialchars($card['status']); ?>
                                            </span>
                                        </td>
                                        <td class="py-4 text-[10px] text-slate-400 max-w-[200px]">
                                            <ul class="list-disc pl-4 space-y-0.5">
                                                <?php 
                                                $pts = explode("\n", str_replace("\r", "", $card['points']));
                                                foreach ($pts as $pt):
                                                    if (trim($pt) === '') continue;
                                                    echo '<li class="truncate">' . htmlspecialchars(trim($pt)) . '</li>';
                                                endforeach;
                                                ?>
                                            </ul>
                                        </td>
                                        <td class="py-4 text-center text-slate-300">
                                            <?php echo htmlspecialchars($card['sort_order']); ?>
                                        </td>
                                        <td class="py-4 text-right space-x-2 whitespace-nowrap">
                                            <a href="platform_manager.php?action=edit&id=<?php echo $card['id']; ?>" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-slate-850 text-brand-400 flex items-center justify-center inline-flex transition-colors border border-slate-800 hover:border-brand-500/30" title="Edit">
                                                <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                            </a>
                                            <a href="../platform-detail.php?slug=<?php echo htmlspecialchars($card['slug']); ?>" target="_blank" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-slate-850 text-slate-300 flex items-center justify-center inline-flex transition-colors border border-slate-800" title="View Detail Page">
                                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                            </a>
                                            <a href="platform_manager.php?action=delete&id=<?php echo $card['id']; ?>" onclick="return confirm('Are you sure you want to delete this card?');" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-red-950/20 text-red-400 flex items-center justify-center inline-flex transition-colors border border-slate-800 hover:border-red-500/30" title="Delete">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                            </a>
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
