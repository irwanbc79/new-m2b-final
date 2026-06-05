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
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase;margin-bottom:16px" x-text="$store.lang.t('Tentang Kami', 'About Us', '关于我们', 'من نحن')">Tentang Kami</span>
    <h1 style="font-family:Syne;font-weight:800;font-size:48px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1">PT. Mora Multi Berkah<br><span style="color:#4a9eda" x-text="$store.lang.t('Mitra Logistik Terpercaya', 'Trusted Logistics Partner', '值得信赖的物流合作伙伴', 'شريك لوجستي موثوق')">Mitra Logistik Terpercaya</span></h1>
    <p style="color:rgba(255,255,255,0.6);font-size:17px;max-width:580px" x-text="$store.lang.t('Freight Forwarder & Customs Broker yang berbasis di Medan, Sumatera Utara. Melayani ekspor-impor ke 20+ negara dengan transparan dan profesional.', 'Freight Forwarder & Customs Broker based in Medan, North Sumatra. Serving export-import to 20+ countries with transparency and professionalism.', '总部位于印尼北苏门答腊省棉兰市的货运代理与报关行。以透明和专业的态度为20多个国家提供进出口物流服务。', 'وكيل شحن ومخلص جمركي مقرنا في ميدان، شمال سومطرة. نخدم الاستيراد والتصدير إلى ٢٠+ دولة بشفافية واحترافية.')">Freight Forwarder & Customs Broker yang berbasis di Medan, Sumatera Utara. Melayani ekspor-impor ke 20+ negara dengan transparan dan profesional.</p>
  </div>
</div>

<section style="padding:80px 40px;background:#fff" class="about-section">
  <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1.4fr;gap:56px;align-items:center" class="about-intro-grid">
    <div style="position:relative">
      {{-- Director photo --}}
      <div style="border-radius:16px;overflow:hidden;aspect-ratio:4/5;box-shadow:0 16px 48px rgba(0,0,0,0.14);position:relative">
        <picture style="display:block;width:100%;height:100%">
          <source srcset="{{ asset('images/director-eka.webp') }}" type="image/webp">
          <img src="{{ asset('images/director-eka.jpg') }}"
               alt="Eka Mayang Sari Harahap, S.E. — Direktur PT. Mora Multi Berkah"
               style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block">
        </picture>
        {{-- Gradient overlay at bottom --}}
        <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top,rgba(11,17,32,0.85) 0%,rgba(11,17,32,0) 60%);padding:24px 22px 22px">
          <div style="font-family:Syne;font-weight:800;font-size:15px;color:#fff">Eka Mayang Sari Harahap, S.E.</div>
          <div style="font-size:12px;color:rgba(255,255,255,0.7);margin-top:3px" x-text="$store.lang.t('Direktur — PT. Mora Multi Berkah', 'Director — PT. Mora Multi Berkah', '董事长 — PT. Mora Multi Berkah', 'المدير — PT. Mora Multi Berkah')">Direktur — PT. Mora Multi Berkah</div>
          <div style="display:flex;gap:14px;margin-top:12px">
            @foreach([['20+',['id'=>'Negara','en'=>'Countries','zh'=>'国家/地区','ar'=>'دولة']],['5+',['id'=>'Tahun','en'=>'Years','zh'=>'年经验','ar'=>'سنوات']],['100+',['id'=>'Klien','en'=>'Clients','zh'=>'客户','ar'=>'عميل']]] as [$n,$l])
            <div style="text-align:center">
              <div style="font-family:Syne;font-weight:800;font-size:16px;color:#4a9eda">{{ $n }}</div>
              <div style="font-size:10px;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.5px" x-text="$store.lang.t('{{ $l['id'] }}', '{{ $l['en'] }}', '{{ $l['zh'] }}', '{{ $l['ar'] }}')">{{ $l['id'] }}</div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div>
      <h2 style="font-family:Syne;font-weight:800;font-size:32px;letter-spacing:-0.8px;margin-bottom:18px;line-height:1.2;color:#0f0f14">
        <span x-show="lang==='id'">Freight Forwarder & Jasa Logistik <span style="color:#1e3a5f">Terpercaya di Indonesia.</span></span>
        <span x-show="lang==='en'" x-cloak>Trusted Freight Forwarder & <span style="color:#1e3a5f">Logistics Partner in Indonesia.</span></span>
        <span x-show="lang==='zh'" x-cloak>印尼值得信赖的 <span style="color:#1e3a5f">货运代理与物流合作伙伴。</span></span>
        <span x-show="lang==='ar'" x-cloak>وكيل شحن وشريك لوجستي <span style="color:#1e3a5f">موثوق به في إندونيسيا.</span></span>
      </h2>
      <p style="font-size:15px;color:#555;line-height:1.85;margin-bottom:18px">
        <span x-show="lang==='id'">Kami adalah perusahaan <strong>freight forwarder</strong> sekaligus <strong>PPJK (Pengusaha Pengurusan Jasa Kepabeanan)</strong> yang berbasis di Medan, Sumatera Utara — Indonesia. Kami menyediakan layanan logistik ekspor-impor secara menyeluruh, mulai dari pengurusan dokumen, customs clearance, hingga pengiriman barang ke berbagai destinasi nasional maupun internasional.</span>
        <span x-show="lang==='en'" x-cloak>We are a <strong>freight forwarding</strong> and <strong>PPJK (Customs Brokerage)</strong> company based in Medan, North Sumatra — Indonesia. We provide comprehensive export-import logistics services, from document processing and customs clearance to cargo delivery across domestic and international destinations.</span>
        <span x-show="lang==='zh'" x-cloak>我们是一家总部位于印尼苏门答腊省棉兰市的<strong>货运代理</strong>与<strong>报关（PPJK）</strong>公司。我们提供全方位的进出口物流服务，包括单证处理、海关清关，以及向印尼国内及全球各目的地的货物运输。</span>
        <span x-show="lang==='ar'" x-cloak>نحن شركة <strong>شحن</strong> و <strong>تخليص جمركي (PPJK)</strong> مقرها في ميدان، شمال سومطرة — إندونيسيا. نحن نقدم خدمات لوجستية شاملة للاستيراد والتصدير، بدءاً من معالجة المستندات والتخليص الجمركي إلى تسليم البضائع إلى مختلف الوجهات المحلية والدولية.</span>
      </p>
      <p style="font-size:15px;color:#555;line-height:1.85;margin-bottom:24px">
        <span x-show="lang==='id'">Berdiri dengan komitmen untuk memberikan layanan logistik yang <strong>transparan, andal, dan terukur</strong>, M2B hadir untuk membantu UMKM maupun perusahaan besar dalam mengelola aktivitas perdagangan internasional mereka dengan lebih efisien.</span>
        <span x-show="lang==='en'" x-cloak>Established with a commitment to provide <strong>transparent, reliable, and scalable</strong> logistics services, M2B is here to support both SMEs and large corporations in managing their international trade activities more efficiently.</span>
        <span x-show="lang==='zh'" x-cloak>我们秉持提供<strong>透明、可靠和可扩展</strong>物流服务的承诺而创立，M2B 旨在帮助中小企业以及大型企业更高效地管理其国际贸易活动。</span>
        <span x-show="lang==='ar'" x-cloak>تأسست M2B مع الالتزام بتقديم خدمات لوجستية <strong>شفافة وموثوقة وقابلة للتطوير</strong>، وهي هنا لدعم الشركات الصغيرة والمتوسطة وكذلك الشركات الكبرى في إدارة أنشطة التجارة الدولية الخاصة بها بشكل أكثر كفاءة.</span>
      </p>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px" class="about-stats-grid">
        @php
        $aboutStats2 = [
          ['🏆', '5+ Tahun', ['id' => 'Berpengalaman', 'en' => 'Years of Exp.', 'zh' => '年行业经验', 'ar' => 'سنوات خبرة']],
          ['🌍', '20+', ['id' => 'Negara Tujuan', 'en' => 'Destinations', 'zh' => '覆盖国家/地区', 'ar' => 'وجهات شحن']],
          ['🤝', '100+', ['id' => 'Klien Aktif', 'en' => 'Active Clients', 'zh' => '活跃客户', 'ar' => 'عملاء نشطين']]
        ];
        @endphp
        @foreach($aboutStats2 as $stat)
        <div style="padding:14px 16px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8;text-align:center">
          <div style="font-size:22px;margin-bottom:8px">{{ $stat[0] }}</div>
          <div style="font-family:Syne;font-weight:800;font-size:20px;color:#1e3a5f">{{ $stat[1] }}</div>
          <div style="font-size:11px;color:#888;margin-top:4px" x-text="$store.lang.t('{{ $stat[2]['id'] }}', '{{ $stat[2]['en'] }}', '{{ $stat[2]['zh'] }}', '{{ $stat[2]['ar'] }}')">{{ $stat[2]['id'] }}</div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<section style="padding:80px 40px;background:#f7f5f0;border-top:1px solid #e5e2dc" class="about-section">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <h2 style="font-family:Syne;font-weight:800;font-size:32px;letter-spacing:-0.8px" x-text="$store.lang.t('Visi & Misi', 'Vision & Mission', '愿景与使命', 'الرؤية والرسالة')">Visi & Misi</h2>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px" class="about-vision-grid">
      <div style="background:#fff;border-radius:14px;padding:36px;border:1px solid #e5e2dc">
        <div style="font-size:32px;margin-bottom:16px">🎯</div>
        <h3 style="font-family:Syne;font-weight:800;font-size:22px;color:#1e3a5f;margin-bottom:12px" x-text="$store.lang.t('Visi', 'Vision', '愿景', 'الرؤية')">Visi</h3>
        <p style="font-size:15px;color:#555;line-height:1.85" x-text="$store.lang.t('Menjadi perusahaan freight forwarding & customs brokerage terpercaya di Indonesia yang membantu UMKM dan perusahaan besar menembus pasar global dengan mudah, aman, dan efisien.', 'To be the most trusted freight forwarding & customs brokerage company in Indonesia, helping SMEs and large enterprises penetrate global markets easily, safely, and efficiently.', '成为印尼最值得信赖的货运代理与报关公司，帮助中小企业和大型企业轻松、安全且高效地开拓全球市场。', 'أن نكون شركة الشحن والتخليص الجمركي الأكثر موثوقية في إندونيسيا، لمساعدة الشركات الصغيرة والمتوسطة والكبرى على اختراق الأسواق العالمية بسهولة وأمان وكفاءة.')">Menjadi perusahaan freight forwarding & customs brokerage terpercaya di Indonesia yang membantu UMKM dan perusahaan besar menembus pasar global dengan mudah, aman, dan efisien.</p>
      </div>
      <div style="background:#fff;border-radius:14px;padding:36px;border:1px solid #e5e2dc">
        <div style="font-size:32px;margin-bottom:16px">🚀</div>
        <h3 style="font-family:Syne;font-weight:800;font-size:22px;color:#1e3a5f;margin-bottom:12px" x-text="$store.lang.t('Misi', 'Mission', '使命', 'الرسالة')">Misi</h3>
        <ul style="font-size:15px;color:#555;line-height:1.85;list-style:none;padding:0">
          @php
          $misiList = [
            [['id' => 'Memberikan layanan logistik transparan tanpa hidden cost', 'en' => 'Provide transparent logistics services without hidden costs', 'zh' => '提供透明的物流服务，绝无隐藏费用', 'ar' => 'تقديم خدمات لوجستية شفافة بدون تكاليف خفية']],
            [['id' => 'Membangun ekosistem ekspor-impor yang aksesibel untuk UMKM', 'en' => 'Build an accessible export-import ecosystem for SMEs', 'zh' => '为中小企业构建易于参与的进出口生态系统', 'ar' => 'بناء بيئة استيراد وتصدير سهلة الوصول للشركات الصغيرة والمتوسطة']],
            [['id' => 'Mengelola setiap shipment dengan dedikasi dan profesionalisme', 'en' => 'Manage every shipment with dedication and professionalism', 'zh' => '以敬业和专业的精神管理每一票货运', 'ar' => 'إدارة كل شحنة بتفان واحترافية']],
            [['id' => 'Selalu update regulasi untuk perlindungan klien terbaik', 'en' => 'Stay updated on regulations for the best client protection', 'zh' => '实时更新政策法规，为客户提供最佳保障', 'ar' => 'مواكبة اللوائح باستمرار لتوفير أفضل حماية للعملاء']]
          ];
          @endphp
          @foreach($misiList as $misi)
          <li style="display:flex;gap:10px;margin-bottom:10px">
            <span style="color:#1e3a5f;font-weight:700;flex-shrink:0">✓</span>
            <span x-text="$store.lang.t('{{ $misi[0]['id'] }}', '{{ $misi[0]['en'] }}', '{{ $misi[0]['zh'] }}', '{{ $misi[0]['ar'] }}')">{{ $misi[0]['id'] }}</span>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>

<section style="padding:80px 40px;background:#fff;border-top:1px solid #e5e2dc" class="about-section">
  <div style="max-width:1200px;margin:0 auto;text-align:center;margin-bottom:48px">
    <h2 style="font-family:Syne;font-weight:800;font-size:32px;letter-spacing:-0.8px" x-text="$store.lang.t('Legalitas & Sertifikasi', 'Legality & Certification', '资质与认证', 'القانونية والشهادات')">Legalitas & Sertifikasi</h2>
    <p style="color:#666;margin-top:12px" x-text="$store.lang.t('M2B terdaftar resmi dan diakui oleh lembaga dan asosiasi industri terpercaya.', 'M2B is officially registered and recognized by trusted organizations and industry associations.', 'M2B 在印尼官方注册，并获得可信赖机构和行业协会的认可。', 'M2B مسجلة رسمياً ومعترف بها من قبل منظمات وجمعيات قطاع الصناعة الموثوقة.')">M2B terdaftar resmi dan diakui oleh lembaga dan asosiasi industri terpercaya.</p>
  </div>
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:20px" class="about-cert-grid">
    @php
    $certs = [
      ['🏛️', ['id'=>'Dirjen Bea dan Cukai RI','en'=>'Directorate General of Customs & Excise','zh'=>'印尼海关总署','ar'=>'المديرية العامة للجمارك والمكوس الإندونيسية'], ['id'=>'Terdaftar sebagai PPJK resmi','en'=>'Registered as an official customs broker','zh'=>'注册官方报关行资质（PPJK）','ar'=>'مسجل كوسيط جمركي رسمي']],
      ['📋', ['id'=>'NIB (Nomor Induk Berusaha)','en'=>'NIB (Business Registration Number)','zh'=>'商业登记号 (NIB)','ar'=>'رقم تسجيل الأعمال (NIB)'], ['id'=>'Legalitas usaha lengkap dan terverifikasi','en'=>'Complete and verified business legality','zh'=>'完整且经过验证的商业合法合规性','ar'=>'قانونية أعمال كاملة ومثبتة']],
      ['🤝', ['id'=>'ALFI','en'=>'ALFI','zh'=>'印尼物流与货运代理协会 (ALFI)','ar'=>'ALFI'], ['id'=>'Anggota Asosiasi Logistik & Forwarder Indonesia','en'=>'Member of the Indonesian Logistics & Forwarders Association','zh'=>'官方会员单位','ar'=>'عضو في الجمعية الإندونيسية للوجستيات ووكلاء الشحن']],
      ['💼', ['id'=>'KADIN','en'=>'KADIN','zh'=>'印尼工商会 (KADIN)','ar'=>'KADIN'], ['id'=>'Anggota Kamar Dagang dan Industri Indonesia','en'=>'Member of the Indonesian Chamber of Commerce & Industry','zh'=>'官方会员单位','ar'=>'عضو في غرفة التجارة والصناعة الإندونيسية']],
      ['🌐', ['id'=>'LNSW','en'=>'LNSW','zh'=>'国家单窗口服务系统 (LNSW)','ar'=>'LNSW'], ['id'=>'Terhubung dengan Layanan Nasional Single Window','en'=>'Connected with the Indonesia National Single Window','zh'=>'实时对接系统','ar'=>'متصل بالنافذة الوطنية الموحدة لإندونيسيا']],
      ['⚓', ['id'=>'Pelindo','en'=>'Pelindo','zh'=>'印尼港口集团 (Pelindo)','ar'=>'Pelindo'], ['id'=>'Mitra operasional di pelabuhan utama','en'=>'Operational partner at major ports','zh'=>'主要港口业务合作伙伴','ar'=>'شريك تشغيلي في الموانئ الرئيسية']]
    ];
    @endphp
    @foreach($certs as $cert)
    <div style="padding:24px;border-radius:12px;border:1px solid #e5e2dc;background:#fafaf8;display:flex;gap:16px;align-items:flex-start">
      <div style="font-size:28px;flex-shrink:0">{{ $cert[0] }}</div>
      <div>
        <div style="font-family:Syne;font-weight:700;font-size:15px;margin-bottom:4px" x-text="$store.lang.t('{{ $cert[1]['id'] }}', '{{ $cert[1]['en'] }}', '{{ $cert[1]['zh'] }}', '{{ $cert[1]['ar'] }}')">{{ $cert[1]['id'] }}</div>
        <div style="font-size:13px;color:#777" x-text="$store.lang.t('{{ $cert[2]['id'] }}', '{{ $cert[2]['en'] }}', '{{ $cert[2]['zh'] }}', '{{ $cert[2]['ar'] }}')">{{ $cert[2]['id'] }}</div>
      </div>
    </div>
    @endforeach
  </div>
</section>

<section style="padding:60px 40px;background:#0f0f14">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <h2 style="font-family:Syne;font-weight:800;font-size:36px;color:#fff;letter-spacing:-1px;margin-bottom:16px" x-text="$store.lang.t('Siap Bekerja Sama?', 'Ready to Work Together?', '准备好合作了吗？', 'جاهز للعمل معنا؟')">Siap Bekerja Sama?</h2>
    <p style="color:rgba(255,255,255,0.5);font-size:16px;margin-bottom:32px" x-text="$store.lang.t('Konsultasikan kebutuhan logistik ekspor-impor Anda dengan tim M2B.', 'Consult your export-import logistics needs with the M2B team.', '向 M2B 团队咨询您的进出口物流需求。', 'استشر فريق M2B بشأن احتياجاتك من الخدمات اللوجستية للاستيراد والتصدير.')">Konsultasikan kebutuhan logistik ekspor-impor Anda dengan tim M2B.</p>
    <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('Halo M2B, saya mau konsultasi gratis', 'Hello M2B, I would like a free consultation', '您好M2B，我想进行免费咨询。', 'مرحباً M2B، أرغب في استشارة مجانية'))" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:16px" x-text="$store.lang.t('💬 Konsultasi Gratis via WhatsApp', '💬 Free Consultation via WhatsApp', '💬 免费微信/WhatsApp咨询', '💬 استشارة مجانية عبر الواتساب')">💬 Konsultasi Gratis via WhatsApp</a>
  </div>
</section>
@endsection
