<?php
require_once __DIR__ . '/settings_helper.php';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenvora Global Solutions | Premium Legal, Tax & Compliance Partner</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Zenvora Global Solutions is your premier partner for business setup, company registration, legal compliance, accounting, and growth services. Clean, modern, and compliant.">
    <meta name="keywords" content="Company Registration, GST Filing, Trademark Registration, Bookkeeping, legal Compliance, Startup Consulting, Zenvora">
    
    <!-- Google Fonts - Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN for premium vector icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Configuration matching the Gold and Slate brand colors -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fdfbf7',
                            100: '#f9f3e6',
                            200: '#f1e2c5',
                            300: '#e5ca97',
                            400: '#d7ac63',
                            500: '#bc8731', // Exact Gold from your logo
                            600: '#a36d26',
                            700: '#83521d',
                            800: '#693f18',
                            900: '#573316',
                            950: '#321c0b',
                        },
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['"Space Grotesk"', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(25px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Utilities styling (Scrollbar & backdrop fixes) -->
    <style type="text/css">
        /* Custom Smooth Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #bc8731;
        }

        /* Glassmorphism utility helpers in Light Mode */
        .glass-panel {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(15, 23, 42, 0.05);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(15, 23, 42, 0.04);
            box-shadow: 0 10px 40px -10px rgba(188, 135, 49, 0.06);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #0f172a 30%, #bc8731 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .accent-gradient {
            background: linear-gradient(135deg, #bc8731 0%, #d7ac63 100%);
        }

        /* Dynamic search section glow pulse */
        @keyframes sectionGlow {
            0%, 100% { outline: 0px solid transparent; box-shadow: none; }
            50% { outline: 4px solid #bc8731; box-shadow: 0 0 35px rgba(188, 135, 49, 0.5); }
        }
        .glow-section {
            animation: sectionGlow 2.5s ease-in-out forwards;
            border-radius: 1.5rem;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans selection:bg-brand-100 selection:text-brand-900 overflow-x-hidden">
