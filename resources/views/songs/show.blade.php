@extends('layouts.master')

@section('title', $song->title . ' - ' . ($song->artistModel->name ?? $song->artist) . ' | SambaApp')

@section('content')
    <div class="max-w-5xl mx-auto px-6 py-12 pb-32">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm font-black uppercase tracking-widest text-gray-500 mb-8 italic">
            <a href="{{ route('artists.index') }}" class="hover:text-samba-gold transition-colors">Artistas</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            @if($song->artistModel)
                <a href="{{ route('artists.show', $song->artistModel->id) }}"
                    class="hover:text-samba-gold transition-colors">{{ $song->artistModel->name }}</a>
            @else
                <span class="text-gray-400">{{ $song->artist ?? 'Independente' }}</span>
            @endif
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-samba-gold">{{ $song->title }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Main Lyrics Content -->
            <div class="flex-1">
                <div class="mb-12">
                    <h1
                        class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white uppercase italic tracking-tighter leading-none mb-4">
                        {{ $song->title }}
                    </h1>
                    <div class="flex items-center gap-4">
                        @if($song->artistModel)
                            <h2 class="text-xl font-bold text-gray-500 hover:text-samba-gold transition-colors">
                                <a href="{{ route('artists.show', $song->artistModel->id) }}">{{ $song->artistModel->name }}</a>
                            </h2>
                        @endif
                        <div class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-700"></div>
                        <span
                            class="px-3 py-1 bg-samba-gold/10 text-samba-gold rounded-lg text-sm font-black uppercase tracking-widest italic">
                            Tom: {{ $song->key ?? '-' }}
                        </span>
                    </div>
                </div>

                <!-- Cifra/Lyrics Container -->
                <div
                    class="relative bg-white dark:bg-dark-card rounded-[3rem] p-8 md:p-16 shadow-xl ring-1 ring-gray-100 dark:ring-white/5">
                    <div class="absolute top-8 right-8 flex gap-4">
                        <!-- Tools (Visual only for now) -->
                        <button
                            class="p-3 rounded-2xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-samba-gold transition-all"
                            title="Aumentar Fonte">
                            <span class="material-symbols-outlined font-bold">format_size</span>
                        </button>
                        <button
                            class="p-3 rounded-2xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-samba-gold transition-all"
                            title="Auto-scrolling">
                            <span class="material-symbols-outlined font-bold">unfold_more</span>
                        </button>
                    </div>

                    <pre
                        class="font-mono text-lg md:text-xl leading-relaxed whitespace-pre-wrap dark:text-gray-200 selection:bg-samba-gold/30">{{ $song->lyrics ?? 'Letra não disponível para esta música.' }}</pre>
                </div>
            </div>

            <!-- Sidebar / Action Container -->
            <div class="w-full lg:w-80 space-y-6">
                @auth
                    <div class="p-8 bg-samba-gold text-dark-bg rounded-[2.5rem] shadow-2xl shadow-samba-gold/20">
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] mb-4 opacity-70 italic">Gerenciamento</h4>
                        <p class="font-bold text-lg mb-6 leading-tight">Gostou dessa música? Adicione ao seu repertório!</p>

                        <button onclick="window.location.href='{{ route('dashboard') }}?add_song={{ $song->id }}'"
                            class="w-full py-4 bg-dark-bg text-white font-black text-sm rounded-2xl hover:bg-black transition-all shadow-xl shadow-black/20 uppercase tracking-widest italic">
                            Adicionar ao Setlist
                        </button>
                    </div>
                @else
                    <div
                        class="p-8 bg-dark-card text-white rounded-[2.5rem] shadow-xl ring-1 ring-white/5 border border-white/5">
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] mb-4 text-samba-gold italic italic">Exclusivo
                        </h4>
                        <p class="font-bold text-lg mb-6 leading-tight">Crie seus próprios repertórios de Samba gratuitamente.
                        </p>
                        <a href="{{ route('register') }}"
                            class="block w-full py-4 bg-samba-gold text-dark-bg text-center font-black text-sm rounded-2xl hover:bg-yellow-500 transition-all uppercase tracking-widest italic">
                            Cadastrar Agora
                        </a>
                    </div>
                @endauth

                <!-- Meta Stats -->
                <div
                    class="p-8 bg-white dark:bg-dark-card rounded-[2.5rem] shadow-sm ring-1 ring-gray-100 dark:ring-white/5 space-y-6">
                    <div>
                        <span
                            class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Andamento</span>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-samba-gold">speed</span>
                            <span class="text-lg font-black text-slate-900 dark:text-white">{{ $song->bpm ?? '--' }} <span
                                    class="text-xs text-gray-500">BPM</span></span>
                        </div>
                    </div>
                    <div class="h-px bg-gray-100 dark:bg-white/5"></div>
                    <div>
                        <span
                            class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Compartilhar</span>
                        <div class="flex gap-3">
                            <button
                                class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-samba-gold transition-all">
                                <span class="material-symbols-outlined text-lg">share</span>
                            </button>
                            <button
                                class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-samba-gold transition-all">
                                <span class="material-symbols-outlined text-lg">content_copy</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection