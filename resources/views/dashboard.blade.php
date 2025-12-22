@extends('layouts.master')
@section('content')
<main class="relative z-10 flex flex-col h-full w-full max-w-md mx-auto px-6 pb-12 pt-10">
    <div class="space-y-4">
        <h2 class="text-xl font-bold">Meus Repertórios</h2>
        
        @foreach($repertoires as $repertoire)
        <a href="{{ route('repertoires.show', $repertoire->id) }}" class="block bg-white dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-transparent">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">{{ $repertoire->icon }}</span>
                </div>
                <div>
                    <h3 class="font-bold">{{ $repertoire->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $repertoire->blocks->count() }} Blocos • {{ $repertoire->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </a>
        @endforeach
        
        <a href="{{ route('repertoires.create') }}" class="w-full py-4 rounded-2xl bg-primary text-white font-bold flex justify-center items-center gap-2">
            <span class="material-symbols-outlined">add</span> Novo Repertório
        </a>
    </div>
</main>
@endsection