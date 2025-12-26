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
                <button type="button" wire:click="selectKey('{{ $k['key'] }}')"
                    class="flex flex-col items-center justify-center shrink-0 w-14 h-14 rounded-2xl transition-all active:scale-95
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

    <div class="mb-4 relative">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-base font-bold text-slate-900 dark:text-white">Músicas do Bloco</h2>
            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                {{ count($addedSongs) }} Músicas
            </span>
        </div>

        <div class="flex gap-2 items-start mb-4 relative z-20">
            <div class="relative flex-1">
                <div class="w-full flex items-center gap-3 p-3 rounded-xl border-dashed border-2 border-gray-300 dark:border-gray-700 bg-transparent hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:border-primary dark:hover:border-primary transition-all focus-within:border-primary focus-within:ring-1 focus-within:ring-primary h-[54px] group">
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors">search</span>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="w-full bg-transparent border-none p-0 focus:ring-0 text-slate-900 dark:text-white placeholder-gray-500 font-medium group-hover:text-primary transition-colors placeholder-gray-500 dark:placeholder-gray-400"
                        placeholder="Busque ou crie uma música...">
                </div>

                @if(!empty($this->searchResults) || strlen($search) > 2)
                    <div class="absolute top-16 left-0 w-full bg-white dark:bg-surface-dark rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                        
                        @foreach($this->searchResults as $result)
                            <button wire:click="addSong({{ $result->id }})"
                                class="w-full text-left p-3 hover:bg-gray-50 dark:hover:bg-gray-700 flex justify-between items-center border-b border-gray-100 dark:border-gray-800 last:border-0">
                                <div>
                                    <p class="font-bold text-sm dark:text-white">{{ $result->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $result->artist }}</p>
                                </div>
                                <div class="flex gap-2">
                                    @if($result->key) <span class="text-xs font-bold bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $result->key }}</span> @endif
                                </div>
                            </button>
                        @endforeach

                        @if(strlen($search) > 2)
                            <div class="p-2 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-background-dark">
                                <button type="button" wire:click="openSongModal"
                                    class="w-full py-3 px-4 rounded-lg bg-primary/10 text-primary hover:bg-primary hover:text-white transition-colors flex items-center justify-center gap-2 text-sm font-bold">
                                    <span class="material-symbols-outlined">add_circle</span>
                                    Cadastrar "{{ $search }}"
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <button type="button" wire:click="openSongModal"
                class="shrink-0 h-[54px] w-[54px] flex items-center justify-center rounded-xl bg-primary text-white shadow-lg shadow-blue-500/30 hover:bg-blue-600 transition-colors active:scale-95"
                title="Criar Nova Música">
                <span class="material-symbols-outlined text-2xl">add</span>
            </button>
        </div>

        <div wire:sortable="updateBlockOrder" class="flex flex-col gap-3">
            @forelse($addedSongs as $index => $song)
                <div wire:sortable.item="{{ $song['id'] }}" wire:key="song-{{ $song['id'] }}"
                    class="flex items-center p-3 bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-gray-100 dark:border-transparent group">
                    
                    <div wire:sortable.handle
                        class="cursor-grab text-gray-300 hover:text-gray-500 dark:text-gray-600 dark:hover:text-gray-400 mr-3 active:cursor-grabbing">
                        <span class="material-symbols-outlined text-xl">drag_indicator</span>
                    </div>

                    <div class="flex-1 min-w-0 pointer-events-none select-none">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $song['title'] }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $song['artist'] ?? 'Sem artista' }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @if(isset($song['bpm']) && $song['bpm'])
                             <span class="px-1.5 py-1 rounded text-[10px] font-medium bg-gray-100 dark:bg-gray-800 text-gray-500 border border-gray-200 dark:border-gray-700">
                                {{ $song['bpm'] }}
                            </span>
                        @endif
                        @if(isset($song['key']) && $song['key'])
                            <span class="px-2 py-1 rounded text-xs font-bold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                {{ $song['key'] }}
                            </span>
                        @endif
                        
                        <button wire:click="removeSong({{ $index }})" type="button"
                            class="p-1.5 ml-1 text-red-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-gray-400 text-sm italic">
                    Nenhuma música neste bloco.
                </div>
            @endforelse
        </div>
    </div>

    <div class="flex gap-3 p-4 bg-blue-50 dark:bg-blue-900/10 rounded-xl mt-6 border border-blue-100 dark:border-blue-900/20">
        <span class="material-symbols-outlined text-primary text-xl">info</span>
        <p class="text-xs text-blue-800 dark:text-blue-200 leading-relaxed font-medium">
            O tom predominante ajuda a sugerir transições.
        </p>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
        <div class="flex gap-3">
            
            <a href="{{ route('repertoires.show', $repertoire_id) }}"
                class="flex-1 h-12 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-surface-dark text-slate-900 dark:text-white font-semibold text-base hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors active:scale-[0.98]">
                Cancelar
            </a>

            <button wire:click="save" wire:loading.attr="disabled"
                class="flex-1 h-12 flex items-center justify-center rounded-xl bg-primary text-white font-semibold text-base shadow-lg shadow-blue-500/30 hover:bg-blue-600 transition-colors active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed">
                
                <span wire:loading.remove>Salvar</span>
                
                <div wire:loading class="flex items-center gap-2">
                    <span class="material-symbols-outlined animate-spin text-xl">progress_activity</span>
                    <span>Salvando...</span>
                </div>
            </button>
            
        </div>
    </div>

    <livewire:create-song-modal />
</div>