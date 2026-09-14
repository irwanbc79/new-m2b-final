<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Bridge: pull PUBLISHED M2B articles from the CMS (cms.m2b.co.id) read API
 * and upsert them into the local `posts` table so they appear on m2b.co.id/blog.
 *
 * Safe by default: only CREATES posts for slugs that don't exist yet (so locally
 * edited posts — e.g. fixed images — are never clobbered). Use --all to also
 * update existing posts, and --dry-run to preview without writing.
 */
class SyncBlogFromCms extends Command
{
    protected $signature = 'blog:sync-cms {--limit=50 : page size} {--all : also update existing posts} {--dry-run : preview only, no DB writes}';

    protected $description = 'Pull published M2B articles from the CMS API and upsert into local posts.';

    public function handle(): int
    {
        $base  = rtrim((string) config('services.cms.url'), '/');
        $token = (string) config('services.cms.token');

        if ($base === '' || $token === '') {
            $this->error('CMS API not configured. Set CMS_API_URL & CMS_API_TOKEN in .env.');
            return self::FAILURE;
        }

        $dry = (bool) $this->option('dry-run');
        $all = (bool) $this->option('all');
        $created = $updated = $skipped = $failed = 0;
        $page = 1;
        $lastPage = 1;

        do {
            $resp = Http::withToken($token)->acceptJson()->timeout(30)
                ->get("{$base}/api/v1/articles", [
                    'limit' => (int) $this->option('limit'),
                    'page'  => $page,
                ]);

            if ($resp->failed()) {
                $this->error("List request failed (page {$page}): HTTP {$resp->status()}");
                return self::FAILURE;
            }

            $json     = $resp->json();
            $lastPage = (int) ($json['meta']['last_page'] ?? 1);

            foreach (($json['data'] ?? []) as $item) {
                $slug = $item['slug'] ?? null;
                if (! $slug) {
                    continue;
                }

                $exists = Post::where('slug', $slug)->exists();
                if ($exists && ! $all) {
                    $skipped++;
                    $this->line("  skip (exists): {$slug}");
                    continue;
                }

                // Fetch full detail for content_html.
                $detail = Http::withToken($token)->acceptJson()->timeout(30)
                    ->get("{$base}/api/v1/articles/{$slug}");
                if ($detail->failed()) {
                    $failed++;
                    $this->warn("  detail failed: {$slug} (HTTP {$detail->status()})");
                    continue;
                }

                $a = $detail->json('data') ?? [];
                $tags = $a['tags'] ?? null;

                $data = [
                    'title'            => $a['title'] ?? $slug,
                    'content'          => $a['content_html'] ?? '',
                    'excerpt'          => $a['excerpt'] ?? null,
                    'meta_title'       => $a['og_title'] ?? ($a['title'] ?? null),
                    'meta_description' => $a['meta_description'] ?? null,
                    'featured_image'   => $a['featured_image_url'] ?? null,
                    'category'         => $this->mapCategory($slug, $a['pillar'] ?? null),
                    'tags'             => is_array($tags) ? implode(', ', $tags) : ($tags ?: null),
                    'lang'             => $a['language'] ?? 'id',
                    'status'           => 'published',
                    'published_at'     => $a['published_at'] ?? now(),
                ];

                if ($dry) {
                    $verb = $exists ? 'UPDATE' : 'CREATE';
                    $this->line("  [{$verb}] {$slug}  ->  [{$data['category']}] {$data['title']}");
                    $exists ? $updated++ : $created++;
                    continue;
                }

                $post = Post::updateOrCreate(['slug' => $slug], $data);
                $post->wasRecentlyCreated ? $created++ : $updated++;
            }

            $page++;
        } while ($page <= $lastPage);

        $mode = $dry ? 'DRY-RUN' : 'SYNC';
        $this->info("{$mode} done: created={$created} updated={$updated} skipped={$skipped} failed={$failed}");
        if (! $dry) {
            Log::info('blog:sync-cms', compact('created', 'updated', 'skipped', 'failed'));
        }

        return self::SUCCESS;
    }

    /** Map CMS slug/pillar to a local Post category (Ekspor/Impor/UMKM/Bea Cukai/Uncategorized). */
    private function mapCategory(string $slug, ?string $pillar): string
    {
        if (str_starts_with($slug, 'export-')) {
            return 'Ekspor';
        }
        if (str_starts_with($slug, 'import-')) {
            return 'Impor';
        }
        if (str_contains($slug, 'customs') || str_contains($slug, 'bea-cukai') || str_contains($slug, 'freight')) {
            return 'Bea Cukai';
        }

        return match ($pillar) {
            'umkm'     => 'UMKM',
            'regulasi' => 'Bea Cukai',
            'logistik' => 'Impor',
            default    => 'Uncategorized',
        };
    }
}
