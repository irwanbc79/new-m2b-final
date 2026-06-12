<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lead MORA Chat</title>
  <style>
    body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI',Arial,sans-serif; color:#1a202c; }
    .wrap { max-width:600px; margin:32px auto; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08); }
    .header { background:linear-gradient(135deg,#1e3a5f 0%,#2563eb 100%); padding:28px 32px; }
    .header-logo { font-size:22px; font-weight:800; color:#fff; letter-spacing:-0.5px; }
    .header-sub { font-size:12px; color:rgba(255,255,255,0.7); margin-top:2px; }
    .body { padding:28px 32px; }
    .badge-new { display:inline-block; background:#dbeafe; color:#1d4ed8; font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; margin-bottom:16px; letter-spacing:0.3px; }
    .section-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#94a3b8; margin:0 0 10px 0; }
    .info-card { background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px 20px; margin-bottom:20px; }
    .info-row { display:flex; gap:8px; align-items:baseline; padding:5px 0; border-bottom:1px solid #f1f5f9; }
    .info-row:last-child { border-bottom:none; }
    .info-label { font-size:11px; font-weight:700; color:#64748b; width:90px; flex-shrink:0; text-transform:uppercase; letter-spacing:0.4px; }
    .info-value { font-size:14px; color:#1e293b; font-weight:500; }
    .summary-card { background:linear-gradient(135deg,#fffbeb,#fef3c7); border:1px solid #fcd34d; border-radius:12px; padding:16px 20px; margin-bottom:20px; }
    .summary-text { font-size:14px; line-height:1.7; color:#78350f; }
    .chat-card { background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px 20px; margin-bottom:20px; }
    .chat-bubble { margin-bottom:10px; }
    .chat-bubble:last-child { margin-bottom:0; }
    .bubble-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:3px; }
    .bubble-user .bubble-label { color:#2563eb; }
    .bubble-mora .bubble-label { color:#0f766e; }
    .bubble-text { display:inline-block; padding:8px 14px; border-radius:12px; font-size:13px; line-height:1.55; max-width:100%; word-break:break-word; }
    .bubble-user .bubble-text { background:#dbeafe; color:#1e3a5f; border-bottom-left-radius:4px; }
    .bubble-mora .bubble-text { background:#ccfbf1; color:#134e4a; border-bottom-left-radius:4px; }
    .action-btn { display:inline-block; margin-top:4px; padding:12px 24px; background:#25D366; color:#fff; text-decoration:none; border-radius:10px; font-size:14px; font-weight:700; }
    .footer { background:#f8fafc; border-top:1px solid #e2e8f0; padding:16px 32px; font-size:11px; color:#94a3b8; text-align:center; }
  </style>
</head>
<body>
<div class="wrap">

  {{-- Header --}}
  <div class="header">
    <div class="header-logo">🤖 MORA Chat — M2B</div>
    <div class="header-sub">PT. Mora Multi Berkah · Freight Forwarder & Customs Broker</div>
  </div>

  <div class="body">
    @php
        $scoreEmoji = match($lead->score) { 'hot' => '🔥', 'warm' => '⚡', default => '📩' };
        $scoreLabel = match($lead->score) { 'hot' => 'Hot Lead', 'warm' => 'Warm Lead', default => 'Cold Lead' };
        $scoreBg    = match($lead->score) { 'hot' => '#fee2e2', 'warm' => '#fef3c7', default => '#dbeafe' };
        $scoreColor = match($lead->score) { 'hot' => '#991b1b', 'warm' => '#92400e', default => '#1d4ed8' };
        $sourceLabel = $lead->source === 'cs_form' ? 'CS Form' : 'MORA Chat';
        $phone = preg_replace('/[^0-9]/', '', $lead->phone);
        $phone = preg_replace('/^0/', '62', $phone);
    @endphp
    <div style="display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;">
        <span style="display:inline-block;background:{{ $scoreBg }};color:{{ $scoreColor }};font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px;">{{ $scoreEmoji }} {{ $scoreLabel }}</span>
        <span style="display:inline-block;background:#f0fdf4;color:#166534;font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px;">📩 Lead Baru · {{ $sourceLabel }}</span>
    </div>

    {{-- Data Kontak --}}
    <p class="section-title">Data Kontak</p>
    <div class="info-card">
      <div class="info-row">
        <span class="info-label">Nama</span>
        <span class="info-value">{{ $lead->name }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Perusahaan</span>
        <span class="info-value">{{ $lead->company ?: '—' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">HP / WA</span>
        <span class="info-value">{{ $lead->phone }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Email</span>
        <span class="info-value">{{ $lead->email ?: '—' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Waktu</span>
        <span class="info-value">{{ $lead->created_at->format('d M Y, H:i') }} WIB</span>
      </div>
    </div>

    {{-- AI Summary --}}
    @if($lead->summary)
    <p class="section-title">⚡ Ringkasan AI</p>
    <div class="summary-card">
      <p class="summary-text">{{ $lead->summary }}</p>
    </div>
    @endif

    {{-- Tombol WA --}}
    <p style="margin-bottom:16px;">
      <a href="https://wa.me/{{ $phone }}" class="action-btn">
        💬 Hubungi via WhatsApp
      </a>
    </p>

    {{-- Riwayat Percakapan --}}
    @if(!empty($lead->chat_history))
    <p class="section-title">💬 Riwayat Percakapan ({{ count($lead->chat_history) }} pesan)</p>
    <div class="chat-card">
      @foreach($lead->chat_history as $msg)
        @if($msg['role'] === 'user')
        <div class="chat-bubble bubble-user">
          <div class="bubble-label">Pengunjung</div>
          <div class="bubble-text">{{ $msg['content'] }}</div>
        </div>
        @else
        <div class="chat-bubble bubble-mora">
          <div class="bubble-label">MORA</div>
          <div class="bubble-text">{{ $msg['content'] }}</div>
        </div>
        @endif
      @endforeach
    </div>
    @endif

  </div>

  <div class="footer">
    Email ini dikirim otomatis oleh sistem MORA Chat · portal.m2b.co.id
  </div>

</div>
</body>
</html>
