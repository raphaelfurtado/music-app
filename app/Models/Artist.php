<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = ['name', 'slug', 'image_url', 'bio'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
