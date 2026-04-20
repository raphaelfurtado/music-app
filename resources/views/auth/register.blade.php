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
                <button type="button" onclick="openGoogleAuthPopup()"
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-outline-variant/30 rounded-xl shadow-sm bg-surface-container-low text-sm font-semibold text-on-surface hover:bg-surface-container-high transition-all active:scale-[0.98]">

                    <svg class="h-5 w-5" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                        <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                            <path fill="#4285F4"
                                d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z" />
                            <path fill="#34A853"
                                d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z" />
                            <path fill="#FBBC05"
                                d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z" />
                            <path fill="#EA4335"
                                d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z" />
                        </g>
                    </svg>
                    <span>Entrar com Google</span>
                </button>
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

    <script>
        function togglePasswordVisibility(id) {
            var input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

        function openGoogleAuthPopup() {
            var url = "{{ route('auth.google', ['popup' => 1]) }}";
            var width = 520;
            var height = 680;
            var left = Math.max(0, (window.screen.width - width) / 2);
            var top = Math.max(0, (window.screen.height - height) / 2);
            var features = "width=" + width + ",height=" + height + ",left=" + left + ",top=" + top + ",resizable=yes,scrollbars=yes";

            var popup = window.open(url, "googleLoginPopup", features);

            if (!popup) {
                window.location.href = url;
            }
        }

        window.addEventListener("message", function (event) {
            if (event.origin !== window.location.origin) {
                return;
            }

            var data = event.data || {};
            if (data.type !== "google-auth-callback") {
                return;
            }

            if (data.success) {
                window.location.href = data.redirectUrl;
                return;
            }

            window.location.href = "{{ route('login') }}";
        });
    </script>
@endsection