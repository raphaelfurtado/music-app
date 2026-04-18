<div>
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4 sm:p-6" x-data
            x-trap.noscroll="true">

            <div class="absolute inset-0 bg-dark-bg/80 backdrop-blur-md transition-opacity" wire:click="close"></div>

            <div
                class="relative w-full max-w-xl bg-white dark:bg-dark-card rounded-[3rem] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden animate-in slide-in-from-bottom-10 fade-in duration-300 ring-1 ring-white/10">

                <div
                    class="px-8 py-6 border-b border-gray-100 dark:border-white/5 flex items-center justify-between bg-white dark:bg-dark-card sticky top-0 z-10">
                    <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase italic tracking-tighter">
                        {{ $editingSongId ? 'Editar' : 'Nova' }} <span class="text-samba-gold">Música</span>
                    </h3>
                    <button wire:click="close"
                        class="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-400 hover:text-samba-gold transition-all">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="p-8 overflow-y-auto custom-scrollbar space-y-8">

                    <!-- Title -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1 italic">Título do
                            Show</label>
                        <input wire:model="title" type="text" placeholder="Ex: Deixa a Vida Me Levar"
                            class="block w-full rounded-2xl border-none bg-gray-50 dark:bg-dark-bg text-slate-900 dark:text-white focus:ring-2 focus:ring-samba-gold shadow-sm py-4 px-6 font-bold" />
                        @error('title') <span
                        class="text-red-500 text-[10px] font-bold uppercase ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Artist (Official) -->
                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1 italic">Artista
                                (Oficial)</label>
                            <select wire:model="artist_id"
                                class="block w-full rounded-2xl border-none bg-gray-50 dark:bg-dark-bg text-slate-900 dark:text-white focus:ring-2 focus:ring-samba-gold shadow-sm py-4 px-6 font-bold appearance-none">
                                <option value="">Selecione...</option>
                                @foreach($artists as $a)
                                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Artist (Manual) -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1 italic">Nome
                                Manual (Opcional)</label>
                            <input wire:model="artist" type="text" placeholder="Ex: Zeca Pagodinho"
                                class="block w-full rounded-2xl border-none bg-gray-50 dark:bg-dark-bg text-slate-900 dark:text-white focus:ring-2 focus:ring-samba-gold shadow-sm py-4 px-6 font-bold" />
                        </div>
                    </div>

                    <!-- Key & BPM Section -->
                    <div class="space-y-6 bg-gray-50 dark:bg-dark-bg/50 p-6 rounded-[2rem]">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <label
                                    class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1 italic">Tom
                                    da Cifra</label>
                                @if($key)
                                    <span
                                        class="text-xs font-black text-dark-bg bg-samba-gold px-3 py-1 rounded-lg uppercase italic">{{ $key }}</span>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <span
                                        class="text-[9px] font-black text-gray-400 ml-1 uppercase tracking-widest">Maiores</span>
                                    <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2 pt-1 mt-1">
                                        @foreach(['C', 'Db', 'D', 'Eb', 'E', 'F', 'F#', 'G', 'Ab', 'A', 'Bb', 'B'] as $k)
                                                                    <button type="button" wire:click="$set('key', '{{ $k }}')" class="shrink-0 w-11 h-11 rounded-xl text-xs font-black transition-all border
                                                                                {{ $key === $k
                                            ? 'bg-samba-gold text-dark-bg border-samba-gold shadow-lg shadow-samba-gold/20'
                                            : 'bg-white dark:bg-dark-card text-slate-700 dark:text-gray-300 border-gray-200 dark:border-white/5 hover:border-samba-gold' 
                                                                                }}">
                                                                        {{ $k }}
                                                                    </button>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <span
                                        class="text-[9px] font-black text-gray-400 ml-1 uppercase tracking-widest">Menores</span>
                                    <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2 pt-1 mt-1">
                                        @foreach(['Cm', 'C#m', 'Dm', 'Ebm', 'Em', 'Fm', 'F#m', 'Gm', 'G#m', 'Am', 'Bbm', 'Bm'] as $k)
                                                                    <button type="button" wire:click="$set('key', '{{ $k }}')" class="shrink-0 px-3 h-11 rounded-xl text-[10px] font-black transition-all border
                                                                                {{ $key === $k
                                            ? 'bg-samba-gold text-dark-bg border-samba-gold shadow-lg shadow-samba-gold/20'
                                            : 'bg-white dark:bg-dark-card text-slate-600 dark:text-gray-300 border-gray-200 dark:border-white/5 hover:border-samba-gold' 
                                                                                }}">
                                                                        {{ $k }}
                                                                    </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1 italic">Andamento
                                (BPM)</label>
                            <div class="relative">
                                <input wire:model="bpm" type="number" placeholder="Ex: 95"
                                    class="block w-full rounded-2xl border-none bg-white dark:bg-dark-card text-slate-900 dark:text-white focus:ring-2 focus:ring-samba-gold shadow-sm py-4 px-6 font-bold transition-all" />
                                <div
                                    class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-[10px] font-black text-gray-400">
                                    BPM
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lyrics -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1 italic">Cifra /
                            Letra</label>
                        <textarea wire:model="lyrics" rows="6" placeholder="A letra vai aqui..."
                            class="block w-full rounded-[2rem] border-none bg-gray-50 dark:bg-dark-bg text-slate-900 dark:text-white focus:ring-2 focus:ring-samba-gold shadow-sm py-6 px-8 resize-none font-mono text-xs"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div
                    class="p-8 pt-4 bg-white dark:bg-dark-card sticky bottom-0 z-10 border-t border-gray-100 dark:border-white/5">
                    <button wire:click="save"
                        class="w-full py-5 rounded-2xl bg-samba-gold text-dark-bg font-black shadow-xl shadow-samba-gold/20 hover:bg-yellow-500 active:scale-[0.98] transition-all flex items-center justify-center gap-2 uppercase italic tracking-widest">
                        <span class="material-symbols-outlined font-black">save</span>
                        {{ $editingSongId ? 'Salvar Alterações' : 'Adicionar ao Show' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>