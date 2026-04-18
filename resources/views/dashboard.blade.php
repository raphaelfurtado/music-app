@extends('layouts.master')

@section('content')
    <div class="mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 md:gap-6 mb-8 md:mb-12">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-on-surface uppercase italic tracking-tighter">Meus <span
                        class="text-samba-gold">Repertórios</span></h1>
                <p class="text-on-surface-variant mt-2 text-sm md:text-base">Organize seus shows, churrascos e gigs de Samba.</p>
            </div>
            <a href="{{ route('repertoires.create') }}"
                class="inline-flex items-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-samba-gold text-dark-bg font-black rounded-2xl hover:bg-yellow-500 transition-all shadow-xl shadow-samba-gold/20 uppercase tracking-widest text-xs md:text-sm italic group nm-focus-ring">
                <span class="material-symbols-outlined font-bold group-hover:rotate-90 transition-transform">add</span>
                Criar Repertório
            </a>
        </div>

        <div class="md:hidden space-y-3">
            @forelse($repertoires as $repertoire)
                <a href="{{ route('repertoires.show', $repertoire->id) }}"
                    class="block bg-surface-container-low rounded-xl p-4 ring-1 ring-outline-variant/20 active:scale-[0.99] transition-transform nm-focus-ring">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-11 h-11 rounded-lg flex items-center justify-center text-white"
                                style="background-color: {{ $repertoire->color ?? '#EAB308' }}">
                                <span class="material-symbols-outlined">{{ $repertoire->icon ?? 'queue_music' }}</span>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-on-surface truncate">{{ $repertoire->name }}</h3>
                                <p class="text-xs text-on-surface-variant truncate">{{ $repertoire->blocks->count() }} blocos</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span>
                    </div>
                </a>
            @empty
                <div class="py-14 text-center bg-surface-container-low rounded-2xl ring-1 ring-outline-variant/20">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant">library_music</span>
                    <p class="text-on-surface-variant mt-2 text-sm">Nenhum repertório criado ainda.</p>
                </div>
            @endforelse
        </div>

        <div class="hidden md:grid md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse($repertoires as $repertoire)
                <div
                    class="group relative bg-surface-container-low rounded-[2rem] p-8 shadow-sm ring-1 ring-outline-variant/20 hover:ring-samba-gold/30 hover:shadow-2xl transition-all">
                    <!-- Color Bar -->
                    <div class="absolute top-8 left-0 w-1.5 h-12 rounded-r-full"
                        style="background-color: {{ $repertoire->color ?? '#EAB308' }}"></div>

                    <div class="flex flex-col gap-6">
                        <div class="flex items-start justify-between">
                            <div class="w-16 h-16 rounded-3xl flex items-center justify-center text-white shadow-lg shadow-black/10 group-hover:scale-110 transition-transform"
                                style="background-color: {{ $repertoire->color ?? '#EAB308' }}">
                                <span class="material-symbols-outlined text-4xl">{{ $repertoire->icon ?? 'queue_music' }}</span>
                            </div>

                            <div class="flex gap-2">
                                @if($repertoire->is_public)
                                    <span
                                        class="px-3 py-1 rounded-full bg-samba-green/10 text-samba-green text-[10px] font-black uppercase tracking-widest border border-samba-green/10">Público</span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full bg-gray-500/10 text-gray-500 text-[10px] font-black uppercase tracking-widest border border-gray-500/10">Privado</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3
                                class="text-2xl font-black text-on-surface mb-2 group-hover:text-samba-gold transition-colors truncate">
                                {{ $repertoire->name }}</h3>
                            <p class="text-sm text-on-surface-variant line-clamp-2 min-h-[2.5rem]">
                                {{ $repertoire->description ?? 'Sem descrição informada.' }}</p>
                        </div>

                        <div class="flex items-center justify-between border-t border-outline-variant/20 pt-6 mt-2">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Conteúdo</span>
                                <span
                                    class="text-sm font-bold text-on-surface">{{ $repertoire->blocks->count() }}
                                    Blocos</span>
                            </div>
                            <a href="{{ route('repertoires.show', $repertoire->id) }}"
                                class="p-3 rounded-full bg-surface-container-high text-on-surface-variant hover:bg-samba-gold hover:text-dark-bg transition-all">
                                <span class="material-symbols-outlined font-bold">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-24 text-center bg-surface-container-low rounded-[3rem] ring-1 ring-outline-variant/20">
                    <div
                        class="w-24 h-24 bg-surface-container-high rounded-full flex items-center justify-center mx-auto mb-8">
                        <span class="material-symbols-outlined text-5xl text-on-surface-variant">library_music</span>
                    </div>
                    <h3 class="text-2xl font-black text-on-surface uppercase italic tracking-tighter">O silêncio
                        do pandeiro...</h3>
                    <p class="text-on-surface-variant mt-3 max-w-xs mx-auto">Você ainda não criou nenhum repertório. Que tal começar um
                        agora?</p>
                    <a href="{{ route('repertoires.create') }}"
                        class="inline-flex items-center gap-2 mt-8 px-8 py-4 bg-samba-gold text-dark-bg font-black rounded-2xl hover:bg-yellow-500 transition-all uppercase tracking-widest text-sm nm-focus-ring">
                        Criar meu Primeiro Setlist
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection