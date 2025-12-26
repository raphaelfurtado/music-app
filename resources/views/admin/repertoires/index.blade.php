@extends('layouts.master')

@section('title', 'Moderação de Repertórios - Admin')

@section('content')
    <div class="px-4 py-6 md:px-8 md:py-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-2 italic tracking-tight">
                    Moderação
                </h1>
                <p class="text-gray-500 dark:text-gray-400">Gerencie repertórios públicos e destaques da plataforma.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-2 text-primary hover:text-primary/80 transition-colors font-medium">
                <span class="material-symbols-outlined">arrow_back</span>
                Voltar ao Dashboard
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-500 rounded-2xl flex items-center gap-3">
                <span class="material-symbols-outlined text-xl">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($repertoires as $repertoire)
                <div
                    class="group bg-dark-card border border-white/5 rounded-3xl overflow-hidden shadow-2xl hover:border-primary/30 transition-all">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white text-2xl"
                                style="background-color: {{ $repertoire->color }}">
                                <span class="material-symbols-outlined text-3xl">{{ $repertoire->icon }}</span>
                            </div>
                            @if ($repertoire->is_featured)
                                <span
                                    class="px-3 py-1 bg-amber-500/10 text-amber-500 text-[10px] font-bold uppercase tracking-widest rounded-full border border-amber-500/20 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">stars</span>
                                    Destaque
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-white mb-1 group-hover:text-primary transition-colors truncate">
                            {{ $repertoire->name }}
                        </h3>
                        <p class="text-xs text-gray-500 mb-4 flex items-center gap-1 font-medium">
                            <span class="material-symbols-outlined text-sm">person</span>
                            por {{ $repertoire->user->name }}
                        </p>

                        <p class="text-sm text-gray-400 line-clamp-2 mb-6 min-h-[40px]">
                            {{ $repertoire->description ?: 'Sem descrição disponível.' }}
                        </p>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('repertoires.public', $repertoire->slug) }}" target="_blank"
                                class="flex-1 flex items-center justify-center gap-2 py-3 bg-white/5 text-gray-300 font-bold rounded-2xl hover:bg-white/10 transition-all text-xs border border-white/5 uppercase tracking-wider">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                Ver Público
                            </a>
                            <form action="{{ route('admin.repertoires.toggle-featured', $repertoire) }}" method="POST"
                                class="flex-none">
                                @csrf
                                <button type="submit"
                                    class="w-12 h-12 flex items-center justify-center rounded-2xl {{ $repertoire->is_featured ? 'bg-amber-500 text-white' : 'bg-white/5 text-gray-500 hover:text-amber-500 border border-white/5' }} transition-all shadow-lg active:scale-95">
                                    <span class="material-symbols-outlined">stars</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-dark-card border border-white/5 rounded-3xl">
                    <span class="material-symbols-outlined text-6xl text-gray-700 mb-4">music_off</span>
                    <p class="text-gray-500 italic">Nenhum repertório público encontrado no momento.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $repertoires->links() }}
        </div>
    </div>
@endsection