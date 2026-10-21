{{--
    Kartu artikel untuk grid /blog.

    Sebelumnya seluruh markup ini plus empat blok PHP peta kategori/badge ditulis
    inline di pages/blog/index.blade.php. Sisanya (posisi iklan in-feed dan CTA
    e-book berdasarkan $cardIndex) tetap di halaman, karena itu soal tata letak.

    JANGAN tulis directive "php" (dengan awalan @) di dalam komentar Blade:
    BladeCompiler::storeUncompiledBlocks() mencocokkan pola itu sampai penanda
    penutup blok PHP jauh sebelum komentar diproses, sehingga penanda penutup
    komentar ikut tertelan dan template gagal dikompilasi ("unexpected
    identifier"). Begitu juga jangan tulis penanda buka/tutup komentar Blade
    di dalam komentar.

    Props:
      post   — App\Models\Post
      hotIds — daftar id POPULER dari PostViewCounter (opsional)
--}}
@props(['post', 'hotIds' => []])

@php
    $labels = $post->categoryLabels();
    [$bg, $em] = $post->theme();
    $isNew = $post->isNew();
    $isUpdated = $post->isUpdated();
    $isHot = $post->isHot($hotIds);
    $searchData = $post->searchHaystack();
@endphp

<a href="{{ route('blog.show', $post->slug) }}"
   data-search="{{ $searchData }}"
   x-show="search === '' || $el.dataset.search.includes(search.toLowerCase())"
   style="text-decoration:none; border-radius:16px; overflow:hidden; border:1px solid #e5e2dc; background:#fff; display:flex; flex-direction:column; transition:all .3s; box-shadow:0 2px 8px rgba(0,0,0,0.03)"
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
      @if($post->category)<span style="padding:2px 8px; border-radius:4px; background:#1e3a5f; color:#fff; font-size:9px; font-weight:700; text-transform:uppercase" x-text="$store.lang.t('{{ $labels['id'] }}', '{{ $labels['en'] }}', '{{ $labels['zh'] }}', '{{ $labels['ar'] }}')">{{ $post->category }}</span>@endif
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
