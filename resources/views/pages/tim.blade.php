@extends('layouts.app')
@section('title', 'Tim M2B — Para Ahli Logistik Ekspor-Impor')
@section('description', 'Kenali tim profesional M2B yang siap membantu kebutuhan freight forwarding dan customs brokerage Anda.')

@section('content')
<div style="background:#0f0f14;padding:64px 40px 56px">
  <div style="max-width:1200px;margin:0 auto">
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase;margin-bottom:16px">Tim Kami</span>
    <h1 style="font-family:Syne;font-weight:800;font-size:48px;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;line-height:1.1">Para Ahli<br><span style="color:#4a9eda">di Balik M2B</span></h1>
    <p style="color:rgba(255,255,255,0.6);font-size:17px;max-width:540px">Tim berpengalaman yang berdedikasi untuk memastikan setiap shipment berjalan lancar.</p>
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
          <div style="font-size:13px;color:#1e3a5f;font-weight:600;margin-bottom:8px">{{ $member->position }}</div>
          @if($member->division)<div style="font-size:11px;color:#999;margin-bottom:10px">{{ $member->division }}</div>@endif
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
      <h3 style="font-family:Syne;font-weight:700;font-size:20px;margin-bottom:8px">Tim kami hadir untuk Anda</h3>
      <p style="color:#666">Hubungi kami untuk mengenal tim M2B lebih lanjut.</p>
    </div>
    @endif
  </div>
</section>

<section style="padding:60px 40px;background:#0f0f14">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <h2 style="font-family:Syne;font-weight:800;font-size:32px;color:#fff;letter-spacing:-0.8px;margin-bottom:16px">Ingin Bergabung dengan Tim?</h2>
    <p style="color:rgba(255,255,255,0.5);margin-bottom:28px">Kami selalu mencari talenta terbaik untuk berkembang bersama M2B.</p>
    <a href="{{ route('karir.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:15px">Lihat Lowongan →</a>
  </div>
</section>
@endsection
