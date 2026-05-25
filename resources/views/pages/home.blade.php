@extends('layouts.app')

@section('head')
<style>
@media(max-width:768px){
  .home-hero-h1{font-size:34px!important;letter-spacing:-1px!important}
  .home-hero{padding:60px 20px!important;min-height:auto!important}
  .home-services-grid{grid-template-columns:1fr!important}
  .home-testimonials-grid{grid-template-columns:1fr!important}
  .home-blog-grid{grid-template-columns:1fr!important}
  .home-process-grid{grid-template-columns:1fr 1fr!important}
  .home-stats{gap:20px!important}
  .home-estimator{padding:48px 20px!important}
  .home-faq{padding:60px 20px!important}
}
@media(min-width:769px) and (max-width:1024px){
  .home-services-grid{grid-template-columns:repeat(2,1fr)!important}
  .home-testimonials-grid{grid-template-columns:repeat(2,1fr)!important}
  .home-blog-grid{grid-template-columns:repeat(2,1fr)!important}
}
</style>
@endsection


@section('content')

{{-- ═══ HERO ═══ --}}
<section style="position:relative;min-height:640px;display:flex;align-items:center;overflow:hidden">
  <div style="position:absolute;inset:0;background-image:url(https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?auto=format&fit=crop&w=1600&q=80);background-size:cover;background-position:center"></div>
  <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(11,17,32,0.92) 40%,rgba(11,17,32,0.55) 75%,rgba(11,17,32,0.25) 100%)"></div>
  <div style="position:relative;max-width:1200px;margin:0 auto;padding:80px 40px;width:100%">
    <div style="max-width:620px">
      <div style="display:flex;gap:8px;margin-bottom:22px;flex-wrap:wrap">
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(255,255,255,0.15);color:#fff;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Freight Forwarder</span>
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(255,255,255,0.15);color:#fff;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Customs Broker</span>
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#7eb3e8;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Medan · Indonesia</span>
      </div>
      <h1 style="font-family:Syne;font-weight:800;font-size:54px;line-height:1.06;color:#fff;letter-spacing:-1.8px;margin-bottom:22px">
        Ekspor &amp; Impor<br>
        <span style="color:#4a9eda">Lebih Mudah,</span><br>
        Lebih Aman.
      </h1>
      <p style="font-size:17px;color:rgba(255,255,255,0.78);margin-bottom:36px;line-height:1.7;max-width:480px">
        End-to-end freight forwarding &amp; customs brokerage. Dari dokumen, bea cukai, hingga door-to-door delivery — M2B handle semuanya.
      </p>
      <div style="background:rgba(255,255,255,0.08);backdrop-filter:blur(16px);border-radius:14px;padding:18px 22px;border:1px solid rgba(255,255,255,0.18);max-width:520px;margin-bottom:20px;box-shadow:0 12px 36px rgba(0,0,0,0.25)">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
          <div style="width:36px;height:36px;border-radius:8px;background:#1e3a5f;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0">🔐</div>
          <div>
            <div style="font-family:Syne;font-weight:700;font-size:13px;color:#fff">Portal M2B</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.45)">ERP & Client Portal — portal.m2b.co.id</div>
          </div>
          <span style="margin-left:auto;padding:2px 9px;border-radius:10px;background:rgba(74,158,218,0.2);color:#4a9eda;font-size:10px;font-weight:700;border:1px solid rgba(74,158,218,0.3)">LIVE</span>
        </div>
        <p style="font-size:13px;color:rgba(255,255,255,0.55);margin-bottom:14px;line-height:1.6">Pantau status shipment, unduh dokumen, invoice, dan laporan logistik real-time.</p>
        <div style="display:flex;gap:8px">
          <a href="https://portal.m2b.co.id" target="_blank" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:10px 14px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:700;font-size:13px;white-space:nowrap">🔐 Login Portal</a>
          <a href="https://portal.m2b.co.id/register" target="_blank" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:10px 14px;border-radius:8px;background:rgba(255,255,255,0.08);color:#fff;text-decoration:none;font-weight:600;font-size:13px;border:1px solid rgba(255,255,255,0.2);white-space:nowrap">✏️ Daftar Akun</a>
        </div>
      </div>
      <div class="flex gap-3 flex-wrap" x-data="{ open: false }">
        <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20mau%20konsultasi%20gratis" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:15px;transition:all .18s">💬 Konsultasi GRATIS</a>

        <button @click="open = true"
                class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-lg border border-white/30 backdrop-blur-sm transition-all duration-300 cursor-pointer">
            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
            </svg>
            Tonton Profil M2B <span class="text-xs opacity-60">(16d)</span>
        </button>

        <a href="#layanan" style="display:inline-flex;align-items:center;gap:8px;padding:13px 24px;border-radius:8px;color:#fff;text-decoration:none;font-weight:600;font-size:15px;border:1.5px solid rgba(255,255,255,0.25);background:rgba(255,255,255,0.05)">Lihat Layanan →</a>

        {{-- YouTube Modal --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="open = false"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 sm:p-6 backdrop-blur-sm"
             style="display: none;">
            <div @click.outside="open = false"
                 class="relative w-full max-w-4xl bg-black rounded-2xl shadow-2xl overflow-hidden aspect-video border border-gray-800">
                <button @click="open = false"
                        class="absolute top-4 right-4 z-10 p-2 bg-black/50 hover:bg-red-600 rounded-full text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                {{-- Lazy load: iframe hanya render saat modal dibuka --}}
                <template x-if="open">
                    <iframe class="w-full h-full"
                            src="https://www.youtube.com/embed/ZkZVVKRXuuA?autoplay=1&rel=0&modestbranding=1"
                            title="PT. Mora Multi Berkah Official"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </template>
            </div>
        </div>
      </div>
      <div style="display:flex;gap:32px;margin-top:48px;border-top:1px solid rgba(255,255,255,0.18);padding-top:28px;flex-wrap:wrap" class="home-stats">
        @foreach([
          ['target'=>5,   'label'=>'Tahun berpengalaman', 'suffix'=>'+'],
          ['target'=>100, 'label'=>'Klien aktif',          'suffix'=>'+'],
          ['target'=>20,  'label'=>'Negara tujuan',        'suffix'=>'+'],
        ] as $stat)
        <div x-data="{ count: 0 }"
             x-intersect.once="
               let start = null, target = {{ $stat['target'] }};
               const step = (ts) => {
                 if (!start) start = ts;
                 const progress = Math.min((ts - start) / 1800, 1);
                 count = Math.floor(progress * target);
                 if (progress < 1) requestAnimationFrame(step);
               };
               requestAnimationFrame(step);
             ">
          <div style="font-family:Syne;font-weight:800;font-size:28px;color:#4a9eda;line-height:1">
            <span x-text="count + '{{ $stat['suffix'] }}'">{{ $stat['target'] }}{{ $stat['suffix'] }}</span>
          </div>
          <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-top:6px">{{ $stat['label'] }}</div>
        </div>
        @endforeach
        <div>
          <div style="font-family:Syne;font-weight:800;font-size:28px;color:#4a9eda;line-height:1">A–Z</div>
          <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-top:6px">Layanan end-to-end</div>
        </div>
      </div>
    </div>
  </div>
</section>



{{-- ═══ MITRA STRATEGIS ═══ --}}
<x-partner-grid />

{{-- ═══ SERVICES ═══ --}}
<section id="layanan" style="padding:80px 40px;background:#f7f5f0" x-data="{ openService: null }">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Layanan</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:36px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px">Semua Kebutuhan Logistik, Satu Atap</h2>
      <p style="color:#666;font-size:16px;max-width:500px;margin:0 auto">Klik setiap layanan untuk pelajari detail lengkap.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px" class="home-services-grid">
      @php
      $services = [
        ['📤','Export Handling','Paling Populer','PEB, packing list, COO/SKA, dan pengiriman ke 20+ negara. Legal & tepat waktu.','Export Handling','Bisnismu siap mendunia. Dokumen yang menahanmu.','PEB (Pemberitahuan Ekspor Barang) — proses 1×24 jam|COO/SKA Form A, D, E, AK — sesuai negara tujuan|Packing List & Commercial Invoice format internasional|Bill of Lading & Sea Waybill koordinasi langsung shipping line|Konsultasi HS Code untuk hindari salah klasifikasi|Tracking real-time hingga barang diterima','500+','Shipment ekspor selesai tahun lalu'],
        ['📥','Import Handling',null,'PIB, estimasi bea & pajak (PDRI), hingga penyerahan ke gudang. Tanpa hidden cost.','Import Handling','Stop bayar 2× untuk barang yang sama.','PIB (Pemberitahuan Impor Barang) — full digital CEISA 4.0|Kalkulasi Bea Masuk + PPN + PPh 22 transparan|Pengawalan jalur hijau & merah di Bea Cukai|Customs Clearance Belawan, Tanjung Priok, Tanjung Perak|Storage minimal — koordinasi pickup di hari yang sama|Asuransi all-risk tersedia','0','Hidden cost dalam quote kami'],
        ['🛃','Customs Clearance',null,'Bea cukai di pelabuhan utama Indonesia — Belawan, Tanjung Priok, Soekarno-Hatta.','Customs Clearance','Setiap menit di Bea Cukai = uang yang menguap.','Pengurusan PIB & PEB sesuai PMK terbaru|NHI (Nota Hasil Intelijen) preemptive check|Penanganan Lartas (barang dilarang/terbatas)|Pendampingan pemeriksaan fisik (jalur merah)|Banding & keberatan jika ada penetapan|Update regulasi PMK & PER-BC real-time','1-3 hari','Rata-rata waktu clearance'],
        ['🚚','Door-to-Door',null,'Layanan end-to-end dari gudang pengirim ke pintu penerima, lintas negara.','Door-to-Door','Dari gudangmu ke pintu pembeli. Kami yang tanggung.','Pickup dari gudang/pabrik dengan armada terpercaya|Konsolidasi LCL & FCL untuk biaya optimal|Customs clearance di Indonesia & negara tujuan|Last-mile delivery ke alamat penerima|Single point of contact — 1 PIC dari awal hingga akhir|Proof of Delivery digital langsung ke email','25+','Negara tujuan door-to-door'],
        ['📝','Undername Import','Untuk UMKM','Solusi bagi importir tanpa API (Angka Pengenal Impor). 100% legal dan aman.','Undername Import','Belum punya API/NIB? Tetap bisa impor — legal.','100% legal — terdaftar resmi sebagai importir di Bea Cukai|Kontrak jelas: kamu pemilik barang, kami importir of record|Cocok untuk first-time importer & UMKM|Pengurusan PIB pakai data M2B|Bea masuk + pajak dibayar M2B, kamu reimburse|Berlanjut ke API/NIB sendiri saat bisnis scale','60+','UMKM kami bantu via undername'],
        ['💡','Konsultasi Logistik','Gratis','Panduan ekspor-impor dari tim ahli — perencanaan moda hingga estimasi biaya.','Konsultasi Logistik','Sebelum salah pilih, tanyakan dulu — tanpa bayar.','Audit kebutuhan logistik bisnismu — gratis 30 menit|Pemilihan moda: sea freight, air freight, atau multimoda|Optimasi rute & jadwal pengiriman|Estimasi total cost (freight + bea + pajak + handling)|Strategi negosiasi dengan supplier/buyer luar negeri|Rekomendasi Incoterms (FOB, CIF, DDP) sesuai bisnismu','5 menit','Rata-rata respon WhatsApp'],
      ];
      @endphp
      @foreach($services as $i => [$icon, $title, $badge, $desc, $modalTitle, $tagline, $bulletStr, $statNum, $statLabel])
      <div @click="openService = {{ $i }}" style="background:{{ $i === 0 ? '#0f0f14' : '#fff' }};border:1px solid {{ $i === 0 ? '#0f0f14' : '#e5e2dc' }};border-radius:12px;padding:28px 24px;transition:all .2s;cursor:pointer;position:relative"
        onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,0.12)';this.style.borderColor='#1e3a5f'"
        onmouseout="this.style.transform='none';this.style.boxShadow='0 1px 4px rgba(0,0,0,0.04)';this.style.borderColor='{{ $i === 0 ? '#0f0f14' : '#e5e2dc' }}'">
        @if($badge)
        <div style="position:absolute;top:20px;right:20px;background:#1e3a5f;color:#fff;font-size:10px;padding:3px 10px;border-radius:10px;font-weight:700;letter-spacing:0.5px;text-transform:uppercase">{{ $badge }}</div>
        @endif
        <div style="font-size:28px;margin-bottom:14px">{{ $icon }}</div>
        <div style="font-family:Syne;font-weight:700;font-size:17px;margin-bottom:8px;color:{{ $i === 0 ? '#fff' : '#0f0f14' }}">{{ $title }}</div>
        <div style="font-size:13px;color:{{ $i === 0 ? 'rgba(255,255,255,0.55)' : '#777' }};line-height:1.7;margin-bottom:14px">{{ $desc }}</div>
        <div style="font-size:12px;color:#4a9eda;font-weight:700;display:flex;align-items:center;gap:6px">Pelajari lebih lanjut <span>→</span></div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- Service Modals --}}
  @foreach($services as $i => [$icon, $title, $badge, $desc, $modalTitle, $tagline, $bulletStr, $statNum, $statLabel])
  @php $bullets = explode('|', $bulletStr); @endphp
  <div x-show="openService === {{ $i }}" x-cloak @click="openService = null"
    style="position:fixed;inset:0;z-index:1000;background:rgba(11,17,32,0.78);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;padding:24px">
    <div @click.stop style="background:#fff;border-radius:20px;max-width:960px;width:100%;max-height:92vh;overflow:hidden;display:grid;grid-template-columns:1.1fr 1fr;box-shadow:0 32px 80px rgba(0,0,0,0.5)">
      <div style="position:relative;min-height:480px;background:#0B1120;display:flex;flex-direction:column;justify-content:space-between;padding:36px">
        <div>
          <div style="font-size:40px;margin-bottom:16px">{{ $icon }}</div>
          @if($badge)<span style="display:inline-block;padding:4px 12px;border-radius:20px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:18px">{{ $badge }}</span>@endif
          <h2 style="font-family:Syne;font-weight:800;font-size:28px;color:#fff;letter-spacing:-1px;line-height:1.1;margin-bottom:14px">{{ $modalTitle }}</h2>
          <p style="font-style:italic;font-size:17px;color:#f5b91c;line-height:1.45">"{{ $tagline }}"</p>
        </div>
        <div style="padding:20px 24px;background:rgba(245,185,28,0.12);border:1px solid rgba(245,185,28,0.35);border-radius:14px">
          <div style="font-family:Syne;font-weight:800;font-size:32px;color:#f5b91c;line-height:1">{{ $statNum }}</div>
          <div style="font-size:12px;color:rgba(255,255,255,0.75);margin-top:4px">{{ $statLabel }}</div>
        </div>
      </div>
      <div style="padding:36px;overflow-y:auto;position:relative">
        <button @click="openService = null" style="position:absolute;top:14px;right:14px;width:32px;height:32px;border-radius:50%;background:#fff;border:1px solid #e5e2dc;cursor:pointer;font-size:16px;color:#666">✕</button>
        <div style="font-size:11px;color:#999;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;margin-bottom:14px">Yang Kami Lakukan</div>
        @foreach($bullets as $j => $bullet)
        <div style="display:flex;gap:12px;padding:10px 0;{{ $j < count($bullets)-1 ? 'border-bottom:1px solid #f0ede8' : '' }};align-items:flex-start">
          <div style="width:20px;height:20px;border-radius:50%;background:rgba(30,58,95,0.1);color:#1e3a5f;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;flex-shrink:0;margin-top:1px">✓</div>
          <div style="font-size:13.5px;color:#1A1F2E;line-height:1.65;flex:1">{{ $bullet }}</div>
        </div>
        @endforeach
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid #e5e2dc;display:flex;flex-direction:column;gap:10px">
          <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20tertarik%20layanan%20{{ urlencode($title) }}" target="_blank" style="background:#25D366;color:#fff;text-align:center;padding:13px;border-radius:10px;text-decoration:none;font-weight:800;font-size:14px;display:flex;align-items:center;justify-content:center;gap:8px">💬 Konsultasi via WhatsApp</a>
          <a href="mailto:sales@m2b.co.id" style="background:transparent;color:#0f0f14;text-align:center;padding:12px;border-radius:10px;text-decoration:none;font-weight:700;font-size:13px;border:1.5px solid #d0cdc8">📧 Email sales@m2b.co.id</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</section>

{{-- ═══ PROCESS ═══ --}}
<section id="proses" style="padding:80px 40px;background:#f7f5f0">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:52px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Cara Kerja</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:34px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px">4 Langkah Mudah</h2>
      <p style="color:#666;max-width:440px;margin:0 auto">Prosesnya sederhana — kami yang kerja keras, kamu yang tenang.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0;position:relative">
      <div style="position:absolute;top:44px;left:12.5%;right:12.5%;height:2px;background:linear-gradient(90deg,#1e3a5f,#c7d7f9);z-index:0"></div>
      @foreach([['💬','Konsultasi Gratis','Hubungi kami via WhatsApp atau form. Ceritakan kebutuhan ekspor/impor kamu.'],['📄','Penawaran Transparan','Kami kirim quote detail — biaya, estimasi waktu, dokumen. Tanpa hidden fee.'],['⚙️','Proses Dokumen','Tim M2B mengurus semua dokumen dan bea cukai. Kamu update via portal real-time.'],['✅','Barang Terkirim','Barang tiba aman di tujuan. Tracking tersedia hingga pengiriman selesai.']] as $k => [$icon,$title,$desc])
      <div style="text-align:center;padding:0 20px;position:relative;z-index:1">
        <div style="width:56px;height:56px;border-radius:50%;background:#fff;border:3px solid #1e3a5f;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;box-shadow:0 0 0 6px #f7f5f0">{{ $icon }}</div>
        <div style="font-family:Syne;font-weight:800;font-size:48px;color:rgba(30,58,95,0.1);position:absolute;top:-8px;left:50%;transform:translateX(-50%);line-height:1">0{{ $k+1 }}</div>
        <div style="font-family:Syne;font-weight:700;font-size:15px;margin-bottom:8px">{{ $title }}</div>
        <div style="font-size:13px;color:#777;line-height:1.7">{{ $desc }}</div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ WHY US ═══ --}}
<section style="padding:80px 40px;background:#0f0f14;color:#fff">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.3);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Keunggulan</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:36px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px;color:#fff">Mengapa Memilih Kami?</h2>
      <p style="color:rgba(255,255,255,0.55);max-width:540px;margin:0 auto;font-size:15px">Lebih dari sekadar jasa ekspedisi — M2B adalah mitra strategis untuk kelancaran bisnismu.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px" class="home-features-grid">
      @foreach([
        ['✓','Terdaftar dan Berpengalaman','Resmi terdaftar di Dirjen Bea Cukai, NIB, dan asosiasi industri logistik Indonesia.','500+','Shipment berhasil diselesaikan','https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20cek%20legalitas%20dan%20pengalaman%20M2B'],
        ['💎','Harga Transparan, Tanpa Hidden Cost','Quote rinci dan jujur. Tidak ada surprise di akhir transaksi.','0','Hidden cost dalam setiap quote','https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20minta%20quote%20transparan'],
        ['⚓','Jaringan Kuat di Pelabuhan Utama','Akses langsung ke Belawan, Tanjung Priok, dan Tanjung Perak.','3','Pelabuhan utama Indonesia','https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20butuh%20info%20customs%20di%20pelabuhan'],
        ['⚡','Komunikasi Cepat & Profesional','Respon rapi via WhatsApp, email, atau Portal M2B kapan saja.','< 5 menit','Rata-rata waktu respons','https://wa.me/6281263027818?text=Halo%20M2B'],
        ['🎯','Dukungan Personal Sesuai Kebutuhan','Setiap shipment ditangani konsultan dedikasi, bukan template generik.','1 PIC','Untuk setiap klien & shipment','https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20butuh%20konsultan%20dedikasi'],
        ['🛡','Penanganan Barang Aman & Terjamin','Proteksi penuh dari gudang hingga tujuan akhir. Asuransi tersedia.','100%','Shipment terlindungi asuransi','https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20info%20asuransi%20kargo'],
      ] as [$icon,$t,$d,$stat,$statLabel,$wa])
      <div x-data="{ hov: false }" @mouseenter="hov=true" @mouseleave="hov=false"
        style="padding:26px 22px;border-radius:14px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);transition:all .25s;cursor:default;display:flex;flex-direction:column"
        :style="hov ? 'background:rgba(30,58,95,0.22);border-color:rgba(74,158,218,0.35);transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,0.3)' : ''">
        <div style="width:46px;height:46px;border-radius:12px;background:rgba(30,58,95,0.45);color:#4a9eda;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;margin-bottom:16px;transition:background .25s"
          :style="hov ? 'background:rgba(30,58,95,0.7)' : ''">{{ $icon }}</div>
        <div style="font-family:Syne;font-weight:700;font-size:16px;color:#fff;margin-bottom:8px">{{ $t }}</div>
        <div style="font-size:13px;color:rgba(255,255,255,0.55);line-height:1.7;flex:1">{{ $d }}</div>
        <div x-show="hov" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
          style="margin-top:18px;padding-top:16px;border-top:1px solid rgba(74,158,218,0.25)">
          <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:12px">
            <span style="font-family:Syne;font-weight:800;font-size:26px;color:#4a9eda;line-height:1">{{ $stat }}</span>
            <span style="font-size:12px;color:rgba(255,255,255,0.4);line-height:1.3">{{ $statLabel }}</span>
          </div>
          <a href="{{ $wa }}" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:6px;padding:9px 14px;border-radius:8px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:12px">💬 Tanya Sekarang</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ ABOUT PREVIEW ═══ --}}
<section id="about" style="padding:80px 40px;background:#fff;border-top:1px solid #e5e2dc">
  <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1.4fr;gap:56px;align-items:center">
    <div style="position:relative">
      <div style="border-radius:16px;overflow:hidden;aspect-ratio:4/5;border:1px solid #e5e2dc;box-shadow:0 16px 48px rgba(0,0,0,0.12);position:relative">
        <img src="{{ asset('images/director-eka.jpg') }}" alt="Eka Mayang Sari Harahap, S.E." style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block">
        <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top,rgba(11,17,32,0.8),transparent);padding:20px 18px 16px">
          <div style="font-family:Syne;font-weight:800;font-size:14px;color:#fff">Eka Mayang Sari Harahap, S.E.</div>
          <div style="font-size:11px;color:rgba(255,255,255,0.7)">Direktur — PT. Mora Multi Berkah</div>
        </div>
      </div>
    </div>
    <div>
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Tentang Kami</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:32px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:18px;line-height:1.2">
        Freight Forwarder & Jasa Logistik<br>
        <span style="color:#1e3a5f">Terpercaya di Indonesia.</span>
      </h2>
      <p style="font-size:15px;color:#555;line-height:1.85;margin-bottom:18px">Kami adalah perusahaan <strong>freight forwarder</strong> sekaligus <strong>PPJK</strong> yang berbasis di Medan, Sumatera Utara — Indonesia. Kami menyediakan layanan logistik ekspor-impor secara menyeluruh, mulai dari pengurusan dokumen, customs clearance, hingga pengiriman barang ke berbagai destinasi nasional maupun internasional.</p>
      <p style="font-size:15px;color:#555;line-height:1.85;margin-bottom:24px">Kami hadir untuk membantu UMKM maupun perusahaan besar dengan solusi logistik yang andal dan terukur sesuai kebutuhan Anda.</p>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px">
        @foreach([['🏆','5+ Tahun','Berpengalaman'],['🌍','20+','Negara Tujuan'],['🤝','100+','Klien Aktif']] as [$icon,$big,$sub])
        <div style="padding:14px 16px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8">
          <div style="font-size:18px;margin-bottom:4px">{{ $icon }}</div>
          <div style="font-family:Syne;font-weight:800;font-size:16px;color:#1e3a5f">{{ $big }}</div>
          <div style="font-size:11px;color:#888">{{ $sub }}</div>
        </div>
        @endforeach
      </div>
      <a href="{{ route('about') }}" style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:14px">Selengkapnya →</a>
    </div>
  </div>
</section>



{{-- ═══ QUICK QUOTE ESTIMATOR ═══ --}}
<section style="padding:80px 40px;background:#0f0f14" x-data="{
  step: 1,
  service: '',
  origin: '',
  dest: '',
  weight: '',
  getLabel: function(s) {
    return {
      'export': '📤 Export Handling',
      'import': '📥 Import Handling',
      'customs': '🛃 Customs Clearance',
      'door': '🚚 Door-to-Door'
    }[s] || s
  }
}">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.3);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Free Estimator</span>
    <h2 style="font-family:Syne;font-weight:800;font-size:34px;color:#fff;letter-spacing:-0.8px;margin-top:12px;margin-bottom:8px">Estimasi Biaya Logistik</h2>
    <p style="color:rgba(255,255,255,0.5);font-size:15px;margin-bottom:40px">Pilih layanan dan kami akan bantu estimasi kebutuhan Anda via WhatsApp — gratis, cepat, tanpa komitmen.</p>

    {{-- Step 1: Pilih Layanan --}}
    <div x-show="step === 1">
      <div style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:20px;font-weight:600;text-transform:uppercase;letter-spacing:1px">Langkah 1 dari 3 — Pilih Layanan</div>
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;max-width:520px;margin:0 auto 28px">
        @foreach([
          'export'  => ['📤','Export Handling',   'PEB, COO/SKA, ke 20+ negara'],
          'import'  => ['📥','Import Handling',   'PIB, kalkulasi bea & pajak'],
          'customs' => ['🛃','Customs Clearance', 'Belawan, Priok, Perak'],
          'door'    => ['🚚','Door-to-Door',       'Gudang pengirim → pintu penerima'],
        ] as $val => [$icon, $name, $sub])
        <button @click="service = '{{ $val }}'; step = 2"
          :style="service === '{{ $val }}' ? 'background:rgba(30,58,95,0.7);border-color:#4a9eda;box-shadow:0 0 0 3px rgba(74,158,218,0.2)' : ''"
          style="padding:22px 16px;border-radius:14px;border:1.5px solid rgba(255,255,255,0.12);background:rgba(255,255,255,0.05);color:#fff;cursor:pointer;text-align:center;transition:all .2s;display:flex;flex-direction:column;align-items:center;gap:8px"
          onmouseover="if(this.getAttribute('data-v')!=='1'){this.style.background='rgba(30,58,95,0.4)';this.style.borderColor='rgba(74,158,218,0.4)'}"
          onmouseout="if(this.getAttribute('data-v')!=='1'){this.style.background='rgba(255,255,255,0.05)';this.style.borderColor='rgba(255,255,255,0.12)'}">
          <span style="font-size:34px;line-height:1;display:block">{{ $icon }}</span>
          <span style="font-family:Syne;font-weight:700;font-size:14px;display:block">{{ $name }}</span>
          <span style="font-size:11px;color:rgba(255,255,255,0.45);display:block;line-height:1.4">{{ $sub }}</span>
        </button>
        @endforeach
      </div>
    </div>

    {{-- Step 2: Origin & Destination --}}
    <div x-show="step === 2">
      <div style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:16px;font-weight:600;text-transform:uppercase;letter-spacing:1px">Langkah 2 dari 3 — Rute Pengiriman</div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;max-width:480px;margin:0 auto 20px">
        <div>
          <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-bottom:6px;text-align:left">Asal / Origin</div>
          <input x-model="origin" type="text" placeholder="Mis: Medan, Jakarta" style="width:100%;padding:12px 14px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.08);color:#fff;font-size:14px;font-family:'DM Sans';outline:none" onfocus="this.style.borderColor='#4a9eda'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
        </div>
        <div>
          <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-bottom:6px;text-align:left">Tujuan / Destination</div>
          <input x-model="dest" type="text" placeholder="Mis: Singapura, China" style="width:100%;padding:12px 14px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.08);color:#fff;font-size:14px;font-family:'DM Sans';outline:none" onfocus="this.style.borderColor='#4a9eda'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
        </div>
      </div>
      <div style="display:flex;gap:12px;justify-content:center;max-width:480px;margin:0 auto">
        <button @click="step = 1" style="padding:12px 20px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.2);background:transparent;color:#fff;cursor:pointer;font-family:'DM Sans';font-size:14px">← Kembali</button>
        <button @click="if(origin && dest) step = 3" style="flex:1;padding:12px;border-radius:8px;background:#1e3a5f;color:#fff;border:none;cursor:pointer;font-family:'DM Sans';font-size:14px;font-weight:700">Lanjut →</button>
      </div>
    </div>

    {{-- Step 3: Weight + Final CTA --}}
    <div x-show="step === 3">
      <div style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:16px;font-weight:600;text-transform:uppercase;letter-spacing:1px">Langkah 3 dari 3 — Estimasi Muatan</div>
      <div style="max-width:480px;margin:0 auto">
        <div style="margin-bottom:20px">
          <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-bottom:6px;text-align:left">Berat / Volume Kargo (opsional)</div>
          <input x-model="weight" type="text" placeholder="Mis: 500 kg, 1 FCL 20ft, 2 CBM" style="width:100%;padding:12px 14px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.08);color:#fff;font-size:14px;font-family:'DM Sans';outline:none" onfocus="this.style.borderColor='#4a9eda'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
        </div>
        <div style="background:rgba(30,58,95,0.3);border:1px solid rgba(30,58,95,0.5);border-radius:12px;padding:16px;margin-bottom:20px;text-align:left">
          <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-bottom:8px;font-weight:600">RINGKASAN REQUEST</div>
          <div style="font-size:14px;color:#fff">🎯 Layanan: <strong x-text="getLabel(service)"></strong></div>
          <div style="font-size:14px;color:#fff;margin-top:4px">🗺️ Rute: <strong x-text="origin + ' → ' + dest"></strong></div>
          <div x-show="weight" style="font-size:14px;color:#fff;margin-top:4px">⚖️ Muatan: <strong x-text="weight"></strong></div>
        </div>
        <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent('Halo M2B, saya ingin estimasi biaya untuk:\n- Layanan: ' + getLabel(service) + '\n- Rute: ' + origin + ' → ' + dest + (weight ? '\n- Muatan: ' + weight : '') + '\n\nMohon bantu estimasi dan quote-nya ya. Terima kasih.')"
          target="_blank"
          style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:16px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:16px;margin-bottom:12px">
          💬 Kirim ke WhatsApp & Minta Quote
        </a>
        <button @click="step = 2" style="width:100%;padding:12px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.2);background:transparent;color:rgba(255,255,255,0.6);cursor:pointer;font-family:'DM Sans';font-size:14px">← Edit Rute</button>
      </div>
    </div>

    {{-- Progress indicators --}}
    <div style="display:flex;justify-content:center;gap:8px;margin-top:32px">
      @for($n = 1; $n <= 3; $n++)
      <div :style="step >= {{ $n }} ? 'background:#4a9eda;width:24px' : 'background:rgba(255,255,255,0.15);width:8px'" style="height:4px;border-radius:4px;transition:all .3s"></div>
      @endfor
    </div>
  </div>
</section>

{{-- ═══ FAQ ═══ --}}
<section style="padding:80px 40px;background:#f7f5f0;border-top:1px solid #e5e2dc">
  <div style="max-width:780px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">FAQ</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:34px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px">Pertanyaan yang Sering Diajukan</h2>
      <p style="color:#666;font-size:15px">Semua yang ingin Anda tahu tentang layanan ekspor-impor M2B.</p>
    </div>
    <div x-data="{ open: null }">
      @php
      $faqs = [
        ['Berapa estimasi biaya customs clearance di M2B?','Biaya customs clearance bervariasi tergantung HS Code, nilai barang, dan jenis jalur (hijau/merah). M2B memberikan kalkulasi transparan termasuk bea masuk, PPN, PPh 22, dan handling fee — tanpa hidden cost. Hubungi kami untuk quote gratis.'],
        ['Apakah M2B bisa mengurus impor untuk UMKM yang belum punya API?','Ya! Kami menyediakan layanan Undername Import khusus untuk importir yang belum memiliki Angka Pengenal Impor (API). 100% legal — M2B bertindak sebagai importir of record, sementara Anda tetap pemilik sah barang.'],
        ['Berapa lama proses customs clearance di Pelabuhan Belawan?','Rata-rata 1–3 hari kerja untuk jalur hijau. Jalur merah bisa 3–7 hari tergantung kompleksitas pemeriksaan. M2B memiliki akses langsung ke sistem CEISA 4.0 dan relasi kuat di pelabuhan Belawan, Tanjung Priok, dan Tanjung Perak.'],
        ['Dokumen apa saja yang diperlukan untuk ekspor?','Untuk ekspor standar: Commercial Invoice, Packing List, Bill of Lading/AWB, dan COO/SKA (Certificate of Origin) jika diperlukan negara tujuan. M2B membantu menyiapkan dan memverifikasi semua dokumen hingga PEB (Pemberitahuan Ekspor Barang).'],
        ['Apakah M2B menyediakan layanan door-to-door ke luar negeri?','Ya! Kami melayani door-to-door ke 25+ negara — dari pickup di gudang Anda, customs clearance di Indonesia, pengiriman internasional, customs di negara tujuan, hingga last-mile delivery. Satu PIC dari awal hingga akhir.'],
        ['Bagaimana cara melacak status shipment saya?','Anda dapat menghubungi langsung tim M2B via WhatsApp (+62 812-6302-7818) untuk update real-time status shipment. Tim kami merespons dalam hitungan menit selama jam operasional (Senin–Sabtu, 08.00–17.00 WIB).'],
      ];
      @endphp
      @foreach($faqs as $i => [$q, $a])
      <div style="border-bottom:1px solid #e5e2dc;padding:4px 0">
        <button @click="open = open === {{ $i }} ? null : {{ $i }}"
          style="width:100%;text-align:left;padding:20px 0;background:transparent;border:none;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px;font-family:'DM Sans',sans-serif">
          <span style="font-family:Syne;font-weight:700;font-size:16px;color:#0f0f14;line-height:1.4">{{ $q }}</span>
          <span :style="open === {{ $i }} ? 'transform:rotate(45deg)' : ''" style="flex-shrink:0;width:28px;height:28px;border-radius:50%;background:rgba(30,58,95,0.1);display:flex;align-items:center;justify-content:center;font-size:16px;color:#1e3a5f;transition:transform .2s;font-weight:700">+</span>
        </button>
        <div x-show="open === {{ $i }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100" style="padding:0 0 20px">
          <p style="font-size:15px;color:#555;line-height:1.8;padding:16px 20px;background:#fff;border-radius:10px;border-left:3px solid #1e3a5f">{{ $a }}</p>
          @if($i === 0)
          <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20minta%20quote%20customs%20clearance" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;font-size:13px;color:#25D366;font-weight:600;text-decoration:none">💬 Minta Quote Sekarang →</a>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    <div style="margin-top:36px;text-align:center">
      <p style="color:#777;font-size:14px;margin-bottom:16px">Pertanyaan lain? Tim M2B siap membantu.</p>
      <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20punya%20pertanyaan" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:14px">💬 Tanya via WhatsApp</a>
    </div>
  </div>
</section>

{{-- ═══ TESTIMONIALS ═══ --}}
<section style="padding:80px 40px;background:#fff;border-top:1px solid #e5e2dc">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Testimoni</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:34px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px">Dipercaya Ratusan Klien</h2>
      <p style="color:#666">Dari UKM hingga perusahaan ekspor skala besar.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px" class="home-testimonials-grid">
      @foreach([['"Penanganan impor dengan biaya yang jelas dan terukur, tepat waktu. Sangat layak menjadi rekan bisnis Anda."','Edy Serdawanto','Direktur — PT. Dira Baraka Mulia'],['"Game-changer for our business! The team at M2B is reliable, efficient, and always responsive."','Mr. Jhonson','GM — Anhui Imp & Export Co., Ltd'],['"Tim M2B sangat suportif dan transparan. Tidak ada biaya tersembunyi — ini yang kami cari."','Sarah Aulia','Online Business Owner — Medan']] as [$q,$name,$co])
      <div style="background:#f7f5f0;border-radius:12px;padding:28px 24px;border:1px solid #e5e2dc">
        <div style="color:#f5b91c;font-size:18px;margin-bottom:12px">★★★★★</div>
        <p style="font-size:14px;color:#444;line-height:1.75;margin-bottom:20px;font-style:italic">{{ $q }}</p>
        <div style="display:flex;gap:10px;align-items:center">
          <div style="width:40px;height:40px;border-radius:50%;background:rgba(30,58,95,0.1);border:2px solid rgba(30,58,95,0.2);display:flex;align-items:center;justify-content:center;font-family:Syne;font-weight:800;color:#1e3a5f;font-size:16px">{{ substr($name,0,1) }}</div>
          <div>
            <div style="font-weight:700;font-size:14px">{{ $name }}</div>
            <div style="font-size:12px;color:#999">{{ $co }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ LATEST BLOG ═══ --}}
@if($latestPosts->count() > 0)
<section id="berita" style="padding:80px 40px;background:#fff;border-top:1px solid #e5e2dc">
  <div style="max-width:1200px;margin:0 auto">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:32px;flex-wrap:wrap;gap:16px">
      <div>
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Artikel Terbaru</span>
        <h2 style="font-family:Syne;font-weight:800;font-size:34px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:6px">Update Logistik & Shipment</h2>
        <p style="color:#666;font-size:15px">Info terkini seputar pelabuhan, regulasi, dan kegiatan pengiriman.</p>
      </div>
      <a href="{{ route('blog.index') }}" style="font-size:13px;color:#1e3a5f;font-weight:600;text-decoration:none">Lihat semua artikel →</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px" class="home-blog-grid">
      @foreach($latestPosts as $post)
      <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;border-radius:12px;overflow:hidden;border:1px solid #e5e2dc;background:#fff;display:flex;flex-direction:column;transition:box-shadow .2s" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
        @if($post->featured_image)
        <div style="height:200px;background-image:url({{ Storage::url($post->featured_image) }});background-size:cover;background-position:center"></div>
        @else
        <div style="height:200px;background:linear-gradient(135deg,#1e3a5f,#2a5298);display:flex;align-items:center;justify-content:center;font-size:48px">📦</div>
        @endif
        <div style="padding:20px 22px;flex:1;display:flex;flex-direction:column">
          @if($post->category)<span style="display:inline-block;padding:3px 8px;border-radius:4px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase;margin-bottom:10px">{{ $post->category }}</span>@endif
          <h3 style="font-family:Syne;font-weight:700;font-size:16px;line-height:1.4;color:#0f0f14;margin-bottom:10px;flex:1">{{ $post->title }}</h3>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;font-size:12px;color:#999">
            <span>{{ $post->published_at?->format('d M Y') }}</span>
            <span style="color:#1e3a5f;font-weight:600">Baca →</span>
          </div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ═══ CTA SECTION ═══ --}}
<section style="padding:80px 40px;background:#0f0f14">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <h2 style="font-family:Syne;font-weight:800;font-size:40px;color:#fff;letter-spacing:-1px;margin-bottom:16px;line-height:1.1">
      Siap Ekspor atau Impor?<br>
      <span style="color:#4a9eda">Mulai Hari Ini.</span>
    </h2>
    <p style="color:rgba(255,255,255,0.5);font-size:16px;margin-bottom:36px;line-height:1.7">Konsultasi gratis, quote transparan, respon cepat. Tidak ada komitmen sebelum kamu setuju.</p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
      <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20mau%20konsultasi" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:16px">💬 Chat WhatsApp Sekarang</a>
      <a href="mailto:sales@m2b.co.id" style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;border-radius:8px;color:#fff;text-decoration:none;font-weight:600;font-size:16px;border:1.5px solid rgba(255,255,255,0.25);background:rgba(255,255,255,0.06)">📧 Email Kami</a>
    </div>
  </div>
</section>

@endsection
