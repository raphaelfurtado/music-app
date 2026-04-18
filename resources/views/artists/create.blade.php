@extends('layouts.master')

@section('title', 'Cadastrar Novo Artista')

@section('content')
    <div class="max-w-3xl mx-auto py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white uppercase italic tracking-tighter">Cadastrar <span
                    class="text-samba-gold">Artista</span></h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Adicione um novo ícone do Samba ou Pagode à biblioteca global.
            </p>
        </div>

        <form action="{{ route('artists.store') }}" method="POST"
            class="space-y-8 bg-white dark:bg-dark-card p-10 rounded-[3rem] shadow-xl ring-1 ring-gray-100 dark:ring-white/5">
            @csrf

            <div class="grid grid-cols-1 gap-8">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name"
                        class="block text-sm font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 italic">Nome
                        do Artista</label>
                    <input type="text" name="name" id="name" required
                        class="w-full bg-gray-50 dark:bg-white/5 border-none ring-1 ring-gray-200 dark:ring-white/10 rounded-2xl py-4 px-6 focus:ring-2 focus:ring-samba-gold transition-all"
                        placeholder="Ex: Zeca Pagodinho">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Image URL -->
                <div class="space-y-2">
                    <label for="image_url"
                        class="block text-sm font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 italic">URL
                        da Imagem</label>
                    <input type="url" name="image_url" id="image_url"
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
                        placeholder="Conte um pouco sobre a história do artista..."></textarea>
                    @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6">
                <button type="submit"
                    class="w-full py-5 bg-samba-gold text-dark-bg font-black rounded-2xl hover:bg-yellow-500 transition-all shadow-xl shadow-samba-gold/20 uppercase tracking-widest italic flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined font-bold">check_circle</span>
                    Salvar Artista
                </button>
            </div>
        </form>
    </div>
@endsection