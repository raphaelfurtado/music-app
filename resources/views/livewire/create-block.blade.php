<div class="flex-1 w-full max-w-md mx-auto px-4 pb-32 pt-6">

    <div class="mb-6">
        <label class="block text-sm font-black uppercase tracking-widest text-gray-500 mb-2 italic">Nome do
            Bloco</label>
        <input wire:model="name" type="text"
            class="block w-full rounded-2xl border-none bg-white dark:bg-dark-card text-slate-900 dark:text-white focus:ring-2 focus:ring-samba-gold shadow-sm py-4 px-6 placeholder-gray-400 font-bold"
            placeholder="Ex: Pagode 90, Set Relax..." />
        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <div class="mb-8">
        <label class="block text-sm font-black uppercase tracking-widest text-gray-500 mb-2 italic">Descrição
            (Opcional)</label>
        <textarea wire:model="description" rows="2"
            class="block w-full rounded-2xl border-none bg-white dark:bg-dark-card text-slate-900 dark:text-white focus:ring-2 focus:ring-samba-gold shadow-sm py-4 px-6 placeholder-gray-400 text-sm resize-none"
            placeholder="Ex: Momento de descontração..."></textarea>
    </div>

    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <label class="block text-sm font-black uppercase tracking-widest text-gray-500 italic">Tom
                Predominante</label>
        </div>

        <div class="flex gap-3 overflow-x-auto no-scrollbar pb-2 -mx-4 px-4">
            @foreach($keys as $k)
                    <button type="button" wire:click="selectKey('{{ $k['key'] }}')" class="flex flex-col items-center justify-center shrink-0 w-16 h-16 rounded-2xl transition-all active:scale-95
                                {{ $predominant_key === $k['key']
                ? 'bg-samba-gold text-dark-bg shadow-lg shadow-samba-gold/20'
                : 'bg-white dark:bg-dark-card text-slate-600 dark:text-gray-300 border border-gray-100 dark:border-white/5 hover:border-samba-gold/50' 
                                }}">
                        <span class="text-lg font-black uppercase italic">{{ $k['key'] }}</span>
                        <span class="text-[9px] uppercase font-black opacity-70">{{ $k['label'] }}</span>
                    </button>
            @endforeach
        </div>
    </div>

    <div class="mb-8">
        <div
            class="p-8 bg-gray-50 dark:bg-dark-card/50 border-2 border-dashed border-gray-200 dark:border-white/10 rounded-[2.5rem] text-center">
            <div
                class="w-16 h-16 bg-samba-gold/10 rounded-full flex items-center justify-center mx-auto mb-4 text-samba-gold">
                <span class="material-symbols-outlined text-3xl">queue_music</span>
            </div>
            <h3 class="text-base font-black text-slate-900 dark:text-white uppercase italic tracking-tighter">Próximo
                Passo: <span class="text-samba-gold">Cifras</span></h3>
            <p class="text-[10px] uppercase font-bold text-gray-500 tracking-widest mt-2 leading-relaxed px-4">
                Você poderá escolher artistas e músicas logo após criar o bloco!
            </p>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-white/5">
        <div class="flex gap-4">
            <a href="{{ route('repertoires.show', $repertoire_id) }}"
                class="flex-1 h-14 flex items-center justify-center rounded-2xl bg-gray-100 dark:bg-white/5 text-gray-500 dark:text-gray-400 font-black uppercase tracking-widest italic text-sm hover:text-white transition-colors">
                Cancelar
            </a>

            <button wire:click="save" wire:loading.attr="disabled"
                class="flex-[2] h-14 flex items-center justify-center rounded-2xl bg-samba-gold text-dark-bg font-black uppercase tracking-widest italic text-sm shadow-xl shadow-samba-gold/20 hover:bg-yellow-500 transition-all disabled:opacity-50">
                <span wire:loading.remove>Criar Bloco</span>
                <div wire:loading class="flex items-center gap-2">
                    <span class="material-symbols-outlined animate-spin text-xl font-bold">progress_activity</span>
                    <span>Criando...</span>
                </div>
            </button>
        </div>
    </div>
</div>