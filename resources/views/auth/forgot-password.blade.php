@extends('layouts.master')

@section('title', 'Recuperar Senha')

@section('content')
    <div class="flex flex-col justify-center min-h-[80vh] px-6 max-w-md mx-auto">
        <h1 class="text-3xl font-bold text-on-surface mb-2">Recuperar senha</h1>
        <p class="text-on-surface-variant text-sm mb-6">
            Informe seu e-mail e enviaremos um link para redefinir sua senha.
        </p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold text-on-surface mb-1">E-mail</label>
                <input id="email" class="block w-full rounded-xl border-0 py-3.5 px-4 text-on-surface shadow-sm ring-1 ring-inset ring-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary" type="email" name="email" value="{{ old('email') }}" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button class="w-full py-4 rounded-xl nm-gradient-gold text-on-primary-container font-bold uppercase tracking-[0.14em]" type="submit">
                Enviar link
            </button>
        </form>
    </div>
@endsection
