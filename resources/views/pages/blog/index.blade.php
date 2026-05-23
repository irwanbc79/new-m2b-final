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
    <p style="color:rgba(255,255,255,0.6);font-size:17px;max-width:540px">Info terkini seputar pelabuhan, regulasi bea cukai, dan kegiatan pengiriman internasional.</p>
  </div>
</div>

<section style="padding:60px 40px;background:#f7f5f0" x-data="{ active: 'Semua' }" class="blog-section">
  <div style="max-width:1200px;margin:0 auto">
    @if($categories->count() > 0)
    <div style="display:flex;gap:8px;margin-bottom:36px;flex-wrap:wrap">
      <button @click="active='Semua'" :style="active==='Semua' ? 'background:#1e3a5f;color:#fff' : 'background:#f0ede8;color:#666'" style="padding:6px 16px;border-radius:20px;border:none;cursor:pointer;font-size:13px;font-weight:500;font-family:DM Sans;transition:all .15s">Semua</button>
      @foreach($categories as $cat)
      <button @click="active='{{ $cat }}'" :style="active==='{{ $cat }}' ? 'background:#1e3a5f;color:#fff' : 'background:#f0ede8;color:#666'" style="padding:6px 16px;border-radius:20px;border:none;cursor:pointer;font-size:13px;font-weight:500;font-family:DM Sans;transition:all .15s">{{ $cat }}</button>
      @endforeach
    </div>
    @endif

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px" class="blog-grid">
      @forelse($posts as $post)
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
      <a href="{{ route('blog.show', $post->slug) }}" x-show="active === 'Semua' || active === '{{ $post->category }}'" style="text-decoration:none;border-radius:12px;overflow:hidden;border:1px solid #e5e2dc;background:#fff;display:flex;flex-direction:column;transition:all .2s" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,0.1)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='none';this.style.transform='none'">
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
  </div>
</section>
@endsection
