<?php
/**
 * Zenvora Global Solutions - Admin Panel Enquiries Manager
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
$message = '';
$messageType = 'success';

// Action Handlers (Database Updates)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    // A. Update Enquiry Status
    if (isset($_POST['action']) && $_POST['action'] === 'update_status') {
        $enquiryId = (int)$_POST['id'];
        $newStatus = trim($_POST['status']);
        
        $validStatuses = ['Pending', 'In Progress', 'Resolved'];
        if (in_array($newStatus, $validStatuses)) {
            try {
                $stmt = $pdo->prepare("UPDATE enquiries SET status = :status WHERE id = :id");
                $stmt->execute([':status' => $newStatus, ':id' => $enquiryId]);
                $message = "Enquiry status updated successfully!";
            } catch (PDOException $e) {
                $message = "Database Error: " . $e->getMessage();
                $messageType = 'error';
            }
        }
    }
    
    // B. Delete Enquiry Lead
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $enquiryId = (int)$_POST['id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = :id");
            $stmt->execute([':id' => $enquiryId]);
            $message = "Enquiry record deleted successfully!";
        } catch (PDOException $e) {
            $message = "Database Error: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Read filters from GET query parameters
$filterStatus = trim($_GET['status'] ?? '');
$filterService = trim($_GET['service'] ?? '');
$filterSearch = trim($_GET['search'] ?? '');
$filterStartDate = trim($_GET['start_date'] ?? '');
$filterEndDate = trim($_GET['end_date'] ?? '');

$enquiriesList = [];
$distinctServices = [];

if ($pdo !== null) {
    try {
        // Fetch distinct services for dynamic dropdown selection list
        $distinctStmt = $pdo->query("SELECT DISTINCT service FROM enquiries ORDER BY service ASC");
        $distinctServices = $distinctStmt->fetchAll(PDO::FETCH_COLUMN);

        // Build dynamic database filtering SQL statement
        $sql = "SELECT * FROM enquiries WHERE 1=1";
        $sqlParams = [];

        if ($filterStatus !== '') {
            $sql .= " AND status = :status";
            $sqlParams[':status'] = $filterStatus;
        }

        if ($filterService !== '') {
            $sql .= " AND service = :service";
            $sqlParams[':service'] = $filterService;
        }

        if ($filterStartDate !== '') {
            $sql .= " AND DATE(created_at) >= :start_date";
            $sqlParams[':start_date'] = $filterStartDate;
        }

        if ($filterEndDate !== '') {
            $sql .= " AND DATE(created_at) <= :end_date";
            $sqlParams[':end_date'] = $filterEndDate;
        }

        if ($filterSearch !== '') {
            $sql .= " AND (name LIKE :search1 OR email LIKE :search2 OR phone LIKE :search3 OR message LIKE :search4)";
            $searchWildcard = '%' . $filterSearch . '%';
            $sqlParams[':search1'] = $searchWildcard;
            $sqlParams[':search2'] = $searchWildcard;
            $sqlParams[':search3'] = $searchWildcard;
            $sqlParams[':search4'] = $searchWildcard;
        }

        $sql .= " ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($sqlParams);
        $enquiriesList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Database Error: " . $e->getMessage();
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Enquiries | Zenvora Admin</title>
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
                    <a href="enquiries.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all bg-brand-500/10 text-brand-400 border border-brand-500/20">
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
            
            <!-- Header bar -->
            <?php include_once 'admin_header.php'; ?>

            <!-- Scrollable workspace content -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
                
                <?php if ($message): ?>
                <div class="p-4 border rounded-2xl flex items-center gap-3 text-xs font-bold <?php echo ($messageType === 'success') ? 'bg-emerald-550/10 bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-red-50 border-red-200 text-red-700'; ?>">
                    <i class="<?php echo ($messageType === 'success') ? 'fa-solid fa-circle-check' : 'fa-solid fa-triangle-exclamation'; ?> text-base"></i>
                    <span><?php echo htmlspecialchars($message); ?></span>
                </div>
                <?php endif; ?>

                <!-- Filters Panel -->
                <div class="bg-white border border-slate-200 p-6 rounded-3xl text-left space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h4 class="text-xs font-black uppercase text-slate-900 tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-filter text-brand-500"></i> Lead Filter Desk
                        </h4>
                        <div class="flex gap-2">
                            <a href="export_enquiries.php?status=<?php echo urlencode($filterStatus); ?>&service=<?php echo urlencode($filterService); ?>&search=<?php echo urlencode($filterSearch); ?>&start_date=<?php echo urlencode($filterStartDate); ?>&end_date=<?php echo urlencode($filterEndDate); ?>" 
                               class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider flex items-center gap-2 transition-colors">
                                <i class="fa-solid fa-file-excel text-xs"></i> Export Filtered to Excel
                            </a>
                            <a href="enquiries.php" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-[10px] font-black uppercase tracking-wider flex items-center gap-2 transition-colors">
                                <i class="fa-solid fa-arrow-rotate-right"></i> Reset Filters
                            </a>
                        </div>
                    </div>

                    <form method="GET" action="enquiries.php" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                        <!-- Status Dropdown -->
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Status</label>
                            <select name="status" onchange="this.form.submit()" class="w-full text-xs font-semibold px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-755 font-sans">
                                <option value="">All Statuses</option>
                                <option value="Pending" <?php echo ($filterStatus === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="In Progress" <?php echo ($filterStatus === 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Resolved" <?php echo ($filterStatus === 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
                            </select>
                        </div>

                        <!-- Service Category Dropdown -->
                        <div class="sm:col-span-4 space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Required Service</label>
                            <select name="service" onchange="this.form.submit()" class="w-full text-xs font-semibold px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-755 font-sans">
                                <option value="">All Service Origins</option>
                                <?php foreach ($distinctServices as $ds): ?>
                                    <option value="<?php echo htmlspecialchars($ds); ?>" <?php echo ($filterService === $ds) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($ds); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Start Date</label>
                            <input type="date" name="start_date" value="<?php echo htmlspecialchars($filterStartDate); ?>" class="w-full text-xs font-semibold px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700 font-sans">
                        </div>

                        <!-- End Date -->
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">End Date</label>
                            <input type="date" name="end_date" value="<?php echo htmlspecialchars($filterEndDate); ?>" class="w-full text-xs font-semibold px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700 font-sans">
                        </div>

                        <!-- Search Button -->
                        <div class="sm:col-span-2 space-y-1.5 flex items-end">
                            <button type="submit" class="w-full text-center py-2 bg-brand-500 hover:bg-brand-600 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-colors flex items-center justify-center gap-1.5 h-[38px]">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i> Apply Filters
                            </button>
                        </div>

                        <!-- Text Search Field -->
                        <div class="sm:col-span-12 space-y-1.5 mt-2">
                            <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-450">Keyword Search</label>
                            <input type="text" name="search" value="<?php echo htmlspecialchars($filterSearch); ?>" placeholder="Search name, email, phone, messages..." class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700 font-sans">
                        </div>
                    </form>
                </div>

                <!-- Leads Datatable Card -->
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden" id="leads">
                    <!-- Card Header -->
                    <div class="px-6 py-5 border-b border-slate-200 flex flex-wrap items-center justify-between gap-4">
                        <div class="text-left space-y-1">
                            <h3 class="text-base font-extrabold text-slate-900">All Enquiry Registries</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">All submissions captured from the website contact forms</p>
                        </div>
                        
                        <!-- Search filtering -->
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-slate-450 text-[10px]"></i>
                            </div>
                            <input type="text" id="leads-search-box" placeholder="Search by name, email, service..." 
                                   class="w-full text-xs font-semibold pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:border-brand-500 focus:outline-none transition-colors">
                        </div>
                    </div>

                    <!-- Table container -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="leads-table">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    <th class="px-6 py-4">Submission Details</th>
                                    <th class="px-6 py-4">Required Service</th>
                                    <th class="px-6 py-4">Details</th>
                                    <th class="px-6 py-4">Filing Status</th>
                                    <th class="px-6 py-4 text-center">Filing Management Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-150 text-xs font-medium text-slate-600">
                                <?php if (empty($enquiriesList)): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-semibold">
                                            <i class="fa-solid fa-inbox text-2xl text-slate-300 block mb-2"></i>
                                            No enquiries have been submitted yet.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($enquiriesList as $lead): ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors lead-row">
                                            <!-- Contact Details -->
                                            <td class="px-6 py-4 space-y-1">
                                                <strong class="text-slate-900 font-extrabold text-sm block lead-name"><?php echo htmlspecialchars($lead['name']); ?></strong>
                                                <span class="text-slate-500 block leading-none font-semibold"><i class="fa-solid fa-envelope mr-1.5 text-slate-400"></i><span class="lead-email"><?php echo htmlspecialchars($lead['email']); ?></span></span>
                                                <span class="text-slate-500 block leading-none font-semibold mt-1"><i class="fa-solid fa-phone mr-1.5 text-slate-400"></i><?php echo htmlspecialchars($lead['phone']); ?></span>
                                            </td>

                                            <!-- Service Category -->
                                            <td class="px-6 py-4">
                                                <span class="inline-block text-[10px] font-extrabold px-2.5 py-1 rounded bg-slate-100 text-slate-700 uppercase tracking-wider">
                                                    <?php echo htmlspecialchars($lead['service']); ?>
                                                </span>
                                                <span class="text-[10px] text-slate-400 font-bold block mt-1">Timeline: <?php echo htmlspecialchars($lead['timeline']); ?></span>
                                            </td>

                                            <!-- Message details -->
                                            <td class="px-6 py-4 max-w-xs sm:max-w-sm">
                                                <div class="space-y-1 text-left">
                                                    <span class="text-[10px] text-slate-400 font-bold block">Size: <?php echo htmlspecialchars($lead['org_size']); ?> employee(s)</span>
                                                    <p class="text-[11px] text-slate-550 leading-relaxed truncate-2-lines italic">
                                                        "<?php echo htmlspecialchars($lead['message'] ?: 'No details specified.'); ?>"
                                                    </p>
                                                    <span class="text-[9px] text-slate-300 block mt-0.5"><?php echo htmlspecialchars($lead['created_at']); ?></span>
                                                </div>
                                            </td>

                                            <!-- Current Status -->
                                            <td class="px-6 py-4">
                                                <?php if ($lead['status'] === 'Pending'): ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-500/25">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                                    </span>
                                                <?php elseif ($lead['status'] === 'In Progress'): ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-500/25">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> In Progress
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-500/25">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Resolved
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Update Status & Delete Actions -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center gap-3">
                                                    <!-- Status Update Form -->
                                                    <form action="" method="POST" class="flex items-center">
                                                        <input type="hidden" name="action" value="update_status">
                                                        <input type="hidden" name="id" value="<?php echo $lead['id']; ?>">
                                                        <select name="status" onchange="this.form.submit()" 
                                                                class="text-xs font-semibold px-2 py-1.5 bg-slate-50 border border-slate-200 rounded-md focus:border-brand-500 focus:outline-none transition-colors">
                                                            <option value="" disabled selected>Update status...</option>
                                                            <option value="Pending" <?php echo $lead['status'] === 'Pending' ? 'disabled' : ''; ?>>Mark Pending</option>
                                                            <option value="In Progress" <?php echo $lead['status'] === 'In Progress' ? 'disabled' : ''; ?>>Mark In Progress</option>
                                                            <option value="Resolved" <?php echo $lead['status'] === 'Resolved' ? 'disabled' : ''; ?>>Mark Resolved</option>
                                                        </select>
                                                    </form>

                                                    <!-- Delete Button Form -->
                                                    <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this enquiry lead?')" class="flex items-center">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $lead['id']; ?>">
                                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-500 text-red-500 hover:text-white flex items-center justify-center border border-red-200/40 transition-all text-xs" title="Delete Lead">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Script Helpers -->
    <script>
        // Sidebar Toggle logic

        // Live filtering search box
        const searchBox = document.getElementById('leads-search-box');
        if (searchBox) {
            searchBox.addEventListener('input', () => {
                const query = searchBox.value.trim().toLowerCase();
                const rows = document.querySelectorAll('.lead-row');
                
                rows.forEach(row => {
                    const name = row.querySelector('.lead-name').textContent.toLowerCase();
                    const email = row.querySelector('.lead-email').textContent.toLowerCase();
                    const service = row.querySelector('span.uppercase').textContent.toLowerCase();
                    
                    if (name.includes(query) || email.includes(query) || service.includes(query)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            });
        }
    </script>
</body>
</html>
