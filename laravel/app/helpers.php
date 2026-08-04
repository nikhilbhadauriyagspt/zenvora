<?php

if (!function_exists('getWebSetting')) {
    function getWebSetting($key, $default = '') {
        static $settings = null;
        if ($settings === null) {
            $defaultSettings = [
                'logo_url' => 'assets/images/logo/Zenvora_Global_Solutions_Logo.png',
                'favicon' => 'assets/images/logo/Zenvora_Global_Solutions_Logo.png',
                'email_1' => 'support@zenvora.in',
                'email_2' => 'info@zenvora.in',
                'phone_1' => '+91 98765 43210',
                'address_noida' => 'Office Suite 508, Block A, The iThum Towers, Sector 62, Noida, Uttar Pradesh - 201301',
                'map_iframe' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.562145326574!2d77.36214627632616!3d28.612911975674393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce561a0f9b3bb%3A0xe1068800b46ebf45!2sThe%20iThum!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin',
                'working_hours' => 'Mon - Sat: 9:00 AM - 7:00 PM (IST)',
                'whatsapp_number' => '+91 98765 43210',
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
                'about_accreditations_badge' => 'Accreditations',
                'about_accreditations_title' => 'Verified and Fully Compliant Infrastructure',
                'about_accreditations_desc' => 'Zenvora is recognized and approved by key regulatory authorities and bodies to coordinate national and global filings safely.',
                'about_tech_badge' => 'Our Stack',
                'about_tech_title' => 'Software Engineered for Corporate Oversight',
                'about_tech_desc' => 'Unlike traditional offline consultants, we replace friction with software pipelines to give you real-time visibility.',
                'about_values_badge' => 'Core values',
                'about_values_title' => 'Built on absolute trust.',
                'about_advisors_badge' => 'Corporate Panel',
                'about_advisors_title' => 'Advisors Who Understand Startup Scaling',
                'about_cta_title' => 'Ready to streamline your legal compliance?',
                'about_cta_desc' => 'Get in touch with Priyanka or Tushar to schedule a free 15-minute consultation. We\'ll map out your custom compliance roadmap.',
                'about_cta_btn_text' => 'Book Free Consultation Call',
                'about_cta_btn_url' => 'contact.php',
                'stat_ops_count' => '1,200+',
                'stat_ops_label' => 'Startups incorporated and legally compliant across India.',
                'stat_accuracy_count' => '99.8%',
                'stat_accuracy_label' => 'Compliance SLA success rate with zero late-fee liabilities.',
                'stat_panel_count' => '45+',
                'stat_panel_label' => 'Chartered Accountants, Lawyers & CSs at your service.',
                'stat_speed_count' => '24 Hours',
                'stat_speed_label' => 'Average turnaround time for company name approvals and filings.'
            ];

            try {
                $dbSettings = \App\Models\Setting::pluck('setting_value', 'setting_key')->toArray();
                $settings = array_merge($defaultSettings, $dbSettings);
            } catch (\Exception $e) {
                $settings = $defaultSettings;
            }
        }
        return $settings[$key] ?? $default;
    }
}

if (!function_exists('getWebPhones')) {
    function getWebPhones() {
        $defaultPhones = [
            ["label" => "Noida HQ Hotline", "value" => "+91 98765 43210", "visible" => 1],
            ["label" => "Advisory Desk", "value" => "+91 99999 88888", "visible" => 1]
        ];
        $json = getWebSetting('phone_numbers');
        $phones = json_decode($json, true);
        if (!is_array($phones)) {
            return $defaultPhones;
        }
        return array_filter($phones, function($p) {
            return isset($p['visible']) && ($p['visible'] == 1 || $p['visible'] === true || $p['visible'] === 'true');
        });
    }
}

if (!function_exists('getWebAddresses')) {
    function getWebAddresses() {
        $defaultAddresses = [
            ["label" => "Noida HQ", "value" => "Office Suite 508, Block A, The iThum Towers, Sector 62, Noida, Uttar Pradesh - 201301", "visible" => 1],
            ["label" => "Mumbai Desk", "value" => "Maker Chambers V, Nariman Point, Mumbai, Maharashtra - 400021", "visible" => 1],
            ["label" => "Bengaluru Desk", "value" => "Brigade Road, Ashok Nagar, Bengaluru, Karnataka - 560025", "visible" => 1],
            ["label" => "Hyderabad Desk", "value" => "Jubilee Hills, Road No. 36, Hyderabad, Telangana - 500033", "visible" => 1]
        ];
        $json = getWebSetting('office_addresses');
        $addresses = json_decode($json, true);
        if (!is_array($addresses)) {
            return $defaultAddresses;
        }
        return array_filter($addresses, function($a) {
            return isset($a['visible']) && ($a['visible'] == 1 || $a['visible'] === true || $a['visible'] === 'true');
        });
    }
}

if (!function_exists('getWebSlides')) {
    function getWebSlides() {
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
        $json = getWebSetting('homepage_hero_slides');
        $slides = json_decode($json, true);
        if (!is_array($slides)) {
            return $defaultSlides;
        }
        return array_filter($slides, function($s) {
            return isset($s['visible']) && ($s['visible'] == 1 || $s['visible'] === true || $s['visible'] === 'true');
        });
    }
}
