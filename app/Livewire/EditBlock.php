<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Models\Song;

class EditBlock extends Component
{
    public Block $block;

    // Campos do Formulário
    public $name = '';
    public $description = '';
    public $predominant_key = '';

    // Controle da Lista
    public $search = '';
    public $addedSongs = [];

    protected $listeners = ['song-created' => 'addSong'];

    // Tons para os botões
    public $keys = [
        ['key' => 'G', 'label' => 'Sol'],
        ['key' => 'C', 'label' => 'Dó'],
        ['key' => 'D', 'label' => 'Ré'],
        ['key' => 'E', 'label' => 'Mi'],
        ['key' => 'F', 'label' => 'Fá'],
        ['key' => 'A', 'label' => 'Lá'],
    ];

    public function mount(Block $block)
    {
        $this->block = $block;
        $this->name = $block->name;
        $this->description = $block->description ?? '';
        $this->predominant_key = $block->predominant_key;

        // LÓGICA CRÍTICA DE CARREGAMENTO
        if (session()->has('temp_block_songs')) {
            // 1. Prioridade: Se voltou da tela de "Criar Música", pega da memória
            $this->addedSongs = session()->pull('temp_block_songs');
        } else {
            // 2. Padrão: Carrega do Banco de Dados
            // Se isso vier vazio, é porque a tabela 'block_song' está vazia para este bloco.
            $this->addedSongs = $block->songs()
                ->orderBy('block_song.order', 'asc')
                ->get()
                ->map(function ($song) {
                    return $song->toArray();
                })->toArray();
        }

        // 3. Adiciona música nova se veio da URL
        if (request()->has('new_song_id')) {
            $this->addSong(request('new_song_id'));
        }
    }

    public function goToCreateSong($searchTitle)
    {
        session()->put('temp_block_songs', $this->addedSongs);

        // CORREÇÃO CRÍTICA
        $currentUrl = request()->header('Referer');

        return redirect()->route('songs.create', [
            'title' => $searchTitle,
            'return_url' => $currentUrl
        ]);
    }

    public function addSong($songId)
    {
        $song = Song::find($songId);
        if (!$song)
            return;

        // Evita duplicatas visuais
        foreach ($this->addedSongs as $s) {
            if ($s['id'] == $songId) {
                $this->search = '';
                return;
            }
        }

        $this->addedSongs[] = $song->toArray();
        $this->search = '';
    }

    public function removeSong($index)
    {
        unset($this->addedSongs[$index]);
        $this->addedSongs = array_values($this->addedSongs);
    }

    public function updateBlockOrder($list)
    {
        $ordered = [];
        foreach ($list as $item) {
            $found = collect($this->addedSongs)->firstWhere('id', $item['value']);
            if ($found)
                $ordered[] = $found;
        }
        $this->addedSongs = $ordered;
    }

    public function selectKey($key)
    {
        $this->predominant_key = ($this->predominant_key === $key) ? null : $key;
    }

    // Propriedade computada para a busca (Livewire)
    public function getSearchResultsProperty()
    {
        if (strlen($this->search) < 2)
            return [];

        return Song::where('user_id', auth()->id())
            ->where('title', 'like', '%' . $this->search . '%')
            ->take(5)
            ->get();
    }

    public function save()
    {
        $this->validate(['name' => 'required|min:3']);

        // 1. Atualiza dados do bloco
        $this->block->update([
            'name' => $this->name,
            'description' => $this->description,
            'predominant_key' => $this->predominant_key,
        ]);

        // 2. Prepara o array para sincronizar
        $syncData = [];
        foreach ($this->addedSongs as $index => $song) {
            if (isset($song['id'])) {
                $syncData[$song['id']] = ['order' => $index + 1];
            }
        }

        // 3. GRAVA NO BANCO (Aqui preenche a tabela block_song)
        $this->block->songs()->sync($syncData);

        return redirect()->route('repertoires.show', $this->block->repertoire_id);
    }

    public function render()
    {
        return view('livewire.edit-block');
    }
}