<!DOCTYPE html>
<html lang="pt-BR" class="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "rgb(var(--nm-primary) / <alpha-value>)",
                        "samba-gold": "rgb(var(--nm-primary) / <alpha-value>)",
                        "samba-green": "rgb(var(--nm-tertiary) / <alpha-value>)",
                        "primary-container": "rgb(var(--nm-primary-container) / <alpha-value>)",
                        "on-primary-container": "rgb(var(--nm-on-primary-container) / <alpha-value>)",
                        "dark-bg": "rgb(var(--nm-surface) / <alpha-value>)",
                        "dark-card": "rgb(var(--nm-surface-container-low) / <alpha-value>)",
                        "background-light": "rgb(var(--nm-surface) / <alpha-value>)",
                        "background-dark": "rgb(var(--nm-surface) / <alpha-value>)",
                        "surface-dark": "rgb(var(--nm-surface-container-low) / <alpha-value>)",
                        "surface-light": "rgb(var(--nm-on-surface) / <alpha-value>)",
                        "surface": "rgb(var(--nm-surface) / <alpha-value>)",
                        "surface-container-lowest": "rgb(var(--nm-surface-container-lowest) / <alpha-value>)",
                        "surface-container-low": "rgb(var(--nm-surface-container-low) / <alpha-value>)",
                        "surface-container": "rgb(var(--nm-surface-container) / <alpha-value>)",
                        "surface-container-high": "rgb(var(--nm-surface-container-high) / <alpha-value>)",
                        "surface-container-highest": "rgb(var(--nm-surface-container-highest) / <alpha-value>)",
                        "surface-bright": "rgb(var(--nm-surface-bright) / <alpha-value>)",
                        "outline-variant": "rgb(var(--nm-outline-variant) / <alpha-value>)",
                        "on-surface": "rgb(var(--nm-on-surface) / <alpha-value>)",
                        "on-surface-variant": "rgb(var(--nm-on-surface-variant) / <alpha-value>)",
                        "tertiary": "rgb(var(--nm-tertiary) / <alpha-value>)",
                    },
                    fontFamily: {
                        "headline": ["Noto Serif", "serif"],
                        "body": ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        "sm": "0.125rem",
                        "md": "0.375rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                    }
                },
            },
        }
    </script>

    <style>
        :root {
            --nm-primary: 242 202 80;
            --nm-primary-container: 212 175 55;
            --nm-on-primary-container: 60 47 0;
            --nm-surface: 19 19 19;
            --nm-surface-container-lowest: 14 14 14;
            --nm-surface-container-low: 28 27 27;
            --nm-surface-container: 32 31 31;
            --nm-surface-container-high: 42 42 42;
            --nm-surface-container-highest: 53 53 52;
            --nm-surface-bright: 58 57 57;
            --nm-outline-variant: 77 70 53;
            --nm-on-surface: 229 226 225;
            --nm-on-surface-variant: 208 197 175;
            --nm-tertiary: 88 231 170;
        }

        .nm-gradient-gold {
            background-image: linear-gradient(135deg, rgb(var(--nm-primary)) 0%, rgb(var(--nm-primary-container)) 100%);
        }

        .nm-glass {
            background: rgb(var(--nm-surface-container) / 0.85);
            backdrop-filter: blur(16px);
        }

        .nm-shadow {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5);
        }

        .nm-focus-ring:focus-visible {
            outline: 2px solid rgb(var(--nm-primary));
            outline-offset: 2px;
        }

        .nm-card {
            border: 1px solid rgb(var(--nm-outline-variant) / 0.25);
            background: rgb(var(--nm-surface-container-low));
            border-radius: 0.75rem;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);
        }
    </style>

    @livewireStyles
</head>

<body class="bg-surface text-on-surface font-body min-h-screen flex flex-col">

    @include('layouts.navigation')

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
            $bgClass = match ($globalNotice['type']) {
                'error' => 'bg-red-500',
                'warning' => 'bg-amber-500',
                'success' => 'bg-tertiary',
                default => 'bg-primary'
            };
        @endphp
        <div class="z-40 {{ $bgClass }} text-surface px-4 py-2 text-center text-xs md:text-sm font-bold shadow-lg">
            <div class="max-w-7xl mx-auto flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-base">campaign</span>
                {{ $globalNotice['message'] }}
            </div>
        </div>
    @endif

    @if($isMaintenance && !$isAdmin)
        <div class="fixed inset-0 z-[100] bg-dark-bg/95 backdrop-blur-md flex items-center justify-center p-6 text-center">
            <div class="max-w-md">
                <div
                    class="w-20 h-20 bg-samba-gold/20 text-samba-gold rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-5xl">construction</span>
                </div>
                <h2 class="text-3xl font-black text-white mb-4 italic tracking-tight uppercase">Em Manutenção</h2>
                <p class="text-gray-400 mb-8 leading-relaxed">Estamos afinando os instrumentos. Voltamos em alguns minutos!
                </p>
                <div class="h-1.5 w-16 bg-samba-gold mx-auto rounded-full"></div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-tertiary text-surface px-6 py-3 rounded-md shadow-xl font-bold text-sm flex items-center gap-2 animate-bounce"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <main class="flex-1 w-full max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-8 xl:py-10">
        @yield('content')
    </main>

    <footer class="py-12 border-t border-outline-variant/20 bg-surface-container-low mt-auto">
        <div class="max-w-screen-2xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-8 text-on-surface-variant">
            <div class="flex items-center gap-3 opacity-80">
                <span class="material-symbols-outlined text-2xl">music_note</span>
                <span class="font-headline font-bold text-lg uppercase italic tracking-tight text-primary">SambaApp</span>
            </div>

            <p class="text-sm">© {{ date('Y') }} SambaApp. Viva o Samba.</p>
        </div>
    </footer>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
    @stack('scripts')
</body>

</html>