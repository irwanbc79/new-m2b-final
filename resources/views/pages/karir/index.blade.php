@extends('layouts.app')
@section('title', 'Karir di M2B — Bergabung dengan Tim Logistik Terbaik')
@section('description', 'Bergabunglah dengan M2B dan jadilah bagian dari tim freight forwarder & customs broker terpercaya di Indonesia.')

@section('content')
<div style="background:#0f0f14;padding:64px 40px 56px">
  <div style="max-width:1200px;margin:0 auto">
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase;margin-bottom:16px" x-text="$store.lang.t('Karir', 'Careers', '职业生涯', 'الوظائف')">Karir</span>
    <h1 style="font-family:Syne;font-weight:800;font-size:48px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1">
      <span x-text="$store.lang.t('Bergabung dengan', 'Join the', '加入', 'انضم إلى')">Bergabung dengan</span><br>
      <span style="color:#4a9eda" x-text="$store.lang.t('Tim M2B', 'M2B Team', 'M2B 团队', 'فريق M2B')">Tim M2B</span>
    </h1>
    <p style="color:rgba(255,255,255,0.6);font-size:17px;max-width:540px" x-text="$store.lang.t('Jadilah bagian dari tim freight forwarder & customs broker terpercaya. Kami mencari orang-orang yang bersemangat dan berdedikasi.', 'Be part of a trusted freight forwarder & customs broker team. We are looking for passionate and dedicated people.', '成为值得信赖的货运代理与报关行团队的一员。我们正在寻找充满激情与奉献精神的伙伴。', 'كن جزءاً من فريق وكيل شحن ومخلص جمركي موثوق. نحن نبحث عن أشخاص شغوفين ومخلصين.')">Jadilah bagian dari tim freight forwarder & customs broker terpercaya. Kami mencari orang-orang yang bersemangat dan berdedikasi.</p>
  </div>
</div>

<section style="padding:60px 40px;background:#f7f5f0">
  <div style="max-width:1000px;margin:0 auto">
    @forelse($careers as $career)
    <div style="background:#fff;border:1px solid #e5e2dc;border-radius:14px;padding:28px 32px;margin-bottom:20px;transition:all .2s" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,0.08)';this.style.borderColor='#1e3a5f'" onmouseout="this.style.boxShadow='none';this.style.borderColor='#e5e2dc'">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px">
        <div>
          <h2 style="font-family:Syne;font-weight:800;font-size:22px;color:#0f0f14;margin-bottom:8px">{{ $career->title }}</h2>
          <div style="display:flex;gap:12px;flex-wrap:wrap;font-size:13px;color:#666">
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
            <span>🏢 <span x-text="$store.lang.t('{{ $career->department }}', '{{ $deptEn }}', '{{ $deptZh }}', '{{ $deptAr }}')">{{ $career->department }}</span></span>
            @endif
            <span>📍 {{ $career->location }}</span>
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
            <span style="background:rgba(30,58,95,0.1);color:#1e3a5f;padding:2px 10px;border-radius:20px;font-weight:600" x-text="$store.lang.t('{{ $typeId }}', '{{ $typeEn }}', '{{ $typeZh }}', '{{ $typeAr }}')">{{ $typeId }}</span>
          </div>
        </div>
        <a href="{{ route('karir.show', $career->id) }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:13px;white-space:nowrap;flex-shrink:0" x-text="$store.lang.t('Lamar Sekarang →', 'Apply Now →', '立即申请 →', 'تقدم الآن ←')">Lamar Sekarang →</a>
      </div>
      @if($career->description)
      <p style="font-size:14px;color:#666;line-height:1.7;margin-top:16px;padding-top:16px;border-top:1px solid #f0ede8">{{ Str::limit(strip_tags($career->description), 200) }}</p>
      @endif
      @if($career->deadline)
      <div style="margin-top:12px;font-size:12px;color:#999">
        <span x-text="$store.lang.t('⏰ Batas pendaftaran:', '⏰ Application Deadline:', '⏰ 申请截止日期:', '⏰ الموعد النهائي لتقديم الطلبات:')">⏰ Batas pendaftaran:</span> {{ $career->deadline->format('d M Y') }}
      </div>
      @endif
    </div>
    @empty
    <div style="text-align:center;padding:80px 40px;background:#fff;border-radius:14px;border:1px solid #e5e2dc">
      <div style="font-size:48px;margin-bottom:16px">💼</div>
      <h3 style="font-family:Syne;font-weight:700;font-size:20px;margin-bottom:8px" x-text="$store.lang.t('Belum ada lowongan terbuka', 'No open vacancies yet', '暂无可申请的空缺职位', 'لا توجد وظائف شاغرة حالياً')">Belum ada lowongan terbuka</h3>
      <p style="color:#666;margin-bottom:24px" x-text="$store.lang.t('Tapi kami selalu mencari talenta terbaik. Kirim CV kamu ke:', 'But we are always looking for the best talent. Send your CV to:', '但我们始终在寻找优秀的人才。请发送您的简历至：', 'لكننا نبحث دائماً عن أفضل المواهب. أرسل سيرتك الذاتية إلى:')">Tapi kami selalu mencari talenta terbaik. Kirim CV kamu ke:</p>
      <a href="mailto:hr@m2b.co.id" style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:14px">📧 hr@m2b.co.id</a>
    </div>
    @endforelse
  </div>
</section>
@endsection
