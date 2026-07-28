<?php
/**
 * Zenvora Global Solutions - Web Settings Helper
 * This helper loads global configurations from the database
 * with fallback support for offline/demo development modes.
 */

$dbPath = __DIR__ . '/db_connect.php';
if (file_exists($dbPath)) {
    require_once $dbPath;
}

$defaultPhones = [
    ["label" => "Noida HQ Hotline", "value" => "+91 98765 43210", "visible" => 1],
    ["label" => "Advisory Desk", "value" => "+91 99999 88888", "visible" => 1]
];

$defaultAddresses = [
    ["label" => "Noida HQ", "value" => "Office Suite 508, Block A, The iThum Towers, Sector 62, Noida, Uttar Pradesh - 201301", "visible" => 1],
    ["label" => "Mumbai Desk", "value" => "Maker Chambers V, Nariman Point, Mumbai, Maharashtra - 400021", "visible" => 1],
    ["label" => "Bengaluru Desk", "value" => "Brigade Road, Ashok Nagar, Bengaluru, Karnataka - 560025", "visible" => 1],
    ["label" => "Hyderabad Desk", "value" => "Jubilee Hills, Road No. 36, Hyderabad, Telangana - 500033", "visible" => 1]
];

$defaultSlides = [
    [
        "badge" => "Business Startup",
        "title" => "Launch Your Venture <br> <span class=\"text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400\">With Expert Setup.</span>",
        "image" => "assets/images/hero_bg.jpg",
        "btn1_text" => "Book Free Call",
        "btn1_url" => "#contact",
        "btn2_text" => "View Startup Packages",
        "btn2_url" => "#services",
        "visible" => 1,
        "p1_icon" => "fa-solid fa-building", "p1_title" => "Pvt Ltd & LLP", "p1_desc" => "Incorporation in 7-10 days with direct MCA name approvals.",
        "p2_icon" => "fa-solid fa-user-tie", "p2_title" => "One Person Company", "p2_desc" => "Perfect setup for solo founders looking for limited liability.",
        "p3_icon" => "fa-solid fa-user-group", "p3_title" => "Partnership & Proprietor", "p3_desc" => "Firm setups and proprietorship registrations done online."
    ],
    [
        "badge" => "Permits & Registrations",
        "title" => "Registrations & Licenses <br> <span class=\"text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400\">For Safe Operations.</span>",
        "image" => "assets/images/hero_bg_4.jpg",
        "btn1_text" => "Book Free Call",
        "btn1_url" => "#contact",
        "btn2_text" => "View Permits Checklist",
        "btn2_url" => "#services",
        "visible" => 1,
        "p1_icon" => "fa-solid fa-receipt", "p1_title" => "GST & MSME", "p1_desc" => "Tax registrations and MSME Udyam certificates set up inside 24 hours.",
        "p2_icon" => "fa-solid fa-utensils", "p2_title" => "FSSAI Food License", "p2_desc" => "Basic, state, and central food safety registry compliance handled.",
        "p3_icon" => "fa-solid fa-shop", "p3_title" => "Shop Act & Trade", "p3_desc" => "Municipal trade permissions and state establishment licenses."
    ],
    [
        "badge" => "Brand Protection",
        "title" => "Secure Your Identity <br> <span class=\"text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400\">With Trademark Filings.</span>",
        "image" => "assets/images/hero_bg_3.jpg",
        "btn1_text" => "Book Free Call",
        "btn1_url" => "#contact",
        "btn2_text" => "Check TM Availability",
        "btn2_url" => "#services",
        "visible" => 1,
        "p1_icon" => "fa-solid fa-registered", "p1_title" => "Trademark Registry", "p1_desc" => "Brand name and logo filings with immediate TM application receipt.",
        "p2_icon" => "fa-solid fa-copyright", "p2_title" => "Copyright Registry", "p2_desc" => "Secure legal rights for your original software, creative codes, and designs.",
        "p3_icon" => "fa-solid fa-shield-halved", "p3_title" => "Patent Filings", "p3_desc" => "Invention disclosure checks and provisional patent drafting services."
    ],
    [
        "badge" => "Tax & Compliance",
        "title" => "Outsource Your Filings <br> <span class=\"text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400\">To Chartered Accountants.</span>",
        "image" => "assets/images/hero_bg_2.jpg",
        "btn1_text" => "Book Free Call",
        "btn1_url" => "#contact",
        "btn2_text" => "Get Tax Estimate",
        "btn2_url" => "#services",
        "visible" => 1,
        "p1_icon" => "fa-solid fa-percent", "p1_title" => "GST Filings", "p1_desc" => "Monthly and quarterly returns filed with absolute input tax credit matching.",
        "p2_icon" => "fa-solid fa-scale-balanced", "p2_title" => "ROC Filings & Accounts", "p2_desc" => "Annual MCA returns, auditor audits, and board resolution listings.",
        "p3_icon" => "fa-solid fa-wallet", "p3_title" => "Income Tax Return", "p3_desc" => "Corporate and personal ITR filings with complete tax deduction optimizations."
    ],
    [
        "badge" => "NGO & Trust",
        "title" => "Register Your Trust <br> <span class=\"text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400\">Section 8 & Societies.</span>",
        "image" => "assets/images/hero_bg_5.jpg",
        "btn1_text" => "Book Free Call",
        "btn1_url" => "#contact",
        "btn2_text" => "Register Non-Profit",
        "btn2_url" => "#services",
        "visible" => 1,
        "p1_icon" => "fa-solid fa-hands-holding-child", "p1_title" => "Section 8 Company", "p1_desc" => "Non-profit company registrations with MCA and NITI Aayog registration.",
        "p2_icon" => "fa-solid fa-scroll", "p2_title" => "Trust & Society", "p2_desc" => "NGO registrations and charitable trust creation deeds online.",
        "p3_icon" => "fa-solid fa-stamp", "p3_title" => "12A, 80G & CSR", "p3_desc" => "Tax exemptions for trust donors and GeM NGO registration."
    ]
];

$defaultTestimonials = [
    [
        'initials' => 'AM',
        'name' => 'Aarav Mehta',
        'role' => 'Founder, Zephyr Logistics',
        'review' => 'Zenvora got our Private Limited incorporation and trade licenses sorted in exactly 8 days. Direct WhatsApp access to our assigned CA made the entire paperwork process completely effortless.',
        'rating' => 5
    ],
    [
        'initials' => 'NS',
        'name' => 'Neha Sharma',
        'role' => 'Co-Founder, Vedic Retail',
        'review' => 'We outsourced our monthly GST return filings and corporate accounting to Zenvora. Their fixed upfront billing and clean document management saved us from penalty surcharges entirely.',
        'rating' => 5
    ],
    [
        'initials' => 'VA',
        'name' => 'Vikram Aditya',
        'role' => 'Director, Dune Tech Solutions',
        'review' => 'Applied for our trademark registration and ISO certification through Zenvora. The process was 100% digital, and we received our TM application number code in under 24 hours.',
        'rating' => 5
    ]
];

$defaultSettings = [
    'logo_url' => 'assets/images/logo/Zenvora_Global_Solutions_Logo.png',
    'favicon' => 'assets/images/logo/Zenvora_Global_Solutions_Logo.png',
    'phone_numbers' => json_encode($defaultPhones),
    'homepage_testimonials' => json_encode($defaultTestimonials),
    'office_addresses' => json_encode($defaultAddresses),
    'email_1' => 'support@zenvora.in',
    'email_2' => 'info@zenvora.in',
    'phone_1' => '+91 98765 43210',
    'address_noida' => 'Office Suite 508, Block A, The iThum Towers, Sector 62, Noida, Uttar Pradesh - 201301',
    'map_iframe' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.562145326574!2d77.36214627632616!3d28.612911975674393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce561a0f9b3bb%3A0xe1068800b46ebf45!2sThe%20iThum!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin',
    'working_hours' => 'Mon - Sat: 9:00 AM - 7:00 PM (IST)',
    'whatsapp_number' => '+91 98765 43210',
    'homepage_hero_slides' => json_encode($defaultSlides),
    
    'badge_mca' => 'MCA Approved',
    'badge_gst' => 'GSTN Network',
    'badge_msme' => 'MSME Board',
    'badge_dpiit' => 'DPIIT (Startup India)',
    'badge_fssai' => 'FSSAI Authority',
    
    'social_facebook' => '#',
    'social_twitter' => '#',
    'social_linkedin' => '#',
    'social_instagram' => '#',
    'social_youtube' => '#',

    // Dynamic About Us Page Settings
    'about_hero_title' => 'We Are Redefining <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Compliance Infrastructure.</span>',
    'about_hero_subtitle' => 'Zenvora replaces slow legal delays with streamlined, digitized compliance pipelines. We empower modern founders to scale legally without a dedicated in-house compliance team.',
    'about_purpose_badge' => 'Our Purpose',
    'about_purpose_title' => 'Built for finance teams operating internationally.',
    'about_purpose_image' => 'assets/images/hero_illustration.jpg',
    'about_purpose_desc' => 'Founded in 2018, Zenvora Global Solutions began with a simple belief: registering a company, filing taxes, and managing global subsidiaries shouldn\'t require weeks of document exchanges and confusing government portals.',
    'about_vision_icon' => 'fa-solid fa-eye',
    'about_vision_title' => 'Our Vision',
    'about_vision_desc' => 'To create a global operations platform that handles entity management, indirect tax, and transfer pricing across all jurisdictions automatically.',
    'about_mission_icon' => 'fa-solid fa-compass',
    'about_mission_title' => 'Our Mission',
    'about_mission_desc' => 'To provide transparent pricing, rapid MCA name approvals, and direct access to qualified CAs for maximum filing accuracy.',
    'about_timeline_badge' => 'Our Timeline',
    'about_timeline_title' => 'How We Grew to Support 1,200+ Startups',
    'about_timeline_desc' => 'A quick look at Zenvora\'s milestone milestones and structural expansion.',
    'about_timeline_milestones' => json_encode([
        ["year" => "2018", "title" => "Noida HQ Establishment", "desc" => "Zenvora was incorporated at Noida, UP, starting as a traditional boutique advisory firm with a panel of 3 Chartered Accountants and 2 corporate lawyers."],
        ["year" => "2020", "title" => "Digitization of MCA Pipelines", "desc" => "Launched our digital documents dashboard. Allowed clients to upload KYC records and track name approvals online, shortening company setups to under 10 days."],
        ["year" => "2023", "title" => "Global Infrastructure Expansion", "desc" => "Scaled entity registration and indirect tax services (VAT/GST filing) across 70+ countries. Formed dedicated desks for Transfer Pricing and international subsidiaries."],
        ["year" => "2026", "title" => "Supporting 1,200+ Startups", "desc" => "Zenvora is recognized as one of India's fastest-growing digital compliance partners for high-growth tech firms, with a legal network of 45+ professionals."]
    ]),
    'about_accreditations_badge' => 'Accreditations',
    'about_accreditations_title' => 'Verified and Fully Compliant Infrastructure',
    'about_accreditations_desc' => 'Zenvora is recognized and approved by key regulatory authorities and bodies to coordinate national and global filings safely.',
    'about_accreditations_badges' => json_encode([
        ["title" => "MCA Approved", "icon" => "fa-solid fa-building-shield"],
        ["title" => "DPIIT Partner", "icon" => "fa-solid fa-stamp"],
        ["title" => "GSTN Authorized", "icon" => "fa-solid fa-receipt"],
        ["title" => "ISO 9001:2015", "icon" => "fa-solid fa-ribbon"],
        ["title" => "MSME Registered", "icon" => "fa-solid fa-circle-check"]
    ]),
    'about_tech_badge' => 'Our Stack',
    'about_tech_title' => 'Software Engineered for Corporate Oversight',
    'about_tech_desc' => 'Unlike traditional offline consultants, we replace friction with software pipelines to give you real-time visibility.',
    'about_tech_features' => json_encode([
        ["title" => "Encrypted Document Vault", "desc" => "Manage and access company formation deeds, share certificates, and director DSC keys safely in your secure cloud vault backed by bank-grade encryption.", "icon" => "fa-solid fa-vault"],
        ["title" => "Proactive Compliance Alerts", "desc" => "Our platform tracks filing dates for ROC, GST returns, and TDS deposits, automatically alerting you and our CA team well ahead of deadlines.", "icon" => "fa-solid fa-bell"],
        ["title" => "Itemized Cost Transparency", "desc" => "Every single government fee challan and professional service receipt is uploaded directly to your ledger to eliminate unannounced surcharges.", "icon" => "fa-solid fa-list-check"]
    ]),
    'about_values_badge' => 'Core values',
    'about_values_title' => 'Built on absolute trust.',
    'about_values_list' => json_encode([
        ["title" => "Absolute Transparency", "desc" => "No hidden professional charges. Every government challan, registration receipt, and MCA fee filing is uploaded directly to your panel for absolute audit trails.", "icon" => "fa-solid fa-scale-balanced"],
        ["title" => "Execution Speed", "desc" => "Your filings are processed through digital conduits. We secure PAN/TAN allocations in 2 days and deliver final MCA incorporation certificates in under 7 days.", "icon" => "fa-solid fa-gauge-high"],
        ["title" => "Direct CA Supervision", "desc" => "Every compliance return, trademark application, and subsidy claim is reviewed and signed off by qualified Chartered Accountants and CS professionals.", "icon" => "fa-solid fa-user-shield"]
    ]),
    'about_advisors_badge' => 'Corporate Panel',
    'about_advisors_title' => 'Advisors Who Understand Startup Scaling',
    'about_advisors_list' => json_encode([
        ["name" => "Priyanka Sharma", "role" => "Senior Startup Legal Advisor", "desc" => "Directs legal formation frameworks, shareholder agreements, and DPIIT tax exemption approvals for tech startups.", "image" => "assets/images/about_us.jpg"],
        ["name" => "Tushar Sudheesh", "role" => "Managing CFO Partner", "desc" => "Qualified Chartered Accountant managing corporate auditing, monthly accounting systems, and global taxation filings.", "image" => "assets/images/hero_bg.jpg"],
        ["name" => "Aditya Varma", "role" => "Senior IP & Trademark Counsel", "desc" => "Trademark attorney managing patent searches, brand registrations, municipal licensing, and labor law filings.", "image" => "assets/images/hero_bg_3.jpg"]
    ]),
    'about_cta_title' => 'Ready to streamline your legal compliance?',
    'about_cta_desc' => 'Get in touch with Priyanka or Tushar to schedule a free 15-minute consultation. We\'ll map out your custom compliance roadmap.',
    'about_cta_btn_text' => 'Book Free Consultation Call',
    'about_cta_btn_url' => 'contact.php',

    // Dynamic Stats Settings
    'stat_ops_count' => '1,200+',
    'stat_ops_label' => 'Startups incorporated and legally compliant across India.',
    'stat_accuracy_count' => '99.8%',
    'stat_accuracy_label' => 'Compliance SLA success rate with zero late-fee liabilities.',
    'stat_panel_count' => '45+',
    'stat_panel_label' => 'Chartered Accountants, Lawyers & CSs at your service.',
    'stat_speed_count' => '24 Hours',
    'stat_speed_label' => 'Average turnaround time for company name approvals and filings.'
];

$webSettings = $defaultSettings;

if (isset($pdo) && $pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM settings");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $webSettings[$row['setting_key']] = $row['setting_value'];
        }
    } catch (PDOException $e) {
        // Fallback remains
    }
}

/**
 * Retrieve dynamic website setting.
 */
function getWebSetting($key) {
    global $webSettings;
    return $webSettings[$key] ?? '';
}

/**
 * Get only visible phone numbers.
 * @return array
 */
function getWebPhones() {
    $json = getWebSetting('phone_numbers');
    $phones = json_decode($json, true);
    if (!is_array($phones)) {
        global $defaultPhones;
        return $defaultPhones;
    }
    return array_filter($phones, function($p) {
        return isset($p['visible']) && ($p['visible'] == 1 || $p['visible'] === true || $p['visible'] === 'true');
    });
}

/**
 * Get only visible office addresses.
 * @return array
 */
function getWebAddresses() {
    $json = getWebSetting('office_addresses');
    $addresses = json_decode($json, true);
    if (!is_array($addresses)) {
        global $defaultAddresses;
        return $defaultAddresses;
    }
    return array_filter($addresses, function($a) {
        return isset($a['visible']) && ($a['visible'] == 1 || $a['visible'] === true || $a['visible'] === 'true');
    });
}

/**
 * Get only visible hero slides.
 * @return array
 */
function getWebSlides() {
    $json = getWebSetting('homepage_hero_slides');
    $slides = json_decode($json, true);
    if (!is_array($slides)) {
        global $defaultSlides;
        return $defaultSlides;
    }
    return array_filter($slides, function($s) {
        return isset($s['visible']) && ($s['visible'] == 1 || $s['visible'] === true || $s['visible'] === 'true');
    });
}
