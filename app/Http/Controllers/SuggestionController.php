<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function index(Request $request)
    {
        $key = $request->get('key', 'G'); // Padrão Sol Maior (G)
        
        // Busca músicas do próprio usuário naquele tom
        $userSongs = Song::where('user_id', auth()->id())
            ->where('key', $key)
            ->get();

        // Numa versão Premium real, aqui buscaríamos de uma tabela 'GlobalSongs'
        // ou chamaria uma API de IA.
        
        return view('suggestions.index', [
            'selectedKey' => $key,
            'suggestions' => $userSongs,
            'count' => $userSongs->count()
        ]);
    }
}