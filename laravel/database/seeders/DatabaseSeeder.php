<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\ServiceCategory;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@zenvora.in',
                'password' => Hash::make('adminpassword'),
                'role' => 'admin'
            ]
        );

        // 2. Seed Default Settings
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
            ]
        ];

        $defaultTestimonials = [
            [
                'initials' => 'AM',
                'name' => 'Aarav Mehta',
                'role' => 'Founder, Zephyr Logistics',
                'review' => 'Zenvora got our Private Limited incorporation and trade licenses sorted in exactly 8 days. Direct WhatsApp access to our assigned CA made the entire paperwork process completely effortless.',
                'rating' => 5
            ]
        ];

        $settings = [
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
            'about_cta_btn_url' => 'contact',
            'stat_ops_count' => '1,200+',
            'stat_ops_label' => 'Startups incorporated and legally compliant across India.',
            'stat_accuracy_count' => '99.8%',
            'stat_accuracy_label' => 'Compliance SLA success rate with zero late-fee liabilities.',
            'stat_panel_count' => '45+',
            'stat_panel_label' => 'Chartered Accountants, Lawyers & CSs at your service.',
            'stat_speed_count' => '24 Hours',
            'stat_speed_label' => 'Average turnaround time for company name approvals and filings.'
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['setting_key' => $key], ['setting_value' => $val]);
        }

        // 3. Seed Default Categories
        $categoriesData = [
            ['name' => 'Business Startup', 'slug' => 'business-startup', 'icon' => 'fa-solid fa-rocket', 'image_url' => 'assets/images/service_incorporation.jpg', 'sort_order' => 1],
            ['name' => 'Registrations', 'slug' => 'registrations', 'icon' => 'fa-solid fa-receipt', 'image_url' => 'assets/images/hero_bg.jpg', 'sort_order' => 2],
            ['name' => 'Licenses', 'slug' => 'licenses', 'icon' => 'fa-solid fa-scale-balanced', 'image_url' => 'assets/images/hero_bg_4.jpg', 'sort_order' => 3],
            ['name' => 'Certifications', 'slug' => 'certifications', 'icon' => 'fa-solid fa-certificate', 'image_url' => 'assets/images/service_trademark.jpg', 'sort_order' => 4],
            ['name' => 'Tax & Compliance', 'slug' => 'tax-compliance', 'icon' => 'fa-solid fa-calculator', 'image_url' => 'assets/images/service_taxation.jpg', 'sort_order' => 5],
            ['name' => 'NGO Registration', 'slug' => 'ngo-registration', 'icon' => 'fa-solid fa-handshake-angle', 'image_url' => 'assets/images/hero_bg_5.jpg', 'sort_order' => 6]
        ];

        foreach ($categoriesData as $cat) {
            ServiceCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Seed Default Services (All 28 Original Services)
        $servicesList = [
            // Registrations
            ['registrations', 'GST Registration', 'gst-registration', '₹499', '2 Days'],
            ['registrations', 'MSME (Udyam) Registration', 'msme-udyam', '₹299', '1 Day'],
            ['registrations', 'Startup India DPIIT Recognition', 'startup-india', '₹4,999', '10 Days'],
            ['registrations', 'Import Export Code (IEC)', 'import-export-code', '₹999', '2 Days'],
            ['registrations', 'PF & ESI Registration', 'pf-esi-registration', '₹1,999', '3 Days'],
            ['registrations', 'GEM Portal Registration', 'gem-portal-registration', '₹2,999', '5 Days'],
            
            // Licenses
            ['licenses', 'FSSAI Food License', 'fssai-food-license', '₹1,999', '5 Days'],
            ['licenses', 'Trade License (Municipal)', 'trade-license', '₹2,499', '7 Days'],
            ['licenses', 'Shop & Establishment (Shop Act)', 'shop-establishment', '₹999', '2 Days'],
            ['licenses', 'CLRA Contract Labour License', 'clra-contract-labour', '₹4,999', '10 Days'],
            ['licenses', 'LWF Labour Welfare Fund', 'lwf-labour-welfare', '₹1,499', '4 Days'],
            ['licenses', 'Professional Tax Registration', 'professional-tax', '₹1,499', '3 Days'],
            
            // Certifications
            ['certifications', 'ISO Certification', 'iso-certification', '₹2,999', '4 Days'],
            ['certifications', 'Trademark (TM) Registration', 'trademark-registration', '₹1,999', '3 Days'],
            ['certifications', 'BIS Certification & ISI Mark', 'bis-certification', '₹14,999', '20 Days'],
            ['certifications', 'Fire Safety NOC Certificate', 'fire-safety-noc', '₹9,999', '15 Days'],
            ['certifications', 'Class 3 Digital Signature (DSC)', 'dsc-class-3', '₹999', '1 Day'],
            ['certifications', 'Make in India Certification', 'make-in-india', '₹3,999', '7 Days'],
            
            // Tax & Compliance
            ['tax-compliance', 'Income Tax Return (ITR) Filing', 'itr-filing', '₹499', '2 Days'],
            ['tax-compliance', 'GST Return Filing', 'gst-return', '₹499', '2 Days'],
            ['tax-compliance', 'ROC Annual Compliances', 'roc-annual-compliances', '₹4,999', '10 Days'],
            ['tax-compliance', 'Corporate Accounting & Bookkeeping', 'accounting-bookkeeping', '₹1,999', '30 Days'],
            ['tax-compliance', 'Company Winding Up', 'company-winding-up', '₹9,999', '45 Days'],
            
            // NGO Registration
            ['ngo-registration', 'Trust Registration', 'trust-registration', '₹5,999', '10 Days'],
            ['ngo-registration', 'Society Registration', 'society-registration', '₹7,999', '12 Days'],
            ['ngo-registration', 'Section 8 Company Setup', 'section-8-company', '₹9,999', '8 Days'],
            ['ngo-registration', '12A & 80G Tax Exemptions', '12a-80g-exemption', '₹4,999', '15 Days'],
            ['ngo-registration', 'CSR-1 Registration', 'csr-1-registration', '₹2,999', '5 Days']
        ];

        // Seed Private Limited Company explicitly first (with custom pillars and details)
        $startupCat = ServiceCategory::where('slug', 'business-startup')->first();
        if ($startupCat) {
            $pillars = [
                ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Limited Liability Protection', 'desc' => 'Your personal assets (house, savings) are 100% safe. If the business incurs losses or debt, shareholders are only liable up to their unpaid share capital.'],
                ['icon' => 'fa-solid fa-scale-balanced', 'title' => 'Separate Legal Entity', 'desc' => 'The company can buy property, sign legal agreements, sue, and be sued in its own name. It continues to exist even if directors or owners change.'],
                ['icon' => 'fa-solid fa-chart-line', 'title' => 'Investor & Funding Ready', 'desc' => 'Venture capitalists (VCs) and angel investors only fund Private Limited companies. It allows easy share allocation and equity dilution.']
            ];

            $steps = [
                ['number' => '01', 'title' => 'Secure DSC & Name Reservation', 'desc' => 'We obtain Digital Signature Certificates (DSC) for directors. Then, we submit your name choices to the MCA for RUN name approval.'],
                ['number' => '02', 'title' => 'Draft Bylaws (MoA/AoA)', 'desc' => 'We draft your Memorandum of Association (MoA) and Articles of Association (AoA) to define your company\'s business goals and rules.'],
                ['number' => '03', 'title' => 'MCA Filing & Approval', 'desc' => 'We file the SPICe+ incorporation forms with the MCA, pay government stamp duties, and secure your official Certificate of Incorporation (COI).']
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

            $pricing = [
                [
                    'name' => 'Basic Plan',
                    'title' => 'Basic Startup',
                    'price' => '₹4,999',
                    'desc' => 'Essential incorporation structure to get operational.',
                    'bullets' => ['2 Director DSCs (Class 3)', '2 Director DIN Registrations', 'RUN Name Approval Coordination', 'Drafting of MoA & AoA Bylaws', 'Company PAN & TAN Allotments']
                ],
                [
                    'name' => 'Compliance Kit',
                    'title' => 'Standard Setup',
                    'price' => '₹7,999',
                    'desc' => 'Adds GST registration, MSME status & corporate bank account.',
                    'bullets' => ['All Basic Plan Deliverables', 'GST Registration (State & Center)', 'MSME Udyam Registration', 'EPFO & ESIC Code Allocation', 'Zero-Balance Bank Account (Partner Banks)'],
                    'best_value' => true
                ],
                [
                    'name' => 'All Inclusive',
                    'title' => 'VIP Expansion',
                    'price' => '₹14,999',
                    'desc' => 'Includes brand IP trademark filing & initial compliance audits.',
                    'bullets' => ['All Standard Plan Deliverables', 'Trademark (TM) Registration (1 Class)', 'Professional Draft of Shareholder Agreements', 'First Board Meeting Resolution Drafts', 'Commencement of Business (INC-20A) Filing']
                ]
            ];

            $faqs = [
                ['q' => 'How many directors are needed to incorporate a Pvt Ltd Company?', 'a' => 'A minimum of two directors are required. The maximum limit is 15. At least one of the directors must be an Indian citizen and a resident of India (stayed in India for over 182 days in the previous calendar year).'],
                ['q' => 'What is the minimum capital required to start a Pvt Ltd Company?', 'a' => 'Historically, a minimum capital of ₹1 Lakh was required. However, under the updated Companies Amendment Act, there is no minimum paid-up capital requirement to register. You can start with an authorized capital as low as ₹10,000.']
            ];

            Service::updateOrCreate(
                ['slug' => 'private-limited-company'],
                [
                    'category_id' => $startupCat->id,
                    'title' => 'Private Limited Company',
                    'tagline' => 'Incorporate your startup in India online with direct expert assistance',
                    'description' => 'Fastest company registration pipeline.',
                    'starting_price' => '₹4,999',
                    'average_duration' => '7-10 Days',
                    'hero_image' => 'assets/images/service_incorporation.jpg',
                    'what_is_brief' => 'A Private Limited Company is the most popular legal structure.',
                    'pillars_json' => $pillars,
                    'steps_json' => $steps,
                    'deliverables_json' => $deliverables,
                    'pricing_packages_json' => $pricing,
                    'faqs_json' => $faqs,
                ]
            );
        }

        // Seed all other services in loop
        foreach ($servicesList as $srvData) {
            $catSlug = $srvData[0];
            $title = $srvData[1];
            $slug = $srvData[2];
            $price = $srvData[3];
            $duration = $srvData[4];

            $cat = ServiceCategory::where('slug', $catSlug)->first();
            if (!$cat) continue;

            $description = "Secure your legal registration for " . $title . " with 100% professional CA/CS assistance. We manage name search, stamp duties, drafting bylaws, government portal uploads, and tracking.";
            $what_is = "A " . $title . " registration is crucial for businesses aiming to operate legally, open commercial bank accounts, and trade across states. Our legal experts streamline your filing process, helping you avoid government query rejections and legal penalties.";
            
            $pillars = [
                ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Legal Compliance', 'desc' => 'Ensure 100% alignment with municipal, state, and central laws.'],
                ['icon' => 'fa-solid fa-clock', 'title' => 'Fast-Track Processing', 'desc' => 'Our legal specialists process your details within 24 hours of document submission.'],
                ['icon' => 'fa-solid fa-hand-holding-dollar', 'title' => 'Transparent Rates', 'desc' => 'Pay flat fee package pricing with zero hidden consultancy charges.']
            ];

            $steps = [
                ['number' => '01', 'title' => 'Document Verification', 'desc' => 'Upload scanned KYC papers and office utility bills to our portal.'],
                ['number' => '02', 'title' => 'Drafting & Filing', 'desc' => 'Our legal desk compiles the government registration forms and drafts declarations.'],
                ['number' => '03', 'title' => 'Final Certification', 'desc' => 'We coordinate with the department registrar and hand over your dynamic digital certificate.']
            ];

            $deliverables = [
                $title . ' Official Registration Certificate',
                'Government Department Challan Receipts',
                'Complimentary CA consultation call'
            ];

            $numericPrice = intval(preg_replace('/[^0-9]/', '', $price));
            $premiumPrice = '₹' . ($numericPrice + 1999);

            $pricing = [
                [
                    'name' => 'Basic Setup',
                    'title' => 'Standard Setup',
                    'price' => $price,
                    'desc' => 'Essential registration setup and government filing.',
                    'bullets' => ['KYC & Document Verification', 'Government Application Compiling', 'Certificate Delivery by Email']
                ],
                [
                    'name' => 'Premium Setup',
                    'title' => 'Fast-Track Compliance',
                    'price' => $premiumPrice,
                    'desc' => 'Adds express priority processing and tax registration support.',
                    'bullets' => ['All Standard Plan Deliverables', 'Priority Processing (Express TAT)', '1-Hour Dedicated Call with Attorney'],
                    'best_value' => true
                ]
            ];

            $faqs = [
                ['q' => 'How long does the registration process take?', 'a' => 'The average turnaround time is approximately ' . $duration . ', subject to government approvals.'],
                ['q' => 'Are original physical documents required?', 'a' => 'No. Clear colored scans or PDF files uploaded to our client desk are completely sufficient.']
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

            Service::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $cat->id,
                    'title' => $title,
                    'tagline' => 'Fast & Hassle-free setup in India',
                    'description' => $description,
                    'starting_price' => $price,
                    'average_duration' => $duration,
                    'hero_image' => $heroImage,
                    'what_is_brief' => $what_is,
                    'pillars_json' => $pillars,
                    'steps_json' => $steps,
                    'deliverables_json' => $deliverables,
                    'pricing_packages_json' => $pricing,
                    'faqs_json' => $faqs
                ]
            );
        }

        // 5. Seed Blogs
        $blogsData = [
            [
                'title' => 'Private Limited vs LLP: Which is Right for Your Startup?',
                'slug' => 'private-limited-vs-llp',
                'category' => 'Business Setup',
                'category_slug' => 'business-startup',
                'date' => 'July 24, 2026',
                'author' => 'Priyanka Sharma',
                'author_role' => 'Senior Legal Advisor',
                'author_avatar' => 'assets/images/about_us.jpg',
                'read_time' => '6 Min Read',
                'image' => 'assets/images/service_incorporation.jpg',
                'excerpt' => 'Choosing the correct legal structure is critical. We analyze tax implications, ROC compliance costs, and venture funding capabilities for Pvt Ltd and LLPs in India.',
                'content' => '<p>When embarking on a new business journey in India, one of the most critical decisions you will face is choosing the right legal entity. The two most popular choices among modern tech founders and traditional SMEs are the Private Limited Company (Pvt Ltd) and the Limited Liability Partnership (LLP).</p><p>Both legal structures offer limited liability protection to their owners, but they differ significantly in their compliance overhead, tax treatments, capital requirements, and ability to raise external venture capital.</p>',
                'status' => 'Published'
            ],
            [
                'title' => 'GST Registration Rules: Thresholds & Mandatory Rules',
                'slug' => 'gst-registration-rules',
                'category' => 'Tax & GST',
                'category_slug' => 'tax',
                'date' => 'July 18, 2026',
                'author' => 'Tushar Sudheesh',
                'author_role' => 'Managing CFO Partner',
                'author_avatar' => 'assets/images/hero_bg.jpg',
                'read_time' => '8 Min Read',
                'image' => 'assets/images/service_taxation.jpg',
                'excerpt' => 'A complete compliance guide on when GST registration becomes mandatory, inter-state tax rules, and how to avoid penalties for late filings under the GST Act.',
                'content' => '<p>The Goods and Services Tax (GST) has consolidated indirect taxes in India, bringing uniform tax structures across states. However, many business owners remain confused about when they must register and what compliance protocols are required.</p>',
                'status' => 'Published'
            ],
            [
                'title' => "The Founder's Guide to Trademark Registration in India",
                'slug' => 'trademark-registration-guide',
                'category' => 'Intellectual Property',
                'category_slug' => 'intellectual-property',
                'date' => 'July 10, 2026',
                'author' => 'Aditya Varma',
                'author_role' => 'Senior IP Counsel',
                'author_avatar' => 'assets/images/hero_bg_3.jpg',
                'read_time' => '5 Min Read',
                'image' => 'assets/images/service_trademark.jpg',
                'excerpt' => 'Learn how to register your brand trademark, use the TM symbol, search for matching registry logs, and resolve trademark objections.',
                'content' => '<p>Your brand name, logo, and slogan represent your company’s identity and goodwill. In a competitive market, failing to protect these intellectual properties can allow copycats to hijack your brand.</p>',
                'status' => 'Published'
            ]
        ];

        foreach ($blogsData as $blog) {
            \App\Models\Blog::updateOrCreate(['slug' => $blog['slug']], $blog);
        }

        // 6. Seed Pricing Packages
        $pricingData = [
            [
                'title' => 'Startup Registry',
                'subtitle' => 'For Early Stage Founders',
                'price' => '₹4,999',
                'tax_note' => '+ Gov Challan',
                'description' => 'Complete legal setup to get your corporate identity registered with MCA and tax hubs in days.',
                'deliverables' => "2 Director DINs & DSC Digital Keys\nMCA Name Approval Filing (RUN)\nMoA / AoA Drafting & Filing\nPAN & TAN Cards Allocation\nZero-Balance Current Bank Account",
                'badge' => '',
                'sort_order' => 1
            ],
            [
                'title' => 'Scale & Compliancy',
                'subtitle' => 'For Funded & Scaling Startups',
                'price' => '₹9,999',
                'tax_note' => '+ Gov Challan',
                'description' => 'Complete corporate incorporation combined with operational tax registrations and corporate advisor check-ins.',
                'deliverables' => "Everything in Startup Registry\nMSME (Udyam) Registration\nGST Registration & HSN Codes Setup\n1-Year Compliance Calendar Consult\nFirst Board Resolution Draft",
                'badge' => 'Most Popular',
                'sort_order' => 2
            ]
        ];

        foreach ($pricingData as $pack) {
            \App\Models\PricingPackage::updateOrCreate(['title' => $pack['title']], $pack);
        }
    }
}
