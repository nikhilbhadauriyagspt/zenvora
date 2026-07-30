<?php
/**
 * Zenvora Global Solutions - Admin Panel Dashboard
 */
session_start();
require_once '../components/db_connect.php';
require_once '../components/settings_helper.php';

// 1. Session verification: Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || !isset($_SESSION['admin_username'])) {
    header('Location: login.php');
    exit;
}

$adminUsername = $_SESSION['admin_username'] ?? 'Admin';
$adminRole = $_SESSION['admin_role'] ?? 'admin';

// Redirect back helper
function refreshPage() {
    header('Location: admin.php');
    exit;
}

// 2. Action Handlers (Database Updates)
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
            } catch (PDOException $e) {
                // Silently fail or log
            }
        }
        refreshPage();
    }
    
    // B. Delete Enquiry Lead
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $enquiryId = (int)$_POST['id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = :id");
            $stmt->execute([':id' => $enquiryId]);
        } catch (PDOException $e) {
            // Silently fail or log
        }
        refreshPage();
    }
}

// 3. Fetch KPI Metrics & Chart Data
$totalLeads = 0;
$pendingLeads = 0;
$inProgressLeads = 0;
$resolvedLeads = 0;
$enquiriesList = [];
$chartData = [];

if ($pdo !== null) {
    try {
        // Enquiries Query for KPIs
        $stmtAll = $pdo->prepare("SELECT status FROM enquiries");
        $stmtAll->execute();
        $allLeads = $stmtAll->fetchAll();
        
        $totalLeads = count($allLeads);
        foreach ($allLeads as $item) {
            if ($item['status'] === 'Pending') $pendingLeads++;
            elseif ($item['status'] === 'In Progress') $inProgressLeads++;
            elseif ($item['status'] === 'Resolved') $resolvedLeads++;
        }
        
        // Fetch only 5 recent enquiries for dashboard table
        $stmtRecent = $pdo->prepare("SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 5");
        $stmtRecent->execute();
        $enquiriesList = $stmtRecent->fetchAll();

        // Fetch leads history (last 7 days) for chart
        $stmtChart = $pdo->query("
            SELECT DATE(created_at) as date_label, COUNT(*) as count 
            FROM enquiries 
            GROUP BY DATE(created_at) 
            ORDER BY DATE(created_at) DESC 
            LIMIT 7
        ");
        $chartData = array_reverse($stmtChart->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        // Silently fail
    }
}

// Parse chart counts for 7-day intake line
$labels = [];
$dataCounts = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('d M', strtotime($date));
    
    $foundCount = 0;
    foreach ($chartData as $row) {
        if ($row['date_label'] === $date) {
            $foundCount = (int)$row['count'];
            break;
        }
    }
    $dataCounts[] = $foundCount;
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Zenvora Global Solutions</title>
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
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<body class="h-full font-sans antialiased text-slate-100 selection:bg-brand-500 selection:text-white bg-slate-900">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside id="admin-sidebar" class="w-64 bg-slate-950 border-r border-slate-800 p-6 flex flex-col justify-between flex-shrink-0 z-30 transition-all duration-300 ease-in-out">
            <div class="flex flex-col flex-grow space-y-8">
                <!-- Branding -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-400 flex items-center justify-center font-black">Z</div>
                    <div>
                        <span class="text-xs font-black tracking-widest text-white block uppercase">Zenvora</span>
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Admin Control</span>
                    </div>
                </div>

                <!-- Nav list -->
                <nav class="flex-1 space-y-1">
                    <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mb-2 whitespace-nowrap">Metrics & Leads</span>
                    <a href="admin.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold bg-brand-500/10 text-brand-400 border border-brand-500/20">
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
                    <a href="testimonials_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-star text-sm"></i> <span class="whitespace-nowrap">Testimonials</span>
                    </a>
                    <a href="blog_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-newspaper text-sm"></i> <span class="whitespace-nowrap">Blog Manager</span>
                    </a>
                    <a href="pricing_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-tags text-sm"></i> <span class="whitespace-nowrap">Pricing Packages</span>
                    </a>
                    <a href="platform_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-earth-americas text-sm"></i> <span class="whitespace-nowrap">Global Operations</span>
                    </a>
                    <a href="seo_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-search text-sm"></i> <span class="whitespace-nowrap">Page SEO Settings</span>
                    </a>
                    
                    <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mt-6 mb-2 flex items-center gap-1.5"><i class="fa-solid fa-user-shield text-[9px]"></i> Account</span>
                    <a href="change_password.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-key text-sm"></i> <span class="whitespace-nowrap">Change Password</span>
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
        </aside>

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0 overflow-hidden bg-slate-900">
            <!-- Header Bar -->
            <?php include_once 'admin_header.php'; ?>

            <!-- Scrollable Workspace Body -->
            <main class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-8">
                
                <!-- Welcome Title -->
                <div class="text-left space-y-1">
                    <h1 class="text-2xl font-black text-white tracking-tight">Welcome Back, <?php echo htmlspecialchars($adminUsername); ?>!</h1>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Compliance Leads & Status Oversight</p>
                </div>

                <!-- KPI Status Dashboard Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- KPI 1: Total Leads -->
                    <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between">
                        <div class="space-y-1.5 text-left">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block">Total Enquiries</span>
                            <span class="text-2xl font-black text-white block"><?php echo $totalLeads; ?></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-slate-400 flex items-center justify-center text-sm border border-slate-800">
                            <i class="fa-solid fa-folder-open"></i>
                        </div>
                    </div>

                    <!-- KPI 2: Pending Reviews -->
                    <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between">
                        <div class="space-y-1.5 text-left">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block">Pending Reviews</span>
                            <span class="text-2xl font-black text-amber-500 block"><?php echo $pendingLeads; ?></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-sm border border-amber-500/20">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                    </div>

                    <!-- KPI 3: In Progress Desk -->
                    <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between">
                        <div class="space-y-1.5 text-left">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block">In Progress Desk</span>
                            <span class="text-2xl font-black text-blue-500 block"><?php echo $inProgressLeads; ?></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-sm border border-blue-500/20">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                    </div>

                    <!-- KPI 4: Resolved Milestones -->
                    <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between">
                        <div class="space-y-1.5 text-left">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block">Resolved Files</span>
                            <span class="text-2xl font-black text-emerald-500 block"><?php echo $resolvedLeads; ?></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm border border-emerald-500/20">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>

                </div>

                <!-- Upgraded Premium Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    <!-- Line Chart: 7-Day Lead Flow (70% width) -->
                    <div class="lg:col-span-8 bg-slate-950 border border-slate-800 rounded-3xl p-6 space-y-4">
                        <div class="text-left">
                            <h3 class="text-sm font-extrabold text-white uppercase tracking-wider">7-Day Enquiries Flow</h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Chronological view of lead volume in the past week</p>
                        </div>
                        <div class="h-64 relative w-full">
                            <canvas id="leadsHistoryChart"></canvas>
                        </div>
                    </div>

                    <!-- Doughnut Chart: Status distribution (30% width) -->
                    <div class="lg:col-span-4 bg-slate-950 border border-slate-800 rounded-3xl p-6 space-y-4 flex flex-col justify-between">
                        <div class="text-left">
                            <h3 class="text-sm font-extrabold text-white uppercase tracking-wider">Status Distribution</h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Active workflow breakdowns</p>
                        </div>
                        <div class="h-48 relative w-full flex items-center justify-center">
                            <canvas id="leadsStatusChart"></canvas>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-center text-[10px] font-bold uppercase pt-2 border-t border-slate-900">
                            <div>
                                <span class="text-amber-500 block">Pending</span>
                                <span class="text-slate-400"><?php echo $pendingLeads; ?></span>
                            </div>
                            <div>
                                <span class="text-blue-500 block">Active</span>
                                <span class="text-slate-400"><?php echo $inProgressLeads; ?></span>
                            </div>
                            <div>
                                <span class="text-emerald-500 block">Done</span>
                                <span class="text-slate-400"><?php echo $resolvedLeads; ?></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Quick Actions Console Panel -->
                <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 space-y-6">
                    <div class="border-b border-slate-900 pb-4">
                        <h3 class="text-sm font-extrabold text-white uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-bolt text-brand-400"></i> Command Panel Shortcuts
                        </h3>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Direct links to edit, manage and scale your digital operations</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        
                        <!-- Shortcut 1: Manage Blog -->
                        <a href="blog_manager.php" class="p-4 bg-slate-900 hover:bg-slate-850 border border-slate-800 rounded-2xl flex flex-col items-center justify-center text-center gap-3 group transition-all">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 group-hover:scale-110 transition-transform flex items-center justify-center text-sm border border-blue-500/10">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-wider">Manage Blog</span>
                        </a>

                        <!-- Shortcut 2: Add Banner -->
                        <a href="homepage.php" class="p-4 bg-slate-900 hover:bg-slate-850 border border-slate-800 rounded-2xl flex flex-col items-center justify-center text-center gap-3 group transition-all">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 group-hover:scale-110 transition-transform flex items-center justify-center text-sm border border-amber-500/10">
                                <i class="fa-solid fa-rectangle-ad"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-wider">Add Banner</span>
                        </a>

                        <!-- Shortcut 3: Manage Services -->
                        <a href="services_manager.php" class="p-4 bg-slate-900 hover:bg-slate-850 border border-slate-800 rounded-2xl flex flex-col items-center justify-center text-center gap-3 group transition-all">
                            <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-400 group-hover:scale-110 transition-transform flex items-center justify-center text-sm border border-purple-500/10">
                                <i class="fa-solid fa-folder-plus"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-wider">Add Service</span>
                        </a>

                        <!-- Shortcut 4: SEO Configurations -->
                        <a href="seo_manager.php" class="p-4 bg-slate-900 hover:bg-slate-850 border border-slate-800 rounded-2xl flex flex-col items-center justify-center text-center gap-3 group transition-all">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 group-hover:scale-110 transition-transform flex items-center justify-center text-sm border border-emerald-500/10">
                                <i class="fa-solid fa-magnifying-glass-chart"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-wider">SEO Settings</span>
                        </a>

                        <!-- Shortcut 5: Pricing Plans -->
                        <a href="pricing_manager.php" class="p-4 bg-slate-900 hover:bg-slate-850 border border-slate-800 rounded-2xl flex flex-col items-center justify-center text-center gap-3 group transition-all">
                            <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 group-hover:scale-110 transition-transform flex items-center justify-center text-sm border border-rose-500/10">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-wider">Pricing Plans</span>
                        </a>

                        <!-- Shortcut 6: Global Operations -->
                        <a href="platform_manager.php" class="p-4 bg-slate-900 hover:bg-slate-850 border border-slate-800 rounded-2xl flex flex-col items-center justify-center text-center gap-3 group transition-all">
                            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-400 group-hover:scale-110 transition-transform flex items-center justify-center text-sm border border-cyan-500/10">
                                <i class="fa-solid fa-earth-americas"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-wider">Global Ops</span>
                        </a>

                    </div>
                </div>

                <!-- Leads Datatable Card -->
                <div class="bg-slate-950 border border-slate-800 rounded-3xl overflow-hidden" id="leads">
                    <!-- Card Header -->
                    <div class="px-6 py-5 border-b border-slate-800 flex flex-wrap items-center justify-between gap-4">
                        <div class="text-left space-y-1">
                            <h3 class="text-base font-extrabold text-white">Recent Enquiry Registries</h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Latest 5 submissions captured from the website contact forms</p>
                        </div>
                        
                        <!-- Search filtering -->
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-slate-550 text-[10px]"></i>
                            </div>
                            <input type="text" id="leads-search-box" placeholder="Filter by name, email..." 
                                   class="w-full text-xs font-semibold pl-9 pr-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-slate-200 focus:border-brand-500 focus:outline-none transition-colors">
                        </div>
                    </div>

                    <!-- Table container -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="leads-table">
                            <thead>
                                <tr class="bg-slate-950 border-b border-slate-800 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                    <th class="px-6 py-4">Submission Details</th>
                                    <th class="px-6 py-4">Required Service</th>
                                    <th class="px-6 py-4">Details</th>
                                    <th class="px-6 py-4">Filing Status</th>
                                    <th class="px-6 py-4 text-center">Filing Management Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-850 text-xs font-medium text-slate-400">
                                <?php if (empty($enquiriesList)): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-semibold">
                                            <i class="fa-solid fa-inbox text-2xl text-slate-700 block mb-2"></i>
                                            No enquiries have been submitted yet.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($enquiriesList as $lead): ?>
                                        <tr class="hover:bg-slate-900/50 transition-colors lead-row">
                                            <!-- Contact Details -->
                                            <td class="px-6 py-4 space-y-1">
                                                <strong class="text-white font-extrabold text-sm block lead-name"><?php echo htmlspecialchars($lead['name']); ?></strong>
                                                <span class="text-slate-400 block leading-none font-semibold"><i class="fa-solid fa-envelope mr-1.5 text-slate-500"></i><span class="lead-email"><?php echo htmlspecialchars($lead['email']); ?></span></span>
                                                <span class="text-slate-400 block leading-none font-semibold mt-1"><i class="fa-solid fa-phone mr-1.5 text-slate-500"></i><?php echo htmlspecialchars($lead['phone']); ?></span>
                                            </td>

                                            <!-- Service Category -->
                                            <td class="px-6 py-4">
                                                <span class="inline-block text-[10px] font-extrabold px-2.5 py-1 rounded bg-slate-900 text-brand-400 border border-slate-800 uppercase tracking-wider">
                                                    <?php echo htmlspecialchars($lead['service']); ?>
                                                </span>
                                                <span class="text-[10px] text-slate-500 font-bold block mt-1">Timeline: <?php echo htmlspecialchars($lead['timeline']); ?></span>
                                            </td>

                                            <!-- Message details -->
                                            <td class="px-6 py-4 max-w-xs sm:max-w-sm">
                                                <div class="space-y-1">
                                                    <span class="text-[10px] text-slate-500 font-bold block">Size: <?php echo htmlspecialchars($lead['org_size']); ?> employee(s)</span>
                                                    <p class="text-[11px] text-slate-400 leading-relaxed truncate-2-lines italic">
                                                        "<?php echo htmlspecialchars($lead['message'] ?: 'No details specified.'); ?>"
                                                    </p>
                                                    <span class="text-[9px] text-slate-650 block mt-0.5"><?php echo htmlspecialchars($lead['created_at']); ?></span>
                                                </div>
                                            </td>

                                            <!-- Current Status -->
                                            <td class="px-6 py-4">
                                                <?php if ($lead['status'] === 'Pending'): ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500/10 text-amber-400 border border-amber-500/25">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                                    </span>
                                                <?php elseif ($lead['status'] === 'In Progress'): ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-500/10 text-blue-400 border border-blue-500/25">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> In Progress
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/25">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Resolved
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Update Status & Delete Actions -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center gap-3">
                                                    <!-- Status Update Form -->
                                                    <form action="admin.php" method="POST" class="flex items-center">
                                                        <input type="hidden" name="action" value="update_status">
                                                        <input type="hidden" name="id" value="<?php echo $lead['id']; ?>">
                                                        <select name="status" onchange="this.form.submit()" 
                                                                class="text-xs font-semibold px-2 py-1.5 bg-slate-900 border border-slate-800 text-slate-300 rounded-md focus:border-brand-500 focus:outline-none transition-colors">
                                                            <option value="" disabled selected>Update status...</option>
                                                            <option value="Pending" <?php echo $lead['status'] === 'Pending' ? 'disabled' : ''; ?>>Mark Pending</option>
                                                            <option value="In Progress" <?php echo $lead['status'] === 'In Progress' ? 'disabled' : ''; ?>>Mark In Progress</option>
                                                            <option value="Resolved" <?php echo $lead['status'] === 'Resolved' ? 'disabled' : ''; ?>>Mark Resolved</option>
                                                        </select>
                                                    </form>

                                                    <!-- Delete button form -->
                                                    <form action="admin.php" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this lead enquiry?');">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $lead['id']; ?>">
                                                        <button type="submit" class="p-1.5 rounded-md border border-red-500/30 text-red-400 hover:bg-red-950 transition-colors flex items-center justify-center" aria-label="Delete Lead">
                                                            <i class="fa-solid fa-trash text-xs"></i>
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
                    <!-- Card Footer Link -->
                    <div class="px-6 py-4 bg-slate-950 border-t border-slate-850 text-center">
                        <a href="enquiries.php" class="inline-flex items-center gap-1.5 text-xs font-black text-brand-400 hover:text-brand-350 uppercase tracking-widest transition-all">
                            View All Customer Enquiries <i class="fa-solid fa-arrow-right-long text-[10px]"></i>
                        </a>
                    </div>
                </div>

            </main>

        </div>

    </div>

    <!-- Sidebar Collapsing and search/chart scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('admin-sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const searchBox = document.getElementById('leads-search-box');
            const tableRows = document.querySelectorAll('.lead-row');

            // 1. Sidebar Toggle collapse function
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-0');
            });

            // 2. Client Side lead Search filtering
            searchBox.addEventListener('input', () => {
                const query = searchBox.value.toLowerCase().trim();
                
                tableRows.forEach(row => {
                    const name = row.querySelector('.lead-name').textContent.toLowerCase();
                    const email = row.querySelector('.lead-email').textContent.toLowerCase();
                    
                    if (name.includes(query) || email.includes(query)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            });

            // 3. Render 7-Day Leads Intake Line Chart
            const ctxHistory = document.getElementById('leadsHistoryChart').getContext('2d');
            const leadsHistoryChart = new Chart(ctxHistory, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                        label: 'Enquiries Captured',
                        data: <?php echo json_encode($dataCounts); ?>,
                        borderColor: '#bc8731', // Gold line color
                        backgroundColor: 'rgba(188, 135, 49, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#bc8731',
                        pointBorderColor: '#ffffff',
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 9,
                                    family: '"Space Grotesk"'
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            ticks: {
                                color: '#94a3b8',
                                stepSize: 1,
                                font: {
                                    size: 9,
                                    family: '"Space Grotesk"'
                                }
                            }
                        }
                    }
                }
            });

            // 4. Render Status Distribution Doughnut Chart
            const ctxStatus = document.getElementById('leadsStatusChart').getContext('2d');
            const leadsStatusChart = new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'In Progress', 'Resolved'],
                    datasets: [{
                        data: [
                            <?php echo $pendingLeads; ?>, 
                            <?php echo $inProgressLeads; ?>, 
                            <?php echo $resolvedLeads; ?>
                        ],
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '75%'
                }
            });

        });
    </script>

</body>

</html>
