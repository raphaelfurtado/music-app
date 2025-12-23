@extends('layouts.master')

@section('title', $repertoire->name)

@section('content')
<header class="sticky top-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-800 transition-all">
    <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-10 h-10 -ml-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors text-gray-600 dark:text-gray-300">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    
    <h1 class="text-base font-bold tracking-tight truncate max-w-[60%]">{{ $repertoire->name }}</h1>
    
    <a href="{{ route('repertoires.edit', $repertoire->id) }}" class="flex items-center justify-center w-10 h-10 -mr-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors text-primary">
        <span class="material-symbols-outlined">edit_square</span>
    </a>
</header>

<main class="flex-1 w-full max-w-md mx-auto px-4 pb-24 pt-4">
    
    <div class="bg-white dark:bg-surface-dark rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-transparent mb-6">
        <div class="flex flex-col items-center">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-primary mb-4">
                <span class="material-symbols-outlined text-3xl">{{ $repertoire->icon ?? 'library_music' }}</span>
            </div>
            
            <h2 class="text-xl font-bold text-center mb-1">{{ $repertoire->name }}</h2>
            
            <div class="flex items-center gap-2 mb-4">
                <span class="px-2.5 py-1 rounded-md text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                    {{ Str::limit($repertoire->description, 15) ?: 'Geral' }}
                </span>
                <span class="text-gray-400 text-xs">•</span>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $repertoire->created_at->format('d M, Y') }}</span>
            </div>
            
            <div class="flex gap-4 w-full mt-2">
                <div class="flex-1 bg-background-light dark:bg-background-dark rounded-xl p-3 text-center border border-gray-100 dark:border-gray-800/50">
                    <span class="block text-xl font-bold text-primary">{{ $repertoire->blocks->count() }}</span>
                    <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Blocos</span>
                </div>
                <div class="flex-1 bg-background-light dark:bg-background-dark rounded-xl p-3 text-center border border-gray-100 dark:border-gray-800/50">
                    <span class="block text-xl font-bold text-primary">{{ $repertoire->blocks->sum(fn($block) => $block->songs->count()) }}</span>
                    <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Músicas</span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-3 px-1">
        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Roteiro Musical</h3>
        <span class="text-xs text-primary font-medium cursor-pointer hover:underline">Expandir todos</span>
    </div>

    <div class="flex flex-col gap-3">
        @forelse($repertoire->blocks as $block)
            <a href="{{ route('blocks.edit', $block->id) }}" class="group relative flex items-center p-4 bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-gray-100 dark:border-transparent active:scale-[0.98] transition-all duration-200 cursor-pointer hover:shadow-md dark:hover:bg-gray-800/80">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-slate-600 dark:text-gray-300 font-bold text-sm">
                    {{ $block->order }}
                </div>
                <div class="flex-1 min-w-0 ml-4">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white truncate">{{ $block->name }}</h3>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="material-symbols-outlined text-[14px] text-gray-400">music_note</span>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $block->songs->count() }} Músicas</p>
                    </div>
                </div>
                <div class="text-gray-300 dark:text-gray-600 group-hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </a>
        @empty
            <div class="text-center py-8 text-gray-400">
                <p>Nenhum bloco criado ainda.</p>
                <p class="text-xs">Toque no botão + para começar.</p>
            </div>
        @endforelse

        <div class="mt-2 py-6 flex flex-col items-center justify-center text-center border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-2xl">
            <p class="text-sm text-gray-400 mb-2">Precisa de mais momentos?</p>
            <button class="text-primary font-semibold text-sm hover:underline">
                Ver sugestões para Casamento
            </button>
        </div>
    </div>
</main>

<a href="{{ route('blocks.create', $repertoire->id) }}" class="fixed bottom-28 right-6 w-14 h-14 rounded-full bg-primary shadow-lg shadow-blue-500/30 flex items-center justify-center text-white z-30 hover:bg-blue-600 active:scale-95 transition-all duration-200 group">
    <span class="material-symbols-outlined text-3xl group-hover:rotate-90 transition-transform duration-300">add</span>
    <span class="absolute right-16 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Novo Bloco</span>
</a>

@endsection