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

$defaultSettings = [
    'logo_url' => 'assets/images/logo/Zenvora_Global_Solutions_Logo.png',
    'favicon' => 'assets/images/logo/Zenvora_Global_Solutions_Logo.png',
    'phone_numbers' => json_encode($defaultPhones),
    'office_addresses' => json_encode($defaultAddresses),
    'email_1' => 'support@zenvora.in',
    'email_2' => 'info@zenvora.in',
    'map_iframe' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.562145326574!2d77.36214627632616!3d28.612911975674393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce561a0f9b3bb%3A0xe1068800b46ebf45!2sThe%20iThum!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin',
    'working_hours' => 'Mon - Sat: 9:00 AM - 7:00 PM (IST)',
    'whatsapp_number' => '+91 98765 43210',
    'homepage_hero_slides' => json_encode($defaultSlides),
    
    'badge_mca' => 'MCA Approved',
    'badge_gst' => 'GSTN Network',
    'badge_msme' => 'MSME Board',
    'badge_dpiit' => 'DPIIT (Startup India)',
    'badge_fssai' => 'FSSAI Authority'
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
