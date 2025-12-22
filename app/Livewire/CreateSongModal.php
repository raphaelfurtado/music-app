<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Song;

class CreateSongModal extends Component
{
    public $isOpen = false; // Controla se o modal está visível
    
    public $title = '';
    public $key = '';
    public $lyrics = '';

    // Ouve o evento para abrir o modal
    protected $listeners = ['openSongModal' => 'open'];

    public function open($searchName = '')
    {
        $this->title = $searchName; // Já preenche com o que você digitou na busca
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->reset(['title', 'key', 'lyrics']);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:2',
        ]);

        $song = Song::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'key' => $this->key,
            'lyrics' => $this->lyrics,
        ]);

        $this->close();

        // Avisa o componente de Criação de Bloco que a música foi criada
        // e passa o ID dela para já ser adicionada na lista
        $this->dispatch('song-created', songId: $song->id); 
    }

    public function render()
    {
        return view('livewire.create-song-modal');
    }
}