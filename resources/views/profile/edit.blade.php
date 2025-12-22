@extends('layouts.master')

@section('title', 'Editar Perfil')

@section('content')
    <div class="sticky top-0 z-20 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md px-4 py-3 flex items-center gap-4 border-b border-gray-200 dark:border-gray-800">
        <a href="{{ route('profile.index') }}" 
           class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors text-slate-900 dark:text-white">
            <span class="material-symbols-outlined text-2xl">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Editar Perfil</h1>
    </div>

    <div class="px-6 py-8">
        
        <form action="{{ route('profile.update') }}" method="POST" class="flex flex-col gap-6">
            @csrf
            @method('PUT') <div class="flex flex-col items-center gap-3 mb-4">
                <div class="relative group">
                    @if($user->profile_photo_url)
                         <img alt="Profile" class="w-28 h-28 rounded-full object-cover border-4 border-white dark:border-surface-dark shadow-md" 
                              src="{{ $user->profile_photo_url }}" />
                    @else
                        <div class="w-28 h-28 rounded-full bg-primary/10 flex items-center justify-center text-primary border-4 border-white dark:border-surface-dark shadow-md">
                            <span class="material-symbols-outlined text-5xl">person</span>
                        </div>
                    @endif
                    
                    <button type="button" class="absolute bottom-0 right-0 bg-gray-900 text-white p-2 rounded-full border-2 border-white dark:border-surface-dark hover:bg-black transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-lg block">camera_alt</span>
                    </button>
                </div>
                <p class="text-xs text-gray-500">Toque para alterar a foto</p>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1" for="name">
                    Nome Completo
                </label>
                <div class="relative group">
                    <input name="name" value="{{ old('name', $user->name) }}" required
                        class="block w-full px-4 py-3.5 rounded-2xl border-none bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:outline-none shadow-sm text-base transition-shadow"
                        id="name" type="text" />
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined">badge</span>
                    </div>
                </div>
                @error('name') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1" for="email">
                    E-mail
                </label>
                <div class="relative group">
                    <input name="email" value="{{ old('email', $user->email) }}" required
                        class="block w-full px-4 py-3.5 rounded-2xl border-none bg-white dark:bg-surface-dark text-slate-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:outline-none shadow-sm text-base transition-shadow"
                        id="email" type="email" />
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                </div>
                @error('email') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 pb-20">
                <button type="submit"
                    class="w-full py-4 rounded-xl font-bold text-white bg-primary shadow-lg shadow-blue-500/30 hover:bg-blue-600 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
@endsection