@extends('layouts.master')
@section('title', 'Minhas Músicas')
@section('content')
<div class="px-4 py-6 pb-24">
    <h1 class="text-2xl font-bold mb-6 text-slate-900 dark:text-white">Minhas Músicas</h1>

    <div class="flex flex-col gap-2">
        @foreach($songs as $song)
            <div class="p-4 bg-white dark:bg-surface-dark rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                <h3 class="font-bold text-slate-900 dark:text-white">{{ $song->title }}</h3>
                <p class="text-xs text-gray-500">{{ $song->artist ?? 'Artista desconhecido' }} • Tom:
                    {{ $song->key ?? '-' }}</p>
            </div>
        @endforeach
    </div>
@endsection    