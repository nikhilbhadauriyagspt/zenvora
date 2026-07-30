<!-- Premium Auto-Scrolling Marquee Accent Strip -->
<div class="relative w-full overflow-hidden bg-slate-900 border-y border-slate-850 py-4 z-20 select-none">
    
    <!-- CSS Animation Styles (Scoped to this component) -->
    <style type="text/css">
        @keyframes marqueeLoop {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marqueeLoop 25s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused; /* Pause on hover for interactive feel */
        }
    </style>

    <div class="marquee-track flex whitespace-nowrap">
        <!-- Marquee Group 1 -->
        <div class="flex items-center gap-12 text-[10px] sm:text-xs font-black uppercase tracking-widest text-brand-400">
            <span>Company Incorporation</span> <span class="text-slate-700 font-normal">/</span>
            <span class="text-white">GST Filing & Return</span> <span class="text-slate-700 font-normal">/</span>
            <span>Trademark Registration</span> <span class="text-slate-700 font-normal">/</span>
            <span class="text-white">Direct CA & CS Desk</span> <span class="text-slate-700 font-normal">/</span>
            <span>Income Tax Filings</span> <span class="text-slate-700 font-normal">/</span>
            <span class="text-white">NGO Trust Setup</span> <span class="text-slate-700 font-normal">/</span>
            <span>Startup DPIIT Recognition</span> <span class="text-slate-700 font-normal">/</span>
            <span class="text-white">Corporate Compliance Audits</span> <span class="text-slate-700 font-normal">/</span>
        </div>

        <!-- Marquee Group 2 (Duplicate for Seamless Loop) -->
        <div class="flex items-center gap-12 text-[10px] sm:text-xs font-black uppercase tracking-widest text-brand-400 ml-12">
            <span>Company Incorporation</span> <span class="text-slate-700 font-normal">/</span>
            <span class="text-white">GST Filing & Return</span> <span class="text-slate-700 font-normal">/</span>
            <span>Trademark Registration</span> <span class="text-slate-700 font-normal">/</span>
            <span class="text-white">Direct CA & CS Desk</span> <span class="text-slate-700 font-normal">/</span>
            <span>Income Tax Filings</span> <span class="text-slate-700 font-normal">/</span>
            <span class="text-white">NGO Trust Setup</span> <span class="text-slate-700 font-normal">/</span>
            <span>Startup DPIIT Recognition</span> <span class="text-slate-700 font-normal">/</span>
            <span class="text-white">Corporate Compliance Audits</span> <span class="text-slate-700 font-normal">/</span>
        </div>
    </div>
</div>
