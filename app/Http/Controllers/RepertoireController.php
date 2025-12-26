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
        $repertoire->load([
            'blocks' => function ($query) {
                $query->orderBy('order')->withCount('songs');
            }
        ]);

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
        // 1. Verifique se o usuário é dono do repertório (Segurança)
        if ($repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        // 2. Validação dos dados
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            // Adicione estes apenas se tiver os campos no banco:
            'event_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        // 3. Atualiza no Banco de Dados
        $repertoire->update($validated);

        // 4. O IMPORTANTE: Redirecionar de volta para a tela de visualização
        return redirect()->route('repertoires.show', $repertoire->id)
            ->with('message', 'Repertório atualizado com sucesso!');
    }

    // Exportar PDF
    public function exportPdf(Repertoire $repertoire)
    {
        if ($repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        // Carrega os dados necessários: Blocos e Músicas
        $repertoire->load([
            'blocks' => function ($query) {
                $query->orderBy('order')->with([
                    'songs' => function ($q) {
                        $q->orderBy('pivot_order'); // Assumindo que existe uma ordem na pivot, senão usa padrão
                    }
                ]);
            }
        ]);

        // Gera o PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('repertoires.pdf', compact('repertoire'));

        // Define o tamanho do papel (opcional)
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('repertorio-' . \Illuminate\Support\Str::slug($repertoire->name) . '.pdf');
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