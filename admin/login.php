<?php
/**
 * Zenvora Global Solutions - Admin Login Portal
 */
session_start();
require_once '../components/db_connect.php';

// If user is already logged in, redirect straight to admin panel
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

$errorMsg = '';

// Handle login attempt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameInput = trim($_POST['username']);
    $passwordInput = trim($_POST['password']);
    
    if (empty($usernameInput) || empty($passwordInput)) {
        $errorMsg = 'Please enter both username and password.';
    } else {
        if ($pdo === null) {
            $errorMsg = 'Database connection failed. Please run db_init.php first.';
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :user LIMIT 1");
                $stmt->execute([':user' => $usernameInput]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($passwordInput, $user['password'])) {
                    // Start session
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_username'] = $user['username'];
                    $_SESSION['admin_role'] = $user['role'];
                    
                    header('Location: admin.php');
                    exit;
                } else {
                    $errorMsg = 'Invalid username or password.';
                }
            } catch (PDOException $e) {
                $errorMsg = 'Query error: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Zenvora Global Solutions</title>
    <meta name="description" content="Secure portal login for Zenvora Global Solutions administrators.">
    
    <!-- Load Head dependencies (Tailwind CDN, Fonts, Font Awesome) -->
    <?php include_once '../components/head.php'; ?>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 selection:bg-brand-500 selection:text-white">

    <main class="w-full max-w-md bg-white border border-slate-200 p-8 rounded-3xl space-y-6 relative overflow-hidden">
        <!-- Subtle gold line decorative header -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-400"></div>

        <!-- Logo Icon in Center -->
        <div class="text-center space-y-4">
            <a href="../index.php" class="inline-block">
                <img class="h-14 w-auto object-contain mx-auto" src="../assets/images/logo/Zenvora_Global_Solutions_Logo.png" alt="Zenvora Logo">
            </a>
            <div class="space-y-1">
                <h1 class="text-xl font-black text-slate-900 tracking-tight">Admin Console</h1>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Secure Portal Access</p>
            </div>
        </div>

        <!-- Error Alerts -->
        <?php if (!empty($errorMsg)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs p-4 rounded-xl flex items-center gap-3 text-left font-semibold">
                <i class="fa-solid fa-circle-exclamation text-sm flex-shrink-0"></i>
                <span><?php echo htmlspecialchars($errorMsg); ?></span>
            </div>
        <?php endif; ?>

        <!-- Form fields -->
        <form action="login.php" method="POST" class="space-y-4 text-left">
            <!-- Username -->
            <div class="space-y-1.5">
                <label for="username" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-user text-slate-400 text-xs"></i>
                    </div>
                    <input type="text" id="username" name="username" required placeholder="Enter username..." 
                           class="w-full text-sm font-semibold pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="text-xs font-extrabold uppercase tracking-widest text-slate-500">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400 text-xs"></i>
                    </div>
                    <input type="password" id="password" name="password" required placeholder="Enter password..." 
                           class="w-full text-sm font-semibold pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-brand-500 focus:outline-none transition-colors">
                </div>
            </div>

            <!-- Options -->
            <div class="flex items-center justify-between text-[11px] font-bold text-slate-500">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-200 text-brand-500 focus:ring-brand-500">
                    <span>Remember this session</span>
                </label>
                <a href="https://wa.me/919876543210" target="_blank" class="text-brand-650 hover:underline">Forgot credentials?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full text-center py-3.5 mt-2 rounded-full text-xs font-black text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                Authenticate Credentials
            </button>
        </form>

        <!-- Redirect to db helper -->
        <div class="text-center pt-2 border-t border-slate-100">
            <span class="text-[10px] text-slate-400 font-semibold">First time logging in?</span>
            <a href="db_init.php" class="text-[10px] text-brand-650 font-extrabold ml-1 hover:underline">Initialize Database</a>
        </div>
    </main>

</body>

</html>
