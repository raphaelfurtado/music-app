<div class="flex-1 w-full max-w-md mx-auto px-4 pb-32 pt-6">

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nome do Bloco</label>
        <input wire:model="name" type="text"
            class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm py-3 px-4 placeholder-gray-400 font-medium" />
        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    <div class="mb-8">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descrição (Opcional)</label>
        <textarea wire:model="description" rows="2"
            class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm py-3 px-4 placeholder-gray-400 text-sm resize-none"
            placeholder="Ex: Entrada dos padrinhos e pais..."></textarea>
    </div>

    <div class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tom Predominante</label>
            <span class="text-xs font-medium text-primary cursor-pointer hover:underline">Ver todos</span>
        </div>

        <div class="flex gap-3 overflow-x-auto no-scrollbar pb-2 -mx-4 px-4">
            @foreach($keys as $k)
                    <button type="button" wire:click="selectKey('{{ $k['key'] }}')" class="flex flex-col items-center justify-center shrink-0 w-14 h-14 rounded-2xl transition-all active:scale-95
                                    {{ $predominant_key === $k['key']
                ? 'bg-primary text-white shadow-lg shadow-blue-500/20 border-2 border-primary ring-2 ring-blue-500/20 ring-offset-2 ring-offset-background-light dark:ring-offset-background-dark'
                : 'bg-white dark:bg-surface-dark text-slate-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-primary/50 dark:hover:border-primary/50' 
                                    }}">
                        <span class="text-lg font-bold">{{ $k['key'] }}</span>
                        <span class="text-[10px] uppercase font-bold opacity-90">{{ $k['label'] }}</span>
                    </button>
            @endforeach
        </div>
    </div>

    <div class="mb-4">
        <!-- Espaço reservado para músicas (Removido na simplificação) -->
        <div
            class="p-6 bg-gray-50 dark:bg-surface-dark border border-dashed border-gray-200 dark:border-gray-700 rounded-2xl text-center">
            <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">queue_music</span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Adicionar Músicas</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 mb-4">
                Você poderá adicionar e organizar as músicas após criar o bloco básico.
            </p>
            <p class="text-xs font-semibold text-primary">Vamos configurar o básico primeiro!</p>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
        <div class="flex gap-3">

            <a href="{{ route('repertoires.show', $repertoire_id) }}"
                class="flex-1 h-12 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-surface-dark text-slate-900 dark:text-white font-semibold text-base hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors active:scale-[0.98]">
                Cancelar
            </a>

            <button wire:click="save" wire:loading.attr="disabled"
                class="flex-1 h-12 flex items-center justify-center rounded-xl bg-primary text-white font-semibold text-base shadow-lg shadow-blue-500/30 hover:bg-blue-600 transition-colors active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed">

                <span wire:loading.remove>Criar e Adicionar Músicas</span>

                <div wire:loading class="flex items-center gap-2">
                    <span class="material-symbols-outlined animate-spin text-xl">progress_activity</span>
                    <span>Criando...</span>
                </div>
            </button>

        </div>
    </div>


</div>