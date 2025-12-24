@extends('layouts.master')

@section('title', 'Editar Repertório')

@section('content')
    <div class="flex flex-col h-screen bg-background-light dark:bg-background-dark">
        
        <header class="sticky top-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <a href="{{ route('repertoires.show', $repertoire->id) }}"
                    class="flex items-center justify-center w-10 h-10 -ml-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors text-slate-900 dark:text-white">
                    <span class="material-symbols-outlined text-2xl">arrow_back</span>
                </a>
                <h1 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">Editar Repertório</h1>
            </div>
        </header>

        <main class="flex-1 w-full max-w-md mx-auto px-4 py-6">
            
            <form action="{{ route('repertoires.update', $repertoire->id) }}" method="POST" class="flex flex-col gap-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                        Nome do Evento
                    </label>
                    <input name="name" value="{{ old('name', $repertoire->name) }}" required
                        class="block w-full px-4 py-3.5 rounded-2xl border-none bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:outline-none shadow-sm text-base"
                        placeholder="Ex: Casamento da Júlia" type="text" />
                    @error('name') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                        Descrição / Observações
                    </label>
                    <textarea name="description" rows="4"
                        class="block w-full px-4 py-3.5 rounded-2xl border-none bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:outline-none shadow-sm text-base resize-none"
                        placeholder="Ex: Chegar 1 hora antes. Traje esporte fino.">{{ old('description', $repertoire->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col-reverse gap-3 pt-6 sm:flex-row pb-10">
                    <a href="{{ route('repertoires.show', $repertoire->id) }}"
                        class="flex-1 py-4 rounded-xl font-bold text-gray-600 dark:text-gray-300 bg-transparent border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all text-center flex items-center justify-center">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-1 py-4 rounded-xl font-bold text-white bg-primary shadow-lg shadow-blue-500/30 hover:bg-blue-600 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Salvar
                    </button>
                </div>

            </form>
        </main>
    </div>
@endsection