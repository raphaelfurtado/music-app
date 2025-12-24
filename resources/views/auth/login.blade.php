@extends('layouts.master')

@section('title', 'Entrar')

@section('content')
    <div class="flex flex-col justify-center min-h-[80vh] px-6">

        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary shadow-lg shadow-blue-500/30 mb-6 text-white">
                <span class="material-symbols-outlined text-4xl">queue_music</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white mb-2">Bem-vindo</h1>
            <p class="text-gray-500 dark:text-gray-400 text-base">
                Entre para gerenciar seus repertórios e shows
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-slate-900 dark:text-gray-200 ml-1" for="email">
                    E-mail ou Usuário
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full rounded-xl border-0 py-3.5 pl-11 text-slate-900 shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-white dark:bg-surface-dark dark:text-white transition-shadow"
                        placeholder="seu@email.com" />
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
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full rounded-xl border-0 py-3.5 pl-11 pr-10 text-slate-900 shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary text-base bg-white dark:bg-surface-dark dark:text-white transition-shadow"
                        placeholder="••••••••" />

                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <span class="material-symbols-outlined text-xl">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror

                <div class="flex justify-end pt-1">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-primary hover:text-blue-500">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>
            </div>

            <button type="submit"
                class="w-full py-4 rounded-2xl bg-primary text-white font-bold text-lg shadow-lg shadow-blue-500/30 hover:bg-blue-600 active:scale-[0.98] transition-all flex items-center justify-center">
                Entrar
            </button>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-background-dark text-gray-500 dark:text-gray-400">
                        Ou continue com
                    </span>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('auth.google') }}"
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-xl shadow-sm bg-white dark:bg-surface-dark text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">

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
                </a>
            </div>
        </div>

    </div>

    <script>
        function togglePassword() {
            var input = document.getElementById("password");
            input.type = (input.type === "password") ? "text" : "password";
        }
    </script>
@endsection