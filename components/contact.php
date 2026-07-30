<!-- Zenvora Contact & Consultation Booking Form (Dark Theme, Glassmorphic 2-Column Grid, Full Background Image) -->
<section id="contact" class="relative py-24 overflow-hidden bg-cover bg-center" style="background-image: url('assets/images/contact_bg.jpg');">
    <!-- Dark gradient overlay for text readability -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950/90 via-slate-950/70 to-slate-950/90 pointer-events-none"></div>
    <!-- Subtle Background Decorators -->
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none bg-[radial-gradient(#bc8731_1px,transparent_1px)] [background-size:24px_24px]"></div>
    
    <!-- Glowing glass orbs -->
    <div class="absolute -top-20 -right-20 w-[450px] h-[450px] bg-brand-500/10 rounded-full blur-[130px] pointer-events-none"></div>
    <div class="absolute -bottom-20 -left-20 w-[450px] h-[450px] bg-brand-500/5 rounded-full blur-[130px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            <!-- Left Column: Contact info details (col-span-5, wrapped in Glassmorphic Panel for 100% readability) -->
            <div class="lg:col-span-5 space-y-8 text-left bg-slate-950/55 backdrop-blur-xl border border-white/10 p-6 sm:p-8 rounded-3xl shadow-2xl shadow-black/40 flex flex-col justify-between">
                
                <!-- Section Header -->
                <div class="space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-extrabold bg-brand-500/10 border border-brand-500/30 text-brand-400 uppercase tracking-widest">
                        <i class="fa-solid fa-headset mr-1"></i> Contact Us
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-50 tracking-tight leading-tight">
                        Schedule a Free <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-brand-300">Advisory Call.</span>
                    </h2>
                    <p class="text-slate-200 text-xs sm:text-sm leading-relaxed font-semibold drop-shadow-sm">
                        Speak with our qualified corporate advisors and CAs to map out your registration, licensing, and taxation compliance in under 15 minutes.
                    </p>
                </div>

                <!-- Contact Channels (Glassmorphic Cards) -->
                <div class="space-y-4 text-sm font-semibold text-slate-300">
                    <!-- Phone -->
                    <a href="tel:<?php echo getWebSetting('phone_1'); ?>" class="flex items-center gap-4 p-4 rounded-xl border border-white/5 bg-slate-950/45 backdrop-blur-lg hover:border-brand-500/30 transition-all duration-300 shadow-md">
                        <div class="w-10 h-10 rounded-lg bg-brand-500/15 text-brand-400 flex items-center justify-center text-base flex-shrink-0">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs">Call Support</span>
                            <span class="text-white font-extrabold mt-0.5 block"><?php echo getWebSetting('phone_1'); ?></span>
                        </div>
                    </a>
                    
                    <!-- Email -->
                    <a href="mailto:<?php echo getWebSetting('email_1'); ?>" class="flex items-center gap-4 p-4 rounded-xl border border-white/5 bg-slate-950/45 backdrop-blur-lg hover:border-brand-500/30 transition-all duration-300 shadow-md">
                        <div class="w-10 h-10 rounded-lg bg-brand-500/15 text-brand-400 flex items-center justify-center text-base flex-shrink-0">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs">Email Enquiries</span>
                            <span class="text-white font-extrabold mt-0.5 block"><?php echo getWebSetting('email_1'); ?></span>
                        </div>
                    </a>

                    <!-- Office Address -->
                    <div class="flex items-center gap-4 p-4 rounded-xl border border-white/5 bg-slate-950/45 backdrop-blur-lg shadow-md">
                        <div class="w-10 h-10 rounded-lg bg-brand-500/15 text-brand-400 flex items-center justify-center text-base flex-shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs">Main Head Office</span>
                            <span class="text-slate-200 font-extrabold mt-0.5 block leading-normal text-xs">
                                <?php echo getWebSetting('address_noida'); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Live availability label -->
                <div class="flex items-center gap-2.5 px-4 py-3 bg-emerald-500/10 border border-emerald-500/25 rounded-xl backdrop-blur-sm mt-4">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></span>
                    <span class="text-[10px] font-bold text-slate-350">CA Panel Available (Wait: 4 mins)</span>
                </div>
            </div>

            <!-- Right Column: Glassmorphic consulting form (col-span-7) -->
            <div class="lg:col-span-7 bg-slate-950/55 backdrop-blur-xl border border-white/10 p-6 sm:p-8 rounded-3xl shadow-2xl shadow-black/40 flex flex-col justify-between">
                <!-- Form Header Intro Content -->
                <div class="mb-6 space-y-1.5 pb-4 border-b border-white/10">
                    <h3 class="text-base font-extrabold text-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane text-brand-400"></i> Request a Call Back
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-semibold leading-relaxed">
                        Fill out the details below. A dedicated compliance CA or legal advisor will review your requirement and call you back within 15 minutes.
                    </p>
                </div>
                
                <form action="contact.php" method="POST" class="space-y-5 text-left">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Full Name -->
                        <div class="space-y-1.5">
                            <label for="form-name" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Full Name</label>
                            <input type="text" id="form-name" name="name" required placeholder="Aarav Sharma" 
                                   class="w-full text-sm font-semibold px-4 py-3 bg-slate-950/70 border border-white/10 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-200 placeholder-slate-700">
                        </div>
                        
                        <!-- Phone Number -->
                        <div class="space-y-1.5">
                            <label for="form-phone" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Mobile Number</label>
                            <input type="tel" id="form-phone" name="phone" required placeholder="+91 99999 99999" 
                                   class="w-full text-sm font-semibold px-4 py-3 bg-slate-950/70 border border-white/10 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-200 placeholder-slate-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Email -->
                        <div class="space-y-1.5">
                            <label for="form-email" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Business Email</label>
                            <input type="email" id="form-email" name="email" required placeholder="aarav@company.com" 
                                   class="w-full text-sm font-semibold px-4 py-3 bg-slate-950/70 border border-white/10 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-200 placeholder-slate-700">
                        </div>
                        
                        <!-- Service Category -->
                        <div class="space-y-1.5">
                            <label for="form-service" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Required Service</label>
                            <select id="form-service" name="service" required 
                                    class="w-full text-sm font-semibold px-4 py-3 bg-slate-950/70 border border-white/10 rounded-xl focus:border-brand-500 focus:outline-none transition-colors text-slate-300">
                                <option value="" disabled selected class="bg-slate-950">Select category...</option>
                                <option value="startup" class="bg-slate-950">Business Startup Registration</option>
                                <option value="tax" class="bg-slate-950">GST & Tax Compliances</option>
                                <option value="licenses" class="bg-slate-950">Operational Licenses</option>
                                <option value="certifications" class="bg-slate-950">ISO & Trademarking</option>
                                <option value="ngo" class="bg-slate-950">NGO & Trust setup</option>
                            </select>
                        </div>
                    </div>

                    <!-- Hidden fields to support database fields from home component -->
                    <input type="hidden" name="org_size" value="1">
                    <input type="hidden" name="timeline" value="immediately">
                    <input type="hidden" name="source_page" value="Homepage">

                    <!-- Message details -->
                    <div class="space-y-1.5">
                        <label for="form-message" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Tell us about your requirement</label>
                        <textarea id="form-message" name="message" rows="4" placeholder="Briefly specify what business registrations or licensing you are looking for..." 
                                  class="w-full text-sm font-semibold px-4 py-3 bg-slate-950/70 border border-white/10 rounded-xl focus:border-brand-500 focus:outline-none transition-colors resize-none text-slate-200 placeholder-slate-700"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full text-center py-4 rounded-full text-sm font-bold text-white accent-gradient hover:shadow-lg hover:shadow-brand-500/25 transition-all duration-300">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Book Free Consultation Call
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
