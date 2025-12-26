@extends('layouts.master')

@section('title', 'Rankings de Engajamento - Admin')

@section('content')
    <div class="px-4 py-6 md:px-8 md:py-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-2 italic tracking-tight">
                    Power Users & Popularidade
                </h1>
                <p class="text-gray-500 dark:text-gray-400">Descubra quem são seus usuários mais ativos e as músicas que
                    dominam a plataforma.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-2 text-primary hover:text-primary/80 transition-colors font-medium">
                <span class="material-symbols-outlined">arrow_back</span>
                Voltar ao Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Top Musicians -->
            <div class="bg-dark-card border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                <div class="px-6 py-5 md:px-8 md:py-6 border-b border-white/5 bg-white/[0.02]">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">emoji_events</span>
                        Top 10 Músicos (Repertórios)
                    </h2>
                </div>
                <div class="divide-y divide-white/5">
                    @forelse ($topUsers as $index => $user)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                            <div class="flex items-center gap-4">
                                <span class="w-6 text-sm font-black text-gray-700">#{{ $index + 1 }}</span>
                                <div
                                    class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-white">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-black text-white">{{ $user->repertoires_count }}</div>
                                <div class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Sets</div>
                            </div>
                        </div>
                    @empty
                        <p class="p-8 text-center text-gray-500 italic">Dados insuficientes para gerar o ranking.</p>
                    @endforelse
                </div>
            </div>

            <!-- Most Popular Songs -->
            <div class="bg-dark-card border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                <div class="px-6 py-5 md:px-8 md:py-6 border-b border-white/5 bg-white/[0.02]">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-cyan-400">trending_up</span>
                        Músicas Mais Adicionadas
                    </h2>
                </div>
                <div class="divide-y divide-white/5">
                    @forelse ($topSongs as $index => $song)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                            <div class="flex items-center gap-4 truncate">
                                <span class="w-6 text-sm font-black text-gray-700">#{{ $index + 1 }}</span>
                                <div class="w-10 h-10 rounded-xl bg-cyan-400/10 flex items-center justify-center text-cyan-400">
                                    <span class="material-symbols-outlined">music_note</span>
                                </div>
                                <div class="truncate">
                                    <div class="font-bold text-white truncate">{{ $song->title }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $song->artist }}</div>
                                </div>
                            </div>
                            <div class="text-right flex-none">
                                <div class="text-lg font-black text-white">{{ $song->total_adds }}</div>
                                <div class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Usos</div>
                            </div>
                        </div>
                    @empty
                        <p class="p-8 text-center text-gray-500 italic">Ainda não há músicas suficientes nos repertórios.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection