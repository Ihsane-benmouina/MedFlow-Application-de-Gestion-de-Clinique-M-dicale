<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedFlow - Premium Clinic Management</title>
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Premium Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/60 text-slate-800 antialiased min-h-screen flex flex-col">

<header class="bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-slate-100 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="/index.php" class="flex items-center gap-3 cursor-pointer">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-blue-600 flex items-center justify-center text-white shadow-md shadow-sky-200">
                <span class="text-xl font-bold">M</span>
            </div>
            <div>
                <span class="text-lg font-extrabold text-slate-900 tracking-tight">Med<span class="text-sky-500">Flow</span></span>
                <span class="block text-[9px] text-slate-400 font-bold tracking-widest uppercase">Smart Clinic</span>
            </div>
        </a>

        <!-- Action Button based on context -->
        <div class="flex items-center gap-4">
            <a href="?action=login" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-sky-600 bg-sky-50 hover:bg-sky-100 transition-all cursor-pointer">
                🔑 Se Connecter
            </a>
        </div>
    </div>
</header>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">