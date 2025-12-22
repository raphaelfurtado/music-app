<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Song;
use App\Models\User;

class SongSeeder extends Seeder
{
    public function run(): void
    {
        // Pega o primeiro usuário do banco (provavelmente VOCÊ)
        $user = User::first();

        if (!$user) {
            $this->command->error('ERRO: Crie uma conta no site antes de rodar este comando!');
            return;
        }

        $songs = [
            ['title' => 'Ousado Amor', 'artist' => 'Isaias Saad', 'key' => 'G', 'bpm' => 68],
            ['title' => 'Lugar Secreto', 'artist' => 'Gabriela Rocha', 'key' => 'G', 'bpm' => 72],
            ['title' => 'Perfect', 'artist' => 'Ed Sheeran', 'key' => 'Ab', 'bpm' => 95],
            ['title' => 'Tempo de Alegria', 'artist' => 'Ivete Sangalo', 'key' => 'E', 'bpm' => 140],
            ['title' => 'Oceanos', 'artist' => 'Ana Nóbrega', 'key' => 'D', 'bpm' => 65],
            ['title' => 'A Casa é Sua', 'artist' => 'Casa Worship', 'key' => 'C', 'bpm' => 70],
            ['title' => 'Todavia Me Alegrarei', 'artist' => 'Leandro Soares', 'key' => 'A', 'bpm' => 68],
            ['title' => 'Raridade', 'artist' => 'Anderson Freire', 'key' => 'Bb', 'bpm' => 75],
        ];

        foreach ($songs as $song) {
            Song::create(array_merge($song, [
                'user_id' => $user->id,
                'lyrics' => 'Letra de teste para ' . $song['title']
            ]));
        }

        $this->command->info('Músicas adicionadas para o usuário: ' . $user->name);
    }
}