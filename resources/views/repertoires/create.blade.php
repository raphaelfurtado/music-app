@extends('layouts.master')

@section('title', 'Criar Novo Repertório')

@section('content')
    <header class="sticky top-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md px-4 py-3 flex items-center gap-4 border-b border-gray-200 dark:border-gray-800">
        <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-10 h-10 -ml-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors text-slate-900 dark:text-white">
            <span class="material-symbols-outlined text-2xl">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold tracking-tight">Criar Novo Repertório</h1>
    </header>

    <main class="flex-1 w-full max-w-md mx-auto px-4 pt-6 pb-6">
        <form action="{{ route('repertoires.store') }}" method="POST" class="flex flex-col gap-6" id="createForm">
            @csrf
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300" for="name">
                    Nome do Repertório
                </label>
                <div class="relative">
                    <input autofocus
                        class="block w-full rounded-2xl border-0 py-4 px-4 bg-white dark:bg-surface-dark text-slate-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-base sm:leading-6 transition-all @error('name') ring-red-500 @enderror"
                        id="name" name="name" value="{{ old('name') }}" placeholder="Ex: Casamento João & Maria" type="text" />
                    
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                        <span class="material-symbols-outlined text-xl">edit</span>
                    </div>
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300" for="description">
                        Descrição
                    </label>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Opcional</span>
                </div>
                <textarea
                    class="block w-full rounded-2xl border-0 py-4 px-4 bg-white dark:bg-surface-dark text-slate-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-base sm:leading-6 resize-none transition-all"
                    id="description" name="description"
                    placeholder="Adicione detalhes sobre o evento, local, ou observações importantes..."
                    rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300">
                    Ícone e Cor
                </label>
                
                <input type="hidden" name="icon" id="selected_icon_input" value="library_music">

                <div class="flex gap-4 overflow-x-auto no-scrollbar py-1" id="icon-container">
                    <button type="button" onclick="selectIcon(this, 'library_music')"
                        class="icon-btn w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/40 text-primary border-2 border-primary flex items-center justify-center shrink-0 transition-all active:scale-95">
                        <span class="material-symbols-outlined">library_music</span>
                    </button>
                    
                    <button type="button" onclick="selectIcon(this, 'nightlife')"
                        class="icon-btn w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-gray-400 flex items-center justify-center shrink-0 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                        <span class="material-symbols-outlined">nightlife</span>
                    </button>

                    <button type="button" onclick="selectIcon(this, 'church')"
                        class="icon-btn w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-gray-400 flex items-center justify-center shrink-0 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                        <span class="material-symbols-outlined">church</span>
                    </button>

                    <button type="button" onclick="selectIcon(this, 'piano')"
                        class="icon-btn w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-gray-400 flex items-center justify-center shrink-0 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                        <span class="material-symbols-outlined">piano</span>
                    </button>

                    <button type="button" onclick="selectIcon(this, 'mic')"
                        class="icon-btn w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-gray-400 flex items-center justify-center shrink-0 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                        <span class="material-symbols-outlined">mic</span>
                    </button>
                </div>
            </div>

            <div class="flex-1"></div>

            <button type="submit"
                class="w-full flex items-center justify-center gap-2 rounded-2xl bg-primary py-4 px-3 text-base font-bold text-white shadow-lg shadow-blue-500/20 hover:bg-blue-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:scale-[0.98] transition-all mt-4">
                <span class="material-symbols-outlined">check</span>
                Criar Repertório
            </button>
        </form>
    </main>

    <script>
        function selectIcon(buttonElement, iconValue) {
            // 1. Atualiza o input hidden (o que vai pro banco)
            document.getElementById('selected_icon_input').value = iconValue;

            // 2. Reseta o estilo de TODOS os botões para o estado "inativo"
            const buttons = document.querySelectorAll('.icon-btn');
            buttons.forEach(btn => {
                // Classes de inativo
                btn.className = "icon-btn w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-gray-400 flex items-center justify-center shrink-0 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all";
            });

            // 3. Aplica o estilo "ativo" (Azul) APENAS no botão clicado
            buttonElement.className = "icon-btn w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/40 text-primary border-2 border-primary flex items-center justify-center shrink-0 transition-transform active:scale-95";
        }
    </script>
@endsection