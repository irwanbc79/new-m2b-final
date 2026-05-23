@extends('layouts.app')
@section('title', 'Tentang M2B — PT. Mora Multi Berkah')
@section('description', 'PT. Mora Multi Berkah adalah freight forwarder & PPJK terpercaya berbasis di Medan, melayani ekspor-impor ke 20+ negara.')

@section('head')
<style>
@media(max-width:768px){
  .about-intro-grid{grid-template-columns:1fr!important;gap:36px!important}
  .about-vision-grid{grid-template-columns:1fr!important}
  .about-cert-grid{grid-template-columns:1fr 1fr!important}
  .about-stats-grid{grid-template-columns:repeat(3,1fr)!important}
  .about-hero{padding:48px 20px 40px!important}
  .about-section{padding:60px 20px!important}
  .about-hero h1{font-size:34px!important}
  .director-badge{left:0!important;bottom:-16px!important}
}
</style>
@endsection

@section('content')
<div style="background:#0f0f14;padding:64px 40px 56px" class="about-hero">
  <div style="max-width:1200px;margin:0 auto">
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase;margin-bottom:16px">Tentang Kami</span>
    <h1 style="font-family:Syne;font-weight:800;font-size:48px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1">PT. Mora Multi Berkah<br><span style="color:#4a9eda">Mitra Logistik Terpercaya</span></h1>
    <p style="color:rgba(255,255,255,0.6);font-size:17px;max-width:580px">Freight Forwarder & Customs Broker yang berbasis di Medan, Sumatera Utara. Melayani ekspor-impor ke 20+ negara dengan transparan dan profesional.</p>
  </div>
</div>

<section style="padding:80px 40px;background:#fff" class="about-section">
  <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1.4fr;gap:56px;align-items:center" class="about-intro-grid">
    <div style="position:relative">
      {{-- Coverage map as hero visual --}}
      <div style="border-radius:16px;overflow:hidden;aspect-ratio:4/5;background:#0f1e38;display:flex;flex-direction:column;box-shadow:0 16px 48px rgba(0,0,0,0.14)">
        <img src="{{ asset('images/coverage-map.jpg') }}" alt="Jaringan pengiriman M2B ke 20+ negara" style="width:100%;height:60%;object-fit:cover;object-position:center">
        <div style="flex:1;padding:20px 22px;background:linear-gradient(180deg,#0f1e38,#1e3a5f)">
          <div style="font-family:Syne;font-weight:800;font-size:14px;color:#4a9eda;margin-bottom:8px;letter-spacing:0.5px">JANGKAUAN GLOBAL M2B</div>
          <div style="font-size:13px;color:rgba(255,255,255,0.65);line-height:1.7">Pelabuhan Belawan (Medan) sebagai hub utama menghubungkan Sumatera Utara ke jaringan pengiriman internasional — Asia, Eropa, Amerika, dan Australia.</div>
          <div style="display:flex;gap:16px;margin-top:14px">
            @foreach([['20+','Negara'],['5+','Tahun'],['100+','Klien']] as [$n,$l])
            <div style="text-align:center">
              <div style="font-family:Syne;font-weight:800;font-size:18px;color:#fff">{{ $n }}</div>
              <div style="font-size:10px;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.5px">{{ $l }}</div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      {{-- Director badge --}}
      <div style="position:absolute;bottom:-24px;left:-24px;background:#fff;padding:16px 20px;border-radius:12px;border:1px solid #e5e2dc;box-shadow:0 12px 36px rgba(0,0,0,0.1);display:flex;gap:14px;align-items:center" class="director-badge">
        <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#1e3a5f,#2a5298);display:flex;align-items:center;justify-content:center;font-family:Syne;font-weight:800;font-size:14px;color:#fff;flex-shrink:0">EMS</div>
        <div>
          <div style="font-family:Syne;font-weight:800;font-size:14px">Eka Mayang Sari</div>
          <div style="font-size:11px;color:#999">Direktur — PT. Mora Multi Berkah</div>
        </div>
      </div>
    </div>
    <div>
      <h2 style="font-family:Syne;font-weight:800;font-size:32px;letter-spacing:-0.8px;margin-bottom:18px;line-height:1.2;color:#0f0f14">Freight Forwarder & Jasa Logistik <span style="color:#1e3a5f">Terpercaya di Indonesia.</span></h2>
      <p style="font-size:15px;color:#555;line-height:1.85;margin-bottom:18px">Kami adalah perusahaan <strong>freight forwarder</strong> sekaligus <strong>PPJK (Pengusaha Pengurusan Jasa Kepabeanan)</strong> yang berbasis di Medan, Sumatera Utara — Indonesia. Kami menyediakan layanan logistik ekspor-impor secara menyeluruh, mulai dari pengurusan dokumen, customs clearance, hingga pengiriman barang ke berbagai destinasi nasional maupun internasional.</p>
      <p style="font-size:15px;color:#555;line-height:1.85;margin-bottom:24px">Berdiri dengan komitmen untuk memberikan layanan logistik yang <strong>transparan, andal, dan terukur</strong>, M2B hadir untuk membantu UMKM maupun perusahaan besar dalam mengelola aktivitas perdagangan internasional mereka dengan lebih efisien.</p>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px" class="about-stats-grid">
        @foreach([['🏆','5+ Tahun','Berpengalaman'],['🌍','20+','Negara Tujuan'],['🤝','100+','Klien Aktif']] as [$icon,$big,$sub])
        <div style="padding:14px 16px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8;text-align:center">
          <div style="font-size:22px;margin-bottom:8px">{{ $icon }}</div>
          <div style="font-family:Syne;font-weight:800;font-size:20px;color:#1e3a5f">{{ $big }}</div>
          <div style="font-size:11px;color:#888;margin-top:4px">{{ $sub }}</div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<section style="padding:80px 40px;background:#f7f5f0;border-top:1px solid #e5e2dc" class="about-section">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <h2 style="font-family:Syne;font-weight:800;font-size:32px;letter-spacing:-0.8px">Visi & Misi</h2>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px" class="about-vision-grid">
      <div style="background:#fff;border-radius:14px;padding:36px;border:1px solid #e5e2dc">
        <div style="font-size:32px;margin-bottom:16px">🎯</div>
        <h3 style="font-family:Syne;font-weight:800;font-size:22px;color:#1e3a5f;margin-bottom:12px">Visi</h3>
        <p style="font-size:15px;color:#555;line-height:1.85">Menjadi perusahaan freight forwarding & customs brokerage terpercaya di Indonesia yang membantu UMKM dan perusahaan besar menembus pasar global dengan mudah, aman, dan efisien.</p>
      </div>
      <div style="background:#fff;border-radius:14px;padding:36px;border:1px solid #e5e2dc">
        <div style="font-size:32px;margin-bottom:16px">🚀</div>
        <h3 style="font-family:Syne;font-weight:800;font-size:22px;color:#1e3a5f;margin-bottom:12px">Misi</h3>
        <ul style="font-size:15px;color:#555;line-height:1.85;list-style:none;padding:0">
          @foreach(['Memberikan layanan logistik transparan tanpa hidden cost','Membangun ekosistem ekspor-impor yang aksesibel untuk UMKM','Mengelola setiap shipment dengan dedikasi dan profesionalisme','Selalu update regulasi untuk perlindungan klien terbaik'] as $misi)
          <li style="display:flex;gap:10px;margin-bottom:10px"><span style="color:#1e3a5f;font-weight:700;flex-shrink:0">✓</span> {{ $misi }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>

<section style="padding:80px 40px;background:#fff;border-top:1px solid #e5e2dc" class="about-section">
  <div style="max-width:1200px;margin:0 auto;text-align:center;margin-bottom:48px">
    <h2 style="font-family:Syne;font-weight:800;font-size:32px;letter-spacing:-0.8px">Legalitas & Sertifikasi</h2>
    <p style="color:#666;margin-top:12px">M2B terdaftar resmi dan diakui oleh lembaga dan asosiasi industri terpercaya.</p>
  </div>
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:20px" class="about-cert-grid">
    @foreach([['🏛️','Dirjen Bea dan Cukai RI','Terdaftar sebagai PPJK resmi'],['📋','NIB (Nomor Induk Berusaha)','Legalitas usaha lengkap dan terverifikasi'],['🤝','ALFI','Anggota Asosiasi Logistik & Forwarder Indonesia'],['💼','KADIN','Anggota Kamar Dagang dan Industri Indonesia'],['🌐','LNSW','Terhubung dengan Layanan Nasional Single Window'],['⚓','Pelindo','Mitra operasional di pelabuhan utama']] as [$icon,$title,$desc])
    <div style="padding:24px;border-radius:12px;border:1px solid #e5e2dc;background:#fafaf8;display:flex;gap:16px;align-items:flex-start">
      <div style="font-size:28px;flex-shrink:0">{{ $icon }}</div>
      <div>
        <div style="font-family:Syne;font-weight:700;font-size:15px;margin-bottom:4px">{{ $title }}</div>
        <div style="font-size:13px;color:#777">{{ $desc }}</div>
      </div>
    </div>
    @endforeach
  </div>
</section>

<section style="padding:60px 40px;background:#0f0f14">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <h2 style="font-family:Syne;font-weight:800;font-size:36px;color:#fff;letter-spacing:-1px;margin-bottom:16px">Siap Bekerja Sama?</h2>
    <p style="color:rgba(255,255,255,0.5);font-size:16px;margin-bottom:32px">Konsultasikan kebutuhan logistik ekspor-impor Anda dengan tim M2B.</p>
    <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20mau%20konsultasi%20gratis" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:16px">💬 Konsultasi Gratis via WhatsApp</a>
  </div>
</section>
@endsection
