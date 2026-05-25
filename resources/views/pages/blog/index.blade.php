@extends('layouts.app')
@section('title', 'Blog & Artikel — M2B Logistik')
@section('description', 'Artikel terbaru seputar ekspor-impor, regulasi bea cukai, dan tips logistik dari tim M2B.')

@section('head')
<style>
@media(max-width:768px){
  .blog-grid{grid-template-columns:1fr!important}
  .blog-hero-h1{font-size:34px!important}
  .blog-hero{padding:48px 20px 40px!important}
  .blog-section{padding:40px 20px!important}
  .blog-featured-card{grid-template-columns:1fr!important}
  .blog-featured-card > div:first-child{min-height:200px!important}
}
@media(min-width:769px) and (max-width:1024px){
  .blog-grid{grid-template-columns:repeat(2,1fr)!important}
}
</style>
@endsection

@section('content')
<div style="background:#0f0f14;padding:64px 40px 56px" class="blog-hero">
  <div style="max-width:1200px;margin:0 auto">
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase;margin-bottom:16px">Blog & Artikel</span>
    <h1 style="font-family:Syne;font-weight:800;font-size:48px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1" class="blog-hero-h1">Update Logistik &<br><span style="color:#4a9eda">Shipment</span></h1>
    <p style="color:rgba(255,255,255,0.6);font-size:17px;max-width:540px;margin-bottom:28px">Info terkini seputar pelabuhan, regulasi bea cukai, dan kegiatan pengiriman internasional.</p>
    {{-- Search bar --}}
    <div style="max-width:480px;display:flex;gap:0;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.18);border-radius:10px;overflow:hidden;backdrop-filter:blur(12px)">
      <div style="padding:0 14px;display:flex;align-items:center;color:rgba(255,255,255,0.4);font-size:16px">🔍</div>
      <input id="blog-search" type="text" placeholder="Cari artikel..." oninput="filterBlog(this.value)"
        style="flex:1;background:transparent;border:none;outline:none;color:#fff;font-size:14px;padding:13px 0;font-family:'DM Sans'">
      <button onclick="document.getElementById('blog-search').value='';filterBlog('')" style="padding:0 14px;background:transparent;border:none;color:rgba(255,255,255,0.3);cursor:pointer;font-size:18px;line-height:1">×</button>
    </div>
    <div id="blog-search-count" style="margin-top:10px;font-size:12px;color:rgba(255,255,255,0.35);display:none"></div>
  </div>
</div>

<section style="padding:60px 40px;background:#f7f5f0" x-data="{ active: 'Semua' }" class="blog-section">
  <div style="max-width:1200px;margin:0 auto">
    @if($categories->count() > 0)
    <div style="display:flex;gap:8px;margin-bottom:36px;flex-wrap:wrap;align-items:center">
      <span style="font-size:11px;color:#999;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-right:4px">Filter:</span>
      <button @click="active='Semua'" :style="active==='Semua' ? 'background:#1e3a5f;color:#fff;border-color:#1e3a5f' : 'background:#fff;color:#555;border-color:#e5e2dc'" style="padding:6px 16px;border-radius:20px;border:1.5px solid;cursor:pointer;font-size:13px;font-weight:600;transition:all .15s">Semua</button>
      @foreach($categories as $cat)
      <button @click="active='{{ $cat }}'" :style="active==='{{ $cat }}' ? 'background:#1e3a5f;color:#fff;border-color:#1e3a5f' : 'background:#fff;color:#555;border-color:#e5e2dc'" style="padding:6px 16px;border-radius:20px;border:1.5px solid;cursor:pointer;font-size:13px;font-weight:600;transition:all .15s">{{ $cat }}</button>
      @endforeach
      <span style="margin-left:auto;font-size:12px;color:#bbb">{{ $posts->total() }} artikel</span>
    </div>
    @endif

    {{-- Featured post (first item, full width) --}}
    @if($posts->count() > 0)
    @php $featured = $posts->first(); @endphp
    @php
      $fc = strtolower($featured->category ?? '');
      if(str_contains($fc,'ekspor')) { $fbg='linear-gradient(135deg,#1e3a5f 0%,#1a6b3a 100%)'; $fem='🚢'; }
      elseif(str_contains($fc,'impor')) { $fbg='linear-gradient(135deg,#1e3a5f 0%,#4a2a7f 100%)'; $fem='📥'; }
      elseif(str_contains($fc,'bea cukai')) { $fbg='linear-gradient(135deg,#5f2a1e 0%,#1e3a5f 100%)'; $fem='🛃'; }
      else { $fbg='linear-gradient(135deg,#1e3a5f 0%,#2a5298 100%)'; $fem='📦'; }
    @endphp
    <a href="{{ route('blog.show', $featured->slug) }}" x-show="active === 'Semua' || active === '{{ $featured->category }}'"
      style="text-decoration:none;border-radius:16px;overflow:hidden;border:1px solid #e5e2dc;background:#fff;display:grid;grid-template-columns:1fr 1fr;margin-bottom:28px;transition:all .2s;box-shadow:0 2px 8px rgba(0,0,0,0.06)"
      onmouseover="this.style.boxShadow='0 12px 40px rgba(0,0,0,0.13)';this.style.transform='translateY(-2px)'"
      onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)';this.style.transform='none'" class="blog-featured-card">
      @if($featured->featured_image)
      <div style="min-height:300px;background-image:url({{ Storage::url($featured->featured_image) }});background-size:cover;background-position:center"></div>
      @else
      <div style="min-height:300px;background:{{ $fbg }};display:flex;align-items:center;justify-content:center;font-size:72px">{{ $fem }}</div>
      @endif
      <div style="padding:36px 32px;display:flex;flex-direction:column;justify-content:center">
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(245,185,28,0.15);color:#b8860b;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;border:1px solid rgba(245,185,28,0.3)">★ Artikel Pilihan</span>
        @if($featured->category)<span style="display:inline-block;padding:3px 8px;border-radius:4px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase;margin-bottom:14px">{{ $featured->category }}</span>@endif
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

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px" class="blog-grid">
      @forelse($posts as $i => $post)
      @continue($i === 0)
      @php
        $cat = strtolower($post->category ?? '');
        if(str_contains($cat,'bea cukai') && str_contains($cat,'ekspor')) {
          $bg='linear-gradient(135deg,#1e3a5f 0%,#7a3a1e 100%)'; $em='📋';
        } elseif(str_contains($cat,'bea cukai') && str_contains($cat,'impor')) {
          $bg='linear-gradient(135deg,#3a1e5f 0%,#1e3a5f 100%)'; $em='🛃';
        } elseif(str_contains($cat,'bea cukai')) {
          $bg='linear-gradient(135deg,#5f2a1e 0%,#1e3a5f 100%)'; $em='🛃';
        } elseif(str_contains($cat,'ekspor') && str_contains($cat,'impor')) {
          $bg='linear-gradient(135deg,#1e3a5f 0%,#2a7a5f 100%)'; $em='🌐';
        } elseif(str_contains($cat,'ekspor')) {
          $bg='linear-gradient(135deg,#1e3a5f 0%,#1a6b3a 100%)'; $em='🚢';
        } elseif(str_contains($cat,'impor')) {
          $bg='linear-gradient(135deg,#1e3a5f 0%,#4a2a7f 100%)'; $em='📥';
        } elseif(str_contains($cat,'umkm')) {
          $bg='linear-gradient(135deg,#1e3a5f 0%,#7f5a1e 100%)'; $em='🏪';
        } else {
          $bg='linear-gradient(135deg,#1e3a5f 0%,#2a5298 100%)'; $em='📦';
        }
      @endphp
      <a href="{{ route('blog.show', $post->slug) }}" x-show="active === 'Semua' || active === '{{ $post->category }}'" class="blog-post-card" data-title="{{ strtolower($post->title) }}" style="text-decoration:none;border-radius:12px;overflow:hidden;border:1px solid #e5e2dc;background:#fff;display:flex;flex-direction:column;transition:all .2s" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,0.1)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='none';this.style.transform='none'">
        @if($post->featured_image)
        <div style="height:210px;background-image:url({{ Storage::url($post->featured_image) }});background-size:cover;background-position:center"></div>
        @else
        <div style="height:210px;background:{{ $bg }};display:flex;align-items:center;justify-content:center;font-size:52px">{{ $em }}</div>
        @endif
        <div style="padding:22px 24px;flex:1;display:flex;flex-direction:column">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;flex-wrap:wrap">
            @if($post->category)<span style="padding:3px 8px;border-radius:4px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase">{{ $post->category }}</span>@endif
            <span style="font-size:11px;color:#bbb">{{ $post->published_at?->format('d M Y') }}</span>
          </div>
          <h2 style="font-family:Syne;font-weight:700;font-size:16px;line-height:1.45;color:#0f0f14;margin-bottom:10px;flex:1">{{ $post->title }}</h2>
          @if($post->excerpt)<p style="font-size:13px;color:#777;line-height:1.7;margin-bottom:14px">{{ Str::limit($post->excerpt, 100) }}</p>@endif
          <div style="display:flex;justify-content:space-between;align-items:center;padding-top:12px;border-top:1px solid #f0ede8;font-size:12px">
            <span style="color:#999">⏱ {{ $post->reading_time }} menit baca</span>
            <span style="color:#1e3a5f;font-weight:600">Baca selengkapnya →</span>
          </div>
        </div>
      </a>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:80px 40px;color:#999">
        <div style="font-size:48px;margin-bottom:16px">📝</div>
        <p>Belum ada artikel yang dipublikasikan.</p>
      </div>
      @endforelse
    </div>

    @if($posts->hasPages())
    <div style="margin-top:48px;display:flex;justify-content:center">{{ $posts->links() }}</div>
    @endif

    {{-- Newsletter / CTA strip --}}
    <div style="margin-top:56px;background:linear-gradient(135deg,#0B1120 0%,#1e3a5f 100%);border-radius:20px;padding:40px 48px;display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap">
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

<script>
function filterBlog(q) {
  const term = q.toLowerCase().trim();
  const cards = document.querySelectorAll('.blog-post-card');
  let visible = 0;
  cards.forEach(c => {
    const title = c.dataset.title || '';
    const show = !term || title.includes(term);
    c.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  const counter = document.getElementById('blog-search-count');
  if (term) {
    counter.textContent = visible + ' artikel ditemukan untuk "' + q + '"';
    counter.style.display = 'block';
  } else {
    counter.style.display = 'none';
  }
}
</script>
@endsection
