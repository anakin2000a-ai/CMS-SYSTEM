<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'tags',
        'reading_time',
        'views_count',
        'is_featured',
        'published_at',
        'user_id',
        'category_id',
        'featured_image_id',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function featuredImage()
    {
        return $this->belongsTo(Image::class, 'featured_image_id');
    }
}
