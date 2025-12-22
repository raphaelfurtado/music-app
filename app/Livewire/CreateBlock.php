<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Repertoire;
use App\Models\Song;
use Illuminate\Support\Facades\DB;

class CreateBlock extends Component
{
    public Repertoire $repertoire;

    // Campos do Formulário
    public $name = '';
    public $predominant_key = '';
    public $description = '';

    // Busca e Lista de Músicas
    public $search = '';
    public $addedSongs = []; // AQUI ESTÁ A CHAVE: Esta lista precisa encher!

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

        // 1. RECUPERA A SESSÃO (Músicas que já estavam na lista antes de ir pro Controller)
        if (session()->has('temp_block_songs')) {
            $this->addedSongs = session()->pull('temp_block_songs');
        }

        // 2. CAPTURA A MÚSICA NOVA (O ID que o SongController mandou pela URL)
        if (request()->has('new_song_id')) {
            $songId = request('new_song_id');
            $this->addSong($songId); // Adiciona na lista visual imediatamente
        }
    }

    // Função auxiliar para adicionar música na lista visual
    public function addSong($songId)
    {
        $song = Song::find($songId);
        if (!$song)
            return;

        // Evita duplicatas (se a música já estiver na lista, não adiciona de novo)
        foreach ($this->addedSongs as $s) {
            if ($s['id'] == $songId)
                return;
        }

        $this->addedSongs[] = $song->toArray();
    }

    // Ação do botão "Cadastrar" no HTML
    public function goToCreateSong($searchTitle)
    {
        // 1. Salva o estado atual na sessão
        session()->put('temp_block_songs', $this->addedSongs);

        // 2. CORREÇÃO CRÍTICA:
        // Não use url()->current() aqui, pois ele pega a rota interna do Livewire.
        // Use o 'Referer', que é o endereço que está no seu navegador agora.
        $currentUrl = request()->header('Referer');

        // Redireciona para o Controller de Música
        return redirect()->route('songs.create', [
            'title' => $searchTitle,
            'return_url' => $currentUrl // Agora a URL correta vai para o controller
        ]);
    }

    // ... (Métodos selectKey, removeSong, updateBlockOrder, etc. iguais aos anteriores) ...
    public function selectKey($key)
    {
        $this->predominant_key = ($this->predominant_key === $key) ? null : $key;
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
    public function getSearchResultsProperty()
    {
        if (strlen($this->search) < 2)
            return [];
        return Song::where('user_id', auth()->id())->where('title', 'like', '%' . $this->search . '%')->take(5)->get();
    }

    // O SALVAMENTO REAL
    public function save()
    {
        $this->validate(['name' => 'required|min:3']);

        DB::beginTransaction(); // Segurança do banco

        try {
            // 1. Cria o Bloco (que ainda não existia)
            $block = $this->repertoire->blocks()->create([
                'name' => $this->name,
                'description' => $this->description,
                'predominant_key' => $this->predominant_key,
                'order' => $this->repertoire->blocks()->count() + 1,
            ]);

            // 2. Verifica se a lista visual tem músicas
            if (!empty($this->addedSongs)) {
                $pivotData = [];

                foreach ($this->addedSongs as $index => $song) {
                    $pivotData[] = [
                        'block_id' => $block->id,
                        'song_id' => $song['id'],
                        'order' => $index + 1,
                    ];
                }

                // 3. INSERE NA TABELA PIVÔ MANUALMENTE
                // Isso ignora qualquer erro de Model e força a gravação
                DB::table('block_song')->insert($pivotData);
            }

            DB::commit(); // Confirma tudo

            return redirect()->route('repertoires.show', $this->repertoire->id);

        } catch (\Exception $e) {
            DB::rollBack();
            dd('Erro ao salvar:', $e->getMessage()); // Mostra erro se houver
        }
    }

    public function render()
    {
        return view('livewire.create-block');
    }
}