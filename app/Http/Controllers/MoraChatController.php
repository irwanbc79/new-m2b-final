<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

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
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key={$key}",
            [
                'system_instruction' => ['parts' => [['text' => self::SYSTEM_PROMPT]]],
                'contents'           => $contents,
                'generationConfig'   => ['temperature' => 0.7, 'maxOutputTokens' => 500],
            ]
        );

        if ($response->failed()) return ['', 'gemini_error'];
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

        if ($response->failed()) return ['', 'claude_error'];
        return [$response->json('content.0.text', ''), null];
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

        [$reply, $error] = $provider === 'gemini'
            ? $this->callGemini($history)
            : $this->callClaude($history);

        // Fallback: if gemini fails, try claude
        if ($error && $provider === 'gemini') {
            [$reply, $error] = $this->callClaude($history);
        }

        if (!$reply) {
            return response()->json(['error' => 'Maaf, layanan sedang tidak tersedia. Silakan hubungi kami via WhatsApp.'], 503);
        }

        return response()->json(['reply' => $reply, 'provider' => $provider]);
    }

    public function lead(Request $request): JsonResponse
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'company' => 'nullable|string|max:100',
            'email'   => 'nullable|email|max:100',
            'phone'   => 'required|string|max:20',
        ]);

        $data = $request->only(['name', 'company', 'email', 'phone']);
        $body = "Lead baru dari MORA Chat\n\n"
              . "Nama    : {$data['name']}\n"
              . "Perusahaan: " . ($data['company'] ?: '-') . "\n"
              . "Email   : " . ($data['email'] ?: '-') . "\n"
              . "HP/WA   : {$data['phone']}\n\n"
              . "Waktu   : " . now()->format('d M Y H:i') . " WIB";

        try {
            Mail::raw($body, fn($m) => $m
                ->to('mora.multiberkah@gmail.com')
                ->subject('Lead MORA Chat — ' . now()->format('d M Y'))
            );
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            // Jangan sampai lead hilang: catat data lengkap + error agar bisa di-recover manual
            Log::error('MORA lead gagal terkirim', [
                'lead'  => $data,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['success' => false], 500);
        }
    }
}
