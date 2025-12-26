<div>
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4 sm:p-6" x-data
            x-trap.noscroll="true">

            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" wire:click="close"></div>

            <div
                class="relative w-full max-w-lg bg-white dark:bg-surface-dark rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden animate-in slide-in-from-bottom-10 fade-in duration-200">

                <div
                    class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-white dark:bg-surface-dark sticky top-0 z-10">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        {{ $editingSongId ? 'Editar Música' : 'Nova Música' }}
                    </h3>
                    <button wire:click="close"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto custom-scrollbar space-y-5">

                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 ml-1">Nome da
                            Música</label>
                        <input wire:model="title" type="text" placeholder="Ex: Oceano"
                            class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-background-dark text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm py-3 px-4" />
                        @error('title') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 ml-1">Artista</label>
                        <input wire:model="artist" type="text" placeholder="Ex: Djavan"
                            class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-background-dark text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm py-3 px-4" />
                        @error('artist') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 ml-1">Tom</label>
                                @if($key)
                                    <span
                                        class="text-xs font-bold text-primary bg-primary/10 px-2 py-0.5 rounded">{{ $key }}</span>
                                @endif
                            </div>

                            <div class="mb-2">
                                <span class="text-[10px] font-bold text-gray-400 ml-1 uppercase">Maiores</span>
                                <div class="flex gap-2 overflow-x-auto custom-scrollbar pb-2 pt-1">
                                    @foreach(['C', 'Db', 'D', 'Eb', 'E', 'F', 'F#', 'G', 'Ab', 'A', 'Bb', 'B'] as $k)
                                                            <button type="button" wire:click="$set('key', '{{ $k }}')" class="shrink-0 w-10 h-10 rounded-lg text-sm font-bold transition-all border
                                                                        {{ $key === $k
                                        ? 'bg-primary text-white border-primary shadow-lg shadow-blue-500/30 ring-2 ring-primary/20'
                                        : 'bg-white dark:bg-surface-dark text-slate-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:border-primary hover:text-primary' 
                                                                        }}">
                                                                {{ $k }}
                                                            </button>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <span class="text-[10px] font-bold text-gray-400 ml-1 uppercase">Menores</span>
                                <div class="flex gap-2 overflow-x-auto custom-scrollbar pb-2 pt-1">
                                    @foreach(['Cm', 'C#m', 'Dm', 'Ebm', 'Em', 'Fm', 'F#m', 'Gm', 'G#m', 'Am', 'Bbm', 'Bm'] as $k)
                                                            <button type="button" wire:click="$set('key', '{{ $k }}')" class="shrink-0 w-auto px-3 h-10 rounded-lg text-xs font-bold transition-all border
                                                                        {{ $key === $k
                                        ? 'bg-primary text-white border-primary shadow-lg shadow-blue-500/30 ring-2 ring-primary/20'
                                        : 'bg-gray-50 dark:bg-surface-dark text-slate-600 dark:text-gray-400 border-gray-200 dark:border-gray-700 hover:border-primary hover:text-primary' 
                                                                        }}">
                                                                {{ $k }}
                                                            </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 ml-1">BPM (Batidas
                                por minuto)</label>
                            <div class="relative">
                                <input wire:model="bpm" type="number" placeholder="Ex: 120"
                                    class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-background-dark text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm py-3 px-4 transition-all" />
                                <div
                                    class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-xs font-bold text-gray-400">
                                    BPM
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 ml-1">Trecho da Letra /
                            Obs</label>
                        <textarea wire:model="lyrics" rows="4" placeholder="Cole o início da letra aqui..."
                            class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-background-dark text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm py-3 px-4 resize-none"></textarea>
                    </div>
                </div>

                <div class="p-6 pt-2 bg-white dark:bg-surface-dark sticky bottom-0 z-10">
                    <button wire:click="save"
                        class="w-full py-3.5 rounded-xl bg-primary text-white font-bold shadow-lg shadow-blue-500/25 hover:bg-blue-600 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">save</span>
                        {{ $editingSongId ? 'Atualizar Música' : 'Adicionar Música' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>