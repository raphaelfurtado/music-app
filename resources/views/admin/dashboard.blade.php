@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="px-4 py-6 md:px-8 md:py-10">
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-3 italic tracking-tight">
                    Painel Admin</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm md:text-base">Métricas globais e monitoramento de novos
                    acessos.</p>
            </div>
            <div class="flex flex-wrap items-center justify-center md:justify-end gap-3">
                <a href="{{ route('admin.rankings.index') }}"
                    class="flex items-center justify-center gap-2 px-6 py-3 bg-white/5 text-gray-300 font-bold rounded-2xl hover:bg-white/10 transition-all border border-white/5 active:scale-95">
                    <span class="material-symbols-outlined">emoji_events</span>
                    Rankings
                </a>
                <a href="{{ route('admin.repertoires.index') }}"
                    class="flex items-center justify-center gap-2 px-6 py-3 bg-white/5 text-gray-300 font-bold rounded-2xl hover:bg-white/10 transition-all border border-white/5 active:scale-95">
                    <span class="material-symbols-outlined">music_video</span>
                    Moderação
                </a>
                <a href="{{ route('admin.export.users') }}"
                    class="flex items-center justify-center gap-2 px-6 py-3 bg-cyan-400/10 text-cyan-400 font-bold rounded-2xl hover:bg-cyan-400/20 transition-all border border-cyan-400/20 active:scale-95">
                    <span class="material-symbols-outlined">download</span>
                    Exportar
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center justify-center gap-2 px-6 py-3 bg-white/5 text-gray-300 font-bold rounded-2xl hover:bg-white/10 transition-all border border-white/5 active:scale-95">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    Usuários
                </a>
                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 active:scale-95">
                    <span class="material-symbols-outlined">settings</span>
                    Configurações
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-12">
            <div
                class="bg-dark-card border border-white/5 rounded-3xl p-6 shadow-xl hover:border-primary/30 transition-colors group">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">group</span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Usuários</h3>
                </div>
                <p class="text-4xl font-black text-white">{{ $stats['total_users'] }}</p>
            </div>

            <div
                class="bg-dark-card border border-white/5 rounded-3xl p-6 shadow-xl hover:border-cyan-400/30 transition-colors group">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-cyan-400/10 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">library_music</span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Repertórios</h3>
                </div>
                <p class="text-4xl font-black text-white">{{ $stats['total_repertoires'] }}</p>
            </div>

            <div
                class="bg-dark-card border border-white/5 rounded-3xl p-6 shadow-xl hover:border-purple-500/30 transition-colors group sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">music_note</span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Músicas</h3>
                </div>
                <p class="text-4xl font-black text-white">{{ $stats['total_songs'] }}</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
            <!-- Growth Chart -->
            <div class="lg:col-span-2 bg-dark-card border border-white/5 rounded-3xl p-6 md:p-8 shadow-xl">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-bold flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-primary">trending_up</span>
                            Crescimento (30 dias)
                        </h3>
                        <p class="text-xs text-gray-500 uppercase tracking-widest">Novos usuários por dia</p>
                    </div>
                </div>
                <div class="h-[300px] w-full">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>

            <!-- Plan Distribution -->
            <div class="bg-dark-card border border-white/5 rounded-3xl p-6 md:p-8 shadow-xl">
                <div class="mb-8">
                    <h3 class="text-xl font-bold flex items-center gap-2 mb-1">
                        <span class="material-symbols-outlined text-cyan-400">pie_chart</span>
                        Planos
                    </h3>
                    <p class="text-xs text-gray-500 uppercase tracking-widest">Distribuição de contas</p>
                </div>
                <div class="h-[300px] w-full flex items-center justify-center">
                    <canvas id="planChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-dark-card border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
            <div
                class="px-6 py-5 md:px-8 md:py-6 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                <h2 class="text-xl font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person_add</span>
                    Novos Cadastros
                </h2>
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white/5 text-gray-400 text-xs uppercase tracking-widest">
                            <th class="px-8 py-4">Nome</th>
                            <th class="px-8 py-4">E-mail</th>
                            <th class="px-8 py-4">Data/Hora</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($stats['recent_users'] as $user)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-5 font-bold text-white">{{ $user->name }}</td>
                                <td class="px-8 py-5 text-gray-400">{{ $user->email }}</td>
                                <td class="px-8 py-5 text-gray-400">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-8 py-8 text-center text-gray-500 italic text-base">Nenhum usuário
                                    cadastrado recentemente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List -->
            <div class="md:hidden divide-y divide-white/5">
                @forelse($stats['recent_users'] as $user)
                    <div class="px-6 py-5">
                        <div class="flex flex-col gap-1">
                            <span class="text-base font-bold text-white">{{ $user->name }}</span>
                            <span class="text-sm text-gray-400">{{ $user->email }}</span>
                            <span
                                class="text-xs text-primary mt-2 flex items-center gap-1 font-medium bg-primary/10 w-fit px-2 py-0.5 rounded-full">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-500 italic">Nenhum usuário encontrado.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Configurações globais do Chart.js para o tema Dark
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.05)';
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

            // ——— Gráfico de Crescimento (Line Chart) ———
            const growthData = @json($usersPerDay);
            const growthCtx = document.getElementById('growthChart').getContext('2d');

            new Chart(growthCtx, {
                type: 'line',
                data: {
                    labels: growthData.map(d => {
                        const date = new Date(d.date);
                        return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit' });
                    }),
                    datasets: [{
                        label: 'Novos Usuários',
                        data: growthData.map(d => d.count),
                        borderColor: '#137fec',
                        backgroundColor: 'rgba(19, 127, 236, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#137fec',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1b2733',
                            titleColor: '#fff',
                            bodyColor: '#94a3b8',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            // ——— Gráfico de Distribuição (Doughnut) ———
            const planData = @json($planDistribution);
            const planCtx = document.getElementById('planChart').getContext('2d');

            new Chart(planCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Premium', 'Free'],
                    datasets: [{
                        data: [planData.premium, planData.free],
                        backgroundColor: ['#22d3ee', 'rgba(148, 163, 184, 0.2)'],
                        borderColor: 'transparent',
                        hoverOffset: 15,
                        spacing: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                color: '#fff',
                                font: { size: 12, weight: 'bold' }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush