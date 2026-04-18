@extends('layouts.master')

@section('title', 'Editar Artista - ' . $artist->name)

@section('content')
    <div class="max-w-3xl mx-auto py-12">
        <div class="mb-12 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-slate-900 dark:text-white uppercase italic tracking-tighter">Editar
                    <span class="text-samba-gold">Artista</span></h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Atualize as informações de {{ $artist->name }}.</p>
            </div>
            <a href="{{ route('artists.index') }}"
                class="text-gray-500 hover:text-white transition-colors flex items-center gap-2 font-bold uppercase tracking-widest text-xs">
                <span class="material-symbols-outlined">arrow_back</span>
                Voltar
            </a>
        </div>

        <form action="{{ route('artists.update', $artist) }}" method="POST"
            class="space-y-8 bg-white dark:bg-dark-card p-10 rounded-[3rem] shadow-xl ring-1 ring-gray-100 dark:ring-white/5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-8">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name"
                        class="block text-sm font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 italic">Nome
                        do Artista</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $artist->name) }}" required
                        class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-samba-gold transition-all"
                        placeholder="Ex: Zeca Pagodinho">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Image URL -->
                <div class="space-y-2">
                    <label for="image_url"
                        class="block text-sm font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 italic">URL
                        da Imagem</label>
                    <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $artist->image_url) }}"
                        class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-samba-gold transition-all"
                        placeholder="https://exemplo.com/foto.jpg">
                    @error('image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Bio -->
                <div class="space-y-2">
                    <label for="bio"
                        class="block text-sm font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 italic">Biografia
                        / Descrição</label>
                    <textarea name="bio" id="bio" rows="4"
                        class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-samba-gold transition-all"
                        placeholder="Conte um pouco sobre a história do artista...">{{ old('bio', $artist->bio) }}</textarea>
                    @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6">
                <button type="submit"
                    class="w-full py-5 bg-samba-gold text-dark-bg font-black rounded-2xl hover:bg-yellow-500 transition-all shadow-xl shadow-samba-gold/20 uppercase tracking-widest italic flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined font-bold">save</span>
                    Atualizar Artista
                </button>
            </div>
        </form>

        @can('admin')
            <div class="mt-12 p-10 bg-red-500/5 rounded-[3rem] border border-red-500/10 flex items-center justify-between">
                <div>
                    <h3 class="text-red-500 font-black uppercase italic tracking-tighter text-lg">Zona de Perigo</h3>
                    <p class="text-red-500/60 text-sm font-bold">Esta ação não pode ser desfeita.</p>
                </div>
                <form action="{{ route('artists.destroy', $artist) }}" method="POST"
                    onsubmit="return confirm('Tem certeza que deseja excluir este artista? Todas as músicas vinculadas a ele ficarão sem artista.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-3 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all uppercase tracking-widest text-xs italic">
                        Excluir Artista
                    </button>
                </form>
            </div>
        @endcan
    </div>
@endsection