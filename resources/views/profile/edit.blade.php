@extends('layouts.master')

@section('title', 'Editar Perfil')

@section('content')
    <div class="max-w-3xl mx-auto py-10 pb-24">
        <div class="mb-10 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-headline text-on-surface">Editar Perfil</h1>
                <p class="text-on-surface-variant text-sm mt-1">Atualize seus dados com visual consistente.</p>
            </div>
            <a href="{{ route('profile.index') }}"
                class="inline-flex items-center gap-1 px-3 py-2 rounded-md bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Voltar
            </a>
        </div>

        <form action="{{ route('profile.update') }}" method="POST"
            class="space-y-7 bg-surface-container-low p-6 md:p-8 rounded-xl nm-shadow">
            @csrf
            @method('PUT')

            <div class="flex flex-col items-center gap-3 mb-4">
                <div class="relative group">
                    @if($user->profile_photo_url)
                         <img alt="Profile" class="w-28 h-28 rounded-lg object-cover border border-outline-variant/30"
                              src="{{ $user->profile_photo_url }}" />
                    @else
                        <div class="w-28 h-28 rounded-lg bg-surface-container-high flex items-center justify-center text-primary border border-outline-variant/30">
                            <span class="material-symbols-outlined text-5xl">person</span>
                        </div>
                    @endif
                    
                    <button type="button" class="absolute -bottom-2 -right-2 bg-surface-container-high text-on-surface p-2 rounded-md border border-outline-variant/30 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-lg block">camera_alt</span>
                    </button>
                </div>
                <p class="text-xs text-on-surface-variant">Toque para alterar a foto</p>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant ml-1" for="name">
                    Nome Completo
                </label>
                <div class="relative group">
                    <input name="name" value="{{ old('name', $user->name) }}" required
                        class="block w-full px-4 py-3.5 rounded-lg border-none bg-surface-container-high text-on-surface placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-primary focus:outline-none"
                        id="name" type="text" />
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-on-surface-variant group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined">badge</span>
                    </div>
                </div>
                @error('name') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant ml-1" for="email">
                    E-mail
                </label>
                <div class="relative group">
                    <input name="email" value="{{ old('email', $user->email) }}" required
                        class="block w-full px-4 py-3.5 rounded-lg border-none bg-surface-container-high text-on-surface placeholder:text-on-surface-variant/70 focus:ring-2 focus:ring-primary focus:outline-none"
                        id="email" type="email" />
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-on-surface-variant group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                </div>
                @error('email') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 border-t border-outline-variant/20 flex gap-3">
                <a href="{{ route('profile.index') }}"
                    class="flex-1 py-4 rounded-md bg-surface-container-high text-center text-on-surface-variant hover:text-on-surface transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-[2] py-4 rounded-md font-bold uppercase tracking-[0.14em] text-on-primary-container nm-gradient-gold hover:brightness-110 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Salvar alterações
                </button>
            </div>
        </form>
    </div>
@endsection