<!DOCTYPE html>
<html class="dark" lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Boas-Vindas</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
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
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        body { min-height: 100dvh; }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white overflow-hidden h-screen w-screen flex flex-col relative">
    
    <div class="absolute top-0 left-0 w-full h-[60%] z-0">
        <img alt="Microphone on stage" class="w-full h-full object-cover opacity-90 dark:opacity-60" 
             src="https://lh3.googleusercontent.com/aida-public/AB6AXuAd2Ga-bcmNJBPb4KAZGq0NGI2X5UHlIgy9E2rKfkx0tgZ-Pk9YOGPd2pGlGEDCvr3K5MnsUb1IR4UFwoE2n0Qg4bYxWeAoA9sJVloL-DSLeA-MlWwBjalqaziow8YilE-QPAlv9tIGG7uor8rthGBguUtxdma6HFBcI1vXPiCTTw84VWu2bD10iamocVha9lHQQfxM2GLJ_89GmtpoJHN8Wqixg80baRs4WBegV_jVtam1UZeNDl_cZoUHq33LmYtJ7_IK6X021_k" />
        
        <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-background-light/20 to-background-light dark:via-background-dark/20 dark:to-background-dark"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-background-light via-background-light/80 to-transparent dark:from-background-dark dark:via-background-dark/80 dark:to-transparent"></div>
    </div>

    <main class="relative z-10 flex flex-col justify-end h-full w-full max-w-md mx-auto px-6 pb-12 pt-10">
        
        <div class="flex justify-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-400 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <span class="material-symbols-outlined text-white text-4xl">queue_music</span>
            </div>
        </div>

        <div class="text-center space-y-4 mb-10">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 dark:text-white leading-tight">
                Seu repertório,<br />
                <span class="text-primary">reinventado.</span>
            </h1>
            <p class="text-slate-600 dark:text-gray-400 text-lg leading-relaxed max-w-[90%] mx-auto">
                Organize shows em blocos, gerencie tons e receba sugestões inteligentes para a performance perfeita.
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-2 mb-10 opacity-80">
            <span class="px-3 py-1 rounded-full bg-white/50 dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-xs font-medium text-slate-600 dark:text-gray-300 backdrop-blur-sm flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">grid_view</span> Blocos
            </span>
            <span class="px-3 py-1 rounded-full bg-white/50 dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-xs font-medium text-slate-600 dark:text-gray-300 backdrop-blur-sm flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">piano</span> Tons
            </span>
            <span class="px-3 py-1 rounded-full bg-white/50 dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-xs font-medium text-slate-600 dark:text-gray-300 backdrop-blur-sm flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">lightbulb</span> Sugestões
            </span>
        </div>

        <div class="flex flex-col gap-4 w-full">
            <a href="{{ route('register') }}" class="w-full py-4 px-6 rounded-2xl bg-primary text-white font-bold text-lg shadow-xl shadow-blue-500/20 hover:bg-blue-600 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 text-center cursor-pointer">
                Criar Conta
                <span class="material-symbols-outlined text-xl">arrow_forward</span>
            </a>

            <a href="{{ route('login') }}" class="w-full py-4 px-6 rounded-2xl bg-white dark:bg-surface-dark text-slate-700 dark:text-white border border-gray-200 dark:border-gray-700 font-semibold text-lg hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-[0.98] transition-all duration-200 text-center cursor-pointer">
                Entrar
            </a>
        </div>

        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400 dark:text-gray-500">
                Ao continuar, você concorda com nossos <br />
                <a class="underline decoration-gray-400 dark:decoration-gray-600 underline-offset-2 hover:text-primary transition-colors" href="#">Termos de Serviço</a> e <a class="underline decoration-gray-400 dark:decoration-gray-600 underline-offset-2 hover:text-primary transition-colors" href="#">Política de Privacidade</a>.
            </p>
        </div>
    </main>
</body>
</html>