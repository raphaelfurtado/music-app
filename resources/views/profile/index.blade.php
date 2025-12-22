@extends('layouts.master')

@section('title', 'Perfil e Configurações')

@section('content')
    <div class="flex flex-col h-screen bg-background-light dark:bg-background-dark overflow-y-auto pb-24">
        
        <header class="sticky top-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-800">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Perfil</h1>
            <button class="text-primary font-semibold text-sm hover:text-blue-600 transition-colors">
                Editar
            </button>
        </header>

        <main class="flex-1 w-full max-w-md mx-auto px-4 pt-2">
            
            <div class="flex flex-col items-center pt-6 pb-6">
                <div class="relative group cursor-pointer">
                    @if(auth()->user()->profile_photo_url)
                         <img alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-white dark:border-surface-dark shadow-md" 
                              src="{{ auth()->user()->profile_photo_url }}" />
                    @else
                        <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center text-primary border-4 border-white dark:border-surface-dark shadow-md">
                            <span class="material-symbols-outlined text-4xl">person</span>
                        </div>
                    @endif
                    
                    <div class="relative group cursor-pointer">
    <a href="{{ route('profile.edit') }}" class="absolute bottom-0 right-0 bg-primary text-white p-1.5 rounded-full border-2 border-white dark:border-surface-dark hover:bg-blue-600 transition-colors shadow-sm">
        <span class="material-symbols-outlined text-sm font-bold block">edit</span>
    </a>
</div>
                </div>

                <h2 class="mt-4 text-xl font-bold text-slate-900 dark:text-white">{{ auth()->user()->name }}</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ auth()->user()->email }}</p>

                <div class="flex gap-6 mt-4">
                    <div class="text-center">
                        <span class="block font-bold text-lg text-slate-900 dark:text-white">{{ auth()->user()->repertoires()->count() }}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Repertórios</span>
                    </div>
                    <div class="w-px bg-gray-200 dark:bg-gray-700 h-8 self-center"></div>
                    <div class="text-center">
                        <span class="block font-bold text-lg text-slate-900 dark:text-white">{{ auth()->user()->songs()->count() }}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Músicas</span>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-5 text-white mb-6 shadow-lg shadow-blue-500/20 active:scale-[0.99] transition-transform cursor-pointer">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="relative flex items-center justify-between z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined filled text-yellow-300">workspace_premium</span>
                            <h3 class="font-bold text-lg">Seja Premium</h3>
                        </div>
                        <p class="text-blue-100 text-xs font-medium max-w-[180px]">Transposição automática ilimitada e sugestões por IA.</p>
                    </div>
                    <button class="bg-white text-blue-600 px-4 py-2 rounded-lg font-bold text-xs shadow-sm hover:bg-gray-50 transition-colors">
                        Assinar Agora
                    </button>
                </div>
            </div>

            <div class="mb-2 px-1">
                <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 ml-2">Geral</h4>
            </div>
            
            <div class="flex flex-col bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-gray-100 dark:border-transparent overflow-hidden mb-6">
                <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300">
                            <span class="material-symbols-outlined text-xl">dark_mode</span>
                        </div>
                        <span class="font-medium text-sm text-slate-900 dark:text-white">Modo Escuro</span>
                    </div>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                        <input type="checkbox" id="toggleDarkMode" class="peer sr-only">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                    </div>
                </div>
            </div>

            <div class="mb-2 px-1">
                <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 ml-2">Conta</h4>
            </div>

            <div class="flex flex-col bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-gray-100 dark:border-transparent overflow-hidden mb-6">
                
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between p-4 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors group cursor-pointer text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-500 group-hover:bg-orange-100 dark:group-hover:bg-orange-900/40 transition-colors">
                                <span class="material-symbols-outlined text-xl">logout</span>
                            </div>
                            <span class="font-medium text-sm text-orange-600 dark:text-orange-500">Sair da Conta</span>
                        </div>
                        <span class="material-symbols-outlined text-orange-300 dark:text-orange-800 group-hover:text-orange-500 transition-colors">chevron_right</span>
                    </button>
                </form>

            </div>

            <div class="text-center pb-8">
                <p class="text-xs text-gray-400 dark:text-gray-600">Versão 1.0.0</p>
            </div>

        </main>
        
        @include('layouts.navigation-bar') 
    </div>
@endsection