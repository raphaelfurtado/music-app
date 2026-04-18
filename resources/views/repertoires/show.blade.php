@extends('layouts.master')

@section('title', $repertoire->name)

@section('content')
    @php
        $estimatedSeconds = $repertoire->blocks->sum(fn($block) => $block->songs->count()) * 4 * 60;
        $currentElapsedSeconds = $repertoire->show_started_at
            ? $repertoire->show_started_at->diffInSeconds(now())
            : 0;

        $formatDuration = function (int $seconds): string {
            $hours = intdiv($seconds, 3600);
            $minutes = intdiv($seconds % 3600, 60);
            $secs = $seconds % 60;

            return sprintf('%02dh %02dm %02ds', $hours, $minutes, $secs);
        };
    @endphp

    <div class="-mx-4 sm:-mx-6 lg:-mx-8">
        @if($repertoire->is_public)
            <div class="sticky top-20 z-40 w-full bg-surface-container-lowest/95 backdrop-blur-md border-b border-tertiary/20">
                <div class="max-w-screen-2xl mx-auto px-4 md:px-8 py-2 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-tertiary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-tertiary"></span>
                        </div>
                        <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-tertiary">Live</span>
                        <span class="hidden md:inline text-sm text-on-surface-variant truncate">Link público ativo e visível para a banda</span>
                    </div>

                    <button onclick="copyPublicLink(event, '{{ route('repertoires.public', $repertoire->slug) }}')"
                        class="shrink-0 flex items-center gap-2 px-3 py-1.5 rounded-md bg-surface-container-highest border border-outline-variant/20 hover:border-primary/40 transition-colors">
                        <span class="material-symbols-outlined text-sm text-primary">link</span>
                        <span class="text-xs font-semibold text-primary">Copy Link</span>
                    </button>
                </div>
            </div>
        @endif

        <section class="max-w-screen-2xl mx-auto px-4 md:px-8 pt-6 md:pt-10 space-y-8" x-data="{ allExpanded: false }">
            <div class="relative overflow-hidden rounded-xl bg-surface-container-low nm-shadow">
                <div class="absolute inset-0 opacity-40">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_15%_20%,rgba(242,202,80,0.18)_0%,transparent_45%)]"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_15%,rgba(212,175,55,0.12)_0%,transparent_40%)]"></div>
                </div>

                <div class="relative z-10 p-5 md:p-8 lg:p-10 flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-md text-[10px] uppercase tracking-[0.2em] font-bold bg-primary/10 text-primary border border-primary/20">
                                {{ Str::limit($repertoire->description, 18) ?: 'Repertório' }}
                            </span>
                            <span class="text-xs text-on-surface-variant">{{ $repertoire->created_at->format('d M Y') }}</span>
                        </div>

                        <h1 class="font-headline text-4xl md:text-5xl lg:text-6xl leading-tight tracking-tight text-on-surface">
                            {{ $repertoire->name }}
                        </h1>
                    </div>

                    <div class="w-full lg:w-auto grid grid-cols-2 lg:flex gap-4 lg:gap-8 border-t lg:border-t-0 lg:border-l border-outline-variant/30 pt-5 lg:pt-0 lg:pl-8">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant mb-1">Blocos</p>
                            <p class="font-headline text-3xl text-primary">{{ $repertoire->blocks->count() }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant mb-1">Músicas</p>
                            <p class="font-headline text-3xl text-primary">{{ $repertoire->blocks->sum(fn($block) => $block->songs->count()) }}</p>
                        </div>
                        <div class="col-span-2 lg:col-span-1 flex lg:items-end">
                            @if($repertoire->show_started_at)
                                <form method="POST" action="{{ route('repertoires.stop-show', $repertoire->id) }}" class="hidden md:block">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-3 rounded-md bg-tertiary text-surface font-bold text-xs uppercase tracking-[0.14em] hover:brightness-110 transition-all">
                                        <span class="material-symbols-outlined text-lg">stop_circle</span>
                                        Encerrar show
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('repertoires.start-show', $repertoire->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-3 rounded-md nm-gradient-gold text-on-primary-container font-bold text-xs uppercase tracking-[0.14em] hover:brightness-110 transition-all">
                                        <span class="material-symbols-outlined text-lg">play_circle</span>
                                        Iniciar show
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($repertoire->show_started_at)
                <div class="sticky {{ $repertoire->is_public ? 'top-[6.75rem] md:top-32' : 'top-[4.5rem] md:top-20' }} z-30 -mx-4 px-4 md:mx-0 md:px-0 py-1 bg-surface/90 backdrop-blur-sm">
                    <div class="md:hidden rounded-lg border border-tertiary/25 bg-surface-container-lowest/95 px-3 py-2 flex items-center justify-between gap-3">
                        <div class="min-w-0 flex items-center gap-2">
                            <span class="material-symbols-outlined text-base text-tertiary">timer</span>
                            <p class="font-headline text-lg text-on-surface" data-show-timer="{{ $repertoire->show_started_at->timestamp }}">
                                {{ $formatDuration($currentElapsedSeconds) }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('repertoires.stop-show', $repertoire->id) }}" class="shrink-0">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-tertiary text-surface font-bold text-[10px] uppercase tracking-[0.12em] hover:brightness-110 transition-all">
                                <span class="material-symbols-outlined text-sm">stop_circle</span>
                                Fim
                            </button>
                        </form>
                    </div>

                    <div class="hidden md:flex rounded-xl border border-tertiary/25 bg-surface-container-lowest/95 backdrop-blur-md px-5 py-3.5 items-center justify-between gap-3 nm-shadow">
                        <div class="min-w-0">
                            <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-tertiary">Show em andamento</p>
                            <p class="font-headline text-2xl text-on-surface mt-0.5" data-show-timer="{{ $repertoire->show_started_at->timestamp }}">
                                {{ $formatDuration($currentElapsedSeconds) }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('repertoires.stop-show', $repertoire->id) }}" class="shrink-0">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md bg-tertiary text-surface font-bold text-xs uppercase tracking-[0.14em] hover:brightness-110 transition-all">
                                <span class="material-symbols-outlined text-base">stop_circle</span>
                                Encerrar
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="flex flex-wrap items-center justify-between gap-2">
                <h2 class="text-2xl font-headline text-on-surface">Estrutura do Show</h2>
                <div class="flex items-center gap-2">
                    <button @click="allExpanded = !allExpanded; $dispatch('toggle-all', { state: allExpanded })"
                        class="text-xs uppercase tracking-[0.15em] font-semibold text-on-surface-variant hover:text-primary transition-colors">
                        <span x-text="allExpanded ? 'Recolher blocos' : 'Expandir blocos'"></span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 pb-24">
                <section class="space-y-4 lg:col-span-8">
                @forelse($repertoire->blocks as $block)
                    <article x-data="{ open: false }" @toggle-all.window="open = $event.detail.state"
                        class="rounded-xl overflow-hidden bg-surface-container-low border border-outline-variant/20 nm-shadow">

                        <div class="p-4 md:p-5 flex items-center justify-between gap-4 cursor-pointer hover:bg-surface-container-high/60 transition-colors"
                            @click="open = !open">
                            <div class="flex items-center gap-4 min-w-0">
                                <span class="material-symbols-outlined text-primary transition-transform" :class="open ? 'rotate-90' : ''">chevron_right</span>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-lg text-on-surface truncate">{{ $block->name }}</h3>
                                    <p class="text-xs text-on-surface-variant">
                                        {{ $block->songs->count() }} músicas • Estimativa: {{ max(5, $block->songs->count() * 4) }} min
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-1 shrink-0">
                                <a href="{{ route('blocks.edit', $block->id) }}" @click.stop
                                    class="p-2 rounded-md text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors"
                                    title="Editar bloco">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                            </div>
                        </div>

                        <div x-show="open" x-collapse style="display: none;" class="bg-surface-container px-4 md:px-6 py-4 space-y-4">
                            @forelse($block->songs as $song)
                                <div class="grid grid-cols-1 lg:grid-cols-[32px_minmax(0,1fr)_140px] gap-3 lg:gap-5 py-1">
                                    <span class="text-xs font-semibold text-on-surface-variant/60 pt-1">
                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <div class="min-w-0">
                                        <p class="text-base font-semibold text-on-surface truncate">{{ $song->title }}</p>
                                        @if($song->artist)
                                            <p class="text-sm text-on-surface-variant truncate">{{ $song->artist }}</p>
                                        @endif
                                        @if($song->lyrics)
                                            <p class="text-xs italic text-on-surface-variant mt-1 line-clamp-1">
                                                "{{ Str::limit($song->lyrics, 80) }}"
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex lg:justify-end items-start">
                                        @if($song->key)
                                            <div class="min-w-[68px] h-12 rounded-md bg-surface-container-highest text-center grid place-content-center px-2">
                                                <span class="text-[10px] uppercase tracking-widest text-on-surface-variant">Tom</span>
                                                <span class="text-sm font-bold text-primary">{{ $song->key }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-on-surface-variant italic">Nenhuma música neste bloco.</div>
                            @endforelse
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl bg-surface-container-low p-8 text-center text-on-surface-variant">
                        <p class="text-lg font-headline text-on-surface mb-1">Nenhum bloco criado ainda</p>
                        <p class="text-sm">Toque no botão + para montar seu primeiro bloco.</p>
                    </div>
                @endforelse
                </section>

                <aside class="hidden lg:block lg:col-span-4">
                    <div class="sticky top-28 space-y-4">
                        <div class="rounded-xl bg-surface-container-low p-5 nm-shadow">
                            <span class="material-symbols-outlined text-primary mb-3 block">schedule</span>
                            <h3 class="font-headline text-xl text-on-surface mb-2">Linha do Tempo</h3>
                            <p class="text-sm text-on-surface-variant mb-3">Duração total estimada do repertório.</p>
                            <p class="font-headline text-3xl text-on-surface">{{ sprintf('%02dh %02dm', floor($estimatedSeconds / 3600), floor(($estimatedSeconds % 3600) / 60)) }}</p>

                            @if($repertoire->show_started_at)
                                <div class="mt-4 rounded-lg bg-tertiary/10 border border-tertiary/20 p-3">
                                    <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-tertiary">Show em andamento</p>
                                    <p class="font-headline text-2xl text-on-surface mt-1" data-show-timer="{{ $repertoire->show_started_at->timestamp }}">
                                        {{ $formatDuration($currentElapsedSeconds) }}
                                    </p>
                                </div>
                            @elseif($repertoire->last_show_duration_seconds)
                                <div class="mt-4 rounded-lg bg-surface-container-high p-3 border border-outline-variant/20">
                                    <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-surface-variant">Ultimo show</p>
                                    <p class="font-headline text-xl text-on-surface mt-1">{{ $formatDuration((int) $repertoire->last_show_duration_seconds) }}</p>
                                </div>
                            @endif

                            @if((int) $repertoire->total_shows > 0)
                                <p class="mt-3 text-xs text-on-surface-variant">
                                    {{ (int) $repertoire->total_shows }} shows salvos • Total {{ $formatDuration((int) $repertoire->total_show_duration_seconds) }}
                                </p>
                            @endif
                        </div>

                        <div class="rounded-xl bg-surface-container-low p-5 nm-shadow">
                            <span class="material-symbols-outlined text-primary mb-3 block">description</span>
                            <h3 class="font-headline text-xl text-on-surface mb-2">Documentação</h3>
                            <p class="text-sm text-on-surface-variant">Exporte e compartilhe a versão em PDF com a banda.</p>
                            <a href="{{ route('repertoires.export', $repertoire->id) }}" target="_blank"
                                class="inline-flex items-center gap-2 mt-4 text-xs font-semibold text-primary hover:text-primary/80 transition-colors nm-focus-ring rounded-sm">
                                <span class="material-symbols-outlined text-base">print</span>
                                Exportar PDF
                            </a>
                        </div>

                        <div class="rounded-xl bg-surface-container-low p-5 nm-shadow">
                            <span class="material-symbols-outlined text-primary mb-3 block">group</span>
                            <h3 class="font-headline text-xl text-on-surface mb-2">Equipe Técnica</h3>
                            <p class="text-sm text-on-surface-variant">Gerencie permissões de edição para músicos e produção.</p>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-6 lg:hidden">
                <div class="rounded-xl bg-surface-container-low p-5">
                    <span class="material-symbols-outlined text-primary mb-3 block">group</span>
                    <h3 class="font-headline text-xl text-on-surface mb-2">Equipe Técnica</h3>
                    <p class="text-sm text-on-surface-variant">Gerencie permissões de edição para músicos e produção.</p>
                </div>

                <div class="rounded-xl bg-surface-container-low p-5">
                    <span class="material-symbols-outlined text-primary mb-3 block">schedule</span>
                    <h3 class="font-headline text-xl text-on-surface mb-2">Linha do Tempo</h3>
                    <p class="text-sm text-on-surface-variant mb-3">Duração total estimada do repertório.</p>
                    <p class="font-headline text-3xl text-on-surface">{{ sprintf('%02dh %02dm', floor($estimatedSeconds / 3600), floor(($estimatedSeconds % 3600) / 60)) }}</p>

                    @if($repertoire->show_started_at)
                        <div class="mt-4 rounded-lg bg-tertiary/10 border border-tertiary/20 p-3">
                            <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-tertiary">Show em andamento</p>
                            <p class="font-headline text-2xl text-on-surface mt-1" data-show-timer="{{ $repertoire->show_started_at->timestamp }}">
                                {{ $formatDuration($currentElapsedSeconds) }}
                            </p>
                        </div>
                    @elseif($repertoire->last_show_duration_seconds)
                        <div class="mt-4 rounded-lg bg-surface-container-high p-3 border border-outline-variant/20">
                            <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-surface-variant">Ultimo show</p>
                            <p class="font-headline text-xl text-on-surface mt-1">{{ $formatDuration((int) $repertoire->last_show_duration_seconds) }}</p>
                        </div>
                    @endif

                    @if((int) $repertoire->total_shows > 0)
                        <p class="mt-3 text-xs text-on-surface-variant">
                            {{ (int) $repertoire->total_shows }} shows salvos • Total {{ $formatDuration((int) $repertoire->total_show_duration_seconds) }}
                        </p>
                    @endif
                </div>

                <div class="rounded-xl bg-surface-container-low p-5">
                    <span class="material-symbols-outlined text-primary mb-3 block">description</span>
                    <h3 class="font-headline text-xl text-on-surface mb-2">Documentação</h3>
                    <p class="text-sm text-on-surface-variant">Exporte e compartilhe a versão em PDF com a banda.</p>
                    <a href="{{ route('repertoires.export', $repertoire->id) }}" target="_blank"
                        class="inline-flex items-center gap-2 mt-4 text-xs font-semibold text-primary hover:text-primary/80 transition-colors">
                        <span class="material-symbols-outlined text-base">print</span>
                        Exportar PDF
                    </a>
                </div>
            </div>
        </section>

        <div class="fixed right-6 bottom-7 md:right-10 md:bottom-10 z-50 flex flex-col items-end gap-2">
            <div class="hidden md:flex items-center gap-1">
                <form action="{{ route('repertoires.toggle-public', $repertoire->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-3 py-2 rounded-md text-xs font-semibold {{ $repertoire->is_public ? 'bg-tertiary text-surface' : 'bg-surface-container-high text-on-surface-variant hover:text-primary' }} transition-colors"
                        title="{{ $repertoire->is_public ? 'Tornar privado' : 'Tornar público' }}">
                        {{ $repertoire->is_public ? 'Público' : 'Privado' }}
                    </button>
                </form>

                <form action="{{ route('repertoires.duplicate', $repertoire->id) }}" method="POST"
                    onsubmit="return confirm('Deseja duplicar este repertório?');">
                    @csrf
                    <button type="submit"
                        class="p-2 rounded-md bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors"
                        title="Duplicar">
                        <span class="material-symbols-outlined text-base">content_copy</span>
                    </button>
                </form>

                <a href="{{ route('repertoires.edit', $repertoire->id) }}"
                    class="p-2 rounded-md bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors"
                    title="Editar">
                    <span class="material-symbols-outlined text-base">edit_square</span>
                </a>

                <form action="{{ route('repertoires.destroy', $repertoire->id) }}" method="POST"
                    onsubmit="return confirm('Tem certeza que deseja excluir este repertório? Esta ação não pode ser desfeita.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 rounded-md bg-surface-container-high text-red-400 hover:text-red-300 transition-colors"
                        title="Excluir">
                        <span class="material-symbols-outlined text-base">delete</span>
                    </button>
                </form>
            </div>

            <a href="{{ route('blocks.create', $repertoire->id) }}"
                class="w-14 h-14 rounded-xl nm-gradient-gold text-on-primary-container nm-shadow grid place-content-center hover:brightness-110 active:scale-95 transition-all"
                title="Adicionar bloco">
                <span class="material-symbols-outlined text-4xl">add</span>
            </a>
        </div>
    </div>

    <script>
        function formatDuration(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            const pad = (n) => String(n).padStart(2, '0');
            return `${pad(hours)}h ${pad(minutes)}m ${pad(seconds)}s`;
        }

        function initShowTimers() {
            const nodes = document.querySelectorAll('[data-show-timer]');
            if (!nodes.length) {
                return;
            }

            const tick = () => {
                const now = Math.floor(Date.now() / 1000);
                nodes.forEach((node) => {
                    const startedAt = Number(node.dataset.showTimer);
                    if (!startedAt) {
                        return;
                    }
                    const elapsed = Math.max(0, now - startedAt);
                    node.textContent = formatDuration(elapsed);
                });
            };

            tick();
            setInterval(tick, 1000);
        }

        initShowTimers();

        function copyPublicLink(evt, url) {
            const btn = evt.currentTarget;
            navigator.clipboard.writeText(url).then(() => {
                const original = btn.innerHTML;
                btn.innerHTML = '<span class="material-symbols-outlined text-sm text-surface">check_circle</span><span class="text-xs font-semibold text-surface">Copiado</span>';
                btn.classList.add('bg-tertiary');
                btn.classList.remove('bg-surface-container-highest');

                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.classList.remove('bg-tertiary');
                    btn.classList.add('bg-surface-container-highest');
                }, 1600);
            });
        }
    </script>

@endsection