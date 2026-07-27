<!-- Zenvora Contact & Consultation Booking Form (Light Theme, 2-Column Grid, No Shadows, Clean Standard Tailwind CSS) -->
<section id="contact" class="relative py-24 bg-white border-t border-slate-100 overflow-hidden">
    <!-- Subtle Background Decorators -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            
            <!-- Left Column: Contact info details (col-span-5) -->
            <div class="lg:col-span-5 space-y-8 text-left">
                
                <!-- Section Header -->
                <div class="space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-extrabold bg-brand-500/10 border border-brand-500/20 text-brand-700 uppercase tracking-widest">
                        <i class="fa-solid fa-headset mr-1"></i> Contact Us
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Schedule a Free <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Advisory Call.</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-base leading-relaxed font-semibold">
                        Speak with our qualified corporate advisors and CAs to map out your registration, licensing, and taxation compliance in under 15 minutes.
                    </p>
                </div>

                <!-- Contact Channels -->
                <div class="space-y-4 text-sm font-semibold text-slate-700">
                    <!-- Phone -->
                    <a href="tel:<?php echo getWebSetting('phone_1'); ?>" class="flex items-center gap-4 p-5 rounded-xl border border-slate-200/50 bg-slate-50/50 hover:border-brand-500/30 transition-colors">
                        <div class="w-10 h-10 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-base flex-shrink-0">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-xs">Call Support</span>
                            <span class="text-slate-900 font-extrabold mt-0.5 block"><?php echo getWebSetting('phone_1'); ?></span>
                        </div>
                    </a>
                    
                    <!-- Email -->
                    <a href="mailto:<?php echo getWebSetting('email_1'); ?>" class="flex items-center gap-4 p-5 rounded-xl border border-slate-200/50 bg-slate-50/50 hover:border-brand-500/30 transition-colors">
                        <div class="w-10 h-10 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-base flex-shrink-0">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-xs">Email Enquiries</span>
                            <span class="text-slate-900 font-extrabold mt-0.5 block"><?php echo getWebSetting('email_1'); ?></span>
                        </div>
                    </a>

                    <!-- Office Address -->
                    <div class="flex items-center gap-4 p-5 rounded-xl border border-slate-200/50 bg-slate-50/50">
                        <div class="w-10 h-10 rounded-lg bg-brand-500/10 text-brand-500 flex items-center justify-center text-base flex-shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-xs">Main Head Office</span>
                            <span class="text-slate-900 font-extrabold mt-0.5 block leading-normal">
                                <?php echo getWebSetting('address_noida'); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Live availability label -->
                <div class="flex items-center gap-2.5 px-4 py-3 bg-emerald-500/5 border border-emerald-500/15 rounded-xl">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></span>
                    <span class="text-xs font-bold text-slate-700">CA Panel Currently Available (Current wait time: 4 mins)</span>
                </div>
            </div>

            <!-- Right Column: Glassmorphic consulting form (col-span-7, No Shadows) -->
            <div class="lg:col-span-7 bg-slate-50/50 border border-slate-200 p-6 sm:p-8 rounded-3xl">
                <!-- Form Header Intro Content (Larger Fonts) -->
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

                    <!-- Hidden fields to support database fields from home component -->
                    <input type="hidden" name="org_size" value="1">
                    <input type="hidden" name="timeline" value="immediately">

                    <!-- Message details -->
                    <div class="space-y-1.5">
                        <label for="form-message" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Tell us about your requirement</label>
                        <textarea id="form-message" name="message" rows="4" placeholder="Briefly specify what business registrations or licensing you are looking for..." 
                                  class="w-full text-sm font-semibold px-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors resize-none"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full text-center py-4 rounded-full text-sm font-bold text-white accent-gradient hover:opacity-95 transition-all duration-300">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Book Free Consultation Call
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
