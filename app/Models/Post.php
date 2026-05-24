<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    public function scopePublished($query)
    {
        return $query->where("status","published")->orderByDesc("published_at");
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
