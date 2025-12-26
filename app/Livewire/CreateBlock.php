<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Repertoire;
use App\Models\Song;
use Illuminate\Support\Facades\DB;

class CreateBlock extends Component
{
    public Repertoire $repertoire;

    // Campos do Formulário do Bloco
    public $repertoire_id;
    public $name = '';
    public $predominant_key = '';
    public $description = '';

    // Busca e Lista de Músicas
    public $search = '';
    public $addedSongs = [];

    // --- PROPRIEDADES DO MODAL (Adicionadas) ---
    // Removidas em favor do CreateSongModal
    // -------------------------------------------

    protected $listeners = ['song-created' => 'addSong'];

    public $keys = [
        ['key' => 'G', 'label' => 'Sol'],
        ['key' => 'C', 'label' => 'Dó'],
        ['key' => 'D', 'label' => 'Ré'],
        ['key' => 'E', 'label' => 'Mi'],
        ['key' => 'F', 'label' => 'Fá'],
        ['key' => 'A', 'label' => 'Lá'],
    ];

    public function mount(Repertoire $repertoire)
    {
        $this->repertoire = $repertoire;
        $this->repertoire_id = $repertoire->id; // Importante para o botão cancelar

        // 1. RECUPERA A SESSÃO
        if (session()->has('temp_block_songs')) {
            $this->addedSongs = session()->pull('temp_block_songs');
        }

        // 2. CAPTURA A MÚSICA NOVA VIA URL
        if (request()->has('new_song_id')) {
            $songId = request('new_song_id');
            $this->addSong($songId);
        }
    }

    // --- MÉTODOS DO MODAL ---

    public function openSongModal()
    {
        // Envia o search atual como sugestão de nome
        // E passa o repertoire_id para já vincular corretamente
        $this->dispatch(
            'openSongModal',
            searchName: $this->search,
            repertoireId: $this->repertoire_id
        );
    }
    // ------------------------

    public function addSong($songId)
    {
        $song = Song::find($songId);
        if (!$song)
            return;

        // Evita duplicatas
        foreach ($this->addedSongs as $s) {
            if ($s['id'] == $songId)
                return;
        }

        $this->addedSongs[] = $song->toArray();
        $this->search = ''; // Limpa a busca
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

    public function getSearchResultsProperty()
    {
        if (strlen($this->search) < 2)
            return [];
        return Song::where('title', 'like', '%' . $this->search . '%')
            ->take(5)->get();
    }

    // Mantido caso você ainda use o redirecionamento externo
    public function goToCreateSong($searchTitle)
    {
        session()->put('temp_block_songs', $this->addedSongs);
        $currentUrl = request()->header('Referer');
        return redirect()->route('songs.create', [
            'title' => $searchTitle,
            'return_url' => $currentUrl
        ]);
    }

    public function save()
    {
        $this->validate(['name' => 'required|min:3']);

        DB::beginTransaction();

        try {
            // 1. Cria o Bloco
            $block = $this->repertoire->blocks()->create([
                'name' => $this->name,
                'description' => $this->description,
                'predominant_key' => $this->predominant_key,
                'order' => $this->repertoire->blocks()->count() + 1,
            ]);

            // 2. Vincula as músicas da lista ($addedSongs) ao bloco criado
            if (!empty($this->addedSongs)) {
                $pivotData = [];
                foreach ($this->addedSongs as $index => $song) {
                    $pivotData[] = [
                        'block_id' => $block->id,
                        'song_id' => $song['id'],
                        'order' => $index + 1,
                    ];
                }
                DB::table('block_song')->insert($pivotData);
            }

            DB::commit();
            return redirect()->route('repertoires.show', $this->repertoire->id);

        } catch (\Exception $e) {
            DB::rollBack();
            // Em produção, evite dd(), use session()->flash('error', ...)
            session()->flash('error', 'Erro ao salvar bloco: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.create-block');
    }
}