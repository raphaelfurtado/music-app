@extends('layouts.master')

@section('title', 'Entrar')

@section('content')
    <div class="min-h-[80vh] grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center px-2 sm:px-6">

        <aside class="hidden lg:flex flex-col justify-between rounded-2xl nm-card p-10 min-h-[560px]">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-primary font-bold mb-4">Music App</p>
                <h2 class="font-headline text-5xl leading-tight text-on-surface mb-4">Seu palco começa no planejamento.</h2>
                <p class="text-on-surface-variant text-base leading-relaxed">No desktop, acompanhe repertórios, blocos e estatísticas com mais contexto visual em uma experiência de painel.</p>
            </div>
            <div class="rounded-xl bg-surface-container p-5 border border-outline-variant/20">
                <p class="text-sm text-on-surface-variant">"Organização boa é ensaio que rende."</p>
            </div>
        </aside>

        <div class="w-full max-w-md mx-auto">

        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-samba-gold shadow-xl shadow-samba-gold/20 mb-6 text-dark-bg transition-transform hover:scale-110">
                <span class="material-symbols-outlined text-4xl font-black">music_note</span>
            </div>
            <h1 class="text-4xl font-black tracking-tighter text-on-surface mb-2 uppercase italic">Bem-<span
                    class="text-samba-gold">vindo</span></h1>
            <p class="text-on-surface-variant text-lg">
                Entre para dominar o seu repertório.
            </p>
        </div>

        @if (session('status'))
            <div
                class="mb-6 p-4 bg-primary/10 border border-primary/20 text-primary rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
                <span class="material-symbols-outlined text-xl">info</span>
                <span class="text-sm font-medium">{{ session('status') }}</span>
            </div>
        @endif

        @if (session('info'))
            <div
                class="mb-6 p-4 bg-amber-500/10 border border-amber-500/20 text-amber-500 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
                <span class="material-symbols-outlined text-xl">lock</span>
                <span class="text-sm font-medium">{{ session('info') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-on-surface ml-1" for="email">
                    E-mail ou Usuário
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-on-surface-variant">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full rounded-xl border-0 py-3.5 pl-11 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-surface-container-low transition-shadow"
                        placeholder="seu@email.com" />
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
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full rounded-xl border-0 py-3.5 pl-11 pr-10 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-surface-container-low transition-shadow"
                        placeholder="••••••••" />

                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-primary">
                        <span class="material-symbols-outlined text-xl">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror

                <div class="flex justify-end pt-1">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-primary hover:text-primary/80">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>
            </div>

            <button type="submit"
                class="w-full py-5 rounded-2xl bg-samba-gold text-dark-bg font-black text-lg shadow-xl shadow-samba-gold/20 hover:bg-yellow-500 active:scale-[0.98] transition-all flex items-center justify-center uppercase tracking-widest italic leading-none">
                Entrar no Palco
            </button>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-outline-variant/30"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-surface text-on-surface-variant">
                        Ou continue com
                    </span>
                </div>
            </div>

            <div class="mt-6">
                <div id="google-signin-button" class="w-full flex justify-center"></div>
                <p id="google-signin-error" class="text-red-500 text-xs mt-2 text-center hidden"></p>
            </div>
        </div>

        </div>

    </div>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function togglePassword() {
            var input = document.getElementById("password");
            input.type = (input.type === "password") ? "text" : "password";
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
                context: "signin"
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