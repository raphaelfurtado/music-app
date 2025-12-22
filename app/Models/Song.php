<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'artist', 'key', 'bpm', 'lyrics'];

    // Uma música pertence a quem a cadastrou
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Uma música pode estar em vários blocos
    public function blocks()
    {
        return $this->belongsToMany(Block::class);
    }
}