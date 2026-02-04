<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
     protected $fillable = [
        'url',
        'thumbnail_url',
        'alt',
        'width',
        'height',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'featured_image_id');
    }
}
