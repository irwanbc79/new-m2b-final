<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" x-data="{ lang: localStorage.getItem('m2b_lang') || 'id' }" x-init="$watch('lang', v => localStorage.setItem('m2b_lang', v))">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'M2B — Freight Forwarder & Customs Broker Indonesia')</title>
<meta name="description" content="@yield('description', 'M2B - PT. Mora Multi Berkah. Freight Forwarder & Customs Broker terpercaya dari Medan. Layanan ekspor-impor, bea cukai, door-to-door ke 20+ negara.')">
<meta property="og:title" content="@yield('title', 'M2B — Freight Forwarder & Customs Broker Indonesia')">
<meta property="og:description" content="@yield('description', 'PT. Mora Multi Berkah - Mitra logistik ekspor-impor terpercaya.')">
<meta property="og:image" content="@yield('og_image', asset('images/og-m2b.jpg'))">
<meta name="twitter:image" content="@yield('og_image', asset('images/og-m2b.jpg'))">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="robots" content="index, follow">
<meta property="og:type" content="website">
<meta property="og:locale" content="id_ID">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', 'M2B — Freight Forwarder & Customs Broker Indonesia')">
<meta name="twitter:description" content="@yield('description', 'PT. Mora Multi Berkah - Mitra logistik ekspor-impor terpercaya.')">
<link rel="canonical" href="{{ url()->current() }}">
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "LocalBusiness",
  "name": "PT. Mora Multi Berkah (M2B)",
  "description": "Freight Forwarder & Customs Broker terpercaya berbasis di Medan, Indonesia. Layanan ekspor-impor ke 20+ negara.",
  "url": "https://new.m2b.co.id",
  "telephone": "+6281263027818",
  "email": "sales@@m2b.co.id",
  "address": {
    "@@type": "PostalAddress",
    "addressLocality": "Medan",
    "addressRegion": "Sumatera Utara",
    "addressCountry": "ID"
  },
  "openingHours": "Mo-Sa 08:00-17:00",
  "sameAs": ["https://m2b.co.id", "https://portal.m2b.co.id"],
  "serviceArea": {"@@type": "Country", "name": "Indonesia"},
  "hasOfferCatalog": {
    "@@type": "OfferCatalog",
    "name": "Layanan Logistik M2B",
    "itemListElement": [
      {"@@type": "Offer", "itemOffered": {"@@type": "Service", "name": "Export Handling"}},
      {"@@type": "Offer", "itemOffered": {"@@type": "Service", "name": "Import Handling"}},
      {"@@type": "Offer", "itemOffered": {"@@type": "Service", "name": "Customs Clearance"}},
      {"@@type": "Offer", "itemOffered": {"@@type": "Service", "name": "Door-to-Door Delivery"}}
    ]
  }
}
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{background:#f7f5f0;font-family:'DM Sans',sans-serif;color:#0f0f14;font-size:15px;line-height:1.6}
.accent{color:#1e3a5f}
.font-syne{font-family:'Syne',sans-serif}
@keyframes ticker{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
.ticker-track{display:flex;animation:ticker 28s linear infinite;white-space:nowrap}
.ticker-track:hover{animation-play-state:paused}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
@keyframes wapulse{0%,100%{transform:scale(1);box-shadow:0 8px 24px rgba(37,211,102,0.4)}50%{transform:scale(1.05);box-shadow:0 12px 36px rgba(37,211,102,0.55)}}
.wa-btn{animation:wapulse 2s ease-in-out infinite}
::-webkit-scrollbar{width:6px}
@media(max-width:768px){.footer-grid{grid-template-columns:1fr 1fr!important;gap:32px!important}.footer-contact-grid{grid-template-columns:1fr 1fr!important}}
::-webkit-scrollbar-track{background:#f0ede8}
::-webkit-scrollbar-thumb{background:#c0bdb7;border-radius:3px}
.container{max-width:1200px;margin:0 auto;padding:0 40px}
@media(max-width:768px){.container{padding:0 20px}.hide-mobile{display:none!important}.show-mobile{display:flex!important}}@media(min-width:769px){.show-mobile{display:none!important}}
</style>
@yield('head')
{{-- ═══ GOOGLE ADSENSE ═══ --}}
{{-- Uncomment baris di bawah setelah akun AdSense diverifikasi untuk domain ini --}}
{{-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXXX" crossorigin="anonymous"></script> --}}
</head>
<body>

{{-- News Ticker --}}
<div style="background:#0f0f14;overflow:hidden;padding:8px 0;border-bottom:2px solid #1e3a5f">
  <div style="display:flex;align-items:center;gap:16px">
    <div style="flex-shrink:0;background:#1e3a5f;color:#fff;padding:2px 14px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;z-index:1;margin-left:0">TERKINI</div>
    <div style="flex:1;overflow:hidden">
      <div class="ticker-track" style="gap:60px">
        @php
        $ticker = [
          // M2B own — gold
          ['📘 FREE E-Book Ekspor Impor untuk Pemula — Download GRATIS di ebook.m2b.co.id', 'https://ebook.m2b.co.id', true],
          ['📘 E-Book Ekspor Impor tersedia GRATIS — kunjungi ebook.m2b.co.id sekarang', 'https://ebook.m2b.co.id', true],
          // Local media — bisnis & logistik
          ['📰 Bisnis.com: Update terkini industri logistik & ekspor-impor Indonesia', 'https://ekonomi.bisnis.com/perdagangan', false],
          ['🗞️ Kontan.co.id: Berita bisnis & perdagangan internasional', 'https://industri.kontan.co.id/logistik', false],
          ['📊 Katadata: Analisis ekspor-impor & komoditas unggulan Indonesia', 'https://katadata.co.id/tags/ekspor-impor', false],
          ['⚖️ Bea Cukai RI: Berita & regulasi kepabeanan terbaru', 'https://www.beacukai.go.id/berita.html', false],
          ['🛳️ Pelindo: Update operasional pelabuhan utama Indonesia', 'https://www.pelindo.co.id/id/media/berita', false],
          ['📋 DJPEN Kemendag: Peluang ekspor & pasar internasional', 'https://djpen.kemendag.go.id/app_frontend/contents/83-berita', false],
          // International media
          ['🌐 FreightWaves: Global freight & logistics news', 'https://www.freightwaves.com/news', false],
          ['⚓ The Loadstar: International shipping & logistics updates', 'https://theloadstar.com', false],
          ['🚢 JOC.com: Journal of Commerce — container shipping news', 'https://www.joc.com', false],
          ['✈️ Air Cargo World: Global air freight industry news', 'https://aircargoworld.com/news/', false],
          ['📦 Supply Chain Dive: Supply chain & logistics analysis', 'https://www.supplychaindive.com', false],
        ];
        @endphp
        @foreach(array_merge($ticker,$ticker) as $item)
        <a href="{{ $item[1] }}" target="_blank" rel="noopener" style="color:{{ $item[2] ? '#f5b91c' : '#d1d0cf' }};font-size:12px;white-space:nowrap;text-decoration:none;{{ $item[2] ? 'font-weight:600' : '' }}" onmouseover="this.style.color='{{ $item[2] ? '#ffd44d' : '#fff' }}'" onmouseout="this.style.color='{{ $item[2] ? '#f5b91c' : '#d1d0cf' }}'">{{ $item[0] }} ↗</a>
        @endforeach
      </div>
    </div>
  </div>
</div>

{{-- Navbar --}}
<nav x-data="{ scrolled: false, mobileOpen: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })"
  :style="scrolled ? 'background:rgba(247,245,240,0.95);backdrop-filter:blur(12px);box-shadow:0 2px 16px rgba(0,0,0,0.06)' : 'background:#f7f5f0'"
  style="position:sticky;top:0;z-index:100;border-bottom:1px solid #e5e2dc;transition:background .25s,box-shadow .25s">
  <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;height:72px;gap:16px;padding:0 24px">
    <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:12px;flex-shrink:0;text-decoration:none">
      <img src="{{ asset('images/logo-m2b.png') . '?v=2' }}" alt="M2B Logo" style="height:48px;width:auto;mix-blend-mode:multiply">
      <div style="display:flex;flex-direction:column;line-height:1.1;border-left:1.5px solid #d5d0c8;padding-left:12px" class="hide-mobile">
        <span style="font-family:Syne;font-weight:800;font-size:14px;color:#0B1120;letter-spacing:-0.3px">PT. Mora Multi Berkah</span>
        <span style="font-size:9px;color:#8b1e2b;font-weight:700;letter-spacing:1.5px">LOGISTIC · SOLUTION · PARTNER</span>
      </div>
    </a>
    <div style="display:flex;gap:20px;flex:1;justify-content:center" class="hide-mobile">
      <a href="{{ route('home') }}#layanan" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Layanan</a>
      <a href="{{ route('home') }}#proses" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Proses</a>
      <a href="{{ route('blog.index') }}" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Blog</a>
      <a href="{{ route('about') }}" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">About</a>
      <a href="{{ route('karir.index') }}" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Karir</a>
    </div>
    <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20konsultasi%20gratis" target="_blank"
      style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:13px;white-space:nowrap;flex-shrink:0" class="hide-mobile">
      💬 Konsultasi Gratis
    </a>
    {{-- Hamburger button — mobile only --}}
    <button @click="mobileOpen = !mobileOpen" class="show-mobile"
      style="margin-left:auto;width:44px;height:44px;border-radius:10px;border:1px solid #e5e2dc;background:#fff;cursor:pointer;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;flex-shrink:0">
      <span :style="mobileOpen ? 'transform:rotate(45deg) translate(5px,5px)' : ''" style="display:block;width:20px;height:2px;background:#0f0f14;border-radius:2px;transition:transform .2s"></span>
      <span x-show="!mobileOpen" style="display:block;width:20px;height:2px;background:#0f0f14;border-radius:2px"></span>
      <span :style="mobileOpen ? 'transform:rotate(-45deg) translate(5px,-5px)' : ''" style="display:block;width:20px;height:2px;background:#0f0f14;border-radius:2px;transition:transform .2s"></span>
    </button>
  </div>
  {{-- Mobile menu drawer --}}
  <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0"
    style="border-top:1px solid #e5e2dc;background:#f7f5f0;padding:16px 24px 24px" class="show-mobile">
    <div style="display:flex;flex-direction:column;gap:0">
      <a href="{{ route('home') }}#layanan" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">📦 Layanan</a>
      <a href="{{ route('home') }}#proses" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">⚙️ Proses</a>
      <a href="{{ route('blog.index') }}" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">📝 Blog</a>
      <a href="{{ route('about') }}" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">🏢 Tentang M2B</a>
      <a href="{{ route('karir.index') }}" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">💼 Karir</a>
      <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20konsultasi%20gratis" target="_blank" style="margin-top:16px;display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;border-radius:10px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:700;font-size:15px">💬 Konsultasi Gratis via WhatsApp</a>
    </div>
  </div>
</nav>

{{-- Page Content --}}
@yield('content')

{{-- Footer --}}
<footer style="background:#fff;border-top:4px solid #1e3a5f;padding:64px 40px 32px;color:#555">
  <div style="max-width:1200px;margin:0 auto">
    <div style="display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:48px;margin-bottom:48px" class="footer-grid">
      <div>
        <img src="{{ asset('images/logo-m2b.png') . '?v=2' }}" alt="M2B" style="height:96px;width:auto;display:block;margin-bottom:16px;mix-blend-mode:multiply">
        <div style="font-family:Syne;font-weight:700;font-size:14px;color:#1e3a5f;margin-bottom:6px">PT. Mora Multi Berkah</div>
        <div style="font-size:12px;color:#888;margin-bottom:16px;line-height:1.75">Freight Forwarder & Customs Broker.<br>Mitra logistik tepercaya dari Medan untuk Indonesia & dunia.</div>
      </div>
      <div>
        <div style="font-family:Syne;font-weight:700;font-size:12px;color:#1e3a5f;margin-bottom:18px;text-transform:uppercase;letter-spacing:1px">Layanan</div>
        @foreach(['Export Handling','Import Handling','Customs Clearance','Door-to-Door','Undername Import','Konsultasi'] as $l)
        <div style="font-size:13px;margin-bottom:10px"><a href="{{ route('home') }}#layanan" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">{{ $l }}</a></div>
        @endforeach
      </div>
      <div>
        <div style="font-family:Syne;font-weight:700;font-size:12px;color:#1e3a5f;margin-bottom:18px;text-transform:uppercase;letter-spacing:1px">Perusahaan</div>
        <div style="font-size:13px;margin-bottom:10px"><a href="{{ route('about') }}" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">About M2B</a></div>
        <div style="font-size:13px;margin-bottom:10px"><a href="{{ route('tim') }}" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Tim Kami</a></div>
        <div style="font-size:13px;margin-bottom:10px"><a href="{{ route('karir.index') }}" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Karir</a></div>
        <div style="font-size:13px;margin-bottom:10px"><a href="https://portal.m2b.co.id" target="_blank" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Portal M2B ↗</a></div>
      </div>
      <div>
        <div style="font-family:Syne;font-weight:700;font-size:12px;color:#1e3a5f;margin-bottom:18px;text-transform:uppercase;letter-spacing:1px">Konten</div>
        <div style="font-size:13px;margin-bottom:10px"><a href="{{ route('blog.index') }}" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Blog & Artikel</a></div>
        <div style="font-size:13px;margin-bottom:10px"><a href="https://ebook.m2b.co.id" target="_blank" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Download E-Book ↗</a></div>
      </div>
    </div>
    <div style="background:#fafaf8;border:1px solid #e5e2dc;border-radius:16px;overflow:hidden;margin-bottom:32px;display:grid;grid-template-columns:1fr 1.5fr" class="footer-contact-grid">
      {{-- Kiri: Info Kontak --}}
      <div style="padding:24px 28px">
        <div style="font-family:Syne;font-weight:800;font-size:12px;color:#1e3a5f;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px">Hubungi Kami</div>
        <p style="font-size:12.5px;color:#666;line-height:1.75;margin-bottom:18px">Komplek Graha Metropolitan Blok G No. 24,<br>Jl. Kapten Sumarsono, Kp. Lalang,<br>Kec. Sunggal, Kota Medan 20114</p>
        @php
      $footerContacts = [
        ['📧','Email','sales@m2b.co.id','mailto:sales@m2b.co.id'],
        ['📱','WhatsApp','+62 812-6302-7818','https://wa.me/6281263027818'],
        ['🕒','Jam Buka','Senin–Sabtu · 08–17 WIB',null],
      ];
      @endphp
      @foreach($footerContacts as $fc)
        <div style="display:flex;gap:10px;align-items:center;margin-bottom:12px">
          <div style="width:30px;height:30px;border-radius:8px;background:rgba(30,58,95,0.08);display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0">{{ $fc[0] }}</div>
          <div>
            <div style="font-size:10px;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;font-weight:600">{{ $fc[1] }}</div>
            @if($fc[3])<a href="{{ $fc[3] }}" style="font-size:13px;color:#1e3a5f;font-weight:600;text-decoration:none">{{ $fc[2] }}</a>
            @else<div style="font-size:13px;color:#1e3a5f;font-weight:600">{{ $fc[2] }}</div>@endif
          </div>
        </div>
      @endforeach
        <a href="https://maps.app.goo.gl/qxDf2EHjkEngXNGP7" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;font-size:12px;color:#4a9eda;font-weight:600;text-decoration:none">🗺️ Buka di Google Maps ↗</a>
      </div>
      {{-- Kanan: Google Maps --}}
      <iframe
        src="https://maps.google.com/maps?q=PT+Mora+Multi+Berkah+Jl+Kapten+Sumarsono+Komplek+Graha+Metropolitan+Medan&output=embed&z=16"
        width="100%" height="260"
        style="border:0;display:block;min-height:260px"
        allowfullscreen loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px;align-items:center">
      <span style="font-size:11px;color:#999;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-right:8px">Legalitas:</span>
      @foreach(['NIB','NPWP','ALFI','KADIN','LNSW','Bea Cukai RI'] as $l)
      <span style="padding:4px 10px;border:1px solid #e5e2dc;border-radius:4px;font-size:11px;color:#666;background:#fff;font-weight:500">{{ $l }}</span>
      @endforeach
    </div>
    <div style="border-top:1px solid #e5e2dc;padding-top:24px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:12px;font-size:12px;color:#888">
      <span>© {{ date('Y') }} PT. Mora Multi Berkah. All rights reserved.</span>
      <div style="display:flex;gap:16px;flex-wrap:wrap">
        <a href="{{ route('privacy') }}" style="color:#888;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#888'">Privacy Policy</a>
        <a href="{{ route('disclaimer') }}" style="color:#888;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#888'">Disclaimer</a>
        <a href="{{ route('terms') }}" style="color:#888;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#888'">Ketentuan Layanan</a>
      </div>
    </div>
  </div>
</footer>

{{-- Scroll to Top --}}
<button x-data="{ show: false }" x-init="window.addEventListener('scroll', () => show = window.scrollY > 300)" x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="window.scrollTo({top:0,behavior:'smooth'})" style="position:fixed;bottom:100px;right:28px;z-index:998;width:44px;height:44px;border-radius:50%;background:#1e3a5f;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;box-shadow:0 4px 14px rgba(30,58,95,0.35);transition:background .2s" onmouseover="this.style.background='#162d4a'" onmouseout="this.style.background='#1e3a5f'">↑</button>

{{-- WhatsApp Float Button --}}
<a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20konsultasi%20gratis" target="_blank"
  class="wa-btn"
  style="position:fixed;bottom:28px;right:28px;z-index:999;width:60px;height:60px;border-radius:50%;background:#25D366;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:28px;box-shadow:0 8px 24px rgba(37,211,102,0.4)">
  💬
</a>

</body>
</html>
