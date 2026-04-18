@extends('layouts.master')

@section('title', 'Confirmar Senha')

@section('content')
    <div class="flex flex-col justify-center min-h-[80vh] px-6 max-w-md mx-auto">
        <h1 class="text-3xl font-bold text-on-surface mb-2">Confirmar senha</h1>
        <p class="mb-4 text-sm text-on-surface-variant">
            Esta é uma área segura. Confirme sua senha para continuar.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div>
                <label for="password" class="block text-sm font-semibold text-on-surface mb-1">Senha</label>
                <input id="password" class="block w-full rounded-xl border-0 py-3.5 px-4 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button class="w-full py-4 rounded-xl nm-gradient-gold text-on-primary-container font-bold uppercase tracking-[0.14em]" type="submit">
                Confirmar
            </button>
        </form>
    </div>
@endsection
