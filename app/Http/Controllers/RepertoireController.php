<?php

namespace App\Http\Controllers;

use App\Models\Repertoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RepertoireController extends Controller
{
    // Tela Inicial (Dashboard)
    public function index()
    {
        // Pega os repertórios do usuário logado, ordenados pelo mais recente
        $repertoires = auth()->user()->repertoires()
            ->withCount('blocks') // Conta inteligente para mostrar no card
            ->latest()
            ->get();

        return view('dashboard', compact('repertoires'));
    }

    // Formulário de Criação
    public function create()
    {
        return view('repertoires.create');
    }

    // Salvar no Banco
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|string|max:50',
        ]);

        // Cria associado ao usuário automaticamente
        $repertoire = auth()->user()->repertoires()->create($validated);

        return redirect()->route('repertoires.show', $repertoire)
            ->with('success', 'Repertório criado com sucesso!');
    }

    // Detalhes do Repertório (Lista de Blocos)
    public function show(Repertoire $repertoire)
    {
        // Segurança: Garante que o repertório pertence ao usuário
        if ($repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        // Carrega os blocos e conta as músicas de cada bloco para evitar N+1 queries
        $repertoire->load(['blocks' => function($query) {
            $query->orderBy('order')->withCount('songs');
        }]);

        return view('repertoires.show', compact('repertoire'));
    }

    // Editar
    public function edit(Repertoire $repertoire)
    {
        if ($repertoire->user_id !== auth()->id()) {
            abort(403);
        }
        return view('repertoires.edit', compact('repertoire'));
    }

    // Atualizar
    public function update(Request $request, Repertoire $repertoire)
    {
        if ($repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|string',
        ]);

        $repertoire->update($validated);

        return redirect()->route('repertoires.show', $repertoire);
    }

    // Deletar
    public function destroy(Repertoire $repertoire)
    {
        if ($repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        $repertoire->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Repertório excluído.');
    }
}