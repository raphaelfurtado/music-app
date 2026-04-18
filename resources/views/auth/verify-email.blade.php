@extends('layouts.master')

@section('title', 'Verificar E-mail')

@section('content')
    <div class="flex flex-col justify-center min-h-[80vh] px-6 max-w-md mx-auto">
        <h1 class="text-3xl font-bold text-on-surface mb-2">Verifique seu e-mail</h1>
        <p class="mb-4 text-sm text-on-surface-variant">
            Confirme seu endereço de e-mail clicando no link que enviamos. Se não recebeu, podemos reenviar.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-tertiary bg-tertiary/10 border border-tertiary/30 rounded-xl p-3">
                Um novo link de verificação foi enviado para seu e-mail.
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between gap-3">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-3 rounded-xl nm-gradient-gold text-on-primary-container font-bold text-xs uppercase tracking-[0.14em]">
                    Reenviar verificação
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="py-3 px-4 rounded-xl bg-surface-container-low text-on-surface-variant hover:text-on-surface transition-colors text-xs uppercase tracking-[0.14em] font-bold">
                    Sair
                </button>
            </form>
        </div>
    </div>
@endsection
