@extends('layouts.master')

@section('title', 'Adicionar Música | SambaApp')

@section('content')
    <div class="max-w-3xl mx-auto py-12 pb-32">
        <div class="mb-12">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white uppercase italic tracking-tighter">Adicionar <span
                    class="text-samba-gold">Música</span></h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Cadastre uma nova cifra para a biblioteca global ou seu
                repertório.</p>
        </div>

        <form action="{{ route('songs.store') }}" method="POST"
            class="space-y-8 bg-white dark:bg-dark-card p-8 md:p-12 rounded-[3rem] shadow-xl ring-1 ring-gray-100 dark:ring-white/5">
            @csrf
            <input type="hidden" name="return_url" value="{{ request('return_url') }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Title -->
                <div class="space-y-2 md:col-span-2">
                    <label for="title"
                        class="block text-sm font-black uppercase tracking-widest text-gray-400 italic">Título da
                        Música</label>
                    <div class="relative group">
                        <input type="text" name="title" id="title" value="{{ old('title', $title) }}" required autofocus
                            class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-samba-gold transition-all"
                            placeholder="Ex: Deixa Vida Me Levar">
                        <span
                            class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-samba-gold transition-colors">music_note</span>
                    </div>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Artist Selection -->
                <div class="space-y-2">
                    <label for="artist_id"
                        class="block text-sm font-black uppercase tracking-widest text-gray-400 italic">Artista
                        (Oficial)</label>
                    <div class="relative group">
                        <select name="artist_id" id="artist_id"
                            class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-samba-gold transition-all appearance-none">
                            <option value="">Selecione um artista...</option>
                            @foreach($artists as $artist)
                                <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
                                    {{ $artist->name }}</option>
                            @endforeach
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1 uppercase font-bold">Músicas sem artista oficial ficarão como
                        'Independente'.</p>
                    @error('artist_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Fallback Artist Name -->
                <div class="space-y-2">
                    <label for="artist" class="block text-sm font-black uppercase tracking-widest text-gray-400 italic">Nome
                        Manual (opcional)</label>
                    <input type="text" name="artist" id="artist" value="{{ old('artist') }}"
                        class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-samba-gold transition-all"
                        placeholder="Djavan, SPC, etc.">
                </div>

                <!-- Key -->
                <div class="space-y-2">
                    <label for="key" class="block text-sm font-black uppercase tracking-widest text-gray-400 italic">Tom da
                        Música</label>
                    <div class="relative group">
                        <select name="key" id="key"
                            class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-samba-gold transition-all appearance-none">
                            <option value="">Selecione o tom...</option>
                            @foreach(['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B', 'Cm', 'C#m', 'Dm', 'D#m', 'Em', 'Fm', 'F#m', 'Gm', 'G#m', 'Am', 'A#m', 'Bm'] as $k)
                                <option value="{{ $k }}" {{ old('key') == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">piano</span>
                    </div>
                </div>

                <!-- BPM -->
                <div class="space-y-2">
                    <label for="bpm"
                        class="block text-sm font-black uppercase tracking-widest text-gray-400 italic">Andamento
                        (BPM)</label>
                    <div class="relative group">
                        <input type="number" name="bpm" id="bpm" value="{{ old('bpm') }}"
                            class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-samba-gold transition-all"
                            placeholder="Ex: 95">
                        <span
                            class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">speed</span>
                    </div>
                </div>

                <!-- Lyrics -->
                <div class="space-y-2 md:col-span-2">
                    <label for="lyrics"
                        class="block text-sm font-black uppercase tracking-widest text-gray-400 italic">Cifra /
                        Letra</label>
                    <textarea name="lyrics" id="lyrics" rows="10"
                        class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-[2rem] py-6 px-8 focus:ring-2 focus:ring-samba-gold transition-all font-mono text-sm"
                        placeholder="Cole aqui a cifra ou letra da música..."></textarea>
                    @error('lyrics') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 dark:border-white/5 flex flex-col sm:flex-row gap-4">
                <a href="{{ request('return_url') ?? url()->previous() }}"
                    class="flex-1 py-5 text-center font-black uppercase tracking-widest italic text-gray-400 hover:text-white transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-[2] py-5 bg-samba-gold text-dark-bg font-black rounded-2xl hover:bg-yellow-500 transition-all shadow-xl shadow-samba-gold/20 uppercase tracking-widest italic flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined font-bold">save</span>
                    Salvar Música
                </button>
            </div>
        </form>
    </div>
@endsection