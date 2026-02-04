<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
        'articles_count',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
