@extends('layouts.master')

@section('title', 'Entrar')

@section('content')
    <div class="flex flex-col justify-center min-h-[80vh] px-6">
        
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary shadow-lg shadow-blue-500/30 mb-6 text-white">
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
                    
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
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

            <button type="submit" class="w-full py-4 rounded-2xl bg-primary text-white font-bold text-lg shadow-lg shadow-blue-500/30 hover:bg-blue-600 active:scale-[0.98] transition-all flex items-center justify-center">
                Entrar
            </button>
        </form>

        <div class="relative mt-8 mb-6">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-200 dark:border-gray-800"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="bg-background-light dark:bg-background-dark px-2 text-xs text-gray-400">ou</span>
            </div>
        </div>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            Ainda não tem uma conta? 
            <a href="{{ route('register') }}" class="font-bold text-primary hover:text-blue-500">
                Criar Conta
            </a>
        </p>

    </div>

    <script>
        function togglePassword() {
            var input = document.getElementById("password");
            input.type = (input.type === "password") ? "text" : "password";
        }
    </script>
@endsection