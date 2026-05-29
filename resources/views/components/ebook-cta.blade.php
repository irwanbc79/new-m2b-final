{{--
    CTA E-book BERBAYAR untuk halaman blog (funnel blog → ebook.m2b.co.id).
    Copy dibuat jujur sesuai produk asli: 22 bab, Rp 49.000, garansi 7 hari uang kembali.
    UTM dipasang agar penjualan dari blog bisa diukur di Analytics.
    Toolkit gratis tetap ditawarkan sebagai jalur lembut bagi yang belum siap beli.

    @props:
      source  — penanda UTM medium/posisi (mis. 'post', 'feed') untuk membedakan asal klik
--}}
@props(['source' => 'blog'])
@php
    $base = 'https://ebook.m2b.co.id/';
    $utm  = '?utm_source=blog&utm_medium=' . e($source) . '&utm_campaign=ebook_paid';
    $buyUrl  = $base . $utm . '#order';
    $freeUrl = $base . 'toolkit.html?utm_source=blog&utm_medium=' . e($source) . '&utm_campaign=toolkit_free';
@endphp
<div style="margin-top:32px;background:linear-gradient(135deg,#0f0f14 0%,#1e3a5f 100%);border-radius:16px;padding:32px 36px;border:1px solid rgba(245,185,28,0.25)">
  <div style="display:flex;align-items:flex-start;gap:24px;flex-wrap:wrap">
    <div style="font-size:48px;flex-shrink:0;line-height:1">📘</div>
    <div style="flex:1;min-width:240px">
      <div style="display:inline-block;background:rgba(245,185,28,0.15);color:#f5b91c;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:3px 10px;border-radius:6px;margin-bottom:10px">E-Book Resmi M2B</div>
      <div style="font-family:Syne;font-weight:800;font-size:20px;color:#fff;line-height:1.3;margin-bottom:8px">Panduan Lengkap Ekspor Impor Indonesia 2026</div>
      <div style="font-size:14px;color:rgba(255,255,255,0.7);line-height:1.65;margin-bottom:16px">
        22 bab dari A&ndash;Z: mindset global, HS Code, dokumen inti, Incoterms 2020, landed cost, hingga strategi B2B digital. Cocok untuk pemula &amp; UMKM yang serius go global.
      </div>
      <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:20px">
        <span style="font-family:Syne;font-weight:800;font-size:24px;color:#f5b91c">Rp 49.000</span>
        <span style="font-size:13px;color:rgba(255,255,255,0.6)">🔒 Garansi 7 hari uang kembali</span>
      </div>
      <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center">
        <a href="{{ $buyUrl }}" target="_blank" rel="noopener"
           style="display:inline-flex;align-items:center;gap:8px;padding:13px 26px;border-radius:10px;background:#f5b91c;color:#0f0f14;text-decoration:none;font-weight:700;font-size:14px;white-space:nowrap">
          Miliki E-Book Sekarang ↗
        </a>
        <a href="{{ $freeUrl }}" target="_blank" rel="noopener"
           style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,0.7);text-decoration:none;font-weight:600;font-size:13px;border-bottom:1px solid rgba(255,255,255,0.3);padding-bottom:1px">
          Belum siap? Coba toolkit gratis dulu
        </a>
      </div>
    </div>
  </div>
</div>
