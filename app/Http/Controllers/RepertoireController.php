<?php

namespace App\Http\Controllers;

use App\Models\Repertoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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
            'is_public' => 'boolean',
        ]);

        // Cria associado ao usuário automaticamente
        $repertoire = auth()->user()->repertoires()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_public' => $request->has('is_public'),
            'icon' => 'library_music', // Ícone padrão
        ]);

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
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        // 3. Atualiza no Banco de Dados
        $repertoire->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_public' => $request->has('is_public'),
        ]);

        // Se tornou público agora e não tem slug, gera um
        if ($repertoire->is_public && !$repertoire->slug) {
            $repertoire->slug = Str::slug($repertoire->name) . '-' . Str::random(6);
            $repertoire->save();
        }

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

    // Duplicar Repertório
    public function duplicate(Repertoire $repertoire)
    {
        if ($repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        // 1. Clona o Repertório
        $newRepertoire = $repertoire->replicate(['created_at', 'updated_at']);
        $newRepertoire->name = $repertoire->name . ' (Cópia)';
        $newRepertoire->save();

        // 2. Clona os Blocos e suas associações com Músicas
        $repertoire->load('blocks.songs');

        foreach ($repertoire->blocks as $block) {
            // Clona o Bloco
            $newBlock = $block->replicate(['repertoire_id', 'created_at', 'updated_at']);
            $newBlock->repertoire_id = $newRepertoire->id;
            $newBlock->save();

            // Sincroniza as músicas (mantendo a pivot data se houver, ex: ordem)
            // Aqui pegamos os IDs e os atributos da pivot para clonar tudo
            $songsWithPivot = [];
            foreach ($block->songs as $song) {
                // $song->pivot fornece acesso aos dados da tabela intermediária
                // Precisamos passar um array [song_id => pivot_data]
                // Se sua pivot tiver colunas extras (ex: 'order'), elas devem estar aqui
                $songsWithPivot[$song->id] = collect($song->pivot->toArray())
                    ->except(['block_id', 'song_id']) // remove chaves estrangeiras duplicadas
                    ->toArray();
            }

            $newBlock->songs()->attach($songsWithPivot);
        }

        return redirect()->route('repertoires.show', $newRepertoire)
            ->with('success', 'Repertório duplicado com sucesso!');
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

    /**
     * Visualização Pública (Read-only)
     */
    public function publicShow($slug)
    {
        $repertoire = Repertoire::where('slug', $slug)
            ->where('is_public', true)
            ->with([
                'blocks' => function ($query) {
                    $query->orderBy('order')->with([
                        'songs' => function ($q) {
                            $q->orderBy('pivot_order');
                        }
                    ]);
                }
            ])
            ->firstOrFail();

        return view('repertoires.public', compact('repertoire'));
    }

    /**
     * Alternar status público/privado
     */
    public function togglePublic(Repertoire $repertoire)
    {
        if ($repertoire->user_id !== auth()->id()) {
            abort(403);
        }

        $repertoire->is_public = !$repertoire->is_public;

        if ($repertoire->is_public && !$repertoire->slug) {
            $repertoire->slug = Str::slug($repertoire->name) . '-' . Str::random(6);
        }

        $repertoire->save();

        $message = $repertoire->is_public ? 'Link público gerado!' : 'Repertório agora é privado.';
        return back()->with('success', $message);
    }
}