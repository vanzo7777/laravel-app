<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function getImageUrlAttribute() {
        if(!$this-> image) {
            return asset('images/default-article.png');
        } 

        if(str_starts_with($this->image, 'article/')) {
            return asset('storage/' . $this->image);
        }

        return asset($this->image);
    }

    public function getShortExcerptAttribute() {
        return \Illuminate\Support\Str::limit($this->excerpt, 120);
    }

    public function getContentHtmlAttribute() {
        $content = $this->content;

        $content = preg_replace('/src="images\//', 'src="/images/', $content);

        return $content;
    }
}
