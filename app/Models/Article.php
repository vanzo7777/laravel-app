<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'title',
        'sort_order',
        'slug',
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

    protected static function boot() {
        parent::boot();
        static::creating(function($article) {
            if(empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->title);
            }
        });

        static::updating(function($article) {
            if($article->isDirty('title') && empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->title, $article->id);
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while(static::query()
            ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
