@extends('layouts.master')

@section('title', 'Redefinir Senha')

@section('content')
    <div class="flex flex-col justify-center min-h-[80vh] px-6 max-w-md mx-auto">
        <h1 class="text-3xl font-bold text-on-surface mb-2">Nova senha</h1>
        <p class="text-on-surface-variant text-sm mb-6">Defina sua nova senha para voltar ao app.</p>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-semibold text-on-surface mb-1">E-mail</label>
                <input id="email" class="block w-full rounded-xl border-0 py-3.5 px-4 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-on-surface mb-1">Senha</label>
                <input id="password" class="block w-full rounded-xl border-0 py-3.5 px-4 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-on-surface mb-1">Confirmar senha</label>
                <input id="password_confirmation" class="block w-full rounded-xl border-0 py-3.5 px-4 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button class="w-full py-4 rounded-xl nm-gradient-gold text-on-primary-container font-bold uppercase tracking-[0.14em]" type="submit">
                Redefinir senha
            </button>
        </form>
    </div>
@endsection
