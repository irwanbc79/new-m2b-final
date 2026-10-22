<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menandai halaman GET publik blog m2b.co.id sebagai cacheable oleh CDN.
 *
 * Halaman blog tidak menyimpan state per-pengguna, jadi tidak butuh session.
 * Middleware ini dipasang pada route yang sudah melepas StartSession +
 * ShareErrorsFromSession + ValidateCsrfToken (lihat routes/web.php), lalu:
 *
 *  1. membuang header Set-Cookie — presence cookie membuat Hostinger hCDN
 *     mengembalikan BYPASS/DYNAMIC alias HTML tidak pernah di-cache;
 *  2. menulis Cache-Control public + s-maxage agar HTML disimpan di edge.
 *
 * Route yang tetap butuh session (POST /b2b/inquiry, /mora/chat, /mora/lead,
 * dan GET /csrf-token) sengaja TIDAK memakai middleware ini.
 */
class PublicPageCache
{
    public const CACHE_CONTROL = 'public, max-age=300, s-maxage=600, stale-while-revalidate=60';

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->isMethod('GET') || $response->getStatusCode() !== 200) {
            return $response;
        }

        // Hormati response yang memang menyatakan dirinya tidak boleh di-cache.
        if ($response->headers->getCacheControlDirective('no-store')) {
            return $response;
        }

        $response->headers->remove('Set-Cookie');
        $response->headers->set('Cache-Control', self::CACHE_CONTROL);

        return $response;
    }
}
