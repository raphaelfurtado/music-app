<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Repertoire;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    // Exibe a tela de criação (que contém o componente Livewire)
    public function create(Repertoire $repertoire)
    {
        // Garante segurança
        if ($repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        // Retorna a view 'wrapper' que chama o @livewire('create-block')
        return view('blocks.create', compact('repertoire'));
    }

    public function edit(Block $block)
    {
        // Verifica se o bloco pertence a um repertório do usuário logado
        if ($block->repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        return view('blocks.edit', compact('block'));
    }

    // Excluir um bloco inteiro
    public function destroy(Block $block)
    {
        // Verifica se o dono do repertório do bloco é o usuário logado
        if ($block->repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        $repertoireId = $block->repertoire_id;
        $block->delete();

        return redirect()->route('repertoires.show', $repertoireId)
            ->with('success', 'Bloco removido.');
    }
}