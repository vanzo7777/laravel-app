<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'publish_date', 
        'author',
        'image',
    ];

    public function faqs() {
        return $this->hasmany(ArticleFaq::class)->orderBy('sort_order');
    }
}
