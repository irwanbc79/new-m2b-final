@extends('layouts.app')
@section('title', 'Blog & Artikel — M2B Logistik')
@section('description', 'Artikel terbaru seputar ekspor-impor, regulasi bea cukai, dan tips logistik dari tim M2B.')

@section('head')
<style>
.cat-pills::-webkit-scrollbar{display:none}
.cat-pills{-ms-overflow-style:none;scrollbar-width:none}
@media(max-width:768px){
  .blog-grid{grid-template-columns:1fr!important}
  .blog-hero-h1{font-size:34px!important}
  .blog-hero{padding:48px 20px 40px!important}
  .blog-section{padding:40px 20px!important}
  .blog-featured-card{grid-template-columns:1fr!important}
  .blog-featured-card > div:first-child{min-height:200px!important}
  .infeed-cta{padding:24px 20px!important}
  .infeed-cta-btns{flex-direction:column!important}
  .newsletter-strip{padding:28px 20px!important;flex-direction:column!important}
}
@media(min-width:769px) and (max-width:1024px){
  .blog-grid{grid-template-columns:repeat(2,1fr)!important}
}
</style>
@endsection

@section('content')
<div x-data="{ search: '' }">

{{-- ═══ HERO ═══ --}}
<div style="background:#0f0f14;padding:64px 40px 48px" class="blog-hero">
  <div style="max-width:1200px;margin:0 auto">
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase;margin-bottom:16px">Blog & Artikel</span>
    <h1 style="font-family:Syne;font-weight:800;font-size:48px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1" class="blog-hero-h1">Update Logistik &<br><span style="color:#4a9eda">Shipment</span></h1>
    <p style="color:rgba(255,255,255,0.6);font-size:17px;max-width:540px;margin-bottom:24px">Info terkini seputar pelabuhan, regulasi bea cukai, dan kegiatan pengiriman internasional.</p>

    {{-- Search --}}
    <div style="max-width:480px;display:flex;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.18);border-radius:10px;overflow:hidden;backdrop-filter:blur(12px)">
      <div style="padding:0 14px;display:flex;align-items:center;color:rgba(255,255,255,0.4);font-size:16px">🔍</div>
      <input x-model.debounce.300ms="search" type="text" placeholder="Cari artikel, topik, atau kategori..."
        style="flex:1;background:transparent;border:none;outline:none;color:#fff;font-size:14px;padding:13px 0;font-family:'DM Sans'">
      <button @click="search=''" x-show="search !== ''" x-cloak
        style="padding:0 16px;background:transparent;border:none;color:rgba(255,255,255,0.5);cursor:pointer;font-size:18px;line-height:1;font-family:'DM Sans'">×</button>
    </div>

    {{-- Category pills — server-side filter --}}
    <div class="cat-pills" style="display:flex;gap:8px;margin-top:20px;overflow-x:auto;padding-bottom:2px;align-items:center">
      <a href="{{ route('blog.index') }}"
        style="padding:6px 18px;border-radius:20px;border:1.5px solid;text-decoration:none;font-size:13px;font-weight:600;transition:all .15s;white-space:nowrap;font-family:'DM Sans';{{ !$category ? 'background:#4a9eda;color:#fff;border-color:#4a9eda' : 'background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.6);border-color:rgba(255,255,255,0.18)' }}">Semua</a>
      @foreach($categories as $cat)
      <a href="{{ route('blog.index', ['category' => $cat]) }}"
        style="padding:6px 18px;border-radius:20px;border:1.5px solid;text-decoration:none;font-size:13px;font-weight:600;transition:all .15s;white-space:nowrap;font-family:'DM Sans';{{ $category === $cat ? 'background:#4a9eda;color:#fff;border-color:#4a9eda' : 'background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.6);border-color:rgba(255,255,255,0.18)' }}">{{ $cat }}</a>
      @endforeach
    </div>

    {{-- Active filter indicator --}}
    <div style="margin-top:10px;display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.4);flex-wrap:wrap">
      @if($category)
      <span style="padding:2px 10px;border-radius:12px;background:rgba(74,158,218,0.15);color:#4a9eda;border:1px solid rgba(74,158,218,0.3)">📂 {{ $category }}</span>
      <a href="{{ route('blog.index') }}" style="color:#4a9eda;text-decoration:underline;font-family:'DM Sans'">Reset ×</a>
      @endif
      <span x-show="search !== ''" x-cloak x-text="'🔍 &quot;' + search + '&quot;'" style="padding:2px 10px;border-radius:12px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15)"></span>
    </div>

    <div style="margin-top:12px;font-size:12px;color:rgba(255,255,255,0.2)">
      {{ $posts->total() }} artikel{{ $category ? ' dalam kategori ' . $category : ' tersedia' }}
    </div>
  </div>
</div>

{{-- ═══ GRID SECTION ═══ --}}
<section style="padding:60px 40px;background:#f7f5f0" class="blog-section">
  <div style="max-width:1200px;margin:0 auto">

    {{-- Featured post --}}
    @if($posts->count() > 0)
    @php
      $featured = $posts->first();
      $fc = $featured->category ?? '';
      match($fc) {
        'Ekspor'       => [$fbg, $fem] = ['linear-gradient(135deg,#1e3a5f 0%,#1a6b3a 100%)', '🚢'],
        'Impor'        => [$fbg, $fem] = ['linear-gradient(135deg,#1e3a5f 0%,#4a2a7f 100%)', '📥'],
        'UMKM'         => [$fbg, $fem] = ['linear-gradient(135deg,#1e3a5f 0%,#7f5a1e 100%)', '🏪'],
        'Bea Cukai'    => [$fbg, $fem] = ['linear-gradient(135deg,#5f2a1e 0%,#1e3a5f 100%)', '🛃'],
        default        => [$fbg, $fem] = ['linear-gradient(135deg,#1e3a5f 0%,#2a5298 100%)', '📦'],
      };
      $fDaysOld = $featured->published_at ? now()->diffInDays($featured->published_at) : 999;
      $fIsNew = $fDaysOld <= 7;
      $fIsUpdated = $featured->updated_at && $featured->updated_at->diffInDays(now()) < 14
                    && $featured->updated_at->gt($featured->published_at?->addDays(3) ?? now());
      $fIsHot = isset($hotIds) && in_array($featured->id, $hotIds);
      $fSearch = strtolower($featured->title . ' ' . ($featured->excerpt ?? '') . ' ' . ($featured->category ?? ''));
    @endphp
    <a href="{{ route('blog.show', $featured->slug) }}"
       data-search="{{ $fSearch }}"
       x-show="search === '' || $el.dataset.search.includes(search.toLowerCase())"
       style="text-decoration:none;border-radius:16px;overflow:hidden;border:1px solid #e5e2dc;background:#fff;display:grid;grid-template-columns:1fr 1fr;margin-bottom:28px;transition:all .2s;box-shadow:0 2px 8px rgba(0,0,0,0.06)"
       onmouseover="this.style.boxShadow='0 12px 40px rgba(0,0,0,0.13)';this.style.transform='translateY(-2px)'"
       onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)';this.style.transform='none'" class="blog-featured-card">
      @if($featured->featured_image)
      <div style="min-height:300px;background-image:url({{ Storage::url($featured->featured_image) }});background-size:cover;background-position:center"></div>
      @else
      <div style="min-height:300px;background:{{ $fbg }};display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden">
        <span style="position:absolute;font-size:160px;opacity:0.08;line-height:1">{{ $fem }}</span>
        <span style="font-size:64px;position:relative;z-index:1">{{ $fem }}</span>
      </div>
      @endif
      <div style="padding:36px 32px;display:flex;flex-direction:column;justify-content:center">
        <div style="display:flex;gap:6px;align-items:center;margin-bottom:14px;flex-wrap:wrap">
          <span style="padding:3px 10px;border-radius:20px;background:rgba(245,185,28,0.15);color:#b8860b;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border:1px solid rgba(245,185,28,0.3)">★ Artikel Pilihan</span>
          @if($featured->category)<span style="padding:3px 8px;border-radius:4px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase">{{ $featured->category }}</span>@endif
          @if($fIsNew)<span style="padding:2px 6px;border-radius:4px;background:#16a34a;color:#fff;font-size:10px;font-weight:700">BARU</span>
          @elseif($fIsUpdated)<span style="padding:2px 6px;border-radius:4px;background:#ea580c;color:#fff;font-size:10px;font-weight:700">DIPERBARUI</span>@endif
          @if($fIsHot)<span style="padding:2px 6px;border-radius:4px;background:#dc2626;color:#fff;font-size:10px;font-weight:700">🔥 POPULER</span>@endif
        </div>
        <h2 style="font-family:Syne;font-weight:800;font-size:22px;line-height:1.35;color:#0f0f14;margin-bottom:12px">{{ $featured->title }}</h2>
        @if($featured->excerpt)<p style="font-size:14px;color:#666;line-height:1.75;margin-bottom:18px">{{ Str::limit($featured->excerpt, 160) }}</p>@endif
        <div style="display:flex;align-items:center;gap:16px;font-size:12px;color:#999;margin-top:auto">
          <span>{{ $featured->published_at?->format('d M Y') }}</span>
          <span>⏱ {{ $featured->reading_time }} menit baca</span>
          <span style="margin-left:auto;color:#1e3a5f;font-weight:700;font-size:13px">Baca selengkapnya →</span>
        </div>
      </div>
    </a>
    @endif

    {{-- Ad setelah featured post — posisi paling visible sebelum grid --}}
    <x-adsense-block type="in_feed" format="auto" />

    {{-- Post grid --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px" class="blog-grid">
      @php $cardIndex = 0; @endphp
      @forelse($posts as $i => $post)
      @continue($i === 0)
      @php
        match($post->category ?? '') {
          'Ekspor'    => [$bg, $em] = ['linear-gradient(135deg,#1e3a5f 0%,#1a6b3a 100%)', '🚢'],
          'Impor'     => [$bg, $em] = ['linear-gradient(135deg,#1e3a5f 0%,#4a2a7f 100%)', '📥'],
          'UMKM'      => [$bg, $em] = ['linear-gradient(135deg,#1e3a5f 0%,#7f5a1e 100%)', '🏪'],
          'Bea Cukai' => [$bg, $em] = ['linear-gradient(135deg,#5f2a1e 0%,#1e3a5f 100%)', '🛃'],
          default     => [$bg, $em] = ['linear-gradient(135deg,#1e3a5f 0%,#2a5298 100%)', '📦'],
        };
        $daysOld = $post->published_at ? now()->diffInDays($post->published_at) : 999;
        $isNew     = $daysOld <= 7;
        $isUpdated = $post->updated_at && $post->updated_at->diffInDays(now()) < 14
                     && $post->updated_at->gt($post->published_at?->addDays(3) ?? now());
        $isHot     = isset($hotIds) && in_array($post->id, $hotIds);
        $searchData = strtolower($post->title . ' ' . ($post->excerpt ?? '') . ' ' . ($post->category ?? ''));
      @endphp

      {{-- In-feed E-book CTA after card 3 --}}
      @if($cardIndex === 3)
      <div style="grid-column:1/-1;background:linear-gradient(135deg,#fffbeb 0%,#fef3c7 100%);border:1.5px solid #f5b91c;border-radius:16px;padding:28px 36px;display:flex;align-items:center;gap:28px;flex-wrap:wrap" class="infeed-cta">
        <div style="font-size:44px;flex-shrink:0">📘</div>
        <div style="flex:1;min-width:200px">
          <div style="font-family:Syne;font-weight:800;font-size:17px;color:#0f0f14;margin-bottom:4px">Toolkit Ekspor-Impor GRATIS untuk Anda</div>
          <div style="font-size:13px;color:#6b5a1e;line-height:1.55">Checklist dokumen, template, & panduan praktis dari tim expert M2B — 5+ tahun pengalaman lapangan.</div>
        </div>
        <div class="infeed-cta-btns" style="display:flex;gap:10px;flex-shrink:0">
          <a href="https://ebook.m2b.co.id/toolkit.html" target="_blank" style="display:inline-flex;align-items:center;gap:6px;padding:11px 22px;border-radius:10px;background:#0f0f14;color:#fff;text-decoration:none;font-weight:700;font-size:13px;white-space:nowrap">Download Gratis ↗</a>
        </div>
      </div>
      @endif

      {{-- In-feed AdSense after card 5 --}}
      @if($cardIndex === 5)
      <div style="grid-column:1/-1">
        <x-adsense-block type="in_feed" format="auto" />
      </div>
      @endif

      {{-- In-feed WhatsApp CTA after card 7 --}}
      @if($cardIndex === 7)
      <div style="grid-column:1/-1;background:linear-gradient(135deg,#0B1120 0%,#1e3a5f 100%);border-radius:16px;padding:28px 36px;display:flex;align-items:center;gap:28px;flex-wrap:wrap" class="infeed-cta">
        <div style="font-size:44px;flex-shrink:0">💬</div>
        <div style="flex:1;min-width:200px">
          <div style="font-family:Syne;font-weight:800;font-size:17px;color:#fff;margin-bottom:4px">Ada Pertanyaan Seputar Ekspor-Impor?</div>
          <div style="font-size:13px;color:rgba(255,255,255,0.6);line-height:1.55">Tim M2B siap bantu konsultasi gratis. Respon cepat, solusi nyata untuk kebutuhan logistik Anda.</div>
        </div>
        <div class="infeed-cta-btns" style="display:flex;gap:10px;flex-shrink:0">
          <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20konsultasi%20ekspor-impor" target="_blank" style="display:inline-flex;align-items:center;gap:6px;padding:11px 22px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:13px;white-space:nowrap">💬 Konsultasi Gratis</a>
        </div>
      </div>
      @endif

      {{-- Post card --}}
      <a href="{{ route('blog.show', $post->slug) }}"
         data-search="{{ $searchData }}"
         x-show="search === '' || $el.dataset.search.includes(search.toLowerCase())"
         style="text-decoration:none;border-radius:12px;overflow:hidden;border:1px solid #e5e2dc;background:#fff;display:flex;flex-direction:column;transition:all .2s"
         onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,0.1)';this.style.transform='translateY(-2px)'"
         onmouseout="this.style.boxShadow='none';this.style.transform='none'">

        @if($post->featured_image)
        {{-- Image card header --}}
        <div style="height:210px;background-image:url({{ Storage::url($post->featured_image) }});background-size:cover;background-position:center"></div>
        <div style="padding:20px 24px;flex:1;display:flex;flex-direction:column">
          <div style="display:flex;align-items:center;gap:6px;margin-bottom:10px;flex-wrap:wrap">
            @if($post->category)<span style="padding:3px 8px;border-radius:4px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase">{{ $post->category }}</span>@endif
            @if($isNew)<span style="padding:2px 6px;border-radius:4px;background:#16a34a;color:#fff;font-size:10px;font-weight:700">BARU</span>
            @elseif($isUpdated)<span style="padding:2px 6px;border-radius:4px;background:#ea580c;color:#fff;font-size:10px;font-weight:700">DIPERBARUI</span>@endif
            @if($isHot)<span style="padding:2px 6px;border-radius:4px;background:#dc2626;color:#fff;font-size:10px;font-weight:700">🔥 POPULER</span>@endif
            <span style="font-size:11px;color:#bbb;margin-left:auto">{{ $post->published_at?->format('d M Y') }}</span>
          </div>
          <h2 style="font-family:Syne;font-weight:700;font-size:16px;line-height:1.45;color:#0f0f14;margin-bottom:8px;flex:1">{{ $post->title }}</h2>
          @if($post->excerpt)<p style="font-size:13px;color:#777;line-height:1.7;margin-bottom:12px">{{ Str::limit($post->excerpt, 100) }}</p>@endif
          <div style="display:flex;justify-content:space-between;align-items:center;padding-top:12px;border-top:1px solid #f0ede8;font-size:12px">
            <span style="color:#999">⏱ {{ $post->reading_time }} menit baca</span>
            <span style="color:#1e3a5f;font-weight:600">Baca →</span>
          </div>
        </div>

        @else
        {{-- Text-focused card: thin accent strip + watermark icon, more text space --}}
        <div style="height:68px;background:{{ $bg }};position:relative;overflow:hidden;display:flex;align-items:center;padding:0 20px;flex-shrink:0">
          <span style="position:absolute;right:-4px;top:-10px;font-size:76px;opacity:0.18;line-height:1;pointer-events:none;user-select:none">{{ $em }}</span>
          <div style="display:flex;gap:5px;align-items:center;position:relative;z-index:1;flex-wrap:wrap">
            @if($post->category)<span style="padding:3px 8px;border-radius:4px;background:rgba(255,255,255,0.2);color:#fff;font-size:10px;font-weight:700;text-transform:uppercase;border:1px solid rgba(255,255,255,0.2)">{{ $post->category }}</span>@endif
            @if($isNew)<span style="padding:2px 6px;border-radius:4px;background:#16a34a;color:#fff;font-size:10px;font-weight:700">BARU</span>
            @elseif($isUpdated)<span style="padding:2px 6px;border-radius:4px;background:#ea580c;color:#fff;font-size:10px;font-weight:700">DIPERBARUI</span>@endif
            @if($isHot)<span style="padding:2px 6px;border-radius:4px;background:#dc2626;color:#fff;font-size:10px;font-weight:700">🔥 POPULER</span>@endif
          </div>
        </div>
        <div style="padding:20px 24px;flex:1;display:flex;flex-direction:column">
          <div style="font-size:11px;color:#bbb;margin-bottom:8px">{{ $post->published_at?->format('d M Y') }}</div>
          <h2 style="font-family:Syne;font-weight:700;font-size:17px;line-height:1.4;color:#0f0f14;margin-bottom:10px;flex:1">{{ $post->title }}</h2>
          @if($post->excerpt)<p style="font-size:13px;color:#666;line-height:1.75;margin-bottom:12px">{{ Str::limit($post->excerpt, 130) }}</p>@endif
          <div style="display:flex;justify-content:space-between;align-items:center;padding-top:12px;border-top:1px solid #f0ede8;font-size:12px">
            <span style="color:#999">⏱ {{ $post->reading_time }} menit baca</span>
            <span style="color:#1e3a5f;font-weight:600">Baca →</span>
          </div>
        </div>
        @endif

      </a>
      @php $cardIndex++; @endphp

      @empty
      <div style="grid-column:1/-1;text-align:center;padding:80px 40px;color:#999">
        <div style="font-size:48px;margin-bottom:16px">📝</div>
        <p>Belum ada artikel yang dipublikasikan.</p>
      </div>
      @endforelse
    </div>

    {{-- Reset hint when search active --}}
    <div x-show="search !== ''" x-cloak style="margin-top:16px;text-align:center">
      <p style="font-size:13px;color:#aaa">Tidak menemukan yang dicari? <button @click="search=''" style="color:#1e3a5f;font-weight:600;background:none;border:none;cursor:pointer;font-family:'DM Sans';text-decoration:underline">Hapus pencarian</button></p>
    </div>

    @if($posts->hasPages())
    <div style="margin-top:48px;display:flex;justify-content:center">{{ $posts->appends(request()->only('category'))->links() }}</div>
    @endif

    {{-- Newsletter / CTA strip --}}
    <div style="margin-top:56px;background:linear-gradient(135deg,#0B1120 0%,#1e3a5f 100%);border-radius:20px;padding:40px 48px;display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap" class="newsletter-strip">
      <div>
        <div style="font-family:Syne;font-weight:800;font-size:20px;color:#fff;margin-bottom:6px">Jangan Lewatkan Update Logistik</div>
        <p style="font-size:14px;color:rgba(255,255,255,0.55);max-width:420px">Tips ekspor-impor, regulasi terbaru, dan insight bisnis logistik langsung dari tim M2B.</p>
      </div>
      <div style="display:flex;gap:10px;flex-shrink:0;flex-wrap:wrap">
        <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20mau%20subscribe%20update%20logistik" target="_blank"
          style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:14px">💬 Subscribe via WhatsApp</a>
        <a href="https://ebook.m2b.co.id" target="_blank"
          style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;border-radius:10px;background:rgba(255,255,255,0.1);color:#fff;text-decoration:none;font-weight:600;font-size:14px;border:1px solid rgba(255,255,255,0.2)">📘 Download E-Book</a>
      </div>
    </div>
  </div>
</section>

</div>{{-- end x-data --}}
@endsection
