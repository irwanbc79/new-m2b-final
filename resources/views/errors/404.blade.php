<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 — Halaman Tidak Ditemukan | M2B</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{background:#f7f5f0;font-family:'DM Sans',sans-serif;color:#0f0f14;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:40px 20px}
.wrap{text-align:center;max-width:520px}
.code{font-family:'Syne',sans-serif;font-size:120px;font-weight:800;color:#1e3a5f;line-height:1;letter-spacing:-4px;opacity:.12;user-select:none}
.icon{font-size:52px;margin:-24px 0 20px}
h1{font-family:'Syne',sans-serif;font-size:26px;font-weight:700;color:#1e3a5f;margin-bottom:12px}
p{font-size:15px;color:#6b6b72;line-height:1.7;margin-bottom:32px}
.links{display:flex;gap:12px;flex-wrap:wrap;justify-content:center}
a.btn-primary{background:#1e3a5f;color:#fff;text-decoration:none;padding:11px 28px;border-radius:8px;font-size:14px;font-weight:500;transition:background .2s}
a.btn-primary:hover{background:#162d4a}
a.btn-ghost{background:transparent;color:#1e3a5f;text-decoration:none;padding:11px 24px;border-radius:8px;font-size:14px;font-weight:500;border:1.5px solid #d0cdc7;transition:border-color .2s,color .2s}
a.btn-ghost:hover{border-color:#1e3a5f}
.divider{width:40px;height:3px;background:#e8a020;border-radius:2px;margin:28px auto}
.nav-links{display:flex;gap:24px;justify-content:center;flex-wrap:wrap;margin-top:8px}
.nav-links a{font-size:13px;color:#888;text-decoration:none;transition:color .2s}
.nav-links a:hover{color:#1e3a5f}
</style>
</head>
<body>
<div class="wrap">
    <div class="code">404</div>
    <div class="icon">📦</div>
    <h1>Halaman Tidak Ditemukan</h1>
    <p>Halaman yang Anda cari mungkin sudah dipindahkan, dihapus, atau URL-nya tidak tepat.<br>Coba kembali ke halaman utama atau pilih menu di bawah.</p>
    <div class="links">
        <a href="{{ url('/') }}" class="btn-primary">← Kembali ke Beranda</a>
        <a href="{{ url('/blog') }}" class="btn-ghost">Baca Artikel</a>
    </div>
    <div class="divider"></div>
    <div class="nav-links">
        <a href="{{ url('/tentang-kami') }}">Tentang Kami</a>
        <a href="{{ url('/karir') }}">Karir</a>
        <a href="{{ url('/blog') }}">Blog</a>
        <a href="https://wa.me/6281263027818" target="_blank" rel="noopener">Hubungi Kami</a>
    </div>
</div>
</body>
</html>
