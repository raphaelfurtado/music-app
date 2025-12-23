<div class="flex-1 w-full max-w-md mx-auto px-4 pb-32 pt-6">

    <div class="mb-8">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nome do Bloco</label>
        <input wire:model="name" type="text"
            class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm py-3 px-4 placeholder-gray-400 transition-all" />
        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                ? 'bg-primary text-white shadow-lg shadow-blue-500/20 border-2 border-primary'
                : 'bg-white dark:bg-surface-dark text-slate-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-primary/50' 
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
            <span
                class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                {{ count($addedSongs) }} Músicas
            </span>
        </div>

        <div class="flex gap-2 items-start mb-4 relative z-20">
            <div class="relative flex-1">
                <div
                    class="w-full flex items-center gap-3 p-3 rounded-xl border-dashed border-2 border-gray-300 dark:border-gray-700 bg-transparent hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all focus-within:border-primary focus-within:ring-1 focus-within:ring-primary h-[54px]">
                    <span class="material-symbols-outlined text-gray-400">search</span>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="w-full bg-transparent border-none p-0 focus:ring-0 text-slate-900 dark:text-white placeholder-gray-500"
                        placeholder="Busque ou crie uma música...">
                </div>

                @if(!empty($this->searchResults) || strlen($search) > 2)
                    <div
                        class="absolute top-16 left-0 w-full bg-white dark:bg-surface-dark rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden z-30">
                        @foreach($this->searchResults as $result)
                            <button wire:click="addSong({{ $result->id }})"
                                class="w-full text-left p-3 hover:bg-gray-50 dark:hover:bg-gray-700 flex justify-between items-center border-b border-gray-100 dark:border-gray-800 last:border-0">
                                <div>
                                    <p class="font-bold text-sm dark:text-white">{{ $result->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $result->artist }}</p>
                                </div>
                                <span
                                    class="text-xs font-bold bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $result->key }}</span>
                            </button>
                        @endforeach

                        @if(strlen($search) > 2)
                            <div class="p-2 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-background-dark">
                                <button wire:click="$dispatch('openSongModal', { searchName: '{{ $search }}' })"
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
                class="w-14 h-[54px] rounded-xl bg-primary text-white hover:bg-blue-600 transition-colors flex items-center justify-center shadow-lg shadow-blue-500/20">
                <span class="material-symbols-outlined">add</span>
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

                    <div class="flex-1 min-w-0 pointer-events-none select-none pr-2">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                            {{ $song['title'] }}
                        </h3>
                        @if(!empty($song['lyrics']))
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5 italic">
                                "{{ Str::limit($song['lyrics'], 40) }}"
                            </p>
                        @else
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                {{ $song['artist'] ?? '' }}
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        @if(isset($song['key']))
                            <span
                                class="px-2 py-1 rounded text-xs font-bold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                {{ $song['key'] }}
                            </span>
                        @endif

                        <button wire:click.stop="editSong({{ $song['id'] }})" type="button"
                            class="p-1.5 text-blue-400 hover:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </button>

                        <button wire:click.stop="removeSong({{ $index }})" type="button"
                            class="p-1.5 text-red-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </div>
                </div>
            @empty
                <div
                    class="text-center py-8 text-gray-400 text-sm italic border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                    Nenhuma música neste bloco.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
        <div class="flex gap-3">
            <a href="{{ route('repertoires.show', $block->repertoire_id) }}"
                class="flex-1 h-12 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-surface-dark text-slate-900 dark:text-white font-semibold text-base hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors active:scale-[0.98]">
                Voltar
            </a>

            <button wire:click="save" wire:loading.attr="disabled"
                class="flex-1 h-12 flex items-center justify-center rounded-xl bg-primary text-white font-semibold text-base shadow-lg shadow-blue-500/30 hover:bg-blue-600 transition-colors active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed">
                <span wire:loading.remove>Salvar Bloco</span>
                <div wire:loading class="flex items-center gap-2">
                    <span class="material-symbols-outlined animate-spin text-xl">progress_activity</span>
                    <span>Salvando...</span>
                </div>
            </button>
        </div>
    </div>

    @if($showSongModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4 sm:p-6" x-data
            x-trap.noscroll="true">

            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" wire:click="resetSongForm"></div>

            <div
                class="relative w-full max-w-lg bg-white dark:bg-surface-dark rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden animate-in slide-in-from-bottom-10 fade-in duration-200">

                <div
                    class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-white dark:bg-surface-dark sticky top-0 z-10">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        {{ $editingSongId ? 'Editar Música' : 'Nova Música' }}
                    </h3>
                    <button wire:click="resetSongForm"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto custom-scrollbar space-y-5">

                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 ml-1">Nome da
                            Música</label>
                        <input wire:model="songName" type="text" placeholder="Ex: Oceano"
                            class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-background-dark text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm py-3 px-4" />
                        @error('songName') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-4">

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 ml-1">Tom</label>
                                @if($songKey)
                                    <span
                                        class="text-xs font-bold text-primary bg-primary/10 px-2 py-0.5 rounded">{{ $songKey }}</span>
                                @endif
                            </div>

                            <div class="mb-2">
                                <span class="text-[10px] font-bold text-gray-400 ml-1 uppercase">Maiores</span>
                                <div class="flex gap-2 overflow-x-auto custom-scrollbar pb-2 pt-1">
                                    @foreach(['C', 'Db', 'D', 'Eb', 'E', 'F', 'F#', 'G', 'Ab', 'A', 'Bb', 'B'] as $key)
                                                            <button type="button" wire:click="$set('songKey', '{{ $key }}')" class="shrink-0 w-10 h-10 rounded-lg text-sm font-bold transition-all border
                                                                    {{ $songKey === $key
                                        ? 'bg-primary text-white border-primary shadow-lg shadow-blue-500/30 ring-2 ring-primary/20'
                                        : 'bg-white dark:bg-surface-dark text-slate-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:border-primary hover:text-primary' 
                                                                    }}">
                                                                {{ $key }}
                                                            </button>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <span class="text-[10px] font-bold text-gray-400 ml-1 uppercase">Menores</span>
                                <div class="flex gap-2 overflow-x-auto custom-scrollbar pb-2 pt-1">
                                    @foreach(['Cm', 'C#m', 'Dm', 'Ebm', 'Em', 'Fm', 'F#m', 'Gm', 'G#m', 'Am', 'Bbm', 'Bm'] as $key)
                                                            <button type="button" wire:click="$set('songKey', '{{ $key }}')" class="shrink-0 w-auto px-3 h-10 rounded-lg text-xs font-bold transition-all border
                                                                    {{ $songKey === $key
                                        ? 'bg-primary text-white border-primary shadow-lg shadow-blue-500/30 ring-2 ring-primary/20'
                                        : 'bg-gray-50 dark:bg-surface-dark text-slate-600 dark:text-gray-400 border-gray-200 dark:border-gray-700 hover:border-primary hover:text-primary' 
                                                                    }}">
                                                                {{ $key }}
                                                            </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 ml-1">BPM (Batidas
                                por minuto)</label>
                            <div class="relative">
                                <input wire:model="songBpm" type="number" placeholder="Ex: 120"
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
                        <textarea wire:model="songLyrics" rows="4" placeholder="Cole o início da letra aqui..."
                            class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-background-dark text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm py-3 px-4 resize-none"></textarea>
                    </div>
                </div>

                <div class="p-6 pt-2 bg-white dark:bg-surface-dark sticky bottom-0 z-10">
                    <button wire:click="saveSong"
                        class="w-full py-3.5 rounded-xl bg-primary text-white font-bold shadow-lg shadow-blue-500/25 hover:bg-blue-600 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">save</span>
                        {{ $editingSongId ? 'Atualizar Música' : 'Adicionar Música' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>