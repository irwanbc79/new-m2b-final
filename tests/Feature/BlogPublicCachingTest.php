<?php

namespace Tests\Feature;

use App\Http\Middleware\PublicPageCache;
use App\Models\Post;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Tests\TestCase;

/**
 * Halaman blog publik m2b.co.id wajib bisa di-cache CDN (tanpa Set-Cookie),
 * sementara form MORA/B2B di layout tetap terlindungi verifikasi CSRF lewat
 * endpoint GET /csrf-token.
 *
 * Catatan: Laravel melewati verifikasi CSRF saat running unit tests, jadi
 * respons 419 tidak diuji di sini — proteksi POST diuji secara struktural via
 * gatherRouteMiddleware().
 */
class BlogPublicCachingTest extends TestCase
{
    use RefreshDatabase;

    private const SLUG = 'panduan-uji-cache-cdn';

    protected function setUp(): void
    {
        parent::setUp();

        // View composer layouts.app memanggil Google News RSS; jangan sampai
        // test suite menunggu jaringan.
        Http::fake(['*' => Http::response('', 200)]);

        Post::create([
            'title' => 'Panduan Uji Cache CDN Halaman Artikel',
            'slug' => self::SLUG,
            'excerpt' => 'Ringkasan artikel uji caching.',
            'content' => '<h2>Bagian Uji</h2><p>'.str_repeat('Konten uji caching halaman blog. ', 60).'</p>',
            'meta_description' => 'Deskripsi uji caching halaman artikel blog publik.',
            'category' => 'Ekspor',
            'lang' => 'id',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function test_halaman_artikel_cacheable_dan_tanpa_session_cookie(): void
    {
        $response = $this->get('/blog/'.self::SLUG);

        $response->assertOk();
        $this->assertTrue($response->headers->getCacheControlDirective('public'));
        $this->assertSame('600', (string) $response->headers->getCacheControlDirective('s-maxage'));
        $this->assertSame('300', (string) $response->headers->getCacheControlDirective('max-age'));
        $this->assertCount(0, $response->headers->getCookies());
        $response->assertSee('Panduan Uji Cache CDN Halaman Artikel');
    }

    public function test_halaman_index_dan_kalkulator_cacheable_tanpa_session_cookie(): void
    {
        foreach (['/blog', '/blog/kalkulator-bea-masuk'] as $path) {
            $response = $this->get($path);

            $response->assertOk();
            $this->assertSame('600', (string) $response->headers->getCacheControlDirective('s-maxage'), $path);
            $this->assertCount(0, $response->headers->getCookies(), $path);
        }
    }

    public function test_feed_blog_cacheable_tanpa_session_cookie(): void
    {
        $response = $this->get('/blog/feed');

        $response->assertOk();
        $this->assertSame('600', (string) $response->headers->getCacheControlDirective('s-maxage'));
        $this->assertCount(0, $response->headers->getCookies());
    }

    public function test_halaman_tidak_ditemukan_tidak_memakai_header_cache_publik(): void
    {
        $response = $this->get('/blog/slug-yang-tidak-ada');

        $response->assertNotFound();
        $this->assertNotSame(PublicPageCache::CACHE_CONTROL, $response->headers->get('Cache-Control'));
    }

    public function test_html_blog_tidak_memuat_token_csrf_statis_tapi_memuat_bootstrap(): void
    {
        $response = $this->get('/blog/'.self::SLUG);

        $response->assertOk();
        // Tanpa session, token tidak boleh ditanam di HTML ...
        $response->assertDontSee('name="csrf-token" content=', false);
        // ... melainkan diambil on-demand dari endpoint token.
        $response->assertSee('window.m2bCsrfToken', false);
        $response->assertSee("fetch('/csrf-token'", false);
        // Slot AdSense harus ikut ter-render di HTML yang di-cache.
        $response->assertSee('ca-pub-5616961797801657', false);
    }

    public function test_endpoint_csrf_token_mengembalikan_token_dan_tidak_di_cache(): void
    {
        $response = $this->get('/csrf-token');

        $response->assertOk();
        $response->assertJsonStructure(['token']);
        $this->assertNotEmpty($response->json('token'));
        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
        $this->assertNotEmpty($response->headers->getCookies(), 'Endpoint token harus memulai session.');
    }

    public function test_route_blog_melepas_session_dan_memakai_middleware_cache(): void
    {
        foreach (['blog.index', 'blog.feed', 'blog.kalkulator', 'blog.show'] as $name) {
            $middleware = $this->routeMiddleware($name);

            $this->assertContains(PublicPageCache::class, $middleware, $name);
            $this->assertNotContains(StartSession::class, $middleware, $name);
            $this->assertNotContains(ShareErrorsFromSession::class, $middleware, $name);
            $this->assertNotContains(ValidateCsrfToken::class, $middleware, $name);
        }
    }

    public function test_route_post_dan_endpoint_token_tetap_memakai_session_dan_csrf(): void
    {
        foreach (['b2b.inquiry.submit', 'mora.chat', 'mora.lead'] as $name) {
            $middleware = $this->routeMiddleware($name);

            $this->assertContains(StartSession::class, $middleware, $name);
            $this->assertContains(ValidateCsrfToken::class, $middleware, $name);
            $this->assertNotContains(PublicPageCache::class, $middleware, $name);
        }

        $tokenMiddleware = $this->routeMiddleware('csrf.token');

        $this->assertContains(StartSession::class, $tokenMiddleware);
        $this->assertNotContains(PublicPageCache::class, $tokenMiddleware);
    }

    public function test_halaman_non_blog_tetap_memakai_session(): void
    {
        // Guard: pelepasan session hanya untuk route blog, bukan global.
        $middleware = $this->routeMiddleware('home');

        $this->assertContains(StartSession::class, $middleware);
        $this->assertNotContains(PublicPageCache::class, $middleware);
    }

    /**
     * @return array<int, string>
     */
    private function routeMiddleware(string $name): array
    {
        $router = app('router');

        $route = collect($router->getRoutes()->getRoutes())
            ->first(fn ($route) => $route->getName() === $name);

        $this->assertNotNull($route, "Route {$name} tidak terdaftar.");

        return $router->gatherRouteMiddleware($route);
    }
}
