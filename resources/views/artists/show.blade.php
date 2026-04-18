@extends('layouts.master')

@section('title', $artist->name . ' - Cifras de Samba e Pagode')

@section('content')
    <div class="mb-12">
        <!-- Artist Header -->
        <div class="relative rounded-[3rem] overflow-hidden bg-dark-card mb-12 shadow-2xl ring-1 ring-white/5">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent z-10"></div>

            @if($artist->image_url)
                <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}"
                    class="absolute inset-0 w-full h-full object-cover opacity-60">
            @endif

            <div class="relative z-20 p-8 md:p-16 flex flex-col items-start min-h-[400px] justify-end">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-samba-gold/20 border border-samba-gold/30 mb-6 backdrop-blur-md">
                    <span class="flex h-2 w-2 rounded-full bg-samba-gold animate-pulse"></span>
                    <span class="text-xs font-black text-samba-gold uppercase tracking-widest italic">Artista em
                        Destaque</span>
                </div>
                <h1 class="text-5xl md:text-8xl font-black text-white uppercase italic tracking-tighter leading-none mb-4">
                    {{ $artist->name }}</h1>
                <p class="text-gray-300 dark:text-gray-400 max-w-2xl text-lg leading-relaxed">
                    {{ $artist->bio ?? 'Explore a discografia e cifras deste ícone do Samba e Pagode.' }}</p>
            </div>
        </div>

        <!-- Song List -->
        <div class="flex flex-col md:flex-row gap-12">
            <div class="flex-1">
                <h2
                    class="text-2xl font-black text-slate-900 dark:text-white uppercase italic tracking-tighter mb-8 border-b border-gray-100 dark:border-white/5 pb-4">
                    Principais <span class="text-samba-gold">Cifras</span>
                </h2>

                <div class="grid grid-cols-1 gap-4">
                    @forelse($artist->songs as $song)
                        <a href="{{ route('songs.show', $song->id) }}"
                            class="group flex items-center justify-between p-6 bg-white dark:bg-dark-card rounded-3xl shadow-sm ring-1 ring-gray-100 dark:ring-white/5 hover:ring-samba-gold/30 hover:shadow-xl transition-all">
                            <div class="flex items-center gap-6">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-400 group-hover:bg-samba-gold group-hover:text-dark-bg transition-all">
                                    <span class="material-symbols-outlined text-2xl font-bold">music_note</span>
                                </div>
                                <div>
                                    <h3
                                        class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-samba-gold transition-colors">
                                        {{ $song->title }}</h3>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Tom:
                                            {{ $song->key ?? '-' }}</span>
                                        <div class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-700"></div>
                                        <span
                                            class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $song->bpm ? $song->bpm . ' BPM' : 'Samba' }}</span>
                                    </div>
                                </div>
                            </div>
                            <span
                                class="material-symbols-outlined text-gray-300 group-hover:text-samba-gold transition-colors font-bold">arrow_forward</span>
                        </a>
                    @empty
                        <div
                            class="py-12 text-center bg-gray-50 dark:bg-white/5 rounded-3xl border-2 border-dashed border-gray-200 dark:border-white/10">
                            <p class="text-gray-500">Nenhuma música encontrada para este artista.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar / Stats -->
            <div class="w-full md:w-80 space-y-8">
                <div
                    class="p-8 bg-white dark:bg-dark-card rounded-[2.5rem] shadow-sm ring-1 ring-gray-100 dark:ring-white/5">
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Sobre o Artista</h4>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-samba-gold/10 flex items-center justify-center text-samba-gold">
                                <span class="material-symbols-outlined">library_music</span>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900 dark:text-white">{{ $artist->songs->count() }}
                                </p>
                                <p class="text-xs text-gray-500 font-bold uppercase">Músicas</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-samba-green/10 flex items-center justify-center text-samba-green">
                                <span class="material-symbols-outlined">trending_up</span>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900 dark:text-white">Em Alta</p>
                                <p class="text-xs text-gray-500 font-bold uppercase">Popularidade</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection