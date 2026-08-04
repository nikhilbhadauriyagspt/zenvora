<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Console | Zenvora Global Solutions')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fdfbf7',
                            100: '#f9f3e6',
                            200: '#f1e2c5',
                            300: '#e5ca97',
                            400: '#d7ac63',
                            500: '#bc8731',
                            600: '#a36d26',
                            700: '#83521d',
                            900: '#573316',
                        }
                    },
                    fontFamily: {
                        sans: ['"Space Grotesk"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style type="text/css">
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        ::-webkit-scrollbar-track {
            background: #090f1d;
        }
        ::-webkit-scrollbar-thumb {
            background: #bc8731;
            border-radius: 9999px;
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-100 selection:bg-brand-500 selection:text-white bg-slate-900">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside id="admin-sidebar" class="w-64 bg-slate-950 border-r border-slate-800 p-6 flex flex-col justify-between flex-shrink-0 z-30 transition-all duration-300 ease-in-out">
            <div class="flex flex-col flex-grow space-y-8">
                <!-- Branding -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-400 flex items-center justify-center font-black">Z</div>
                    <div class="text-left">
                        <span class="text-xs font-black tracking-widest text-white block uppercase">Zenvora</span>
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Admin Control</span>
                    </div>
                </div>

                <!-- Nav list -->
                <nav class="flex-1 space-y-1">
                    <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mb-2 whitespace-nowrap text-left">Metrics & Leads</span>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400 hover:bg-slate-850 hover:text-white' }}">
                        <i class="fa-solid fa-chart-line text-sm"></i> <span class="whitespace-nowrap">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.enquiries') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.enquiries') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400 hover:bg-slate-850 hover:text-white' }}">
                        <i class="fa-solid fa-envelope-open-text text-sm"></i> <span class="whitespace-nowrap">Enquiries</span>
                    </a>
                    
                    <span class="block px-3 py-1 text-[9px] font-extrabold text-slate-500 uppercase tracking-widest mt-6 mb-2 whitespace-nowrap text-left">Website Settings</span>
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.settings') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400 hover:bg-slate-850 hover:text-white' }}">
                        <i class="fa-solid fa-sliders text-sm"></i> <span class="whitespace-nowrap">General Settings</span>
                    </a>
                    <a href="{{ route('admin.homepage') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.homepage') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400 hover:bg-slate-850 hover:text-white' }}">
                        <i class="fa-solid fa-rectangle-ad text-sm"></i> <span class="whitespace-nowrap">Hero Manager</span>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.services.*') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400 hover:bg-slate-850 hover:text-white' }}">
                        <i class="fa-solid fa-folder-open text-sm"></i> <span class="whitespace-nowrap">Services catalog</span>
                    </a>
                    <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.blogs.*') ? 'bg-brand-500/10 text-brand-400 border border-brand-500/20' : 'text-slate-400 hover:bg-slate-850 hover:text-white' }}">
                        <i class="fa-solid fa-newspaper text-sm"></i> <span class="whitespace-nowrap">Blog Manager</span>
                    </a>
                </nav>
            </div>

            <!-- Footer Account logout -->
            <div class="border-t border-slate-800 pt-4 flex items-center justify-between">
                <div class="text-left overflow-hidden">
                    <span class="text-[10px] font-black text-slate-500 block uppercase">Logged in as</span>
                    <span class="text-[11px] font-bold text-slate-200 block truncate">{{ Auth::user()->username ?? 'Admin' }}</span>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" id="admin-logout-form" class="inline">
                    @csrf
                    <button type="submit" title="Sign out" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-red-950 text-slate-400 hover:text-red-400 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-sign-out-alt text-xs"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0 overflow-hidden bg-slate-900">
            <!-- Header Bar -->
            <header class="bg-slate-950 border-b border-slate-800 h-16 flex items-center justify-between px-6 flex-shrink-0 relative">
                <div class="flex items-center gap-4">
                    <button type="button" id="sidebar-toggle-btn" class="p-2 rounded-xl border border-slate-800 text-slate-400 hover:bg-slate-900 hover:text-white transition-colors flex items-center justify-center focus:outline-none">
                        <i class="fa-solid fa-bars-staggered text-sm"></i>
                    </button>
                    <span class="text-sm font-black text-white hidden sm:inline-block uppercase tracking-wider">Compliance Command Center</span>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button type="button" id="notification-bell-btn" class="relative p-2 rounded-xl border border-slate-800 text-slate-400 hover:bg-slate-900 hover:text-white transition-all focus:outline-none flex items-center justify-center">
                            <i class="fa-solid fa-bell text-sm"></i>
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
                            <div id="notification-list" class="max-h-60 overflow-y-auto space-y-2 divide-y divide-slate-900">
                                <span class="text-[10px] text-slate-500 block py-4 text-center">Loading...</span>
                            </div>
                            <div class="text-center pt-2 border-t border-slate-900">
                                <a href="{{ route('admin.enquiries') }}" class="text-[9px] font-black uppercase tracking-widest text-brand-400 hover:text-brand-350 transition-colors">
                                    View All Enquiries
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-950/20 border border-emerald-500/20 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">CA Panel Live</span>
                    </div>
                </div>
            </header>

            <!-- Scrollable Workspace Body -->
            <main class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script modules for Sidebar and Bell -->
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

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('w-64');
                    sidebar.classList.toggle('w-0');
                    sidebar.classList.toggle('p-6');
                });
            }

            if (bellBtn && dropdown) {
                bellBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', () => dropdown.classList.add('hidden'));
                dropdown.addEventListener('click', (e) => e.stopPropagation());
            }

            async function checkNotifications() {
                if (!badge || !notificationList) return;
                try {
                    const response = await fetch('{{ route("admin.notifications.pending") }}');
                    const result = await response.json();
                    
                    const count = result.count;
                    if (count > 0) {
                        badge.textContent = count;
                        badge.classList.remove('hidden');
                        countLabel.textContent = `${count} New`;
                        notificationList.innerHTML = result.notifications.map(n => `
                            <div class="py-2.5 space-y-1 block">
                                <div class="flex items-center justify-between">
                                    <strong class="text-xs text-white block truncate w-[70%]">${n.name}</strong>
                                    <span class="text-[8px] text-slate-500 font-bold block">${new Date(n.created_at).toLocaleDateString()}</span>
                                </div>
                                <span class="text-[10px] text-brand-400 block font-semibold uppercase tracking-wider">${n.service}</span>
                            </div>
                        `).join('');
                    } else {
                        badge.classList.add('hidden');
                        countLabel.textContent = '0 New';
                        notificationList.innerHTML = '<span class="text-[10px] text-slate-500 block py-4 text-center">No pending enquiries.</span>';
                    }
                } catch (err) {
                    console.error('Failed to load pending notifications:', err);
                }
            }

            if (clearBtn) {
                clearBtn.addEventListener('click', async () => {
                    if (!confirm('Mark all pending notifications as read?')) return;
                    try {
                        const response = await fetch('{{ route("admin.notifications.clear") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        const result = await response.json();
                        if (result.success) {
                            checkNotifications();
                        }
                    } catch(err) {
                        console.error('Failed to clear notifications:', err);
                    }
                });
            }

            checkNotifications();
            setInterval(checkNotifications, 30000);
        });
    </script>
    @yield('scripts')
</body>
</html>
