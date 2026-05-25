<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        "title","slug","excerpt","content","featured_image",
        "meta_title","meta_description",
        "category","tags","lang","status","wp_id","published_at"
    ];

    protected $casts = ["published_at" => "datetime"];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    protected static function booted(): void
    {
        static::saved(function (Post $post) {
            // Forget this post's cache (current slug)
            Cache::forget("blog_post_{$post->slug}");

            // If slug changed, also forget old slug cache
            if ($post->wasChanged('slug') && $post->getOriginal('slug')) {
                Cache::forget("blog_post_{$post->getOriginal('slug')}");
            }

            // Forget related posts cache for this post
            Cache::forget("blog_related_{$post->id}");

            // Forget blog index pages (covers up to 150 pages of 9 posts = 1350 posts)
            for ($i = 1; $i <= 20; $i++) {
                Cache::forget("blog_index_{$i}");
            }

            // Forget categories list
            Cache::forget('blog_categories');
        });

        static::deleted(function (Post $post) {
            Cache::forget("blog_post_{$post->slug}");
            Cache::forget("blog_related_{$post->id}");
            for ($i = 1; $i <= 20; $i++) {
                Cache::forget("blog_index_{$i}");
            }
            Cache::forget('blog_categories');
        });
    }

    public function scopePublished($query)
    {
        return $query->where("status","published")->orderByDesc("published_at");
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        return $this->featured_image
            ? asset('storage/' . $this->featured_image)
            : asset('images/og-m2b.jpg');
    }

    public function getReadingTimeAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->content)) / 200));
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->title . ' — M2B Blog';
    }

    public function getMetaDescriptionAttribute($value): string
    {
        return $value ?: Str::limit(strip_tags($this->excerpt ?? $this->content), 160);
    }
}
