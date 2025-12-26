<!DOCTYPE html>
<html class="scroll-smooth" lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MusicApp - Domine seu Repertório Musical</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "dark-bg": "#0a0f14",
                        "dark-card": "#161e27",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    animation: {
                        'gradient': 'gradient 8s linear infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        gradient: {
                            '0%, 100%': { 'background-size': '200% 200%', 'background-position': 'left center' },
                            '50%': { 'background-size': '200% 200%', 'background-position': 'right center' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-nav {
            background: rgba(10, 15, 20, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: #137fec;
            box-shadow: 0 20px 40px -20px rgba(19, 127, 236, 0.3);
        }

        .hero-glow {
            background: radial-gradient(circle at 50% 50%, rgba(19, 127, 236, 0.15) 0%, transparent 50%);
        }
    </style>
</head>

<body class="bg-dark-bg text-white selection:bg-primary/30">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="#" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-white text-2xl">queue_music</span>
                </div>
                <span class="text-xl font-bold tracking-tight">MusicApp</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#features"
                    class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Funcionalidades</a>
                <a href="#how-it-works"
                    class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Como Funciona</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}"
                    class="text-sm font-semibold hover:text-primary transition-colors px-4 py-2">Entrar</a>
                <a href="{{ route('register') }}"
                    class="bg-primary hover:bg-blue-600 px-5 py-2.5 rounded-full text-sm font-bold transition-all shadow-lg shadow-primary/20 hover:shadow-primary/40 active:scale-95">
                    Começar Agora
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden min-h-screen flex items-center">
        <div class="absolute inset-0 hero-glow"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/10 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-500/10 blur-[120px] rounded-full"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-8 animate-fade-in">
                <span class="flex h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-xs font-bold text-gray-300 uppercase tracking-widest">A revolução no seu palco</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8 leading-[1.1]">
                Domine seu <span
                    class="bg-gradient-to-r from-primary to-cyan-400 bg-clip-text text-transparent animate-gradient">Repertório
                    Musical</span>
            </h1>

            <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                A ferramenta definitiva para músicos e bandas organizarem shows, gerenciarem setlists e focarem no que
                realmente importa: a música.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-primary text-white font-extrabold text-lg shadow-2xl shadow-primary/30 hover:bg-blue-600 transition-all active:scale-95 flex items-center justify-center gap-2">
                    Criar Minha Conta Grátis
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
                <a href="#features"
                    class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/5 border border-white/10 font-bold text-lg hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                    Ver Funcionalidades
                </a>
            </div>

            <!-- Dashboard Preview -->
            <div class="mt-20 relative max-w-5xl mx-auto animate-float">
                <div class="absolute inset-0 bg-primary/20 blur-[100px] rounded-full -z-10"></div>
                <div
                    class="rounded-3xl border border-white/10 bg-dark-card/50 backdrop-blur-sm p-4 shadow-2xl overflow-hidden aspect-video flex items-center justify-center text-gray-500 border-dashed border-2">
                    <div class="flex flex-col items-center">
                        <span class="material-symbols-outlined text-6xl mb-4">analytics</span>
                        <p class="text-lg font-medium italic">Seu palco, organizado e digital.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-32 bg-dark-bg/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-5xl font-bold mb-6 italic">Tudo que você precisa em um só lugar.</h2>
                <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="feature-card p-8 rounded-3xl bg-dark-card border border-white/5 flex flex-col items-start gap-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl">library_music</span>
                    </div>
                    <h3 class="text-2xl font-bold">Gestão Profissional</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        Crie e organize múltiplos repertórios por shows, eventos ou estilos. Mantenha suas músicas
                        sempre à mão de forma rápida e intuitiva.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="feature-card p-8 rounded-3xl bg-dark-card border border-white/5 flex flex-col items-start gap-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center text-cyan-400">
                        <span class="material-symbols-outlined text-3xl">grid_view</span>
                    </div>
                    <h3 class="text-2xl font-bold">Organização em Blocos</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        Estruture seu show em blocos temáticos ou por dinâmica de palco. Perfeito para gerenciar
                        momentos de energia alta ou sets acústicos.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="feature-card p-8 rounded-3xl bg-dark-card border border-white/5 flex flex-col items-start gap-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-500">
                        <span class="material-symbols-outlined text-3xl">ios_share</span>
                    </div>
                    <h3 class="text-2xl font-bold">Links Públicos</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        Gere links públicos instantâneos para compartilhar o setlist com sua banda, contratantes ou
                        público sem que eles precisem de login.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="feature-card p-8 rounded-3xl bg-dark-card border border-white/5 flex flex-col items-start gap-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center text-amber-400">
                        <span class="material-symbols-outlined text-3xl">picture_as_pdf</span>
                    </div>
                    <h3 class="text-2xl font-bold">Exportação PDF</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        Transforme seu repertório em documentos PDF profissionais com um clique. Pronto para imprimir ou
                        usar em tablets offline durante a performance.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="feature-card p-8 rounded-3xl bg-dark-card border border-white/5 flex flex-col items-start gap-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-emerald-400/10 border border-emerald-400/20 flex items-center justify-center text-emerald-400">
                        <span class="material-symbols-outlined text-3xl">lightbulb</span>
                    </div>
                    <h3 class="text-2xl font-bold">Sugestões Inteligentes</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        Receba insights automáticos baseados nas suas músicas favoritas para criar a sequência perfeita
                        (Crossover, BPM, etc).
                    </p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="feature-card p-8 rounded-3xl bg-dark-card border border-white/5 flex flex-col items-start gap-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center text-pink-500">
                        <span class="material-symbols-outlined text-3xl">sync</span>
                    </div>
                    <h3 class="text-2xl font-bold">Multi-Dispositivo</h3>
                    <p class="text-gray-400 leading-relaxed text-sm">
                        Acesse seus dados de qualquer lugar, seja no PC, tablet ou smartphone. Seus ensaios e
                        apresentações sempre sincronizados.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @if($featuredRepertoires->count() > 0)
        <!-- Featured Repertoires Section -->
        <section id="featured" class="py-32 bg-dark-bg">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div class="max-w-xl">
                        <h2 class="text-3xl md:text-5xl font-bold mb-6 italic tracking-tight uppercase">Em Destaque Agora
                        </h2>
                        <p class="text-gray-400 text-lg">
                            Inspire-se com os repertórios mais organizados da nossa comunidade musical.
                        </p>
                    </div>
                    <div class="h-1 w-20 bg-primary hidden md:block mb-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredRepertoires as $repertoire)
                        <!-- Featured Card -->
                        <div
                            class="group bg-dark-card border border-white/5 rounded-[40px] overflow-hidden hover:border-primary/30 transition-all shadow-2xl relative">
                            <!-- Curadoria Badge -->
                            <div class="absolute top-0 right-0 p-8">
                                <span
                                    class="text-xs font-black text-amber-500/40 uppercase tracking-[0.2em] flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">stars</span>
                                </span>
                            </div>

                            <div class="p-10">
                                <!-- Icon Box -->
                                <div class="w-16 h-16 rounded-3xl flex items-center justify-center text-white text-3xl mb-8 shadow-lg shadow-black/20"
                                    style="background-color: {{ $repertoire->color }}">
                                    <span class="material-symbols-outlined text-4xl">{{ $repertoire->icon }}</span>
                                </div>

                                <!-- Content -->
                                <h3
                                    class="text-2xl font-black text-white mb-2 group-hover:text-primary transition-colors tracking-tight">
                                    {{ $repertoire->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-8 flex items-center gap-2 font-medium">
                                    <span class="material-symbols-outlined text-base">person</span>
                                    por {{ $repertoire->user->name }}
                                </p>

                                <!-- Action -->
                                <a href="{{ route('repertoires.public', $repertoire->slug) }}"
                                    class="inline-flex items-center gap-3 px-6 py-3 bg-white/5 text-primary font-bold rounded-2xl hover:bg-primary hover:text-white transition-all uppercase text-[10px] tracking-[0.2em] border border-primary/20">
                                    Ver Setlist
                                    <span
                                        class="material-symbols-outlined text-sm transition-transform group-hover:translate-x-1">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    <section class="py-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-primary/5"></div>
        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
            <h2 class="text-4xl md:text-6xl font-extrabold mb-8 italic">Pronto para elevar o nível da sua música?</h2>
            <p class="text-xl text-gray-400 mb-12">
                Junte-se a centenas de músicos que já transformaram a forma de gerenciar seus shows.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('register') }}"
                    class="w-full sm:w-auto px-10 py-5 rounded-2xl bg-primary text-white font-black text-xl shadow-2xl shadow-primary/40 hover:scale-105 transition-all flex items-center justify-center gap-3">
                    Começar Grátis Agora
                    <span class="material-symbols-outlined text-2xl">rocket_launch</span>
                </a>
            </div>
            <p class="mt-8 text-gray-500 text-sm italic">Sem cartão de crédito. Comece em menos de 1 minuto.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-white/10 bg-dark-bg">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-8 text-gray-500">
            <div class="flex items-center gap-3 opacity-60">
                <span class="material-symbols-outlined text-2xl">queue_music</span>
                <span class="font-bold text-lg">MusicApp</span>
            </div>

            <div class="flex items-center gap-8 text-sm">
                <a href="#" class="hover:text-primary transition-colors">Termos</a>
                <a href="#" class="hover:text-primary transition-colors">Privacidade</a>
                <a href="#" class="hover:text-primary transition-colors">Contato</a>
            </div>

            <p class="text-sm">© 2025 MusicApp. Viva a música.</p>
        </div>
    </footer>
</body>

</html>