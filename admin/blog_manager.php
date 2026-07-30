<?php
/**
 * Zenvora Global Solutions - Admin Panel Blog Manager
 */
session_start();
require_once __DIR__ . '/../components/db_connect.php';
require_once __DIR__ . '/../components/settings_helper.php';

// Auth Guard
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || !isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit;
}

$adminUsername = $_SESSION['admin_username'] ?? 'Admin';
$successMsg = '';
$errorMsg = '';

$action = trim($_GET['action'] ?? 'list');
$blogId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    // 1. SAVE / UPDATE operation
    if (isset($_POST['save_blog'])) {
        $id = (int)$_POST['id'];
        $title = trim($_POST['title']);
        $slug = trim($_POST['slug']);
        $catSelection = trim($_POST['blog_category_selection'] ?? 'Business Setup|startup');
        $catParts = explode('|', $catSelection);
        $category = trim($catParts[0] ?? 'Business Setup');
        $category_slug = trim($catParts[1] ?? 'startup');
        $date = trim($_POST['date']);
        $author = trim($_POST['author']);
        $author_role = trim($_POST['author_role']);
        $author_avatar = trim($_POST['author_avatar']);
        $read_time = trim($_POST['read_time']);
        $excerpt = trim($_POST['excerpt']);
        $content = trim($_POST['content']);
        $status = trim($_POST['status']);
        $imagePath = trim($_POST['existing_image']);

        // Handle Image Upload
        if (isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['blog_image']['tmp_name'];
            $fileName = $_FILES['blog_image']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $uploadFileDir = '../assets/images/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }
                $newFileName = 'blog_' . time() . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imagePath = 'assets/images/' . $newFileName;
                }
            }
        }

        if (empty($title) || empty($slug) || empty($content)) {
            $errorMsg = 'Please fill out all required fields (Title, Slug, Content).';
        } else {
            try {
                if ($id > 0) {
                    // Update
                    $stmt = $pdo->prepare("UPDATE blogs SET title = :title, slug = :slug, category = :category, category_slug = :category_slug, date = :date, author = :author, author_role = :author_role, author_avatar = :author_avatar, read_time = :read_time, image = :image, excerpt = :excerpt, content = :content, status = :status WHERE id = :id");
                    $stmt->execute([
                        ':title' => $title,
                        ':slug' => $slug,
                        ':category' => $category,
                        ':category_slug' => $category_slug,
                        ':date' => $date,
                        ':author' => $author,
                        ':author_role' => $author_role,
                        ':author_avatar' => $author_avatar,
                        ':read_time' => $read_time,
                        ':image' => $imagePath,
                        ':excerpt' => $excerpt,
                        ':content' => $content,
                        ':status' => $status,
                        ':id' => $id
                    ]);
                    $successMsg = 'Blog post updated successfully!';
                } else {
                    // Insert
                    $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, category, category_slug, date, author, author_role, author_avatar, read_time, image, excerpt, content, status) VALUES (:title, :slug, :category, :category_slug, :date, :author, :author_role, :author_avatar, :read_time, :image, :excerpt, :content, :status)");
                    $stmt->execute([
                        ':title' => $title,
                        ':slug' => $slug,
                        ':category' => $category,
                        ':category_slug' => $category_slug,
                        ':date' => $date ?: date('M d, Y'),
                        ':author' => $author ?: 'Zenvora Team',
                        ':author_role' => $author_role ?: 'Compliance Editor',
                        ':author_avatar' => $author_avatar ?: 'assets/images/about_us.jpg',
                        ':read_time' => $read_time ?: '5 Min Read',
                        ':image' => $imagePath ?: 'assets/images/service_incorporation.jpg',
                        ':excerpt' => $excerpt,
                        ':content' => $content,
                        ':status' => $status
                    ]);
                    $successMsg = 'New blog post published successfully!';
                }
                $action = 'list';
            } catch (PDOException $e) {
                $errorMsg = 'Database Error: ' . $e->getMessage();
            }
        }
    }

    // 2. DELETE operation
    if (isset($_POST['delete_blog'])) {
        $id = (int)$_POST['id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $successMsg = 'Blog post deleted successfully!';
        } catch (PDOException $e) {
            $errorMsg = 'Database Error: ' . $e->getMessage();
        }
    }
}

// Fetch single blog for edit mode
$blogData = null;
if ($action === 'edit' && $blogId > 0 && $pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = :id");
        $stmt->execute([':id' => $blogId]);
        $blogData = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errorMsg = 'Failed to load blog data: ' . $e->getMessage();
    }
}

// Fetch all blogs
$blogsList = [];
if ($pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT * FROM blogs ORDER BY id DESC");
        $blogsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errorMsg = 'Failed to fetch blogs: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs | Zenvora Admin</title>
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
<body class="h-full font-sans antialiased text-slate-655 bg-slate-50 selection:bg-brand-500 selection:text-white">

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
                    <a href="testimonials_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400">
                        <i class="fa-solid fa-star text-sm"></i> <span class="whitespace-nowrap">Testimonials</span>
                    </a>
                    <a href="blog_manager.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 hover:text-white transition-all bg-brand-500/10 text-brand-400 border border-brand-500/20">
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
                    <span class="text-sm font-black text-slate-900 hidden sm:inline-block uppercase tracking-wider">Blog Manager</span>
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

                <?php if ($action === 'list'): ?>
                    <!-- List View -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-left space-y-1">
                            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Compliance Articles</h1>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Publish and manage knowledge base tutorials</p>
                        </div>
                        <a href="blog_manager.php?action=new" class="px-5 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-full text-xs font-black uppercase tracking-wider flex items-center gap-2 transition-colors">
                            <i class="fa-solid fa-file-pen text-sm"></i> Add New Blog Post
                        </a>
                    </div>

                    <!-- Blog items grid -->
                    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        <th class="px-6 py-4">Article Title</th>
                                        <th class="px-6 py-4">Category</th>
                                        <th class="px-6 py-4">Author Details</th>
                                        <th class="px-6 py-4">Publish Date</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-150 text-xs font-medium text-slate-655">
                                    <?php if (empty($blogsList)): ?>
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-semibold">
                                                <i class="fa-solid fa-folder-open text-2xl block mb-2 text-slate-350"></i>
                                                No blog posts available in the database.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($blogsList as $b): ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 space-y-1">
                                                <strong class="text-slate-900 font-extrabold text-sm block"><?php echo htmlspecialchars($b['title']); ?></strong>
                                                <span class="text-[10px] text-slate-400 font-semibold block">Slug: /<?php echo htmlspecialchars($b['slug']); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-block text-[9px] font-extrabold px-2.5 py-1 rounded bg-brand-500/10 text-brand-700 uppercase border border-brand-500/20">
                                                    <?php echo htmlspecialchars($b['category']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="font-bold text-slate-900 block"><?php echo htmlspecialchars($b['author']); ?></span>
                                                <span class="text-[10px] text-slate-400 block"><?php echo htmlspecialchars($b['author_role']); ?></span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500">
                                                <?php echo htmlspecialchars($b['date']); ?> <br>
                                                <span class="text-[10px] text-slate-400"><?php echo htmlspecialchars($b['read_time']); ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-wider <?php echo ($b['status'] === 'Published') ? 'bg-emerald-50 text-emerald-700 border border-emerald-500/20' : 'bg-slate-100 text-slate-600 border border-slate-200'; ?>">
                                                    <span class="w-1.5 h-1.5 rounded-full <?php echo ($b['status'] === 'Published') ? 'bg-emerald-500' : 'bg-slate-400'; ?>"></span>
                                                    <?php echo htmlspecialchars($b['status']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="blog_manager.php?action=edit&id=<?php echo $b['id']; ?>" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center border border-slate-250 transition-all text-xs" title="Edit Post">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?')" class="inline">
                                                        <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
                                                        <button type="submit" name="delete_blog" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-500 text-red-500 hover:text-white flex items-center justify-center border border-red-200/40 transition-all text-xs" title="Delete Post">
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

                <?php else: ?>
                    <!-- Edit/Create Form View -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-left space-y-1">
                            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                                <?php echo ($action === 'edit') ? 'Edit Blog Post' : 'New Blog Post'; ?>
                            </h1>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Configure metadata, thumbnail card, author details, and rich content</p>
                        </div>
                        <a href="blog_manager.php" class="px-4 py-2 border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-full text-xs font-bold uppercase tracking-wider transition-colors">
                            Back to List
                        </a>
                    </div>

                    <form action="blog_manager.php" method="POST" enctype="multipart/form-data" class="space-y-6 text-left">
                        <input type="hidden" name="id" value="<?php echo $blogData ? $blogData['id'] : 0; ?>">
                        <input type="hidden" name="existing_image" value="<?php echo $blogData ? htmlspecialchars($blogData['image']) : ''; ?>">

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                            <!-- Left: Meta columns -->
                            <div class="lg:col-span-8 space-y-6">
                                <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-3xl space-y-4">
                                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-widest border-b border-slate-150 pb-2">Article Data</h3>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Article Title</label>
                                            <input type="text" name="title" id="blog-title" required value="<?php echo $blogData ? htmlspecialchars($blogData['title']) : ''; ?>" class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Unique URL Slug</label>
                                            <input type="text" name="slug" id="blog-slug" required value="<?php echo $blogData ? htmlspecialchars($blogData['slug']) : ''; ?>" class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div class="sm:col-span-2 space-y-1">
                                            <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Select Article Category</label>
                                            <select name="blog_category_selection" class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700">
                                                <option value="Business Setup|startup" <?php echo ($blogData && $blogData['category_slug'] === 'startup') ? 'selected' : ''; ?>>Business Setup (Startup Registration)</option>
                                                <option value="Tax & GST|tax" <?php echo ($blogData && $blogData['category_slug'] === 'tax') ? 'selected' : ''; ?>>Tax & GST (Compliance & Audits)</option>
                                                <option value="Intellectual Property|licenses" <?php echo ($blogData && $blogData['category_slug'] === 'licenses') ? 'selected' : ''; ?>>Intellectual Property (Trademarks & Licenses)</option>
                                            </select>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Read Time Estimate</label>
                                            <input type="text" name="read_time" required placeholder="e.g. 5 Min Read" value="<?php echo $blogData ? htmlspecialchars($blogData['read_time']) : '5 Min Read'; ?>" class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Short Excerpt Summary (appear on cards)</label>
                                        <textarea name="excerpt" rows="2" required class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors resize-none"><?php echo $blogData ? htmlspecialchars($blogData['excerpt']) : ''; ?></textarea>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Article Content (HTML tags supported)</label>
                                        <textarea name="content" rows="12" required class="w-full text-xs font-medium px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors font-mono leading-relaxed"><?php echo $blogData ? htmlspecialchars($blogData['content']) : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Sidebar metadata -->
                            <div class="lg:col-span-4 space-y-6">
                                <div class="bg-white border border-slate-200 p-6 rounded-3xl space-y-4">
                                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-widest border-b border-slate-150 pb-2">Publish Settings</h3>
                                    
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Status</label>
                                        <select name="status" class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700">
                                            <option value="Published" <?php echo ($blogData && $blogData['status'] === 'Published') ? 'selected' : ''; ?>>Published</option>
                                            <option value="Draft" <?php echo ($blogData && $blogData['status'] === 'Draft') ? 'selected' : ''; ?>>Draft</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Publish Date Label</label>
                                        <input type="text" name="date" placeholder="e.g. July 29, 2026" value="<?php echo $blogData ? htmlspecialchars($blogData['date']) : date('F d, Y'); ?>" class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Blog Cover Image File</label>
                                        <input type="file" name="blog_image" class="w-full text-xs font-semibold px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                        <?php if ($blogData && $blogData['image']): ?>
                                            <div class="mt-2 text-left">
                                                <span class="text-[9px] font-bold text-slate-400 block uppercase mb-1">Current Thumbnail</span>
                                                <img src="../<?php echo htmlspecialchars($blogData['image']); ?>" class="w-full aspect-[16/10] object-cover rounded-xl border border-slate-200 max-h-36">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="bg-white border border-slate-200 p-6 rounded-3xl space-y-4">
                                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-widest border-b border-slate-150 pb-2">Author Settings</h3>
                                    
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Author Name</label>
                                        <input type="text" name="author" required value="<?php echo $blogData ? htmlspecialchars($blogData['author']) : 'Priyanka Sharma'; ?>" class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Author Role / Title</label>
                                        <input type="text" name="author_role" required value="<?php echo $blogData ? htmlspecialchars($blogData['author_role']) : 'Senior Legal Advisor'; ?>" class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Author Avatar Path</label>
                                        <input type="text" name="author_avatar" required value="<?php echo $blogData ? htmlspecialchars($blogData['author_avatar']) : 'assets/images/about_us.jpg'; ?>" class="w-full text-xs font-semibold px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors font-mono">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                            <a href="blog_manager.php" class="px-6 py-3 border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-full text-xs font-black uppercase tracking-wider transition-colors">
                                Cancel
                            </a>
                            <button type="submit" name="save_blog" class="px-8 py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-full text-xs font-black uppercase tracking-wider transition-colors">
                                Publish Post
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
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

        // Auto Slug Generation from Title
        const titleInput = document.getElementById('blog-title');
        const slugInput = document.getElementById('blog-slug');
        if (titleInput && slugInput) {
            titleInput.addEventListener('input', () => {
                if (titleInput.value) {
                    const generatedSlug = titleInput.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '') // remove special chars
                        .replace(/\s+/g, '-')        // replace spaces with hyphens
                        .replace(/-+/g, '-');        // replace multiple hyphens
                    slugInput.value = generatedSlug;
                }
            });
        }
    </script>
</body>
</html>
