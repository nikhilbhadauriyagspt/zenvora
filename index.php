<?php

/**
 * Zenvora Global Solutions - Main Entry Point
 * 
 * Root directory contains only this index.php. All other parts are split
 * into premium components inside the components/ directory.
 */

// Load HTML Head (Tailwind, Fonts, Meta Tags)
include_once 'components/head.php';

// Load Global Header Navigation
include_once 'components/header.php';
?>

<main class="min-h-screen">
    <?php
    // Load Hero Section
    include_once 'components/hero.php';
    ?>

    <?php
    // Load Core Highlights Section (3 advantage points)
    include_once 'components/highlights.php';
    ?>

    <?php
    // Load About Us Section (Organic Shape Image, Rich Background)
    include_once 'components/about.php';
    ?>
    <?php
    // Load Services Section (6 Categories, 38 Services)
    include_once 'components/services.php';
    ?>

    <?php
    // Load Moving Marquee Accent Divider
    include_once 'components/marquee-accent.php';
    ?>

    <?php
    // Load Process Section (Clean Flat Onboarding Steps)
    include_once 'components/process.php';
    ?>

    <?php
    // Load Global Platform Showcase Section (Interactive Dashboard Mockups)
    include_once 'components/platform.php';
    ?>
    <!-- 
    ========================================================================
    2. STATS & COMPLIANCE TIMELINE (To be moved to components/stats.php)
    ------------------------------------------------------------------------
    Layout Plan:
    - Step-by-step visual representation of onboarding.
    - Large high-contrast metric callouts.
    ========================================================================
    -->
    <?php
    // Load Why Choose Us Section (Interactive Accordion & Image Swap)
    include_once 'components/why-us.php';
    ?>

    <?php
    // Load Stats Section (Bento Grid Trust Metrics)
    include_once 'components/stats.php';
    ?>

    <?php
    // Load Testimonials Section (Clean 3-Column Reviews Grid)
    include_once 'components/testimonials.php';
    ?>

    <?php
    // Load Pricing Section (3-Tier Flat Spotlight Packages)
    include_once 'components/pricing.php';
    ?>

    <?php
    // Load FAQs Section (Clean 2-Column Accordion Directory)
    include_once 'components/faqs.php';
    ?>

    <?php
    // Load Contact & Enquiry Form Section
    include_once 'components/contact.php';
    ?>
</main>

<?php
// Load Global Footer Section (Multi-column links, fine print & corporate metadata)
include_once 'components/footer.php';
?>

</body>

</html>