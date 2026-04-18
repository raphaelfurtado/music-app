@extends('layouts.master')

@section('title', 'Criar Novo Repertório')

@section('content')
    <div class="max-w-3xl mx-auto py-10 pb-24">
        <div class="mb-10 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-headline text-on-surface">Criar Repertório</h1>
                <p class="text-on-surface-variant text-sm mt-1">Monte o setlist com estética editorial e fluxo rápido.</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-1 px-3 py-2 rounded-md bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Voltar
            </a>
        </div>

        <form action="{{ route('repertoires.store') }}" method="POST"
            class="space-y-7 bg-surface-container-low p-6 md:p-8 rounded-xl nm-shadow" id="createForm">
            @csrf

            <div class="space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant" for="name">
                    Nome do Repertório
                </label>
                <div class="relative">
                    <input autofocus
                        class="block w-full rounded-lg border-0 py-4 px-4 bg-surface-container-high text-on-surface placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-primary transition-all @error('name') ring-red-500 @enderror"
                        id="name" name="name" value="{{ old('name') }}" placeholder="Ex: Casamento João & Maria"
                        type="text" />

                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-on-surface-variant">
                        <span class="material-symbols-outlined text-xl">edit</span>
                    </div>
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant" for="description">
                        Descrição
                    </label>
                    <span class="text-xs text-on-surface-variant">Opcional</span>
                </div>
                <textarea
                    class="block w-full rounded-lg border-0 py-4 px-4 bg-surface-container-high text-on-surface placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-primary resize-none transition-all"
                    id="description" name="description"
                    placeholder="Adicione detalhes sobre o evento, local, ou observações importantes..."
                    rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="space-y-3">
                <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">
                    Ícone e Cor
                </label>

                <input type="hidden" name="icon" id="selected_icon_input" value="library_music">

                <div class="flex gap-4 overflow-x-auto no-scrollbar py-1" id="icon-container">
                    <button type="button" onclick="selectIcon(this, 'library_music')"
                        class="icon-btn w-14 h-14 rounded-lg bg-primary/10 text-primary border border-primary/50 flex items-center justify-center shrink-0 transition-all active:scale-95">
                        <span class="material-symbols-outlined">library_music</span>
                    </button>

                    <button type="button" onclick="selectIcon(this, 'nightlife')"
                        class="icon-btn w-14 h-14 rounded-lg bg-surface-container-high border border-outline-variant/30 text-on-surface-variant flex items-center justify-center shrink-0 hover:text-primary transition-all">
                        <span class="material-symbols-outlined">nightlife</span>
                    </button>

                    <button type="button" onclick="selectIcon(this, 'church')"
                        class="icon-btn w-14 h-14 rounded-lg bg-surface-container-high border border-outline-variant/30 text-on-surface-variant flex items-center justify-center shrink-0 hover:text-primary transition-all">
                        <span class="material-symbols-outlined">church</span>
                    </button>

                    <button type="button" onclick="selectIcon(this, 'piano')"
                        class="icon-btn w-14 h-14 rounded-lg bg-surface-container-high border border-outline-variant/30 text-on-surface-variant flex items-center justify-center shrink-0 hover:text-primary transition-all">
                        <span class="material-symbols-outlined">piano</span>
                    </button>

                    <button type="button" onclick="selectIcon(this, 'mic')"
                        class="icon-btn w-14 h-14 rounded-lg bg-surface-container-high border border-outline-variant/30 text-on-surface-variant flex items-center justify-center shrink-0 hover:text-primary transition-all">
                        <span class="material-symbols-outlined">mic</span>
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant ml-1">
                    Visibilidade
                </label>
                <div
                    class="flex items-center justify-between p-4 bg-surface-container-high rounded-lg border border-outline-variant/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-md bg-tertiary/15 flex items-center justify-center text-tertiary">
                            <span class="material-symbols-outlined">public</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-on-surface">Tornar Público</h4>
                            <p class="text-[11px] text-on-surface-variant">Permite compartilhar via link público.</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_public" value="1" class="sr-only peer" @checked(old('is_public'))>
                        <div
                            class="w-11 h-6 bg-surface-container-lowest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:border-on-surface/20 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-outline-variant/20 flex gap-3">
                <a href="{{ route('dashboard') }}"
                    class="flex-1 py-4 rounded-md bg-surface-container-high text-center text-on-surface-variant hover:text-on-surface transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-[2] flex items-center justify-center gap-2 rounded-md nm-gradient-gold py-4 px-3 text-sm font-bold uppercase tracking-[0.14em] text-on-primary-container hover:brightness-110 active:scale-[0.98] transition-all">
                    <span class="material-symbols-outlined">check</span>
                    Criar repertório
                </button>
            </div>
        </form>
    </div>

    <script>
        function selectIcon(buttonElement, iconValue) {
            // 1. Atualiza o input hidden (o que vai pro banco)
            document.getElementById('selected_icon_input').value = iconValue;

            // 2. Reseta o estilo de TODOS os botões para o estado "inativo"
            const buttons = document.querySelectorAll('.icon-btn');
            buttons.forEach(btn => {
                // Classes de inativo
                btn.className = "icon-btn w-14 h-14 rounded-lg bg-surface-container-high border border-outline-variant/30 text-on-surface-variant flex items-center justify-center shrink-0 hover:text-primary transition-all";
            });

            // 3. Aplica o estilo ativo
            buttonElement.className = "icon-btn w-14 h-14 rounded-lg bg-primary/10 text-primary border border-primary/50 flex items-center justify-center shrink-0 transition-transform active:scale-95";
        }
    </script>
@endsection