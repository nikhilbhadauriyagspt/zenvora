<?php
/**
 * Zenvora Global Solutions - Admin Panel Dashboard
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

// 3. Fetch KPI Metrics
$totalLeads = 0;
$pendingLeads = 0;
$inProgressLeads = 0;
$resolvedLeads = 0;
$enquiriesList = [];

if ($pdo !== null) {
    try {
        // Enquiries Query
        $stmt = $pdo->prepare("SELECT * FROM enquiries ORDER BY created_at DESC");
        $stmt->execute();
        $enquiriesList = $stmt->fetchAll();
        
        $totalLeads = count($enquiriesList);
        foreach ($enquiriesList as $item) {
            if ($item['status'] === 'Pending') $pendingLeads++;
            elseif ($item['status'] === 'In Progress') $inProgressLeads++;
            elseif ($item['status'] === 'Resolved') $resolvedLeads++;
        }
    } catch (PDOException $e) {
        // Silently fail
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Zenvora Global Solutions</title>
    
    <!-- Load Head dependencies (Tailwind CDN, Fonts, Font Awesome) -->
    <?php include_once '../components/head.php'; ?>
    <script>
        // Custom configurations for clean typography
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="h-full font-sans antialiased text-slate-600 selection:bg-brand-500 selection:text-white">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation (Collapsible, w-64 -> w-0) -->
        <aside id="admin-sidebar" class="w-64 bg-slate-900 flex flex-col justify-between transition-all duration-300 ease-in-out flex-shrink-0 z-30 overflow-hidden relative">
            <div class="flex flex-col flex-grow">
                <!-- Branding Header -->
                <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800 flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <img class="h-8 w-auto object-contain bg-white/10 p-1 rounded-lg" src="../assets/images/logo/Zenvora_Global_Solutions_Logo.png" alt="Logo">
                        <span class="text-xs font-black text-white uppercase tracking-widest block whitespace-nowrap">Zenvora Admin</span>
                    </div>
                </div>
                
                <!-- Nav Links -->
                <nav class="flex-1 px-4 py-6 space-y-2.5 overflow-y-auto">
                    <span class="text-[9px] font-black text-slate-550 uppercase tracking-widest pl-3 block mb-2 whitespace-nowrap">Core Directory</span>
                    
                    <a href="admin.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold text-white bg-slate-800 rounded-xl transition-colors whitespace-nowrap">
                        <i class="fa-solid fa-chart-line text-brand-400 text-sm"></i>
                        <span>Dashboard Overview</span>
                    </a>
                    
                    <a href="#leads" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-xl transition-colors whitespace-nowrap">
                        <i class="fa-solid fa-list-check text-sm"></i>
                        <span>Lead Enquiries</span>
                    </a>

                    <a href="homepage.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-xl transition-colors whitespace-nowrap">
                        <i class="fa-solid fa-house-chimney text-sm"></i>
                        <span>Homepage Editor</span>
                    </a>

                    <a href="settings.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-xl transition-colors whitespace-nowrap">
                        <i class="fa-solid fa-gears text-sm"></i>
                        <span>Website Settings</span>
                    </a>
                    
                    <a href="../index.php" target="_blank" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-xl transition-colors whitespace-nowrap">
                        <i class="fa-solid fa-globe text-sm"></i>
                        <span>Visit Website</span>
                    </a>
                </nav>
            </div>
            
            <!-- User Status Footer -->
            <div class="p-4 border-t border-slate-800 flex-shrink-0">
                <div class="flex items-center gap-3 bg-slate-800/40 p-3 rounded-xl">
                    <div class="w-8 h-8 rounded-full bg-brand-500 text-white flex items-center justify-center font-bold text-xs">
                        A
                    </div>
                    <div class="overflow-hidden">
                        <span class="text-[10px] font-extrabold text-white block leading-none truncate"><?php echo htmlspecialchars($adminUsername); ?></span>
                        <span class="text-[9px] text-slate-550 font-bold block mt-1 uppercase tracking-wider">Role: <?php echo htmlspecialchars($adminRole); ?></span>
                    </div>
                </div>
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
                    <span class="text-sm font-black text-slate-900 hidden sm:inline-block uppercase tracking-wider">Compliance Command Center</span>
                </div>

                <!-- Admin Action items -->
                <div class="flex items-center gap-4">
                    <!-- CA Availability badge -->
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
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Welcome Back, <?php echo htmlspecialchars($adminUsername); ?>!</h1>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Compliance Leads & Status Oversight</p>
                </div>

                <!-- KPI Status Dashboard Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- KPI 1: Total Leads -->
                    <div class="bg-white border border-slate-200 p-6 rounded-2xl flex items-center justify-between">
                        <div class="space-y-1.5 text-left">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Total Enquiries</span>
                            <span class="text-2xl font-black text-slate-900 block"><?php echo $totalLeads; ?></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-folder-open"></i>
                        </div>
                    </div>

                    <!-- KPI 2: Pending Reviews -->
                    <div class="bg-white border border-slate-200 p-6 rounded-2xl flex items-center justify-between">
                        <div class="space-y-1.5 text-left">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Pending Reviews</span>
                            <span class="text-2xl font-black text-amber-600 block"><?php echo $pendingLeads; ?></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-sm border border-amber-500/10">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                    </div>

                    <!-- KPI 3: In Progress Desk -->
                    <div class="bg-white border border-slate-200 p-6 rounded-2xl flex items-center justify-between">
                        <div class="space-y-1.5 text-left">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">In Progress Desk</span>
                            <span class="text-2xl font-black text-blue-600 block"><?php echo $inProgressLeads; ?></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-sm border border-blue-500/10">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                    </div>

                    <!-- KPI 4: Resolved Milestones -->
                    <div class="bg-white border border-slate-200 p-6 rounded-2xl flex items-center justify-between">
                        <div class="space-y-1.5 text-left">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Resolved Files</span>
                            <span class="text-2xl font-black text-emerald-600 block"><?php echo $resolvedLeads; ?></span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-sm border border-emerald-500/10">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>

                </div>

                <!-- Leads Datatable Card -->
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden" id="leads">
                    <!-- Card Header -->
                    <div class="px-6 py-5 border-b border-slate-200 flex flex-wrap items-center justify-between gap-4">
                        <div class="text-left space-y-1">
                            <h3 class="text-base font-extrabold text-slate-900">Enquiry Registries</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">All submissions captured from the website contact forms</p>
                        </div>
                        
                        <!-- Search filtering -->
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-slate-450 text-[10px]"></i>
                            </div>
                            <input type="text" id="leads-search-box" placeholder="Filter by name, email..." 
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
                                                <div class="space-y-1">
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
                                                    <form action="admin.php" method="POST" class="flex items-center">
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

                                                    <!-- Delete button form -->
                                                    <form action="admin.php" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this lead enquiry?');">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $lead['id']; ?>">
                                                        <button type="submit" class="p-1.5 rounded-md border border-red-200 text-red-500 hover:bg-red-50 transition-colors flex items-center justify-center" aria-label="Delete Lead">
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
                </div>

            </main>

        </div>

    </div>

    <!-- Sidebar Collapsing and search scripts -->
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
        });
    </script>

</body>

</html>
