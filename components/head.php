<?php
require_once __DIR__ . '/settings_helper.php';
require_once __DIR__ . '/db_connect.php';

// Dynamic SEO and Meta Tags Lookup from Database
$seo_title = 'Zenvora Global Solutions | Premium Legal, Tax & Compliance Partner';
$seo_desc = 'Zenvora Global Solutions is your premier partner for business setup, company registration, legal compliance, accounting, and growth services. Clean, modern, and compliant.';
$seo_keys = 'Company Registration, GST Filing, Trademark Registration, Bookkeeping, legal Compliance, Startup Consulting, Zenvora';
$seo_canonical = '';
$seo_schema = '';

// If custom parameters are already defined by the parent dynamic page (e.g. service-detail, blog-detail, platform-detail)
if (isset($custom_page_title)) {
    $seo_title = $custom_page_title;
}
if (isset($custom_page_desc)) {
    $seo_desc = $custom_page_desc;
}
if (isset($custom_page_keys)) {
    $seo_keys = $custom_page_keys;
}
if (isset($custom_page_canonical)) {
    $seo_canonical = $custom_page_canonical;
}
if (isset($custom_page_schema)) {
    $seo_schema = $custom_page_schema;
}

// Perform database lookup for static pages only if custom metadata is not set
if (!isset($custom_page_title) && !isset($custom_page_desc)) {
    $current_page_file = basename($_SERVER['PHP_SELF']);
    $page_seo_key = 'home';
    if ($current_page_file === 'about.php') {
        $page_seo_key = 'about';
    } elseif ($current_page_file === 'services.php') {
        $page_seo_key = 'services';
    } elseif ($current_page_file === 'contact.php') {
        $page_seo_key = 'contact';
    } elseif ($current_page_file === 'blog.php') {
        $page_seo_key = 'blog';
    } elseif ($current_page_file === 'faqs.php') {
        $page_seo_key = 'faqs';
    }

    if (isset($pdo) && $pdo !== null) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM page_seo WHERE page_key = :key");
            $stmt->execute([':key' => $page_seo_key]);
            $seo_data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($seo_data) {
                $seo_title = $seo_data['meta_title'];
                $seo_desc = $seo_data['meta_description'];
                if (!empty($seo_data['meta_keywords'])) {
                    $seo_keys = $seo_data['meta_keywords'];
                }
                if (!empty($seo_data['canonical_url'])) {
                    $seo_canonical = $seo_data['canonical_url'];
                }
                if (!empty($seo_data['schema_markup'])) {
                    $seo_schema = $seo_data['schema_markup'];
                }
            }
        } catch (Exception $e) {
            // Safe fallback
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($seo_title); ?></title>
    <link rel="icon" type="image/png" href="<?php echo htmlspecialchars(getWebSetting('favicon')); ?>">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo htmlspecialchars($seo_desc); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($seo_keys); ?>">

    <!-- Canonical URL Tag -->
    <?php if (!empty($seo_canonical)): ?>
        <link rel="canonical" href="<?php echo htmlspecialchars($seo_canonical); ?>">
    <?php endif; ?>

    <!-- JSON-LD Schema Markup -->
    <?php if (!empty($seo_schema)): ?>
        <script type="application/ld+json">
            <?php echo $seo_schema; ?>
        </script>
    <?php endif; ?>
    
    <!-- Google Fonts - Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN for premium vector icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Configuration matching the Gold and Slate brand colors -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fdfbf7',
                            100: '#f9f3e6',
                            200: '#f1e2c5',
                            300: '#e5ca97',
                            400: '#d7ac63',
                            500: '#bc8731', // Exact Gold from your logo
                            600: '#a36d26',
                            700: '#83521d',
                            800: '#693f18',
                            900: '#573316',
                            950: '#321c0b',
                        },
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['"Space Grotesk"', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(25px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Utilities styling (Scrollbar & backdrop fixes) -->
    <style type="text/css">
        /* SCOPED SUBPAGE STATIC DARK THEME (Matches Homepage Charcoal & Gold Theme) */
        .subpage-theme {
            background-color: #020617 !important; /* slate-950 */
            color: #cbd5e1 !important; /* slate-300 */
        }
        
        /* Force all main page sections on subpages to use slate-950 background */
        .subpage-theme main,
        .subpage-theme section,
        .subpage-theme section.bg-white,
        .subpage-theme section.bg-slate-50,
        .subpage-theme section.bg-slate-100,
        .subpage-theme section.bg-slate-900,
        .subpage-theme section.bg-gradient-to-br {
            background-color: #020617 !important;
            background-image: none !important;
            border-color: #1e293b !important; /* slate-800 border */
        }
        
        /* Headings color in dark mode (white) */
        .subpage-theme h1,
        .subpage-theme h2,
        .subpage-theme h3,
        .subpage-theme h4,
        .subpage-theme h5,
        .subpage-theme h6,
        .subpage-theme .text-slate-900,
        .subpage-theme .text-slate-800,
        .subpage-theme .text-slate-700 {
            color: #ffffff !important;
        }
        
        /* Secondary and Paragraph text in dark mode (slate-400) */
        .subpage-theme p,
        .subpage-theme li,
        .subpage-theme label,
        .subpage-theme .text-slate-500,
        .subpage-theme .text-slate-600,
        .subpage-theme .text-slate-650 {
            color: #94a3b8 !important; /* slate-400 */
        }
        
        /* Gold accent text colors (brand-400) */
        .subpage-theme .text-brand-500,
        .subpage-theme .text-brand-600,
        .subpage-theme .text-brand-700,
        .subpage-theme .text-brand-800,
        .subpage-theme .text-brand-900,
        .subpage-theme a.text-brand-600,
        .subpage-theme a.text-brand-700 {
            color: #d7ac63 !important; /* Gold */
        }
        
        /* Accents / Badges background (Gold / brand-500 with opacity) */
        .subpage-theme .bg-brand-500\/10,
        .subpage-theme .bg-brand-500\/20 {
            background-color: rgba(215, 172, 99, 0.1) !important;
            border-color: rgba(215, 172, 99, 0.2) !important;
            color: #d7ac63 !important;
        }

        /* Cards, inner blocks, and list containers (Slate-900 / Charcoal) */
        .subpage-theme .bg-white,
        .subpage-theme .bg-slate-50,
        .subpage-theme .bg-slate-100,
        .subpage-theme .bg-slate-50\/50,
        .subpage-theme .bg-slate-50\/40,
        .subpage-theme .bg-slate-50\/10,
        .subpage-theme .bg-slate-900 {
            background-color: #0f172a !important; /* slate-900 */
            border-color: #1e293b !important;
        }
        
        /* Inner items (e.g. image wrappers, inner grids) */
        .subpage-theme .bg-slate-100 {
            background-color: #020617 !important; /* slate-950 background for subcard/images */
        }
        
        /* Timeline connectors, borders, and dividers */
        .subpage-theme .bg-slate-200 {
            background-color: #1e293b !important; /* slate-800 border line */
        }
        .subpage-theme .border-slate-100,
        .subpage-theme .border-slate-200,
        .subpage-theme .border-slate-200\/50,
        .subpage-theme .border-slate-200\/55,
        .subpage-theme .border-slate-200\/60 {
            border-color: #1e293b !important;
        }
        
        /* Form inputs in dark mode */
        .subpage-theme input,
        .subpage-theme select,
        .subpage-theme textarea {
            background-color: #020617 !important;
            border-color: #1e293b !important;
            color: #f1f5f9 !important;
        }
        .subpage-theme input::placeholder,
        .subpage-theme textarea::placeholder {
            color: #475569 !important;
        }

        /* Custom Smooth thin Gold Scrollbar */
        html {
            scrollbar-width: thin;
            scrollbar-color: #bc8731 #090f1d;
        }
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
        ::-webkit-scrollbar-thumb:hover {
            background: #d7ac63;
        }

        /* Glassmorphism utility helpers in Dark Mode (matching brand/slate theme) */
        .glass-panel {
            background: rgba(9, 15, 29, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 40px -10px rgba(188, 135, 49, 0.15);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #0f172a 30%, #bc8731 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .accent-gradient {
            background: linear-gradient(135deg, #bc8731 0%, #d7ac63 100%);
        }

        /* Dynamic search section glow pulse */
        @keyframes sectionGlow {
            0%, 100% { outline: 0px solid transparent; box-shadow: none; }
            50% { outline: 4px solid #bc8731; box-shadow: 0 0 35px rgba(188, 135, 49, 0.5); }
        }
        .glow-section {
            animation: sectionGlow 2.5s ease-in-out forwards;
            border-radius: 1.5rem;
        }

        /* Hero Slider Ken Burns background zoom */
        @keyframes kenBurns {
            0% { transform: scale(1); }
            100% { transform: scale(1.06); }
        }
        .active-slide .hero-bg-img {
            animation: kenBurns 7.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        /* Staggered slide elements entry transitions */
        .carousel-slide .slide-badge {
            transform: translateY(12px);
            opacity: 0;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease;
            transition-delay: 100ms;
        }
        .carousel-slide .slide-title {
            transform: translateY(18px);
            opacity: 0;
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.7s ease;
            transition-delay: 220ms;
        }
        .carousel-slide .slide-points {
            transform: translateY(22px);
            opacity: 0;
            transition: transform 0.75s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.75s ease;
            transition-delay: 350ms;
        }
        .carousel-slide .slide-buttons {
            transform: translateY(25px);
            opacity: 0;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.8s ease;
            transition-delay: 480ms;
        }

        /* Trigger animations when slide becomes active */
        .carousel-slide.active-slide .slide-badge,
        .carousel-slide.active-slide .slide-title,
        .carousel-slide.active-slide .slide-points,
        .carousel-slide.active-slide .slide-buttons {
            transform: translateY(0);
            opacity: 1;
        }
    </style>

    <!-- Google Search Console Verification Meta Tag -->
    <?php 
    $gsc_code = getWebSetting('seo_search_console');
    if (!empty($gsc_code)) {
        echo $gsc_code . "\n";
    }
    ?>

    <!-- Google Analytics Tracking Script -->
    <?php 
    $ga_code = getWebSetting('seo_google_analytics');
    if (!empty($ga_code)) {
        echo $ga_code . "\n";
    }
    ?>

    <!-- Custom Head Additional Scripts -->
    <?php 
    $custom_head = getWebSetting('seo_custom_head');
    if (!empty($custom_head)) {
        echo $custom_head . "\n";
    }
    ?>
</head>
<body class="bg-slate-50 text-slate-800 font-sans selection:bg-brand-100 selection:text-brand-900 overflow-x-hidden">
