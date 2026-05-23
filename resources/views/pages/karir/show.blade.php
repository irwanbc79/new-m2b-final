@extends('layouts.app')
@section('title', $career->title . ' — Karir M2B')
@section('description', 'Bergabunglah sebagai ' . $career->title . ' di PT. Mora Multi Berkah. Lihat detail posisi dan cara melamar.')

@section('content')
<div style="background:#0f0f14;padding:64px 40px 56px">
  <div style="max-width:1200px;margin:0 auto">
    <a href="{{ route('karir.index') }}" style="display:inline-flex;align-items:center;gap:8px;color:#4a9eda;text-decoration:none;font-size:14px;margin-bottom:24px">← Kembali ke Karir</a>
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px">
      @if($career->department)<span style="padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">{{ $career->department }}</span>@endif
      <span style="padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">{{ ucfirst($career->type) }}</span>
    </div>
    <h1 style="font-family:Syne;font-weight:800;font-size:44px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1">{{ $career->title }}</h1>
    <div style="display:flex;gap:20px;font-size:14px;color:rgba(255,255,255,0.55);flex-wrap:wrap">
      <span>📍 {{ $career->location }}</span>
      @if($career->deadline)<span>⏰ Deadline: {{ $career->deadline->format('d M Y') }}</span>@endif
    </div>
  </div>
</div>

<section style="padding:60px 40px;background:#f7f5f0">
  <div style="max-width:960px;margin:0 auto;display:grid;grid-template-columns:1.6fr 1fr;gap:40px;align-items:start">
    <div>
      @if($career->description)
      <div style="background:#fff;border-radius:16px;padding:36px;border:1px solid #e5e2dc;margin-bottom:24px">
        <h2 style="font-family:Syne;font-weight:800;font-size:20px;color:#0f0f14;margin-bottom:16px">📋 Deskripsi Pekerjaan</h2>
        <div style="font-size:15px;color:#555;line-height:1.85">{!! nl2br(e($career->description)) !!}</div>
      </div>
      @endif
      @if($career->requirements)
      <div style="background:#fff;border-radius:16px;padding:36px;border:1px solid #e5e2dc;margin-bottom:24px">
        <h2 style="font-family:Syne;font-weight:800;font-size:20px;color:#0f0f14;margin-bottom:16px">✅ Persyaratan</h2>
        <div style="font-size:15px;color:#555;line-height:1.85">{!! nl2br(e($career->requirements)) !!}</div>
      </div>
      @endif
      @if($career->benefits)
      <div style="background:#fff;border-radius:16px;padding:36px;border:1px solid #e5e2dc">
        <h2 style="font-family:Syne;font-weight:800;font-size:20px;color:#0f0f14;margin-bottom:16px">🎁 Benefit & Fasilitas</h2>
        <div style="font-size:15px;color:#555;line-height:1.85">{!! nl2br(e($career->benefits)) !!}</div>
      </div>
      @endif
    </div>
    <div style="position:sticky;top:100px">
      <div style="background:#fff;border-radius:16px;padding:28px;border:1px solid #e5e2dc;box-shadow:0 8px 32px rgba(0,0,0,0.06)">
        <h3 style="font-family:Syne;font-weight:800;font-size:18px;color:#0f0f14;margin-bottom:20px">Lamar Posisi Ini</h3>
        <div style="margin-bottom:20px;padding:16px;background:#f7f5f0;border-radius:10px">
          <div style="font-size:11px;color:#999;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">Posisi</div>
          <div style="font-weight:700;font-size:15px;color:#0f0f14">{{ $career->title }}</div>
          @if($career->department)<div style="font-size:13px;color:#666;margin-top:4px">{{ $career->department }}</div>@endif
          <div style="font-size:13px;color:#666;margin-top:4px">📍 {{ $career->location }} · {{ ucfirst($career->type) }}</div>
        </div>
        <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20melamar%20posisi%20{{ urlencode($career->title) }}%20yang%20saya%20lihat%20di%20website." target="_blank"
          style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:14px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:15px;margin-bottom:12px">
          💬 Lamar via WhatsApp
        </a>
        <a href="mailto:hr@m2b.co.id?subject=Lamaran%20-%20{{ urlencode($career->title) }}"
          style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:13px;border-radius:10px;border:1.5px solid #d0cdc8;color:#0f0f14;text-decoration:none;font-weight:600;font-size:14px;background:#fff">
          📧 Email hr@m2b.co.id
        </a>
        @if($career->deadline)
        <div style="margin-top:16px;text-align:center;font-size:12px;color:#999;padding:10px;background:#fff3cd;border-radius:8px">
          ⏰ Batas pendaftaran: <strong>{{ $career->deadline->format('d M Y') }}</strong>
        </div>
        @endif
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid #f0ede8">
          <div style="font-size:12px;color:#999;text-align:center">Pertanyaan? Hubungi kami</div>
          <div style="text-align:center;margin-top:6px;font-size:13px;font-weight:600;color:#1e3a5f">📱 +62 812-6302-7818</div>
        </div>
      </div>
    </div>
  </div>
</section>

<section style="padding:60px 40px;background:#0f0f14">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <h2 style="font-family:Syne;font-weight:800;font-size:32px;color:#fff;letter-spacing:-0.8px;margin-bottom:16px">Kenapa Bergabung M2B?</h2>
    <p style="color:rgba(255,255,255,0.5);margin-bottom:32px">Kami bukan hanya tempat kerja — kami komunitas logistik yang terus bertumbuh.</p>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:32px">
      @foreach([['🚀','Berkembang Bersama','Pelatihan & mentorship dari para ahli logistik berpengalaman'],['🤝','Lingkungan Suportif','Tim kolaboratif yang saling mendukung dalam setiap shipment'],['💎','Kompensasi Kompetitif','Gaji + tunjangan + bonus kinerja yang adil dan transparan']] as [,,])
      <div style="padding:20px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;text-align:center">
        <div style="font-size:28px;margin-bottom:10px">{{ $ico }}</div>
        <div style="font-family:Syne;font-weight:700;font-size:13px;color:#fff;margin-bottom:6px">{{ $t }}</div>
        <div style="font-size:12px;color:rgba(255,255,255,0.45);line-height:1.6">{{ $d }}</div>
      </div>
      @endforeach
    </div>
    <a href="{{ route('karir.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.25);color:#fff;text-decoration:none;font-weight:600;font-size:14px">← Lihat Semua Lowongan</a>
  </div>
</section>
@endsection
