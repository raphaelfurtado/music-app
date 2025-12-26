<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- SEO & Branding -->
    <title>@yield('title', 'Music App - Organize seu Repertório')</title>
    <meta name="description"
        content="A plataforma definitiva para músicos organizarem setlists e compartilharem com a banda.">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Music App - Organize seu Repertório')">
    <meta property="og:description"
        content="A plataforma definitiva para músicos organizarem setlists e compartilharem com a banda.">
    <meta property="og:image" content="{{ asset('logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Music App - Organize seu Repertório')">
    <meta property="twitter:description"
        content="A plataforma definitiva para músicos organizarem setlists e compartilharem com a banda.">
    <meta property="twitter:image" content="{{ asset('logo.png') }}">

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class", // Isso diz ao Tailwind para obedecer a classe 'dark' no html
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

    @livewireStyles
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white h-screen w-screen overflow-hidden flex flex-col">

    <div class="flex-none z-30"></div>

    @php
        $globalNotice = \App\Models\Setting::where('key', 'global_notice_active')->first()?->value === '1'
            ? [
                'message' => \App\Models\Setting::where('key', 'global_notice_message')->first()?->value,
                'type' => \App\Models\Setting::where('key', 'global_notice_type')->first()?->value ?? 'info'
            ] : null;

        $isMaintenance = \App\Models\Setting::where('key', 'maintenance_mode')->first()?->value === '1';
        $isAdmin = auth()->check() && auth()->user()->is_admin;
    @endphp

    @if($globalNotice && $globalNotice['message'])
        @php
            $bgClass = match($globalNotice['type']) {
                'error' => 'bg-red-500',
                'warning' => 'bg-amber-500',
                'success' => 'bg-emerald-500',
                default => 'bg-primary'
            };
        @endphp
        <div class="flex-none z-40 {{ $bgClass }} text-white px-4 py-2 text-center text-xs md:text-sm font-bold shadow-lg border-b border-white/10">
            <div class="max-w-md mx-auto flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-base">campaign</span>
                {{ $globalNotice['message'] }}
            </div>
        </div>
    @endif

    @if($isMaintenance && !$isAdmin)
        <div
            class="fixed inset-0 z-[100] bg-background-dark/95 backdrop-blur-md flex items-center justify-center p-6 text-center">
            <div class="max-w-xs">
                <div class="w-20 h-20 bg-red-500/20 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-5xl">construction</span>
                </div>
                <h2 class="text-2xl font-black text-white mb-4 italic tracking-tight uppercase">Manutenção</h2>
                <p class="text-gray-400 mb-8 leading-relaxed">O sistema está passando por ajustes rápidos para melhorar sua
                    experiência. Voltamos em alguns minutos!</p>
                <div class="h-1 w-12 bg-primary mx-auto rounded-full"></div>
            </div>
        </div>
    @elseif($isMaintenance && $isAdmin)
        <div
            class="fixed top-4 right-4 z-[90] flex items-center gap-2 px-3 py-1.5 bg-red-500 text-white text-[10px] font-bold rounded-full shadow-lg border border-white/20 uppercase tracking-widest animate-pulse">
            <span class="material-symbols-outlined text-sm">engineering</span>
            Modo Manutenção Ativo
        </div>
    @endif

    @if(session('success'))
        <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-green-500 text-white px-6 py-3 rounded-full shadow-lg font-medium text-sm animate-bounce"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-red-500 text-white px-6 py-3 rounded-full shadow-lg font-medium text-sm animate-bounce"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            {{ session('error') }}
        </div>
    @endif

    <main class="flex-1 w-full max-w-md mx-auto overflow-y-auto no-scrollbar relative pb-32">
        @yield('content')
    </main>

    @auth
        @include('layouts.navigation-bar')
    @endauth

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
    @stack('scripts')
</body>

</html>