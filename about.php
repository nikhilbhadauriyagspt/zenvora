<?php
// Standalone About Us Page for Zenvora Global Solutions
require_once 'components/settings_helper.php';

// Decode JSON settings values
$timeline = json_decode(getWebSetting('about_timeline_milestones'), true) ?? [];
$accreditations = json_decode(getWebSetting('about_accreditations_badges'), true) ?? [];
$techFeatures = json_decode(getWebSetting('about_tech_features'), true) ?? [];
$values = json_decode(getWebSetting('about_values_list'), true) ?? [];
$advisors = json_decode(getWebSetting('about_advisors_list'), true) ?? [];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Zenvora Global Solutions</title>
    <meta name="description" content="Learn about Zenvora Global Solutions, our mission, vision, history, and the qualified CA panel behind our premium compliance infrastructure.">
    
    <!-- Load Head dependencies (Tailwind CDN, Fonts, Font Awesome) -->
    <?php include_once 'components/head.php'; ?>
</head>

<body class="subpage-theme bg-white font-sans text-slate-600 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Global Header Navigation -->
    <?php include_once 'components/header.php'; ?>

    <main>
        
        <!-- Hero Section -->
        <section class="relative py-28 bg-slate-50 border-b border-slate-100 overflow-hidden">
            <!-- Subtle Grid Background -->
            <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                    <i class="fa-solid fa-building text-[10px]"></i> Our Identity
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none max-w-4xl mx-auto">
                    <?php echo getWebSetting('about_hero_title'); ?>
                </h1>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold max-w-2xl mx-auto">
                    <?php echo htmlspecialchars(getWebSetting('about_hero_subtitle')); ?>
                </p>
            </div>
        </section>

        <!-- Our Story & Mission Split Section (No Shadows) -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    
                    <!-- Left Column: Visual Leaf Frame Image -->
                    <div class="lg:col-span-6 relative">
                        <!-- Curved Organic Frame (Leaf Shape) with Gold Offset Frame -->
                        <div class="absolute inset-0 border border-brand-500/30 rounded-[3rem] rounded-tr-none rounded-bl-none translate-x-4 translate-y-4"></div>
                        <div class="relative rounded-[3rem] rounded-tr-none rounded-bl-none overflow-hidden aspect-[4/3] bg-slate-100 border border-slate-200">
                            <img src="<?php echo htmlspecialchars(getWebSetting('about_purpose_image')); ?>" 
                                 alt="Zenvora Corporate Workspace" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Right Column: Mission Content -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                            <i class="fa-solid fa-bullseye text-[9px]"></i> <?php echo htmlspecialchars(getWebSetting('about_purpose_badge')); ?>
                        </span>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            <?php echo htmlspecialchars(getWebSetting('about_purpose_title')); ?>
                        </h2>
                        <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                            <?php echo htmlspecialchars(getWebSetting('about_purpose_desc')); ?>
                        </p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                            <div class="space-y-2">
                                <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 flex items-center gap-2">
                                    <i class="<?php echo htmlspecialchars(getWebSetting('about_vision_icon')); ?> text-brand-500"></i> <?php echo htmlspecialchars(getWebSetting('about_vision_title')); ?>
                                </h4>
                                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                    <?php echo htmlspecialchars(getWebSetting('about_vision_desc')); ?>
                                </p>
                            </div>
                            <div class="space-y-2">
                                <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 flex items-center gap-2">
                                    <i class="<?php echo htmlspecialchars(getWebSetting('about_mission_icon')); ?> text-brand-500"></i> <?php echo htmlspecialchars(getWebSetting('about_mission_title')); ?>
                                </h4>
                                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                    <?php echo htmlspecialchars(getWebSetting('about_mission_desc')); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Balanced Zig-Zag Timeline Section (Resolves Empty Space Issue) -->
        <section class="py-24 bg-slate-50 border-b border-slate-100 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="max-w-3xl text-left mb-20 space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-timeline text-[9px]"></i> <?php echo htmlspecialchars(getWebSetting('about_timeline_badge')); ?>
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        <?php echo htmlspecialchars(getWebSetting('about_timeline_title')); ?>
                    </h2>
                    <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                        <?php echo htmlspecialchars(getWebSetting('about_timeline_desc')); ?>
                    </p>
                </div>

                <!-- Balanced Zig-Zag Timeline Container -->
                <div class="relative w-full max-w-5xl mx-auto mt-16">
                    <!-- Central Vertical Axis Line (Visible on desktop) -->
                    <div class="absolute left-1/2 top-0 bottom-0 w-0.5 bg-slate-200 -translate-x-1/2 hidden md:block"></div>

                    <div class="space-y-16 relative">
                        
                        <?php foreach ($timeline as $idx => $milestone): 
                            $isEven = ($idx % 2 === 0);
                        ?>
                        <!-- Milestone Row: Zig-Zag layout dynamically generated -->
                        <div class="flex flex-col md:flex-row items-center justify-between relative group">
                            <!-- Center bullet dot -->
                            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-4.5 h-4.5 rounded-full border-2 border-brand-500 bg-white group-hover:bg-brand-500 transition-colors z-20 hidden md:block"></div>
                            
                            <!-- Left Side Layout -->
                            <?php if ($isEven): ?>
                            <!-- Content left -->
                            <div class="w-full md:w-[45%] text-left md:text-right pr-0 md:pr-10 space-y-2">
                                <span class="text-xs font-bold text-brand-600 block md:hidden"><?php echo htmlspecialchars($milestone['year']); ?></span>
                                <h3 class="text-base font-extrabold text-slate-900"><?php echo htmlspecialchars($milestone['title']); ?></h3>
                                <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                                    <?php echo htmlspecialchars($milestone['desc']); ?>
                                </p>
                            </div>
                            <!-- Year label right -->
                            <div class="w-full md:w-[45%] text-left md:pl-10 hidden md:block">
                                <span class="text-3xl font-black text-slate-300 group-hover:text-brand-500 transition-colors uppercase tracking-widest"><?php echo htmlspecialchars($milestone['year']); ?></span>
                            </div>
                            <?php else: ?>
                            <!-- Year label left -->
                            <div class="w-full md:w-[45%] text-right pr-10 hidden md:block">
                                <span class="text-3xl font-black text-slate-300 group-hover:text-brand-500 transition-colors uppercase tracking-widest"><?php echo htmlspecialchars($milestone['year']); ?></span>
                            </div>
                            <!-- Content right -->
                            <div class="w-full md:w-[45%] text-left pl-0 md:pl-10 space-y-2">
                                <span class="text-xs font-bold text-brand-650 block md:hidden"><?php echo htmlspecialchars($milestone['year']); ?></span>
                                <h3 class="text-base font-extrabold text-slate-900"><?php echo htmlspecialchars($milestone['title']); ?></h3>
                                <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                                    <?php echo htmlspecialchars($milestone['desc']); ?>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>

            </div>
        </section>

        <!-- Dynamic Trust Stats Section -->
        <?php include_once 'components/stats.php'; ?>

        <!-- Accreditations & Trust Partners -->
        <section class="py-20 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
                <div class="max-w-2xl mx-auto space-y-3">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest"><?php echo htmlspecialchars(getWebSetting('about_accreditations_badge')); ?></span>
                    <h3 class="text-2xl font-extrabold text-slate-900"><?php echo htmlspecialchars(getWebSetting('about_accreditations_title')); ?></h3>
                    <p class="text-slate-500 text-xs font-semibold leading-relaxed">
                        <?php echo htmlspecialchars(getWebSetting('about_accreditations_desc')); ?>
                    </p>
                </div>

                <!-- Credibility badges grid (Flat panels, No Shadows) -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    <?php foreach ($accreditations as $acc): ?>
                    <div class="bg-slate-50/50 border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="<?php echo htmlspecialchars($acc['icon']); ?> text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider"><?php echo htmlspecialchars($acc['title']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Technology-Enabled Compliance -->
        <section class="py-24 bg-slate-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="max-w-3xl text-left mb-16 space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-code text-[9px]"></i> <?php echo htmlspecialchars(getWebSetting('about_tech_badge')); ?>
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        <?php echo htmlspecialchars(getWebSetting('about_tech_title')); ?>
                    </h2>
                    <p class="text-slate-500 text-sm leading-relaxed font-semibold">
                        <?php echo htmlspecialchars(getWebSetting('about_tech_desc')); ?>
                    </p>
                </div>

                <!-- 3-Column Technology Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($techFeatures as $feat): ?>
                    <!-- Tech Item -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-200/55 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-base">
                                <i class="<?php echo htmlspecialchars($feat['icon']); ?>"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900"><?php echo htmlspecialchars($feat['title']); ?></h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                <?php echo htmlspecialchars($feat['desc']); ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Our Core Values Grid (Flat Cards) -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="max-w-3xl text-left mb-16 space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-heart text-[9px]"></i> <?php echo htmlspecialchars(getWebSetting('about_values_badge')); ?>
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        <?php echo htmlspecialchars(getWebSetting('about_values_title')); ?>
                    </h2>
                </div>

                <!-- 3-Column Values Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($values as $val): ?>
                    <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-200/50">
                        <div class="w-9 h-9 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-sm mb-4">
                            <i class="<?php echo htmlspecialchars($val['icon']); ?>"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900"><?php echo htmlspecialchars($val['title']); ?></h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            <?php echo htmlspecialchars($val['desc']); ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- Leadership Advising Panel Grid -->
        <section class="py-24 bg-slate-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="max-w-3xl text-left mb-16 space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-users text-[9px]"></i> <?php echo htmlspecialchars(getWebSetting('about_advisors_badge')); ?>
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        <?php echo htmlspecialchars(getWebSetting('about_advisors_title')); ?>
                    </h2>
                </div>

                <!-- Leaders Grid (3-column layout, no shadows) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <?php foreach ($advisors as $adv): ?>
                    <!-- Advisor Item -->
                    <div class="bg-white rounded-3xl p-5 border border-slate-200/50 group hover:border-brand-500/30 transition-all duration-300">
                        <div class="relative w-full aspect-square rounded-2xl overflow-hidden mb-4 bg-slate-100">
                            <img src="<?php echo htmlspecialchars($adv['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($adv['name']); ?> Zenvora Advisor" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="text-left space-y-1">
                            <h3 class="text-sm font-extrabold text-slate-900"><?php echo htmlspecialchars($adv['name']); ?></h3>
                            <span class="text-[10px] text-brand-600 font-extrabold uppercase tracking-wider block"><?php echo htmlspecialchars($adv['role']); ?></span>
                            <p class="text-xs text-slate-500 leading-normal pt-2 border-t border-slate-100 mt-2 font-medium">
                                <?php echo htmlspecialchars($adv['desc']); ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </section>

        <!-- Dynamic CTA Section (No Shadows) -->
        <section class="py-24 bg-white text-center">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight"><?php echo htmlspecialchars(getWebSetting('about_cta_title')); ?></h2>
                <p class="text-slate-500 text-sm max-w-xl mx-auto font-semibold">
                    <?php echo htmlspecialchars(getWebSetting('about_cta_desc')); ?>
                </p>
                <div class="pt-4">
                    <a href="<?php echo htmlspecialchars(getWebSetting('about_cta_btn_url')); ?>" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full text-xs font-bold text-white accent-gradient hover:opacity-95 transition-all">
                        <i class="fa-solid fa-calendar-check mr-2"></i> <?php echo htmlspecialchars(getWebSetting('about_cta_btn_text')); ?>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer Navigation -->
    <?php include_once 'components/footer.php'; ?>

</body>

</html>
