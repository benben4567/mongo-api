<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'publisher'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
