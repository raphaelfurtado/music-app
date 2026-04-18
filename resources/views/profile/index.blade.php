@extends('layouts.master')

@section('title', 'Perfil e Configurações')

@section('content')
    <div class="max-w-5xl mx-auto py-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="font-headline text-4xl text-on-surface">Perfil</h1>
                <p class="text-on-surface-variant text-sm mt-1">Gerencie conta, aparência e acesso.</p>
            </div>
            <a href="{{ route('profile.edit') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-md nm-gradient-gold text-on-primary-container text-xs font-bold uppercase tracking-[0.14em] hover:brightness-110 transition-all">
                <span class="material-symbols-outlined text-base">edit</span>
                Editar perfil
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <section class="lg:col-span-2 bg-surface-container-low rounded-xl p-6 nm-shadow">
                <div class="flex flex-col sm:flex-row sm:items-center gap-5">
                    <div class="relative">
                        @if(auth()->user()->avatar)
                            <img alt="Profile" class="w-24 h-24 rounded-lg object-cover border border-outline-variant/30"
                                src="{{ auth()->user()->avatar }}" />
                        @elseif(auth()->user()->profile_photo_url)
                            <img alt="Profile" class="w-24 h-24 rounded-lg object-cover border border-outline-variant/30"
                                src="{{ auth()->user()->profile_photo_url }}" />
                        @else
                            <div
                                class="w-24 h-24 rounded-lg bg-surface-container-high border border-outline-variant/30 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-4xl">person</span>
                            </div>
                        @endif
                    </div>

                    <div class="min-w-0">
                        <h2 class="text-2xl font-semibold text-on-surface truncate">{{ auth()->user()->name }}</h2>
                        <p class="text-on-surface-variant text-sm truncate">{{ auth()->user()->email }}</p>
                        <div class="mt-4 flex gap-6">
                            <div>
                                <p class="text-2xl font-headline text-primary">{{ auth()->user()->repertoires()->count() }}</p>
                                <p class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant">Repertórios</p>
                            </div>
                            <div>
                                <p class="text-2xl font-headline text-primary">{{ auth()->user()->songs()->count() }}</p>
                                <p class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant">Músicas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-surface-container-low rounded-xl p-6 nm-shadow">
                <h3 class="text-xs uppercase tracking-[0.2em] text-on-surface-variant font-bold mb-4">Plano</h3>
                <p class="text-on-surface text-lg font-semibold mb-2">Seja Premium</p>
                <p class="text-on-surface-variant text-sm mb-5">Transposição ilimitada e sugestões avançadas por IA.</p>
                <button
                    class="w-full py-3 rounded-md nm-gradient-gold text-on-primary-container text-xs uppercase tracking-[0.14em] font-bold hover:brightness-110 transition-all">
                    Assinar agora
                </button>
            </section>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <section x-data="{ 
                    darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
                }" x-init="$watch('darkMode', val => {
                    if (val) {
                        document.documentElement.classList.add('dark');
                        localStorage.theme = 'dark';
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.theme = 'light';
                    }
                })" class="bg-surface-container-low rounded-xl p-6 nm-shadow">
                <h3 class="text-xs uppercase tracking-[0.2em] text-on-surface-variant font-bold mb-4">Aparência</h3>
                <div class="flex items-center justify-between p-4 rounded-lg bg-surface-container-high">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary" x-text="darkMode ? 'dark_mode' : 'light_mode'">dark_mode</span>
                        <span class="text-on-surface">Modo Escuro</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" x-model="darkMode">
                        <div
                            class="w-11 h-6 bg-surface-container-lowest rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:border-on-surface/20 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                        </div>
                    </label>
                </div>
            </section>

            <section class="bg-surface-container-low rounded-xl p-6 nm-shadow">
                <h3 class="text-xs uppercase tracking-[0.2em] text-on-surface-variant font-bold mb-4">Conta</h3>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-between p-4 rounded-lg bg-surface-container-high hover:bg-surface-bright transition-colors text-left">
                        <span class="text-on-surface">Sair da Conta</span>
                        <span class="material-symbols-outlined text-on-surface-variant">logout</span>
                    </button>
                </form>
            </section>
        </div>

        <div class="text-center mt-8">
            <p class="text-xs text-on-surface-variant">Versão 1.0.0</p>
        </div>
    </div>
@endsection