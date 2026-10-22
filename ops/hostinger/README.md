# Konfigurasi doc root m2b.co.id (Hostinger)

Berkas di folder ini adalah **salinan byte-exact** dari berkas di server, karena
ketiganya hidup di luar repo Laravel (`new-m2b/public/`) sehingga tanpa salinan
ini perubahannya mudah hilang saat migrasi/reset hosting.

| Berkas di repo                  | Lokasi di server                                            |
| ------------------------------- | ----------------------------------------------------------- |
| `public_html.htaccess`          | `~/domains/m2b.co.id/public_html/.htaccess`                 |
| `blog.htaccess`                 | `~/domains/m2b.co.id/public_html/blog/.htaccess`            |
| `robots.txt`                    | `~/domains/m2b.co.id/public_html/robots.txt`                |

Yang **dilacak repo** hanya `public/.htaccess`, `public/robots.txt`, dan
`public/ads.txt` (folder `public/` Laravel). Doc root adalah `public_html/`
(kode Laravel ada di `public_html/new-m2b/`) sehingga berkas-berkas di tabel
atas tidak ikut ter-deploy oleh `git pull` dan harus disalin manual.

## Alur request yang perlu dipahami

1. `public_html/.htaccess` menangani seluruh situs.
2. `public_html/blog/.htaccess` adalah `.htaccess` per-direktori **paling dalam**,
   jadi ia menimpa aturan doc root untuk semua path `/blog/*`. Setiap aturan baru
   di doc root (mis. 301 www → non-www) **wajib diduplikasi di sini**, kalau tidak
   `https://www.m2b.co.id/blog/...` akan tetap menjawab 200.
3. `/robots.txt` dan `/sitemap.xml`: `robots.txt` adalah berkas statis di doc root
   (dilayani langsung oleh `RewriteCond %{REQUEST_FILENAME} -f`), sedangkan
   `sitemap.xml` dihasilkan Laravel (`x-hcdn-cache-status: DYNAMIC`).

## Aturan yang tidak boleh diubah tanpa alasan

- **301 www → non-www** memakai target `%{REQUEST_URI}` (path asli), **bukan** `$1`.
  Dengan `$1`, mod_rewrite dipanggil ulang untuk internal rewrite dan path relatif
  menjadi kosong sehingga redirect jatuh ke `/index.php`. Pakai juga `[.]`
  (bukan `\.`) di dalam karakter kelas regex supaya tidak bentrok dengan escaping shell.
- **TTL pendek untuk robots.txt & ads.txt** (`max-age=300`) karena TTL default hCDN
  sangat panjang: salinan lama robots.txt masih tersaji berjam-jam setelah berkas
  aslinya diperbarui (nyata terjadi pada audit 22 Okt 2026 — GSC membaca sitemap lama).
- **robots.txt hanya boleh punya satu baris `Sitemap:`** yaitu
  `https://m2b.co.id/sitemap.xml`. `scripts/smoke-blog.sh` gagal bila baris sitemap
  blog lama muncul lagi (URL itu sekarang dijawab 301).

## Cara memulihkan / menyamakan

```bash
# bandingkan salinan repo dengan server (harus tanpa keluaran)
ssh m2b 'cat ~/domains/m2b.co.id/public_html/.htaccess' | diff - ops/hostinger/public_html.htaccess

# pulihkan dari repo ke server (backup dulu!)
ssh m2b 'cp ~/domains/m2b.co.id/public_html/.htaccess ~/deploy-backups/htaccess-$(date +%Y%m%d-%H%M%S).bak'
scp ops/hostinger/public_html.htaccess m2b:domains/m2b.co.id/public_html/.htaccess

# verifikasi setelah perubahan .htaccess (jangan pernah skip: sintaks salah = 500 se-situs)
for u in https://m2b.co.id/ https://m2b.co.id/blog/ https://www.m2b.co.id/blog/; do
  printf '%s → %s\n' "$u" "$(curl -s -o /dev/null -w '%{http_code}' "$u")"
done
cd /Users/irwanbece/new-m2b-final && bash scripts/smoke-blog.sh https://m2b.co.id
```

Backup .htaccess lama ada di `~/deploy-backups/` di server, dan snapshot
working tree produksi sebelum deploy SEO ada di branch `prod-live-2026-10-22`.

## Cache hCDN (jangan bingung dengan bug)

hCDN menyimpan URL apa adanya, termasuk `/robots.txt` dan `/favicon.ico`:

- Perubahan berkas **tidak langsung terlihat**; cek dengan cache-buster
  (`curl "https://m2b.co.id/robots.txt?cb=$RANDOM"`) untuk membedakan
  "berkas asal salah" dari "salinan edge basi".
- `public/favicon.ico` pernah 0 byte; pautan di layout kini memakai
  `?v=20261022` sehingga Google/browser mengambil kunci cache baru. URL polos
  `/favicon.ico` baru bersih setelah entri lama kedaluwarsa (`max-age=604800`).
- Percepat dengan **hPanel → Advanced → Clear cache** (purge hCDN); tidak ada
  cara purge dari SSH.
