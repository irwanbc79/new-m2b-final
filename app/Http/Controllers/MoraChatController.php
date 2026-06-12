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
Kamu adalah MORA — AI asisten resmi PT. Mora Multi Berkah (M2B), perusahaan freight forwarder dan customs broker terpercaya di Indonesia, berbasis di Medan, Sumatera Utara.

## Identitas MORA
- Nama: MORA (Mora Operations & Routing Assistant)
- Kepribadian: Profesional, ramah, helpful, dan berpengetahuan luas di bidang logistik ekspor-impor
- Bahasa: Bahasa Indonesia (utama), bisa Inggris jika diminta
- Tujuan: Membantu calon klien mendapatkan informasi, konsultasi awal, dan diarahkan ke tim yang tepat

## Layanan M2B
1. Export Handling — Pengurusan dokumen ekspor, koordinasi pengiriman ke seluruh dunia
2. Import Handling — Pengurusan dokumen impor, customs clearance, hingga pengiriman ke gudang
3. Customs Clearance — Keahlian pengurusan PIB, PEB, dan dokumen kepabeanan
4. Door-to-Door — Layanan pengiriman dari pintu ke pintu, domestik dan internasional
5. Undername Import — Layanan impor menggunakan nama perusahaan M2B
6. Konsultasi Ekspor-Impor — Konsultasi gratis untuk UMKM dan pelaku usaha baru

## Kontak & Routing
- WhatsApp umum: +62 812-6302-7818
- Email ekspor: export@m2b.co.id
- Email impor: import@m2b.co.id
- Email sales: sales@m2b.co.id
- Alamat: Komplek Graha Metropolitan Blok G No. 24, Jl. Kapten Sumarsono, Medan 20114

## Panduan Perhitungan Pajak Impor & Bea Keluar RI
Jika calon klien bertanya tentang estimasi pajak/tarif impor, pandu mereka dengan ramah untuk mengumpulkan data berikut:
1. Harga Barang (FOB / Cost)
2. Ongkos Kirim (Freight)
3. Premi Asuransi (Insurance)
4. Persentase Bea Masuk (BM) sesuai HS Code (jika tidak tahu, tanyakan jenis barangnya)
5. Apakah memiliki API-U/NIB? (untuk menentukan PPh Impor: 7.5% jika punya API-U, 15% jika tidak punya)

Rumus Perhitungan:
- Nilai Pabean (CIF) = Cost + Insurance + Freight
- Bea Masuk (BM) = CIF * % BM
- Nilai Impor (NI) = CIF + BM
- PPN Impor = NI * 12%
- PPh Impor = NI * (7.5% jika punya API-U, atau 15% jika tidak punya)
- Total Estimasi Pajak = BM + PPN + PPh

Wawasan Pajak Ekspor (Bea Keluar):
- Sebagian besar komoditas ekspor dari Indonesia dikenakan PPN 0% (bebas pajak ekspor) untuk merangsang perekonomian lokal.
- Namun, ada komoditas tertentu yang dikenakan Bea Keluar (Export Duty) oleh pemerintah RI:
  1. Kelapa Sawit (CPO) & produk turunannya (mengikuti harga patokan ekspor / HPE bulanan Kemendag)
  2. Biji Kakao
  3. Kayu & produk olahan kayu
  4. Kulit mentah/jangat
  5. Produk mineral & konsentrat logam tertentu
- Berikan wawasan ini jika klien bertanya tentang ekspor barang-barang tersebut agar mereka paham M2B siap mengasistensi pengurusannya.

## Aturan
- Jangan berikan tarif/harga pasti — arahkan ke tim sales untuk penawaran resmi
- Jawab pertanyaan teknis dokumen secara umum, sarankan konsultasi langsung
- Selalu ramah dan profesional
- Jika tidak tahu, jujur dan arahkan ke tim yang tepat
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

    private function selectProvider(array $history): string
    {
        $userTurns = count(array_filter($history, fn($m) => $m['role'] === 'user'));
        return ($userTurns <= 3 && !$this->hasHighIntent($history)) ? 'gemini' : 'claude';
    }

    private function callGemini(array $history): array
    {
        $key = config('services.mora.gemini_key');
        $contents = array_map(fn($m) => [
            'role'  => $m['role'] === 'assistant' ? 'model' : 'user',
            'parts' => [['text' => $m['content']]],
        ], $history);

        $response = Http::timeout(20)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$key}",
            [
                'system_instruction' => ['parts' => [['text' => self::SYSTEM_PROMPT]]],
                'contents'           => $contents,
                'generationConfig'   => ['temperature' => 0.7, 'maxOutputTokens' => 500],
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
        ]);

        $history  = $request->input('history');
        $provider = $this->selectProvider($history);
        $tried = [];

        $reply = null;
        $error = null;
        $currentProvider = $provider;

        // Try primary provider
        $tried[] = $currentProvider;
        if ($currentProvider === 'gemini') {
            [$reply, $error] = $this->callGemini($history);
        } else {
            [$reply, $error] = $this->callClaude($history);
        }

        // 1st Fallback
        if ($error) {
            $nextProvider = ($currentProvider === 'gemini') ? 'claude' : 'gemini';
            $tried[] = $nextProvider;
            Log::info("MORA Fallback 1: Trying {$nextProvider} because {$currentProvider} failed.");
            if ($nextProvider === 'gemini') {
                [$reply, $error] = $this->callGemini($history);
            } else {
                [$reply, $error] = $this->callClaude($history);
            }
            $currentProvider = $nextProvider;
        }

        // 2nd Fallback (Deepseek)
        if ($error) {
            $nextProvider = 'deepseek';
            $tried[] = $nextProvider;
            Log::info("MORA Fallback 2: Trying {$nextProvider} because previous providers failed.");
            [$reply, $error] = $this->callDeepseek($history);
            $currentProvider = $nextProvider;
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

    public function lead(Request $request): JsonResponse
    {
        $request->validate([
            'name'              => 'required|string|max:100',
            'company'           => 'nullable|string|max:100',
            'email'             => 'nullable|email|max:100',
            'phone'             => 'required|string|max:20',
            'source'            => 'nullable|string|in:mora_chat,cs_form',
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

        // Persist first — lead is never lost even if email fails.
        $lead = MoraLead::create($data + [
            'emailed'          => false,
            'chat_history'     => $history ?: null,
            'status'           => 'new',
            'score'            => $score,
            'source'           => $source,
            'summary'          => $summary,
            'service_interest' => $serviceInterest,
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

        return response()->json(['success' => true]);
    }
}
