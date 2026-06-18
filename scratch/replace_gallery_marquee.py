# -*- coding: utf-8 -*-
import os

file_path = 'resources/views/pages/home.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

start_marker = '{{-- ═══ DOKUMENTASI LAPANGAN (ANONYMOUS MOSAIC GALLERY) ═══ --}}'
end_marker = '</style>'

start_idx = content.find(start_marker)
if start_idx == -1:
    print("Start marker not found!")
    exit(1)

# Find the first end_marker AFTER the start_marker
end_idx = content.find(end_marker, start_idx)
if end_idx == -1:
    print("End marker not found!")
    exit(1)

# Include the length of the end_marker itself
end_idx += len(end_marker)

new_gallery = """{{-- ═══ DOKUMENTASI LAPANGAN (ANONYMOUS MOSAIC GALLERY) ═══ --}}
<section class="home-section" style="background:#09090d;color:#fff;padding:100px 0;border-top:1px solid rgba(255,255,255,0.06);overflow:visible;">
  <div style="max-width:1200px;margin:0 auto;padding:0 20px;">
    <!-- Section Header -->
    <div style="text-align:center;margin-bottom:56px">
      <span style="display:inline-block;padding:4px 12px;border-radius:20px;background:rgba(74,158,218,0.15);color:#4a9eda;font-size:11px;font-weight:700;letter-spacing:0.5px;text-transform:uppercase" x-text="$store.lang.t('DOKUMENTASI LAPANGAN', 'FIELD DOCUMENTATION', '现场操作记录', 'الوثائق الميدانية')">DOKUMENTASI LAPANGAN</span>
      <h2 style="font-family:Syne;font-size:36px;font-weight:800;margin-top:12px;letter-spacing:-0.8px" x-text="$store.lang.t('Bukti Nyata Operasional M2B', 'Real-Time Operational Showcase', 'M2B 真实的物流操作展示', 'عرض عملياتنا اللوجستية الواقعية')">Bukti Nyata Operasional M2B</h2>
      <p style="color:rgba(255,255,255,0.5);max-width:750px;margin:12px auto 0;font-size:15px;line-height:1.75" x-text="$store.lang.t('Kami menjaga kerahasiaan data dan hubungan kemitraan pelanggan dengan ketat. Dokumentasi visual operasional kepabeanan dan logistik kami disajikan secara anonim guna melindungi privasi bisnis dan kode etik pelanggan.', 'We strictly protect client confidentiality and business ethics. Our customs and logistics operational documentation is showcased anonymously to respect and safeguard the privacy of our partners.', '我们严格保护客户机密与商业道德。我们的报关与物流操作实景记录均以匿名形式展示，以尊重并维护合作伙伴的商业隐私。', 'نحن نحمي سرية العملاء وأخلاقيات العمل بصرامة. يتم عرض وثائقنا التشغيلية الجمركية واللوجستية بشكل مجهول لاحترام وحماية خصوصية شركائنا.')">Kami menjaga kerahasiaan data dan hubungan kemitraan pelanggan dengan ketat. Dokumentasi visual operasional kepabeanan dan logistik kami disajikan secara anonim guna melindungi privasi bisnis dan kode etik pelanggan.</p>
    </div>
  </div>

  @php
    $row1Photos = $fieldPhotos->slice(0, 24);
    $row2Photos = $fieldPhotos->slice(24, 24);
  @endphp

  <!-- Row 1 Marquee (scrolls left) -->
  <div class="marquee-wrapper" style="margin-bottom: 0;">
    <div class="marquee-track marquee-left">
      <div class="marquee-items">
        @foreach($row1Photos as $photo)
        <div class="mosaic-item">
          <img src="{{ $photo->url }}" alt="M2B Field Documentation" loading="lazy" />
        </div>
        @endforeach
      </div>
      <div class="marquee-items" aria-hidden="true">
        @foreach($row1Photos as $photo)
        <div class="mosaic-item">
          <img src="{{ $photo->url }}" alt="M2B Field Documentation" loading="lazy" />
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Row 2 Marquee (scrolls right) -->
  <div class="marquee-wrapper">
    <div class="marquee-track marquee-right">
      <div class="marquee-items">
        @foreach($row2Photos as $photo)
        <div class="mosaic-item">
          <img src="{{ $photo->url }}" alt="M2B Field Documentation" loading="lazy" />
        </div>
        @endforeach
      </div>
      <div class="marquee-items" aria-hidden="true">
        @foreach($row2Photos as $photo)
        <div class="mosaic-item">
          <img src="{{ $photo->url }}" alt="M2B Field Documentation" loading="lazy" />
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<style>
.marquee-wrapper {
  overflow: hidden;
  width: 100%;
  padding: 130px 0;
  margin: -105px 0;
  position: relative;
}
.marquee-track {
  display: flex;
  width: max-content;
  gap: 12px;
  overflow: visible;
}
.marquee-items {
  display: flex;
  gap: 12px;
  overflow: visible;
}
.marquee-left {
  animation: scroll-left 60s linear infinite;
}
.marquee-right {
  animation: scroll-right 60s linear infinite;
}

@keyframes scroll-left {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
@keyframes scroll-right {
  0% { transform: translateX(-50%); }
  100% { transform: translateX(0); }
}

/* Pause scroll when hovering over the marquee row */
.marquee-wrapper:hover .marquee-left,
.marquee-wrapper:hover .marquee-right {
  animation-play-state: paused;
}

.mosaic-item {
  position: relative;
  width: 75px;
  height: 75px;
  border-radius: 8px;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: #111a36;
  cursor: default;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  flex-shrink: 0;
}
.mosaic-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  filter: grayscale(100%);
  transition: filter 0.4s ease, transform 0.4s ease;
}
/* Dim other items when hovering the track */
.marquee-track:hover .mosaic-item:not(:hover) {
  opacity: 0.25;
  filter: grayscale(100%) blur(1px);
}
/* Smooth scale up on hover (pop out to absolute size of ~315px) */
.mosaic-item:hover {
  transform: scale(4.2);
  z-index: 100;
  border-color: rgba(74, 158, 218, 0.7);
  box-shadow: 0 20px 45px rgba(0, 0, 0, 0.9);
}
.mosaic-item:hover img {
  filter: grayscale(0%);
}

@media (max-width: 991px) {
  .mosaic-item {
    width: 60px;
    height: 60px;
  }
  .mosaic-item:hover {
    transform: scale(3.5); /* 60 * 3.5 = 210px */
  }
  .marquee-wrapper {
    padding: 100px 0;
    margin: -85px 0;
  }
}
@media (max-width: 767px) {
  .mosaic-item {
    width: 50px;
    height: 50px;
  }
  .mosaic-item:hover {
    transform: scale(3.0); /* 50 * 3.0 = 150px */
  }
  .marquee-wrapper {
    padding: 80px 0;
    margin: -68px 0;
  }
}
</style>"""

updated_content = content[:start_idx] + new_gallery + content[end_idx:]

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(updated_content)

print("Replacement successful!")
