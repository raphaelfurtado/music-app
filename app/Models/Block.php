<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = ['repertoire_id', 'name', 'predominant_key', 'order'];

    // Um bloco pertence a um repertório
    public function repertoire()
    {
        return $this->belongsTo(Repertoire::class);
    }

    // Um bloco contém muitas músicas (Relação N:N)
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'block_song') // 2º param: nome da tabela
            ->withPivot('order')
            ->orderBy('block_song.order'); // Ordenação explícita
    }
}