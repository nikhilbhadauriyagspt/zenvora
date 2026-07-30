<?php
/**
 * Zenvora Global Solutions - Pricing Packages Manager
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

// Edit Mode detection
$editPackage = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id']) && $pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM pricing_packages WHERE id = :id");
        $stmt->execute([':id' => (int)$_GET['id']]);
        $editPackage = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errorMsg = 'Error loading package for editing: ' . $e->getMessage();
    }
}

// Handle Form Submission (Add / Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    $action = $_POST['action'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $tax_note = trim($_POST['tax_note'] ?? '+ Gov Challan');
    $description = trim($_POST['description'] ?? '');
    $deliverables = trim($_POST['deliverables'] ?? '');
    $badge = trim($_POST['badge'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $packageId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($title === '' || $price === '') {
        $errorMsg = 'Title and Price are required fields.';
    } else {
        try {
            if ($action === 'add') {
                $stmt = $pdo->prepare("INSERT INTO pricing_packages (title, subtitle, price, tax_note, description, deliverables, badge, status, sort_order) VALUES (:title, :subtitle, :price, :tax_note, :description, :deliverables, :badge, :status, :sort_order)");
                $stmt->execute([
                    ':title' => $title,
                    ':subtitle' => $subtitle,
                    ':price' => $price,
                    ':tax_note' => $tax_note,
                    ':description' => $description,
                    ':deliverables' => $deliverables,
                    ':badge' => $badge ?: null,
                    ':status' => $status,
                    ':sort_order' => $sort_order
                ]);
                $successMsg = 'Pricing package added successfully!';
            } elseif ($action === 'edit' && $packageId > 0) {
                $stmt = $pdo->prepare("UPDATE pricing_packages SET title = :title, subtitle = :subtitle, price = :price, tax_note = :tax_note, description = :description, deliverables = :deliverables, badge = :badge, status = :status, sort_order = :sort_order WHERE id = :id");
                $stmt->execute([
                    ':title' => $title,
                    ':subtitle' => $subtitle,
                    ':price' => $price,
                    ':tax_note' => $tax_note,
                    ':description' => $description,
                    ':deliverables' => $deliverables,
                    ':badge' => $badge ?: null,
                    ':status' => $status,
                    ':sort_order' => $sort_order,
                    ':id' => $packageId
                ]);
                $successMsg = 'Pricing package updated successfully!';
                
                // Clear edit mode URL parameters
                header("Location: pricing_manager.php?success=" . urlencode($successMsg));
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
        $stmt = $pdo->prepare("DELETE FROM pricing_packages WHERE id = :id");
        $stmt->execute([':id' => (int)$_GET['id']]);
        $successMsg = 'Pricing package deleted successfully!';
        header("Location: pricing_manager.php?success=" . urlencode($successMsg));
        exit;
    } catch (PDOException $e) {
        $errorMsg = 'Failed to delete package: ' . $e->getMessage();
    }
}

// Fetch list of all packages
$packages = [];
if ($pdo !== null) {
    try {
        $packages = $pdo->query("SELECT * FROM pricing_packages ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errorMsg = 'Failed to fetch packages: ' . $e->getMessage();
    }
}

// Success message from redirection URL
if (isset($_GET['success'])) {
    $successMsg = trim($_GET['success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Packages Manager | Zenvora Admin Console</title>
    <!-- Tailwind CSS & Space Grotesk Font -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;900&display=swap" rel="stylesheet">
    <!-- FontAwesome Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Space Grotesk', 'sans-serif'] },
                    colors: {
                        brand: {
                            400: '#e5b15d',
                            500: '#bc8731',
                            600: '#9b6c20'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-900 text-slate-100 flex min-h-screen">

    <!-- Admin Console Sidebar -->
    <div class="w-64 bg-slate-950 border-r border-slate-800 p-6 flex flex-col justify-between flex-shrink-0">
        <div class="space-y-8">
            <!-- Brand header -->
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
                <a href="pricing_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all bg-brand-500/10 text-brand-400 border border-brand-500/20">
                    <i class="fa-solid fa-tags text-sm"></i> <span>Pricing Packages</span>
                </a>
                <a href="platform_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
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
                    <h1 class="text-2xl font-black text-white">Pricing Packages Manager</h1>
                    <p class="text-xs text-slate-400 font-semibold mt-1">Configure flat-rate pricing tiers displayed on the website homepage.</p>
                </div>
                <div class="text-right text-[11px] text-slate-500 font-semibold">
                    <span>Database Connection: </span>
                    <span class="text-green-500"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Active</span>
                </div>
            </div>

            <!-- Status Alert Notifications -->
            <?php if ($successMsg): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-2xl text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($successMsg); ?>
            </div>
            <?php endif; ?>

            <?php if ($errorMsg): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-2xl text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars($errorMsg); ?>
            </div>
            <?php endif; ?>

            <!-- Workspace Columns: Grid list & editor -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Col span 7: Current Packages List -->
                <div class="lg:col-span-7 bg-slate-950 border border-slate-800 rounded-3xl p-6 space-y-6">
                    <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400 flex items-center justify-between">
                        <span>Current Packages List</span>
                        <span class="text-xs text-brand-400 border border-brand-500/20 px-2 py-0.5 rounded"><?php echo count($packages); ?> Packages</span>
                    </h2>

                    <div class="space-y-4">
                        <?php if (empty($packages)): ?>
                        <div class="p-8 text-center text-xs text-slate-500 italic">No packages configured. Add one on the right to start.</div>
                        <?php endif; ?>
                        
                        <?php foreach ($packages as $pkg): ?>
                        <div class="p-5 border border-slate-850 bg-slate-900/40 rounded-2xl space-y-3 hover:border-slate-750 transition-colors">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-extrabold text-white text-base"><?php echo htmlspecialchars($pkg['title']); ?></h3>
                                        <?php if ($pkg['badge']): ?>
                                        <span class="px-2 py-0.5 bg-brand-500/10 text-brand-400 border border-brand-500/20 text-[8px] font-black uppercase rounded-full">
                                            <?php echo htmlspecialchars($pkg['badge']); ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-bold"><?php echo htmlspecialchars($pkg['subtitle']); ?></span>
                                </div>
                                <div class="text-right">
                                    <div class="text-base font-black text-brand-400"><?php echo htmlspecialchars($pkg['price']); ?></div>
                                    <span class="text-[9px] text-slate-500 font-semibold block uppercase"><?php echo htmlspecialchars($pkg['tax_note']); ?></span>
                                </div>
                            </div>

                            <p class="text-xs text-slate-400 leading-relaxed font-semibold"><?php echo htmlspecialchars($pkg['description']); ?></p>

                            <!-- Deliverables bullets preview -->
                            <div class="pt-2 border-t border-slate-800">
                                <span class="text-[8px] font-black uppercase text-slate-500 tracking-wider">Deliverables Preview:</span>
                                <ul class="mt-1.5 grid grid-cols-2 gap-2 text-[10px] text-slate-350">
                                    <?php 
                                    $lines = explode("\n", str_replace("\r", "", $pkg['deliverables']));
                                    foreach (array_slice($lines, 0, 4) as $ln):
                                        if (trim($ln) === '') continue;
                                    ?>
                                    <li class="flex items-center gap-1.5 truncate">
                                        <i class="fa-solid fa-check text-brand-500 text-[8px]"></i> <?php echo htmlspecialchars($ln); ?>
                                    </li>
                                    <?php endforeach; ?>
                                    <?php if (count($lines) > 4): ?>
                                    <li class="text-brand-400 font-bold">+ <?php echo count($lines) - 4; ?> more items...</li>
                                    <?php endif; ?>
                                </ul>
                            </div>

                            <!-- Actions Row -->
                            <div class="pt-4 border-t border-slate-800 flex items-center justify-between text-[10px] font-black uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] text-slate-500">Order: <?php echo $pkg['sort_order']; ?></span>
                                    <span class="h-3 w-px bg-slate-800"></span>
                                    <span class="<?php echo $pkg['status'] === 'Active' ? 'text-emerald-400' : 'text-slate-500'; ?> flex items-center gap-1">
                                        <span class="h-1.5 w-1.5 rounded-full <?php echo $pkg['status'] === 'Active' ? 'bg-emerald-400' : 'bg-slate-500'; ?>"></span>
                                        <?php echo $pkg['status']; ?>
                                    </span>
                                </div>
                                <div class="flex gap-2">
                                    <a href="pricing_manager.php?action=edit&id=<?php echo $pkg['id']; ?>" class="px-3.5 py-1.5 bg-slate-850 hover:bg-slate-700 text-slate-300 rounded-lg transition-colors border border-slate-800">
                                        Edit
                                    </a>
                                    <a href="pricing_manager.php?action=delete&id=<?php echo $pkg['id']; ?>" onclick="return confirm('Are you sure you want to delete this pricing package tier?')" class="px-3.5 py-1.5 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white rounded-lg transition-colors border border-red-500/25">
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Col span 5: Edit / Add Package Form -->
                <div class="lg:col-span-5 bg-slate-950 border border-slate-800 rounded-3xl p-6">
                    <h2 class="text-sm font-extrabold uppercase tracking-widest text-slate-400 mb-6">
                        <?php echo $editPackage ? 'Edit Pricing Tier' : 'Add New Pricing Tier'; ?>
                    </h2>

                    <form action="pricing_manager.php" method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="<?php echo $editPackage ? 'edit' : 'add'; ?>">
                        <?php if ($editPackage): ?>
                        <input type="hidden" name="id" value="<?php echo $editPackage['id']; ?>">
                        <?php endif; ?>

                        <div>
                            <label class="block text-[8px] font-extrabold uppercase text-slate-500 tracking-wider mb-1">Package Title (Required)</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($editPackage['title'] ?? ''); ?>" required placeholder="e.g. Startup Registry" class="w-full text-xs font-semibold px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                        </div>

                        <div>
                            <label class="block text-[8px] font-extrabold uppercase text-slate-500 tracking-wider mb-1">Subtitle / stage note</label>
                            <input type="text" name="subtitle" value="<?php echo htmlspecialchars($editPackage['subtitle'] ?? ''); ?>" placeholder="e.g. For Early Stage Founders" class="w-full text-xs font-semibold px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-500 tracking-wider mb-1">Flat Price (Required)</label>
                                <input type="text" name="price" value="<?php echo htmlspecialchars($editPackage['price'] ?? ''); ?>" required placeholder="e.g. ₹4,999" class="w-full text-xs font-semibold px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                            </div>
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-500 tracking-wider mb-1">Tax Note / Challan note</label>
                                <input type="text" name="tax_note" value="<?php echo htmlspecialchars($editPackage['tax_note'] ?? '+ Gov Challan'); ?>" class="w-full text-xs font-semibold px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[8px] font-extrabold uppercase text-slate-500 tracking-wider mb-1">Short Description</label>
                            <textarea name="description" rows="2" placeholder="Describe who this package is for..." class="w-full text-xs font-semibold px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500 resize-none"><?php echo htmlspecialchars($editPackage['description'] ?? ''); ?></textarea>
                        </div>

                        <div>
                            <label class="block text-[8px] font-extrabold uppercase text-slate-500 tracking-wider mb-1">Deliverables checklist (One per line)</label>
                            <textarea name="deliverables" rows="5" required placeholder="2 Director DINs & DSC Digital Keys&#10;MCA Name Approval Filing (RUN)&#10;MoA / AoA Drafting & Filing" class="w-full text-xs font-semibold px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500 resize-none"><?php echo htmlspecialchars($editPackage['deliverables'] ?? ''); ?></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-500 tracking-wider mb-1">Badge Tag overlay</label>
                                <input type="text" name="badge" value="<?php echo htmlspecialchars($editPackage['badge'] ?? ''); ?>" placeholder="e.g. Most Popular" class="w-full text-xs font-semibold px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                            </div>
                            <div>
                                <label class="block text-[8px] font-extrabold uppercase text-slate-500 tracking-wider mb-1">Display Sort Order</label>
                                <input type="number" name="sort_order" value="<?php echo htmlspecialchars($editPackage['sort_order'] ?? '0'); ?>" class="w-full text-xs font-semibold px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[8px] font-extrabold uppercase text-slate-500 tracking-wider mb-1">Publish Status</label>
                            <select name="status" class="w-full text-xs font-semibold px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                                <option value="Active" <?php echo (($editPackage['status'] ?? 'Active') === 'Active') ? 'selected' : ''; ?>>Active (Visible on Site)</option>
                                <option value="Inactive" <?php echo (($editPackage['status'] ?? 'Active') === 'Inactive') ? 'selected' : ''; ?>>Inactive (Hidden)</option>
                            </select>
                        </div>

                        <div class="pt-4 flex items-center justify-between">
                            <?php if ($editPackage): ?>
                            <a href="pricing_manager.php" class="px-5 py-3 border border-slate-800 hover:border-slate-600 rounded-xl text-xs font-bold text-slate-300 transition-colors">
                                Cancel Edit
                            </a>
                            <?php else: ?>
                            <div></div>
                            <?php endif; ?>
                            
                            <button type="submit" class="px-8 py-3 bg-brand-500 hover:bg-brand-600 text-xs font-bold text-slate-950 rounded-xl transition-colors uppercase tracking-wider">
                                <?php echo $editPackage ? 'Update Tier' : 'Create Tier'; ?>
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>

</body>
</html>
