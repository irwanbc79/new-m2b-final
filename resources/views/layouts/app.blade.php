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
<meta name="csrf-token" content="{{ csrf_token() }}">
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
{{-- ═══ GOOGLE ADSENSE — hanya di halaman blog ═══ --}}
@if(request()->is('blog*'))
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5616961797801657" crossorigin="anonymous"></script>
@endif
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
      <img src="{{ asset('images/m2b_logo1.svg') }}" alt="M2B Logo" style="height:108px;width:auto">
      <div style="display:flex;flex-direction:column;line-height:1.1;border-left:1.5px solid #d5d0c8;padding-left:12px" class="hide-mobile">
        <span style="font-family:Syne;font-weight:800;font-size:14px;color:#0B1120;letter-spacing:-0.3px">PT. Mora Multi Berkah</span>
        <span style="font-size:9px;color:#8b1e2b;font-weight:700;letter-spacing:1.5px">LOGISTIC · SOLUTION · PARTNER</span>
      </div>
    </a>
    <div style="display:flex;gap:20px;flex:1;justify-content:center" class="hide-mobile">
      <a href="{{ route('home') }}#layanan" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">
        <span x-text="lang==='en' ? 'Services' : 'Layanan'">Layanan</span>
      </a>
      <a href="{{ route('home') }}#proses" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">
        <span x-text="lang==='en' ? 'Process' : 'Proses'">Proses</span>
      </a>
      <a href="{{ route('blog.index') }}" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Blog</a>
      <a href="{{ route('about') }}" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">
        <span x-text="lang==='en' ? 'About Us' : 'Tentang'">Tentang</span>
      </a>
      <a href="{{ route('karir.index') }}" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">
        <span x-text="lang==='en' ? 'Careers' : 'Karir'">Karir</span>
      </a>
    </div>
    {{-- Language switcher — akses root lang tanpa x-data baru --}}
    <button @click="lang = lang === 'id' ? 'en' : 'id'; localStorage.setItem('m2b_lang', lang)"
      style="display:inline-flex;align-items:center;gap:5px;padding:6px 11px;border-radius:6px;border:1px solid #e5e2dc;background:#fff;cursor:pointer;font-size:12px;font-weight:600;color:#555;flex-shrink:0;transition:border-color .15s"
      onmouseover="this.style.borderColor='#1e3a5f';this.style.color='#1e3a5f'"
      onmouseout="this.style.borderColor='#e5e2dc';this.style.color='#555'"
      class="hide-mobile">
      <span x-text="lang === 'id' ? '🇮🇩 ID' : '🇬🇧 EN'">🇮🇩 ID</span>
    </button>
    <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20konsultasi%20gratis" target="_blank"
      style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:13px;white-space:nowrap;flex-shrink:0" class="hide-mobile">
      <span x-text="lang==='en' ? '💬 Free Consultation' : '💬 Konsultasi Gratis'">💬 Konsultasi Gratis</span>
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
    <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:48px;align-items:start" class="footer-grid">
      <div>
        <img src="{{ asset('images/m2b_logo1.svg') }}" alt="M2B" style="height:160px;width:auto;display:block;margin-bottom:14px">
        <div style="font-family:Syne;font-weight:700;font-size:14px;color:#1e3a5f;margin-bottom:6px">PT. Mora Multi Berkah</div>
        <div style="font-size:12px;color:#888;margin-bottom:16px;line-height:1.75">Freight Forwarder & Customs Broker.<br>Mitra logistik tepercaya dari Medan untuk Indonesia & dunia.</div>
        {{-- Social media --}}
        <div style="display:flex;gap:8px;margin-bottom:16px">
          <a href="https://www.instagram.com/m2b.logistic" target="_blank" rel="noopener"
            style="width:34px;height:34px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#555;transition:all .15s"
            onmouseover="this.style.background='#fff0f3';this.style.color='#e1306c';this.style.borderColor='#e1306c'"
            onmouseout="this.style.background='#fafaf8';this.style.color='#555';this.style.borderColor='#e5e2dc'">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <a href="https://www.linkedin.com/company/pt-mora-multi-berkah" target="_blank" rel="noopener"
            style="width:34px;height:34px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#555;transition:all .15s"
            onmouseover="this.style.background='#e8f0fb';this.style.color='#0077b5';this.style.borderColor='#0077b5'"
            onmouseout="this.style.background='#fafaf8';this.style.color='#555';this.style.borderColor='#e5e2dc'">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a href="https://wa.me/6281263027818" target="_blank" rel="noopener"
            style="width:34px;height:34px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#555;transition:all .15s"
            onmouseover="this.style.background='#e8fdf0';this.style.color='#25d366';this.style.borderColor='#25d366'"
            onmouseout="this.style.background='#fafaf8';this.style.color='#555';this.style.borderColor='#e5e2dc'">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          </a>
        </div>
        {{-- Badge legalitas --}}
        <div style="display:flex;gap:6px;flex-wrap:wrap">
          @foreach(['NIB','NPWP','ALFI','KADIN','LNSW','Bea Cukai RI'] as $badge)
          <span style="padding:3px 9px;border:1px solid #e5e2dc;border-radius:4px;font-size:10px;color:#666;background:#fff;font-weight:600">{{ $badge }}</span>
          @endforeach
        </div>
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
<button x-data="{ show: false }" x-init="window.addEventListener('scroll', () => show = window.scrollY > 300)" x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="window.scrollTo({top:0,behavior:'smooth'})" style="position:fixed;bottom:155px;right:20px;z-index:998;width:44px;height:44px;border-radius:50%;background:#1e3a5f;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;box-shadow:0 4px 14px rgba(30,58,95,0.35);transition:background .2s" onmouseover="this.style.background='#162d4a'" onmouseout="this.style.background='#1e3a5f'">↑</button>

{{-- Floating Buttons (eBook, WhatsApp right; Language switcher left) --}}
<x-floating-buttons />

{{-- MORA AI Chat Widget --}}
<x-mora-widget />

</body>
</html>
