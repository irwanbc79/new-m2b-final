@extends('layouts.app')
@section('title', 'Blog & Artikel — M2B Logistik')
@section('description', 'Artikel terbaru seputar ekspor-impor, regulasi bea cukai, dan tips logistik dari tim M2B.')

@section('head')
<link rel="alternate" type="application/rss+xml" title="M2B Blog — Ekspor Impor" href="{{ route('blog.feed') }}">
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
  .blog-main-layout{grid-template-columns: 1fr!important;}
}
@media(min-width:769px) and (max-width:1024px){
  .blog-grid{grid-template-columns:repeat(2,1fr)!important}
}
</style>
@endsection

@section('content')
<div x-data="{ search: '{{ $search ?? '' }}' }">

{{-- ═══ HERO ═══ --}}
<div style="background:linear-gradient(135deg, #0B1120 0%, #1e3a5f 100%); padding: 80px 20px 60px; position: relative; overflow: hidden;" class="blog-hero">
  <div style="position: absolute; inset: 0; background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 0); background-size: 24px 24px; opacity: 0.3;"></div>
  <div style="max-width:1200px; margin:0 auto; position: relative; z-index: 10;">
    <span style="display:inline-block; padding:4px 12px; border-radius:20px; background:rgba(74,158,218,0.2); color:#4a9eda; font-size:11px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:16px; border: 1px solid rgba(74,158,218,0.3);" x-text="$store.lang.t('Blog & Artikel', 'Blog & Articles', '博客与文章', 'المدونة والمقالات')">Blog & Artikel</span>
    <h1 style="font-family:Syne; font-weight:800; font-size:52px; color:#fff; letter-spacing:-1.5px; margin-bottom:16px; line-height:1.05" class="blog-hero-h1">
      <span x-text="$store.lang.t('Update Logistik &', 'Logistics &', '物流与', 'تحديثات اللوجستيات و')">Update Logistik &</span><br>
      <span style="color:#4a9eda" x-text="$store.lang.t('Shipment', 'Shipment Updates', '货运动态', 'الشحن')">Shipment</span>
    </h1>
    <p style="color:rgba(255,255,255,0.7); font-size:17px; max-width:560px; margin-bottom:28px" x-text="$store.lang.t('Info terkini seputar pelabuhan, regulasi bea cukai, dan kegiatan pengiriman internasional.', 'Latest info on ports, customs regulations, and international shipping activities.', '关于港口、海关法规以及国际航运活动的最新信息。', 'أحدث المعلومات حول الموانئ، ولوائح الجمارك، وأنشطة الشحن الدولي.')">Info terkini seputar pelabuhan, regulasi bea cukai, dan kegiatan pengiriman internasional.</p>

    {{-- Search --}}
    <div style="max-width:480px; display:flex; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); border-radius:12px; overflow:hidden; backdrop-filter:blur(16px); box-shadow: 0 8px 32px rgba(0,0,0,0.2);">
      <div style="padding:0 16px; display:flex; align-items:center; color:rgba(255,255,255,0.4); font-size:16px">🔍</div>
      <input x-model.debounce.300ms="search" type="text" :placeholder="$store.lang.t('Cari artikel, topik, atau kategori...', 'Search articles, topics, or categories...', '搜索文章、主题或分类...', 'البحث عن المقالات أو المواضيع أو الفئات...')"
        style="flex:1; background:transparent; border:none; outline:none; color:#fff; font-size:14px; padding:14px 0; font-family:'DM Sans'">
      <button @click="search=''" x-show="search !== ''" x-cloak
        style="padding:0 16px; background:transparent; border:none; color:rgba(255,255,255,0.5); cursor:pointer; font-size:18px; line-height:1; font-family:'DM Sans'">×</button>
    </div>

    {{-- Category pills --}}
    <div class="cat-pills" style="display:flex; gap:8px; margin-top:24px; overflow-x:auto; padding-bottom:4px; align-items:center">
      <a href="{{ route('blog.index') }}"
        style="padding:8px 20px; border-radius:20px; border:1.5px solid; text-decoration:none; font-size:13px; font-weight:700; transition:all .2s; white-space:nowrap; font-family:'DM Sans'; {{ !$category ? 'background:#4a9eda; color:#fff; border-color:#4a9eda; box-shadow: 0 4px 14px rgba(74,158,218,0.3);' : 'background:rgba(255,255,255,0.06); color:rgba(255,255,255,0.6); border-color:rgba(255,255,255,0.12)' }}"
        x-text="$store.lang.t('Semua', 'All', '全部', 'الكل')">Semua</a>
      @foreach($categories as $cat)
      @php
        $catEn = [
          'Ekspor' => 'Export',
          'Impor' => 'Import',
          'UMKM' => 'SME',
          'Bea Cukai' => 'Customs',
        ][$cat] ?? $cat;

        $catZh = [
          'Ekspor' => '出口',
          'Impor' => '进口',
          'UMKM' => '中小企业',
          'Bea Cukai' => '海关与报关',
        ][$cat] ?? $catEn;

        $catAr = [
          'Ekspor' => 'التصدير',
          'Impor' => 'الاستيراد',
          'UMKM' => 'الشركات الصغيرة والمتوسطة',
          'Bea Cukai' => 'الجمارك',
        ][$cat] ?? $catEn;
      @endphp
      <a href="{{ route('blog.index', ['category' => $cat]) }}"
        style="padding:8px 20px; border-radius:20px; border:1.5px solid; text-decoration:none; font-size:13px; font-weight:700; transition:all .2s; white-space:nowrap; font-family:'DM Sans'; {{ $category === $cat ? 'background:#4a9eda; color:#fff; border-color:#4a9eda; box-shadow: 0 4px 14px rgba(74,158,218,0.3);' : 'background:rgba(255,255,255,0.06); color:rgba(255,255,255,0.6); border-color:rgba(255,255,255,0.12)' }}"
        x-text="$store.lang.t('{{ $cat }}', '{{ $catEn }}', '{{ $catZh }}', '{{ $catAr }}')">{{ $cat }}</a>
      @endforeach
    </div>

    {{-- Active filter indicator --}}
    <div style="margin-top:14px; display:flex; align-items:center; gap:8px; font-size:12px; color:rgba(255,255,255,0.4); flex-wrap:wrap">
      @if($category)
      @php
        $catEn = [
          'Ekspor' => 'Export',
          'Impor' => 'Import',
          'UMKM' => 'SME',
          'Bea Cukai' => 'Customs',
        ][$category] ?? $category;

        $catZh = [
          'Ekspor' => '出口',
          'Impor' => '进口',
          'UMKM' => '中小企业',
          'Bea Cukai' => '海关与报关',
        ][$category] ?? $catEn;

        $catAr = [
          'Ekspor' => 'التصدير',
          'Impor' => 'الاستيراد',
          'UMKM' => 'الشركات الصغيرة والمتوسطة',
          'Bea Cukai' => 'الجمارك',
        ][$category] ?? $catEn;
      @endphp
      <span style="padding:3px 12px; border-radius:12px; background:rgba(74,158,218,0.15); color:#4a9eda; border:1px solid rgba(74,158,218,0.3)">
        📂 <span x-text="$store.lang.t('{{ $category }}', '{{ $catEn }}', '{{ $catZh }}', '{{ $catAr }}')">{{ $category }}</span>
      </span>
      <a href="{{ route('blog.index') }}" style="color:#4a9eda; text-decoration:underline; font-family:'DM Sans'; font-weight:600;" x-text="$store.lang.t('Reset ×', 'Reset ×', '重置 ×', 'إعادة تعيين ×')">Reset ×</a>
      @endif
      <span x-show="search !== ''" x-cloak x-text="'🔍 &quot;' + search + '&quot;'" style="padding:3px 12px; border-radius:12px; background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.15)"></span>
    </div>

    <div style="margin-top:14px; font-size:12px; color:rgba(255,255,255,0.35); font-weight: 500;">
      <span x-text="$store.lang.t(
        '{{ $posts->total() }} artikel ' + ('{{ $category }}' ? 'dalam kategori {{ $category }}' : 'tersedia'),
        '{{ $posts->total() }} articles ' + ('{{ $category }}' ? 'in {{ $category }}' : 'available'),
        ('{{ $category }}' ? '{{ $category }} 分类下' : '') + '共 {{ $posts->total() }} 篇文章可用',
        '{{ $posts->total() }} مقالات ' + ('{{ $category }}' ? 'في فئة {{ $category }}' : 'متاحة')
      )"></span>
    </div>
  </div>
</div>

{{-- ═══ MAIN & SIDEBAR CONTENT ═══ --}}
<section style="padding:60px 20px; background:#f7f5f0" class="blog-section">
  <div style="max-width:1200px; margin:0 auto; display: grid; grid-template-columns: 2fr 1fr; gap: 40px;" class="blog-main-layout">

    {{-- ─── LEFT COLUMN: ARTICLES ─── --}}
    <div style="display: flex; flex-direction: column; gap: 28px;">
      
      {{-- Featured Post --}}
      @if($posts->count() > 0 && !$search && !$category)
      @php
        $featured = $posts->first();
        $fc = $featured->category ?? '';
        $fbg = 'linear-gradient(135deg,#1e3a5f 0%,#2a5298 100%)';
        $fem = '📦';
        if ($fc === 'Ekspor') {
          [$fbg, $fem] = ['linear-gradient(135deg,#1e3a5f 0%,#1a6b3a 100%)', '🚢'];
        } elseif ($fc === 'Impor') {
          [$fbg, $fem] = ['linear-gradient(135deg,#1e3a5f 0%,#4a2a7f 100%)', '📥'];
        } elseif ($fc === 'UMKM') {
          [$fbg, $fem] = ['linear-gradient(135deg,#1e3a5f 0%,#7f5a1e 100%)', '🏪'];
        } elseif ($fc === 'Bea Cukai') {
          [$fbg, $fem] = ['linear-gradient(135deg,#5f2a1e 0%,#1e3a5f 100%)', '🛃'];
        }
        $fDaysOld = $featured->published_at ? now()->diffInDays($featured->published_at) : 999;
        $fIsNew = $fDaysOld <= 7;
        $fIsUpdated = $featured->updated_at && $featured->updated_at->diffInDays(now()) < 14
                      && $featured->updated_at->gt($featured->published_at?->addDays(3) ?? now());
        $fIsHot = isset($hotIds) && in_array($featured->id, $hotIds);
        $fSearch = strtolower($featured->title . ' ' . ($featured->excerpt ?? '') . ' ' . ($featured->category ?? ''));
        
        $fcEn = [
          'Ekspor' => 'Export',
          'Impor' => 'Import',
          'UMKM' => 'SME',
          'Bea Cukai' => 'Customs',
        ][$fc] ?? $fc;

        $fcZh = [
          'Ekspor' => '出口',
          'Impor' => '进口',
          'UMKM' => '中小企业',
          'Bea Cukai' => '海关与报关',
        ][$fc] ?? $fcEn;

        $fcAr = [
          'Ekspor' => 'التصدير',
          'Impor' => 'الاستيراد',
          'UMKM' => 'الشركات الصغيرة والمتوسطة',
          'Bea Cukai' => 'الجمارك',
        ][$fc] ?? $fcEn;
      @endphp
      <a href="{{ route('blog.show', $featured->slug) }}"
         data-search="{{ $fSearch }}"
         x-show="search === '' || $el.dataset.search.includes(search.toLowerCase())"
         style="text-decoration:none; border-radius:20px; overflow:hidden; border:1px solid #e5e2dc; background:#fff; display:grid; grid-template-columns:1.2fr 1fr; transition:all .3s; box-shadow:0 4px 16px rgba(0,0,0,0.04)"
         onmouseover="this.style.boxShadow='0 16px 48px rgba(30,58,95,0.12)'; this.style.transform='translateY(-3px)'"
         onmouseout="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)'; this.style.transform='none'" class="blog-featured-card">
        
        @if($featured->featured_image)
        <div style="min-height:320px; background-image:url({{ Str::startsWith($featured->featured_image, ['http://', 'https://']) ? $featured->featured_image : Storage::url($featured->featured_image) }}); background-size:cover; background-position:center; transition: transform .5s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'"></div>
        @else
        <div style="min-height:320px; background:{{ $fbg }}; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden">
          <span style="position:absolute; font-size:160px; opacity:0.08; line-height:1">{{ $fem }}</span>
          <span style="font-size:64px; position:relative; z-index:1">{{ $fem }}</span>
        </div>
        @endif
        
        <div style="padding:40px 32px; display:flex; flex-direction:column; justify-content:center">
          <div style="display:flex; gap:6px; align-items:center; margin-bottom:16px; flex-wrap:wrap">
            <span style="padding:3px 10px; border-radius:20px; background:rgba(245,185,28,0.15); color:#b8860b; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; border:1px solid rgba(245,185,28,0.25)" x-text="$store.lang.t('★ Sorotan', '★ Featured', '★ 精选', '★ مميز')">★ Sorotan</span>
            @if($featured->category)<span style="padding:3px 10px; border-radius:20px; background:#1e3a5f; color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;" x-text="$store.lang.t('{{ $featured->category }}', '{{ $fcEn }}', '{{ $fcZh }}', '{{ $fcAr }}')">{{ $featured->category }}</span>@endif
            @if($fIsNew)<span style="padding:2px 8px; border-radius:4px; background:#16a34a; color:#fff; font-size:10px; font-weight:700" x-text="$store.lang.t('BARU', 'NEW', '最新', 'جديد')">BARU</span>
            @elseif($fIsUpdated)<span style="padding:2px 8px; border-radius:4px; background:#ea580c;color:#fff; font-size:10px; font-weight:700" x-text="$store.lang.t('DIPERBARUI', 'UPDATED', '已更新', 'محدث')">DIPERBARUI</span>@endif
            @if($fIsHot)<span style="padding:2px 8px; border-radius:4px; background:#dc2626; color:#fff; font-size:10px; font-weight:700" x-text="$store.lang.t('🔥 POPULER', '🔥 POPULAR', '🔥 热门', '🔥 شائع')">🔥 POPULER</span>@endif
          </div>
          <h2 style="font-family:Syne; font-weight:800; font-size:24px; line-height:1.25; color:#0b1120; margin-bottom:12px">{{ $featured->title }}</h2>
          @if($featured->excerpt)<p style="font-size:14px; color:#55637c; line-height:1.75; margin-bottom:20px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;">{{ $featured->excerpt }}</p>@endif
          <div style="display:flex; align-items:center; gap:16px; font-size:12px; color:#94a3b8; margin-top:auto; padding-top:14px; border-top:1px solid #f0ede8;">
            <span>📅 {{ $featured->published_at?->format('d M Y') }}</span>
            <span>⏱ {{ $featured->reading_time }} <span x-text="$store.lang.t('menit baca', 'min read', '分钟阅读', 'دقائق قراءة')">menit baca</span></span>
            <span style="margin-left:auto; color:#1e3a5f; font-weight:700; font-size:13px; transition: color 0.2s;" onmouseover="this.style.color='#4a9eda'" onmouseout="this.style.color='#1e3a5f'" x-text="$store.lang.t('Baca selengkapnya →', 'Read more →', '阅读全文 →', 'اقرأ المزيد ←')">Baca selengkapnya →</span>
          </div>
        </div>
      </a>
      @endif

      {{-- In-feed Ad after featured post --}}
      <x-adsense-block type="in_feed" format="auto" />

      {{-- Grid Loop --}}
      <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:24px" class="blog-grid">
        @php $cardIndex = 0; @endphp
        @forelse($posts as $post)
        @continue(empty($post->title) || empty($post->slug))
        @continue($posts->count() > 0 && $post->id === $posts->first()->id && !$search && !$category)
        
        @php
          $pc = $post->category ?? '';
          $bg = 'linear-gradient(135deg,#1e3a5f 0%,#2a5298 100%)';
          $em = '📦';
          if ($pc === 'Ekspor') {
            [$bg, $em] = ['linear-gradient(135deg,#1e3a5f 0%,#1a6b3a 100%)', '🚢'];
          } elseif ($pc === 'Impor') {
            [$bg, $em] = ['linear-gradient(135deg,#1e3a5f 0%,#4a2a7f 100%)', '📥'];
          } elseif ($pc === 'UMKM') {
            [$bg, $em] = ['linear-gradient(135deg,#1e3a5f 0%,#7f5a1e 100%)', '🏪'];
          } elseif ($pc === 'Bea Cukai') {
            [$bg, $em] = ['linear-gradient(135deg,#5f2a1e 0%,#1e3a5f 100%)', '🛃'];
          }
          $daysOld = $post->published_at ? now()->diffInDays($post->published_at) : 999;
          $isNew     = $daysOld <= 7;
          $isUpdated = $post->updated_at && $post->updated_at->diffInDays(now()) < 14
                       && $post->updated_at->gt($post->published_at?->addDays(3) ?? now());
          $isHot     = isset($hotIds) && in_array($post->id, $hotIds);
          $searchData = strtolower($post->title . ' ' . ($post->excerpt ?? '') . ' ' . ($post->category ?? ''));
          
          $pcEn = [
            'Ekspor' => 'Export',
            'Impor' => 'Import',
            'UMKM' => 'SME',
            'Bea Cukai' => 'Customs',
          ][$pc] ?? $pc;

          $pcZh = [
            'Ekspor' => '出口',
            'Impor' => '进口',
            'UMKM' => '中小企业',
            'Bea Cukai' => '海关与报关',
          ][$pc] ?? $pcEn;

          $pcAr = [
            'Ekspor' => 'التصدير',
            'Impor' => 'الاستيراد',
            'UMKM' => 'الشركات الصغيرة والمتوسطة',
            'Bea Cukai' => 'الجمارك',
          ][$pc] ?? $pcEn;
        @endphp

        {{-- In-feed E-book CTA after card 2 --}}
        @if($cardIndex === 2)
        <div style="grid-column:1/-1; background:linear-gradient(135deg,#fffbeb 0%,#fef3c7 100%); border:1.5px solid #f5b91c; border-radius:16px; padding:24px 32px; display:flex; align-items:center; gap:20px; flex-wrap:wrap" class="infeed-cta">
          <div style="font-size:36px; flex-shrink:0">📘</div>
          <div style="flex:1; min-width:200px">
            <div style="font-family:Syne; font-weight:800; font-size:16px; color:#0f0f14; margin-bottom:4px" x-text="$store.lang.t('Toolkit Ekspor-Impor GRATIS untuk Anda', 'FREE Export-Import Toolkit for You', '为您提供免费的进出口工具包', 'مجموعة أدوات الاستيراد والتصدير المجانية لك')">Toolkit Ekspor-Impor GRATIS untuk Anda</div>
            <div style="font-size:12.5px; color:#6b5a1e; line-height:1.5" x-text="$store.lang.t('Checklist dokumen, template, & panduan praktis dari tim expert M2B — 5+ tahun pengalaman lapangan.', 'Document checklists, templates, & practical guides from M2B experts — 5+ years of field experience.', '来自 M2B 专家的文档清单、模板和实用指南 — 5 年以上现场经验。', 'قوائم مراجعة المستندات والقوالب والأدلة العملية من خبراء M2B - خبرة ميدانية تزيد عن 5 سنوات.')">Checklist dokumen, template, & panduan praktis dari tim expert M2B — 5+ tahun pengalaman lapangan.</div>
          </div>
          <a href="https://ebook.m2b.co.id/toolkit.html" target="_blank" style="display:inline-flex; align-items:center; gap:6px; padding:10px 20px; border-radius:8px; background:#0f0f14; color:#fff; text-decoration:none; font-weight:700; font-size:12px; white-space:nowrap; transition: background 0.2s;" onmouseover="this.style.background='#1e3a5f'" onmouseout="this.style.background='#0f0f14'" x-text="$store.lang.t('Download Gratis ↗', 'Download Free ↗', '免费下载 ↗', 'تحميل مجاني ↗')">Download Gratis ↗</a>
        </div>
        @endif

        {{-- In-feed AdSense after card 4 --}}
        @if($cardIndex === 4)
        <div style="grid-column:1/-1">
          <x-adsense-block type="in_feed" format="auto" />
        </div>
        @endif

        {{-- Post Card --}}
        <a href="{{ route('blog.show', $post->slug) }}"
           data-search="{{ $searchData }}"
           x-show="search === '' || $el.dataset.search.includes(search.toLowerCase())"
           style="text-decoration:none; border-radius:16px; overflow:hidden; border:1px solid #e5e2dc; background:#fff; display:flex; flex-direction:column; transition:all .3s; box-shadow: 0 2px 8px rgba(0,0,0,0.03)"
           onmouseover="this.style.boxShadow='0 12px 36px rgba(30,58,95,0.08)'; this.style.transform='translateY(-3px)'"
           onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.03)'; this.style.transform='none'">

          @if($post->featured_image)
          <div style="height:190px; background-image:url({{ Str::startsWith($post->featured_image, ['http://', 'https://']) ? $post->featured_image : Storage::url($post->featured_image) }}); background-size:cover; background-position:center; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'"></div>
          @else
          <div style="height:190px; background:{{ $bg }}; position:relative; overflow:hidden; display:flex; align-items:center; justify-content:center;">
            <span style="position:absolute; font-size:110px; opacity:0.08; line-height:1">{{ $em }}</span>
            <span style="font-size:44px; position:relative; z-index:1">{{ $em }}</span>
          </div>
          @endif

          <div style="padding:24px; flex:1; display:flex; flex-direction:column">
            <div style="display:flex; align-items:center; gap:6px; margin-bottom:12px; flex-wrap:wrap">
              @if($post->category)<span style="padding:2px 8px; border-radius:4px; background:#1e3a5f; color:#fff; font-size:9px; font-weight:700; text-transform:uppercase" x-text="$store.lang.t('{{ $post->category }}', '{{ $pcEn }}', '{{ $pcZh }}', '{{ $pcAr }}')">{{ $post->category }}</span>@endif
              @if($isNew)<span style="padding:2px 6px; border-radius:4px; background:#16a34a; color:#fff; font-size:9px; font-weight:700" x-text="$store.lang.t('BARU', 'NEW', '最新', 'جديد')">BARU</span>
              @elseif($isUpdated)<span style="padding:2px 6px; border-radius:4px; background:#ea580c; color:#fff; font-size:9px; font-weight:700" x-text="$store.lang.t('DIPERBARUI', 'UPDATED', '已更新', 'محدث')">DIPERBARUI</span>@endif
              @if($isHot)<span style="padding:2px 6px; border-radius:4px; background:#dc2626; color:#fff; font-size:9px; font-weight:700" x-text="$store.lang.t('🔥 POPULER', '🔥 POPULAR', '🔥 热门', '🔥 شائع')">🔥 POPULER</span>@endif
            </div>
            <h3 style="font-family:Syne; font-weight:700; font-size:17px; line-height:1.4; color:#0b1120; margin-bottom:8px; flex:1; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $post->title }}</h3>
            @if($post->excerpt)<p style="font-size:13px; color:#55637c; line-height:1.65; margin-bottom:16px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $post->excerpt }}</p>@endif
            
            <div style="display:flex; justify-content:space-between; align-items:center; padding-top:12px; border-top:1px solid #f0ede8; font-size:11.5px; color:#94a3b8;">
              <span>⏱ {{ $post->reading_time }} <span x-text="$store.lang.t('menit baca', 'min read', '分钟阅读', 'دقائق قراءة')">menit baca</span></span>
              <span style="color:#1e3a5f; font-weight:700; font-size:12.5px" x-text="$store.lang.t('Baca →', 'Read →', '阅读 →', 'اقرأ ←')">Baca →</span>
            </div>
          </div>
        </a>
        @php $cardIndex++; @endphp

        @empty
        <div style="grid-column:1/-1; text-align:center; padding:80px 40px; color:#94a3b8">
          <div style="font-size:48px; margin-bottom:16px">📝</div>
          <p x-text="$store.lang.t('Belum ada artikel yang dipublikasikan.', 'No articles published yet.', '尚未发布任何文章。', 'لم يتم نشر أي مقالات بعد.')">Belum ada artikel yang dipublikasikan.</p>
        </div>
        @endforelse
      </div>

      {{-- Reset Search Hint --}}
      <div x-show="search !== ''" x-cloak style="margin-top:16px; text-align:center">
        <p style="font-size:13px; color:#94a3b8">
          <span x-text="$store.lang.t('Tidak menemukan yang dicari?', 'Did not find what you were looking for?', '没有找到您要找的内容？', 'لم تجد ما تبحث عنه؟')">Tidak menemukan yang dicari?</span>
          <button @click="search=''" style="color:#1e3a5f; font-weight:700; background:none; border:none; cursor:pointer; font-family:'DM Sans'; text-decoration:underline" x-text="$store.lang.t('Hapus pencarian', 'Clear search', '清除搜索', 'مسح البحث')">Hapus pencarian</button>
        </p>
      </div>

      @if($posts->hasPages())
      <div style="margin-top:40px; display:flex; justify-content:center">{{ $posts->appends(request()->only('category'))->links() }}</div>
      @endif
    </div>

    {{-- ─── RIGHT COLUMN: SIDEBAR ─── --}}
    <aside style="display:flex; flex-direction:column; gap:28px;" class="blog-sidebar">
      
      {{-- Popular Posts Widget --}}
      <div style="background:#fff; border:1px solid #e5e2dc; border-radius:20px; padding:24px; box-shadow: 0 4px 16px rgba(0,0,0,0.02)">
        <h3 style="font-family:Syne; font-weight:800; font-size:15px; color:#0b1120; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
          <span style="width:4px; height:16px; border-radius:2px; background:#4a9eda; display:inline-block"></span>
          <span x-text="$store.lang.t('Artikel Populer', 'Popular Articles', '热门文章', 'المقالات الشائعة')">Artikel Populer</span>
        </h3>
        <div style="display:flex; flex-direction:column; gap:16px;">
          @foreach($popular as $idx => $popPost)
          <a href="{{ route('blog.show', $popPost->slug) }}" class="group" style="text-decoration:none; display:flex; gap:12px; align-items:start;">
            <span style="font-size:24px; font-weight:900; color:#e2e8f0; line-height:1; width:28px; flex-shrink:0;">{{ sprintf("%02d", $idx + 1) }}</span>
            <div style="flex:1">
              <h4 style="font-size:13.5px; font-weight:700; color:#334155; line-height:1.45; margin-bottom:4px; transition:color 0.2s;" onmouseover="this.style.color='#4a9eda'" onmouseout="this.style.color='#334155'">{{ $popPost->title }}</h4>
              <span style="font-size:11px; color:#94a3b8;">⏱ {{ $popPost->reading_time }} min read</span>
            </div>
          </a>
          @endforeach
        </div>
      </div>

      {{-- Categories Widget --}}
      <div style="background:#fff; border:1px solid #e5e2dc; border-radius:20px; padding:24px; box-shadow: 0 4px 16px rgba(0,0,0,0.02)">
        <h3 style="font-family:Syne; font-weight:800; font-size:15px; color:#0b1120; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
          <span style="width:4px; height:16px; border-radius:2px; background:#8b1e2b; display:inline-block"></span>
          <span x-text="$store.lang.t('Kategori', 'Categories', '分类', 'الفئات')">Kategori</span>
        </h3>
        <div style="display:flex; flex-direction:column; gap:4px">
          @foreach($categories as $cat)
          @php
            $catEn = [
              'Ekspor' => 'Export',
              'Impor' => 'Import',
              'UMKM' => 'SME',
              'Bea Cukai' => 'Customs',
            ][$cat] ?? $cat;

            $catZh = [
              'Ekspor' => '出口',
              'Impor' => '进口',
              'UMKM' => '中小企业',
              'Bea Cukai' => '海关与报关',
            ][$cat] ?? $catEn;

            $catAr = [
              'Ekspor' => 'التصدير',
              'Impor' => 'الاستيراد',
              'UMKM' => 'الشركات الصغيرة والمتوسطة',
              'Bea Cukai' => 'الجمارك',
            ][$cat] ?? $catEn;
          @endphp
          <a href="{{ route('blog.index', ['category' => $cat]) }}"
             style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f0ede8; text-decoration:none; transition: padding-left 0.2s;"
             onmouseover="this.style.paddingLeft='4px'" onmouseout="this.style.paddingLeft='0'">
            <span style="font-size:13.5px; font-weight:600; color:#55637c;" x-text="$store.lang.t('{{ $cat }}', '{{ $catEn }}', '{{ $catZh }}', '{{ $catAr }}')">{{ $cat }}</span>
            <span style="font-size:12px; color:#cbd5e1;">➔</span>
          </a>
          @endforeach
        </div>
      </div>

      {{-- Consultation CTA Card --}}
      <div style="background:linear-gradient(135deg, #1e3a5f 0%, #0B1120 100%); border-radius:20px; padding:28px 24px; text-align:center; color:#fff; box-shadow: 0 8px 32px rgba(30,58,95,0.15); position:relative; overflow:hidden;">
        <div style="position:absolute; inset:0; background-image:radial-gradient(rgba(255,255,255,0.05) 1px, transparent 0); background-size: 16px 16px; opacity:0.4;"></div>
        <div style="position:relative; z-index:1">
          <div style="width:48px; height:48px; border-radius:14px; background:rgba(255,255,255,0.08); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; border:1px solid rgba(255,255,255,0.15)">
            <span style="font-size:20px">💬</span>
          </div>
          <h4 style="font-family:Syne; font-weight:800; font-size:16px; color:#fff; margin-bottom:8px;" x-text="$store.lang.t('Konsultasi Logistik Gratis', 'Free Logistics Consultation', '免费物流咨询', 'استشارة لوجستية مجانية')">Konsultasi Logistik Gratis</h4>
          <p style="font-size:12px; color:rgba(255,255,255,0.65); line-height:1.6; margin-bottom:20px;" x-text="$store.lang.t('Diskusikan kebutuhan ekspor, impor, atau kepabeanan Anda dengan konsultan expert kami.', 'Discuss your export, import, or customs clearance needs with our expert consultants.', '与我们的专家顾问讨论您的进出口 or 清关需求。', 'ناقش احتياجاتك من الاستيراد أو التصدير أو التخليص الجمركي مع مستشارينا الخبراء.')">Diskusikan kebutuhan ekspor, impor, atau kepabeanan Anda dengan konsultan expert kami.</p>
          <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20konsultasi%20ekspor-impor" target="_blank"
             style="display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:12px 20px; border-radius:10px; background:#25D366; color:#fff; text-decoration:none; font-weight:700; font-size:13px; w-full; transition:transform 0.2s;"
             onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='none'"
             x-text="$store.lang.t('💬 Chat WhatsApp', '💬 Chat WhatsApp', '💬 微信/WhatsApp 咨询', '💬 اتصال واتساب')">💬 Chat WhatsApp</a>
        </div>
      </div>

    </aside>

  </div>

  {{-- Newsletter Banner --}}
  <div style="max-width:1200px; margin: 56px auto 0;" class="container-max">
    <div style="background:linear-gradient(135deg,#0B1120 0%,#1e3a5f 100%); border-radius:20px; padding:40px 48px; display:flex; align-items:center; justify-content:space-between; gap:32px; flex-wrap:wrap" class="newsletter-strip">
      <div>
        <div style="font-family:Syne; font-weight:800; font-size:20px; color:#fff; margin-bottom:6px" x-text="$store.lang.t('Jangan Lewatkan Update Logistik', 'Don\'t Miss Logistics Updates', '不要错过物流更新', 'لا تفوت تحديثات اللوجستيات')">Jangan Lewatkan Update Logistik</div>
        <p style="font-size:14px; color:rgba(255,255,255,0.55); max-width:420px" x-text="$store.lang.t('Tips ekspor-impor, regulasi terbaru, dan insight bisnis logistik langsung dari tim M2B.', 'Export-import tips, latest regulations, and business logistics insights directly from the M2B team.', '来自 M2B 团队的进出口技巧、最新法规 and 商业物流洞察。', 'نصائح الاستيراد والتصدير، وأحدث اللوائح، ورؤى لوجستيات الأعمال مباشرة من فريق M2B.')">Tips ekspor-impor, regulasi terbaru, dan insight bisnis logistik langsung dari tim M2B.</p>
      </div>
      <div style="display:flex; gap:10px; flex-shrink:0; flex-wrap:wrap">
        <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('Halo M2B, saya mau subscribe update logistik', 'Hello M2B, I want to subscribe to logistics updates', '您好 M2B，我想订阅物流更新', 'مرحباً M2B، أرغب في الاشتراك في تحديثات اللوجستيات'))" target="_blank"
          style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; border-radius:10px; background:#25D366; color:#fff; text-decoration:none; font-weight:700; font-size:14px; transition: transform 0.2s;"
          onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='none'"
          x-text="$store.lang.t('💬 Subscribe via WhatsApp', '💬 Subscribe via WhatsApp', '💬 通过 WhatsApp 订阅', '💬 الاشتراك عبر WhatsApp')">💬 Subscribe via WhatsApp</a>
        <a href="https://ebook.m2b.co.id" target="_blank"
          style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;border-radius:10px;background:rgba(255,255,255,0.1);color:#fff;text-decoration:none;font-weight:600;font-size:14px;border:1px solid rgba(255,255,255,0.2)"
          x-text="$store.lang.t('📘 Download E-Book', '📘 Download E-Book', '📘 下载电子书', '📘 تحميل الكتاب الإلكتروني')">📘 Download E-Book</a>
      </div>
    </div>
  </div>
</section>

</div>{{-- end x-data --}}
@endsection
