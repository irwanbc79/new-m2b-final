<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TeamMember;

class PageController extends Controller
{
    public function home(\App\Services\ExchangeRateService $rateService)
    {
        $latestPosts = Post::published()->limit(3)->get();
        $rates = $rateService->getRates();

        // Fetch field photos dynamically from portal database (clean, no metadata to preserve confidentiality)
        $fieldPhotos = collect([]);
        try {
            $photosPool = \Illuminate\Support\Facades\DB::connection('portal')
                ->table('field_photos')
                ->where('status', 'approved')
                ->whereNotNull('file_path')
                ->where('file_path', '!=', '')
                ->select('id', 'file_path')
                ->orderBy('id', 'desc')
                ->limit(100)
                ->get();

            if ($photosPool->isNotEmpty()) {
                $fieldPhotos = $photosPool->shuffle()
                    ->take(40)
                    ->map(function ($photo) {
                        $photo->url = 'https://portal.m2b.co.id/storage/' . $photo->file_path;
                        return $photo;
                    })
                    ->values();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to load field photos from portal: ' . $e->getMessage());
        }

        // Fallback to high quality pre-curated photo assets if database is empty or connection fails
        if ($fieldPhotos->isEmpty()) {
            $fallbackUrls = [
                'https://portal.m2b.co.id/storage/field-photos/2026/06/111/1780378406_qjvUQslV.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659396_dkc49m8H.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/92/1777022144_0N67z2J0.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/104/1776326866_CnPfLj0R.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/96/1776865058_xbbqqSob.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/92/1777088659_RSGuHScw.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/06/111/1780378406_7ZCOgFY1.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/06/111/1780378405_l8X2t7BQ.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/06/111/1780378405_onbWqGPX.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659395_QUAtjLMr.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659393_tclIzRWu.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659392_JhmQlZ6Z.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659391_dOSjbSVX.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659390_BgRB1vBa.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659388_Ne54vUHR.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659387_Mwjx8MBg.jpg'
            ];
            $fieldPhotos = collect($fallbackUrls)->map(fn($url) => (object)['url' => $url]);
        }

        return view("pages.home", compact("latestPosts", "rates", "fieldPhotos"));
    }

    public function about()
    {
        return view("pages.about");
    }

    public function tim()
    {
        $members = TeamMember::active()->get();
        return view("pages.tim", compact("members"));
    }

    public function privacy()
    {
        return view("pages.legal", [
            "title" => "Privacy Policy / Kebijakan Privasi",
            "slug" => "privacy-policy",
        ]);
    }

    public function disclaimer()
    {
        return view("pages.legal", [
            "title" => "Disclaimer / Penafian",
            "slug" => "disclaimer",
        ]);
    }

    public function terms()
    {
        return view("pages.legal", [
            "title" => "Ketentuan Layanan",
            "slug" => "terms",
        ]);
    }
}
