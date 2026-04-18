<div class="flex-1 w-full max-w-screen-2xl mx-auto px-4 md:px-6 pb-20 pt-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
        <aside class="lg:col-span-4 lg:sticky lg:top-28 self-start space-y-6">
            <div class="rounded-xl bg-surface-container-low border border-outline-variant/20 p-5 md:p-6">
                <label class="block text-xs font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3 italic">
                    Nome do Bloco
                </label>
                <input wire:model="name" type="text"
                    class="block w-full rounded-xl border-none bg-surface-container text-on-surface focus:ring-2 focus:ring-samba-gold py-3.5 px-4 placeholder:text-on-surface-variant/70 transition-all font-semibold" />
                @error('name') <span class="text-red-500 text-xs mt-2 inline-block">{{ $message }}</span> @enderror
            </div>

            <div class="rounded-xl bg-surface-container-low border border-outline-variant/20 p-5 md:p-6">
                <div class="flex items-center justify-between mb-3">
                    <label class="block text-xs font-black uppercase tracking-[0.2em] text-on-surface-variant italic">
                        Tom do Bloco
                    </label>
                </div>

                <div class="flex gap-2.5 overflow-x-auto no-scrollbar pb-2 -mx-1 px-1">
                    @foreach($keys as $k)
                        <button type="button" wire:click="selectKey('{{ $k['key'] }}')"
                            class="flex flex-col items-center justify-center shrink-0 w-14 h-14 rounded-xl transition-all active:scale-95 {{ $predominant_key === $k['key']
                                ? 'bg-samba-gold text-dark-bg shadow-lg shadow-samba-gold/20'
                                : 'bg-surface-container-high text-on-surface-variant border border-outline-variant/20 hover:border-samba-gold/50' }}">
                            <span class="text-base font-black uppercase italic leading-none">{{ $k['key'] }}</span>
                            <span class="text-[9px] uppercase font-black opacity-70 mt-1">{{ $k['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </aside>

        <section class="lg:col-span-8">
            <div class="mb-4 relative">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg md:text-xl font-black text-on-surface uppercase italic tracking-tighter">
                        Músicas <span class="text-samba-gold">do Bloco</span>
                    </h2>
                    <span
                        class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-surface-container-high text-samba-gold border border-samba-gold/30">
                        {{ count($addedSongs) }} Músicas
                    </span>
                </div>

                <div class="flex gap-2 items-start mb-6 relative z-20">
                    <div class="relative flex-1">
                        <div
                            class="w-full flex items-center gap-3 p-4 rounded-xl border border-outline-variant/20 bg-surface-container-low h-[56px] focus-within:ring-2 focus-within:ring-samba-gold transition-all">
                            @if($selectedArtist)
                                <button wire:click="clearArtist"
                                    class="flex items-center gap-2 bg-samba-gold/10 text-samba-gold px-2 py-1 rounded-lg hover:bg-samba-gold/20 mr-1">
                                    <span class="text-xs font-black uppercase tracking-widest italic">Voltar</span>
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            @else
                                <span class="material-symbols-outlined text-on-surface-variant">search</span>
                            @endif

                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="w-full bg-transparent border-none p-0 focus:ring-0 text-on-surface placeholder:text-on-surface-variant/70 font-semibold"
                                placeholder="{{ $selectedArtist ? 'Buscar na lista do artista...' : 'Busque Artista ou Música...' }}">
                        </div>

                        @if(!empty($this->searchResults) || strlen($search) > 2)
                            <div
                                class="absolute top-16 left-0 w-full bg-surface-container-low rounded-2xl shadow-2xl border border-outline-variant/20 overflow-hidden z-30 animate-in fade-in slide-in-from-top-4 duration-200">
                                @if($selectedArtist)
                                    @forelse($this->searchResults as $result)
                                        <button wire:click="addSong({{ $result->id }})"
                                            class="w-full text-left p-4 hover:bg-surface-container-high flex justify-between items-center border-b border-outline-variant/20 last:border-0 group transition-colors">
                                            <div>
                                                <p class="font-black text-on-surface group-hover:text-samba-gold transition-colors">
                                                    {{ $result->title }}
                                                </p>
                                                <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-widest mt-0.5">
                                                    Automático: Tom {{ $result->key ?? '--' }}
                                                </p>
                                            </div>
                                            <span class="material-symbols-outlined text-samba-gold">add_circle</span>
                                        </button>
                                    @empty
                                        <div class="p-6 text-center text-on-surface-variant text-sm italic">Nenhuma música encontrada.</div>
                                    @endforelse
                                @else
                                    @php $results = $this->searchResults; @endphp

                                    @if(count($results['artists'] ?? []) > 0)
                                        <div
                                            class="p-3 bg-surface-container text-[10px] font-black uppercase tracking-[0.2em] text-on-surface-variant">
                                            Artistas
                                        </div>
                                        @foreach($results['artists'] as $artist)
                                            <button wire:click="selectArtist({{ $artist->id }})"
                                                class="w-full text-left p-4 hover:bg-surface-container-high flex items-center gap-4 transition-all">
                                                <div class="w-10 h-10 rounded-full bg-samba-gold/10 flex items-center justify-center text-samba-gold">
                                                    <span class="material-symbols-outlined text-lg">person</span>
                                                </div>
                                                <span class="font-black text-on-surface uppercase italic">{{ $artist->name }}</span>
                                            </button>
                                        @endforeach
                                    @endif

                                    @if(count($results['songs'] ?? []) > 0)
                                        <div
                                            class="p-3 bg-surface-container text-[10px] font-black uppercase tracking-[0.2em] text-on-surface-variant">
                                            Músicas
                                        </div>
                                        @foreach($results['songs'] as $song)
                                            <button wire:click="addSong({{ $song->id }})"
                                                class="w-full text-left p-4 hover:bg-surface-container-high flex justify-between items-center transition-all border-t border-outline-variant/20">
                                                <span class="font-bold text-on-surface">{{ $song->title }}</span>
                                                <span class="text-[10px] font-black bg-surface-container-high px-2 py-1 rounded-lg text-on-surface-variant">{{ $song->key }}</span>
                                            </button>
                                        @endforeach
                                    @endif
                                @endif

                                @if(strlen($search) > 2)
                                    <div class="p-4 border-t border-outline-variant/20 bg-surface-container-lowest">
                                        <button wire:click="goToCreateSong('{{ $search }}')"
                                            class="w-full py-3.5 px-6 rounded-xl bg-samba-gold text-dark-bg transition-all flex items-center justify-center gap-2 text-sm font-black uppercase italic tracking-widest shadow-lg shadow-samba-gold/20">
                                            <span class="material-symbols-outlined text-lg">add_circle</span>
                                            Cadastrar "{{ $search }}"
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <button type="button" wire:click="openSongModal"
                        class="w-14 h-[56px] rounded-xl bg-surface-container-high text-samba-gold hover:bg-surface-container-highest border border-samba-gold/30 transition-all flex items-center justify-center shadow-sm active:scale-95">
                        <span class="material-symbols-outlined font-black">add</span>
                    </button>
                </div>

                <div wire:sortable="updateBlockOrder" class="flex flex-col gap-3.5">
                    @forelse($addedSongs as $index => $song)
                        @php
                            $lyricsPreview = collect(preg_split('/\r\n|\r|\n/', (string) ($song['lyrics'] ?? '')))
                                ->map(fn($line) => trim($line))
                                ->first(fn($line) => $line !== '');

                            $secondaryLine = $lyricsPreview
                                ? \Illuminate\Support\Str::limit($lyricsPreview, 80)
                                : ($song['artist'] ?: '--');
                        @endphp

                        <div wire:sortable.item="{{ $song['id'] }}" wire:key="song-{{ $song['id'] }}"
                            class="flex items-center p-4 md:p-5 bg-surface-container-low rounded-2xl md:rounded-[2rem] shadow-sm ring-1 ring-outline-variant/20 group relative overflow-hidden">

                            <div wire:sortable.handle
                                class="cursor-grab text-on-surface-variant/40 hover:text-samba-gold mr-3 md:mr-4 active:cursor-grabbing transition-colors">
                                <span class="material-symbols-outlined text-2xl font-black">drag_indicator</span>
                            </div>

                            <div class="flex-1 min-w-0 pr-2">
                                <h3 class="text-base md:text-[1.35rem] font-black text-on-surface truncate uppercase italic tracking-tight">
                                    {{ $song['title'] }}
                                </h3>
                                <p class="text-[11px] text-on-surface-variant font-semibold tracking-wide mt-1 italic truncate">
                                    {{ $secondaryLine }}
                                </p>
                            </div>

                            <div class="flex items-center gap-1.5 md:gap-3">
                                @if(isset($song['key']) && $song['key'])
                                    <span
                                        class="text-[10px] font-black bg-samba-gold/10 text-samba-gold border border-samba-gold/20 px-2.5 md:px-3 py-1.5 rounded-xl uppercase italic">
                                        {{ $song['key'] }}
                                    </span>
                                @endif

                                <button wire:click.stop="editSong({{ $song['id'] }})" type="button"
                                    class="p-2 md:p-2.5 text-on-surface-variant hover:text-samba-gold hover:bg-samba-gold/10 rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </button>

                                <button wire:click.stop="removeSong({{ $index }})" type="button"
                                    class="p-2 md:p-2.5 text-on-surface-variant hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-14 px-6 bg-surface-container-low rounded-3xl border border-dashed border-outline-variant/30 transition-all">
                            <p class="text-on-surface-variant text-sm font-bold uppercase tracking-widest italic leading-relaxed">
                                Arraste cifras para planejar o seu show!
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-outline-variant/20">
                <div class="flex gap-3 md:gap-4">
                    <a href="{{ route('repertoires.show', $block->repertoire_id) }}"
                        class="flex-1 h-12 md:h-14 flex items-center justify-center rounded-xl md:rounded-2xl bg-surface-container-high text-on-surface-variant font-black uppercase tracking-widest italic text-xs md:text-sm hover:text-on-surface transition-all">
                        Voltar
                    </a>

                    <button wire:click="save" wire:loading.attr="disabled"
                        class="flex-[2] h-12 md:h-14 flex items-center justify-center rounded-xl md:rounded-2xl bg-samba-gold text-dark-bg font-black uppercase tracking-widest italic text-xs md:text-sm shadow-xl shadow-samba-gold/20 hover:bg-yellow-500 transition-all disabled:opacity-50">
                        <span wire:loading.remove>Salvar Bloco</span>
                        <div wire:loading class="flex items-center gap-2">
                            <span class="material-symbols-outlined animate-spin text-xl font-bold">progress_activity</span>
                            <span>Salvando...</span>
                        </div>
                    </button>
                </div>
            </div>
        </section>
    </div>

    <livewire:create-song-modal />
</div>