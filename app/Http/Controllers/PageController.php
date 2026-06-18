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
                ->select('id', 'description', 'file_path')
                ->orderBy('id', 'desc')
                ->limit(200)
                ->get();

            if ($photosPool->isNotEmpty()) {
                $blacklist = [
                    'seal', 'segel', 'penyegelan', 'cro', 'dokumen', 'document', 'paper', 'kertas',
                    'resi', 'surat', 'packing', 'invoice', 'stnk', 'plat', 'dus', 'karton', 'box',
                    'timbangan', 'timbang', 'antrian', 'pkb', 'pintu', 'label', 'form', 'slip',
                    'kondisi', 'identitas', 'ktp', 'sim', 'paspor', 'no', 'nomor', 'number',
                    'manifest', 'detail', 'berat', 'weight', 'plate', 'nopol', 'tally', 'tag', 'marking'
                ];

                $filteredPhotos = $photosPool->filter(function ($photo) use ($blacklist) {
                    if (empty($photo->description)) {
                        return true;
                    }
                    $desc = strtolower($photo->description);
                    foreach ($blacklist as $word) {
                        if (str_contains($desc, $word)) {
                            return false;
                        }
                    }
                    return true;
                });

                $fieldPhotos = $filteredPhotos->shuffle()
                    ->take(48)
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
            $fallbackUrlsCurated = [
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
                'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659387_Mwjx8MBg.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/96/1776865058_f1tMRUsv.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/96/1776865058_NhDu6Lbg.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/96/1776865058_WS9TnjJy.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/104/1776326866_fBmmSuVA.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/104/1776326866_ALrYOyh5.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/96/1776245628_iWTId1Jl.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/96/1776245628_Yb5PszIK.jpg',
                'https://portal.m2b.co.id/storage/field-photos/2026/04/96/1776245628_NuXmlbL7.jpg'
            ];
            $fallbackUrls = array_merge($fallbackUrlsCurated, $fallbackUrlsCurated);
            $fieldPhotos = collect($fallbackUrls)->map(fn($url) => (object)['url' => $url]);
        }

        // Fetch approved testimonials dynamically from portal database
        $testimonials = [];
        try {
            $dbTestimonials = \Illuminate\Support\Facades\DB::connection('portal')
                ->table('testimonials')
                ->where('status', 'approved')
                ->select('display_name', 'company_name', 'position', 'rating', 'content')
                ->orderBy('approved_at', 'desc')
                ->get();

            if ($dbTestimonials->isNotEmpty()) {
                foreach ($dbTestimonials as $item) {
                    $testimonials[] = [
                        'name' => $item->display_name ?: 'Mitra M2B',
                        'title' => [
                            'id' => ($item->position ? $item->position . ' — ' : '') . ($item->company_name ?: 'PT. Mora Multi Berkah Client'),
                            'en' => ($item->position ? $item->position . ' — ' : '') . ($item->company_name ?: 'PT. Mora Multi Berkah Client'),
                            'zh' => ($item->position ? $item->position . ' — ' : '') . ($item->company_name ?: 'PT. Mora Multi Berkah Client'),
                            'ar' => ($item->position ? $item->position . ' — ' : '') . ($item->company_name ?: 'PT. Mora Multi Berkah Client'),
                        ],
                        'quote' => [
                            'id' => '"' . trim($item->content, '" ') . '"',
                            'en' => '"' . trim($item->content, '" ') . '"',
                            'zh' => '"' . trim($item->content, '" ') . '"',
                            'ar' => '"' . trim($item->content, '" ') . '"',
                        ],
                        'rating' => $item->rating ?? 5,
                    ];
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to load testimonials from portal: ' . $e->getMessage());
        }

        // Fallback to high quality existing pre-curated testimonials if portal database is empty or connection fails
        if (empty($testimonials)) {
            $testimonials = [
                [
                    'name' => 'Edy Serdawanto',
                    'title' => [
                        'id' => 'Direktur — PT. Dira Baraka Mulia',
                        'en' => 'Director — PT. Dira Baraka Mulia',
                        'zh' => '董事长 — PT. Dira Baraka Mulia',
                        'ar' => 'مدير — PT. Dira Baraka Mulia'
                    ],
                    'quote' => [
                        'id' => '"Penanganan impor dengan biaya yang jelas dan terukur, tepat waktu. Sangat layak menjadi rekan bisnis Anda."',
                        'en' => '"Import handling with clear, measurable costs and on-time delivery. Very worthy of being your business partner."',
                        'zh' => '"进口操作费用清晰透明、交货准时，非常值得信赖的商业合作伙伴。"',
                        'ar' => '"مناولة واردات بتكاليف واضحة ومدروسة، وفي الوقت المحدد. تستحق بجدارة أن تكون شريكك التجاري."'
                    ],
                    'rating' => 5,
                ],
                [
                    'name' => 'Mr. Jhonson',
                    'title' => [
                        'id' => 'GM — Anhui Imp & Export Co., Ltd',
                        'en' => 'GM — Anhui Imp & Export Co., Ltd',
                        'zh' => '总经理 — 安徽进出口有限公司',
                        'ar' => 'المدير العام — شركة آنهوي للاستيراد والتصدير المحدودة'
                    ],
                    'quote' => [
                        'id' => '"Game-changer bagi bisnis kami! Tim di M2B sangat andal, efisien, dan selalu responsif."',
                        'en' => '"Game-changer for our business! The team at M2B is reliable, efficient, and always responsive."',
                        'zh' => '"这是我们业务的变革者！M2B 的团队非常可靠、高效，且始终能快速响应。"',
                        'ar' => '"نقلة نوعية لعملنا! الفريق in M2B موثوق وفعال ومتجاوب دائماً."'
                    ],
                    'rating' => 5,
                ],
                [
                    'name' => 'Sarah Aulia',
                    'title' => [
                        'id' => 'Online Business Owner — Medan',
                        'en' => 'Online Business Owner — Medan',
                        'zh' => '电商主 — 棉兰',
                        'ar' => 'صاحبة عمل تجari عبر الإنترنت — ميدان'
                    ],
                    'quote' => [
                        'id' => '"Tim M2B sangat suportif dan transparan. Tidak ada biaya tersembunyi — ini yang kami cari."',
                        'en' => '"M2B team is very supportive and transparent. No hidden fees — exactly what we were looking for."',
                        'zh' => '"M2B 团队非常给予支持且高度透明。没有任何隐藏费用——这正是我们所寻找ของ。"',
                        'ar' => '"فريق M2B متعاون وشفاف للغاية. لا توجد رسوم خفية — هذا بالضبط ما كنا نبحث عنه."'
                    ],
                    'rating' => 5,
                ]
            ];
        }

        return view("pages.home", compact("latestPosts", "rates", "fieldPhotos", "testimonials"));
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
