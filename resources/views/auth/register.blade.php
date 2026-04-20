@extends('layouts.master')

@section('title', 'Cadastro')

@section('content')
    <div class="min-h-[80vh] grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center px-2 sm:px-6">

        <aside class="hidden lg:flex flex-col justify-between rounded-2xl nm-card p-10 min-h-[560px]">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-primary font-bold mb-4">Primeiro Acesso</p>
                <h2 class="font-headline text-5xl leading-tight text-on-surface mb-4">Monte seu repertório como diretor musical.</h2>
                <p class="text-on-surface-variant text-base leading-relaxed">No desktop você terá visão ampla para editar setlists, arrastar blocos e controlar o fluxo completo do show.</p>
            </div>
            <div class="rounded-xl bg-surface-container p-5 border border-outline-variant/20">
                <p class="text-sm text-on-surface-variant">Cadastro rápido no mobile, controle total no desktop.</p>
            </div>
        </aside>

        <div class="w-full max-w-md mx-auto">

        <div class="mb-8 text-center sm:text-left">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-primary/10 text-primary mb-6">
                <span class="material-symbols-outlined text-3xl">music_note</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-on-surface mb-2">Criar conta</h1>
            <p class="text-on-surface-variant text-base">
                Cadastre-se para organizar seus repertórios e blocos de músicas.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-on-surface ml-1" for="name">
                    Nome completo
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-on-surface-variant">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        autocomplete="name"
                        class="block w-full rounded-xl border-0 py-3.5 pl-11 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-surface-container-low transition-shadow"
                        placeholder="Seu nome" />
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-on-surface ml-1" for="email">
                    E-mail
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-on-surface-variant">
                        <span class="material-symbols-outlined text-xl">mail</span>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="username"
                        class="block w-full rounded-xl border-0 py-3.5 pl-11 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-surface-container-low transition-shadow"
                        placeholder="exemplo@email.com" />
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-on-surface ml-1" for="password">
                    Senha
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-on-surface-variant">
                        <span class="material-symbols-outlined text-xl">lock</span>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full rounded-xl border-0 py-3.5 pl-11 pr-10 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-surface-container-low transition-shadow"
                        placeholder="Minimo 8 caracteres" />
                    <button type="button" onclick="togglePasswordVisibility('password')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-primary">
                        <span class="material-symbols-outlined text-xl">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-on-surface ml-1" for="password_confirmation">
                    Confirmar Senha
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-on-surface-variant">
                        <span class="material-symbols-outlined text-xl">lock_reset</span>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password"
                        class="block w-full rounded-xl border-0 py-3.5 pl-11 pr-10 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-surface-container-low transition-shadow"
                        placeholder="Confirme a senha" />
                </div>
            </div>

            <div class="flex items-start pt-2">
                <div class="flex h-6 items-center">
                    <input id="terms" name="terms" type="checkbox" required
                        class="h-5 w-5 rounded border-outline-variant/40 text-primary focus:ring-primary bg-surface-container-low" />
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label class="font-medium text-on-surface-variant" for="terms">
                        Li e concordo com os <a class="font-semibold text-primary hover:text-primary/80 underline" href="#">Termos de Serviço</a> e Política de Privacidade.
                    </label>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="flex w-full justify-center items-center gap-2 rounded-2xl nm-gradient-gold px-3 py-4 text-base font-black leading-6 text-on-primary-container shadow-lg shadow-samba-gold/20 hover:brightness-110 transition-all active:scale-[0.98] uppercase tracking-widest italic leading-none">
                    Começar o Show
                    <span class="material-symbols-outlined text-xl font-black">arrow_forward</span>
                </button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-outline-variant/30"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-surface text-on-surface-variant font-medium">
                        Ou continue com
                    </span>
                </div>
            </div>

            <div class="mt-6">
                <div id="google-signin-button" class="w-full flex justify-center"></div>
                <p id="google-signin-error" class="text-red-500 text-xs mt-2 text-center hidden"></p>
            </div>
        </div>

        <p class="mt-8 text-center text-sm text-on-surface-variant">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="font-bold leading-6 text-primary hover:text-primary/80 ml-1">
                Fazer login
            </a>
        </p>

        </div>
    </div>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function togglePasswordVisibility(id) {
            var input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

        function showGoogleSignInError(message) {
            var errorEl = document.getElementById("google-signin-error");
            if (!errorEl) {
                return;
            }

            errorEl.textContent = message;
            errorEl.classList.remove("hidden");
        }

        async function handleGoogleCredentialResponse(response) {
            if (!response || !response.credential) {
                showGoogleSignInError("Nao foi possivel autenticar com Google.");
                return;
            }

            try {
                var result = await fetch("{{ route('auth.google.token') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    credentials: "same-origin",
                    body: JSON.stringify({
                        credential: response.credential
                    })
                });

                var data = await result.json();
                if (!result.ok) {
                    throw new Error(data.message || "Falha no login Google.");
                }

                window.location.href = data.redirect || "{{ route('dashboard') }}";
            } catch (error) {
                showGoogleSignInError(error.message || "Erro ao entrar com Google.");
            }
        }

        function initGoogleIdentity() {
            if (!window.google || !window.google.accounts || !window.google.accounts.id) {
                showGoogleSignInError("Google Identity nao carregou. Tente atualizar a pagina.");
                return;
            }

            var clientId = "{{ config('services.google.client_id') }}";
            if (!clientId) {
                showGoogleSignInError("Google Client ID nao configurado.");
                return;
            }

            google.accounts.id.initialize({
                client_id: clientId,
                callback: handleGoogleCredentialResponse,
                ux_mode: "popup",
                auto_select: false,
                context: "signup"
            });

            google.accounts.id.renderButton(
                document.getElementById("google-signin-button"),
                {
                    type: "standard",
                    theme: "outline",
                    size: "large",
                    text: "continue_with",
                    shape: "pill",
                    logo_alignment: "left"
                }
            );

            google.accounts.id.prompt();
        }

        window.addEventListener("load", function () {
            var tries = 0;
            var maxTries = 20;
            var timer = setInterval(function () {
                tries += 1;
                if (window.google && window.google.accounts && window.google.accounts.id) {
                    clearInterval(timer);
                    initGoogleIdentity();
                    return;
                }

                if (tries >= maxTries) {
                    clearInterval(timer);
                    showGoogleSignInError("Google Identity indisponivel no momento.");
                }
            }, 150);
        });
    </script>
@endsection