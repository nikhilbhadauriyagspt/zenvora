<?php
/**
 * Zenvora Admin Console - Shared Header Component
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$headerAdminUser = $_SESSION['admin_username'] ?? 'Admin';
?>
<header class="bg-slate-950 border-b border-slate-800 h-16 flex items-center justify-between px-6 flex-shrink-0 relative">
    <!-- Toggle Button -->
    <div class="flex items-center gap-4">
        <button type="button" id="sidebar-toggle-btn" class="p-2 rounded-xl border border-slate-800 text-slate-400 hover:bg-slate-900 hover:text-white transition-colors flex items-center justify-center focus:outline-none">
            <i class="fa-solid fa-bars-staggered text-sm"></i>
        </button>
        <span class="text-sm font-black text-white hidden sm:inline-block uppercase tracking-wider">Compliance Command Center</span>
    </div>

    <!-- Admin Action items -->
    <div class="flex items-center gap-4">
        
        <!-- Notification Bell -->
        <div class="relative">
            <button type="button" id="notification-bell-btn" class="relative p-2 rounded-xl border border-slate-800 text-slate-400 hover:bg-slate-900 hover:text-white transition-all focus:outline-none flex items-center justify-center">
                <i class="fa-solid fa-bell text-sm"></i>
                <!-- Badge count -->
                <span id="notification-badge" class="absolute -top-1 -right-1 hidden w-4 h-4 rounded-full bg-red-650 text-[9px] font-black text-white flex items-center justify-center animate-pulse">0</span>
            </button>
            <!-- Notification Dropdown Panel -->
            <div id="notification-dropdown" class="absolute right-0 mt-3 w-80 bg-slate-950 border border-slate-800 rounded-2xl shadow-2xl p-4 hidden space-y-3 z-50 text-left">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-xs font-black uppercase text-white">Pending Leads</span>
                    <div class="flex items-center gap-2">
                        <button type="button" id="clear-notifications-btn" class="text-[9px] font-black uppercase text-red-400 hover:text-red-300 transition-colors">Clear All</button>
                        <span id="notification-count-label" class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-brand-500/20 text-brand-400">0 New</span>
                    </div>
                </div>
                <!-- List container -->
                <div id="notification-list" class="max-h-60 overflow-y-auto space-y-2 divide-y divide-slate-900">
                    <span class="text-[10px] text-slate-500 block py-4 text-center">Loading notifications...</span>
                </div>
                <div class="text-center pt-2 border-t border-slate-900">
                    <a href="enquiries.php" class="text-[9px] font-black uppercase tracking-widest text-brand-400 hover:text-brand-350 transition-colors">
                        View All Lead Files
                    </a>
                </div>
            </div>
        </div>

        <!-- CA Availability badge -->
        <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-950/20 border border-emerald-500/20 rounded-full">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">CA Panel Live</span>
        </div>
    </div>
</header>

<!-- Notification Polling & Sidebar Toggling Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('admin-sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        const bellBtn = document.getElementById('notification-bell-btn');
        const dropdown = document.getElementById('notification-dropdown');
        const badge = document.getElementById('notification-badge');
        const countLabel = document.getElementById('notification-count-label');
        const notificationList = document.getElementById('notification-list');
        const clearBtn = document.getElementById('clear-notifications-btn');
        
        let lastCount = 0;

        // 1. Sidebar toggle logic (runs if sidebar exists on page)
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-0');
            });
        }

        // 2. Bell dropdown toggling
        if (bellBtn && dropdown) {
            bellBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', () => {
                dropdown.classList.add('hidden');
            });

            dropdown.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }

        // 3. Clear/Mark all read function
        if (clearBtn) {
            clearBtn.addEventListener('click', async () => {
                if (!confirm('Mark all pending notifications as read?')) return;
                try {
                    const response = await fetch('clear_notifications.php', { method: 'POST' });
                    const result = await response.json();
                    if (result.success) {
                        checkNotifications();
                    }
                } catch(err) {
                    console.error('Failed to clear notifications:', err);
                }
            });
        }

        // 4. Polling Function
        async function checkNotifications() {
            if (!badge || !notificationList) return;
            try {
                const response = await fetch('get_pending_notifications.php');
                const result = await response.json();
                
                if (result.success) {
                    const count = result.count;
                    
                    if (count > 0) {
                        badge.textContent = count;
                        badge.classList.remove('hidden');
                        countLabel.textContent = `${count} New`;
                        
                        if (count > lastCount && lastCount !== 0) {
                            bellBtn.classList.add('animate-bounce');
                            setTimeout(() => bellBtn.classList.remove('animate-bounce'), 1000);
                        }
                    } else {
                        badge.classList.add('hidden');
                        countLabel.textContent = '0 New';
                    }
                    
                    if (result.leads.length > 0) {
                        notificationList.innerHTML = result.leads.map(lead => `
                            <div class="py-2.5 space-y-1 block hover:bg-slate-900 transition-colors">
                                <div class="flex items-center justify-between">
                                    <strong class="text-xs text-white block truncate w-[70%]">${lead.name}</strong>
                                    <span class="text-[8px] text-slate-500 font-bold block">${lead.time_ago}</span>
                                </div>
                                <span class="text-[10px] text-brand-400 block font-semibold uppercase tracking-wider">${lead.service}</span>
                            </div>
                        `).join('');
                    } else {
                        notificationList.innerHTML = '<span class="text-[10px] text-slate-500 block py-4 text-center">No pending enquiries.</span>';
                    }
                    
                    lastCount = count;
                }
            } catch (err) {
                console.error('Failed to load pending leads notifications:', err);
            }
        }

        // Initial check and poll interval
        checkNotifications();
        setInterval(checkNotifications, 15000);
    });
</script>
