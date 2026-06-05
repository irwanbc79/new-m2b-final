@extends('layouts.app')
@section('title', 'Tim M2B — Para Ahli Logistik Ekspor-Impor')
@section('description', 'Kenali tim profesional M2B yang siap membantu kebutuhan freight forwarding dan customs brokerage Anda.')

@section('content')
<div style="background:#0f0f14;padding:64px 40px 56px">
  <div style="max-width:1200px;margin:0 auto">
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase;margin-bottom:16px" x-text="$store.lang.t('Tim Kami', 'Our Team', '我们的团队', 'فريقنا')">Tim Kami</span>
    <h1 style="font-family:Syne;font-weight:800;font-size:48px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1">
      <span x-text="$store.lang.t('Para Ahli', 'The Experts', '行业专家', 'الخبراء')">Para Ahli</span><br>
      <span style="color:#4a9eda" x-text="$store.lang.t('di Balik M2B', 'Behind M2B', '在 M2B 背后', 'خلف M2B')">di Balik M2B</span>
    </h1>
    <p style="color:rgba(255,255,255,0.6);font-size:17px;max-width:540px" x-text="$store.lang.t('Tim berpengalaman yang berdedikasi untuk memastikan setiap shipment berjalan lancar.', 'An experienced team dedicated to ensuring every shipment runs smoothly.', '富有经验的专业团队致力于确保每一批货运顺利通关。', 'فريق ذو خبرة مخصص لضمان سير كل شحنة بسلاسة.')">Tim berpengalaman yang berdedikasi untuk memastikan setiap shipment berjalan lancar.</p>
  </div>
</div>

<section style="padding:80px 40px;background:#f7f5f0">
  <div style="max-width:1200px;margin:0 auto">
    @if($members->count() > 0)
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px">
      @foreach($members as $member)
      <div style="background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e5e2dc;text-align:center;transition:all .2s" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='none';this.style.boxShadow='none'">
        @if($member->photo)
        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" style="width:100%;height:240px;object-fit:cover">
        @else
        <div style="width:100%;height:240px;background:linear-gradient(135deg,#1e3a5f,#2a5298);display:flex;align-items:center;justify-content:center;font-size:64px;color:rgba(255,255,255,0.3);font-family:Syne;font-weight:800">{{ substr($member->name,0,1) }}</div>
        @endif
        <div style="padding:20px 18px">
          <div style="font-family:Syne;font-weight:800;font-size:16px;color:#0f0f14;margin-bottom:4px">{{ $member->name }}</div>
          <div style="font-size:13px;color:#1e3a5f;font-weight:600;margin-bottom:8px">
            @php
              $posEn = [
                'Direktur' => 'Director',
                'Komisaris' => 'Commissioner',
                'Manager Operasional' => 'Operational Manager',
                'Staf PPJK' => 'Customs Broker Staff',
                'Customer Service' => 'Customer Service',
              ][$member->position] ?? $member->position;

              $posZh = [
                'Direktur' => '总经理/董事长',
                'Komisaris' => '监事会主席',
                'Manager Operasional' => '运营经理',
                'Staf PPJK' => '报关员',
                'Customer Service' => '客服专员',
              ][$member->position] ?? $posEn;

              $posAr = [
                'Direktur' => 'المدير',
                'Komisaris' => 'المفوض',
                'Manager Operasional' => 'مدير العمليات',
                'Staf PPJK' => 'موظف التخليص الجمركي',
                'Customer Service' => 'خدمة العملاء',
              ][$member->position] ?? $posEn;
            @endphp
            <span x-text="$store.lang.t('{{ $member->position }}', '{{ $posEn }}', '{{ $posZh }}', '{{ $posAr }}')">{{ $member->position }}</span>
          </div>
          @if($member->division)
          <div style="font-size:11px;color:#999;margin-bottom:10px">
            @php
              $divEn = [
                'Operasional' => 'Operations',
                'Keuangan' => 'Finance',
                'Pemasaran' => 'Marketing',
                'Dokumentasi' => 'Documentation',
              ][$member->division] ?? $member->division;

              $divZh = [
                'Operasional' => '运营部',
                'Keuangan' => '财务部',
                'Pemasaran' => '市场部',
                'Dokumentasi' => '单证部',
              ][$member->division] ?? $divEn;

              $divAr = [
                'Operasional' => 'العمليات',
                'Keuangan' => 'المالية',
                'Pemasaran' => 'التسويق',
                'Dokumentasi' => 'التوثيق',
              ][$member->division] ?? $divEn;
            @endphp
            <span x-text="$store.lang.t('{{ $member->division }}', '{{ $divEn }}', '{{ $divZh }}', '{{ $divAr }}')">{{ $member->division }}</span>
          </div>
          @endif
          @if($member->bio)<p style="font-size:12px;color:#777;line-height:1.6;margin-bottom:12px">{{ Str::limit($member->bio, 100) }}</p>@endif
          @if($member->linkedin)
          <a href="{{ $member->linkedin }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;color:#1e3a5f;text-decoration:none;font-weight:600">💼 LinkedIn</a>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div style="text-align:center;padding:80px 40px;background:#fff;border-radius:14px;border:1px solid #e5e2dc">
      <div style="font-size:48px;margin-bottom:16px">👥</div>
      <h3 style="font-family:Syne;font-weight:700;font-size:20px;margin-bottom:8px" x-text="$store.lang.t('Tim kami hadir untuk Anda', 'Our team is here for you', '我们的团队为您服务', 'فريقنا هنا من أجلك')">Tim kami hadir untuk Anda</h3>
      <p style="color:#666" x-text="$store.lang.t('Hubungi kami untuk mengenal tim M2B lebih lanjut.', 'Contact us to get to know the M2B team better.', '联系我们以深入了解 M2B 团队。', 'اتصل بنا للتعرف على فريق M2B بشكل أفضل.')">Hubungi kami untuk mengenal tim M2B lebih lanjut.</p>
    </div>
    @endif
  </div>
</section>

<section style="padding:60px 40px;background:#0f0f14">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <h2 style="font-family:Syne;font-weight:800;font-size:32px;color:#fff;letter-spacing:-0.8px;margin-bottom:16px" x-text="$store.lang.t('Ingin Bergabung dengan Tim?', 'Want to Join the Team?', '想加入我们的团队吗？', 'هل ترغب في الانضمام إلى الفريق؟')">Ingin Bergabung dengan Tim?</h2>
    <p style="color:rgba(255,255,255,0.5);margin-bottom:28px" x-text="$store.lang.t('Kami selalu mencari talenta terbaik untuk berkembang bersama M2B.', 'We are always looking for the best talent to grow with M2B.', '我们一直在寻找优秀的人才与 M2B 共同成长。', 'نحن نبحث دائماً عن أفضل المواهب للنمو مع M2B.')">Kami selalu mencari talenta terbaik untuk berkembang bersama M2B.</p>
    <a href="{{ route('karir.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:15px" x-text="$store.lang.t('Lihat Lowongan →', 'View Openings →', '查看空缺职位 →', 'عرض الوظائف الشاغرة ←')">Lihat Lowongan →</a>
  </div>
</section>
@endsection
