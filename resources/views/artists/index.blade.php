@extends('layouts.master')

@section('title', 'Artistas de Samba e Pagode')

@section('content')
    <div class="mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black text-slate-900 dark:text-white uppercase italic tracking-tighter">Explorar
                    <span class="text-samba-gold">Artistas</span></h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Encontre as melhores cifras de Samba e Pagode dos seus
                    artistas favoritos.</p>
            </div>
            @can('admin')
                <a href="{{ route('artists.create') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-samba-gold text-dark-bg font-black rounded-xl hover:bg-yellow-500 transition-all shadow-lg shadow-samba-gold/20 uppercase tracking-widest text-sm">
                    <span class="material-symbols-outlined font-bold">add</span>
                    Novo Artista
                </a>
            @endcan
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @forelse($artists as $artist)
                <div class="group flex flex-col items-center relative">
                    <a href="{{ route('artists.show', $artist->id) }}" class="w-full">
                        <div
                            class="relative w-full aspect-square mb-4 overflow-hidden rounded-[2.5rem] ring-1 ring-gray-100 dark:ring-white/5 group-hover:ring-samba-gold/50 group-hover:shadow-2xl transition-all">
                            @if($artist->image_url)
                                <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-dark-card flex items-center justify-center text-gray-700">
                                    <span class="material-symbols-outlined text-6xl">person</span>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-6">
                            </div>
                        </div>
                    </a>

                    @can('admin')
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                            <a href="{{ route('artists.edit', $artist) }}" class="w-10 h-10 bg-white dark:bg-dark-card rounded-xl flex items-center justify-center text-gray-500 hover:text-samba-gold shadow-lg ring-1 ring-black/5">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                        </div>
                    @endcan

                    <h3
                        class="text-lg font-black text-slate-900 dark:text-white group-hover:text-samba-gold transition-colors text-center uppercase italic">
                        {{ $artist->name }}</h3>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-1">{{ $artist->songs_count ?? 0 }}
                        Músicas</span>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-gray-500">Nenhum artista cadastrado ainda.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $artists->links() }}
        </div>
    </div>
@endsection