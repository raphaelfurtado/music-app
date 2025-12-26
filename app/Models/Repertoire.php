<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repertoire extends Model
{
    use HasFactory;

    // Campos que podem ser salvos
    protected $fillable = ['user_id', 'name', 'description', 'icon', 'color', 'slug', 'is_public'];

    // Um repertório pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Um repertório tem muitos blocos
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}