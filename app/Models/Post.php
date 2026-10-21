<?php
namespace App\Models;

use App\Services\BlogCache;
use App\Services\PostViewCounter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    /** Single source of truth for blog categories (display labels). */
    public const CATEGORIES = ['Ekspor', 'Impor', 'UMKM', 'Bea Cukai', 'Uncategorized'];

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
            $cache = app(BlogCache::class);

            // Forget this post's cache (current slug)
            $cache->forgetPost($post->slug);

            // If slug changed, also forget old slug cache
            if ($post->wasChanged('slug') && $post->getOriginal('slug')) {
                $cache->forgetPost($post->getOriginal('slug'));
            }

            // Forget related posts cache for this post
            $cache->forgetRelated($post->id);

            $cache->forgetAll();
        });

        static::deleted(function (Post $post) {
            $cache = app(BlogCache::class);

            $cache->forgetPost($post->slug);
            $cache->forgetRelated($post->id);
            app(PostViewCounter::class)->forget($post->id);
            $cache->forgetAll();
        });
    }

    public function scopePublished($query)
    {
        return $query->where("status","published")->orderByDesc("published_at");
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if (!$this->featured_image) {
            return asset('images/og-m2b.jpg');
        }

        if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
            return $this->featured_image;
        }

        return asset('storage/' . $this->featured_image);
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
