<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Zenvora Global Solutions</title>
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
                            500: '#bc8731',
                            600: '#a36d26',
                            400: '#d7ac63'
                        }
                    },
                    fontFamily: {
                        sans: ['"Space Grotesk"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 font-sans">

    <main class="w-full max-w-md bg-white border border-slate-200 p-8 rounded-3xl space-y-6 relative overflow-hidden shadow-xl">
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-400"></div>

        <div class="text-center space-y-4">
            <a href="{{ route('home') }}" class="inline-block">
                <img class="h-14 w-auto object-contain mx-auto" src="{{ asset(getWebSetting('logo_url')) }}" alt="Logo">
            </a>
            <div class="space-y-1">
                <h1 class="text-xl font-black text-slate-900 tracking-tight">Admin Console</h1>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Secure Portal Access</p>
            </div>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs p-4 rounded-xl flex items-center gap-3 text-left font-semibold">
                <i class="fa-solid fa-circle-exclamation text-sm flex-shrink-0"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-4 text-left">
            @csrf
            <div class="space-y-1.5">
                <label for="username" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-user text-slate-400 text-xs"></i>
                    </div>
                    <input type="text" id="username" name="username" required value="{{ old('username') }}" placeholder="Enter username..." 
                           class="w-full text-sm font-semibold pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="password" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400 text-xs"></i>
                    </div>
                    <input type="password" id="password" name="password" required placeholder="Enter password..." 
                           class="w-full text-sm font-semibold pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full text-center py-3.5 mt-2 rounded-full text-xs font-black text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                Authenticate Credentials
            </button>
        </form>
    </main>

</body>
</html>
