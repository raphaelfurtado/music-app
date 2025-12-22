<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{

    // App\Http\Controllers\SongController.php

    public function index()
    {
        // Pega todas as músicas do usuário logado
        $songs = Song::where('user_id', auth()->id())->orderBy('title')->get();

        // Você precisará criar essa view: resources/views/songs/index.blade.php
        return view('songs.index', compact('songs'));
    }

    // Mostrar formulário de criar
    public function create(Request $request)
    {
        $title = $request->get('title', '');
        return view('songs.create', compact('title'));
    }

    // Salvar no banco
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'key' => 'nullable|string|max:10',
            'bpm' => 'nullable|integer', // Novo campo BPM
            'lyrics' => 'nullable|string',
        ]);

        $song = Song::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'key' => $validated['key'],
            'bpm' => $validated['bpm'], // Salvando BPM
            'lyrics' => $validated['lyrics'],
        ]);

        // Lógica para voltar com o ID da música nova
        $returnUrl = $request->get('return_url', route('dashboard'));

        // Verifica se a URL já tem parametros (?) para concatenar corretamente
        $separator = str_contains($returnUrl, '?') ? '&' : '?';

        return redirect($returnUrl . $separator . 'new_song_id=' . $song->id)
            ->with('success', 'Música criada!');
    }
}