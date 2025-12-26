<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Models\Song;

class EditBlock extends Component
{
    public Block $block;

    // Campos do Bloco
    public $name = '';
    public $description = '';
    public $predominant_key = '';

    // Controle da Lista e Busca
    public $search = '';
    public $addedSongs = [];

    protected $listeners = [
        'song-created' => 'addSong',
        'song-updated' => 'refreshSongList'
    ];

    // Tons para os botões - MANTIDO para o bloco, não para música
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

        // Se veio de uma criação externa (redirect), adiciona a música
        if (request()->has('new_song_id')) {
            $this->addSong(request('new_song_id'));
        }

        $this->loadSongs();
    }

    // Carrega as músicas do banco ordenadas
    public function loadSongs()
    {
        $this->addedSongs = $this->block->songs()
            ->orderByPivot('order', 'asc')
            ->get()
            ->toArray();
    }

    // Chamado quando uma música é editada externamente
    public function refreshSongList($songId)
    {
        $this->loadSongs();
    }

    // Adiciona uma música existente (da busca ou recém-criada) ao bloco
    public function addSong($songId)
    {
        $song = Song::find($songId);
        if (!$song)
            return;

        // Verifica se já existe para não duplicar
        $exists = $this->block->songs()->where('song_id', $songId)->exists();

        if (!$exists) {
            // Salva IMEDIATAMENTE no banco
            $this->block->songs()->attach($songId, [
                'order' => $this->block->songs()->count() + 1
            ]);
        }

        $this->search = '';
        $this->loadSongs(); // Recarrega a lista
    }

    // Remove a música do bloco (Banco de dados)
    public function removeSong($index)
    {
        if (isset($this->addedSongs[$index])) {
            $songId = $this->addedSongs[$index]['id'];

            // Remove IMEDIATAMENTE do banco
            $this->block->songs()->detach($songId);

            $this->loadSongs(); // Recarrega a lista
        }
    }

    // Abre o modal de EDIÇÃO (Dispara para o componente filho)
    public function editSong($songId)
    {
        $this->dispatch('editSong', songId: $songId);
    }

    // Abre o modal de CRIAÇÃO (Dispara para o componente filho)
    public function openSongModal()
    {
        // Envia o search atual como sugestão de nome
        // E passa o repertoire_id para já vincular corretamente se necessário
        $this->dispatch(
            'openSongModal',
            searchName: $this->search,
            repertoireId: $this->block->repertoire_id
        );
    }

    // Reordenação (Drag and Drop)
    public function updateBlockOrder($items)
    {
        foreach ($items as $item) {
            $this->block->songs()->updateExistingPivot($item['value'], [
                'order' => $item['order']
            ]);
        }
        $this->loadSongs();
    }

    public function selectKey($key)
    {
        $this->predominant_key = ($this->predominant_key === $key) ? null : $key;
    }

    // Propriedade computada para a busca
    public function getSearchResultsProperty()
    {
        if (strlen($this->search) < 2)
            return [];

        return Song::where('title', 'like', '%' . $this->search . '%')
            // Se quiser filtrar apenas músicas do usuário ou globais:
            // ->where(fn($q) => $q->where('user_id', auth()->id())->orWhereNull('user_id'))
            ->take(5)
            ->get();
    }

    // Redirecionamento para criar música em outra tela (se ainda usar)
    public function goToCreateSong($searchTitle)
    {
        // Nota: Como agora salvamos direto no banco, o uso de session 
        // para 'temp_block_songs' é menos necessário, mas mantido para compatibilidade.
        session()->put('temp_block_songs', $this->addedSongs);
        $currentUrl = request()->header('Referer');

        return redirect()->route('songs.create', [
            'title' => $searchTitle,
            'return_url' => $currentUrl
        ]);
    }

    // Salva apenas os dados do Bloco (Nome, Descrição)
    public function save()
    {
        $this->validate(['name' => 'required|min:3']);

        $this->block->update([
            'name' => $this->name,
            'description' => $this->description,
            'predominant_key' => $this->predominant_key,
        ]);

        // Não precisa mais do sync aqui pois já salvamos as músicas individualmente
        // Mas o redirect continua
        return redirect()->route('repertoires.show', $this->block->repertoire_id);
    }

    public function render()
    {
        return view('livewire.edit-block');
    }
}