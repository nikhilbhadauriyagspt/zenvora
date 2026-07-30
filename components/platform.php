<?php
/**
 * Global Platform Showcase Section (Light Theme, Clean & Neat, 4-Column Card Grid)
 * Fetches platform cards dynamically from the database, runs auto-migration check.
 */
global $pdo;
$db_platform_cards = [];

if (isset($pdo) && $pdo !== null) {
    try {
        // Auto-Migration check: Create table if it doesn't exist
        $pdo->exec("CREATE TABLE IF NOT EXISTS platform_cards (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            slug VARCHAR(100) UNIQUE NOT NULL,
            subtitle VARCHAR(100) DEFAULT NULL,
            description TEXT NOT NULL,
            image_url VARCHAR(255) NOT NULL,
            points TEXT NOT NULL,
            detailed_content LONGTEXT NOT NULL,
            status VARCHAR(20) DEFAULT 'Active',
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB");

        // Seed default 4 cards if empty
        $check = $pdo->query("SELECT COUNT(*) FROM platform_cards")->fetchColumn();
        if ($check == 0) {
            $default_cards = [
                [
                    'title' => 'Entity Management',
                    'slug' => 'entity-management',
                    'subtitle' => 'Global Subsidiary Operations',
                    'description' => 'Formation, maintenance, and oversight for subsidiaries across 70+ countries.',
                    'image_url' => 'assets/images/hero_bg_5.jpg',
                    'points' => "70+ Countries subsidiary setup\nLocal registered agent service\nAnnual secretary oversight",
                    'detailed_content' => "<h3>Unified Subsidiary Operations Across 70+ Countries</h3><p>Establish, align and maintain your international corporate footprint without hiring local operations desks. Zenvora provides a single centralized compliance panel to supervise cross-border entities.</p><h4>What you get:</h4><ul><li>Global subsidiary incorporation packages in compliance with native laws.</li><li>Registered agent representation and local address allocations.</li><li>Annual filings, corporate resolutions, board meeting logistics, and statutory secretarial reviews.</li></ul>"
                ],
                [
                    'title' => 'Global Indirect Tax',
                    'slug' => 'global-indirect-tax',
                    'subtitle' => 'Automated Tax Compliance',
                    'description' => 'VAT, GST, and sales tax obligations tracked, filed, and confirmed globally.',
                    'image_url' => 'assets/images/service_taxation.jpg',
                    'points' => "VAT / GST obligations tracking\nAutomated country return filing\nLocal confirmation tax audits",
                    'detailed_content' => "<h3>VAT, GST and Sales Tax Filings Simplified</h3><p>Stay ahead of multi-country taxation requirements and cross-border digital service tax rules. Zenvora automates indirect tax triggers and manages international filings in real time.</p><h4>Core Services:</h4><ul><li>Nexus tracking for digital services, physical warehouses and subsidiaries.</li><li>Automated calculation, collection advice, and portal return filings.</li><li>Localized tax audit defenses and penalty-free compliance tracking.</li></ul>"
                ],
                [
                    'title' => 'Transfer Pricing',
                    'slug' => 'transfer-pricing',
                    'subtitle' => 'OECD Compliant Intercompany Setup',
                    'description' => 'Intercompany policy, documentation, and filing, built to OECD standards.',
                    'image_url' => 'assets/images/hero_illustration.jpg',
                    'points' => "OECD benchmark reports\nIntercompany agreement drafts\nMaster File & Local compliance",
                    'detailed_content' => "<h3>OECD Intercompany Policy & Reporting Desk</h3><p>Establish defensible, compliant transfer pricing systems to prevent local tax challenges and duplicate taxation audits. We prepare robust documentation aligned with BEPS directives.</p><h4>Deliverables:</h4><ul><li>OECD and local benchmark reports prepared by corporate tax experts.</li><li>Intercompany agreements and cross-border transfer pricing policy drafts.</li><li>Master File, Local File and Country-by-Country (CbC) tax report filings.</li></ul>"
                ],
                [
                    'title' => 'Tax & Accounting',
                    'slug' => 'tax-accounting',
                    'subtitle' => 'Consolidated Statutory Reporting',
                    'description' => 'Consolidated financial reporting and local corporate tax filings with one audit trail.',
                    'image_url' => 'assets/images/service_incorporation.jpg',
                    'points' => "Consolidated balance sheets\nStatutory local tax filings\nSingle unified audit trail logs",
                    'detailed_content' => "<h3>Integrated Cross-Border Accounting and Tax Audits</h3><p>Manage international bookkeeping under a single dashboard. Zenvora consolidates statutory local books and tracks all transactions under a unified audit trail.</p><h4>Highlights:</h4><ul><li>Statutory financial reporting under US GAAP, IFRS, and local standards.</li><li>Corporate tax returns prepared by specialized local chartered accountants.</li><li>Unified transaction logs and complete compliance audit trails.</li></ul>"
                ]
            ];

            $stmt = $pdo->prepare("INSERT INTO platform_cards (title, slug, subtitle, description, image_url, points, detailed_content, status, sort_order) VALUES (:title, :slug, :subtitle, :description, :image_url, :points, :detailed_content, 'Active', :sort_order)");
            foreach ($default_cards as $idx => $card) {
                $stmt->execute([
                    ':title' => $card['title'],
                    ':slug' => $card['slug'],
                    ':subtitle' => $card['subtitle'],
                    ':description' => $card['description'],
                    ':image_url' => $card['image_url'],
                    ':points' => $card['points'],
                    ':detailed_content' => $card['detailed_content'],
                    ':sort_order' => $idx * 10
                ]);
            }
        }

        // Fetch active platform cards
        $db_platform_cards = $pdo->query("SELECT * FROM platform_cards WHERE status = 'Active' ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $db_platform_cards = [];
    }
}

// Static Fallback logic in case DB connection is not alive
if (empty($db_platform_cards)) {
    $db_platform_cards = [
        [
            'title' => 'Entity Management',
            'slug' => 'entity-management',
            'description' => 'Formation, maintenance, and oversight for subsidiaries across 70+ countries.',
            'image_url' => 'assets/images/hero_bg_5.jpg',
            'points' => "70+ Countries subsidiary setup\nLocal registered agent service\nAnnual secretary oversight"
        ],
        [
            'title' => 'Global Indirect Tax',
            'slug' => 'global-indirect-tax',
            'description' => 'VAT, GST, and sales tax obligations tracked, filed, and confirmed globally.',
            'image_url' => 'assets/images/service_taxation.jpg',
            'points' => "VAT / GST obligations tracking\nAutomated country return filing\nLocal confirmation tax audits"
        ],
        [
            'title' => 'Transfer Pricing',
            'slug' => 'transfer-pricing',
            'description' => 'Intercompany policy, documentation, and filing, built to OECD standards.',
            'image_url' => 'assets/images/hero_illustration.jpg',
            'points' => "OECD benchmark reports\nIntercompany agreement drafts\nMaster File & Local compliance"
        ],
        [
            'title' => 'Tax & Accounting',
            'slug' => 'tax-accounting',
            'description' => 'Consolidated financial reporting and local corporate tax filings with one audit trail.',
            'image_url' => 'assets/images/service_incorporation.jpg',
            'points' => "Consolidated balance sheets\nStatutory local tax filings\nSingle unified audit trail logs"
        ]
    ];
}
?>
<!-- Global Platform Showcase Section (Light Theme, Clean & Neat, 4-Column Card Grid, No Shadows) -->
<section id="platform" class="relative py-24 bg-white border-b border-slate-100 overflow-hidden">
    <!-- Subtle Background Decorators -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="max-w-3xl text-left mb-16 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                <i class="fa-solid fa-earth-americas text-[9px]"></i> Global Operations
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Every jurisdiction, no gaps.
            </h2>
            <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                Built for finance teams running international operations without a dedicated compliance function. This is the infrastructure you should have had from day one.
            </p>
        </div>

        <!-- 4-Column Simple Grid Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <?php foreach ($db_platform_cards as $card): 
                $points = explode("\n", str_replace("\r", "", $card['points']));
            ?>
            <!-- Card Object -->
            <div class="bg-slate-50/50 rounded-2xl p-5 border border-slate-200/50 hover:border-brand-500/30 transition-all duration-300 group flex flex-col justify-between">
                <div>
                    <!-- Simple visual image -->
                    <div class="relative w-full h-36 overflow-hidden rounded-xl mb-4 bg-slate-200">
                        <img src="<?php echo htmlspecialchars($card['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($card['title']); ?>" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                        <?php echo htmlspecialchars($card['title']); ?>
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        <?php echo htmlspecialchars($card['description']); ?>
                    </p>
                    
                    <!-- Bullet Points -->
                    <ul class="mt-4 space-y-2 text-[10px] text-slate-600 border-t border-slate-100/60 pt-3">
                        <?php foreach ($points as $pt): 
                            if (trim($pt) === '') continue;
                        ?>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-brand-500"></i> <?php echo htmlspecialchars(trim($pt)); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a href="platform-detail.php?slug=<?php echo htmlspecialchars($card['slug']); ?>" class="inline-flex items-center gap-1 text-[10px] font-bold text-brand-500 hover:text-brand-600 mt-5 pt-3 border-t border-slate-100 w-full">
                    Learn more <i class="fa-solid fa-arrow-up-right-from-square text-[8px]"></i>
                </a>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
