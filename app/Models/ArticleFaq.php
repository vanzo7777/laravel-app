<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleFaq extends Model
{
    protected $fillable = [
        'article_id', 
        'question', 
        'asnwer', 
        'sort_order',
    ];

    public function article() {
        return $this->belongsTo(Article::class);
    }
}
