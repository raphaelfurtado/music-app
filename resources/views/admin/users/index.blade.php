@extends('layouts.master')

@section('title', 'Gestão de Usuários - Admin')

@section('content')
    <div class="px-4 py-6 md:px-8 md:py-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-2 italic tracking-tight">
                    Gestão de Usuários
                </h1>
                <p class="text-gray-500 dark:text-gray-400">Administre permissões e privilégios dos usuários da plataforma.</p>
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

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl flex items-center gap-3">
                <span class="material-symbols-outlined text-xl">error</span>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-dark-card border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white/5 text-gray-400 text-xs uppercase tracking-widest">
                            <th class="px-8 py-4">Usuário</th>
                            <th class="px-8 py-4">Papéis</th>
                            <th class="px-8 py-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @foreach ($users as $user)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        @if ($user->avatar)
                                            <img src="{{ $user->avatar }}" class="w-10 h-10 rounded-full border border-white/10">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-white">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-wrap gap-2">
                                        @if ($user->is_admin)
                                            <span class="px-2 py-0.5 rounded-full bg-purple-500/10 text-purple-500 text-[10px] font-bold uppercase tracking-wider border border-purple-500/20">Admin</span>
                                        @endif
                                        @if ($user->is_premium)
                                            <span class="px-2 py-0.5 rounded-full bg-cyan-400/10 text-cyan-400 text-[10px] font-bold uppercase tracking-wider border border-cyan-400/20">Premium</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full bg-gray-500/10 text-gray-500 text-[10px] font-bold uppercase tracking-wider border border-gray-500/20 text-opacity-50">Free</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <form action="{{ route('admin.users.toggle-premium', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-cyan-400/10 text-cyan-400 hover:bg-cyan-400/20 transition-colors text-xs font-bold whitespace-nowrap">
                                                <span class="material-symbols-outlined text-sm">stars</span>
                                                {{ $user->is_premium ? 'Remover Premium' : 'Tornar Premium' }}
                                            </button>
                                        </form>

                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-purple-500/10 text-purple-500 hover:bg-purple-500/20 transition-colors text-xs font-bold whitespace-nowrap">
                                                <span class="material-symbols-outlined text-sm">admin_panel_settings</span>
                                                {{ $user->is_admin ? 'Remover Admin' : 'Tornar Admin' }}
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile List -->
            <div class="md:hidden divide-y divide-white/5">
                @foreach ($users as $user)
                    <div class="px-6 py-6 transition-colors">
                        <div class="flex items-center gap-4 mb-4">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" class="w-12 h-12 rounded-full border border-white/10">
                            @else
                                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xl">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div class="text-lg font-bold text-white leading-none mb-1">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-6">
                            @if ($user->is_admin)
                                <span class="px-2 py-0.5 rounded-full bg-purple-500/10 text-purple-500 text-[10px] font-bold uppercase tracking-wider border border-purple-500/20">Admin</span>
                            @endif
                            @if ($user->is_premium)
                                <span class="px-2 py-0.5 rounded-full bg-cyan-400/10 text-cyan-400 text-[10px] font-bold uppercase tracking-wider border border-cyan-400/20">Premium</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-gray-500/10 text-gray-500 text-[10px] font-bold uppercase tracking-wider border border-gray-500/20">Free</span>
                            @endif
                        </div>

                        <div class="flex flex-col gap-3">
                            <form action="{{ route('admin.users.toggle-premium', $user) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-cyan-400/10 text-cyan-400 active:scale-95 transition-transform text-sm font-bold border border-cyan-400/20">
                                    <span class="material-symbols-outlined">stars</span>
                                    {{ $user->is_premium ? 'Remover Plano Premium' : 'Ativar Plano Premium' }}
                                </button>
                            </form>

                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-purple-500/10 text-purple-500 active:scale-95 transition-transform text-sm font-bold border border-purple-500/20">
                                    <span class="material-symbols-outlined">shield_person</span>
                                    {{ $user->is_admin ? 'Remover Acesso Admin' : 'Conceder Acesso Admin' }}
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-8">
            {{ $users->links() }}
        </div>
    </div>
@endsection
