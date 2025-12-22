<!DOCTYPE html>
<html class="dark" lang="pt-BR">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'App Música')</title>
    
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                        "surface-dark": "#1b2733",
                        "surface-light": "#ffffff",
                    },
                    fontFamily: { "display": ["Plus Jakarta Sans", "sans-serif"] }
                },
            },
        }
    </script>
    <style> body { min-height: max(884px, 100dvh); } </style>
    @livewireStyles
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white overflow-hidden h-screen flex flex-col items-center justify-center">    
    @yield('content')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
</body>
</html>