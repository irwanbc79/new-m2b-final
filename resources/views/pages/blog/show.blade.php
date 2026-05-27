@extends('layouts.app')

@section('og_image', $post->featured_image_url)

@section('og_type', 'article')
@section('head')
<meta property="article:published_time" content="{{ $post->published_at?->toISOString() }}">
<meta property="article:modified_time" content="{{ $post->updated_at?->toISOString() }}">
@if($post->category)<meta property="article:section" content="{{ $post->category }}">@endif
<meta property="article:author" content="PT. Mora Multi Berkah (M2B)">
<style>
.prose-m2b{line-height:1.9;font-size:16px;color:#333}
.prose-m2b h1,.prose-m2b h2,.prose-m2b h3,.prose-m2b h4{font-family:Syne,sans-serif;font-weight:800;color:#0f0f14;margin-top:2em;margin-bottom:.6em;line-height:1.3;letter-spacing:-0.4px}
.prose-m2b h2{font-size:22px;border-bottom:2px solid #f0ede8;padding-bottom:10px}
.prose-m2b h3{font-size:18px;color:#1e3a5f}
.prose-m2b h4{font-size:16px;color:#1e3a5f}
.prose-m2b p{margin-bottom:1.25em}
.prose-m2b ul,.prose-m2b ol{padding-left:1.6em;margin-bottom:1.25em}
.prose-m2b ul{list-style:disc}
.prose-m2b ol{list-style:decimal}
.prose-m2b li{margin-bottom:.5em;line-height:1.8}
.prose-m2b strong{font-weight:700;color:#0f0f14}
.prose-m2b em{font-style:italic;color:#555}
.prose-m2b a{color:#1e3a5f;font-weight:600;text-decoration:underline;text-underline-offset:3px}
.prose-m2b a:hover{color:#2a5298}
.prose-m2b img{max-width:100%;height:auto;border-radius:10px;margin:20px auto;display:block;box-shadow:0 4px 20px rgba(0,0,0,0.1)}
.prose-m2b figure{margin:24px 0;text-align:center}
.prose-m2b figcaption{font-size:13px;color:#999;margin-top:8px;font-style:italic}
.prose-m2b blockquote{border-left:4px solid #1e3a5f;padding:16px 20px;margin:24px 0;background:#f7f5f0;border-radius:0 10px 10px 0;font-style:italic;color:#555;font-size:15px}
.prose-m2b hr,.prose-m2b .wp-block-separator{border:none;border-top:2px solid #f0ede8;margin:2em 0}
.prose-m2b table{width:100%;border-collapse:collapse;margin:24px 0;font-size:14px;border-radius:10px;overflow:hidden;border:1px solid #e5e2dc}
.prose-m2b th{background:#1e3a5f;color:#fff;padding:12px 16px;text-align:left;font-family:Syne;font-weight:700;font-size:13px}
.prose-m2b td{padding:11px 16px;border-bottom:1px solid #f0ede8;color:#444}
.prose-m2b tr:last-child td{border-bottom:none}
.prose-m2b tr:nth-child(even) td{background:#fafaf8}
.prose-m2b pre{background:#0f0f14;color:#e5e5e5;padding:20px 24px;border-radius:10px;overflow-x:auto;font-size:13px;margin:20px 0;line-height:1.7}
.prose-m2b code{background:#f0ede8;padding:2px 6px;border-radius:4px;font-size:13px;color:#1e3a5f;font-weight:600}
.prose-m2b pre code{background:transparent;padding:0;color:inherit;font-weight:normal}
.prose-m2b .wp-block-list{list-style:disc;padding-left:1.6em}
.prose-m2b .wp-block-heading{font-family:Syne,sans-serif;font-weight:800;color:#0f0f14}
.prose-m2b .wp-block-table{margin:24px 0}
.prose-m2b .wp-block-table table{width:100%;border-collapse:collapse;border-radius:10px;overflow:hidden;border:1px solid #e5e2dc}
.prose-m2b .wp-block-table th{background:#1e3a5f;color:#fff;padding:12px 16px;text-align:left;font-weight:700}
.prose-m2b .wp-block-table td{padding:11px 16px;border-bottom:1px solid #f0ede8}
.prose-m2b .wp-block-quote{border-left:4px solid #1e3a5f;padding:16px 20px;margin:24px 0;background:#f7f5f0;border-radius:0 10px 10px 0}
.prose-m2b .wp-block-callout,.prose-m2b .wp-block-info{background:#e8f0fb;border:1px solid #c5d9f5;border-radius:10px;padding:16px 20px;margin:20px 0}
@media(max-width:768px){
  .prose-m2b{font-size:15px}
  .prose-m2b h2{font-size:19px}
  .prose-m2b h3{font-size:16px}
  .prose-m2b table{font-size:13px}
  .related-grid{grid-template-columns:1fr!important}
  .share-row{flex-direction:column!important;align-items:stretch!important}
  .share-row a{justify-content:center!important}
  .blog-article-box{padding:28px 20px!important}
  .blog-hero{padding:48px 20px 40px!important}
  .blog-hero h1{font-size:28px!important}
}
</style>
{{-- Article JSON-LD --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Article",
  "headline": "{{ addslashes($post->title) }}",
  "description": "{{ addslashes($post->meta_description) }}",
  "image": "{{ $post->featured_image_url }}",
  "datePublished": "{{ $post->published_at?->toISOString() }}",
  "dateModified": "{{ $post->updated_at?->toISOString() }}",
  "author": {"@@type":"Organization","name":"PT. Mora Multi Berkah (M2B)","url":"https://m2b.co.id"},
  "publisher": {"@@type":"Organization","name":"PT. Mora Multi Berkah (M2B)","logo":{"@@type":"ImageObject","url":"{{ asset('images/logo-m2b.png') }}"}},
  "url": "{{ url()->current() }}",
  "mainEntityOfPage": "{{ url()->current() }}"
}
</script>
@endsection

@section('title', $post->meta_title)
@section('description', $post->meta_description)

@section('content')
{{-- Reading progress bar --}}
<div id="reading-progress" style="position:fixed;top:0;left:0;height:3px;background:linear-gradient(90deg,#1e3a5f,#4a9eda);width:0%;z-index:9999;transition:width .08s linear"></div>
<script>
window.addEventListener('scroll',function(){
  var el=document.getElementById('article-body');
  if(!el)return;
  var s=el.offsetTop,e=s+el.offsetHeight-window.innerHeight;
  document.getElementById('reading-progress').style.width=Math.min(100,Math.max(0,((window.scrollY-s)/(e-s))*100))+'%';
});
</script>
<div style="background:#0f0f14;padding:64px 40px 56px" class="blog-hero">
  <div style="max-width:800px;margin:0 auto">
    <a href="{{ route('blog.index') }}" style="display:inline-flex;align-items:center;gap:8px;color:#4a9eda;text-decoration:none;font-size:14px;margin-bottom:24px">← Kembali ke Blog</a>
    @if($post->category)<span style="display:inline-block;padding:3px 8px;border-radius:4px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase;margin-bottom:16px">{{ $post->category }}</span>@endif
    <h1 style="font-family:Syne;font-weight:800;font-size:40px;color:#fff;letter-spacing:-1px;margin-bottom:16px;line-height:1.2">{{ $post->title }}</h1>
    <div style="display:flex;gap:16px;font-size:13px;color:rgba(255,255,255,0.5);flex-wrap:wrap;align-items:center">
      <span>{{ $post->published_at?->format('d F Y') }}</span>
      <span>·</span>
      <span>⏱ {{ $post->reading_time }} menit baca</span>
    </div>
  </div>
</div>

<section style="padding:60px 40px;background:#f7f5f0">
  <div style="max-width:800px;margin:0 auto">
    @if($post->featured_image)
    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" loading="lazy" style="width:100%;height:420px;object-fit:cover;border-radius:16px;margin-bottom:40px;box-shadow:0 12px 40px rgba(0,0,0,0.12)">
    @endif

    <div id="article-body" style="background:#fff;border-radius:16px;padding:48px;border:1px solid #e5e2dc" class="prose-m2b blog-article-box">
      @php
        $rawContent = preg_replace('/<!--.*?-->/s', '', $post->content);
        $paragraphs = explode('</p>', $rawContent);
        $total = count($paragraphs);
      @endphp
      @foreach($paragraphs as $i => $para)
        {!! $para !!}@if($i < $total - 1)</p>@endif
        @if($i === 3)<x-adsense-block type="in_content" />@endif
        @if($total > 10 && $i === 8)<x-adsense-block type="in_content" />@endif
      @endforeach
    </div>

    {{-- Post-read ad — zona engagement tinggi setelah selesai baca --}}
    <x-adsense-block type="post_read" />

    {{-- Social Sharing --}}
    <div style="margin-top:32px;padding:20px 28px;background:#fff;border-radius:12px;border:1px solid #e5e2dc;display:flex;align-items:center;gap:12px;flex-wrap:wrap" class="share-row">
      <span style="font-size:13px;font-weight:600;color:#555;white-space:nowrap;flex-shrink:0">Bagikan artikel ini:</span>
      <a href="https://wa.me/?text={{ urlencode($post->title . ' — ' . url()->current()) }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;background:#25D366;color:#fff;text-decoration:none;font-weight:600;font-size:13px">💬 WhatsApp</a>
      <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;background:#000;color:#fff;text-decoration:none;font-weight:600;font-size:13px">𝕏 Twitter</a>
      <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;background:#0A66C2;color:#fff;text-decoration:none;font-weight:600;font-size:13px">in LinkedIn</a>
      <button onclick="navigator.clipboard.writeText(window.location.href);this.textContent='✅ Link disalin!';setTimeout(()=>this.textContent='🔗 Salin Link',2000)" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;background:#f0ede8;color:#333;border:1px solid #e5e2dc;cursor:pointer;font-weight:600;font-size:13px;font-family:DM Sans">🔗 Salin Link</button>
      <a href="{{ route('blog.index') }}" style="margin-left:auto;color:#1e3a5f;text-decoration:none;font-weight:600;font-size:14px;white-space:nowrap">← Semua Artikel</a>
    </div>

    {{-- Ebook CTA Banner --}}
    <div style="margin-top:32px;background:linear-gradient(135deg,#0f0f14 0%,#1e3a5f 100%);border-radius:16px;padding:32px 36px;display:flex;align-items:center;gap:28px;flex-wrap:wrap">
      <div style="font-size:48px;flex-shrink:0">📘</div>
      <div style="flex:1;min-width:220px">
        <div style="font-family:Syne;font-weight:800;font-size:18px;color:#fff;margin-bottom:6px">Download Toolkit E-Book Ekspor Impor — GRATIS</div>
        <div style="font-size:14px;color:rgba(255,255,255,0.65);line-height:1.6">Toolkit lengkap ekspor-impor: checklist dokumen, template, & panduan praktis untuk pemula & UMKM. Ditulis oleh tim expert M2B dari pengalaman 5+ tahun lapangan.</div>
      </div>
      <a href="https://ebook.m2b.co.id/toolkit.html" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:10px;background:#f5b91c;color:#0f0f14;text-decoration:none;font-weight:700;font-size:14px;white-space:nowrap;flex-shrink:0">Download Toolkit Gratis ↗</a>
    </div>

    <div style="margin-top:16px;text-align:center">
      <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20baca%20artikel:%20{{ urlencode($post->title) }}" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:8px;background:#25D366;color:#fff;text-decoration:none;font-weight:600;font-size:13px">💬 Ada pertanyaan seputar artikel ini? Chat kami</a>
    </div>

    @if($related->count() > 0)
    <div style="margin-top:56px">
      <h3 style="font-family:Syne;font-weight:800;font-size:22px;margin-bottom:24px">Artikel Terkait</h3>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px" class="related-grid">
        @foreach($related as $r)
        <a href="{{ route('blog.show', $r->slug) }}" style="text-decoration:none;border-radius:10px;overflow:hidden;border:1px solid #e5e2dc;background:#fff;transition:box-shadow .2s" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
          <div style="height:140px;background:{{ $r->featured_image ? 'url('.Storage::url($r->featured_image).') center/cover' : 'linear-gradient(135deg,#1e3a5f,#2a5298)' }}"></div>
          <div style="padding:14px 16px">
            <div style="font-family:Syne;font-weight:700;font-size:14px;line-height:1.4;color:#0f0f14;margin-bottom:8px">{{ Str::limit($r->title, 70) }}</div>
            <span style="font-size:12px;color:#1e3a5f;font-weight:600">Baca →</span>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</section>
@endsection
