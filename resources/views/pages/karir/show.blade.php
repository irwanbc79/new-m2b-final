@extends('layouts.app')
@section('title', $career->title . ' — Karir M2B')
@section('description', 'Bergabunglah sebagai ' . $career->title . ' di PT. Mora Multi Berkah. Lihat detail posisi dan cara melamar.')

@section('content')
<div style="background:#0f0f14;padding:64px 40px 56px">
  <div style="max-width:1200px;margin:0 auto">
    <a href="{{ route('karir.index') }}" style="display:inline-flex;align-items:center;gap:8px;color:#4a9eda;text-decoration:none;font-size:14px;margin-bottom:24px" x-text="$store.lang.t('← Kembali ke Karir', '← Back to Careers', '← 返回职业生涯', '← العودة إلى الوظائف')">← Kembali ke Karir</a>
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px">
      @if($career->department)
      @php
        $deptEn = [
          'Operasional' => 'Operations',
          'Keuangan' => 'Finance',
          'Pemasaran' => 'Marketing',
          'Dokumentasi' => 'Documentation',
        ][$career->department] ?? $career->department;

        $deptZh = [
          'Operasional' => '运营部',
          'Keuangan' => '财务部',
          'Pemasaran' => '市场部',
          'Dokumentasi' => '单证部',
        ][$career->department] ?? $deptEn;

        $deptAr = [
          'Operasional' => 'العمليات',
          'Keuangan' => 'المالية',
          'Pemasaran' => 'التسويق',
          'Dokumentasi' => 'التوثيق',
        ][$career->department] ?? $deptEn;
      @endphp
      <span style="padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('{{ $career->department }}', '{{ $deptEn }}', '{{ $deptZh }}', '{{ $deptAr }}')">{{ $career->department }}</span>
      @endif
      @php
        $typeEn = [
          'fulltime' => 'Full-time',
          'parttime' => 'Part-time',
          'internship' => 'Internship',
          'kontrak' => 'Contract',
        ][strtolower($career->type)] ?? $career->type;

        $typeZh = [
          'fulltime' => '全职',
          'parttime' => '兼职',
          'internship' => '实习',
          'kontrak' => '合同工',
        ][strtolower($career->type)] ?? $typeEn;

        $typeAr = [
          'fulltime' => 'دوام كامل',
          'parttime' => 'دوام جزئي',
          'internship' => 'تدريب عملي',
          'kontrak' => 'عقد',
        ][strtolower($career->type)] ?? $typeEn;

        $typeId = [
          'fulltime' => 'Penuh Waktu',
          'parttime' => 'Paruh Waktu',
          'internship' => 'Magang',
          'kontrak' => 'Kontrak',
        ][strtolower($career->type)] ?? ucfirst($career->type);
      @endphp
      <span style="padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('{{ $typeId }}', '{{ $typeEn }}', '{{ $typeZh }}', '{{ $typeAr }}')">{{ $typeId }}</span>
    </div>
    <h1 style="font-family:Syne;font-weight:800;font-size:44px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1">{{ $career->title }}</h1>
    <div style="display:flex;gap:20px;font-size:14px;color:rgba(255,255,255,0.55);flex-wrap:wrap">
      <span>📍 {{ $career->location }}</span>
      @if($career->deadline)
      <span>⏰ <span x-text="$store.lang.t('Batas Pendaftaran:', 'Deadline:', '截止日期:', 'الموعد النهائي:')">Deadline:</span> {{ $career->deadline->format('d M Y') }}</span>
      @endif
    </div>
  </div>
</div>

<section style="padding:60px 40px;background:#f7f5f0">
  <div style="max-width:960px;margin:0 auto;display:grid;grid-template-columns:1.6fr 1fr;gap:40px;align-items:start">
    <div>
      @if($career->description)
      <div style="background:#fff;border-radius:16px;padding:36px;border:1px solid #e5e2dc;margin-bottom:24px">
        <h2 style="font-family:Syne;font-weight:800;font-size:20px;color:#0f0f14;margin-bottom:16px" x-text="$store.lang.t('📋 Deskripsi Pekerjaan', '📋 Job Description', '📋 职位描述', '📋 الوصف الوظيفي')">📋 Deskripsi Pekerjaan</h2>
        <div style="font-size:15px;color:#555;line-height:1.85">{!! nl2br(e($career->description)) !!}</div>
      </div>
      @endif
      @if($career->requirements)
      <div style="background:#fff;border-radius:16px;padding:36px;border:1px solid #e5e2dc;margin-bottom:24px">
        <h2 style="font-family:Syne;font-weight:800;font-size:20px;color:#0f0f14;margin-bottom:16px" x-text="$store.lang.t('✅ Persyaratan', '✅ Requirements', '✅ 任职要求', '✅ المتطلبات')">✅ Persyaratan</h2>
        <div style="font-size:15px;color:#555;line-height:1.85">{!! nl2br(e($career->requirements)) !!}</div>
      </div>
      @endif
      @if($career->benefits)
      <div style="background:#fff;border-radius:16px;padding:36px;border:1px solid #e5e2dc">
        <h2 style="font-family:Syne;font-weight:800;font-size:20px;color:#0f0f14;margin-bottom:16px" x-text="$store.lang.t('🎁 Benefit & Fasilitas', '🎁 Benefits & Perks', '🎁 福利待遇', '🎁 المزايا والفوائد')">🎁 Benefit & Fasilitas</h2>
        <div style="font-size:15px;color:#555;line-height:1.85">{!! nl2br(e($career->benefits)) !!}</div>
      </div>
      @endif
    </div>
    <div style="position:sticky;top:100px">
      <div style="background:#fff;border-radius:16px;padding:28px;border:1px solid #e5e2dc;box-shadow:0 8px 32px rgba(0,0,0,0.06)">
        <h3 style="font-family:Syne;font-weight:800;font-size:18px;color:#0f0f14;margin-bottom:20px" x-text="$store.lang.t('Lamar Posisi Ini', 'Apply for This Position', '申请该职位', 'تقدم لهذه الوظيفة')">Lamar Posisi Ini</h3>
        <div style="margin-bottom:20px;padding:16px;background:#f7f5f0;border-radius:10px">
          <div style="font-size:11px;color:#999;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px" x-text="$store.lang.t('Posisi', 'Position', '申请职位', 'الوظيفة')">Posisi</div>
          <div style="font-weight:700;font-size:15px;color:#0f0f14">{{ $career->title }}</div>
          @if($career->department)<div style="font-size:13px;color:#666;margin-top:4px" x-text="$store.lang.t('{{ $career->department }}', '{{ $deptEn }}', '{{ $deptZh }}', '{{ $deptAr }}')">{{ $career->department }}</div>@endif
          <div style="font-size:13px;color:#666;margin-top:4px">📍 {{ $career->location }} · <span x-text="$store.lang.t('{{ $typeId }}', '{{ $typeEn }}', '{{ $typeZh }}', '{{ $typeAr }}')">{{ $typeId }}</span></div>
        </div>
        <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('Halo M2B, saya ingin melamar posisi ' + '{{ $career->title }}' + ' yang saya lihat di website.', 'Hello M2B, I would like to apply for the position of ' + '{{ $career->title }}' + ' that I saw on the website.', '您好M2B，我想申请在官网上看到的' + '{{ $career->title }}' + '职位。', 'مرحباً M2B، أرغب في التقدم لشغل وظيفة ' + '{{ $career->title }}' + ' التي رأيتها على الموقع الإلكتروني.'))" target="_blank"
          style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:14px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:15px;margin-bottom:12px"
          x-text="$store.lang.t('💬 Lamar via WhatsApp', '💬 Apply via WhatsApp', '💬 通过微信/WhatsApp申请', '💬 التقدم عبر الواتساب')">
          💬 Lamar via WhatsApp
        </a>
        <a href="mailto:hr@m2b.co.id?subject=Lamaran%20-%20{{ urlencode($career->title) }}"
          style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:13px;border-radius:10px;border:1.5px solid #d0cdc8;color:#0f0f14;text-decoration:none;font-weight:600;font-size:14px;background:#fff"
          x-text="$store.lang.t('📧 Email hr@m2b.co.id', '📧 Email hr@m2b.co.id', '📧 发送邮件至 hr@m2b.co.id', '📧 البريد hr@m2b.co.id')">
          📧 Email hr@m2b.co.id
        </a>
        @if($career->deadline)
        <div style="margin-top:16px;text-align:center;font-size:12px;color:#999;padding:10px;background:#fff3cd;border-radius:8px">
          <span x-text="$store.lang.t('⏰ Batas pendaftaran:', '⏰ Application Deadline:', '⏰ 申请截止日期:', '⏰ الموعد النهائي لتقديم الطلبات:')">⏰ Batas pendaftaran:</span> <strong>{{ $career->deadline->format('d M Y') }}</strong>
        </div>
        @endif
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid #f0ede8">
          <div style="font-size:12px;color:#999;text-align:center" x-text="$store.lang.t('Pertanyaan? Hubungi kami', 'Questions? Contact us', '如有疑问？请联系我们', 'هل لديك أسئلة؟ اتصل بنا')">Pertanyaan? Hubungi kami</div>
          <div style="text-align:center;margin-top:6px;font-size:13px;font-weight:600;color:#1e3a5f">📱 +62 812-6302-7818</div>
        </div>
      </div>
    </div>
  </div>
</section>

<section style="padding:60px 40px;background:#0f0f14">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <h2 style="font-family:Syne;font-weight:800;font-size:32px;color:#fff;letter-spacing:-0.8px;margin-bottom:16px" x-text="$store.lang.t('Kenapa Bergabung M2B?', 'Why Join M2B?', '为什么加入 M2B？', 'لماذا تنضم إلى M2B؟')">Kenapa Bergabung M2B?</h2>
    <p style="color:rgba(255,255,255,0.5);margin-bottom:32px" x-text="$store.lang.t('Kami bukan hanya tempat kerja — kami komunitas logistik yang terus bertumbuh.', 'We are not just a workplace — we are a growing logistics community.', '我们不仅仅是一个工作场所——我们是一个不断成长的物流共同体。', 'نحن لسنا مجرد مكان عمل — نحن مجتمع لوجستي متنامٍ.')">Kami bukan hanya tempat kerja — kami komunitas logistik yang terus bertumbuh.</p>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:32px">
      @php
      $reasons = [
        ['🚀', ['id'=>'Berkembang Bersama','en'=>'Grow Together','zh'=>'共同成长','ar'=>'النمو معاً'], ['id'=>'Pelatihan & mentorship dari para ahli logistik berpengalaman','en'=>'Training & mentorship from experienced logistics experts','zh'=>'来自资深物流专家的培训与指导','ar'=>'التدريب والتوجيه من خبراء اللوجستيات ذوي الخبرة']],
        ['🤝', ['id'=>'Lingkungan Suportif','en'=>'Supportive Environment','zh'=>'相互支持的工作环境','ar'=>'بيئة داعمة'], ['id'=>'Tim kolaboratif yang saling mendukung dalam setiap shipment','en'=>'Collaborative team supporting each other in every shipment','zh'=>'在每一次货运中互相支持的协作团队','ar'=>'فريق تعاوني يدعم بعضه البعض في كل شحنة']],
        ['💎', ['id'=>'Kompensasi Kompetitif','en'=>'Competitive Compensation','zh'=>'具有竞争力的薪酬福利','ar'=>'تعويضات تنافسية'], ['id'=>'Gaji + tunjangan + bonus kinerja yang adil dan transparan','en'=>'Fair and transparent salary + allowances + performance bonuses','zh'=>'公平透明的薪资 + 津贴 + 绩效奖金','ar'=>'راتب + بدلات + مكافآت أداء عادلة وشفافة']]
      ];
      @endphp
      @foreach($reasons as $reason)
      <div style="padding:20px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;text-align:center">
        <div style="font-size:28px;margin-bottom:10px">{{ $reason[0] }}</div>
        <div style="font-family:Syne;font-weight:700;font-size:13px;color:#fff;margin-bottom:6px" x-text="$store.lang.t('{{ $reason[1]['id'] }}', '{{ $reason[1]['en'] }}', '{{ $reason[1]['zh'] }}', '{{ $reason[1]['ar'] }}')">{{ $reason[1]['id'] }}</div>
        <div style="font-size:12px;color:rgba(255,255,255,0.45);line-height:1.6" x-text="$store.lang.t('{{ $reason[2]['id'] }}', '{{ $reason[2]['en'] }}', '{{ $reason[2]['zh'] }}', '{{ $reason[2]['ar'] }}')">{{ $reason[2]['id'] }}</div>
      </div>
      @endforeach
    </div>
    <a href="{{ route('karir.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.25);color:#fff;text-decoration:none;font-weight:600;font-size:14px" x-text="$store.lang.t('← Lihat Semua Lowongan', '← View All Openings', '← 查看所有空缺职位', '← عرض جميع الوظائف الشاغرة')">← Lihat Semua Lowongan</a>
  </div>
</section>
@endsection
