<!-- Zenvora Global Solutions Footer Component (Dark Slate Theme, Multi-Column, Flat Design, Huge Watermark) -->
<footer class="relative bg-slate-900 text-slate-400 text-xs py-16 border-t border-slate-800 overflow-hidden">
    
    <!-- Content Wrapper (relative z-10 to stay on top of the watermark) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 relative z-10">
        
        <!-- Multi-column grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 text-left">
            
            <!-- Col 1: Zenvora Info -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img class="h-8 w-auto opacity-95" src="<?php echo getWebSetting('logo_url'); ?>" alt="Zenvora Logo">
                    <span class="font-extrabold text-white tracking-widest text-sm">ZENVORA</span>
                </div>
                <p class="leading-relaxed text-slate-400 text-[11px]">
                    Unified legal, tax, and NGO compliance infrastructure engineered for modern Indian startups and global enterprises.
                </p>
                <!-- Social media icons -->
                <div class="flex gap-2">
                    <a href="#" class="w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-facebook-f text-[10px]"></i>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-twitter text-[10px]"></i>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-linkedin-in text-[10px]"></i>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-full bg-slate-800 text-slate-300 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-instagram text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2: Startup Setup -->
            <div class="space-y-4">
                <h4 class="text-xs font-extrabold uppercase tracking-widest text-white border-b border-slate-800 pb-2">Startup Setup</h4>
                <ul class="space-y-2 text-[11px]">
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Private Limited Company</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Limited Liability Partnership (LLP)</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">One Person Company (OPC)</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Partnership Firm Registry</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Proprietorship Registration</a></li>
                </ul>
            </div>

            <!-- Col 3: Tax & Licenses -->
            <div class="space-y-4">
                <h4 class="text-xs font-extrabold uppercase tracking-widest text-white border-b border-slate-800 pb-2">Tax & Licenses</h4>
                <ul class="space-y-2 text-[11px]">
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">GST Registration</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">GST Return Filings</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Income Tax Return (ITR)</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">FSSAI Food License</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Trade License (Municipal)</a></li>
                </ul>
            </div>

            <!-- Col 4: NGO & Trust -->
            <div class="space-y-4">
                <h4 class="text-xs font-extrabold uppercase tracking-widest text-white border-b border-slate-800 pb-2">NGO & Trust</h4>
                <ul class="space-y-2 text-[11px]">
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Section 8 Company NGO</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Charitable Trust Registry</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">Society Registration</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">NITI Aayog Darpan Setup</a></li>
                    <li><a href="services.php" class="hover:text-brand-400 transition-colors">12A & 80G Tax Exemption</a></li>
                </ul>
            </div>

        </div>

        <!-- Divider line -->
        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 text-[10px] text-slate-500">
            <div class="space-y-1 text-left">
                <p>&copy; 2026 Zenvora Global Solutions Private Limited. All rights reserved.</p>
                <p class="text-slate-650">CIN: U74999UP2018PTC105187 | MCA Registered Corporate Agent</p>
                <p class="text-slate-650 mt-1.5 leading-normal max-w-3xl">
                    <strong>CA Advisory Note:</strong> Outsource your legal, tax, and NGO registrations to our panel of CAs & lawyers. Every process is supervised and verified directly by qualified professionals.
                </p>
            </div>
            
            <div class="flex-shrink-0 text-left md:text-right space-y-1">
                <?php 
                $footerAddresses = getWebAddresses();
                $footerHQ = !empty($footerAddresses) ? reset($footerAddresses) : ['label' => 'Noida Head Office', 'value' => 'Office Suite 508, Block A, The iThum Towers, Sector 62, Noida, Uttar Pradesh - 201301'];
                ?>
                <span class="text-slate-400 block font-bold"><?php echo htmlspecialchars($footerHQ['label']); ?></span>
                <span class="block"><?php echo htmlspecialchars($footerHQ['value']); ?></span>
            </div>
        </div>

    </div>

    <!-- Huge Company Name Watermark Behind Content (z-0, opacity controlled slate-800/10) -->
    <div class="absolute bottom-0 left-0 right-0 text-center pointer-events-none select-none overflow-hidden z-0 leading-none translate-y-12">
        <span class="text-[14vw] font-black text-slate-950/20 tracking-[0.15em] uppercase block">ZENVORA</span>
    </div>
</footer>
