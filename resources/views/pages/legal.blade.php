@extends('layouts.app')
@section('title', $title . ' — M2B')

@section('content')
<div style="background:#0f0f14;padding:48px 40px 40px">
  <div style="max-width:800px;margin:0 auto">
    <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:8px;color:#4a9eda;text-decoration:none;font-size:14px;margin-bottom:20px">← Kembali ke Beranda</a>
    <h1 style="font-family:Syne;font-weight:800;font-size:36px;color:#fff;letter-spacing:-1px;line-height:1.2">{{ $title }}</h1>
    <p style="color:rgba(255,255,255,0.45);font-size:13px;margin-top:10px">PT. Mora Multi Berkah · Terakhir diperbarui: {{ date('F Y') }}</p>
  </div>
</div>

<section style="padding:60px 40px;background:#f7f5f0">
  <div style="max-width:800px;margin:0 auto">
    <div style="background:#fff;border-radius:16px;padding:48px;border:1px solid #e5e2dc;font-size:15px;color:#444;line-height:1.85">
      @if($slug === 'privacy-policy')
        <h2 style="font-family:Syne;font-weight:800;font-size:22px;color:#0f0f14;margin-bottom:16px">Kebijakan Privasi</h2>
        <p style="margin-bottom:24px">Selamat datang di <strong>new.m2b.co.id</strong>. Kami menghargai privasi Anda dan berkomitmen melindungi informasi pribadi yang Anda berikan.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Informasi yang Kami Kumpulkan</h3>
        <p style="margin-bottom:20px">Kami mengumpulkan informasi seperti nama, email, nomor telepon, dan data penggunaan untuk meningkatkan kualitas layanan dan berkomunikasi mengenai kebutuhan logistik Anda.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Penggunaan Informasi</h3>
        <p style="margin-bottom:20px">Informasi Anda digunakan untuk menyediakan layanan freight forwarding & customs brokerage, berkomunikasi mengenai shipment dan dokumen, serta meningkatkan pengalaman pengguna di website ini.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Keamanan Data</h3>
        <p style="margin-bottom:20px">Kami menerapkan langkah-langkah keamanan teknis untuk melindungi data Anda dari akses yang tidak sah. Data hanya dibagikan kepada mitra logistik (shipping line, Bea Cukai) yang diperlukan untuk menyelesaikan layanan.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Hak Pengguna</h3>
        <p style="margin-bottom:20px">Anda berhak mengakses, mengoreksi, atau meminta penghapusan data pribadi sesuai UU PDP No. 27 Tahun 2022.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Perubahan Kebijakan</h3>
        <p>Kami dapat memperbarui kebijakan ini sewaktu-waktu. Perubahan material akan diumumkan di halaman ini.</p>

      @elseif($slug === 'disclaimer')
        <h2 style="font-family:Syne;font-weight:800;font-size:22px;color:#0f0f14;margin-bottom:16px">Penafian (Disclaimer)</h2>
        <p style="margin-bottom:24px">Konten pada situs <strong>new.m2b.co.id</strong> disediakan hanya untuk tujuan informasi umum tentang layanan PT. Mora Multi Berkah.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Keterbatasan Informasi</h3>
        <p style="margin-bottom:20px">Meskipun kami berusaha menjaga keakuratan konten, kami tidak memberikan jaminan mengenai kelengkapan atau ketepatannya. Regulasi bea cukai dan tarif logistik dapat berubah sewaktu-waktu.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Penggunaan Informasi</h3>
        <p style="margin-bottom:20px">Anda menggunakan informasi dari situs ini atas risiko Anda sendiri. Untuk keputusan bisnis signifikan terkait ekspor-impor, selalu konsultasikan langsung dengan tim M2B.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Tautan Eksternal</h3>
        <p style="margin-bottom:20px">Situs ini mungkin mengandung tautan ke situs eksternal (portal Bea Cukai, LNSW, dll.) yang tidak kami kendalikan. Kami tidak bertanggung jawab atas isi situs tersebut.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Perubahan Konten</h3>
        <p>Kami berhak mengubah konten situs ini kapan saja tanpa pemberitahuan sebelumnya.</p>

      @elseif($slug === 'terms')
        <h2 style="font-family:Syne;font-weight:800;font-size:22px;color:#0f0f14;margin-bottom:16px">Ketentuan Layanan</h2>
        <p style="margin-bottom:24px">Dengan mengakses dan menggunakan website serta layanan PT. Mora Multi Berkah, Anda setuju mematuhi syarat dan ketentuan berikut.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Penggunaan Layanan</h3>
        <p style="margin-bottom:20px">Anda setuju menggunakan layanan sesuai hukum yang berlaku di Indonesia. Layanan ekspor-impor tunduk pada peraturan Dirjen Bea dan Cukai RI.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Kerahasiaan Informasi Bisnis</h3>
        <p style="margin-bottom:20px">Informasi yang Anda bagikan (dokumen, HS Code, nilai transaksi) akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan pengurusan shipment Anda.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Tanggung Jawab Klien</h3>
        <p style="margin-bottom:20px">Klien bertanggung jawab atas keakuratan informasi dan dokumen yang diserahkan kepada M2B. Ketidakakuratan dapat menyebabkan penundaan di Bea Cukai di luar kendali M2B.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Konten dan Hak Cipta</h3>
        <p style="margin-bottom:20px">Seluruh konten di website ini (teks, logo, desain) adalah milik PT. Mora Multi Berkah dan dilindungi oleh hak cipta.</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Pembatasan Tanggung Jawab</h3>
        <p style="margin-bottom:20px">M2B tidak bertanggung jawab atas kerugian yang timbul dari keterlambatan yang disebabkan oleh pihak ketiga (shipping line, maskapai, otoritas pelabuhan, atau perubahan regulasi mendadak).</p>
        <h3 style="font-family:Syne;font-weight:700;font-size:16px;color:#1e3a5f;margin-bottom:8px">Perubahan Ketentuan</h3>
        <p>Kami berhak mengubah syarat ini sewaktu-waktu. Perubahan akan diumumkan di halaman ini.</p>
      @endif

      <div style="margin-top:36px;padding:20px 24px;background:#f7f5f0;border-radius:10px">
        <div style="font-size:13px;font-weight:600;color:#1e3a5f;margin-bottom:8px">Ada pertanyaan? Hubungi kami:</div>
        <div style="font-size:14px;color:#555">📧 <a href="mailto:sales@m2b.co.id" style="color:#1e3a5f">sales@m2b.co.id</a> &nbsp;·&nbsp; 📱 +62 812-6302-7818 &nbsp;·&nbsp; 📍 Medan, Sumatera Utara</div>
      </div>
    </div>
  </div>
</section>
@endsection
