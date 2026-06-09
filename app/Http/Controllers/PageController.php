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

        // Fetch field photos dynamically from portal database
        $fieldPhotos = collect([]);
        try {
            $photosPool = \Illuminate\Support\Facades\DB::connection('portal')
                ->table('field_photos as fp')
                ->join('shipments as s', 'fp.shipment_id', '=', 's.id')
                ->where('fp.status', 'approved')
                ->whereNotNull('fp.file_path')
                ->where('fp.file_path', '!=', '')
                ->select(
                    'fp.id',
                    'fp.shipment_id',
                    'fp.file_path',
                    'fp.description as photo_description',
                    's.shipment_type',
                    's.service_type',
                    's.origin',
                    's.destination',
                    's.commodity'
                )
                ->orderBy('fp.id', 'desc')
                ->limit(35) // Query recent 35 photos
                ->get();

            if ($photosPool->isNotEmpty()) {
                $fieldPhotos = $photosPool->unique('shipment_id')
                    ->shuffle()
                    ->take(6)
                    ->map(function ($photo) {
                        $photo->url = 'https://portal.m2b.co.id/storage/' . $photo->file_path;
                        
                        $direction = '';
                        if ($photo->service_type === 'import') {
                            $direction = 'Import';
                        } elseif ($photo->service_type === 'export') {
                            $direction = 'Export';
                        } elseif ($photo->service_type === 'domestic') {
                            $direction = 'Domestic';
                        } else {
                            $direction = ucfirst($photo->service_type);
                        }

                        $mode = '';
                        if ($photo->shipment_type === 'sea') {
                            $mode = '🌊 Sea Freight';
                        } elseif ($photo->shipment_type === 'air') {
                            $mode = '✈️ Air Freight';
                        } elseif ($photo->shipment_type === 'land') {
                            $mode = '🚛 Land Transport';
                        } else {
                            $mode = '📦 Logistics';
                        }

                        $photo->badge = $mode . ' - ' . $direction;
                        
                        $desc = trim($photo->photo_description);
                        if (empty($desc)) {
                            $desc = 'Penanganan pengiriman kargo ' . ($photo->commodity ?: 'logistik') . ' dari ' . $photo->origin . ' ke ' . $photo->destination;
                        }
                        $photo->title = $desc;
                        $photo->location = '📍 ' . $photo->origin . ' → ' . $photo->destination;
                        
                        return $photo;
                    })
                    ->values();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to load field photos from portal: ' . $e->getMessage());
        }

        // Fallback to high quality pre-curated photo assets if database is empty or connection fails
        if ($fieldPhotos->isEmpty()) {
            $fallbackPhotos = [
                [
                    'url' => 'https://portal.m2b.co.id/storage/field-photos/2026/06/111/1780378406_qjvUQslV.jpg',
                    'badge' => '🌊 Sea Freight - Import',
                    'title' => 'Pemeriksaan Fisik Jalur Merah oleh Petugas Bea Cukai & Tim Lapangan M2B',
                    'location' => '📍 Shanghai, China → Belawan, Indonesia',
                ],
                [
                    'url' => 'https://portal.m2b.co.id/storage/field-photos/2026/05/110/1778659396_dkc49m8H.jpg',
                    'badge' => '✈️ Air Freight - Import',
                    'title' => 'Handling Kargo Udara Komoditas Impor di Terminal Kargo KNO',
                    'location' => '📍 Kuala Lumpur, Malaysia → KNO, Indonesia',
                ],
                [
                    'url' => 'https://portal.m2b.co.id/storage/field-photos/2026/04/92/1777022144_0N67z2J0.jpg',
                    'badge' => '🌊 Sea Freight - Export',
                    'title' => 'Pemuatan Kontainer FCL 40ft untuk Ekspor Komoditas Hasil Bumi',
                    'location' => '📍 Belawan, Indonesia → Abu Dhabi, UAE',
                ],
                [
                    'url' => 'https://portal.m2b.co.id/storage/field-photos/2026/04/104/1776326866_CnPfLj0R.jpg',
                    'badge' => '🚛 Land Transport - Domestic',
                    'title' => 'Pengiriman Kontainer Domestik Menggunakan Armada Trucking M2B',
                    'location' => '📍 Belawan → Medan, Indonesia',
                ],
                [
                    'url' => 'https://portal.m2b.co.id/storage/field-photos/2026/04/96/1776865058_xbbqqSob.jpg',
                    'badge' => '🌊 Sea Freight - Import',
                    'title' => 'Stuffing Inspection dan Pemuatan Kargo di Gudang Konsolidasi',
                    'location' => '📍 Shanghai, China → Belawan, Indonesia',
                ],
                [
                    'url' => 'https://portal.m2b.co.id/storage/field-photos/2026/04/92/1777088659_RSGuHScw.jpg',
                    'badge' => '🌊 Sea Freight - Export',
                    'title' => 'Pemuatan Kontainer Ekspor di Terminal Peti Kemas Belawan',
                    'location' => '📍 Belawan, Indonesia → Abu Dhabi, UAE',
                ]
            ];
            $fieldPhotos = collect($fallbackPhotos)->map(fn($p) => (object) $p);
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
