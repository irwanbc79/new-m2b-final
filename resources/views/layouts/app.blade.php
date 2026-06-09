<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" x-data="{ get lang() { return $store.lang.current }, set lang(v) { $store.lang.current = v; localStorage.setItem('m2b_lang', v) } }">
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
<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:locale" content="id_ID">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', 'M2B — Freight Forwarder & Customs Broker Indonesia')">
<meta name="twitter:description" content="@yield('description', 'PT. Mora Multi Berkah - Mitra logistik ekspor-impor terpercaya.')">
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/jpeg">
<meta name="geo.region" content="ID-SU">
<meta name="geo.placename" content="Medan, Sumatera Utara">
<meta name="geo.position" content="3.5952;98.6722">
<meta name="ICBM" content="3.5952, 98.6722">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "LocalBusiness",
  "name": "PT. Mora Multi Berkah (M2B)",
  "description": "Freight Forwarder & Customs Broker terpercaya berbasis di Medan, Indonesia. Layanan ekspor-impor ke 20+ negara.",
  "url": "https://m2b.co.id",
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
{{-- Preload critical assets untuk LCP --}}
<link rel="preload" as="image" href="https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?auto=format&fit=crop&w=1600&q=80" fetchpriority="high">
<link rel="preload" as="image" href="{{ asset('images/logo_m2b_final.svg') }}" fetchpriority="high">
<style>
[x-cloak]{display:none!important}
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
.wa-btn-main {
  width: 68px !important;
  height: 68px !important;
  border-radius: 50% !important;
  background: #25D366 !important;
  border: none !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  box-shadow: 0 8px 24px rgba(37,211,102,0.4) !important;
  cursor: pointer !important;
  transition: transform .2s !important;
}
.m2b-navbar {
  position: sticky !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  width: 100% !important;
  z-index: 9999 !important;
  border-bottom: 1px solid #e5e2dc !important;
  transition: background .25s, box-shadow .25s !important;
  background: #f7f5f0 !important;
}
.m2b-navbar.scrolled {
  background: rgba(247, 245, 240, 0.96) !important;
  backdrop-filter: blur(14px) !important;
  box-shadow: 0 2px 16px rgba(0,0,0,0.07) !important;
}
::-webkit-scrollbar{width:6px}
@media(max-width:768px){.footer-grid{grid-template-columns:1fr 1fr!important;gap:32px!important}.footer-contact-grid{grid-template-columns:1fr 1fr!important}}
::-webkit-scrollbar-track{background:#f0ede8}
::-webkit-scrollbar-thumb{background:#c0bdb7;border-radius:3px}
.container{max-width:1200px;margin:0 auto;padding:0 40px}
@media(max-width:768px){.container{padding:0 20px}.hide-mobile{display:none!important}.show-mobile{display:flex!important}}@media(min-width:769px){.show-mobile{display:none!important}}
.m2b-mobile-drawer { display: none; }
@media(max-width:768px) { .m2b-mobile-drawer { display: block; } }

/* Shared B2B Inquiry Modal Styles */
.calc-input {
  background: rgba(255, 255, 255, 0.05) !important;
  border: 1px solid rgba(255, 255, 255, 0.15) !important;
  border-radius: 8px !important;
  color: #fff !important;
  padding: 10px 12px !important;
  font-size: 14px !important;
  font-family: inherit !important;
  width: 100% !important;
  transition: all 0.2s !important;
  outline: none !important;
}
.calc-input:focus {
  border-color: #4a9eda !important;
  background: rgba(255, 255, 255, 0.08) !important;
  box-shadow: 0 0 0 2px rgba(74, 158, 218, 0.2) !important;
}
.calc-input[readonly] {
  background: rgba(255, 255, 255, 0.02) !important;
  color: rgba(255, 255, 255, 0.6) !important;
  border-color: rgba(255, 255, 255, 0.08) !important;
  cursor: not-allowed !important;
}
.calc-select {
  background: #1e293b !important;
  border: 1px solid rgba(255, 255, 255, 0.15) !important;
  border-radius: 8px !important;
  color: #fff !important;
  padding: 10px 12px !important;
  font-size: 14px !important;
  font-weight: 600 !important;
  width: 100% !important;
  outline: none !important;
  cursor: pointer !important;
}
.calc-select:focus {
  border-color: #4a9eda !important;
}
.calc-label {
  display: block !important;
  font-size: 11px !important;
  font-weight: 700 !important;
  color: rgba(255, 255, 255, 0.65) !important;
  margin-bottom: 5px !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
}
@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>
@yield('head')
{{-- ═══ GOOGLE ADSENSE ═══ --}}
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5616961797801657" crossorigin="anonymous"></script>
{{-- ═══ GOOGLE ANALYTICS 4 — deferred loading, tidak blokir FCP ═══ --}}
@production
<script>
(function(){
    function loadGA(){
        var s=document.createElement('script');
        s.src='https://www.googletagmanager.com/gtag/js?id=G-BZQ3135741';
        s.async=true;
        document.head.appendChild(s);
        window.dataLayer=window.dataLayer||[];
        function gtag(){dataLayer.push(arguments);}
        window.gtag=gtag;
        gtag('js',new Date());
        gtag('config','G-BZQ3135741');
    }
    'requestIdleCallback' in window
        ? requestIdleCallback(loadGA,{timeout:2000})
        : window.addEventListener('load',loadGA);
})();
</script>
@endproduction
</head>
<body>

{{-- News Ticker --}}
<div id="m2b-ticker" class="print-hide" style="background:#0f0f14;overflow:hidden;padding:8px 0;border-bottom:2px solid #1e3a5f">
  <div style="display:flex;align-items:center;gap:16px">
    <div style="flex-shrink:0;background:#1e3a5f;color:#fff;padding:2px 14px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;z-index:1;margin-left:0">TERKINI</div>
    <div style="flex:1;overflow:hidden">
      <div class="ticker-track" style="gap:60px">
        @foreach($tickerItems as $item)
        <a href="{{ $item[1] }}" target="_blank" rel="noopener" style="color:{{ $item[2] ? '#f5b91c' : '#d1d0cf' }};font-size:12px;white-space:nowrap;text-decoration:none;{{ $item[2] ? 'font-weight:600' : '' }}" onmouseover="this.style.color='{{ $item[2] ? '#ffd44d' : '#fff' }}'" onmouseout="this.style.color='{{ $item[2] ? '#f5b91c' : '#d1d0cf' }}'">{{ $item[0] }} ↗</a>
        @endforeach
      </div>
    </div>
  </div>
</div>

{{-- Navbar --}}
<nav x-data="{ scrolled: false, mobileOpen: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40; mobileOpen = false })"
  class="m2b-navbar print-hide" :class="{ 'scrolled': scrolled }">
  <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;height:72px;gap:16px;padding:0 24px">
    <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:12px;flex-shrink:0;text-decoration:none">
      <img src="{{ asset('images/logo_m2b_final.svg') }}" alt="M2B Logo" style="height:52px;width:auto">
      <div style="display:flex;flex-direction:column;line-height:1.1;border-left:1.5px solid #d5d0c8;padding-left:12px" class="hide-mobile">
        <span style="font-family:Syne;font-weight:800;font-size:14px;color:#0B1120;letter-spacing:-0.3px">PT. Mora Multi Berkah</span>
        <span style="font-size:9px;color:#8b1e2b;font-weight:700;letter-spacing:1.5px">LOGISTIC · SOLUTION · PARTNER</span>
      </div>
    </a>
    <div style="display:flex;gap:20px;flex:1;justify-content:center" class="hide-mobile">
      <a href="{{ route('home') }}#layanan" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">
        <span x-text="$store.lang.t('Layanan', 'Services', '服务', 'الخدمات')">Layanan</span>
      </a>
      <a href="{{ route('home') }}#proses" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">
        <span x-text="$store.lang.t('Proses', 'Process', '流程', 'العملية')">Proses</span>
      </a>
      <a href="{{ route('blog.index') }}" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Blog</a>
      <a href="{{ route('about') }}" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">
        <span x-text="$store.lang.t('Tentang', 'About Us', '关于我们', 'من نحن')">Tentang</span>
      </a>
      <a href="{{ route('karir.index') }}" style="font-size:13px;text-decoration:none;font-weight:500;color:#555;transition:color .15s" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">
        <span x-text="$store.lang.t('Karir', 'Careers', '职业生涯', 'الوظائف')">Karir</span>
      </a>
    </div>
    {{-- Language switcher — akses root lang tanpa x-data baru --}}
    <button @click="$store.lang.toggle()"
      style="display:inline-flex;align-items:center;gap:5px;padding:6px 11px;border-radius:6px;border:1px solid #e5e2dc;background:#fff;cursor:pointer;font-size:12px;font-weight:600;color:#555;flex-shrink:0;transition:border-color .15s"
      onmouseover="this.style.borderColor='#1e3a5f';this.style.color='#1e3a5f'"
      onmouseout="this.style.borderColor='#e5e2dc';this.style.color='#555'"
      class="hide-mobile">
      <span x-text="{ id: '🇮🇩 ID', en: '🇬🇧 EN', zh: '🇨🇳 中文', ar: '🇸🇦 العربية' }[$store.lang.current]">🇮🇩 ID</span>
    </button>
    <a href="#" @click.prevent="window.dispatchEvent(new CustomEvent('open-b2b-modal'))"
      style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:13px;white-space:nowrap;flex-shrink:0" class="hide-mobile">
      <span x-text="$store.lang.t('💼 Inquiry B2B', '💼 B2B Inquiry', '💼 B2B 询盘', '💼 استعلام B2B')">💼 Inquiry B2B</span>
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
  <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0"
    style="border-top:1px solid #e5e2dc;background:#f7f5f0;padding:16px 24px 24px" class="m2b-mobile-drawer">
    <div style="display:flex;flex-direction:column;gap:0">
      <a href="{{ route('home') }}#layanan" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">
        <span x-text="$store.lang.t('📦 Layanan', '📦 Services', '📦 服务', '📦 الخدمات')">📦 Layanan</span>
      </a>
      <a href="{{ route('home') }}#proses" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">
        <span x-text="$store.lang.t('⚙️ Proses', '⚙️ Process', '⚙️ 流程', '⚙️ العملية')">⚙️ Proses</span>
      </a>
      <a href="{{ route('blog.index') }}" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">
        <span x-text="$store.lang.t('📝 Blog', '📝 Blog', '📝 博客', '📝 المدونة')">📝 Blog</span>
      </a>
      <a href="{{ route('about') }}" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">
        <span x-text="$store.lang.t('🏢 Tentang M2B', '🏢 About M2B', '🏢 关于M2B', '🏢 عن M2B')">🏢 Tentang M2B</span>
      </a>
      <a href="{{ route('karir.index') }}" @click="mobileOpen=false" style="padding:14px 0;font-size:15px;font-weight:500;color:#333;text-decoration:none;border-bottom:1px solid #e5e2dc">
        <span x-text="$store.lang.t('💼 Karir', '💼 Careers', '💼 职业生涯', '💼 الوظائف')">💼 Karir</span>
      </a>
      {{-- Label Pilihan Bahasa --}}
      <div style="margin-top:16px;font-size:11px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;text-align:center">
        Pilih Bahasa / Select Language
      </div>
      {{-- Grid Pilihan Bahasa --}}
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:12px">
        <button @click="$store.lang.current = 'id'; localStorage.setItem('m2b_lang', 'id')"
          :style="$store.lang.current === 'id' ? 'background:#1e3a5f;color:#fff;border-color:#1e3a5f' : 'background:#fff;color:#555;border-color:#e5e2dc'"
          style="padding:10px 0;font-size:12px;font-weight:700;border:1px solid;border-radius:8px;cursor:pointer;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;transition:all .15s">
          <span>🇮🇩</span><span>ID</span>
        </button>
        <button @click="$store.lang.current = 'en'; localStorage.setItem('m2b_lang', 'en')"
          :style="$store.lang.current === 'en' ? 'background:#1e3a5f;color:#fff;border-color:#1e3a5f' : 'background:#fff;color:#555;border-color:#e5e2dc'"
          style="padding:10px 0;font-size:12px;font-weight:700;border:1px solid;border-radius:8px;cursor:pointer;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;transition:all .15s">
          <span>🇬🇧</span><span>EN</span>
        </button>
        <button @click="$store.lang.current = 'zh'; localStorage.setItem('m2b_lang', 'zh')"
          :style="$store.lang.current === 'zh' ? 'background:#1e3a5f;color:#fff;border-color:#1e3a5f' : 'background:#fff;color:#555;border-color:#e5e2dc'"
          style="padding:10px 0;font-size:12px;font-weight:700;border:1px solid;border-radius:8px;cursor:pointer;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;transition:all .15s">
          <span>🇨🇳</span><span>中文</span>
        </button>
        <button @click="$store.lang.current = 'ar'; localStorage.setItem('m2b_lang', 'ar')"
          :style="$store.lang.current === 'ar' ? 'background:#1e3a5f;color:#fff;border-color:#1e3a5f' : 'background:#fff;color:#555;border-color:#e5e2dc'"
          style="padding:10px 0;font-size:12px;font-weight:700;border:1px solid;border-radius:8px;cursor:pointer;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;transition:all .15s">
          <span>🇸🇦</span><span>العربية</span>
        </button>
      </div>
      <a href="#" @click.prevent="mobileOpen = false; window.dispatchEvent(new CustomEvent('open-b2b-modal'))" style="margin-top:10px;display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;border-radius:10px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:700;font-size:15px">
        <span x-text="$store.lang.t('💼 Ajukan Inquiry B2B', '💼 Submit B2B Inquiry', '💼 提交 B2B 询盘', '💼 تقديم استعلام B2B')">💼 Ajukan Inquiry B2B</span>
      </a>
    </div>
  </div>
</nav>
{{-- Spacer tidak diperlukan lagi karena navbar menggunakan position: sticky --}}

{{-- Page Content --}}
@yield('content')

{{-- Footer --}}
<footer class="print-hide" style="background:#fff;border-top:4px solid #1e3a5f;padding:64px 40px 32px;color:#555">
  <div style="max-width:1200px;margin:0 auto">
    <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:48px;align-items:start" class="footer-grid">
      <div>
        <img src="{{ asset('images/logo_m2b_final.svg') }}" alt="M2B" style="height:60px;width:auto;display:block;margin-bottom:14px">
        <div style="font-family:Syne;font-weight:700;font-size:14px;color:#1e3a5f;margin-bottom:6px">PT. Mora Multi Berkah</div>
        <div style="font-size:12px;color:#888;margin-bottom:16px;line-height:1.75" x-text="$store.lang.t('Freight Forwarder & Customs Broker. Mitra logistik tepercaya dari Medan untuk Indonesia & dunia.', 'Freight Forwarder & Customs Broker. Trusted logistics partner from Medan for Indonesia & the world.', '货运代理与报关行。来自棉兰、服务印尼与全球的信赖物流合作伙伴。', 'وكيل شحن ومخلص جمركي. شريك لوجستي موثوق من ميدان لإندونيسيا والعالم.')">Freight Forwarder & Customs Broker.<br>Mitra logistik tepercaya dari Medan untuk Indonesia & dunia.</div>
        {{-- Social media --}}
        <div style="display:flex;gap:8px;margin-bottom:16px">
          <a href="https://www.instagram.com/moramultiberkah" target="_blank" rel="noopener" title="Instagram @moramultiberkah"
            style="width:34px;height:34px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#555;transition:all .15s"
            onmouseover="this.style.background='#fff0f3';this.style.color='#e1306c';this.style.borderColor='#e1306c'"
            onmouseout="this.style.background='#fafaf8';this.style.color='#555';this.style.borderColor='#e5e2dc'">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <a href="https://www.facebook.com/MoraMultiBerkah" target="_blank" rel="noopener" title="Facebook Mora Multi Berkah"
            style="width:34px;height:34px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#555;transition:all .15s"
            onmouseover="this.style.background='#e8f0fb';this.style.color='#1877f2';this.style.borderColor='#1877f2'"
            onmouseout="this.style.background='#fafaf8';this.style.color='#555';this.style.borderColor='#e5e2dc'">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12.073h2.54V9.734c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.878h-2.33V21.951C20.343 21.201 24 17.064 24 12.073z"/></svg>
          </a>
          <a href="https://www.youtube.com/@moramultiberkahofficial893" target="_blank" rel="noopener" title="YouTube @moramultiberkahofficial893"
            style="width:34px;height:34px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#555;transition:all .15s"
            onmouseover="this.style.background='#fff0f0';this.style.color='#ff0000';this.style.borderColor='#ff0000'"
            onmouseout="this.style.background='#fafaf8';this.style.color='#555';this.style.borderColor='#e5e2dc'">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          </a>
          <a href="https://wa.me/6281263027818" target="_blank" rel="noopener" title="WhatsApp M2B"
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
        <div style="font-family:Syne;font-weight:700;font-size:12px;color:#1e3a5f;margin-bottom:18px;text-transform:uppercase;letter-spacing:1px" x-text="$store.lang.t('Layanan', 'Services', '服务', 'الخدمات')">Layanan</div>
        @foreach(['Export Handling','Import Handling','Customs Clearance','Door-to-Door','Undername Import','Konsultasi'] as $l)
        @php
          $lEn = [
            'Export Handling' => 'Export Handling',
            'Import Handling' => 'Import Handling',
            'Customs Clearance' => 'Customs Clearance',
            'Door-to-Door' => 'Door-to-Door',
            'Undername Import' => 'Undername Import',
            'Konsultasi' => 'Consultation'
          ][$l] ?? $l;
          $lZh = [
            'Export Handling' => '出口服务',
            'Import Handling' => '进口服务',
            'Customs Clearance' => '清关服务',
            'Door-to-Door' => '双清门到门服务',
            'Undername Import' => '买单进口代理(Undername)',
            'Konsultasi' => '咨询与策划'
          ][$l] ?? $lEn;
          $lAr = [
            'Export Handling' => 'تخليص الصادرات',
            'Import Handling' => 'تخليص الواردات',
            'Customs Clearance' => 'التخليص الجمركي',
            'Door-to-Door' => 'من الباب إلى الباب',
            'Undername Import' => 'الاستيراد باسم الغير',
            'Konsultasi' => 'الاستشارات اللوجستية'
          ][$l] ?? $lEn;
        @endphp
        <div style="font-size:13px;margin-bottom:10px">
          <a href="{{ route('home') }}#layanan" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">
            <span x-text="$store.lang.t('{{ $l }}', '{{ $lEn }}', '{{ $lZh }}', '{{ $lAr }}')">{{ $l }}</span>
          </a>
        </div>
        @endforeach
      </div>
      <div>
        <div style="font-family:Syne;font-weight:700;font-size:12px;color:#1e3a5f;margin-bottom:18px;text-transform:uppercase;letter-spacing:1px" x-text="$store.lang.t('Perusahaan', 'Company', '公司', 'الشركة')">Perusahaan</div>
        <div style="font-size:13px;margin-bottom:10px"><a href="{{ route('about') }}" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'"><span x-text="$store.lang.t('Tentang M2B', 'About M2B', '关于 M2B', 'عن M2B')">Tentang M2B</span></a></div>
        <div style="font-size:13px;margin-bottom:10px"><a href="{{ route('tim') }}" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'"><span x-text="$store.lang.t('Tim Kami', 'Our Team', '我们的团队', 'فريقنا')">Tim Kami</span></a></div>
        <div style="font-size:13px;margin-bottom:10px"><a href="{{ route('karir.index') }}" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'"><span x-text="$store.lang.t('Karir', 'Careers', '职业生涯', 'الوظائف')">Karir</span></a></div>
        <div style="font-size:13px;margin-bottom:10px"><a href="https://portal.m2b.co.id" target="_blank" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'">Portal M2B ↗</a></div>
      </div>
      <div>
        <div style="font-family:Syne;font-weight:700;font-size:12px;color:#1e3a5f;margin-bottom:18px;text-transform:uppercase;letter-spacing:1px" x-text="$store.lang.t('Konten', 'Content', '内容', 'المحتوى')">Konten</div>
        <div style="font-size:13px;margin-bottom:10px"><a href="{{ route('blog.index') }}" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'"><span x-text="$store.lang.t('Blog & Artikel', 'Blog & Articles', '博客与文章', 'المدونة والمقالات')">Blog & Artikel</span></a></div>
        <div style="font-size:13px;margin-bottom:10px"><a href="https://ebook.m2b.co.id" target="_blank" style="color:#555;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#555'"><span x-text="$store.lang.t('Unduh E-Book ↗', 'Download E-Book ↗', '下载电子书 ↗', 'تحميل الكتاب الإلكتروني ↗')">Download E-Book ↗</span></a></div>
      </div>
    </div>
    <div style="background:#fafaf8;border:1px solid #e5e2dc;border-radius:16px;overflow:hidden;margin-bottom:32px;display:grid;grid-template-columns:1fr 1.5fr" class="footer-contact-grid">
      {{-- Kiri: Info Kontak --}}
      <div style="padding:24px 28px">
        <div style="font-family:Syne;font-weight:800;font-size:12px;color:#1e3a5f;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px" x-text="$store.lang.t('Hubungi Kami', 'Contact Us', '联系我们', 'اتصل بنا')">Hubungi Kami</div>
        <p style="font-size:12.5px;color:#666;line-height:1.75;margin-bottom:18px">Komplek Graha Metropolitan Blok G No. 24,<br>Jl. Kapten Sumarsono, Kp. Lalang,<br>Kec. Sunggal, Kota Medan 20114</p>
        @php
      $footerContacts = [
        ['📧','Email','sales@m2b.co.id','mailto:sales@m2b.co.id', 'Email'],
        ['📱','WhatsApp','+62 812-6302-7818','https://wa.me/6281263027818', 'WhatsApp'],
        ['🕒','Jam Buka','Senin–Sabtu · 08–17 WIB',null, 'Jam Buka'],
      ];
      @endphp
      @foreach($footerContacts as $fc)
        @php
          $fcLabelEn = [
            'Email' => 'Email',
            'WhatsApp' => 'WhatsApp',
            'Jam Buka' => 'Opening Hours'
          ][$fc[4]] ?? $fc[4];
          $fcLabelZh = [
            'Email' => '电子邮件',
            'WhatsApp' => '微信/WhatsApp',
            'Jam Buka' => '营业时间'
          ][$fc[4]] ?? $fc[4];
          $fcLabelAr = [
            'Email' => 'البريد الإلكتروني',
            'WhatsApp' => 'الواتساب',
            'Jam Buka' => 'ساعات العمل'
          ][$fc[4]] ?? $fc[4];
          
          $fcValEn = $fc[4] === 'Jam Buka' ? 'Monday–Saturday · 08–17 WIB' : $fc[2];
          $fcValZh = $fc[4] === 'Jam Buka' ? '周一至周六 · 08:00–17:00' : $fc[2];
          $fcValAr = $fc[4] === 'Jam Buka' ? 'الإثنين–السبت · ٠٨–١٧ بتوقيت غرب إندونيسيا' : $fc[2];
        @endphp
        <div style="display:flex;gap:10px;align-items:center;margin-bottom:12px">
          <div style="width:30px;height:30px;border-radius:8px;background:rgba(30,58,95,0.08);display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0">{{ $fc[0] }}</div>
          <div>
            <div style="font-size:10px;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;font-weight:600" x-text="$store.lang.t('{{ $fc[1] }}', '{{ $fcLabelEn }}', '{{ $fcLabelZh }}', '{{ $fcLabelAr }}')">{{ $fc[1] }}</div>
            @if($fc[3])<a href="{{ $fc[3] }}" style="font-size:13px;color:#1e3a5f;font-weight:600;text-decoration:none" x-text="$store.lang.t('{{ $fc[2] }}', '{{ $fcValEn }}', '{{ $fcValZh }}', '{{ $fcValAr }}')">{{ $fc[2] }}</a>
            @else<div style="font-size:13px;color:#1e3a5f;font-weight:600" x-text="$store.lang.t('{{ $fc[2] }}', '{{ $fcValEn }}', '{{ $fcValZh }}', '{{ $fcValAr }}')">{{ $fc[2] }}</div>@endif
          </div>
        </div>
      @endforeach
        <a href="https://maps.app.goo.gl/qxDf2EHjkEngXNGP7" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;font-size:12px;color:#4a9eda;font-weight:600;text-decoration:none" x-text="$store.lang.t('🗺️ Buka di Google Maps ↗', '🗺️ Open in Google Maps ↗', '🗺️ 在谷歌地图中打开 ↗', '🗺️ الفتح في خرائط جوجل ↗')">🗺️ Buka di Google Maps ↗</a>
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
        <a href="{{ route('terms') }}" style="color:#888;text-decoration:none" onmouseover="this.style.color='#1e3a5f'" onmouseout="this.style.color='#888'"><span x-text="$store.lang.t('Ketentuan Layanan', 'Terms of Service', '服务条款', 'شروط الخدمة')">Ketentuan Layanan</span></a>
      </div>
    </div>
  </div>
</footer>

{{-- Scroll to Top --}}
<button class="print-hide" x-data="{ show: false }" x-init="window.addEventListener('scroll', () => show = window.scrollY > 300)" x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="window.scrollTo({top:0,behavior:'smooth'})" style="position:fixed;bottom:155px;right:20px;z-index:998;width:44px;height:44px;border-radius:50%;background:#1e3a5f;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;box-shadow:0 4px 14px rgba(30,58,95,0.35);transition:background .2s" onmouseover="this.style.background='#162d4a'" onmouseout="this.style.background='#1e3a5f'">↑</button>

{{-- Floating Buttons (eBook, WhatsApp right; Language switcher left) --}}
<div class="print-hide">
  <x-floating-buttons />
</div>

{{-- MORA AI Chat Widget --}}
<div class="print-hide">
  <x-mora-widget />
</div>

{{-- B2B Cargo & Customs Inquiry Modal (Global) --}}
<div x-data="{
    openB2bInquiry: false,
    inquiryStep: 'policy',
    inquiryService: 'free_ship',
    inquiryName: '',
    inquiryCompany: '',
    inquiryNpwp: '',
    inquiryEmail: '',
    inquiryPhone: '',
    inquiryCargoDirection: 'impor',
    inquiryShipmentType: 'Sea FCL',
    inquiryVolume: '',
    inquiryOrigin: '',
    inquiryDestination: '',
    inquiryEstDate: '',
    inquiryLoading: false,
    inquirySuccess: false,
    inquiryInvoiceNo: '',
    inquiryId: null,
    inquiryWaText: '',

    resetB2bForm() {
      this.inquiryStep = 'policy';
      this.inquiryService = 'free_ship';
      this.inquiryName = '';
      this.inquiryCompany = '';
      this.inquiryNpwp = '';
      this.inquiryEmail = '';
      this.inquiryPhone = '';
      this.inquiryCargoDirection = 'impor';
      this.inquiryShipmentType = 'Sea FCL';
      this.inquiryVolume = '';
      this.inquiryOrigin = '';
      this.inquiryDestination = '';
      this.inquiryEstDate = '';
      this.inquiryLoading = false;
      this.inquirySuccess = false;
      this.inquiryInvoiceNo = '';
      this.inquiryId = null;
      this.inquiryWaText = '';
      
      const f1 = document.getElementById('b2b_invoice_file'); if (f1) f1.value = '';
      const f2 = document.getElementById('b2b_pl_file'); if (f2) f2.value = '';
      const f3 = document.getElementById('b2b_catalog_file'); if (f3) f3.value = '';
    },

    submitB2bForm() {
      if (!this.inquiryName || !this.inquiryCompany || !this.inquiryNpwp || !this.inquiryEmail || !this.inquiryPhone) {
        alert(this.$store.lang.t('Mohon lengkapi semua kolom wajib!', 'Please fill in all required fields!', '请填写所有必填字段！', 'يرجى ملء جميع الحقول المطلوبة!'));
        return;
      }
      
      // Volume is only required for Option B (free with shipping)
      if (this.inquiryService === 'free_ship' && !this.inquiryVolume) {
        alert(this.$store.lang.t('Mohon masukkan volume atau berat kargo Anda!', 'Please enter your cargo volume or weight!', '请输入您的货物运输体积或重量！', 'يرجى إدخال حجم أو وزن الشحنة!'));
        return;
      }
      
      this.inquiryLoading = true;
      
      const formData = new FormData();
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('name', this.inquiryName);
      formData.append('company', this.inquiryCompany);
      formData.append('npwp', this.inquiryNpwp);
      formData.append('email', this.inquiryEmail);
      formData.append('phone', this.inquiryPhone);
      formData.append('service_type', this.inquiryService);
      formData.append('cargo_direction', this.inquiryCargoDirection);
      formData.append('shipment_type', this.inquiryShipmentType);
      formData.append('volume', this.inquiryVolume);
      formData.append('route_origin', this.inquiryOrigin);
      formData.append('route_destination', this.inquiryDestination);
      formData.append('est_shipment_date', this.inquiryEstDate);
      
      const invoiceInput = document.getElementById('b2b_invoice_file');
      if (invoiceInput && invoiceInput.files[0]) {
        formData.append('invoice_file', invoiceInput.files[0]);
      }
      
      const plInput = document.getElementById('b2b_pl_file');
      if (plInput && plInput.files[0]) {
        formData.append('packing_list_file', plInput.files[0]);
      }
      
      const catInput = document.getElementById('b2b_catalog_file');
      if (catInput && catInput.files[0]) {
        formData.append('catalog_file', catInput.files[0]);
      }
      
      fetch('{{ route("b2b.inquiry.submit") }}', {
        method: 'POST',
        body: formData,
        headers: {
          'Accept': 'application/json'
        }
      })
      .then(res => {
        if (!res.ok) throw new Error('Network response failed');
        return res.json();
      })
      .then(data => {
        this.inquiryLoading = false;
        if (data.success) {
          this.inquiryInvoiceNo = data.invoice_no;
          this.inquiryId = data.inquiry_id;
          this.inquiryWaText = data.wa_text;
          
          if (this.inquiryService === 'paid') {
            this.inquiryStep = 'payment';
          } else {
            this.inquirySuccess = true;
            this.inquiryStep = 'result';
          }
        } else {
          alert(data.error || 'Terjadi kesalahan.');
        }
      })
      .catch(err => {
        this.inquiryLoading = false;
        console.error('B2B Inquiry error', err);
        alert('Gagal mengirim data. Periksa koneksi internet Anda atau coba lagi.');
      });
    }
  }" @open-b2b-modal.window="openB2bInquiry = true; resetB2bForm();" class="print-hide">

  <div x-show="openB2bInquiry" x-cloak @click="openB2bInquiry = false"
    style="position:fixed;inset:0;z-index:10000;background:rgba(11,17,32,0.85);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:center;padding:20px">
    
    <div @click.stop 
      style="background:#0B132B;border-radius:24px;max-width:640px;width:100%;max-height:94vh;overflow-y:auto;box-shadow:0 30px 70px rgba(0,0,0,0.8);border:1px solid rgba(255,255,255,0.08);display:flex;flex-direction:column;position:relative">
      
      <!-- Modal Header -->
      <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,0.08);padding:24px 32px">
        <div>
          <h3 style="font-family:Syne;font-weight:800;font-size:20px;color:#fff;letter-spacing:-0.5px" x-text="$store.lang.t('Inquiry Pengapalan B2B & Bea Cukai', 'B2B Shipping & Customs Inquiry', 'B2B 物流与清关询盘', 'استعلام الشحن والجمارك B2B')">Inquiry Pengapalan B2B & Bea Cukai</h3>
          <p style="font-size:11px;color:rgba(255,255,255,0.5);margin-top:4px" x-text="$store.lang.t('Hubungi tim ahli M2B untuk kalkulasi tarif resmi & penanganan Lartas', 'Contact M2B experts for official freight rates & customs compliance', '联系 M2B 专家以获取官方运费和报关合规建议', 'اتصل بخبراء M2B للحصول على أسعار الشحن والامتثال الجمركي')"></p>
        </div>
        <button @click="openB2bInquiry = false" style="background:rgba(255,255,255,0.05);border:none;border-radius:50%;color:rgba(255,255,255,0.6);width:32px;height:32px;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">✕</button>
      </div>

      <!-- STEP 1: POLICY & OPTION SELECTION -->
      <div x-show="inquiryStep === 'policy'" style="padding:32px;display:flex;flex-direction:column;gap:20px">
        <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:16px 20px;font-size:13px;color:rgba(255,255,255,0.85);line-height:1.6">
          <span style="font-weight:700;color:#f5b91c;" x-text="$store.lang.t('Kebijakan Layanan Konsultasi M2B:', 'M2B Consultation Policy:', 'M2B 咨询服务政策：', 'سياسة استشارات M2B:')"></span>
          <p style="margin-top:6px;font-size:12px;color:rgba(255,255,255,0.7)" x-text="$store.lang.t('Untuk memastikan pelayanan profesional terbaik dan memprioritaskan eksportir/importir komersial (B2B), kami memberlakukan ketentuan kualifikasi HS Code dan verifikasi dokumen Bea Cukai sebagai berikut:', 'To ensure the highest quality of service and prioritize commercial shippers (B2B), we apply the following guidelines for HS Code classification & customs document verification:', '为了确保最优质的专业服务并优先处理商业B2B货主，我们对海关编码归类及单证核查适用以下指南：', 'لضمان أعلى جودة من الخدمة وإعطاء الأولوية للشاحنين التجاريين (B2B)، نطبق الإرشادات التالية لتصنيف رموز HS والتحقق من المستندات الجمركية:')"></p>
        </div>

        <div style="display:flex;flex-direction:column;gap:12px">
          <!-- Option B (Free with shipping - Default) -->
          <label @click="inquiryService = 'free_ship'" 
            :style="inquiryService === 'free_ship' ? 'border-color:#4a9eda;background:rgba(74,158,218,0.08)' : 'border-color:rgba(255,255,255,0.08);background:rgba(255,255,255,0.02)'"
            style="border:1.5px solid;border-radius:14px;padding:16px 20px;cursor:pointer;display:flex;align-items:start;gap:14px;transition:all 0.2s">
            <input type="radio" name="inquiry_service_type_global" value="free_ship" :checked="inquiryService === 'free_ship'" style="margin-top:4px;accent-color:#4a9eda" />
            <div>
              <div style="font-weight:800;font-size:14px;color:#fff" x-text="$store.lang.t('Opsi B: Pengapalan dengan M2B (GRATIS)', 'Option B: Ship with M2B (FREE)', '选项 B：委托 M2B 运输出货（免费）', 'الخيار ب: الشحن مع M2B (مجاني)')">Opsi B: Pengapalan dengan M2B (GRATIS)</div>
              <div style="font-size:11.5px;color:rgba(255,255,255,0.5);margin-top:4px" x-text="$store.lang.t('Biaya verifikasi HS & Lartas Rp 0,- (FREE) khusus bagi calon klien yang mempercayakan pengapalan barangnya (Freight/Undername/Clearance) ke M2B.', 'Consultation is 100% FREE for clients who trust M2B to handle their cargo shipping, forwarding, undername, or customs clearance.', '对于委托 M2B 办理货物运输、货代、买单代理或清关的客户，咨询费用完全免费。', 'الاستشارة مجانية بنسبة 100% للعملاء الذين يثقون في M2B للتعامل مع شحن بضائعهم أو التخليص الجمركي.')"></div>
            </div>
          </label>

          <!-- Option A (Paid consultation) -->
          <label @click="inquiryService = 'paid'" 
            :style="inquiryService === 'paid' ? 'border-color:#4a9eda;background:rgba(74,158,218,0.08)' : 'border-color:rgba(255,255,255,0.08);background:rgba(255,255,255,0.02)'"
            style="border:1.5px solid;border-radius:14px;padding:16px 20px;cursor:pointer;display:flex;align-items:start;gap:14px;transition:all 0.2s">
            <input type="radio" name="inquiry_service_type_global" value="paid" :checked="inquiryService === 'paid'" style="margin-top:4px;accent-color:#4a9eda" />
            <div>
              <div style="font-weight:800;font-size:14px;color:#fff" x-text="$store.lang.t('Opsi A: Konsultasi / Riset Mandiri (Rp 150.000 / Item)', 'Option A: Independent Advisory (Rp 150,000 / Item)', '选项 A：独立付费咨询评估（15万印尼盾/品类）', 'الخيار أ: استشارة مستقلة (150,000 روبية / سلعة)')">Opsi A: Konsultasi / Riset Mandiri (Rp 150.000 / Item)</div>
              <div style="font-size:11.5px;color:rgba(255,255,255,0.5);margin-top:4px" x-text="$store.lang.t('Dikenakan biaya untuk riset HS/Lartas mendalam untuk kebutuhan studi kelayakan tanpa keharusan melakukan pengiriman barang melalui M2B.', 'A professional fee applies for detailed HS Code classification & Lartas analysis for feasibility studies, without shipping commitment.', '对于仅需进行可行性研究的海关编码及限制政策深入核查，无需委托发运货物的，收取专业咨询评估服务费。', 'تطبق رسوم احترافية لتصنيف رمز HS المفصل وتحليل لارتاس لدراسات الجدوى، دون التزام بالشحن.')"></div>
            </div>
          </label>
        </div>

        <button @click="inquiryStep = 'form'" 
          style="background:#1e3a5f;color:#fff;border:none;border-radius:10px;padding:14px;font-weight:800;font-size:14px;cursor:pointer;text-align:center;transition:background 0.2s" 
          onmouseover="this.style.background='#162d4a'" onmouseout="this.style.background='#1e3a5f'"
          x-text="$store.lang.t('Saya Setuju, Lanjutkan ke Formulir →', 'I Agree, Proceed to Form →', '我同意，继续填写表单 →', 'أوافق، الانتقال إلى النموذج ←')">
          Saya Setuju, Lanjutkan ke Formulir →
        </button>
      </div>

      <!-- STEP 2: FORM INPUTS -->
      <div x-show="inquiryStep === 'form'" style="padding:24px 32px 32px 32px;display:flex;flex-direction:column;gap:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,0.05);padding-bottom:10px">
          <span style="font-size:11px;font-weight:800;text-transform:uppercase;color:#4a9eda;letter-spacing:0.5px" x-text="inquiryService === 'paid' ? $store.lang.t('Opsi A: Detail Riset Mandiri', 'Option A: Independent Advisory Details', '选项 A：独立付费评估详情', 'الخيار أ: تفاصيل الاستشارة المستقلة') : $store.lang.t('Opsi B: Detail Kualifikasi Pengapalan', 'Option B: Shipping Qualification Details', '选项 B：委托运输资格详情', 'الخيار ب: تفاصيل تأهيل الشحن')">Opsi B: Detail Kualifikasi Pengapalan</span>
          <button @click="inquiryStep = 'policy'" style="background:transparent;border:none;color:#4a9eda;font-size:11px;font-weight:700;cursor:pointer" x-text="$store.lang.t('← Kembali', '← Back', '← 返回', '← العودة')">← Kembali</button>
        </div>

        <div style="display:flex;flex-direction:column;gap:12px">
          <!-- Company & NPWP (1 Row) -->
          <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:12px">
            <div>
              <label class="calc-label" x-text="$store.lang.t('Nama Perusahaan *', 'Company Name *', '公司名称 *', 'اسم الشركة *')">Nama Perusahaan *</label>
              <input type="text" x-model="inquiryCompany" placeholder="PT. Sukses Jaya" class="calc-input" required />
            </div>
            <div>
              <label class="calc-label" x-text="$store.lang.t('NPWP Perusahaan *', 'Company Tax ID (NPWP) *', '公司税号 *', 'الرقم الضريبي للشركة *')">NPWP Perusahaan *</label>
              <input type="text" x-model="inquiryNpwp" placeholder="01.234.567.8-xxx.xxx" class="calc-input" required />
            </div>
          </div>

          <!-- Contact Name & Phone (1 Row) -->
          <div style="display:grid;grid-template-columns:1fr 1.1fr;gap:12px">
            <div>
              <label class="calc-label" x-text="$store.lang.t('Nama Kontak *', 'Contact Name *', '联系人姓名 *', 'اسم جهة الاتصال *')">Nama Kontak *</label>
              <input type="text" x-model="inquiryName" placeholder="Fauzan" class="calc-input" required />
            </div>
            <div>
              <label class="calc-label" x-text="$store.lang.t('No. HP / WhatsApp (Aktif) *', 'WhatsApp / Phone Number *', '联系电话/微信 *', 'رقم الهاتف/الواتساب *')">No. HP / WhatsApp (Aktif) *</label>
              <input type="tel" x-model="inquiryPhone" placeholder="08126302xxxx" class="calc-input" required />
            </div>
          </div>

          <!-- Email -->
          <div>
            <label class="calc-label" x-text="$store.lang.t('Email Bisnis *', 'Business Email *', '商业电子邮件 *', 'البريد الإلكتروني للعمل *')">Email Bisnis *</label>
            <input type="email" x-model="inquiryEmail" placeholder="sales@perusahaan.com" class="calc-input" required />
          </div>

          <!-- Jalur Pengiriman (Impor/Ekspor/Domestik) -->
          <div>
            <label class="calc-label" x-text="$store.lang.t('Jalur Pengiriman *', 'Shipment Route / Direction *', '运输航线/方向 *', 'مسار الشحن *')">Jalur Pengiriman *</label>
            <select x-model="inquiryCargoDirection" class="calc-select">
              <option value="impor">📥 Impor (Import) — Kargo Masuk ke Indonesia</option>
              <option value="ekspor">📤 Ekspor (Export) — Kargo Keluar dari Indonesia</option>
              <option value="domestik">🇮🇩 Domestik (Domestic) — Antar Pulau / Daerah</option>
            </select>
          </div>

          <!-- Shipment Type & Volume (1 Row) -->
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
            <div>
              <label class="calc-label" x-text="inquiryService === 'free_ship' ? $store.lang.t('Mode Pengiriman *', 'Shipment Mode *', '运输方式 *', 'طريقة الشحن *') : $store.lang.t('Mode Pengiriman (Opsional)', 'Shipment Mode (Optional)', '运输方式（选填）', 'طريقة الشحن (اختياري)')">Mode Pengiriman *</label>
              <select x-model="inquiryShipmentType" class="calc-select">
                <option value="Sea FCL">🚢 Sea Freight - FCL (Container)</option>
                <option value="Sea LCL">🚢 Sea Freight - LCL (Cargo Eceran)</option>
                <option value="Air Cargo">✈️ Air Freight (Cargo Udara)</option>
              </select>
            </div>
            <div>
              <label class="calc-label" x-text="inquiryService === 'free_ship' ? $store.lang.t('Volume / Berat Barang *', 'Volume / Weight *', '货量/毛重 *', 'الحجم / الوزن *') : $store.lang.t('Volume / Berat Barang (Opsional)', 'Volume / Weight (Optional)', '货量/毛重（选填）', 'الحجم / الوزن (اختياري)')">Volume / Berat Barang *</label>
              <input type="text" x-model="inquiryVolume" placeholder="Contoh: 1x20 Ft / 5.000 kg" class="calc-input" />
            </div>
          </div>

          <!-- Route & Date (1 Row) -->
          <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:12px">
            <div>
              <label class="calc-label" x-text="inquiryService === 'free_ship' ? $store.lang.t('Rute: Pelabuhan Asal & Tujuan', 'Route: Loading & Discharge Ports', '航线：始发港与目的港', 'خط السير: ميناء الشحن والوصول') : $store.lang.t('Rute: Pelabuhan Asal & Tujuan (Opsional)', 'Route: Loading & Discharge Ports (Optional)', '航线（选填）', 'خط السير (اختياري)')">Rute: Pelabuhan Asal & Tujuan</label>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px">
                <input type="text" x-model="inquiryOrigin" placeholder="POL (Shanghai)" class="calc-input" style="font-size:12px!important" />
                <input type="text" x-model="inquiryDestination" placeholder="POD (Belawan)" class="calc-input" style="font-size:12px!important" />
              </div>
            </div>
            <div>
              <label class="calc-label" x-text="inquiryService === 'free_ship' ? $store.lang.t('Estimasi Tanggal Kirim', 'Est. Shipment Date', '预计出运日期', 'تاريخ الشحن المتوقع') : $store.lang.t('Estimasi Tanggal Kirim (Opsional)', 'Est. Date (Optional)', '预计出运日期（选填）', 'تاريخ الشحن المتوقع (اختياري)')">Estimasi Tanggal Kirim</label>
              <input type="text" x-model="inquiryEstDate" placeholder="Contoh: Akhir Bulan Ini" class="calc-input" />
            </div>
          </div>

          <!-- Document Upload Box (Invoice & Packing List) -->
          <div style="background:rgba(255,255,255,0.02);border:1px dashed rgba(255,255,255,0.15);border-radius:14px;padding:16px;margin-top:6px">
            <div style="font-size:10px;font-weight:800;color:#f5b91c;text-transform:uppercase;margin-bottom:12px;letter-spacing:0.5px;display:flex;align-items:center;gap:6px">
              <span>🔒</span>
              <span x-text="$store.lang.t('JAMINAN KERAHASIAAN DOKUMEN & DATA (NDA)', 'CONFIDENTIALITY & NDA ASSURANCE', '单证与数据保密承诺', 'ضمان السرية واتفاقية عدم الإفصاح')">JAMINAN KERAHASIAAN DOKUMEN & DATA (NDA)</span>
            </div>
            
            <p style="font-size:10px;color:rgba(255,255,255,0.5);line-height:1.4;margin-bottom:14px" x-text="$store.lang.t('M2B menjamin kerahasiaan invoice & packing list Anda. Dokumen hanya digunakan untuk verifikasi Lartas & tarif kepabeanan resmi di Bea Cukai.', 'M2B guarantees the confidentiality of your documents. File uploads are strictly protected and only used for tariff verification & customs clearance assessment.', 'M2B 承诺对您的所有单证严格保密。上传的文件受到严格保护，仅用于税率验证和海关合规评估。', 'تضمن M2B سرية مستنداتك. الملفات المرفوعة محمية بشكل صارم وتستخدم فقط للتحقق من التعرفة.')"></p>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
              <div>
                <label class="calc-label" style="font-size:9.5px!important" x-text="$store.lang.t('Upload Invoice (PDF/Img) *', 'Invoice File (PDF/Img) *', '上传发票 (PDF/图片) *', 'تحميل الفاتورة *')">Upload Invoice (PDF/Img) *</label>
                <input type="file" id="b2b_invoice_file" accept=".pdf,image/*" style="font-size:11px;color:rgba(255,255,255,0.6)" />
              </div>
              <div>
                <label class="calc-label" style="font-size:9.5px!important" x-text="$store.lang.t('Upload Packing List (PDF/Img)', 'Packing List File (PDF/Img)', '上传箱单 (PDF/图片)', 'تحميل بيان التعبئة')">Upload Packing List (PDF/Img)</label>
                <input type="file" id="b2b_pl_file" accept=".pdf,image/*" style="font-size:11px;color:rgba(255,255,255,0.6)" />
              </div>
            </div>
            <div style="margin-top:10px">
              <label class="calc-label" style="font-size:9.5px!important" x-text="$store.lang.t('Upload Brosur / Spek Teknis (Opsional)', 'Technical Specs / Catalog (Optional)', '上传产品说明书/技术规格书（选填）', 'تحميل الكتالوج / المواصفات الفنية')">Upload Brosur / Spek Teknis (Opsional)</label>
              <input type="file" id="b2b_catalog_file" accept=".pdf,image/*" style="font-size:11px;color:rgba(255,255,255,0.6);width:100%" />
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <button @click="submitB2bForm()" :disabled="inquiryLoading"
          style="background:linear-gradient(135deg, #10b981 0%, #059669 100%);color:#fff;border:none;border-radius:10px;padding:16px;font-weight:800;font-size:15px;cursor:pointer;text-align:center;box-shadow:0 8px 25px rgba(16,185,129,0.3);transition:transform 0.2s;display:flex;align-items:center;justify-content:center;gap:10px"
          onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
          <span x-show="inquiryLoading" style="display:inline-block;width:16px;height:16px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin 0.8s linear infinite"></span>
          <span x-text="inquiryLoading ? $store.lang.t('Mengirim Data...', 'Submitting...', '正在提交...', 'جاري التقديم...') : $store.lang.t('Kirim Inquiry & Dokumen →', 'Submit Inquiry & Documents →', '提交询盘与单证 →', 'تقديم الاستفسار والمستندات ←')"></span>
        </button>
      </div>

      <!-- STEP 3: PROFORMA INVOICE & PAYMENT (ONLY FOR OPTION A) -->
      <div x-show="inquiryStep === 'payment'" style="padding:24px 32px 32px 32px;display:flex;flex-direction:column;gap:18px">
        <!-- Proforma Invoice Header -->
        <div style="background:#fff;color:#0f0f14;padding:24px;border-radius:14px;border:1px solid #e5e2dc;box-shadow:0 4px 15px rgba(0,0,0,0.1);display:flex;flex-direction:column;gap:14px">
          <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e5e2dc;padding-bottom:12px">
            <span style="font-family:Syne;font-weight:800;font-size:14px;color:#1e3a5f" x-text="$store.lang.t('PROFORMA INVOICE', 'PROFORMA INVOICE', '形式发票', 'الفاتورة الأولية')">PROFORMA INVOICE</span>
            <code style="font-weight:700;color:#666;font-size:12px" x-text="inquiryInvoiceNo"></code>
          </div>
          
          <table style="width:100%;font-size:12.5px;color:#333;border-collapse:collapse">
            <tr>
              <th style="text-align:left;padding:6px 0;font-weight:500;color:#777" x-text="$store.lang.t('Nama Perusahaan', 'Company Name', '公司名称', 'اسم الشركة')">Nama Perusahaan</th>
              <td style="text-align:right;padding:6px 0;font-weight:700" x-text="inquiryCompany"></td>
            </tr>
            <tr>
              <th style="text-align:left;padding:6px 0;font-weight:500;color:#777" x-text="$store.lang.t('Keterangan', 'Description', '服务项目', 'الوصف')">Keterangan</th>
              <td style="text-align:right;padding:6px 0;font-weight:700" x-text="$store.lang.t('Jasa Analisis Klasifikasi HS & Lartas', 'Customs HS & Lartas Analysis Service', '海关归类与进口限制核查服务', 'خدمة تصنيف رمز HS وتحليل القيود')">Jasa Analisis Klasifikasi HS & Lartas</td>
            </tr>
            <tr style="border-top:1px dashed #ccc;border-bottom:1px dashed #ccc">
              <th style="text-align:left;padding:10px 0;font-weight:700;color:#1e3a5f" x-text="$store.lang.t('Total Tagihan', 'Total Invoice', '总计金额', 'إجمالي الفاتورة')">Total Tagihan</th>
              <td style="text-align:right;padding:10px 0;font-weight:800;color:#1e3a5f;font-size:16px">Rp 150.000,-</td>
            </tr>
          </table>

          <!-- Bank Details -->
          <div style="background:#f4f7f6;border-radius:10px;padding:14px 18px;border-left:4px solid #1e3a5f">
            <span style="font-size:10px;font-weight:800;color:#777;text-transform:uppercase;display:block" x-text="$store.lang.t('METODE PEMBAYARAN: TRANSFER BANK', 'PAYMENT METHOD: BANK TRANSFER', '付款方式：银行转账', 'طريقة الدفع: تحويل بنكي')">METODE PEMBAYARAN: TRANSFER BANK</span>
            <div style="font-family:Syne;font-weight:800;font-size:16px;color:#1e3a5f;margin-top:6px">BANK MANDIRI</div>
            <div style="font-family:monospace;font-size:18px;font-weight:800;color:#0f0f14;letter-spacing:1px;margin-top:4px">1060055988896</div>
            <div style="font-size:12px;font-weight:700;color:#333;margin-top:2px">a.n. PT. Mora Multi Berkah</div>
          </div>
        </div>

        <div style="background:rgba(245,185,28,0.1);border-left:3px solid #f5b91c;padding:12px;border-radius:4px;font-size:11px;color:rgba(255,255,255,0.85);line-height:1.5">
          <span x-text="$store.lang.t('💡 Setelah melakukan transfer bank, klik tombol di bawah untuk melampirkan bukti pembayaran via WhatsApp agar staf kami langsung melakukan verifikasi pabean.', '💡 After transferring, click the button below to send the payment slip via WhatsApp so our team can start the customs audit immediately.', '💡 转账成功后，请点击下方按钮通过 WhatsApp 发送付款水单，以便我们的报关团队立即开始核查。', '💡 بعد التحويل، انقر فوق الزر أدناه لإرسال إيصال الدفع عبر الواتساب ليبدأ فريقنا التدقيق فوراً.')"></span>
        </div>

        <!-- WA Confirm Button -->
        <a :href="'https://wa.me/6281263027818?text=' + inquiryWaText" target="_blank"
          @click="openB2bInquiry = false"
          style="background:#25D366;color:#fff;text-align:center;padding:15px;border-radius:10px;text-decoration:none;font-weight:800;font-size:14px;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 8px 20px rgba(37,211,102,0.3);transition:transform 0.2s"
          onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
          <span>💬</span>
          <span x-text="$store.lang.t('Kirim Bukti Bayar & Konfirmasi via WhatsApp', 'Send Payment Slip & Confirm via WhatsApp', '发送付款水单并微信/WhatsApp确认', 'إرسال إيصال الدفع والتأكيد عبر الواتساب')">Kirim Bukti Bayar & Konfirmasi via WhatsApp</span>
        </a>
      </div>

      <!-- STEP 4: SUCCESS RESULT (ONLY FOR OPTION B) -->
      <div x-show="inquiryStep === 'result'" style="padding:32px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:20px">
        <div style="width:68px;height:68px;border-radius:50%;background:rgba(16,185,129,0.1);color:#10b981;display:flex;align-items:center;justify-content:center;font-size:32px">✓</div>
        
        <div>
          <h4 style="font-family:Syne;font-weight:800;font-size:18px;color:#fff" x-text="$store.lang.t('Inquiry Berhasil Terkirim!', 'Inquiry Successfully Submitted!', '询盘提交成功！', 'تم تقديم الاستفسار بنجاح!')">Inquiry Berhasil Terkirim!</h4>
          <p style="font-size:12.5px;color:rgba(255,255,255,0.6);line-height:1.6;margin-top:8px" x-text="$store.lang.t('Tim B2B & Customs Broker M2B telah menerima berkas Invoice/Packing List Anda. Notifikasi data dan lampiran file juga telah otomatis dikirimkan ke email sales@m2b.co.id.', 'M2B B2B & Customs Broker team has received your documents. Email notification and attachments have also been automatically sent to sales@m2b.co.id.', 'M2B 物流与报关行团队已收到您的单证。邮件通知及附件也已自动发送至 sales@m2b.co.id。', 'تلقى فريق الجمارك والشحن مستنداتك. تم إرسال إشعار بالبريد الإلكتروني والمرفقات تلقائياً إلى sales@m2b.co.id.')"></p>
        </div>

        <div style="background:rgba(74,158,218,0.08);border-radius:12px;padding:16px;width:100%;font-size:12px;color:rgba(255,255,255,0.8);line-height:1.5">
          <span x-text="$store.lang.t('💡 Klik tombol di bawah untuk membuka chat WhatsApp M2B agar tim sales kami dapat segera memberikan penawaran harga pengiriman dan penanganan Lartas Anda dalam 15-30 menit.', '💡 Click the button below to open M2B WhatsApp chat so our team can provide your shipping quote and customs advisory in 15-30 minutes.', '💡 点击下方按钮打开 M2B 微信/WhatsApp 聊天，以便我们的团队在 15-30 分钟内向您提供运费报价 and 报关合规建议。', '💡 انقر فوق الزر أدناه لفتح دردشة الواتساب لتزويدك بعرض أسعار الشحن والاستشارات الجمركية في غضون ١٥-٣٠ دقيقة.')"></span>
        </div>

        <!-- Redirect WA Button -->
        <a :href="'https://wa.me/6281263027818?text=' + inquiryWaText" target="_blank"
          @click="openB2bInquiry = false"
          style="background:#25D366;color:#fff;text-align:center;padding:15px;border-radius:10px;text-decoration:none;font-weight:800;font-size:14px;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 8px 20px rgba(37,211,102,0.3);width:100%;transition:transform 0.2s"
          onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
          <span>💬</span>
          <span x-text="$store.lang.t('Hubungi Sales M2B via WhatsApp', 'Contact M2B Sales via WhatsApp', '通过微信/WhatsApp联系销售人员', 'الاتصال بالمبيعات عبر الواتساب')">Hubungi Sales M2B via WhatsApp</span>
        </a>
      </div>

    </div>
  </div>

</div>

</body>
</html>
