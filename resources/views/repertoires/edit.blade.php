@extends('layouts.master')

@section('title', 'Editar Repertório')

@section('content')
    <div class="flex flex-col h-screen bg-background-light dark:bg-background-dark">

        <header
            class="sticky top-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-gray-200 dark:border-gray-800">
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

                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                        Ícone
                    </label>

                    <input type="hidden" name="icon" id="selected_icon_input" value="{{ old('icon', $repertoire->icon) }}">

                    <div class="flex gap-4 overflow-x-auto no-scrollbar py-1" id="icon-container">
                        @php
                            $icons = ['library_music', 'nightlife', 'church', 'piano', 'mic'];
                        @endphp

                        @foreach($icons as $iconName)
                                        <button type="button" onclick="selectIcon(this, '{{ $iconName }}')"
                                            class="icon-btn w-14 h-14 rounded-2xl shrink-0 transition-all active:scale-95 flex items-center justify-center 
                                                    {{ old('icon', $repertoire->icon) == $iconName
                            ? 'bg-blue-100 dark:bg-blue-900/40 text-primary border-2 border-primary'
                            : 'bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                            <span class="material-symbols-outlined">{{ $iconName }}</span>
                                        </button>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                        Visibilidade
                    </label>
                    <div
                        class="flex items-center justify-between p-4 bg-white dark:bg-surface-dark rounded-2xl shadow-sm border border-gray-100 dark:border-transparent">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500">
                                <span class="material-symbols-outlined">public</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Tornar Público</h4>
                                <p class="text-[11px] text-gray-500">Permite compartilhar via link público.</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_public" value="1" class="sr-only peer" @checked(old('is_public', $repertoire->is_public))>
                            <div
                                class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </label>
                    </div>
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

    <script>
        function selectIcon(buttonElement, iconValue) {
            document.getElementById('selected_icon_input').value = iconValue;

            const buttons = document.querySelectorAll('.icon-btn');
            buttons.forEach(btn => {
                btn.className = "icon-btn w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-gray-400 flex items-center justify-center shrink-0 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all";
            });

            buttonElement.className = "icon-btn w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/40 text-primary border-2 border-primary flex items-center justify-center shrink-0 transition-transform active:scale-95";
        }
    </script>
@endsection