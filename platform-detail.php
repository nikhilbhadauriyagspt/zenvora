<?php
/**
 * Standalone Platform Detail Page for Zenvora Global Solutions
 * Displays comprehensive details for international entity setups, global taxes, transfer pricing, etc.
 */
require_once 'components/db_connect.php';
require_once 'components/settings_helper.php';

// Validate and fetch the request card slug
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

$card = null;
if ($pdo !== null && $slug !== '') {
    try {
        $stmt = $pdo->prepare("SELECT * FROM platform_cards WHERE slug = :slug AND status = 'Active'");
        $stmt->execute([':slug' => $slug]);
        $card = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $card = null;
    }
}

if (!$card) {
    // If invalid slug, redirect back to home page
    header('Location: index.php');
    exit;
}

$points = explode("\n", str_replace("\r", "", $card['points']));

// Define custom SEO metadata variables for head.php inclusion (Automatic generation from platform card details)
$custom_page_title = htmlspecialchars($card['title']) . ' | Global Operations | Zenvora Global Solutions';
$custom_page_desc = htmlspecialchars($card['description']);
$custom_page_keys = htmlspecialchars($card['title']) . ', Global Operations, Compliance, Zenvora';
$custom_page_canonical = 'http://localhost/commanpro/platform-detail.php?slug=' . htmlspecialchars($card['slug']);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Load Head dependencies (Tailwind CDN, Fonts, Font Awesome) -->
    <?php include_once 'components/head.php'; ?>

    <!-- Premium CSS overrides for dynamic database content styling inside .prose container -->
    <style type="text/css">
        .prose h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
            letter-spacing: -0.025em;
        }
        .prose h4 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .prose p {
            font-size: 0.875rem;
            line-height: 1.625;
            color: #475569;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        .prose ul {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 1.5rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }
        .prose li {
            position: relative;
            padding-left: 1.5rem;
            font-size: 0.875rem;
            color: #334155;
            font-weight: 600;
        }
        .prose li::before {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 0.125rem;
            color: #bc8731;
            font-size: 0.75rem;
        }
        /* Static dark overrides for prose container */
        .prose h3 { color: #ffffff !important; }
        .prose h4 { color: #f1f5f9 !important; }
        .prose p { color: #94a3b8 !important; }
        .prose li { color: #cbd5e1 !important; }
    </style>
</head>

<body class="subpage-theme bg-white font-sans text-slate-600 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Global Header Navigation -->
    <?php include_once 'components/header.php'; ?>

    <main>
        
        <!-- Breadcrumb & Header Section (Matches Zenvora Header Design) -->
        <section class="py-16 bg-slate-50 border-b border-slate-100">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-left space-y-6">
                <!-- Back Link -->
                <a href="index.php#platform" class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-brand-600 hover:text-brand-500 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> Back to Global Operations
                </a>
                
                <div class="space-y-4">
                    <span class="inline-block text-[9px] font-black text-brand-700 bg-brand-500/10 border border-brand-500/20 px-3 py-1 rounded-full uppercase tracking-widest">
                        <?php echo htmlspecialchars($card['subtitle'] ?: 'International Operations'); ?>
                    </span>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                        <?php echo htmlspecialchars($card['title']); ?>
                    </h1>
                    <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold">
                        <?php echo htmlspecialchars($card['description']); ?>
                    </p>
                </div>
            </div>
        </section>

        <!-- Detailed Page Content Section -->
        <section class="py-20 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                    
                    <!-- Left Column: Rich Card Body Content (col-span-8) -->
                    <div class="lg:col-span-8 text-left space-y-8">
                        
                        <!-- Main Card Cover Image -->
                        <div class="w-full aspect-[21/9] bg-slate-100 rounded-3xl overflow-hidden border border-slate-200 shadow-sm">
                            <img src="<?php echo htmlspecialchars($card['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($card['title']); ?>" 
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Highlights checklist block -->
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-150">
                            <h4 class="text-xs font-extrabold uppercase tracking-widest text-slate-400 mb-4">Core Deliverables</h4>
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <?php foreach ($points as $pt): 
                                    if (trim($pt) === '') continue;
                                ?>
                                <li class="flex items-start gap-2.5 text-xs font-bold text-slate-700">
                                    <span class="w-5 h-5 rounded-full bg-brand-500/10 text-brand-500 flex items-center justify-center text-[10px] mt-0.5 flex-shrink-0"><i class="fa-solid fa-check"></i></span>
                                    <span><?php echo htmlspecialchars(trim($pt)); ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Rich Text HTML Content Block from Database -->
                        <div class="prose max-w-none text-slate-600 space-y-6 text-sm leading-relaxed">
                            <?php 
                            // Render HTML markup securely or as entered in admin panel
                            echo $card['detailed_content']; 
                            ?>
                        </div>

                    </div>

                    <!-- Right Column: Sidebar consultation Form (col-span-4) -->
                    <div class="lg:col-span-4 space-y-8">
                        
                        <!-- Side Form Box (Standard Zenvora Lead Capture) -->
                        <div class="bg-slate-50 border border-slate-200 p-6 sm:p-8 rounded-3xl text-left space-y-6">
                            <div class="space-y-1">
                                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-brand-500"></i> Advisory Call
                                </h3>
                                <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                                    Speak directly with our qualified CAs regarding <?php echo htmlspecialchars($card['title']); ?> setups.
                                </p>
                            </div>
                            
                            <form action="contact.php" method="POST" class="space-y-4">
                                <!-- Hidden inputs for tracking -->
                                <input type="hidden" name="source_page" value="Platform Detail: <?php echo htmlspecialchars($card['title']); ?>">
                                <input type="hidden" name="service" value="startup">
                                <input type="hidden" name="org_size" value="1">
                                <input type="hidden" name="timeline" value="immediately">
                                <input type="hidden" name="message" value="Requested consulting callback from platform detail page: <?php echo htmlspecialchars($card['title']); ?>">

                                <!-- Name -->
                                <div class="space-y-1">
                                    <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500 block">Your Name</label>
                                    <input type="text" name="name" required placeholder="Aarav Sharma" 
                                           class="w-full text-xs font-semibold px-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700">
                                </div>

                                <!-- Phone -->
                                <div class="space-y-1">
                                    <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500 block">Mobile Number</label>
                                    <input type="tel" name="phone" required placeholder="+91 99999 99999" 
                                           class="w-full text-xs font-semibold px-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700">
                                </div>

                                <!-- Email -->
                                <div class="space-y-1">
                                    <label class="text-[9px] font-extrabold uppercase tracking-widest text-slate-500 block">Email Address</label>
                                    <input type="email" name="email" required placeholder="aarav@company.com" 
                                           class="w-full text-xs font-semibold px-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700">
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="w-full text-center py-3.5 rounded-xl text-xs font-black text-white accent-gradient hover:shadow-lg hover:shadow-brand-500/25 transition-all duration-300">
                                    Book Advisory Callback
                                </button>
                            </form>
                        </div>

                        <!-- Sidebar Info Badge -->
                        <div class="p-6 rounded-3xl border border-dashed border-slate-200 text-left space-y-3">
                            <span class="text-[10px] font-black uppercase text-brand-600 tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-halved"></i> Zenvora SLA Guarantee
                            </span>
                            <p class="text-[11px] text-slate-450 leading-relaxed font-semibold">
                                Qualified Chartered Accountants supervise every stage of filing. Real-time portal check-ins and direct whatsapp escalation routes are provided with all active services.
                            </p>
                        </div>

                    </div>

                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer -->
    <?php include_once 'components/footer.php'; ?>

</body>

</html>
