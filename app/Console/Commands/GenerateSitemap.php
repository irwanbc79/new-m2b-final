<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml untuk SEO';

    public function handle(): void
    {
        $sitemap = Sitemap::create();

        // Halaman statis
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('weekly'));
        $sitemap->add(Url::create('/tentang-kami')->setPriority(0.8)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/tim')->setPriority(0.6)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/blog')->setPriority(0.9)->setChangeFrequency('daily'));
        $sitemap->add(Url::create('/karir')->setPriority(0.7)->setChangeFrequency('weekly'));
        $sitemap->add(Url::create('/privacy-policy')->setPriority(0.3)->setChangeFrequency('yearly'));
        $sitemap->add(Url::create('/disclaimer')->setPriority(0.3)->setChangeFrequency('yearly'));
        $sitemap->add(Url::create('/ketentuan-layanan')->setPriority(0.3)->setChangeFrequency('yearly'));

        // Semua blog post published
        Post::where('status', 'published')
            ->orderByDesc('published_at')
            ->each(function (Post $post) use ($sitemap) {
                $sitemap->add(
                    Url::create("/blog/{$post->slug}")
                        ->setLastModificationDate($post->updated_at)
                        ->setPriority(0.7)
                        ->setChangeFrequency('monthly')
                );
            });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $count = Post::where('status', 'published')->count();
        $this->info("Sitemap generated: 8 halaman statis + {$count} blog posts → public/sitemap.xml");
    }
}
