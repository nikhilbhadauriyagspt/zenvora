<?php
/**
 * Standalone Contact Us Page for Zenvora Global Solutions
 * Handles lead database capture if the database is running on localhost/Laragon.
 */
session_start();
require_once 'components/db_connect.php';

$successMsg = '';
$errorMsg = '';

// Handle enquiry submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $service = trim($_POST['service'] ?? 'General Inquiry');
    $org_size = trim($_POST['org_size'] ?? '1');
    $timeline = trim($_POST['timeline'] ?? 'immediately');
    $message = trim($_POST['message'] ?? '');
    $source_page = trim($_POST['source_page'] ?? 'Contact Page');
    
    // Map service category slug to a premium, human-readable name
    $serviceMapping = [
        'startup' => 'Business Startup Registration',
        'tax' => 'GST & Tax Compliances',
        'licenses' => 'Operational Licenses',
        'certifications' => 'ISO & Trademarking',
        'ngo' => 'NGO & Trust setup'
    ];
    if (isset($serviceMapping[$service])) {
        $service = $serviceMapping[$service];
    }
    
    // Append the source page to the service name
    $finalService = $service . ' (' . $source_page . ')';
    
    if (empty($name) || empty($phone) || empty($email)) {
        $errorMsg = 'Please fill out all required fields (Name, Phone, and Email).';
    } else {
        if ($pdo !== null) {
            try {
                $stmt = $pdo->prepare("INSERT INTO enquiries (name, phone, email, service, org_size, timeline, message, status) VALUES (:name, :phone, :email, :service, :org_size, :timeline, :message, 'Pending')");
                $stmt->execute([
                    ':name' => $name,
                    ':phone' => $phone,
                    ':email' => $email,
                    ':service' => $finalService,
                    ':org_size' => $org_size,
                    ':timeline' => $timeline,
                    ':message' => $message
                ]);
                
                // Dispatch SMTP email alert
                require_once __DIR__ . '/components/mail_helper.php';
                @send_lead_notification($name, $phone, $email, $finalService, $org_size, $timeline, $message);
                
                $successMsg = 'Thank you! Your advisory request has been successfully logged. A CA will call you back in under 15 minutes.';
            } catch (PDOException $e) {
                $errorMsg = 'Failed to submit enquiry: ' . $e->getMessage();
            }
        } else {
            // Fallback for demonstration if database is not active
            $successMsg = 'Thank you! Your request was received successfully (Demo Mode - Active database required for dashboard sync).';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Zenvora Global Solutions</title>
    <meta name="description" content="Get in touch with Zenvora Global Solutions. Speak directly with CAs, CSs, and attorneys regarding company registrations, GST filings, and licensing.">
    
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
                    <i class="fa-solid fa-headset text-[10px]"></i> Advisory Desk
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none max-w-4xl mx-auto">
                    Get in Touch. Speak <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Directly with a CA.</span>
                </h1>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold max-w-2xl mx-auto">
                    Outsource your startup formation, licensing, and compliance tracking. Our qualified panel of Chartered Accountants and corporate attorneys is ready to call you back.
                </p>
            </div>
        </section>

        <!-- Main Contact & Offices Grid (No Shadows) -->
        <section class="py-24 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Feedback Alerts -->
                <?php if (!empty($successMsg)): ?>
                    <div class="mb-10 max-w-3xl mx-auto bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm p-5 rounded-2xl flex items-center gap-4 text-left font-semibold">
                        <i class="fa-solid fa-circle-check text-xl text-emerald-600 flex-shrink-0"></i>
                        <span><?php echo htmlspecialchars($successMsg); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errorMsg)): ?>
                    <div class="mb-10 max-w-3xl mx-auto bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm p-5 rounded-2xl flex items-center gap-4 text-left font-semibold">
                        <i class="fa-solid fa-circle-exclamation text-xl text-red-600 flex-shrink-0"></i>
                        <span><?php echo htmlspecialchars($errorMsg); ?></span>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                    
                    <!-- Left Column: Noida HQ, Regional Offices, & WhatsApp Support Card (col-span-5) -->
                    <div class="lg:col-span-5 space-y-8 text-left">
                        
                        <!-- Main Corporate Head Office Address & Integrated Map -->
                        <?php 
                        $contactAddresses = getWebAddresses();
                        $hqDesk = !empty($contactAddresses) ? array_shift($contactAddresses) : ['label' => 'Noida Head Office', 'value' => 'Office Suite 508, Block A, The iThum Towers, Sector 62, Noida, Uttar Pradesh - 201301'];
                        
                        $contactPhones = getWebPhones();
                        $firstPhoneVal = !empty($contactPhones) ? reset($contactPhones)['value'] : '+91 98765 43210';
                        ?>
                        <div class="space-y-4">
                            <span class="text-xs font-extrabold text-slate-400 uppercase tracking-widest block">Main Corporate Headquarters</span>
                            <div class="bg-slate-50/50 border border-slate-200 p-6 rounded-3xl space-y-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-base flex-shrink-0">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-extrabold text-slate-900"><?php echo htmlspecialchars($hqDesk['label']); ?></h3>
                                        <p class="text-xs text-slate-500 mt-1 font-semibold leading-relaxed">
                                            <?php echo htmlspecialchars($hqDesk['value']); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="border-t border-slate-200 pt-4 grid grid-cols-2 gap-4 text-xs font-semibold text-slate-700">
                                    <div>
                                        <span class="text-slate-400 block text-[9px] uppercase tracking-wider">Direct Hotline</span>
                                        <span class="text-slate-900 font-extrabold mt-0.5 block"><?php echo htmlspecialchars($firstPhoneVal); ?></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[9px] uppercase tracking-wider">Help Email</span>
                                        <span class="text-slate-900 font-extrabold mt-0.5 block"><?php echo getWebSetting('email_1'); ?></span>
                                    </div>
                                </div>

                                <!-- Integrated Google Map Embed (Noida HQ iThum Towers) -->
                                <div class="border-t border-slate-200 pt-4">
                                    <iframe src="<?php echo getWebSetting('map_iframe'); ?>" 
                                            width="100%" 
                                            height="200" 
                                            style="border:0;" 
                                            allowfullscreen="" 
                                            loading="lazy" 
                                            referrerpolicy="no-referrer-when-downgrade"
                                            class="rounded-2xl border border-slate-200">
                                    </iframe>
                                </div>
                            </div>
                        </div>

                        <!-- Regional Advisory Desks -->
                        <div class="space-y-4">
                            <span class="text-xs font-extrabold text-slate-400 uppercase tracking-widest block">Regional Advisory Desks</span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <?php foreach ($contactAddresses as $regDesk): ?>
                                <div class="bg-slate-50/50 border border-slate-200 p-5 rounded-2xl space-y-2">
                                    <h4 class="text-xs font-extrabold text-slate-900 flex items-center gap-2">
                                        <i class="fa-solid fa-building text-[10px] text-brand-500"></i> <?php echo htmlspecialchars($regDesk['label']); ?>
                                    </h4>
                                    <p class="text-[10px] text-slate-550 leading-normal font-semibold">
                                        <?php echo htmlspecialchars($regDesk['value']); ?>
                                    </p>
                                </div>
                                <?php endforeach; ?>
                                
                                <!-- Support Hours -->
                                <div class="bg-slate-50/50 border border-slate-200 p-5 rounded-2xl space-y-2">
                                    <h4 class="text-xs font-extrabold text-slate-900 flex items-center gap-2">
                                        <i class="fa-solid fa-clock text-[10px] text-brand-500"></i> Support Hours
                                    </h4>
                                    <p class="text-[10px] text-slate-550 leading-normal font-semibold">
                                        <?php echo getWebSetting('working_hours'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Live WhatsApp Lady Advisor Card -->
                        <div class="bg-white border border-slate-200 p-5 rounded-2xl flex items-center gap-4 text-left">
                            <img src="assets/images/about_us.jpg" 
                                 alt="Priyanka Sharma Zenvora Advisor" 
                                 class="w-16 h-16 rounded-full object-cover border-2 border-brand-500/30 flex-shrink-0">
                            <div class="space-y-2 flex-grow">
                                <span class="text-xs font-extrabold text-slate-900 block leading-tight">Need immediate CA assistance?</span>
                                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', getWebSetting('whatsapp_number')); ?>" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-full text-[10px] font-black text-white bg-emerald-600 hover:bg-emerald-700 transition-colors w-full">
                                    <i class="fa-brands fa-whatsapp text-xs"></i> WhatsApp Chat
                                </a>
                            </div>
                        </div>

                        <!-- CA availability badge -->
                        <div class="flex items-center gap-2.5 px-4 py-3 bg-emerald-50/50 border border-emerald-500/15 rounded-xl">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></span>
                            <span class="text-xs font-bold text-slate-700">CA Panel Currently Available (Current wait time: 4 mins)</span>
                        </div>
                    </div>

                    <!-- Right Column: Consultation Schedule Form (col-span-7) -->
                    <div class="lg:col-span-7 bg-slate-50/50 border border-slate-200 p-6 sm:p-8 rounded-3xl">
                        <!-- Form Header Intro Content -->
                        <div class="mb-6 space-y-1.5 pb-4 border-b border-slate-200">
                            <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane text-brand-500"></i> Request a Call Back
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-550 font-semibold leading-relaxed">
                                Fill out the details below. A dedicated compliance CA or legal advisor will review your requirement and call you back within 15 minutes.
                            </p>
                        </div>
                        
                        <form action="contact.php" method="POST" class="space-y-5 text-left">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <!-- Full Name -->
                                <div class="space-y-1.5">
                                    <label for="form-name" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Full Name</label>
                                    <input type="text" id="form-name" name="name" required placeholder="Aarav Sharma" 
                                           class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                                </div>
                                
                                <!-- Phone Number -->
                                <div class="space-y-1.5">
                                    <label for="form-phone" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Mobile Number</label>
                                    <input type="tel" id="form-phone" name="phone" required placeholder="+91 99999 99999" 
                                           class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <!-- Email -->
                                <div class="space-y-1.5">
                                    <label for="form-email" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Business Email</label>
                                    <input type="email" id="form-email" name="email" required placeholder="aarav@company.com" 
                                           class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                                </div>
                                
                                <!-- Service Category -->
                                <div class="space-y-1.5">
                                    <label for="form-service" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Required Service</label>
                                    <select id="form-service" name="service" required 
                                            class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700">
                                        <option value="" disabled selected>Select category...</option>
                                        <option value="startup">Business Startup Registration</option>
                                        <option value="tax">GST & Tax Compliances</option>
                                        <option value="licenses">Operational Licenses</option>
                                        <option value="certifications">ISO & Trademarking</option>
                                        <option value="ngo">NGO & Trust setup</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <!-- Organization Size -->
                                <div class="space-y-1.5">
                                    <label for="form-size" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Organization Size</label>
                                    <select id="form-size" name="org_size" required 
                                            class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700">
                                        <option value="" disabled selected>Select size...</option>
                                        <option value="1">1 (Sole Founder)</option>
                                        <option value="2-10">2 - 10 Employees</option>
                                        <option value="11-50">11 - 50 Employees</option>
                                        <option value="50+">50+ Employees</option>
                                    </select>
                                </div>
                                
                                <!-- Launch Date Timeline -->
                                <div class="space-y-1.5">
                                    <label for="form-timeline" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Target Launch Date</label>
                                    <select id="form-timeline" name="timeline" required 
                                            class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-700">
                                        <option value="" disabled selected>Select timeline...</option>
                                        <option value="immediately">Immediately</option>
                                        <option value="30days">Within 30 Days</option>
                                        <option value="justexploring">Just Exploring</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Message details -->
                            <div class="space-y-1.5">
                                <label for="form-message" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Tell us about your requirement</label>
                                <textarea id="form-message" name="message" rows="4" placeholder="Briefly specify what business registrations or licensing you are looking for..." 
                                          class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors resize-none"></textarea>
                            </div>

                            <input type="hidden" name="source_page" value="Contact Page">

                            <!-- Submit Button -->
                            <button type="submit" class="w-full text-center py-4 rounded-full text-sm font-bold text-white accent-gradient hover:opacity-95 transition-all duration-300">
                                <i class="fa-solid fa-calendar-check mr-2"></i> Book Free Consultation Call
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </section>

        <!-- New Value-Add Content Section: What Happens After You Book (Our Process Protocol) -->
        <section class="py-20 bg-slate-50/50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
                <div class="max-w-2xl mx-auto space-y-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-list-check text-[9px]"></i> Our Protocol
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">What Happens After You Submit?</h3>
                    <p class="text-slate-500 text-xs sm:text-sm font-semibold leading-relaxed">
                        We respect your time. Here is our 3-step onboarding pipeline to map out your legal compliance blueprint.
                    </p>
                </div>

                <!-- 3-Step Process Steps (Flat Panels, No Shadows) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                    <!-- Step 1 -->
                    <div class="bg-white border border-slate-200/50 p-6 rounded-2xl space-y-4">
                        <div class="w-8 h-8 rounded-full bg-brand-500/10 text-brand-500 flex items-center justify-center text-xs font-black">1</div>
                        <h4 class="text-sm font-extrabold text-slate-900">Trademark & Name Audit</h4>
                        <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                            Before our call, our legal team runs a preliminary check on your target business name against the MCA database and IPR trademark registry to ensure zero conflicts.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white border border-slate-200/50 p-6 rounded-2xl space-y-4">
                        <div class="w-8 h-8 rounded-full bg-brand-500/10 text-brand-500 flex items-center justify-center text-xs font-black">2</div>
                        <h4 class="text-sm font-extrabold text-slate-900">15-Min CA Consultation</h4>
                        <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                            Our qualified Chartered Accountant calls you to discuss tax liability setups (GST registration, composition schemes) and necessary operational licenses for your niche.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white border border-slate-200/50 p-6 rounded-2xl space-y-4">
                        <div class="w-8 h-8 rounded-full bg-brand-500/10 text-brand-500 flex items-center justify-center text-xs font-black">3</div>
                        <h4 class="text-sm font-extrabold text-slate-900">Compliance Roadmap</h4>
                        <p class="text-xs text-slate-550 leading-relaxed font-semibold">
                            Within 2 hours, we deliver a customized PDF proposal detailing every government challan cost, timeline milestones, and documents checklist.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trust Accreditations Banner -->
        <section class="py-20 bg-slate-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-10">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Approved Registrations</span>
                <!-- Badges -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    <div class="bg-white border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="fa-solid fa-building-shield text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">MCA Approved</span>
                    </div>
                    <div class="bg-white border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="fa-solid fa-stamp text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">DPIIT Partner</span>
                    </div>
                    <div class="bg-white border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="fa-solid fa-receipt text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">GSTN Authorized</span>
                    </div>
                    <div class="bg-white border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3">
                        <i class="fa-solid fa-ribbon text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">ISO 9001:2015</span>
                    </div>
                    <div class="bg-white border border-slate-200/50 p-6 rounded-2xl flex flex-col items-center justify-center gap-3 col-span-2 md:col-span-1">
                        <i class="fa-solid fa-circle-check text-2xl text-brand-500/80"></i>
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">MSME Registered</span>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer Navigation -->
    <?php include_once 'components/footer.php'; ?>

</body>

</html>
