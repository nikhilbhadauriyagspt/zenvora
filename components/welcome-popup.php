<?php

/**
 * Dynamic Services list for Welcome Popup
 */
global $pdo;
$popup_services = [];
if (isset($pdo) && $pdo !== null) {
    try {
        $popup_services = $pdo->query("SELECT title, slug FROM services ORDER BY title ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $popup_services = [];
    }
}

// Fallback services in case DB is not initialized or query fails
if (empty($popup_services)) {
    $popup_services = [
        ['title' => 'Private Limited Company', 'slug' => 'private-limited-company'],
        ['title' => 'Limited Liability Partnership (LLP)', 'slug' => 'limited-liability-partnership'],
        ['title' => 'One Person Company (OPC)', 'slug' => 'one-person-company'],
        ['title' => 'GST Registration', 'slug' => 'gst-registration'],
        ['title' => 'MSME (Udyam) Registration', 'slug' => 'msme-udyam'],
        ['title' => 'Trademark Registration', 'slug' => 'trademark-registration'],
        ['title' => 'Income Tax Return (ITR) Filing', 'slug' => 'itr-filing'],
        ['title' => 'FSSAI Food License', 'slug' => 'fssai-food-license']
    ];
}
?>
<!-- Premium Larger Welcome Popup Modal (Glassmorphic, Slide-in and Page-turn animations) -->
<div id="welcome-popup-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-500">

    <!-- CSS Transitions and Keyframe Animations -->
    <style type="text/css">
        /* Slide in from the Right Side */
        @keyframes slideInRight {
            0% {
                transform: translateX(100vw) rotate(5deg) scale(0.9);
                opacity: 0;
            }

            100% {
                transform: translateX(0) rotate(0deg) scale(1);
                opacity: 1;
            }
        }

        /* Page Fly Away Turn to the Left Side */
        @keyframes pageFlyAwayLeft {
            0% {
                transform: translateX(0) rotate(0deg) scale(1);
                transform-origin: left bottom;
                opacity: 1;
            }

            30% {
                transform: translateX(-50px) rotate(-3deg) scale(0.98);
                transform-origin: left bottom;
                opacity: 0.95;
            }

            100% {
                transform: translateX(-120vw) rotate(-22deg) scale(0.85);
                transform-origin: left bottom;
                opacity: 0;
            }
        }

        /* Classes to toggle via JS */
        .popup-animate-enter {
            animation: slideInRight 0.85s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .popup-animate-exit {
            animation: pageFlyAwayLeft 0.85s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }
    </style>

    <!-- Large Modal Container (max-w-4xl split) -->
    <div id="welcome-modal-card" class="relative w-full max-w-4xl mx-4 bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row opacity-0 transform">

        <!-- Left Column: Image Overlay & Offer Briefing -->
        <div class="relative w-full md:w-5/12 h-48 md:h-auto bg-cover bg-center" style="background-image: url('assets/images/about_us.jpg');">
            <!-- Dark gradient backdrop -->
            <!-- Subtle gradient cover only at the bottom text area (85% opacity) and transparent everywhere else -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent pointer-events-none"></div>

            <!-- Left Info Panel details -->
            <div class="absolute bottom-6 left-6 right-6 text-left space-y-3">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black bg-brand-500 text-slate-950 uppercase tracking-widest shadow">
                    Exclusive Founders Offer
                </span>
                <h4 class="text-lg sm:text-xl font-black text-white leading-snug drop-shadow-sm">
                    Get Free Legal & Compliance Consult
                </h4>
                <p class="text-[11px] text-slate-300 leading-relaxed font-semibold drop-shadow-sm">
                    Discuss your corporate structure, registrations, and accounting schedules directly with qualified CAs. Free waiver on initial document drafting fees!
                </p>
                <div class="flex items-center gap-2 pt-2 border-t border-white/10 text-[9px] text-slate-400 font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Panel Desk Live & Active
                </div>
            </div>
        </div>

        <!-- Right Column: Interactive Form (Dynamic dropdown, new fields, scrollable for mobile) -->
        <div class="w-full md:w-7/12 p-6 sm:p-8 text-left relative bg-slate-900 flex flex-col justify-center overflow-y-auto max-h-[80vh] md:max-h-[580px]">

            <!-- Floating close icon -->
            <button type="button" id="close-welcome-popup" class="absolute top-4 right-4 w-7 h-7 rounded-full bg-slate-950 border border-slate-800 hover:border-brand-500 text-slate-400 hover:text-white flex items-center justify-center transition-colors focus:outline-none z-30 shadow" aria-label="Close Welcome Popup">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>

            <!-- Form Wrapper Container -->
            <div id="popup-form-container" class="space-y-4 transition-all duration-300">
                <!-- Headings -->
                <div class="space-y-2 pr-6">
                    <!-- Dynamic Zenvora Logo Branding inside Popup Header -->
                    <div class="flex items-center gap-2 mb-2">
                        <img class="h-6 w-auto opacity-95" src="<?php echo getWebSetting('logo_url'); ?>" alt="Zenvora Logo">
                        <span class="font-extrabold text-brand-400 tracking-widest text-[11px] uppercase">Zenvora</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-extrabold text-white flex items-center gap-2">
                        <i class="fa-solid fa-gift text-brand-400"></i> Start Your Journey
                    </h3>
                    <p class="text-[11px] text-slate-300 font-semibold leading-relaxed">
                        Submit your corporate registration requirements. An assigned CA/CS will call you back within 15 minutes.
                    </p>
                </div>

                <!-- Booking Form -->
                <form id="popup-lead-form" action="contact.php" method="POST" class="space-y-3.5 pt-2">
                    <!-- Hidden inputs for page source tracking -->
                    <input type="hidden" name="source_page" value="Welcome Popup Detailed">
                    <input type="hidden" name="org_size" value="1">
                    <input type="hidden" name="timeline" value="immediately">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Full Name -->
                        <div class="space-y-1">
                            <label for="popup-name" class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Full Name *</label>
                            <input type="text" id="popup-name" name="name" required placeholder="Aarav Sharma"
                                class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-950 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-200 placeholder-slate-700">
                        </div>

                        <!-- Phone Number -->
                        <div class="space-y-1">
                            <label for="popup-phone" class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Mobile Number *</label>
                            <input type="tel" id="popup-phone" name="phone" required placeholder="+91 99999 99999"
                                class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-950 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-200 placeholder-slate-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Email Address -->
                        <div class="space-y-1">
                            <label for="popup-email" class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Business Email *</label>
                            <input type="email" id="popup-email" name="email" required placeholder="aarav@company.com"
                                class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-950 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-200 placeholder-slate-700">
                        </div>

                        <!-- Company Name (Optional) -->
                        <div class="space-y-1">
                            <label for="popup-company" class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Company / Brand Name</label>
                            <input type="text" id="popup-company" name="company_name" placeholder="Zenvora Tech Corp"
                                class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-950 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-200 placeholder-slate-700">
                        </div>
                    </div>

                    <!-- Required Service (Dynamic List) -->
                    <div class="space-y-1">
                        <label for="popup-service" class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Required Service *</label>
                        <select id="popup-service" name="service" required
                            class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-950 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-300">
                            <option value="" disabled selected class="bg-slate-900">Select service category...</option>
                            <?php foreach ($popup_services as $p_srv): ?>
                                <option value="<?php echo htmlspecialchars($p_srv['slug']); ?>" class="bg-slate-900 text-slate-200">
                                    <?php echo htmlspecialchars($p_srv['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Message Box -->
                    <div class="space-y-1">
                        <label for="popup-message" class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 block">Tell us about your requirement</label>
                        <textarea id="popup-message" name="message" rows="2" placeholder="Tell us if you want company setup, registrations, tax support, etc."
                            class="w-full text-xs font-semibold px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl focus:border-brand-500 focus:outline-none transition-colors resize-none text-slate-200 placeholder-slate-700"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full text-center py-3 rounded-full text-xs font-black text-white accent-gradient hover:shadow-lg hover:shadow-brand-500/25 transition-all duration-300 block">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Book Free Consultation Call
                    </button>
                </form>
            </div>

            <!-- Success Message Container (Hidden by default, shown via JS) -->
            <div id="popup-success-container" class="hidden flex flex-col items-center justify-center text-center py-10 space-y-5 animate-pulse-slow">
                <div class="w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-3xl shadow-lg border border-emerald-500/20">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="text-lg font-black text-white">Consultation Scheduled!</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-semibold max-w-sm mx-auto">
                        Thank you! Your advisory request has been successfully registered in our dashboard. A qualified CA will contact you within 15 minutes.
                    </p>
                </div>
                <button type="button" id="popup-success-close-btn" class="px-6 py-2.5 rounded-full text-[10px] font-black text-slate-950 bg-brand-500 hover:bg-brand-400 transition-colors uppercase tracking-widest">
                    Continue Browsing
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Modal Control Logic (localStorage & Complex Custom Animations & AJAX Submit) -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('welcome-popup-modal');
        const card = document.getElementById('welcome-modal-card');
        const closeBtn = document.getElementById('close-welcome-popup');
        const successCloseBtn = document.getElementById('popup-success-close-btn');
        const form = document.getElementById('popup-lead-form');

        if (!modal || !card || !closeBtn) return;

        // Check if user closed the modal previously
        const isClosed = localStorage.getItem('zenvora_welcome_popup_closed');

        if (!isClosed) {
            // Trigger popup with 1.8 seconds delay
            setTimeout(() => {
                // Show modal overlay
                modal.classList.remove('opacity-0', 'pointer-events-none');

                // Add right-to-left slide in class to card
                card.classList.remove('opacity-0');
                card.classList.add('popup-animate-enter');
            }, 1800);
        }

        function dismissPopup() {
            // Remove enter class and add left-sliding page-fly-away class
            card.classList.remove('popup-animate-enter');
            card.classList.add('popup-animate-exit');

            // Wait for animation (850ms) to complete, then hide backdrop overlay
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
                card.classList.remove('popup-animate-exit');
                card.classList.add('opacity-0');
            }, 850);

            // Set localStorage so it never triggers again
            localStorage.setItem('zenvora_welcome_popup_closed', 'true');
        }

        // Close on close-button click
        closeBtn.addEventListener('click', dismissPopup);
        if (successCloseBtn) {
            successCloseBtn.addEventListener('click', dismissPopup);
        }

        // Close when clicking on background overlay
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                dismissPopup();
            }
        });

        // AJAX Form Submission (No redirect, inline success message)
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault(); // Stop standard page redirect

                // Show loading state on submit button
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-2"></i> Registering...';

                const companyInput = document.getElementById('popup-company');
                const messageTextarea = document.getElementById('popup-message');

                let finalMessage = messageTextarea.value.trim();
                if (companyInput && companyInput.value.trim() !== '') {
                    finalMessage = `Company Name: ${companyInput.value.trim()}\n\n${finalMessage}`;
                }

                // Put modified value back to form input
                messageTextarea.value = finalMessage;

                const formData = new FormData(form);

                // Submit in background to contact.php via Fetch API
                fetch('contact.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            // Hide form panel and show success container
                            document.getElementById('popup-form-container').classList.add('hidden');
                            document.getElementById('popup-success-container').classList.remove('hidden');

                            // Set localStorage to block popup reappearance
                            localStorage.setItem('zenvora_welcome_popup_closed', 'true');

                            // Automatically close modal after 5 seconds
                            setTimeout(() => {
                                dismissPopup();
                            }, 5000);
                        } else {
                            throw new Error('Server error');
                        }
                    })
                    .catch(error => {
                        // Reset button state on failure
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHtml;
                        alert('Submission failed. Please check your network and try again.');
                    });
            });
        }
    });
</script>