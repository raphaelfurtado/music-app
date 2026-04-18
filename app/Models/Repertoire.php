<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repertoire extends Model
{
    use HasFactory;

    // Campos que podem ser salvos
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'icon',
        'color',
        'slug',
        'is_public',
        'is_featured',
        'show_started_at',
        'last_show_started_at',
        'last_show_ended_at',
        'last_show_duration_seconds',
        'total_show_duration_seconds',
        'total_shows',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'show_started_at' => 'datetime',
        'last_show_started_at' => 'datetime',
        'last_show_ended_at' => 'datetime',
    ];

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