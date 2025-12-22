<!DOCTYPE html>
<html class="dark" lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Cadastro</title>
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

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white overflow-x-hidden min-h-screen flex flex-col">
    
    <header class="sticky top-0 z-20 px-4 py-3 flex items-center">
        <a href="{{ url('/') }}" class="flex items-center justify-center w-10 h-10 rounded-full text-slate-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
    </header>

    <main class="flex-1 w-full max-w-md mx-auto px-6 pb-8 flex flex-col justify-center">
        
        <div class="mb-8 text-center sm:text-left">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-primary/10 text-primary mb-6">
                <span class="material-symbols-outlined text-3xl">music_note</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white mb-2">Criar conta</h1>
            <p class="text-gray-500 dark:text-gray-400 text-base">
                Cadastre-se para organizar seus repertórios e blocos de músicas.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-slate-900 dark:text-gray-200 ml-1" for="name">
                    Nome completo
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="block w-full rounded-xl border-0 py-3.5 pl-11 text-slate-900 shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-white dark:bg-surface-dark dark:text-white transition-shadow" 
                           placeholder="Seu nome" />
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-slate-900 dark:text-gray-200 ml-1" for="email">
                    E-mail
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <span class="material-symbols-outlined text-xl">mail</span>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="block w-full rounded-xl border-0 py-3.5 pl-11 text-slate-900 shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-white dark:bg-surface-dark dark:text-white transition-shadow" 
                           placeholder="exemplo@email.com" />
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-slate-900 dark:text-gray-200 ml-1" for="password">
                    Senha
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <span class="material-symbols-outlined text-xl">lock</span>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="block w-full rounded-xl border-0 py-3.5 pl-11 pr-10 text-slate-900 shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-white dark:bg-surface-dark dark:text-white transition-shadow" 
                           placeholder="Mínimo 8 caracteres" />
                    <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <span class="material-symbols-outlined text-xl">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-slate-900 dark:text-gray-200 ml-1" for="password_confirmation">
                    Confirmar Senha
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <span class="material-symbols-outlined text-xl">lock_reset</span>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="block w-full rounded-xl border-0 py-3.5 pl-11 pr-10 text-slate-900 shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-white dark:bg-surface-dark dark:text-white transition-shadow" 
                           placeholder="Confirme a senha" />
                </div>
            </div>

            <div class="flex items-start pt-2">
                <div class="flex h-6 items-center">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary bg-white dark:bg-surface-dark dark:border-gray-600 dark:checked:bg-primary" />
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label class="font-medium text-gray-600 dark:text-gray-300" for="terms">
                        Li e concordo com os <a class="font-semibold text-primary hover:text-blue-500 underline decoration-transparent hover:decoration-primary transition-all" href="#">Termos de Serviço</a> e Política de Privacidade.
                    </label>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="flex w-full justify-center items-center gap-2 rounded-2xl bg-primary px-3 py-4 text-base font-bold leading-6 text-white shadow-lg shadow-blue-500/25 hover:bg-blue-600 hover:shadow-blue-500/40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all active:scale-[0.98]">
                    Cadastrar
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </button>
            </div>
        </form>

        <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="font-bold leading-6 text-primary hover:text-blue-500 ml-1">
                Fazer login
            </a>
        </p>
    </main>

    <script>
        function togglePasswordVisibility(id) {
            var input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>