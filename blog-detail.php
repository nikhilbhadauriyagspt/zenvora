<?php
// Standalone Blog Detail Page for Zenvora Global Solutions
require_once 'components/db_connect.php';
require_once 'components/settings_helper.php';

// Validate and fetch the request blog ID
$blogId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$blog = null;
$blogs = [];
if ($pdo !== null) {
    try {
        if ($blogId > 0) {
            $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = :id AND status = 'Published'");
            $stmt->execute([':id' => $blogId]);
            $blog = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $stmtAll = $pdo->query("SELECT * FROM blogs WHERE status = 'Published' ORDER BY id DESC LIMIT 5");
        $blogs = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Fallback
    }
}

if (!$blog) {
    // If invalid ID, redirect back to blogs catalog page
    header('Location: blog.php');
    exit;
}

// Define custom SEO metadata variables for head.php inclusion (Automatic generation from blog details)
$custom_page_title = htmlspecialchars($blog['title']) . ' | Zenvora Blog';
$custom_page_desc = htmlspecialchars($blog['excerpt']);
$custom_page_keys = htmlspecialchars($blog['category']) . ', Blog, Zenvora';
$custom_page_canonical = 'http://localhost/commanpro/blog-detail.php?id=' . (int)$blog['id'];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Load Head dependencies (Tailwind CDN, Fonts, Font Awesome) -->
    <?php include_once 'components/head.php'; ?>
</head>

<body class="subpage-theme bg-white font-sans text-slate-600 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Global Header Navigation -->
    <?php include_once 'components/header.php'; ?>

    <main>
        
        <!-- Breadcrumb & Header Section -->
        <section class="py-12 bg-slate-50 border-b border-slate-100">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-left space-y-6">
                <!-- Back Link -->
                <a href="blog.php" class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-brand-600 hover:text-brand-500 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> Back to all articles
                </a>
                
                <div class="space-y-4">
                    <span class="inline-block text-[9px] font-black text-brand-700 bg-brand-500/10 border border-brand-500/20 px-3 py-1 rounded-full uppercase tracking-wider">
                        <?php echo htmlspecialchars($blog['category']); ?>
                    </span>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                        <?php echo htmlspecialchars($blog['title']); ?>
                    </h1>
                </div>

                <!-- Author Row -->
                <div class="flex flex-wrap items-center gap-6 pt-4 border-t border-slate-200">
                    <div class="flex items-center gap-3">
                        <img src="<?php echo htmlspecialchars($blog['author_avatar']); ?>" 
                             alt="<?php echo htmlspecialchars($blog['author']); ?>" 
                             class="w-10 h-10 rounded-full object-cover border border-slate-200">
                        <div>
                            <span class="text-xs font-extrabold text-slate-900 block leading-tight"><?php echo htmlspecialchars($blog['author']); ?></span>
                            <span class="text-[10px] text-slate-400 font-bold block mt-0.5"><?php echo htmlspecialchars($blog['author_role']); ?></span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-[11px] text-slate-400 font-bold ml-0 sm:ml-auto">
                        <span><i class="fa-solid fa-calendar mr-1.5 text-slate-350"></i><?php echo htmlspecialchars($blog['date']); ?></span>
                        <span class="hidden sm:inline text-slate-200">|</span>
                        <span><i class="fa-solid fa-clock mr-1.5 text-slate-350"></i><?php echo htmlspecialchars($blog['read_time']); ?></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Article Content Section (No Shadows) -->
        <section class="py-16 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                    
                    <!-- Left Column: Rich Article Body (col-span-8) -->
                    <article class="lg:col-span-8 text-left space-y-6">
                        <!-- Featured Image Cover -->
                        <div class="w-full aspect-[21/9] bg-slate-100 rounded-3xl overflow-hidden mb-10 border border-slate-200">
                            <img src="<?php echo htmlspecialchars($blog['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($blog['title']); ?>" 
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Render Rich Content -->
                        <div class="prose max-w-none">
                            <?php echo $blog['content']; ?>
                        </div>
                    </article>

                    <!-- Right Column: Sidebar (col-span-4, sticky, no shadows) -->
                    <aside class="lg:col-span-4 space-y-8 text-left lg:sticky lg:top-24">
                        
                        <!-- Author Detail Card -->
                        <div class="bg-slate-50/50 border border-slate-200 p-6 rounded-3xl space-y-4">
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block">Author Profile</span>
                            <div class="flex items-center gap-3">
                                <img src="<?php echo htmlspecialchars($blog['author_avatar']); ?>" 
                                     alt="<?php echo htmlspecialchars($blog['author']); ?>" 
                                     class="w-12 h-12 rounded-full object-cover border border-slate-200">
                                <div>
                                    <h4 class="text-sm font-extrabold text-slate-900"><?php echo htmlspecialchars($blog['author']); ?></h4>
                                    <span class="text-[10px] text-brand-600 font-extrabold uppercase tracking-wider block mt-0.5"><?php echo htmlspecialchars($blog['author_role']); ?></span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed font-semibold">
                                Qualified advisor managing corporate compliance registries, accounting systems, and regulatory filings for Zenvora startups.
                            </p>
                            <a href="contact.php" class="inline-flex items-center justify-center gap-1.5 w-full text-center py-2.5 rounded-full text-xs font-black text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                                <i class="fa-solid fa-phone text-[10px]"></i> Speak with Advisor
                            </a>
                        </div>

                        <!-- Other Related Articles -->
                        <div class="bg-slate-50/50 border border-slate-200 p-6 rounded-3xl space-y-4">
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block">Recent Insights</span>
                            <div class="space-y-4 divide-y divide-slate-200">
                                <?php 
                                $count = 0;
                                foreach ($blogs as $item): 
                                    if ($item['id'] !== $blog['id'] && $count < 2):
                                        $count++;
                                ?>
                                    <div class="pt-4 first:pt-0 space-y-2">
                                        <span class="text-[9px] font-extrabold text-brand-600 uppercase tracking-wider block">
                                            <?php echo htmlspecialchars($item['category']); ?>
                                        </span>
                                        <h5 class="text-xs font-extrabold text-slate-900 leading-snug hover:text-brand-500 transition-colors">
                                            <a href="blog-detail.php?id=<?php echo $item['id']; ?>">
                                                <?php echo htmlspecialchars($item['title']); ?>
                                            </a>
                                        </h5>
                                        <span class="text-[9px] text-slate-400 font-bold block"><?php echo htmlspecialchars($item['date']); ?></span>
                                    </div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        </div>

                        <!-- Live Support Call Card -->
                        <div class="bg-brand-500/5 border border-brand-500/20 p-6 rounded-3xl space-y-4">
                            <span class="text-[9px] font-extrabold text-brand-700 uppercase tracking-widest block">Need Direct Help?</span>
                            <h4 class="text-sm font-extrabold text-slate-900">Need specific legal consultation?</h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-semibold">
                                Get in touch with our advisory desk. Our CAs will guide you in under 15 minutes.
                            </p>
                            <a href="tel:<?php echo getWebSetting('phone_1'); ?>" class="inline-flex items-center justify-center gap-1.5 w-full text-center py-2.5 rounded-full text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 transition-colors">
                                <i class="fa-solid fa-phone text-brand-500"></i> Call Support
                            </a>
                        </div>

                    </aside>

                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer Navigation -->
    <?php include_once 'components/footer.php'; ?>

</body>

</html>
