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
    
    // 5.b Create service_categories table
    $conn->exec("CREATE TABLE IF NOT EXISTS service_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(100) UNIQUE NOT NULL,
        icon VARCHAR(100) NOT NULL,
        image_url VARCHAR(255) NOT NULL,
        sort_order INT DEFAULT 0
    ) ENGINE=InnoDB");

    // 5.c Create services table
    $conn->exec("CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT NOT NULL,
        title VARCHAR(150) NOT NULL,
        slug VARCHAR(150) UNIQUE NOT NULL,
        tagline VARCHAR(150) NOT NULL,
        description TEXT NOT NULL,
        starting_price VARCHAR(50) NOT NULL,
        average_duration VARCHAR(50) NOT NULL,
        hero_image VARCHAR(255) NOT NULL,
        what_is_brief TEXT NOT NULL,
        docs_title VARCHAR(255) DEFAULT 'Documents Needed. Keep Them Ready.',
        docs_subtitle VARCHAR(255) DEFAULT 'Scanned copies are sufficient. No physical originals are required for submission.',
        pillars_json TEXT NOT NULL,
        steps_json TEXT NOT NULL,
        deliverables_json TEXT NOT NULL,
        pricing_packages_json TEXT NOT NULL,
        faqs_json TEXT NOT NULL,
        docs_json TEXT,
        FOREIGN KEY (category_id) REFERENCES service_categories(id) ON DELETE CASCADE
    ) ENGINE=InnoDB");

    // Alter table if it already exists to add columns dynamically
    try {
        $conn->exec("ALTER TABLE services ADD docs_title VARCHAR(255) DEFAULT 'Documents Needed. Keep Them Ready.' AFTER what_is_brief");
        $conn->exec("ALTER TABLE services ADD docs_subtitle VARCHAR(255) DEFAULT 'Scanned copies are sufficient. No physical originals are required for submission.' AFTER docs_title");
        $conn->exec("ALTER TABLE services ADD docs_json TEXT AFTER faqs_json");
    } catch (PDOException $e) {
        // Columns already exist, safe to ignore
    }

    // 5.d Create blogs table
    $conn->exec("CREATE TABLE IF NOT EXISTS blogs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE NOT NULL,
        category VARCHAR(100) NOT NULL,
        category_slug VARCHAR(100) NOT NULL,
        date VARCHAR(50) NOT NULL,
        author VARCHAR(100) NOT NULL,
        author_role VARCHAR(100) NOT NULL,
        author_avatar VARCHAR(255) NOT NULL,
        read_time VARCHAR(50) NOT NULL,
        image VARCHAR(255) NOT NULL,
        excerpt TEXT NOT NULL,
        content TEXT NOT NULL,
        status VARCHAR(20) DEFAULT 'Published',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    // 5.e Create pricing_packages table
    $conn->exec("CREATE TABLE IF NOT EXISTS pricing_packages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        subtitle VARCHAR(100) NOT NULL,
        price VARCHAR(50) NOT NULL,
        tax_note VARCHAR(100) DEFAULT '+ Gov Challan',
        description TEXT NOT NULL,
        deliverables TEXT NOT NULL,
        badge VARCHAR(50) DEFAULT NULL,
        status VARCHAR(20) DEFAULT 'Active',
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    // Seed default categories if empty
    $checkCategories = $conn->query("SELECT COUNT(*) FROM service_categories")->fetchColumn();
    if ($checkCategories == 0) {
        $categoriesData = [
            ['Business Startup', 'business-startup', 'fa-solid fa-rocket', 'assets/images/service_incorporation.jpg', 1],
            ['Registrations', 'registrations', 'fa-solid fa-receipt', 'assets/images/hero_bg.jpg', 2],
            ['Licenses', 'licenses', 'fa-solid fa-scale-balanced', 'assets/images/hero_bg_4.jpg', 3],
            ['Certifications', 'certifications', 'fa-solid fa-certificate', 'assets/images/service_trademark.jpg', 4],
            ['Tax & Compliance', 'tax-compliance', 'fa-solid fa-calculator', 'assets/images/service_taxation.jpg', 5],
            ['NGO Registration', 'ngo-registration', 'fa-solid fa-handshake-angle', 'assets/images/hero_bg_5.jpg', 6]
        ];
        $insertCat = $conn->prepare("INSERT INTO service_categories (name, slug, icon, image_url, sort_order) VALUES (?, ?, ?, ?, ?)");
        foreach ($categoriesData as $cat) {
            $insertCat->execute($cat);
        }
    }

    // Seed default private-limited-company service if empty
    $checkPvtLtd = $conn->query("SELECT COUNT(*) FROM services WHERE slug = 'private-limited-company'")->fetchColumn();
    if ($checkPvtLtd == 0) {
        // Get category_id for business-startup
        $catId = $conn->query("SELECT id FROM service_categories WHERE slug = 'business-startup'")->fetchColumn();
        if ($catId) {
            $pillars = [
                [
                    'icon' => 'fa-solid fa-shield-halved',
                    'title' => 'Limited Liability Protection',
                    'desc' => 'Your personal assets (house, savings) are 100% safe. If the business incurs losses or debt, shareholders are only liable up to their unpaid share capital.'
                ],
                [
                    'icon' => 'fa-solid fa-scale-balanced',
                    'title' => 'Separate Legal Entity',
                    'desc' => 'The company can buy property, sign legal agreements, sue, and be sued in its own name. It continues to exist even if directors or owners change.'
                ],
                [
                    'icon' => 'fa-solid fa-chart-line',
                    'title' => 'Investor & Funding Ready',
                    'desc' => 'Venture capitalists (VCs) and angel investors only fund Private Limited companies. It allows easy share allocation and equity dilution.'
                ]
            ];
            
            $steps = [
                [
                    'number' => '01',
                    'title' => 'Secure DSC & Name Reservation',
                    'desc' => 'We obtain Digital Signature Certificates (DSC) for directors. Then, we submit your name choices to the MCA for RUN name approval.'
                ],
                [
                    'number' => '02',
                    'title' => 'Draft Bylaws (MoA/AoA)',
                    'desc' => 'We draft your Memorandum of Association (MoA) and Articles of Association (AoA) to define your company\'s business goals and rules.'
                ],
                [
                    'number' => '03',
                    'title' => 'MCA Filing & Approval',
                    'desc' => 'We file the SPICe+ incorporation forms with the MCA, pay government stamp duties, and secure your official Certificate of Incorporation (COI).'
                ]
            ];
            
            $deliverables = [
                'Certificate of Incorporation (COI)',
                'Company PAN & TAN Cards',
                '2 Director Identification Numbers (DIN)',
                '2 Class 3 Digital Signatures (DSC)',
                'Approved MoA & AoA Bylaws Documentation',
                'Corporate Bank Account opening letter',
                'EPFO & ESIC registration codes',
                'GST Registration Certificate (Standard & VIP Plan)'
            ];

            $pricing_packages = [
                [
                    'name' => 'Basic Plan',
                    'title' => 'Basic Startup',
                    'price' => '₹4,999',
                    'desc' => 'Essential incorporation structure to get operational.',
                    'bullets' => [
                        '2 Director DSCs (Class 3)',
                        '2 Director DIN Registrations',
                        'RUN Name Approval Coordination',
                        'Drafting of MoA & AoA Bylaws',
                        'Company PAN & TAN Allotments'
                    ]
                ],
                [
                    'name' => 'Compliance Kit',
                    'title' => 'Standard Setup',
                    'price' => '₹7,999',
                    'desc' => 'Adds GST registration, MSME status & corporate bank account.',
                    'bullets' => [
                        'All Basic Plan Deliverables',
                        'GST Registration (State & Center)',
                        'MSME Udyam Registration',
                        'EPFO & ESIC Code Allocation',
                        'Zero-Balance Bank Account (Partner Banks)'
                    ],
                    'best_value' => true
                ],
                [
                    'name' => 'All Inclusive',
                    'title' => 'VIP Expansion',
                    'price' => '₹14,999',
                    'desc' => 'Includes brand IP trademark filing & initial compliance audits.',
                    'bullets' => [
                        'All Standard Plan Deliverables',
                        'Trademark (TM) Registration (1 Class)',
                        'Professional Draft of Shareholder Agreements',
                        'First Board Meeting Resolution Drafts',
                        'Commencement of Business (INC-20A) Filing'
                    ]
                ]
            ];

            $faqs = [
                [
                    'q' => 'How many directors are needed to incorporate a Pvt Ltd Company?',
                    'a' => 'A minimum of two directors are required. The maximum limit is 15. At least one of the directors must be an Indian citizen and a resident of India (stayed in India for over 182 days in the previous calendar year).'
                ],
                [
                    'q' => 'What is the minimum capital required to start a Pvt Ltd Company?',
                    'a' => 'Historically, a minimum capital of ₹1 Lakh was required. However, under the updated Companies Amendment Act, there is no minimum paid-up capital requirement to register. You can start with an authorized capital as low as ₹10,000.'
                ],
                [
                    'q' => 'Do I need to visit the MCA office physically?',
                    'a' => 'No. The incorporation workflow is 100% electronic. All certificates are issued digitally. You only need to scan and upload your documents to our client panel, and we take care of the filing and verification.'
                ],
                [
                    'q' => 'Can a salaried person become a director of a Pvt Ltd Company?',
                    'a' => 'Yes. The Companies Act does not prohibit a salaried employee from becoming a director. However, you must check your employment agreement or seek permission from your employer if conflict of interest guidelines apply.'
                ]
            ];

            $docs_needed = [
                [
                    'section_title' => 'Filing Guidelines & Tips',
                    'icon' => 'fa-solid fa-circle-info',
                    'items' => [
                        ['title' => 'Name Consistency Check', 'desc' => 'Ensure spelling matches exactly across PAN and Aadhaar cards to prevent MCA rejection.'],
                        ['title' => 'Utility Bill Validity', 'desc' => 'Registered office Electricity/Gas bills must not be older than 2 months from submission.'],
                        ['title' => 'Digital Scans Only', 'desc' => 'High-resolution color scans or mobile PDF scanner outputs are 100% accepted. No physical copies needed.']
                    ]
                ],
                [
                    'section_title' => 'Requirements for Promoters',
                    'icon' => 'fa-solid fa-id-card',
                    'items' => [
                        ['title' => 'PAN Card & Aadhaar Card', 'desc' => 'Mandatory identity proof documents for Indian founders.'],
                        ['title' => 'Director Address Proof', 'desc' => 'Latest Bank Statement, Mobile, or Electricity Bill (under 2 months old).'],
                        ['title' => 'Passport Photograph', 'desc' => 'Clear digital photo against a white background.']
                    ]
                ],
                [
                    'section_title' => 'Premises Proof Details',
                    'icon' => 'fa-solid fa-house-chimney',
                    'items' => [
                        ['title' => 'Registered Utility Bill', 'desc' => 'Electricity bill, gas connection, or landline phone bill (under 2 months old).'],
                        ['title' => 'NOC from Property Owner', 'desc' => 'No Objection Certificate signed by the title holder of the premises.'],
                        ['title' => 'Rent/Lease Agreement', 'desc' => 'Required if the office location is rented. Commercial/residential both accepted.']
                    ]
                ]
            ];

            $insertService = $conn->prepare("INSERT INTO services (category_id, title, slug, tagline, description, starting_price, average_duration, hero_image, what_is_brief, docs_title, docs_subtitle, pillars_json, steps_json, deliverables_json, pricing_packages_json, faqs_json, docs_json) VALUES (:cat, :title, :slug, :tagline, :desc, :price, :duration, :hero, :brief, :docs_title, :docs_subtitle, :pillars, :steps, :deliv, :pricing, :faqs, :docs_json)");
            $insertService->execute([
                ':cat' => $catId,
                ':title' => 'Private Limited Company',
                ':slug' => 'private-limited-company',
                ':tagline' => 'Registration in India',
                ':desc' => 'Launch your startup with India\'s most trusted legal structure. Get your Certificate of Incorporation (COI), PAN, TAN, and corporate bank account in just 7 days, 100% online.',
                ':price' => '₹4,999',
                ':duration' => '7 Days',
                ':hero' => 'assets/images/startup_category.jpg',
                ':brief' => 'Think of a Private Limited Company (Pvt Ltd) as a legal shield for your business. It separates your personal life and assets from your business liabilities. In the eyes of the government, a Pvt Ltd company is a "separate legal person" that can sign contracts, own property, and raise funds in its own name. If you plan to raise venture capital or give ESOPs to employees, this is the only structure you should choose.',
                ':docs_title' => 'Documents Needed. Keep Them Ready.',
                ':docs_subtitle' => 'Scanned copies are sufficient. No physical originals are required for submission.',
                ':pillars' => json_encode($pillars),
                ':steps' => json_encode($steps),
                ':deliv' => json_encode($deliverables),
                ':pricing' => json_encode($pricing_packages),
                ':faqs' => json_encode($faqs),
                ':docs_json' => json_encode($docs_needed)
            ]);
        }
    }
    
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

    $aboutTimeline = [
        ["year" => "2018", "title" => "Noida HQ Establishment", "desc" => "Zenvora was incorporated at Noida, UP, starting as a traditional boutique advisory firm with a panel of 3 Chartered Accountants and 2 corporate lawyers."],
        ["year" => "2020", "title" => "Digitization of MCA Pipelines", "desc" => "Launched our digital documents dashboard. Allowed clients to upload KYC records and track name approvals online, shortening company setups to under 10 days."],
        ["year" => "2023", "title" => "Global Infrastructure Expansion", "desc" => "Scaled entity registration and indirect tax services (VAT/GST filing) across 70+ countries. Formed dedicated desks for Transfer Pricing and international subsidiaries."],
        ["year" => "2026", "title" => "Supporting 1,200+ Startups", "desc" => "Zenvora is recognized as one of India's fastest-growing digital compliance partners for high-growth tech firms, with a legal network of 45+ professionals."]
    ];

    $aboutAccreditations = [
        ["title" => "MCA Approved", "icon" => "fa-solid fa-building-shield"],
        ["title" => "DPIIT Partner", "icon" => "fa-solid fa-stamp"],
        ["title" => "GSTN Authorized", "icon" => "fa-solid fa-receipt"],
        ["title" => "ISO 9001:2015", "icon" => "fa-solid fa-ribbon"],
        ["title" => "MSME Registered", "icon" => "fa-solid fa-circle-check"]
    ];

    $aboutTechFeatures = [
        ["title" => "Encrypted Document Vault", "desc" => "Manage and access company formation deeds, share certificates, and director DSC keys safely in your secure cloud vault backed by bank-grade encryption.", "icon" => "fa-solid fa-vault"],
        ["title" => "Proactive Compliance Alerts", "desc" => "Our platform tracks filing dates for ROC, GST returns, and TDS deposits, automatically alerting you and our CA team well ahead of deadlines.", "icon" => "fa-solid fa-bell"],
        ["title" => "Itemized Cost Transparency", "desc" => "Every single government fee challan and professional service receipt is uploaded directly to your ledger to eliminate unannounced surcharges.", "icon" => "fa-solid fa-list-check"]
    ];

    $aboutValues = [
        ["title" => "Absolute Transparency", "desc" => "No hidden professional charges. Every government challan, registration receipt, and MCA fee filing is uploaded directly to your panel for absolute audit trails.", "icon" => "fa-solid fa-scale-balanced"],
        ["title" => "Execution Speed", "desc" => "Your filings are processed through digital conduits. We secure PAN/TAN allocations in 2 days and deliver final MCA incorporation certificates in under 7 days.", "icon" => "fa-solid fa-gauge-high"],
        ["title" => "Direct CA Supervision", "desc" => "Every compliance return, trademark application, and subsidy claim is reviewed and signed off by qualified Chartered Accountants and CS professionals.", "icon" => "fa-solid fa-user-shield"]
    ];

    $aboutAdvisors = [
        ["name" => "Priyanka Sharma", "role" => "Senior Startup Legal Advisor", "desc" => "Directs legal formation frameworks, shareholder agreements, and DPIIT tax exemption approvals for tech startups.", "image" => "assets/images/about_us.jpg"],
        ["name" => "Tushar Sudheesh", "role" => "Managing CFO Partner", "desc" => "Qualified Chartered Accountant managing corporate auditing, monthly accounting systems, and global taxation filings.", "image" => "assets/images/hero_bg.jpg"],
        ["name" => "Aditya Varma", "role" => "Senior IP & Trademark Counsel", "desc" => "Trademark attorney managing patent searches, brand registrations, municipal licensing, and labor law filings.", "image" => "assets/images/hero_bg_3.jpg"]
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
        
        // Let's also restore the general government badges keys
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
        'about_timeline_milestones' => json_encode($aboutTimeline),
        'about_accreditations_badge' => 'Accreditations',
        'about_accreditations_title' => 'Verified and Fully Compliant Infrastructure',
        'about_accreditations_desc' => 'Zenvora is recognized and approved by key regulatory authorities and bodies to coordinate national and global filings safely.',
        'about_accreditations_badges' => json_encode($aboutAccreditations),
        'about_tech_badge' => 'Our Stack',
        'about_tech_title' => 'Software Engineered for Corporate Oversight',
        'about_tech_desc' => 'Unlike traditional offline consultants, we replace friction with software pipelines to give you real-time visibility.',
        'about_tech_features' => json_encode($aboutTechFeatures),
        'about_values_badge' => 'Core values',
        'about_values_title' => 'Built on absolute trust.',
        'about_values_list' => json_encode($aboutValues),
        'about_advisors_badge' => 'Corporate Panel',
        'about_advisors_title' => 'Advisors Who Understand Startup Scaling',
        'about_advisors_list' => json_encode($aboutAdvisors),
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

    // Seed all 30 sub-services dynamically with realistic mock content
    $servicesToSeed = [
        // Business Startup
        ['business-startup', 'Limited Liability Partnership (LLP)', 'limited-liability-partnership', '₹3,999', '8 Days', 'Incorporate your LLP online'],
        ['business-startup', 'One Person Company (OPC)', 'one-person-company', '₹4,499', '6 Days', 'Perfect setup for solo founders'],
        ['business-startup', 'Partnership Firm Setup', 'partnership-firm', '₹1,999', '4 Days', 'Registered Partnership Deeds'],
        ['business-startup', 'Proprietorship Registration', 'proprietorship-registration', '₹999', '2 Days', 'Sole Proprietor setups'],
        
        // Registrations
        ['registrations', 'GST Registration', 'gst-registration', '₹499', '2 Days', 'Secure your Tax Identification ID'],
        ['registrations', 'MSME (Udyam) Registration', 'msme-udyam', '₹299', '1 Day', 'Claim central startup benefits'],
        ['registrations', 'Startup India DPIIT Recognition', 'startup-india', '₹4,999', '10 Days', 'Get tax holidays and DPIIT recognition'],
        ['registrations', 'Import Export Code (IEC)', 'import-export-code', '₹999', '2 Days', 'Export-Import license setup'],
        ['registrations', 'PF & ESI Registration', 'pf-esi-registration', '₹1,999', '3 Days', 'Employee state insurance & provident fund codes'],
        ['registrations', 'GEM Portal Registration', 'gem-portal-registration', '₹2,999', '5 Days', 'Government e-Marketplace vendor onboarding'],
        
        // Licenses
        ['licenses', 'FSSAI Food License', 'fssai-food-license', '₹1,999', '5 Days', 'Food Safety registry clearance'],
        ['licenses', 'Trade License (Municipal)', 'trade-license', '₹2,499', '7 Days', 'Municipal trade setup permits'],
        ['licenses', 'Shop & Establishment (Shop Act)', 'shop-establishment', '₹999', '2 Days', 'Commercial shop establishment act licenses'],
        ['licenses', 'CLRA Contract Labour License', 'clra-contract-labour', '₹4,999', '10 Days', 'Labour department clearances'],
        ['licenses', 'LWF Labour Welfare Fund', 'lwf-labour-welfare', '₹1,499', '4 Days', 'Welfare funds code setups'],
        ['licenses', 'Professional Tax Registration', 'professional-tax', '₹1,499', '3 Days', 'PT employer & employee registrations'],
        
        // Certifications
        ['certifications', 'ISO Certification', 'iso-certification', '₹2,999', '4 Days', 'ISO 9001/14001/27501 quality standards'],
        ['certifications', 'Trademark (TM) Registration', 'trademark-registration', '₹1,999', '3 Days', 'Secure brand logo and company names'],
        ['certifications', 'BIS Certification & ISI Mark', 'bis-certification', '₹14,999', '20 Days', 'Bureau of Indian Standards compliance'],
        ['certifications', 'Fire Safety NOC Certificate', 'fire-safety-noc', '₹9,999', '15 Days', 'Fire department safety permits'],
        ['certifications', 'Class 3 Digital Signature (DSC)', 'dsc-class-3', '₹999', '1 Day', 'Secure personal & company e-signatures'],
        ['certifications', 'Make in India Certification', 'make-in-india', '₹3,999', '7 Days', 'Indigenization program approvals'],
        
        // Tax & Compliance
        ['tax-compliance', 'Income Tax Return (ITR) Filing', 'itr-filing', '₹499', '2 Days', 'Personal & corporate annual tax filings'],
        ['tax-compliance', 'GST Return Filing', 'gst-return', '₹499', '2 Days', 'Monthly and quarterly tax registers filing'],
        ['tax-compliance', 'ROC Annual Compliances', 'roc-annual-compliances', '₹4,999', '10 Days', 'Filings & MCA resolutions bookkeeping'],
        ['tax-compliance', 'Corporate Accounting & Bookkeeping', 'accounting-bookkeeping', '₹1,999', '30 Days', 'Monthly financial statements ledgers'],
        ['tax-compliance', 'Company Winding Up', 'company-winding-up', '₹9,999', '45 Days', 'ROC strike-off and dissolution filings'],
        
        // NGO Registration
        ['ngo-registration', 'Trust Registration', 'trust-registration', '₹5,999', '10 Days', 'NGO Trust deeds setup and filing'],
        ['ngo-registration', 'Society Registration', 'society-registration', '₹7,999', '12 Days', 'Registered bylaws and societies setups'],
        ['ngo-registration', 'Section 8 Company Setup', 'section-8-company', '₹9,999', '8 Days', 'Non-profit company setups under MCA'],
        ['ngo-registration', '12A & 80G Tax Exemptions', '12a-80g-exemption', '₹4,999', '15 Days', 'Income tax relief certificates for NGOs'],
        ['ngo-registration', 'CSR-1 Registration', 'csr-1-registration', '₹2,999', '5 Days', 'Get CSR corporate fund approvals']
    ];

    function seedService($conn, $catSlug, $title, $slug, $price, $duration, $tagline = '') {
        $check = $conn->prepare("SELECT COUNT(*) FROM services WHERE slug = :slug");
        $check->execute([':slug' => $slug]);
        if ($check->fetchColumn() > 0) return;
        
        $catId = $conn->prepare("SELECT id FROM service_categories WHERE slug = :catSlug");
        $catId->execute([':catSlug' => $catSlug]);
        $categoryId = $catId->fetchColumn();
        if (!$categoryId) return;
        
        if (empty($tagline)) {
            $tagline = "Fast & Hassle-free setup in India";
        }
        
        $description = "Secure your legal registration for " . $title . " with 100% professional CA/CS assistance. We manage name search, stamp duties, drafting bylaws, government portal uploads, and tracking.";
        $what_is = "A " . $title . " registration is crucial for businesses aiming to operate legally, open commercial bank accounts, and trade across states. Our legal experts streamline your filing process, helping you avoid government query rejections and legal penalties.";
        
        $pillars = [
            [
                'icon' => 'fa-solid fa-shield-halved',
                'title' => 'Legal Compliance',
                'desc' => 'Ensure 100% alignment with municipal, state, and central laws.'
            ],
            [
                'icon' => 'fa-solid fa-clock',
                'title' => 'Fast-Track Processing',
                'desc' => 'Our legal specialists process your details within 24 hours of document submission.'
            ],
            [
                'icon' => 'fa-solid fa-hand-holding-dollar',
                'title' => 'Transparent Rates',
                'desc' => 'Pay flat fee package pricing with zero hidden consultancy charges.'
            ]
        ];
        
        $steps = [
            [
                'number' => '01',
                'title' => 'Document Verification',
                'desc' => 'Upload scanned KYC papers and office utility bills to our portal.'
            ],
            [
                'number' => '02',
                'title' => 'Drafting & Filing',
                'desc' => 'Our legal desk compiles the government registration forms and drafts declarations.'
            ],
            [
                'number' => '03',
                'title' => 'Final Certification',
                'desc' => 'We coordinate with the department registrar and hand over your dynamic digital certificate.'
            ]
        ];
        
        $deliverables = [
            $title . ' Official Registration Certificate',
            'Government Department Challan Receipts',
            'Complimentary CA consultation call'
        ];
        
        $pricing = [
            [
                'name' => 'Basic Setup',
                'title' => 'Standard Setup',
                'price' => $price,
                'desc' => 'Essential registration setup and government filing.',
                'bullets' => [
                    'KYC & Document Verification',
                    'Government Application Compiling',
                    'Certificate Delivery by Email'
                ]
            ],
            [
                'name' => 'Premium Setup',
                'title' => 'Fast-Track Compliance',
                'price' => '₹' . (intval(preg_replace('/[^0-9]/', '', $price)) + 1999),
                'desc' => 'Adds express priority processing and tax registration support.',
                'bullets' => [
                    'All Standard Plan Deliverables',
                    'Priority Processing (Express TAT)',
                    '1-Hour Dedicated Call with Attorney'
                ],
                'best_value' => true
            ]
        ];
        
        $faqs = [
            [
                'q' => 'How long does the registration process take?',
                'a' => 'The average turnaround time is approximately ' . $duration . ', subject to government approvals.'
            ],
            [
                'q' => 'Are original physical documents required?',
                'a' => 'No. Clear colored scans or PDF files uploaded to our client desk are completely sufficient.'
            ]
        ];
        
        $docs_needed = [
            [
                'section_title' => 'Filing Guidelines & Tips',
                'icon' => 'fa-solid fa-circle-info',
                'items' => [
                    ['title' => 'Official Data Verification', 'desc' => 'Spelling must exactly match across registration certificates and identity cards.'],
                    ['title' => 'Utility Proofs Validity', 'desc' => 'Electricity/Gas bills submitted as address proof must be under 2 months old.'],
                    ['title' => 'High Resolution Scans', 'desc' => 'High quality mobile PDF scan outputs are accepted. No physical copies needed.']
                ]
            ],
            [
                'section_title' => 'Requirements for Promoters',
                'icon' => 'fa-solid fa-id-card',
                'items' => [
                    ['title' => 'PAN & Aadhaar Identification', 'desc' => 'Mandatory identity proofs for promoters / directors.'],
                    ['title' => 'Official Address Proof', 'desc' => 'Latest Bank Statement, Mobile, or Utility Bill (under 2 months old).'],
                    ['title' => 'Passport Photo', 'desc' => 'Clear digital colored photo with neutral background.']
                ]
            ],
            [
                'section_title' => 'Premises Proof Details',
                'icon' => 'fa-solid fa-house-chimney',
                'items' => [
                    ['title' => 'Utility Bill of Office', 'desc' => 'Electricity bill, gas bill, or water tax receipt (under 2 months old).'],
                    ['title' => 'Consent NOC Form', 'desc' => 'Signed No Objection Certificate from the legal owner of the premises.'],
                    ['title' => 'Rent/Lease Proof', 'desc' => 'Lease agreement if the office space is rented. Commercial/residential accepted.']
                ]
            ]
        ];

        $heroImage = 'assets/images/hero_bg.jpg';
        if ($catSlug === 'business-startup') {
            $heroImage = 'assets/images/startup_category.jpg';
        } elseif ($catSlug === 'registrations') {
            $heroImage = 'assets/images/registration_category.jpg';
        } elseif ($catSlug === 'licenses') {
            $heroImage = 'assets/images/licenses_category.jpg';
        } elseif ($catSlug === 'certifications') {
            $heroImage = 'assets/images/certifications_category.jpg';
        } elseif ($catSlug === 'tax-compliance') {
            $heroImage = 'assets/images/tax_category.jpg';
        } elseif ($catSlug === 'ngo-registration') {
            $heroImage = 'assets/images/ngo_category.jpg';
        }

        $stmt = $conn->prepare("INSERT INTO services (category_id, title, slug, tagline, description, starting_price, average_duration, hero_image, what_is_brief, docs_title, docs_subtitle, pillars_json, steps_json, deliverables_json, pricing_packages_json, faqs_json, docs_json) VALUES (:cat, :title, :slug, :tagline, :desc, :price, :duration, :hero, :brief, :docs_title, :docs_subtitle, :pillars, :steps, :deliv, :pricing, :faqs, :docs_json)");
        $stmt->execute([
            ':cat' => $categoryId,
            ':title' => $title,
            ':slug' => $slug,
            ':tagline' => $tagline,
            ':desc' => $description,
            ':price' => $price,
            ':duration' => $duration,
            ':hero' => $heroImage,
            ':brief' => $what_is,
            ':docs_title' => 'Documents Needed for ' . $title . '.',
            ':docs_subtitle' => 'Scanned copies are sufficient. No physical originals are required for submission.',
            ':pillars' => json_encode($pillars),
            ':steps' => json_encode($steps),
            ':deliv' => json_encode($deliverables),
            ':pricing' => json_encode($pricing),
            ':faqs' => json_encode($faqs),
            ':docs_json' => json_encode($docs_needed)
        ]);
    }

    foreach ($servicesToSeed as $srvSeed) {
        seedService($conn, $srvSeed[0], $srvSeed[1], $srvSeed[2], $srvSeed[3], $srvSeed[4], $srvSeed[5]);
    }

    // Update all existing services to use the newly copied, beautiful category images
    $conn->exec("UPDATE services s 
    JOIN service_categories c ON s.category_id = c.id 
    SET s.hero_image = CASE 
        WHEN c.slug = 'business-startup' THEN 'assets/images/startup_category.jpg'
        WHEN c.slug = 'registrations' THEN 'assets/images/registration_category.jpg'
        WHEN c.slug = 'licenses' THEN 'assets/images/licenses_category.jpg'
        WHEN c.slug = 'certifications' THEN 'assets/images/certifications_category.jpg'
        WHEN c.slug = 'tax-compliance' THEN 'assets/images/tax_category.jpg'
        WHEN c.slug = 'ngo-registration' THEN 'assets/images/ngo_category.jpg'
    END");

    // Update all existing service categories to use the newly generated, premium category images
    $conn->exec("UPDATE service_categories 
    SET image_url = CASE 
        WHEN slug = 'business-startup' THEN 'assets/images/startup_category.jpg'
        WHEN slug = 'registrations' THEN 'assets/images/registration_category.jpg'
        WHEN slug = 'licenses' THEN 'assets/images/licenses_category.jpg'
        WHEN slug = 'certifications' THEN 'assets/images/certifications_category.jpg'
        WHEN slug = 'tax-compliance' THEN 'assets/images/tax_category.jpg'
        WHEN slug = 'ngo-registration' THEN 'assets/images/ngo_category.jpg'
        ELSE 'assets/images/hero_bg.jpg'
    END");

    // Seed default blogs if table is empty
    $checkBlogs = $conn->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
    if ($checkBlogs == 0) {
        $insertBlog = $conn->prepare("INSERT INTO blogs (title, slug, category, category_slug, date, author, author_role, author_avatar, read_time, image, excerpt, content, status) VALUES (:title, :slug, :category, :category_slug, :date, :author, :author_role, :author_avatar, :read_time, :image, :excerpt, :content, 'Published')");
        
        // Blog 1
        $insertBlog->execute([
            ':title' => 'Private Limited vs LLP: Which is Right for Your Startup?',
            ':slug' => 'private-limited-vs-llp',
            ':category' => 'Business Setup',
            ':category_slug' => 'startup',
            ':date' => 'July 24, 2026',
            ':author' => 'Priyanka Sharma',
            ':author_role' => 'Senior Legal Advisor',
            ':author_avatar' => 'assets/images/about_us.jpg',
            ':read_time' => '6 Min Read',
            ':image' => 'assets/images/service_incorporation.jpg',
            ':excerpt' => 'Choosing the correct legal structure is critical. We analyze tax implications, ROC compliance costs, and venture funding capabilities for Pvt Ltd and LLPs in India.',
            ':content' => '
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                    When embarking on a new business journey in India, one of the most critical decisions you will face is choosing the right legal entity. The two most popular choices among modern tech founders and traditional SMEs are the <strong>Private Limited Company (Pvt Ltd)</strong> and the <strong>Limited Liability Partnership (LLP)</strong>. 
                </p>
                <p class="text-slate-655 text-sm sm:text-base leading-relaxed mb-6">
                    Both legal structures offer limited liability protection to their owners, but they differ significantly in their compliance overhead, tax treatments, capital requirements, and ability to raise external venture capital. Let’s break down the key differences to help you make an informed choice.
                </p>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-8 mb-4">1. Capital Structure & Venture Funding</h3>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-4">
                    If your business plan involves raising funds from Venture Capitalists (VCs) or Angel Investors, a <strong>Private Limited Company</strong> is the only viable option. VCs prefer investing in Pvt Ltd companies because they allow for easy equity share transfer, issuance of convertible notes, and employee stock options (ESOPs).
                </p>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-6">
                    In contrast, an LLP has a partner contribution structure rather than share capital. Transferring ownership in an LLP requires rewriting the partnership deed, which is a slow legal process that VCs generally avoid.
                </p>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-8 mb-4">2. Compliance Overhead & Maintenance Costs</h3>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-4">
                    This is where the LLP structure shines. LLPs have significantly lower annual compliance requirements compared to Pvt Ltd companies:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-xs sm:text-sm text-slate-655 mb-6">
                    <li><strong>No Mandatory Audit:</strong> LLPs only require an annual audit if their contribution exceeds ₹25 Lakhs or if their annual turnover exceeds ₹40 Lakhs. Pvt Ltd companies must perform audits annually regardless of turnover.</li>
                    <li><strong>Fewer ROC Filings:</strong> LLPs file only two annual forms (Form 8 and Form 11). Pvt Ltd companies must hold annual general meetings (AGMs), maintain board meeting minutes, and file multiple forms (AOC-4, MGT-7, ADT-1, etc.).</li>
                </ul>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-8 mb-4">3. Taxation Comparison</h3>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-6">
                    Both entities are taxed at flat corporate rates. However, a Private Limited Company is subject to Dividend Distribution Tax (DDT) or deemed dividend taxation if cash is distributed to shareholders. LLPs can distribute profits to partners without additional dividend tax liabilities, making cash withdrawals simpler for service boutique operations.
                </p>
                <div class="bg-slate-50 border-l-4 border-brand-500 p-5 my-8 rounded-r-2xl">
                    <p class="text-xs sm:text-sm text-slate-700 font-semibold italic">
                        "Summary Advisory: Choose a Private Limited structure if you aim to raise external equity funding, launch ESOPs, or build a scalable startup. Choose an LLP if you are running a lifestyle business, agency, or professional consultancy where low compliance costs are preferred."
                    </p>
                </div>
            '
        ]);

        // Blog 2
        $insertBlog->execute([
            ':title' => 'GST Registration Rules: Thresholds & Mandatory Rules',
            ':slug' => 'gst-registration-rules',
            ':category' => 'Tax & GST',
            ':category_slug' => 'tax',
            ':date' => 'July 18, 2026',
            ':author' => 'Tushar Sudheesh',
            ':author_role' => 'Managing CFO Partner',
            ':author_avatar' => 'assets/images/hero_bg.jpg',
            ':read_time' => '8 Min Read',
            ':image' => 'assets/images/service_taxation.jpg',
            ':excerpt' => 'A complete compliance guide on when GST registration becomes mandatory, inter-state tax rules, and how to avoid penalties for late filings under the GST Act.',
            ':content' => '
                <p class="text-slate-655 text-sm sm:text-base leading-relaxed mb-6">
                    The Goods and Services Tax (GST) has consolidated indirect taxes in India, bringing uniform tax structures across states. However, many business owners remain confused about when they must register and what compliance protocols are required. 
                </p>
                <p class="text-slate-655 text-sm sm:text-base leading-relaxed mb-6">
                    Failing to register for GST when legally required, or delaying GSTR-3B filings, can attract heavy interest charges and structural penalties. Let’s look at the thresholds and rules.
                </p>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-8 mb-4">1. Turnover Thresholds for Registration</h3>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-4">
                    GST registration requirements are defined based on the aggregate annual turnover of the business:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-xs sm:text-sm text-slate-655 mb-6">
                    <li><strong>Goods Suppliers:</strong> Mandatory registration if annual aggregate turnover exceeds ₹40 Lakhs (limit is ₹20 Lakhs for Special Category and North-Eastern states).</li>
                    <li><strong>Service Providers:</strong> Mandatory registration if annual aggregate turnover exceeds ₹20 Lakhs (limit is ₹10 Lakhs for Special Category states).</li>
                </ul>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-8 mb-4">2. Mandatory Registration (Regardless of Turnover)</h3>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-4">
                    You must register for GST immediately, even if your annual turnover is ₹1, if you fall under any of these criteria:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-xs sm:text-sm text-slate-655 mb-6">
                    <li><strong>Inter-State Sales:</strong> Selling goods across state boundaries. (Note: Service providers are allowed inter-state sales up to ₹20L without GST).</li>
                    <li><strong>E-Commerce Sellers:</strong> Listing products on Amazon, Flipkart, or other digital marketplaces.</li>
                    <li><strong>Non-Resident Taxable Persons:</strong> Operating a business in India without a fixed place of business.</li>
                </ul>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-8 mb-4">3. Late Filing Penalties & Interest</h3>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-6">
                    If you hold a active GST registration, you must file monthly/quarterly returns (GSTR-1 and GSTR-3B) even if you had zero transactions. Filing late triggers a late fee of ₹50 per day (₹20 for Nil returns), plus an interest charge of 18% per annum on any unpaid tax liabilities.
                </p>
                <div class="bg-slate-50 border-l-4 border-brand-500 p-5 my-8 rounded-r-2xl">
                    <p class="text-xs sm:text-sm text-slate-700 font-semibold italic">
                        "Compliance Tip: Even if your startup turnover is currently under ₹20 Lakhs, taking a voluntary GST registration is recommended as it allows you to claim Input Tax Credit (ITC) on office setups, laptops, and professional fees."
                    </p>
                </div>
            '
        ]);

        // Blog 3
        $insertBlog->execute([
            ':title' => "The Founder's Guide to Trademark Registration in India",
            ':slug' => 'trademark-registration-guide',
            ':category' => 'Intellectual Property',
            ':category_slug' => 'licenses',
            ':date' => 'July 10, 2026',
            ':author' => 'Aditya Varma',
            ':author_role' => 'Senior IP Counsel',
            ':author_avatar' => 'assets/images/hero_bg_3.jpg',
            ':read_time' => '5 Min Read',
            ':image' => 'assets/images/service_trademark.jpg',
            ':excerpt' => 'Learn how to register your brand trademark, use the TM symbol, search for matching registry logs, and resolve trademark objections.',
            ':content' => '
                <p class="text-slate-655 text-sm sm:text-base leading-relaxed mb-6">
                    Your brand name, logo, and slogan represent your company’s identity and goodwill. In a competitive market, failing to protect these intellectual properties can allow copycats to hijack your brand. 
                </p>
                <p class="text-slate-655 text-sm sm:text-base leading-relaxed mb-6">
                    A registered trademark gives you exclusive rights to use your brand assets nationwide. Let’s look at how the registration process works.
                </p>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-8 mb-4">1. Running a Comprehensive Search</h3>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-6">
                    Before filing, you must conduct a thorough search on the government’s IP India database. The database categorizes trademarks under 45 different "Classes" based on business niches. A matching or phonetically similar brand name registered under your class will lead to an immediate trademark objection.
                </p>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-8 mb-4">2. TM vs ® Symbol: What is the Difference?</h3>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-6">
                    The day your trademark application is submitted online and marked as "Received", you can start displaying the <strong>"TM" symbol</strong> beside your logo. This tells competitors you claim ownership. You can only use the <strong>"®" symbol</strong> after the Registrar issues the registration certificate (which can take 6-12 months).
                </p>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mt-8 mb-4">3. Trademark Objections</h3>
                <p class="text-slate-655 text-xs sm:text-sm leading-relaxed mb-6">
                    Over 50% of trademark filings receive an initial "Objected" status in the examination report. This usually happens under Section 9 (lack of distinctiveness) or Section 11 (identical names). You must file a formal reply within 30 days explaining why your brand name is unique, often backed by evidence of prior use.
                </p>
                <div class="bg-slate-50 border-l-4 border-brand-500 p-5 my-8 rounded-r-2xl">
                    <p class="text-xs sm:text-sm text-slate-700 font-semibold italic">
                        "Legal Advice: Always register your trademark early. Startups registered under MSME get a 50% discount on government filing fees, reducing it from ₹9,000 to ₹4,500."
                    </p>
                </div>
            '
        ]);
    }

    // Seed default pricing packages if table is empty
    $checkPricing = $conn->query("SELECT COUNT(*) FROM pricing_packages")->fetchColumn();
    if ($checkPricing == 0) {
        $insertPrice = $conn->prepare("INSERT INTO pricing_packages (title, subtitle, price, tax_note, description, deliverables, badge, sort_order) VALUES (:title, :subtitle, :price, :tax_note, :description, :deliverables, :badge, :sort_order)");
        
        // Pack 1
        $insertPrice->execute([
            ':title' => 'Startup Registry',
            ':subtitle' => 'For Early Stage Founders',
            ':price' => '₹4,999',
            ':tax_note' => '+ Gov Challan',
            ':description' => 'Complete legal setup to get your corporate identity registered with MCA and tax hubs in days.',
            ':deliverables' => "2 Director DINs & DSC Digital Keys\nMCA Name Approval Filing (RUN)\nMoA / AoA Drafting & Filing\nPAN & TAN Cards Allocation\nZero-Balance Current Bank Account",
            ':badge' => '',
            ':sort_order' => 1
        ]);
        
        // Pack 2
        $insertPrice->execute([
            ':title' => 'Scale & Compliancy',
            ':subtitle' => 'For Funded & Scaling Startups',
            ':price' => '₹9,999',
            ':tax_note' => '+ Gov Challan',
            ':description' => 'Complete corporate incorporation combined with operational tax registrations and corporate advisor check-ins.',
            ':deliverables' => "Everything in Startup Registry\nMSME (Udyam) Registration\nGST Registration & HSN Codes Setup\n1-Year Compliance Calendar Consult\nFirst Board Resolution Draft",
            ':badge' => 'Most Popular',
            ':sort_order' => 2
        ]);
        
        // Pack 3
        $insertPrice->execute([
            ':title' => 'Enterprise Suite',
            ':subtitle' => 'For Subsidiaries & MNCs',
            ':price' => '₹24,999',
            ':tax_note' => 'All-Inclusive Fee',
            ':description' => 'End-to-end setup coordination for foreign subsidiaries, joint ventures, and custom capital structures.',
            ':deliverables' => "Foreign Direct Investment (FDI) reporting\nRBI FEMA compliance checks\nCustom drafted Shareholder agreements\nDedicated Corporate Secretary support\nRegistered Office Address setup (1 Year)",
            ':badge' => '',
            ':sort_order' => 3
        ]);
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
