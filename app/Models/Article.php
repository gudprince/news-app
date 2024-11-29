<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{  
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'author',
        'source_name',
        'published_at',
        'category_id',
        'article_url',
        'slug',
        'image_url',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
