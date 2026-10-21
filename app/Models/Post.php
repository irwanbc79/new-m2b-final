<?php
namespace App\Models;

use App\Services\BlogCache;
use App\Services\PostViewCounter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    /**
     * Batasi ke daftar id POPULER hasil PostViewCounter.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<Post>  $query
     * @param  array<int, int|string>  $hotIds
     */
    public function scopeHot($query, array $hotIds)
    {
        return $query->whereIn('id', $hotIds);
    }

    /**
     * Artikel POPULER untuk widget sidebar /blog: yang view-nya terbanyak dulu.
     *
     * Kalau belum ada view sama sekali (atau id di cache sudah tidak published),
     * widget jatuh ke post terbaru sebanyak $fallbackLimit — perilaku lama.
     *
     * Urutan akhir ditentukan di PHP (bukan ORDER BY) karena sumbernya counter
     * cache, bukan kolom DB. Satu panggilan PostViewCounter::counts() dipakai
     * untuk semua post (Cache::many → satu query di store `database`),
     * menggantikan count() per post.
     *
     * @param  array<int, int|string>  $hotIds
     * @return \Illuminate\Database\Eloquent\Collection<int, Post>
     */
    public static function popularFor(array $hotIds, PostViewCounter $views, int $fallbackLimit = 4)
    {
        if ($hotIds !== []) {
            $counts = $views->counts($hotIds);

            $posts = static::published()->hot($hotIds)->get()
                ->sortByDesc(fn (Post $post) => $counts[$post->id] ?? 0)
                ->values();

            if ($posts->isNotEmpty()) {
                return $posts;
            }
        }

        return static::published()->take($fallbackLimit)->get();
    }

    /**
     * Artikel "Baca Juga" halaman detail: post published lain di kategori yang
     * sama (kalau post punya kategori).
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Post>
     */
    public static function relatedFor(Post $post, int $limit = 3)
    {
        $query = static::published()->where('id', '!=', $post->id);

        if ($post->category) {
            $query->where('category', $post->category);
        }

        return $query->limit($limit)->get();
    }

    /**
     * Tema visual kartu artikel yang tidak punya gambar: [gradient latar, emoji].
     * Kategori di luar daftar (atau null) memakai fallback di themeFor().
     */
    public const CATEGORY_THEMES = [
        'Ekspor'    => ['linear-gradient(135deg,#1e3a5f 0%,#1a6b3a 100%)', '🚢'],
        'Impor'     => ['linear-gradient(135deg,#1e3a5f 0%,#4a2a7f 100%)', '📥'],
        'UMKM'      => ['linear-gradient(135deg,#1e3a5f 0%,#7f5a1e 100%)', '🏪'],
        'Bea Cukai' => ['linear-gradient(135deg,#5f2a1e 0%,#1e3a5f 100%)', '🛃'],
    ];

    /**
     * Label kategori 4 bahasa untuk UI. Sebelumnya peta ini disalin empat kali
     * di blog/index.blade.php (lihat labelsFor()).
     */
    public const CATEGORY_LABELS = [
        'Ekspor'    => ['id' => 'Ekspor', 'en' => 'Export', 'zh' => '出口', 'ar' => 'التصدير'],
        'Impor'     => ['id' => 'Impor', 'en' => 'Import', 'zh' => '进口', 'ar' => 'الاستيراد'],
        'UMKM'      => ['id' => 'UMKM', 'en' => 'SME', 'zh' => '中小企业', 'ar' => 'الشركات الصغيرة والمتوسطة'],
        'Bea Cukai' => ['id' => 'Bea Cukai', 'en' => 'Customs', 'zh' => '海关与报关', 'ar' => 'الجمارك'],
    ];

    /**
     * @return array{0: string, 1: string} [gradient, emoji]
     */
    public static function themeFor(?string $category): array
    {
        return self::CATEGORY_THEMES[$category]
            ?? ['linear-gradient(135deg,#1e3a5f 0%,#2a5298 100%)', '📦'];
    }

    /**
     * Label id/en/zh/ar untuk satu kategori. Kategori tak dikenal dikembalikan
     * apa adanya di keempat bahasa — sama seperti fallback peta di blade dulu.
     *
     * @return array{id: string, en: string, zh: string, ar: string}
     */
    public static function labelsFor(?string $category): array
    {
        $kategori = (string) $category;

        return self::CATEGORY_LABELS[$category]
            ?? ['id' => $kategori, 'en' => $kategori, 'zh' => $kategori, 'ar' => $kategori];
    }

    /**
     * @return array{0: string, 1: string} [gradient, emoji]
     */
    public function theme(): array
    {
        return self::themeFor($this->category);
    }

    /**
     * @return array{id: string, en: string, zh: string, ar: string}
     */
    public function categoryLabels(): array
    {
        return self::labelsFor($this->category);
    }

    /**
     * Badge BARU: published dalam $days hari terakhir. Post tanpa published_at
     * tidak pernah dianggap baru (dulu lewat nilai sentinel 999).
     */
    public function isNew(int $days = 7): bool
    {
        if (! $this->published_at) {
            return false;
        }

        // Sengaja tanpa abs(): tanggal publish di masa depan dulu juga lolos
        // (diffInDays negatif ≤ 7), jadi jangan diubah di sini.
        return now()->diffInDays($this->published_at) <= $days;
    }

    /**
     * Badge DIPERBARUI: di-update < $days hari lalu DAN update-nya terjadi lebih
     * dari $graceAfterPublish hari setelah publish (biar revisi sehari setelah
     * terbit tidak langsung dicap "diperbarui").
     */
    public function isUpdated(int $days = 14, int $graceAfterPublish = 3): bool
    {
        if (! $this->updated_at || $this->updated_at->diffInDays(now()) >= $days) {
            return false;
        }

        // copy(): addDays() memutasi instance Carbon, jangan sampai published_at
        // artikel ini ikut tergeser tiga hari di halaman yang sama.
        $patokan = $this->published_at
            ? $this->published_at->copy()->addDays($graceAfterPublish)
            : now();

        return $this->updated_at->gt($patokan);
    }

    /**
     * Badge 🔥 POPULER: id artikel ada di daftar hasil PostViewCounter.
     *
     * @param  array<int, int|string>  $hotIds
     */
    public function isHot(array $hotIds): bool
    {
        return in_array($this->id, $hotIds);
    }

    /**
     * Bahan pencarian client-side (x-show pada kartu): judul + ringkasan +
     * kategori dalam huruf kecil.
     */
    public function searchHaystack(): string
    {
        return strtolower($this->title . ' ' . ($this->excerpt ?? '') . ' ' . ($this->category ?? ''));
    }

    /**
     * URL gambar artikel untuk <img>, background-image, dan og:image/JSON-LD.
     *
     * Ini SATU-SATUNYA tempat aturan ini hidup. Sebelumnya aturan yang sama
     * disalin lima kali di blade (kartu grid, kartu featured, hero halaman
     * artikel, kartu "Artikel Terkait", strip blog di home) dengan dua bentuk
     * hasil yang berbeda untuk berkas yang sama:
     *
     *  - blade memakai Storage::url() pada disk DEFAULT, sedangkan disk default
     *    aplikasi ini adalah `local` (root storage/app/private, tanpa kunci url)
     *    → hasilnya URL RELATIF `/storage/posts/x.jpg`;
     *  - accessor og:image memakai asset('storage/...') → absolut.
     *
     * Dua bentuk itu juga membuat kartu diam-diam berubah perilaku kalau
     * FILESYSTEM_DISK diganti, sementara og:image tidak.
     *
     * Disk 'public' sekarang dipakai eksplisit karena di sanalah FileUpload
     * Filament menaruh berkasnya (PostResource → directory("posts"),
     * config('filament.default_filesystem_disk') = 'public', root
     * storage/app/public yang disajikan lewat symlink public/storage).
     *
     * @return string|null null = artikel tidak punya gambar; kartu memakai tema
     *                     kategori (Post::theme()) dan og:image memakai fallback
     */
    public function imageUrl(): ?string
    {
        $path = trim((string) $this->featured_image);

        if ($path === '') {
            return null;
        }

        // URL absolut (mis. hasil SyncBlogFromCms dari CMS lain) atau
        // protocol-relative dipakai apa adanya — jangan ditempeli prefix disk.
        // Dua pemeriksaan sengaja dipakai bersamaan supaya ini superset dari
        // kedua implementasi lama (Str::startsWith di blade, filter_var di
        // accessor og:image): URL unicode yang ditolak filter_var tetap lolos.
        if (filter_var($path, FILTER_VALIDATE_URL) || Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        return Storage::disk('public')->url(ltrim($path, '/'));
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        // og:image/twitter:image wajib absolut dan wajib ada isinya, jadi pakai
        // resolver yang sama dengan kartu + fallback gambar kartu sosial.
        return $this->imageUrl() ?? asset('images/og-m2b.jpg');
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
