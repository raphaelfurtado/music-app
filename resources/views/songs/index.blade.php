@extends('layouts.master')
@section('title', 'Minhas Músicas')
@section('content')
    <div class="mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 md:gap-6 mb-6 md:mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-on-surface uppercase italic tracking-tighter">Minhas
                    <span class="text-samba-gold">Músicas</span></h1>
                <p class="text-on-surface-variant mt-2 text-sm md:text-base">Gerencie seu repertório completo de Samba e Pagode.</p>
            </div>
            <a href="{{ route('songs.create') }}"
                class="inline-flex items-center gap-2 px-5 md:px-6 py-3 bg-samba-gold text-dark-bg font-black rounded-xl hover:bg-yellow-500 transition-all shadow-lg shadow-samba-gold/20 uppercase tracking-widest text-xs md:text-sm nm-focus-ring">
                <span class="material-symbols-outlined font-bold">add</span>
                Nova Música
            </a>
        </div>

        <!-- Search / Filter (Visual Placeholder) -->
        <div class="mb-8">
            <div class="relative group">
                <span
                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-samba-gold transition-colors">search</span>
                <input type="text" placeholder="Buscar música ou artista..."
                    class="w-full bg-surface-container-low border-none ring-1 ring-outline-variant/20 focus:ring-2 focus:ring-samba-gold rounded-xl md:rounded-2xl py-3.5 md:py-4 pl-12 pr-4 text-on-surface transition-all shadow-sm">
            </div>
        </div>

        <div class="md:hidden space-y-3">
            @forelse($songs as $song)
                <div class="p-4 bg-surface-container-low rounded-xl ring-1 ring-outline-variant/20">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h3 class="text-base font-bold text-on-surface truncate">{{ $song->title }}</h3>
                            <p class="text-xs text-on-surface-variant truncate mt-1">{{ $song->artist ?? 'Artista Independente' }}</p>
                        </div>
                        <span class="px-2 py-0.5 rounded-md bg-samba-gold/10 text-samba-gold text-[10px] font-black uppercase">{{ $song->key ?? '-' }}</span>
                    </div>
                    @if($song->bpm)
                        <p class="text-[11px] text-on-surface-variant mt-3">{{ $song->bpm }} BPM</p>
                    @endif
                </div>
            @empty
                <div class="py-14 text-center bg-surface-container-low rounded-2xl">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant">library_music</span>
                    <p class="text-on-surface-variant mt-2 text-sm">Nenhuma música encontrada.</p>
                </div>
            @endforelse
        </div>

        <div class="hidden md:grid md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($songs as $song)
                <div
                    class="group p-6 bg-surface-container-low rounded-3xl shadow-sm ring-1 ring-outline-variant/20 hover:ring-samba-gold/30 hover:shadow-xl transition-all relative overflow-hidden">
                    <!-- Hover Decoration -->
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-samba-gold/5 blur-3xl -mr-12 -mt-12 group-hover:bg-samba-gold/10 transition-colors">
                    </div>

                    <div class="relative">
                        <h3
                            class="text-xl font-black text-on-surface mb-1 group-hover:text-samba-gold transition-colors">
                            {{ $song->title }}</h3>
                        <div class="flex flex-wrap items-center gap-3 mt-3">
                            <span class="flex items-center gap-1 text-sm font-bold text-on-surface-variant">
                                <span class="material-symbols-outlined text-base">person</span>
                                {{ $song->artist ?? 'Artista Independente' }}
                            </span>
                            <div class="w-1 h-1 rounded-full bg-outline-variant/60"></div>
                            <span class="px-2 py-0.5 rounded-lg bg-samba-gold/10 text-samba-gold text-xs font-black uppercase">
                                Tom: {{ $song->key ?? '-' }}
                            </span>
                            @if($song->bpm)
                                <div class="w-1 h-1 rounded-full bg-outline-variant/60"></div>
                                <span class="flex items-center gap-1 text-xs font-bold text-on-surface-variant">
                                    <span class="material-symbols-outlined text-sm">speed</span>
                                    {{ $song->bpm }} <span class="text-[10px]">BPM</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div
                        class="w-20 h-20 bg-surface-container-high rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant">library_music</span>
                    </div>
                    <h3 class="text-xl font-bold text-on-surface-variant">Nenhuma música encontrada</h3>
                    <p class="text-on-surface-variant mt-2">Comece por cadastrar suas músicas favoritas do Samba!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection