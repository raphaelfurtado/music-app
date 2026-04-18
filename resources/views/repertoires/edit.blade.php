@extends('layouts.master')

@section('title', 'Editar Repertório')

@section('content')
    <div class="max-w-3xl mx-auto py-10 pb-24">
        <div class="mb-10 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-headline text-on-surface">Editar Repertório</h1>
                <p class="text-on-surface-variant text-sm mt-1">Ajuste detalhes sem perder a identidade visual.</p>
            </div>
            <a href="{{ route('repertoires.show', $repertoire->id) }}"
                class="inline-flex items-center gap-1 px-3 py-2 rounded-md bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Voltar
            </a>
        </div>

        <form action="{{ route('repertoires.update', $repertoire->id) }}" method="POST"
            class="space-y-7 bg-surface-container-low p-6 md:p-8 rounded-xl nm-shadow">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant ml-1">
                        Nome do Evento
                    </label>
                    <input name="name" value="{{ old('name', $repertoire->name) }}" required
                        class="block w-full px-4 py-3.5 rounded-lg border-none bg-surface-container-high text-on-surface placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-primary focus:outline-none"
                        placeholder="Ex: Casamento da Júlia" type="text" />
                    @error('name') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant ml-1">
                        Descrição / Observações
                    </label>
                    <textarea name="description" rows="4"
                        class="block w-full px-4 py-3.5 rounded-lg border-none bg-surface-container-high text-on-surface placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-primary focus:outline-none resize-none"
                        placeholder="Ex: Chegar 1 hora antes. Traje esporte fino.">{{ old('description', $repertoire->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-4">
                    <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant ml-1">
                        Visibilidade
                    </label>
                    <div
                        class="flex items-center justify-between p-4 bg-surface-container-high rounded-lg border border-outline-variant/20">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-md bg-tertiary/15 flex items-center justify-center text-tertiary">
                                <span class="material-symbols-outlined">public</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-on-surface">Tornar Público</h4>
                                <p class="text-[11px] text-on-surface-variant">Permite compartilhar via link público.</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_public" value="1" class="sr-only peer" @checked(old('is_public', $repertoire->is_public))>
                            <div
                                class="w-11 h-6 bg-surface-container-lowest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:border-on-surface/20 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-4 border-t border-outline-variant/20 flex gap-3">
                    <a href="{{ route('repertoires.show', $repertoire->id) }}"
                        class="flex-1 py-4 rounded-md bg-surface-container-high text-center text-on-surface-variant hover:text-on-surface transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-[2] py-4 rounded-md font-bold uppercase tracking-[0.14em] text-on-primary-container nm-gradient-gold hover:brightness-110 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Salvar alterações
                    </button>
                </div>

        </form>
    </div>
@endsection