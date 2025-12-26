<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Song;

class CreateSongModal extends Component
{
    public $isOpen = false;
    public $editingSongId = null;

    // Campos da Música
    public $title = '';
    public $artist = '';
    public $key = '';
    public $bpm = null;
    public $lyrics = '';

    // Contexto (onde a música será salva)
    public $repertoire_id = null;
    public $block_id = null;

    protected $listeners = [
        'openSongModal' => 'open',
        'editSong' => 'edit'
    ];

    public function open($searchName = '', $repertoireId = null, $blockId = null)
    {
        $this->resetForm();
        $this->title = $searchName;
        $this->repertoire_id = $repertoireId; // Se vier de um bloco, pode passar o repertório
        $this->block_id = $blockId;           // Se quisermos vincular direto (opcional, mas bom ter)
        $this->isOpen = true;
    }

    public function edit($songId)
    {
        $song = Song::find($songId);
        if (!$song)
            return;

        $this->editingSongId = $song->id;
        $this->title = $song->title;
        $this->artist = $song->artist;
        $this->key = $song->key;
        $this->bpm = $song->bpm;
        $this->lyrics = $song->lyrics;

        $this->isOpen = true;
    }

    public function resetForm()
    {
        $this->reset(['title', 'artist', 'key', 'bpm', 'lyrics', 'editingSongId', 'repertoire_id', 'block_id']);
    }

    public function close()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:2|string|max:255',
            'artist' => 'nullable|string|max:255',
            'key' => 'nullable|string',
            'bpm' => 'nullable|integer',
            'lyrics' => 'nullable|string',
        ]);

        if ($this->editingSongId) {
            // --- EDIÇÃO ---
            $song = Song::find($this->editingSongId);
            if ($song) {
                $song->update([
                    'title' => $this->title,
                    'artist' => $this->artist,
                    'key' => $this->key,
                    'bpm' => $this->bpm,
                    'lyrics' => $this->lyrics,
                ]);

                // Dispara evento de atualização
                $this->dispatch('song-updated', songId: $song->id);
            }
        } else {
            // --- CRIAÇÃO ---
            $song = Song::create([
                'user_id' => auth()->id(),
                'repertoire_id' => $this->repertoire_id, // Se informado
                'title' => $this->title,
                'artist' => $this->artist,
                'key' => $this->key,
                'bpm' => $this->bpm,
                'lyrics' => $this->lyrics,
            ]);

            // Dispara evento de criação
            $this->dispatch('song-created', songId: $song->id);
        }

        $this->close();
    }

    public function render()
    {
        return view('livewire.create-song-modal');
    }
}