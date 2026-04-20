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
                <button type="button" onclick="openGoogleAuthPopup()"
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-outline-variant/30 rounded-xl shadow-sm bg-surface-container-low text-sm font-medium text-on-surface hover:bg-surface-container-high transition-colors">

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

        </div>

    </div>

    <script>
        function togglePassword() {
            var input = document.getElementById("password");
            input.type = (input.type === "password") ? "text" : "password";
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