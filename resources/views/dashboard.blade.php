@extends('layouts.master')

@section('content')
    <div class="px-6 pt-8 pb-4 flex flex-col gap-6">
        
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Meus Repertórios</h2>
        </div>
        
        <div class="space-y-4">
            @forelse($repertoires as $repertoire)
                <a href="{{ route('repertoires.show', $repertoire->id) }}" 
                   class="block bg-white dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-transparent hover:scale-[1.02] transition-transform active:scale-[0.98]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">{{ $repertoire->icon ?? 'queue_music' }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">{{ $repertoire->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $repertoire->blocks->count() }} Blocos • {{ $repertoire->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-10 opacity-60">
                    <span class="material-symbols-outlined text-4xl mb-2 text-gray-400">library_music</span>
                    <p class="text-sm">Nenhum repertório criado ainda.</p>
                </div>
            @endforelse
        </div>
        
        <a href="{{ route('repertoires.create') }}" 
           class="w-full py-4 rounded-2xl bg-primary text-white font-bold flex justify-center items-center gap-2 shadow-lg shadow-blue-500/30 hover:bg-blue-600 active:scale-[0.98] transition-all">
            <span class="material-symbols-outlined">add</span> 
            Novo Repertório
        </a>

    </div>
@endsection