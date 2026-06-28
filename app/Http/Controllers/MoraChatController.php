<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Models\MoraLead;
use App\Mail\MoraLeadMail;

class MoraChatController extends Controller
{
    private const SYSTEM_PROMPT = <<<'PROMPT'
Kamu adalah MORA 2.0 (Mora Operations & Routing Assistant) — AI asisten dan konsultan kepabeanan resmi dari PT. Mora Multi Berkah (M2B), perusahaan freight forwarder dan customs broker terpercaya di Indonesia yang berbasis di Medan.

## Identitas & Gaya Komunikasi
- **Gaya:** Profesional, ramah, persuasif, taktis, dan sangat berpengetahuan tentang aturan ekspor-impor Bea Cukai Indonesia.
- **Tugas Utama:** Memberikan analisis awal (prediksi HS Code, Lartas, kalkulasi bea masuk) berdasarkan foto produk atau deskripsi singkat yang diberikan pengunjung, lalu mengarahkan mereka untuk menggunakan jasa M2B.

## Layanan Utama M2B
1. **Customs Clearance:** PIB (Pemberitahuan Impor Barang) & PEB (Pemberitahuan Ekspor Barang).
2. **Freight Forwarding:** Layanan Door-to-Door & Port-to-Port (LCL / FCL) udara dan laut.
3. **Undername Import (Izin Impor Konsinyasi):** Pinjam bendera perusahaan M2B bagi importir tanpa NIB/API-U.
4. **Asistensi Lartas:** Penanganan dokumen pembatasan secara legal.

## Fitur Unggulan: Impor Praktis via Link / Tautan Produk (All-in-One)
Jika pengunjung menyebutkan, menyalin, atau bertanya tentang proses impor menggunakan **link / tautan produk dari supplier luar negeri** (misalnya dari Alibaba, 1688, Taobao, Amazon, AliExpress, dll.):
- Katakan dengan antusias bahwa mereka **CUKUP memberikan link produk tersebut** kepada M2B.
- Jelaskan bahwa PT. Mora Multi Berkah (M2B) akan mengurus seluruh proses impor dari hulu ke hilir (End-to-End):
  1. **Komunikasi Supplier & Incoterms:** M2B berkomunikasi langsung dengan supplier luar negeri Anda mengenai term penyerahan kargo (apakah EXW / Ex Works atau FOB / Free on Board).
  2. **Customs Clearance:** M2B mengurus seluruh dokumen kepabeanan impor (PIB) dan proses kepabeanan Bea Cukai di Indonesia.
  3. **Estimasi Pajak:** M2B menghitung estimasi seluruh bea masuk dan pajak impor resmi.
  4. **Last-Mile Delivery:** Kargo dikirim langsung dari bandara/pelabuhan masuk ke pintu alamat gudang Anda (Door-to-Door).
- **Pengikatan Leads (Lead Locking):** Jelaskan bahwa agar tim impor M2B dapat langsung menganalisis link produk tersebut, bernegosiasi dengan supplier Anda, dan membuatkan penawaran harga resmi, pengunjung **wajib mengisi data kontak mereka** (Nama & No WA) pada form yang muncul di bawah chat.

## Alur Analisis Kepabeanan & Prediksi MORA 2.0 (Jika Mengunggah Gambar / Deskripsi)
Jika pengunjung mengunggah foto produk atau mendeskripsikan produknya:
1. **Prediksi HS Code (AHTN/BTKI):**
   - Lakukan analisis jenis barang. Prediksikan HS Code 8-digit yang paling mendekati (misal: "Mainan plastik berbentuk hewan kemungkinan masuk HS Code 9503.00.99").
   - Sertakan tingkat keyakinan (Confidence Level) AI (misal: "Tingkat Keyakinan AI: 85%").
   - Berikan alasan klasifikasi singkat mengapa barang tersebut dimasukkan ke pos tarif tersebut.
2. **Deteksi Lartas (Larangan & Pembatasan):**
   - Berikan informasi mengenai lartas produk tersebut di Bea Cukai RI.
   - Sebutkan instansi terkait yang menerbitkan izinnya (contoh: BPOM untuk kosmetik/makanan/suplemen, SNI untuk helm/mainan anak/elektronik rumah tangga, Kementerian Kesehatan untuk Alkes, Persetujuan Impor (PI) dari Kemendag untuk tekstil/besi baja, Laporan Surveyor (LS) untuk garmen).
   - **Batas Jualan (Sales Gate):** JANGAN memberikan detail panduan langkah demi langkah cara mengurus izin lartas tersebut. Sebaliknya, katakan bahwa M2B memiliki layanan pengurusan Lartas resmi agar impor berjalan legal tanpa hambatan di pelabuhan.
3. **Estimasi Perhitungan Bea Masuk & Pajak Impor:**
   - Gunakan data nilai barang (FOB), Freight, dan Insurance jika disebutkan pengguna.
   - Jika pengguna tidak menyebutkan nilai barang, berikan simulasi kalkulasi pajak menggunakan contoh nilai barang **USD 1,000** (freight USD 100, insurance USD 10) dengan asumsi Bea Masuk 10% (sesuaikan jika produknya punya BM spesifik).
   - Hitung dengan rumus berikut:
     * **Nilai Pabean (CIF)** = FOB + Insurance + Freight
     * **Bea Masuk (BM)** = CIF * % BM (gunakan persentase BM standar produk terkait)
     * **Nilai Impor (NI)** = CIF + BM
     * **PPN Impor** = NI * 12% (PPN Indonesia terbaru)
     * **PPh Impor (Pasal 22):** Berikan 2 skema: 7.5% jika importir memiliki API-U (NIB Impor), atau 15% jika tidak memiliki API-U (atau 0.5% jika menggunakan undername M2B yang punya fasilitas khusus).
     * Tampilkan hasil perhitungan dalam **Tabel Markdown** yang bersih.

## Batasan Jualan & Disclaimer Wajib (Non-Negotiable)
Setiap kali selesai memberikan prediksi HS Code, Lartas, atau kalkulasi pajak, kamu **wajib** menutup jawabanmu dengan dua bagian berikut:

> ⚠️ **Disclaimer Penting:** Hasil klasifikasi HS Code, Lartas, dan kalkulasi di atas adalah prediksi awal berbasis AI. Salah klasifikasi HS Code di Bea Cukai berisiko terkena sanksi administratif/denda (Notul). Untuk kepastian hukum dan validasi tarif resmi, Anda disarankan menggunakan jasa verifikasi resmi kami.

> 💼 **Penawaran Solusi M2B:**
> - **GRATIS 100%:** Layanan analisis klasifikasi HS Code & Lartas resmi Bea Cukai tidak dikenakan biaya apa pun jika Anda mempercayakan pengapalan barang (Freight Forwarding, Clearance, atau Undername) Anda melalui M2B.
> - **Layanan Studi Kelayakan (Rp 150.000,-):** Jika Anda hanya memerlukan riset mendalam klasifikasi HS & regulasi Lartas Bea Cukai untuk riset pasar tanpa pengiriman barang.
> 
> *Arahkan pengguna: "Silakan kirim detail kontak Anda (Nama & No WA) di form di bawah ini agar tim Customs Broker M2B dapat memvalidasi dokumen Anda sekarang!"*

## Kontak & Alamat Resmi
- WhatsApp Hubungi: +62 812-6302-7818
- Alamat Kantor: Komplek Graha Metropolitan Blok G No. 24, Jl. Kapten Sumarsono, Medan 20114.
PROMPT;

    private const HIGH_INTENT_KEYWORDS = [
        'harga','biaya','tarif','penawaran','quote','rate','ongkos','ongkir',
        'cost','fee','bayar','bayaran','berapa','paket','promo','diskon',
    ];

    private function hasHighIntent(array $history): bool
    {
        $text = strtolower(implode(' ', array_column($history, 'content')));
        foreach (self::HIGH_INTENT_KEYWORDS as $kw) {
            if (str_contains($text, $kw)) return true;
        }
        return false;
    }

    private function selectProvider(array $history, ?array $image = null): string
    {
        // Images need a vision model — Gemini handles inline image data here.
        if ($image) return 'gemini';
        // Text conversations are handled by OpenAI gpt-5.4-mini as the primary model.
        return 'openai';
    }

    /** Dispatch a chat turn to the given provider. Returns [reply, error]. */
    private function callProvider(string $provider, array $history, ?array $image = null): array
    {
        return match ($provider) {
            'openai'   => $this->callOpenAI($history),
            'gemini'   => $this->callGemini($history, $image),
            'claude'   => $this->callClaude($history),
            'deepseek' => $this->callDeepseek($history),
            default    => ['', 'unknown_provider'],
        };
    }

    private function callOpenAI(array $history): array
    {
        $key = config('services.mora.openai_key');
        if (!$key) {
            Log::warning('MORA OpenAI API key is missing');
            return ['', 'openai_key_missing'];
        }
        $model = config('services.mora.openai_model', 'gpt-5.4-mini');

        $messages = [['role' => 'system', 'content' => self::SYSTEM_PROMPT]];
        foreach ($history as $m) {
            $messages[] = ['role' => $m['role'], 'content' => $m['content']];
        }

        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => "Bearer {$key}",
                'Content-Type'  => 'application/json',
            ])
            ->post('https://api.openai.com/v1/chat/completions', [
                'model'                 => $model,
                'messages'              => $messages,
                // gpt-5.x family requires max_completion_tokens (max_tokens rejected).
                'max_completion_tokens' => 800,
            ]);

        if ($response->failed()) {
            Log::warning('MORA OpenAI API failed', [
                'status' => $response->status(),
                'error'  => $response->body(),
            ]);
            return ['', 'openai_error'];
        }
        return [$response->json('choices.0.message.content', ''), null];
    }

    private function callGemini(array $history, ?array $image = null): array
    {
        $key = config('services.mora.gemini_key');
        
        $contents = [];
        foreach ($history as $index => $m) {
            $role = $m['role'] === 'assistant' ? 'model' : 'user';
            $parts = [['text' => $m['content']]];
            
            if ($role === 'user' && $index === count($history) - 1 && $image) {
                $parts[] = [
                    'inlineData' => [
                        'mimeType' => $image['mimeType'],
                        'data'     => $image['data'],
                    ]
                ];
            }
            
            $contents[] = [
                'role'  => $role,
                'parts' => $parts,
            ];
        }

        $response = Http::timeout(25)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$key}",
            [
                'system_instruction' => ['parts' => [['text' => self::SYSTEM_PROMPT]]],
                'contents'           => $contents,
                'generationConfig'   => ['temperature' => 0.7, 'maxOutputTokens' => 800],
            ]
        );

        if ($response->failed()) {
            Log::warning('MORA Gemini API failed', [
                'status' => $response->status(),
                'error'  => $response->body()
            ]);
            return ['', 'gemini_error'];
        }
        return [$response->json('candidates.0.content.parts.0.text', ''), null];
    }

    private function callClaude(array $history): array
    {
        $key = config('services.mora.claude_key');
        $messages = array_map(fn($m) => [
            'role'    => $m['role'],
            'content' => $m['content'],
        ], $history);

        $response = Http::timeout(30)
            ->withHeaders([
                'x-api-key'         => $key,
                'anthropic-version' => '2023-06-01',
                'anthropic-beta'    => 'prompt-caching-2024-07-31',
            ])
            ->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-haiku-4-5-20251001',
                'max_tokens' => 500,
                'system'     => [[
                    'type'          => 'text',
                    'text'          => self::SYSTEM_PROMPT,
                    'cache_control' => ['type' => 'ephemeral'],
                ]],
                'messages' => $messages,
            ]);

        if ($response->failed()) {
            Log::warning('MORA Claude API failed', [
                'status' => $response->status(),
                'error'  => $response->body()
            ]);
            return ['', 'claude_error'];
        }
        return [$response->json('content.0.text', ''), null];
    }

    private function callDeepseek(array $history): array
    {
        $key = config('services.mora.deepseek_key');
        if (!$key) {
            Log::warning('MORA Deepseek API key is missing');
            return ['', 'deepseek_key_missing'];
        }

        $messages = [];
        $messages[] = [
            'role' => 'system',
            'content' => self::SYSTEM_PROMPT
        ];
        foreach ($history as $m) {
            $messages[] = [
                'role' => $m['role'],
                'content' => $m['content']
            ];
        }

        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => "Bearer {$key}",
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.deepseek.com/chat/completions', [
                'model'      => 'deepseek-chat',
                'messages'   => $messages,
                'max_tokens' => 500,
                'temperature'=> 0.7,
            ]);

        if ($response->failed()) {
            Log::warning('MORA Deepseek API failed', [
                'status' => $response->status(),
                'error'  => $response->body()
            ]);
            return ['', 'deepseek_error'];
        }
        return [$response->json('choices.0.message.content', ''), null];
    }

    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'history'           => 'required|array|min:1|max:30',
            'history.*.role'    => 'required|in:user,assistant',
            'history.*.content' => 'required|string|max:2000',
            'image'             => 'nullable|array',
            'image.data'        => 'required_with:image|string',
            'image.mimeType'    => 'required_with:image|string|in:image/jpeg,image/png,image/webp,image/gif',
        ]);

        $history  = $request->input('history');
        $image    = $request->input('image');
        $primary  = $this->selectProvider($history, $image);

        // Fallback order. Images: only Gemini does vision here, so lead with it.
        // Text: OpenAI gpt-5.4-mini primary, then graceful fallback to the rest.
        $order = $image
            ? ['gemini', 'claude', 'deepseek']
            : array_values(array_unique([$primary, 'openai', 'gemini', 'claude', 'deepseek']));

        $reply = null;
        $error = null;
        $tried = [];
        $currentProvider = null;

        foreach ($order as $p) {
            $tried[] = $p;
            $currentProvider = $p;
            [$reply, $error] = $this->callProvider($p, $history, $image);
            if (!$error && $reply) {
                break;
            }
            Log::info("MORA provider '{$p}' failed ({$error}); trying next.");
        }

        if (!$reply) {
            Log::error('MORA Chat failed completely. All providers failed.', [
                'history' => $history,
                'tried'   => $tried
            ]);
            return response()->json(['error' => 'Maaf, layanan sedang tidak tersedia. Silakan hubungi kami via WhatsApp.'], 503);
        }

        return response()->json(['reply' => $reply, 'provider' => $currentProvider]);
    }

    private function detectServiceInterest(array $history): ?string
    {
        if (empty($history)) return null;

        $text = strtolower(implode(' ', array_column($history, 'content')));

        $map = [
            'undername'    => ['undername', 'under name', 'pinjam nama'],
            'customs'      => ['bea cukai', 'customs', 'clearance', 'pib', 'peb', 'kepabeanan'],
            'door_to_door' => ['door to door', 'pintu ke pintu', 'd2d', 'dtd'],
            'export'       => ['ekspor', 'export', 'peb', 'bea keluar'],
            'import'       => ['impor', 'import', 'pib', 'bea masuk'],
            'consultation' => ['konsultasi', 'tanya', 'info', 'informasi'],
        ];

        foreach ($map as $service => $keywords) {
            foreach ($keywords as $kw) {
                if (str_contains($text, $kw)) return $service;
            }
        }
        return null;
    }

    private function scoreChat(array $history): string
    {
        if (empty($history)) return 'cold';

        $text = strtolower(implode(' ', array_column($history, 'content')));

        $hotKeywords  = ['harga','biaya','tarif','penawaran','quote','rate','ongkos','berapa','segera','urgent','cepat','besok','minggu ini','sekarang','cost','fee'];
        $warmKeywords = ['ekspor','impor','undername','bea cukai','dokumen','pengiriman','door to door','layanan','service','clearance','pib','peb','customs'];

        foreach ($hotKeywords as $kw) {
            if (str_contains($text, $kw)) return 'hot';
        }
        foreach ($warmKeywords as $kw) {
            if (str_contains($text, $kw)) return 'warm';
        }
        return 'cold';
    }

    private function generateSummary(array $history): ?string
    {
        if (empty($history)) return null;

        $transcript = collect($history)
            ->map(fn($m) => ($m['role'] === 'user' ? 'Pengunjung' : 'MORA') . ': ' . $m['content'])
            ->implode("\n");

        $prompt = "Berikut adalah transkrip percakapan antara pengunjung website dan MORA (AI asisten M2B freight forwarder):\n\n{$transcript}\n\nBuat ringkasan singkat 2-3 kalimat dalam Bahasa Indonesia yang menjelaskan: apa kebutuhan/pertanyaan utama pengunjung, layanan apa yang relevan, dan seberapa serius minat mereka. Langsung tulis ringkasannya tanpa pembuka.";

        $key      = config('services.mora.gemini_key');
        $response = Http::timeout(15)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$key}",
            [
                'contents'         => [['role' => 'user', 'parts' => [['text' => $prompt]]]],
                'generationConfig' => ['temperature' => 0.4, 'maxOutputTokens' => 150],
            ]
        );

        if ($response->failed()) return null;
        return $response->json('candidates.0.content.parts.0.text') ?: null;
    }

    private function notifyPortal(MoraLead $lead): void
    {
        $url    = config('services.mora.portal_webhook');
        $secret = config('services.mora.portal_secret');

        if (!$url) return;

        try {
            Http::timeout(5)
                ->withHeaders(['X-Mora-Secret' => $secret])
                ->post($url, [
                    'remote_lead_id'   => $lead->id,
                    'name'             => $lead->name,
                    'company'          => $lead->company,
                    'phone'            => $lead->phone,
                    'email'            => $lead->email,
                    'score'            => $lead->score,
                    'source'           => $lead->source,
                    'service_interest' => $lead->service_interest,
                    'product_links'    => $lead->product_links,
                    'summary'          => $lead->summary,
                    'chat_history'     => $lead->chat_history,
                ]);
        } catch (\Throwable $e) {
            Log::warning('MORA portal webhook gagal (lead aman di DB)', [
                'lead_id' => $lead->id,
                'error'   => $e->getMessage(),
            ]);
        }
    }

    private function extractProductLinks(array $history): ?string
    {
        if (empty($history)) return null;

        $links = [];
        foreach ($history as $msg) {
            if (($msg['role'] ?? '') !== 'user') continue;
            
            $content = $msg['content'] ?? '';
            
            // 1. Match absolute URLs with http/https
            if (preg_match_all('/\bhttps?:\/\/[^\s<>"\']+/i', $content, $matches)) {
                foreach ($matches[0] as $url) {
                    $links[] = $url;
                }
            }
            
            // 2. Match common supplier domains without protocol (e.g. 1688.com/item/123, alibaba.com/...)
            $domainPattern = '/\b(?:1688|taobao|alibaba|aliexpress|amazon|ebay|made-in-china)\.[a-z]{2,}(?:\/[^\s<>"\']*)?/i';
            if (preg_match_all($domainPattern, $content, $matches)) {
                foreach ($matches[0] as $url) {
                    // Check if it's already captured with protocol
                    $alreadyCaptured = false;
                    foreach ($links as $existing) {
                        if (str_contains($existing, $url)) {
                            $alreadyCaptured = true;
                            break;
                        }
                    }
                    if (!$alreadyCaptured) {
                        $links[] = 'https://' . $url;
                    }
                }
            }
        }
        
        return !empty($links) ? implode(', ', array_unique($links)) : null;
    }

    public function lead(Request $request): JsonResponse
    {
        $request->validate([
            'name'              => 'required|string|max:100',
            'company'           => 'nullable|string|max:100',
            'email'             => 'nullable|email|max:100',
            'phone'             => 'required|string|max:20',
            'source'            => 'nullable|string|in:mora_chat,cs_form,cs_form_whatsapp,cs_form_telegram',
            'history'           => 'nullable|array|max:40',
            'history.*.role'    => 'required_with:history|in:user,assistant',
            'history.*.content' => 'required_with:history|string|max:2000',
        ]);

        $data    = $request->only(['name', 'company', 'email', 'phone']);
        $history = $request->input('history', []);
        $source  = $request->input('source', 'mora_chat');

        $score           = $this->scoreChat($history);
        $summary         = $this->generateSummary($history);
        $serviceInterest = $this->detectServiceInterest($history);
        $productLinks    = $this->extractProductLinks($history);

        // Persist first — lead is never lost even if email fails.
        $lead = MoraLead::create($data + [
            'emailed'          => false,
            'chat_history'     => $history ?: null,
            'status'           => 'new',
            'score'            => $score,
            'source'           => $source,
            'summary'          => $summary,
            'service_interest' => $serviceInterest,
            'product_links'    => $productLinks,
        ]);

        try {
            Mail::to('mora.multiberkah@gmail.com')->send(new MoraLeadMail($lead));
            $lead->update(['emailed' => true]);
        } catch (\Throwable $e) {
            Log::error('MORA lead email gagal (lead tetap tersimpan di DB)', [
                'lead_id' => $lead->id,
                'error'   => $e->getMessage(),
            ]);
        }

        // Kirim ke portal.m2b.co.id agar tim sales bisa pantau dari satu tempat.
        $this->notifyPortal($lead->refresh());

        return response()->json(['success' => true]);
    }
}
