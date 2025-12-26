@extends('layouts.master')

@section('title', 'Configurações do Sistema - Admin')

@section('content')
    <div class="px-4 py-6 md:px-8 md:py-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-2 italic tracking-tight">
                    Configurações
                </h1>
                <p class="text-gray-500 dark:text-gray-400">Gerencie avisos globais e o status do sistema.</p>
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

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Global Notice Section -->
            <div class="bg-dark-card border border-white/5 rounded-3xl p-6 md:p-8 shadow-2xl">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl">notification_important</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Aviso Global</h2>
                        <p class="text-xs text-gray-500 uppercase tracking-widest">Banner para todos os usuários</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Mensagem do
                            Aviso</label>
                        <textarea name="notice_message" rows="3"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:outline-none focus:border-primary/50 transition-colors placeholder-gray-600"
                            placeholder="Ex: Teremos uma atualização hoje às 22h...">{{ $notices['message'] }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Tipo de
                                Alerta</label>
                            <select name="notice_type"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:outline-none focus:border-primary/50 transition-colors appearance-none">
                                <option value="info" @selected($notices['type'] == 'info')>Informativo (Azul)</option>
                                <option value="success" @selected($notices['type'] == 'success')>Sucesso (Verde)</option>
                                <option value="warning" @selected($notices['type'] == 'warning')>Aviso (Amarelo)</option>
                                <option value="error" @selected($notices['type'] == 'error')>Crítico (Vermelho)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Status do
                                Aviso</label>
                            <label class="relative inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" name="notice_active" value="1" class="sr-only peer"
                                    @checked($notices['active'] == '1')>
                                <div
                                    class="w-14 h-7 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-300 uppercase tracking-widest">Ativo</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status Section -->
            <div class="bg-dark-card border border-white/5 rounded-3xl p-6 md:p-8 shadow-2xl">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500">
                        <span class="material-symbols-outlined text-3xl">construction</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Status do Sistema</h2>
                        <p class="text-xs text-gray-500 uppercase tracking-widest">Controle de acessibilidade</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-6 bg-red-500/5 border border-red-500/10 rounded-2xl">
                    <div class="max-w-md">
                        <h4 class="font-bold text-white mb-1 uppercase tracking-tight">Modo Manutenção</h4>
                        <p class="text-sm text-gray-400">Ao ativar, um aviso de manutenção será exibido para todos os
                            usuários não-admin.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer"
                            @checked($maintenance == '1')>
                        <div
                            class="w-14 h-7 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-red-500">
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit"
                    class="w-full md:w-auto px-10 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 active:scale-95 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
@endsection