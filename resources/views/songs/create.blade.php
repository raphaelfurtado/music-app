@extends('layouts.master')

@section('title', 'Detalhes da Música')

@section('content')
    <div class="flex flex-col h-screen bg-background-light dark:bg-background-dark">
        <header
            class="sticky top-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-800">
            <a href="{{ request('return_url') ?? url()->previous() }}"
                class="flex items-center justify-center w-10 h-10 -ml-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors text-slate-900 dark:text-white">
                <span class="material-symbols-outlined text-2xl">arrow_back</span>
            </a>
            <h1 class="text-lg font-bold tracking-tight">Detalhes da Música</h1>
            <div class="w-8"></div>
        </header>

        <main class="flex-1 w-full max-w-md mx-auto px-4 py-6">
            <form action="{{ route('songs.store') }}" method="POST" class="flex flex-col gap-6">
                @csrf

                <input type="hidden" name="return_url" value="{{ request('return_url') }}">

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1" for="songName">
                        Nome da Música
                    </label>
                    <div class="relative group">
                        <input name="title" value="{{ old('title', $title) }}" required autofocus
                            class="block w-full px-4 py-3.5 rounded-2xl border-none bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:outline-none shadow-sm text-base transition-shadow"
                            id="songName" placeholder="Ex: Oceano" type="text" />
                        <div
                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined">music_note</span>
                        </div>
                    </div>
                    @error('title') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-4">
                    <div class="space-y-2 flex-1">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1" for="songKey">
                            Tom
                        </label>
                        <div class="relative group">
                            <input name="key" id="songKeyInput" readonly
                                class="block w-full px-4 py-3.5 rounded-2xl border-none bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:outline-none shadow-sm text-base transition-shadow cursor-default"
                                placeholder="Selecione abaixo" type="text" />
                        </div>
                    </div>

                    <div class="space-y-2 w-1/3">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1" for="songBpm">
                            BPM
                        </label>
                        <div class="relative group">
                            <input name="bpm" type="number"
                                class="block w-full px-4 py-3.5 rounded-2xl border-none bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:outline-none shadow-sm text-base transition-shadow"
                                placeholder="120" />
                            <div
                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400 text-xs font-bold">
                                BPM
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3 -mt-2">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-400 ml-1">Maiores</span>
                        <div class="flex gap-2 overflow-x-auto no-scrollbar pt-1 pb-2">
                            @foreach(['C','Db','D','Eb','E','F','F#','G','Ab','A','Bb','B'] as $k)
                            <button type="button" onclick="document.getElementById('songKeyInput').value = '{{ $k }}'"
                                class="shrink-0 h-10 w-10 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark text-sm font-bold text-slate-700 dark:text-gray-200 hover:border-primary hover:bg-primary hover:text-white dark:hover:bg-primary transition-all shadow-sm">
                                {{ $k }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-400 ml-1">Menores</span>
                        <div class="flex gap-2 overflow-x-auto no-scrollbar pt-1 pb-2">
                            @foreach(['Cm','C#m','Dm','Ebm','Em','Fm','F#m','Gm','G#m','Am','Bbm','Bm'] as $k)
                            <button type="button" onclick="document.getElementById('songKeyInput').value = '{{ $k }}'"
                                class="shrink-0 h-10 w-auto px-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-surface-dark/50 text-xs font-semibold text-slate-600 dark:text-gray-400 hover:border-primary hover:bg-primary hover:text-white dark:hover:bg-primary transition-all">
                                {{ $k }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1" for="lyrics">
                        Trecho da Letra / Observações
                    </label>
                    <div class="relative group">
                        <textarea name="lyrics"
                            class="block w-full px-4 py-3.5 rounded-2xl border-none bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:outline-none shadow-sm text-base resize-none transition-shadow"
                            id="lyrics" placeholder="Adicione a primeira estrofe ou observações..." rows="6"></textarea>
                        <div
                            class="absolute top-3 right-4 pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined">notes</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 pt-6 sm:flex-row pb-10">
                    <a href="{{ request('return_url') ?? url()->previous() }}"
                        class="flex-1 py-4 rounded-xl font-bold text-gray-600 dark:text-gray-300 bg-transparent border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 active:scale-[0.98] transition-all text-center flex items-center justify-center">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-1 py-4 rounded-xl font-bold text-white bg-primary shadow-lg shadow-blue-500/30 hover:bg-blue-600 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Salvar
                    </button>
                </div>
            </form>
        </main>
    </div>
@endsection