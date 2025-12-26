<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $repertoire->name }} | Music App</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 font-sans antialiased pb-20">

    <div class="max-w-2xl mx-auto px-4 pt-8">
        <!-- Header -->
        <header class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4 shadow-sm"
                style="background-color: {{ $repertoire->color ?? '#3b82f6' }}20; color: {{ $repertoire->color ?? '#3b82f6' }}">
                <span class="material-symbols-outlined text-4xl">{{ $repertoire->icon ?? 'library_music' }}</span>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 mb-2">{{ $repertoire->name }}</h1>
            @if($repertoire->description)
                <p class="text-slate-500 max-w-md mx-auto">{{ $repertoire->description }}</p>
            @endif
        </header>

        <!-- Content -->
        <div class="space-y-6">
            @foreach($repertoire->blocks as $block)
                <section class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="font-bold text-slate-800">{{ $block->name }}</h2>
                        @if($block->predominant_key)
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-lg uppercase">
                                {{ $block->predominant_key }}
                            </span>
                        @endif
                    </div>

                    <div class="divide-y divide-slate-50">
                        @foreach($block->songs as $song)
                            <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div class="min-w-0 flex-1 pr-4">
                                    <h3 class="font-bold text-slate-900 truncate">{{ $song->title }}</h3>
                                    <p class="text-xs text-slate-500 truncate">{{ $song->artist ?? 'Artista desconhecido' }}</p>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    @if($song->bpm)
                                        <span
                                            class="text-[10px] font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">{{ $song->bpm }}
                                            BPM</span>
                                    @endif
                                    @if($song->key)
                                        <span
                                            class="font-mono font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded-md text-sm border border-slate-200">
                                            {{ $song->key }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($block->songs->isEmpty())
                            <p class="px-6 py-4 text-sm italic text-slate-400">Nenhuma música adicionada.</p>
                        @endif
                    </div>
                </section>
            @endforeach
        </div>

        <!-- Call to Action -->
        <footer class="mt-16 text-center">
            <div class="inline-block p-8 bg-white rounded-3xl shadow-xl shadow-blue-500/10 border border-blue-50">
                <p class="text-slate-600 mb-4 font-medium">Gostou desse repertório?</p>
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-2xl transition-all shadow-lg shadow-blue-600/20 active:scale-95">
                    <span class="material-symbols-outlined">rocket_launch</span>
                    Crie o seu no Music App
                </a>
            </div>
            <p class="mt-8 text-slate-400 text-xs font-bold uppercase tracking-widest">&copy; {{ date('Y') }} Music App
            </p>
        </footer>
    </div>

</body>

</html>