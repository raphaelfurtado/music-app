<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $repertoire->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            color: #111;
        }

        .meta {
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }

        .block {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .block-title {
            font-size: 18px;
            font-weight: bold;
            background-color: #f3f4f6;
            padding: 8px 12px;
            margin-bottom: 10px;
            border-left: 4px solid #3b82f6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            text-align: left;
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #fafafa;
            font-weight: 600;
            color: #555;
        }

        .key {
            font-weight: bold;
            color: #dc2626;
            /* Red for visibility */
        }

        .bpm {
            color: #666;
            font-size: 12px;
        }

        .artist {
            color: #666;
            font-style: italic;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #aaa;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $repertoire->name }}</h1>
        @if($repertoire->description)
            <div class="meta">{{ $repertoire->description }}</div>
        @endif
        <div class="meta">Gerado em {{ date('d/m/Y H:i') }}</div>
    </div>

    @foreach($repertoire->blocks as $block)
        <div class="block">
            <div class="block-title">{{ $block->name }}</div>

            @if($block->songs->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50%">Música</th>
                            <th style="width: 30%">Artista</th>
                            <th style="width: 10%">Tom</th>
                            <th style="width: 10%">BPM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($block->songs as $song)
                            <tr>
                                <td>
                                    <strong>{{ $song->title }}</strong>
                                    @if($song->lyrics)
                                        <div style="font-size: 11px; color: #555; margin-top: 4px; font-style: italic;">
                                            {{ Str::limit($song->lyrics, 200) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="artist">{{ $song->artist ?? '-' }}</td>
                                <td class="key">{{ $song->key ?? '-' }}</td>
                                <td class="bpm">{{ $song->bpm ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="padding: 0 12px; color: #999; font-style: italic;">Nenhuma música neste bloco.</p>
            @endif
        </div>
    @endforeach

    <div class="footer">
        Gerado via Music App
    </div>
</body>

</html>