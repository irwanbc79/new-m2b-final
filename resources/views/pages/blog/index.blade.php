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
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase;margin-bottom:16px" x-text="$store.lang.t('Blog & Artikel', 'Blog & Articles', '博客与文章', 'المدونة والمقالات')">Blog & Artikel</span>
    <h1 style="font-family:Syne;font-weight:800;font-size:48px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1" class="blog-hero-h1">
      <span x-text="$store.lang.t('Update Logistik &', 'Logistics &', '物流与', 'تحديثات اللوجستيات و')">Update Logistik &</span><br>
      <span style="color:#4a9eda" x-text="$store.lang.t('Shipment', 'Shipment Updates', '货运动态', 'الشحن')">Shipment</span>
    </h1>
    <p style="color:rgba(255,255,255,0.6);font-size:17px;max-width:540px;margin-bottom:24px" x-text="$store.lang.t('Info terkini seputar pelabuhan, regulasi bea cukai, dan kegiatan pengiriman internasional.', 'Latest info on ports, customs regulations, and international shipping activities.', '关于港口、海关法规以及国际航运活动的最新信息。', 'أحدث المعلومات حول الموانئ، ولوائح الجمارك، وأنشطة الشحن الدولي.')">Info terkini seputar pelabuhan, regulasi bea cukai, dan kegiatan pengiriman internasional.</p>

    {{-- Search --}}
    <div style="max-width:480px;display:flex;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.18);border-radius:10px;overflow:hidden;backdrop-filter:blur(12px)">
      <div style="padding:0 14px;display:flex;align-items:center;color:rgba(255,255,255,0.4);font-size:16px">🔍</div>
      <input x-model.debounce.300ms="search" type="text" :placeholder="$store.lang.t('Cari artikel, topik, atau kategori...', 'Search articles, topics, or categories...', '搜索文章、主题或分类...', 'البحث عن المقالات أو المواضيع أو الفئات...')"
        style="flex:1;background:transparent;border:none;outline:none;color:#fff;font-size:14px;padding:13px 0;font-family:'DM Sans'">
      <button @click="search=''" x-show="search !== ''" x-cloak
        style="padding:0 16px;background:transparent;border:none;color:rgba(255,255,255,0.5);cursor:pointer;font-size:18px;line-height:1;font-family:'DM Sans'">×</button>
    </div>

    {{-- Category pills — server-side filter --}}
    <div class="cat-pills" style="display:flex;gap:8px;margin-top:20px;overflow-x:auto;padding-bottom:2px;align-items:center">
      <a href="{{ route('blog.index') }}"
        style="padding:6px 18px;border-radius:20px;border:1.5px solid;text-decoration:none;font-size:13px;font-weight:600;transition:all .15s;white-space:nowrap;font-family:'DM Sans';{{ !$category ? 'background:#4a9eda;color:#fff;border-color:#4a9eda' : 'background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.6);border-color:rgba(255,255,255,0.18)' }}"
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
        style="padding:6px 18px;border-radius:20px;border:1.5px solid;text-decoration:none;font-size:13px;font-weight:600;transition:all .15s;white-space:nowrap;font-family:'DM Sans';{{ $category === $cat ? 'background:#4a9eda;color:#fff;border-color:#4a9eda' : 'background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.6);border-color:rgba(255,255,255,0.18)' }}"
        x-text="$store.lang.t('{{ $cat }}', '{{ $catEn }}', '{{ $catZh }}', '{{ $catAr }}')">{{ $cat }}</a>
      @endforeach
    </div>

    {{-- Active filter indicator --}}
    <div style="margin-top:10px;display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.4);flex-wrap:wrap">
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
      <span style="padding:2px 10px;border-radius:12px;background:rgba(74,158,218,0.15);color:#4a9eda;border:1px solid rgba(74,158,218,0.3)">
        📂 <span x-text="$store.lang.t('{{ $category }}', '{{ $catEn }}', '{{ $catZh }}', '{{ $catAr }}')">{{ $category }}</span>
      </span>
      <a href="{{ route('blog.index') }}" style="color:#4a9eda;text-decoration:underline;font-family:'DM Sans'" x-text="$store.lang.t('Reset ×', 'Reset ×', '重置 ×', 'إعادة تعيين ×')">Reset ×</a>
      @endif
      <span x-show="search !== ''" x-cloak x-text="'🔍 &quot;' + search + '&quot;'" style="padding:2px 10px;border-radius:12px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15)"></span>
    </div>

    <div style="margin-top:12px;font-size:12px;color:rgba(255,255,255,0.2)">
      @php
        $catLabelEn = $category ? ($catEn ?? $category) : '';
        $catLabelZh = $category ? ($catZh ?? $category) : '';
        $catLabelAr = $category ? ($catAr ?? $category) : '';
      @endphp
      <span x-text="$store.lang.t(
        '{{ $posts->total() }} artikel ' + ('{{ $category }}' ? 'dalam kategori {{ $category }}' : 'tersedia'),
        '{{ $posts->total() }} articles ' + ('{{ $category }}' ? 'in {{ $catLabelEn }}' : 'available'),
        ('{{ $category }}' ? '{{ $catLabelZh }} 分类下' : '') + '共 {{ $posts->total() }} 篇文章可用',
        '{{ $posts->total() }} مقالات ' + ('{{ $category }}' ? 'في فئة {{ $catLabelAr }}' : 'متاحة')
      )"></span>
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
       style="text-decoration:none;border-radius:16px;overflow:hidden;border:1px solid #e5e2dc;background:#fff;display:grid;grid-template-columns:1fr 1fr;margin-bottom:28px;transition:all .2s;box-shadow:0 2px 8px rgba(0,0,0,0.06)"
       onmouseover="this.style.boxShadow='0 12px 40px rgba(0,0,0,0.13)';this.style.transform='translateY(-2px)'"
       onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)';this.style.transform='none'" class="blog-featured-card">
      @if($featured->featured_image)
      <div style="min-height:300px;background-image:url({{ Str::startsWith($featured->featured_image, ['http://', 'https://']) ? $featured->featured_image : Storage::url($featured->featured_image) }});background-size:cover;background-position:center"></div>
      @else
      <div style="min-height:300px;background:{{ $fbg }};display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden">
        <span style="position:absolute;font-size:160px;opacity:0.08;line-height:1">{{ $fem }}</span>
        <span style="font-size:64px;position:relative;z-index:1">{{ $fem }}</span>
      </div>
      @endif
      <div style="padding:36px 32px;display:flex;flex-direction:column;justify-content:center">
        <div style="display:flex;gap:6px;align-items:center;margin-bottom:14px;flex-wrap:wrap">
          <span style="padding:3px 10px;border-radius:20px;background:rgba(245,185,28,0.15);color:#b8860b;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border:1px solid rgba(245,185,28,0.3)" x-text="$store.lang.t('★ Artikel Pilihan', '★ Featured Article', '★ 精选文章', '★ مقال مختار')">★ Artikel Pilihan</span>
          @if($featured->category)<span style="padding:3px 8px;border-radius:4px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase" x-text="$store.lang.t('{{ $featured->category }}', '{{ $fcEn }}', '{{ $fcZh }}', '{{ $fcAr }}')">{{ $featured->category }}</span>@endif
          @if($fIsNew)<span style="padding:2px 6px;border-radius:4px;background:#16a34a;color:#fff;font-size:10px;font-weight:700" x-text="$store.lang.t('BARU', 'NEW', '最新', 'جديد')">BARU</span>
          @elseif($fIsUpdated)<span style="padding:2px 6px;border-radius:4px;background:#ea580c;color:#fff;font-size:10px;font-weight:700" x-text="$store.lang.t('DIPERBARUI', 'UPDATED', '已更新', 'محدث')">DIPERBARUI</span>@endif
          @if($fIsHot)<span style="padding:2px 6px;border-radius:4px;background:#dc2626;color:#fff;font-size:10px;font-weight:700" x-text="$store.lang.t('🔥 POPULER', '🔥 POPULAR', '🔥 热门', '🔥 شائع')">🔥 POPULER</span>@endif
        </div>
        <h2 style="font-family:Syne;font-weight:800;font-size:22px;line-height:1.35;color:#0f0f14;margin-bottom:12px">{{ $featured->title }}</h2>
        @if($featured->excerpt)<p style="font-size:14px;color:#666;line-height:1.75;margin-bottom:18px">{{ Str::limit($featured->excerpt, 160) }}</p>@endif
        <div style="display:flex;align-items:center;gap:16px;font-size:12px;color:#999;margin-top:auto">
          <span>{{ $featured->published_at?->format('d M Y') }}</span>
          <span>⏱ {{ $featured->reading_time }} <span x-text="$store.lang.t('menit baca', 'min read', '分钟阅读', 'دقائق قراءة')">menit baca</span></span>
          <span style="margin-left:auto;color:#1e3a5f;font-weight:700;font-size:13px" x-text="$store.lang.t('Baca selengkapnya →', 'Read more →', '阅读全文 →', 'اقرأ المزيد ←')">Baca selengkapnya →</span>
        </div>
      </div>
    </div>
    @endif

    {{-- Ad setelah featured post — posisi paling visible sebelum grid --}}
    <x-adsense-block type="in_feed" format="auto" />

    {{-- Post grid --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px" class="blog-grid">
      @php $cardIndex = 0; @endphp
      @forelse($posts as $i => $post)
      @continue($i === 0)
      @php
        $pc = $post->category ?? '';
        match($pc) {
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

      {{-- In-feed E-book CTA after card 3 --}}
      @if($cardIndex === 3)
      <div style="grid-column:1/-1;background:linear-gradient(135deg,#fffbeb 0%,#fef3c7 100%);border:1.5px solid #f5b91c;border-radius:16px;padding:28px 36px;display:flex;align-items:center;gap:28px;flex-wrap:wrap" class="infeed-cta">
        <div style="font-size:44px;flex-shrink:0">📘</div>
        <div style="flex:1;min-width:200px">
          <div style="font-family:Syne;font-weight:800;font-size:17px;color:#0f0f14;margin-bottom:4px" x-text="$store.lang.t('Toolkit Ekspor-Impor GRATIS untuk Anda', 'FREE Export-Import Toolkit for You', '为您提供免费的进出口工具包', 'مجموعة أدوات الاستيراد والتصدير المجانية لك')">Toolkit Ekspor-Impor GRATIS untuk Anda</div>
          <div style="font-size:13px;color:#6b5a1e;line-height:1.55" x-text="$store.lang.t('Checklist dokumen, template, & panduan praktis dari tim expert M2B — 5+ tahun pengalaman lapangan.', 'Document checklists, templates, & practical guides from M2B experts — 5+ years of field experience.', '来自 M2B 专家的文档清单、模板和实用指南 — 5 年以上现场经验。', 'قوائم مراجعة المستندات والقوالب والأدلة العملية من خبراء M2B - خبرة ميدانية تزيد عن 5 سنوات.')">Checklist dokumen, template, & panduan praktis dari tim expert M2B — 5+ tahun pengalaman lapangan.</div>
        </div>
        <div class="infeed-cta-btns" style="display:flex;gap:10px;flex-shrink:0">
          <a href="https://ebook.m2b.co.id/toolkit.html" target="_blank" style="display:inline-flex;align-items:center;gap:6px;padding:11px 22px;border-radius:10px;background:#0f0f14;color:#fff;text-decoration:none;font-weight:700;font-size:13px;white-space:nowrap" x-text="$store.lang.t('Download Gratis ↗', 'Download Free ↗', '免费下载 ↗', 'تحميل مجاني ↗')">Download Gratis ↗</a>
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
          <div style="font-family:Syne;font-weight:800;font-size:17px;color:#fff;margin-bottom:4px" x-text="$store.lang.t('Ada Pertanyaan Seputar Ekspor-Impor?', 'Any Questions About Export-Import?', '关于进出口有什么疑问吗？', 'هل لديك أي أسئلة حول الاستيراد والتصدير؟')">Ada Pertanyaan Seputar Ekspor-Impor?</div>
          <div style="font-size:13px;color:rgba(255,255,255,0.6);line-height:1.55" x-text="$store.lang.t('Tim M2B siap bantu konsultasi gratis. Respon cepat, solusi nyata untuk kebutuhan logistik Anda.', 'M2B team is ready to help with a free consultation. Fast response, real solutions for your logistics needs.', 'M2B 团队随时为您提供免费咨询。快速响应，为您解决实际的物流需求。', 'فريق M2B جاهز للمساعدة في استشارة مجانية. استجابة سريعة، حلول حقيقية لاحتياجاتك اللوجستية.')">Tim M2B siap bantu konsultasi gratis. Respon cepat, solusi nyata untuk kebutuhan logistik Anda.</div>
        </div>
        <div class="infeed-cta-btns" style="display:flex;gap:10px;flex-shrink:0">
          <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('Halo M2B, saya ingin konsultasi ekspor-impor', 'Hello M2B, I would like to consult about export-import', '您好 M2B，我想咨询进出口业务', 'مرحباً M2B، أرغب في استشارة حول الاستيراد والتصدير'))" target="_blank" style="display:inline-flex;align-items:center;gap:6px;padding:11px 22px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:13px;white-space:nowrap" x-text="$store.lang.t('💬 Konsultasi Gratis', '💬 Free Consultation', '💬 免费咨询', '💬 استشارة مجانية')">💬 Konsultasi Gratis</a>
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
        <div style="height:210px;background-image:url({{ Str::startsWith($post->featured_image, ['http://', 'https://']) ? $post->featured_image : Storage::url($post->featured_image) }});background-size:cover;background-position:center"></div>
        <div style="padding:20px 24px;flex:1;display:flex;flex-direction:column">
          <div style="display:flex;align-items:center;gap:6px;margin-bottom:10px;flex-wrap:wrap">
            @if($post->category)<span style="padding:3px 8px;border-radius:4px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase" x-text="$store.lang.t('{{ $post->category }}', '{{ $pcEn }}', '{{ $pcZh }}', '{{ $pcAr }}')">{{ $post->category }}</span>@endif
            @if($isNew)<span style="padding:2px 6px;border-radius:4px;background:#16a34a;color:#fff;font-size:10px;font-weight:700" x-text="$store.lang.t('BARU', 'NEW', '最新', 'جديد')">BARU</span>
            @elseif($isUpdated)<span style="padding:2px 6px;border-radius:4px;background:#ea580c;color:#fff;font-size:10px;font-weight:700" x-text="$store.lang.t('DIPERBARUI', 'UPDATED', '已更新', 'محدث')">DIPERBARUI</span>@endif
            @if($isHot)<span style="padding:2px 6px;border-radius:4px;background:#dc2626;color:#fff;font-size:10px;font-weight:700" x-text="$store.lang.t('🔥 POPULER', '🔥 POPULAR', '🔥 热门', '🔥 شائع')">🔥 POPULER</span>@endif
            <span style="font-size:11px;color:#bbb;margin-left:auto">{{ $post->published_at?->format('d M Y') }}</span>
          </div>
          <h2 style="font-family:Syne;font-weight:700;font-size:16px;line-height:1.45;color:#0f0f14;margin-bottom:8px;flex:1">{{ $post->title }}</h2>
          @if($post->excerpt)<p style="font-size:13px;color:#777;line-height:1.7;margin-bottom:12px">{{ Str::limit($post->excerpt, 100) }}</p>@endif
          <div style="display:flex;justify-content:space-between;align-items:center;padding-top:12px;border-top:1px solid #f0ede8;font-size:12px">
            <span style="color:#999">⏱ {{ $post->reading_time }} <span x-text="$store.lang.t('menit baca', 'min read', '分钟阅读', 'دقائق قراءة')">menit baca</span></span>
            <span style="color:#1e3a5f;font-weight:600" x-text="$store.lang.t('Baca →', 'Read →', '阅读 →', 'اقرأ ←')">Baca →</span>
          </div>
        </div>

        @else
        {{-- Text-focused card --}}
        <div style="height:68px;background:{{ $bg }};position:relative;overflow:hidden;display:flex;align-items:center;padding:0 20px;flex-shrink:0">
          <span style="position:absolute;right:-4px;top:-10px;font-size:76px;opacity:0.18;line-height:1;pointer-events:none;user-select:none">{{ $em }}</span>
          <div style="display:flex;gap:5px;align-items:center;position:relative;z-index:1;flex-wrap:wrap">
            @if($post->category)<span style="padding:3px 8px;border-radius:4px;background:rgba(255,255,255,0.2);color:#fff;font-size:10px;font-weight:700;text-transform:uppercase;border:1px solid rgba(255,255,255,0.2)" x-text="$store.lang.t('{{ $post->category }}', '{{ $pcEn }}', '{{ $pcZh }}', '{{ $pcAr }}')">{{ $post->category }}</span>@endif
            @if($isNew)<span style="padding:2px 6px;border-radius:4px;background:#16a34a;color:#fff;font-size:10px;font-weight:700" x-text="$store.lang.t('BARU', 'NEW', '最新', 'جديد')">BARU</span>
            @elseif($isUpdated)<span style="padding:2px 6px;border-radius:4px;background:#ea580c;color:#fff;font-size:10px;font-weight:700" x-text="$store.lang.t('DIPERBARUI', 'UPDATED', '已更新', 'محدث')">DIPERBARUI</span>@endif
            @if($isHot)<span style="padding:2px 6px;border-radius:4px;background:#dc2626;color:#fff;font-size:10px;font-weight:700" x-text="$store.lang.t('🔥 POPULER', '🔥 POPULAR', '🔥 热门', '🔥 شائع')">🔥 POPULER</span>@endif
          </div>
        </div>
        <div style="padding:20px 24px;flex:1;display:flex;flex-direction:column">
          <div style="font-size:11px;color:#bbb;margin-bottom:8px">{{ $post->published_at?->format('d M Y') }}</div>
          <h2 style="font-family:Syne;font-weight:700;font-size:17px;line-height:1.4;color:#0f0f14;margin-bottom:10px;flex:1">{{ $post->title }}</h2>
          @if($post->excerpt)<p style="font-size:13px;color:#666;line-height:1.75;margin-bottom:12px">{{ Str::limit($post->excerpt, 130) }}</p>@endif
          <div style="display:flex;justify-content:space-between;align-items:center;padding-top:12px;border-top:1px solid #f0ede8;font-size:12px">
            <span style="color:#999">⏱ {{ $post->reading_time }} <span x-text="$store.lang.t('menit baca', 'min read', '分钟阅读', 'دقائق قراءة')">menit baca</span></span>
            <span style="color:#1e3a5f;font-weight:600" x-text="$store.lang.t('Baca →', 'Read →', '阅读 →', 'اقرأ ←')">Baca →</span>
          </div>
        </div>
        @endif

      </a>
      @php $cardIndex++; @endphp

      @empty
      <div style="grid-column:1/-1;text-align:center;padding:80px 40px;color:#999">
        <div style="font-size:48px;margin-bottom:16px">📝</div>
        <p x-text="$store.lang.t('Belum ada artikel yang dipublikasikan.', 'No articles published yet.', '尚未发布任何文章。', 'لم يتم نشر أي مقالات بعد.')">Belum ada artikel yang dipublikasikan.</p>
      </div>
      @endforelse
    </div>

    {{-- Reset hint when search active --}}
    <div x-show="search !== ''" x-cloak style="margin-top:16px;text-align:center">
      <p style="font-size:13px;color:#aaa">
        <span x-text="$store.lang.t('Tidak menemukan yang dicari?', 'Did not find what you were looking for?', '没有找到您要找的内容？', 'لم تجد ما تبحث عنه؟')">Tidak menemukan yang dicari?</span>
        <button @click="search=''" style="color:#1e3a5f;font-weight:600;background:none;border:none;cursor:pointer;font-family:'DM Sans';text-decoration:underline" x-text="$store.lang.t('Hapus pencarian', 'Clear search', '清除搜索', 'مسح البحث')">Hapus pencarian</button>
      </p>
    </div>

    @if($posts->hasPages())
    <div style="margin-top:48px;display:flex;justify-content:center">{{ $posts->appends(request()->only('category'))->links() }}</div>
    @endif

    {{-- Newsletter / CTA strip --}}
    <div style="margin-top:56px;background:linear-gradient(135deg,#0B1120 0%,#1e3a5f 100%);border-radius:20px;padding:40px 48px;display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap" class="newsletter-strip">
      <div>
        <div style="font-family:Syne;font-weight:800;font-size:20px;color:#fff;margin-bottom:6px" x-text="$store.lang.t('Jangan Lewatkan Update Logistik', 'Don\'t Miss Logistics Updates', '不要错过物流更新', 'لا تفوت تحديثات اللوجستيات')">Jangan Lewatkan Update Logistik</div>
        <p style="font-size:14px;color:rgba(255,255,255,0.55);max-width:420px" x-text="$store.lang.t('Tips ekspor-impor, regulasi terbaru, dan insight bisnis logistik langsung dari tim M2B.', 'Export-import tips, latest regulations, and business logistics insights directly from the M2B team.', '来自 M2B 团队的进出口技巧、最新法规 and 商业物流洞察。', 'نصائح الاستيراد والتصدير، وأحدث اللوائح، ورؤى لوجستيات الأعمال مباشرة من فريق M2B.')">Tips ekspor-impor, regulasi terbaru, dan insight bisnis logistik langsung dari tim M2B.</p>
      </div>
      <div style="display:flex;gap:10px;flex-shrink:0;flex-wrap:wrap">
        <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('Halo M2B, saya mau subscribe update logistik', 'Hello M2B, I want to subscribe to logistics updates', '您好 M2B，我想订阅物流更新', 'مرحباً M2B، أرغب في الاشتراك في تحديثات اللوجستيات'))" target="_blank"
          style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:14px"
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
