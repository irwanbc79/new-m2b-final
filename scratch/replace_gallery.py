# -*- coding: utf-8 -*-
import os

file_path = 'resources/views/pages/home.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

start_marker = '{{-- ═══ DOKUMENTASI LAPANGAN (BENTO GRID GALLERY) ═══ --}}'
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
<section class="home-section" style="background:#09090d;color:#fff;padding:100px 20px;border-top:1px solid rgba(255,255,255,0.06);overflow:visible;">
  <div style="max-width:1200px;margin:0 auto">
    <!-- Section Header -->
    <div style="text-align:center;margin-bottom:56px">
      <span style="display:inline-block;padding:4px 12px;border-radius:20px;background:rgba(74,158,218,0.15);color:#4a9eda;font-size:11px;font-weight:700;letter-spacing:0.5px;text-transform:uppercase" x-text="$store.lang.t('DOKUMENTASI LAPANGAN', 'FIELD DOCUMENTATION', '现场操作记录', 'الوثائق الميدانية')">DOKUMENTASI LAPANGAN</span>
      <h2 style="font-family:Syne;font-size:36px;font-weight:800;margin-top:12px;letter-spacing:-0.8px" x-text="$store.lang.t('Bukti Nyata Operasional M2B', 'Real-Time Operational Showcase', 'M2B 真实的物流操作展示', 'عرض عملياتنا اللوجستية الواقعية')">Bukti Nyata Operasional M2B</h2>
      <p style="color:rgba(255,255,255,0.5);max-width:750px;margin:12px auto 0;font-size:15px;line-height:1.75" x-text="$store.lang.t('Kami menjaga kerahasiaan data dan hubungan kemitraan pelanggan dengan ketat. Dokumentasi visual operasional kepabeanan dan logistik kami disajikan secara anonim guna melindungi privasi bisnis dan kode etik pelanggan.', 'We strictly protect client confidentiality and business ethics. Our customs and logistics operational documentation is showcased anonymously to respect and safeguard the privacy of our partners.', '我们严格保护客户机密与商业道德。我们的报关与物流操作实景记录均以匿名形式展示，以尊重并维护合作伙伴的商业隐私。', 'نحن نحمي سرية العملاء وأخلاقيات العمل بصرامة. يتم عرض وثائقنا التشغيلية الجمركية واللوجستية بشكل مجهول لاحترام وحماية خصوصية شركائنا.')">Kami menjaga kerahasiaan data dan hubungan kemitraan pelanggan dengan ketat. Dokumentasi visual operasional kepabeanan dan logistik kami disajikan secara anonim guna melindungi privasi bisnis dan kode etik pelanggan.</p>
    </div>

    <!-- Mosaic Grid Container -->
    <div class="mosaic-grid">
      @foreach($fieldPhotos as $photo)
      <div class="mosaic-item">
        <img src="{{ $photo->url }}" alt="M2B Field Documentation" loading="lazy" />
      </div>
      @endforeach
    </div>
  </div>
</section>

<style>
.mosaic-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 16px;
}
.mosaic-item {
  position: relative;
  aspect-ratio: 4/3;
  border-radius: 12px;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: #111a36;
  cursor: default;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}
.mosaic-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
/* Dim other items when hovering the grid */
.mosaic-grid:hover .mosaic-item:not(:hover) {
  opacity: 0.25;
  filter: grayscale(40%) blur(1px);
}
/* Smooth scale up on hover */
.mosaic-item:hover {
  transform: scale(1.35);
  z-index: 10;
  border-color: rgba(74, 158, 218, 0.6);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7);
}

@media (max-width: 991px) {
  .mosaic-grid {
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
  }
  .mosaic-item:hover {
    transform: scale(1.25);
  }
}
@media (max-width: 767px) {
  .mosaic-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
  }
  .mosaic-item:hover {
    transform: scale(1.2);
  }
}
@media (max-width: 480px) {
  .mosaic-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
  }
  .mosaic-item:hover {
    transform: scale(1.15);
  }
}
</style>"""

updated_content = content[:start_idx] + new_gallery + content[end_idx:]

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(updated_content)

print("Replacement successful!")
