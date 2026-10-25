# Audit lokal landing M2B — 25 Oktober 2026

## Pembaruan tindak lanjut

- Composer: 20 paket diperbarui secara terarah dalam batas major yang sudah digunakan,
  termasuk Laravel 12.70.1, Filament 3.3.57, Livewire 3.8.11. Audit ulang melaporkan
  nol advisory; hasil tersimpan pada composer-audit-after.json.
- npm: 12 paket diperbarui tanpa --force, termasuk Vite 7.3.7. Audit ulang melaporkan
  nol vulnerability; hasil tersimpan pada npm-audit-after.json.
- Script Composer otomatis sengaja dilewati untuk mencegah publish aset/vendor atau
  perubahan environment tanpa review. Deployment tetap memerlukan package discovery,
  sinkronisasi aset Filament, dan build sesuai prosedur server yang telah diuji.
- Bug false-success MORA diperbaiki: form hanya ditutup jika HTTP berhasil dan JSON
  success=true. Error HTTP, JSON rusak, atau jaringan mempertahankan form untuk retry.
- Validasi akhir: 77 test PHP / 320 assertion dan 6 test Node lulus; build Vite, syntax
  check JS, composer validate, platform requirements PHP lokal, dan diff check lulus.
  Test Node mengeksekusi fungsi submitLead dengan DOM/fetch stub, bukan browser visual.
- Backup tindak lanjut: /Users/irwanbece/backups/m2b-followup-20261025.
- Rotasi password server BELUM dilakukan. Pemeriksaan konfigurasi lokal hanya
  menunjukkan DB_PORTAL_USERNAME dan DB_PORTAL_PASSWORD kosong; nilai server dan
  aplikasi lain pemakai akun belum diketahui. Jangan deploy sebelum environment
  server terverifikasi dan rencana rotasi terkoordinasi tersedia.
- Tidak ada commit, push, SSH, deployment, maupun pengiriman email nyata.

Bagian di bawah merupakan catatan baseline awal; temuan dependency dan false-success
MORA yang disebut di bawah sudah ditangani oleh pembaruan lokal di atas.

Baseline: commit 78d2543, repository /Users/irwanbece/new-m2b-final.
Branch: fix/landing-public-input-hardening-20261025.
Backup sebelum perubahan: /Users/irwanbece/backups/m2b-audit-20261025-122512.
Tidak ada SSH, deployment, perubahan environment produksi, atau eksploitasi situs.
Kesamaan byte-for-byte dengan production belum diperiksa.

## Temuan yang diperbaiki secara lokal

1. **Tinggi — fallback kredensial portal dalam source.**
   /Users/irwanbece/new-m2b-final/config/database.php: konfigurasi portal.
   Fallback database/username/password dihapus, bukan nilai environment.
   Nilai lama tidak ditulis di laporan ini. Riwayat Git dan backup masih memuat
   nilai lama: rotasi kredensial serta pemeriksaan akses repo/backup wajib dilakukan
   pengelola server. Belum diverifikasi apakah kredensial lama masih aktif.
2. **Tinggi bersyarat — dokumen inquiry memakai disk default.**
   /Users/irwanbece/new-m2b-final/app/Http/Controllers/B2bInquiryController.php.
   Jika default public, dokumen bisnis bisa berada di storage publik.
   Upload dan attachment kini eksplisit memakai disk local private; validasi MIME,
   ekstensi, serta ukuran membatasi PDF/JPEG/PNG/WebP/GIF. Ini bukan antivirus.
3. **Sedang — kegagalan upload diabaikan dan file yatim.**
   Penyimpanan yang mengembalikan false/exception kini memberi 503 dan membersihkan
   file sebelumnya; kegagalan database membersihkan file. Cleanup best-effort.
4. **Bug — inquiry paid tanpa shipment_type/volume menghasilkan 500.**
   Validator mengizinkan null tetapi skema tidak. Kini disimpan sebagai string kosong;
   batas shipment_type disamakan dengan kolom 30 karakter. Migration lama tidak diubah.
5. **Sedang — MORA timeout melewati fallback.**
   /Users/irwanbece/new-m2b-final/app/Http/Controllers/MoraChatController.php.
   ConnectionException kini melanjutkan fallback; semua provider gagal menghasilkan 503.
   Payload image.data dibatasi 6.990.508 karakter (sekitar 5 MiB base64), bukan verifikasi
   isi gambar. Log kegagalan total tidak lagi menyimpan seluruh percakapan.
6. **Isolasi test.** /Users/irwanbece/new-m2b-final/tests/TestCase.php mengarahkan portal
   ke SQLite test dan memalsukan HTTP, sehingga test tidak bergantung layanan eksternal.

## Temuan terbuka / batas audit

- **Prioritas tinggi:** composer-audit.json melaporkan 40 advisory / 13 paket;
  npm-audit.json melaporkan 10 temuan (2 critical, 7 high, 1 low). Hasil mencakup dev
  dependencies. Belum dianalisis reachability seluruh advisory. Lockfile tidak diubah.
  Upgrade perlu branch terpisah, install bersih, regression test, dan QA admin.
- /Users/irwanbece/new-m2b-final/app/Models/User.php: canAccessPanel selalu true untuk
  user terautentikasi; bukan bypass login. Inventaris operator dan rencana RBAC diperlukan
  sebelum membatasi akses agar tidak terjadi lockout.
- /Users/irwanbece/new-m2b-final/app/Http/Controllers/PageController.php: foto portal
  dipilih berdasarkan status approved dan blacklist deskripsi; ini tidak menjamin foto
  bebas data pelanggan/EXIF. Perlu persetujuan publikasi spesifik, bukan perubahan portal
  sepihak. Halaman juga mengambil hingga 200 foto setiap request.
- /Users/irwanbece/new-m2b-final/public/js/mora.js: submit lead belum memeriksa HTTP
  response.ok sebelum menampilkan sukses. Perlu perbaikan dan test browser terpisah.
- /Users/irwanbece/new-m2b-final/routes/web.php: redirect WordPress ?p=ID di fallback
  tidak menangani root /?p=ID karena route home sudah cocok. Perlu regression test.
- MORA provider failure masih dapat mencatat body error provider; perlu redaksi lanjut.
- Rate limit bersama 30/menit tidak sama dengan kuota biaya global atau proteksi bot.
- Template home 2.194 baris dan layout 998 baris: kandidat ekstraksi komponen/script
  bertahap, bukan rewrite massal tanpa visual regression test.
- Belum ada browser visual/mobile QA, audit header live, uji email nyata, antivirus,
  pemeriksaan seluruh repository history, atau verifikasi permissions disk server.

## Validasi dan deployment gate

Baseline sebelum patch: 70 test / 282 assertion. Test regresi baru dijalankan sebelum
dan sesudah perbaikan. Build Vite lokal berhasil ke /tmp/m2b-audit-vite-build-20261025,
tanpa menimpa public/build. Node melaporkan deprecation warning; build tetap berhasil.

Sebelum deploy: rotasi kredensial, pastikan DB_PORTAL_* terisi aman, bandingkan source
production, selesaikan audit dependensi, uji browser serta email attachment, backup
server, dan persetujuan deployment. Tidak ada klaim bahwa situs sudah bebas celah.