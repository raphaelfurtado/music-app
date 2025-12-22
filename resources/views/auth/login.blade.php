@extends('layouts.master')
@section('content')
    <main class="w-full max-w-sm px-6">
        <div class="flex flex-col items-center mb-10">
            <div
                class="w-20 h-20 bg-gradient-to-tr from-primary to-blue-400 rounded-3xl shadow-lg shadow-blue-500/20 flex items-center justify-center mb-6 transform rotate-3">
                <span class="material-symbols-outlined text-4xl text-white">library_music</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-center text-slate-900 dark:text-white mb-2">Bem-vindo</h1>
            <p class="text-center text-gray-500 dark:text-gray-400 text-sm">Entre para gerenciar seus repertórios e shows
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-2 ml-1" for="email">E-mail ou
                    Usuário</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <input
                        class="block w-full pl-10 pr-4 py-3.5 bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 rounded-2xl text-slate-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                        id="email" name="email" required placeholder="Digite seu e-mail" type="text" />
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2 ml-1">
                    <label class="block text-sm font-medium text-slate-700 dark:text-gray-300" for="password">Senha</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <span class="material-symbols-outlined text-xl">lock</span>
                    </div>
                    <input
                        class="block w-full pl-10 pr-12 py-3.5 bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 rounded-2xl text-slate-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                        id="password" placeholder="••••••••" name="password" required type="password" />
                    <button
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                        type="button">
                        <span class="material-symbols-outlined text-xl">visibility</span>
                    </button>
                </div>
                <div class="flex justify-end mt-2">
                    <a class="text-xs font-semibold text-primary hover:text-blue-600 transition-colors" href="#">Esqueceu a
                        senha?</a>
                </div>
            </div>
            <button
                class="w-full flex items-center justify-center py-3.5 px-4 rounded-2xl text-white bg-primary hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary font-bold shadow-lg shadow-blue-500/25 active:scale-[0.98] transition-all duration-200 mt-2"
                type="submit">
                Entrar
            </button>
        </form>
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-800"></div>
            </div>
            <div class="relative flex justify-center text-xs">
                <span class="px-2 bg-background-light dark:bg-background-dark text-gray-500">ou</span>
            </div>
        </div>
        <p class="text-center text-sm text-gray-600 dark:text-gray-400">
            Ainda não tem uma conta?
            <a class="font-bold text-primary hover:text-blue-600 transition-colors ml-1" href="#">Criar Conta</a>
        </p>
    </main>
    <div class="fixed -top-40 -right-40 w-80 h-80 bg-primary/20 rounded-full blur-3xl pointer-events-none z-[-1]"></div>
    <div class="fixed -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl pointer-events-none z-[-1]">
    </div>

@endsection