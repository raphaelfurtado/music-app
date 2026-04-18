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
        $artists = \App\Models\Artist::orderBy('name')->get();
        return view('songs.create', compact('title', 'artists'));
    }

    // Salvar no banco
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'nullable|exists:artists,id',
            'artist' => 'nullable|string|max:255', // Fallback for manual entry
            'key' => 'nullable|string|max:10',
            'bpm' => 'nullable|integer',
            'lyrics' => 'nullable|string',
        ]);

        $song = Song::create([
            'user_id' => auth()->id(),
            'artist_id' => $validated['artist_id'] ?? null,
            'title' => $validated['title'],
            'artist' => $validated['artist'] ?? null,
            'key' => $validated['key'],
            'bpm' => $validated['bpm'],
            'lyrics' => $validated['lyrics'],
        ]);

        // Lógica para voltar com o ID da música nova
        $returnUrl = $request->get('return_url', route('dashboard'));
        $separator = str_contains($returnUrl, '?') ? '&' : '?';

        return redirect($returnUrl . $separator . 'new_song_id=' . $song->id)
            ->with('success', 'Música criada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        $song->load('artistModel');
        return view('songs.show', compact('song'));
    }
}