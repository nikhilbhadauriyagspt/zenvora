<?php
/**
 * Zenvora Global Solutions - Database Initializer
 * Open this page in your browser (e.g., http://localhost/commanpro/admin/db_init.php)
 * to automatically create the database and tables.
 */

$host = 'localhost';
$username = 'root';
$password = ''; // Default Laragon setting is empty password

try {
    // 1. Connect to MySQL without specifying a database
    $conn = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 2. Create the Database if not exists
    $conn->exec("CREATE DATABASE IF NOT EXISTS zenvora_db CHARACTER SET utf8 COLLATE utf8_general_ci");
    $conn->exec("USE zenvora_db");
    
    // 3. Create Users Table
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL,
        role VARCHAR(20) DEFAULT 'admin',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    
    // 4. Create Enquiries Table
    $conn->exec("CREATE TABLE IF NOT EXISTS enquiries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        email VARCHAR(100) NOT NULL,
        service VARCHAR(50) NOT NULL,
        org_size VARCHAR(50) NOT NULL,
        timeline VARCHAR(50) NOT NULL,
        message TEXT,
        status VARCHAR(20) DEFAULT 'Pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    // 5. Create Settings Table for Dynamic Frontend
    $conn->exec("CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(50) UNIQUE NOT NULL,
        setting_value TEXT NOT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    
    // 6. Insert default Admin User if not exists
    $checkAdmin = $conn->prepare("SELECT id FROM users WHERE username = 'admin'");
    $checkAdmin->execute();
    if (!$checkAdmin->fetch()) {
        $hashedPassword = password_hash('adminpassword', PASSWORD_DEFAULT);
        $insertAdmin = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES ('admin', :pass, 'admin@zenvora.in', 'admin')");
        $insertAdmin->execute([':pass' => $hashedPassword]);
    }
    
    // 7. Establish default dynamic arrays
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

    // Build default dynamic Slides JSON
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
        
        // Let's also restore the general government badges keys
        'badge_mca' => 'MCA Approved',
        'badge_gst' => 'GSTN Network',
        'badge_msme' => 'MSME Board',
        'badge_dpiit' => 'DPIIT (Startup India)',
        'badge_fssai' => 'FSSAI Authority'
    ];

    // Clean up older flat text keys to keep settings table lean
    $conn->exec("DELETE FROM settings WHERE setting_key IN (
        'hero_title', 'hero_subtitle', 'highlight_1_title', 'highlight_1_desc', 'highlight_2_title', 'highlight_2_desc', 
        'highlight_3_title', 'highlight_3_desc', 'about_title', 'about_desc', 'process_title', 'process_step_1_title', 
        'process_step_1_desc', 'process_step_2_title', 'process_step_2_desc', 'process_step_3_title', 'process_step_3_desc', 
        'process_step_4_title', 'process_step_4_desc', 'why_title', 'why_1_title', 'why_1_desc', 'why_2_title', 'why_2_desc', 
        'why_3_title', 'why_3_desc', 'why_4_title', 'why_4_desc', 'stats_title', 'pricing_title'
    )");
    
    // Insert/update settings
    $insertSetting = $conn->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE id=id");
    foreach ($defaultSettings as $key => $val) {
        $insertSetting->execute([$key, $val]);
    }
    
    // 8. Insert sample enquiries if empty
    $checkEnquiries = $conn->prepare("SELECT id FROM enquiries LIMIT 1");
    $checkEnquiries->execute();
    if (!$checkEnquiries->fetch()) {
        $sampleData = [
            [
                'Rohan Mehta', 
                '+91 98123 45678', 
                'rohan@mehtatech.co', 
                'startup', 
                '2-10', 
                '30days', 
                'Looking to register a Private Limited company with 3 directors in Noida. Need help with GST registration too.', 
                'Pending'
            ],
            [
                'Ananya Iyer', 
                '+91 99887 76655', 
                'contact@iyerfoods.in', 
                'licenses', 
                '1', 
                'immediately', 
                'We are launching a cloud kitchen in Bengaluru. We need a basic FSSAI license and shop act registration ASAP.', 
                'In Progress'
            ],
            [
                'Siddharth Verma', 
                '+91 98765 01234', 
                'sid@vermagroup.org', 
                'tax', 
                '50+', 
                'justexploring', 
                'Need outsourced corporate accounting and monthly ROC filings for our group company.', 
                'Resolved'
            ]
        ];
        
        $insertQuery = $conn->prepare("INSERT INTO enquiries (name, phone, email, service, org_size, timeline, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($sampleData as $row) {
            $insertQuery->execute($row);
        }
    }
    
    // Render Success Interface
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Database Setup | Zenvora Global Solutions</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Space Grotesk', sans-serif; }
        </style>
    </head>
    <body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 selection:bg-brand-500 selection:text-white">
        <div class="w-full max-w-md bg-white border border-slate-200 p-8 rounded-3xl text-center space-y-6">
            <!-- Icon -->
            <div class="w-16 h-16 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-3xl mx-auto border border-amber-500/20">
                🚀
            </div>
            
            <div class="space-y-2">
                <h2 class="text-2xl font-black text-slate-900">Database Configured!</h2>
                <p class="text-xs text-slate-550 font-semibold leading-relaxed">
                    Database `zenvora_db` has been successfully upgraded to support dynamic lists for sliders and web settings.
                </p>
            </div>

            <!-- Credentials Box -->
            <div class="bg-slate-50 border border-slate-200 p-5 rounded-2xl text-left space-y-2">
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block">Admin Access</span>
                <div class="text-xs font-semibold text-slate-700 space-y-1">
                    <div><span class="text-slate-400">Username:</span> <strong class="text-slate-950">admin</strong></div>
                    <div><span class="text-slate-400">Password:</span> <strong class="text-slate-950">adminpassword</strong></div>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-2">
                <a href="login.php" class="block w-full text-center py-3.5 rounded-full text-xs font-black text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                    Proceed to Login Screen
                </a>
            </div>
        </div>
    </body>
    </html>
    <?php

} catch (PDOException $e) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Database Error</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md bg-white border border-red-200 p-8 rounded-3xl text-center space-y-6">
            <div class="w-16 h-16 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-3xl mx-auto">
                ⚠️
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Connection Failed</h2>
            <p class="text-xs text-slate-550 font-semibold leading-relaxed">
                Could not connect to MySQL server. Please ensure Laragon (Apache & MySQL services) is running on your system.
            </p>
            <div class="bg-red-50 text-red-700 text-xs p-4 rounded-xl text-left overflow-x-auto border border-red-100">
                <strong>Error details:</strong> <?php echo htmlspecialchars($e->getMessage()); ?>
            </div>
            <a href="db_init.php" class="block w-full text-center py-3.5 rounded-full text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                Retry Connection
            </a>
        </div>
    </body>
    </html>
    <?php
}
