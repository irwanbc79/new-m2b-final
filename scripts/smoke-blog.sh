#!/usr/bin/env bash
#
# Smoke test READ-ONLY untuk blog m2b.co.id (dan domain lain di app yang sama).
#
# Semua permintaan hanya GET — tidak ada login, POST, atau perubahan data, jadi
# aman dijalankan kapan pun, termasuk langsung ke production setelah deploy.
#
# Pemakaian:
#   bash scripts/smoke-blog.sh                      # default https://m2b.co.id
#   bash scripts/smoke-blog.sh https://dira.co.id   # domain lain, app yang sama
#
# Cakupan: pemeriksaan kartu (`data-search=`), /blog/feed, dan invariant gambar
# dikalibrasi untuk layout blog m2b.co.id (Post + <x-post-card>). Domain yang
# memakai layout blog lain — mis. dira.co.id yang punya sitemapindex & tanpa RSS
# /blog/feed — bisa FAIL di bagian itu tanpa berarti ada regresi. Pakai script ini
# untuk domain yang memakai modul blog ini.
#
# Exit code = jumlah pemeriksaan yang GAGAL (0 = semua lolos), sehingga bisa
# dipakai sebagai gerbang: `bash scripts/smoke-blog.sh || echo 'rollback!'`.
#
# Cakupan:
#   1. /blog/ + /blog/?page=2 + /blog/?category=Ekspor  → 200 & kartu ter-render
#   2. Header HTML blog                                → s-maxage ada, tanpa Set-Cookie
#   3. /blog/feed                                      → RSS valid & ada item
#   4. Halaman artikel (item RSS pertama)              → 200, og:image == gambar hero,
#      JSON-LD ada. Ini invariant Post::imageUrl(): satu berkas = satu URL di semua
#      tempat (dulu og:image absolut vs kartu/hero relatif → srcset tak sinkron).
#   5. /sitemap.xml & /ads.txt                         → 200 (isi sitemap valid)
#   6. SEO head (kalibrasi layout blog m2b.co.id): head memuat ikon/manifest/
#      theme-color, /favicon.ico > 1 KB (dibaca dengan cache-buster karena hCDN
#      bisa menyimpan respons 0 byte yang lama; URL polosnya hanya WARN),
#      kanonikal /blog/ ber-trailing-slash, robots ?search= = noindex,
#      thumbnail kartu <img> (bukan background-image), <loc>/blog/</loc> ada &
#      <loc>/blog</loc> tidak ada, robots.txt tidak menunjuk sitemap yang
#      di-redirect, 1 <h1> + meta description ≤155 di artikel, www root &
#      www /blog/* → 301. Gerbang ini hijau sejak audit SEO 22 Okt 2026 live.
#
set -uo pipefail

BASE="${1:-https://m2b.co.id}"
BASE="${BASE%/}"
TMP="$(mktemp -d)"
trap 'rm -rf "$TMP"' EXIT

PASSED=0
FAIL=0

judul() { printf '\n\033[1m%s\033[0m\n' "$1"; }
ok()    { PASSED=$((PASSED + 1)); printf '\033[32m  PASS\033[0m %s\n' "$1"; }
bad()   { FAIL=$((FAIL + 1));     printf '\033[31m  FAIL\033[0m %s\n' "$1"; }
warn()  { printf '\033[33m  WARN\033[0m %s\n' "$1"; }

# Ikuti redirect (Hostinger mengalihkan /blog → /blog/) dan simpan body ke file.
# Mencetak status code HTTP terakhir.
fetch() { curl -sL --max-time 25 -o "$2" -w '%{http_code}' "$BASE$1"; }
hitung() { grep -oF -- "$2" "$1" | wc -l | tr -d ' '; }
hitung_re() { grep -oE -- "$2" "$1" | wc -l | tr -d ' '; }

judul "1. Halaman daftar artikel"
code="$(fetch '/blog/' "$TMP/blog.html")"
[ "$code" = "200" ] && ok "/blog/ → 200" || bad "/blog/ → HTTP $code"

kartu="$(hitung "$TMP/blog.html" 'data-search=')"
[ "$kartu" -ge 8 ] && ok "kartu artikel ter-render: $kartu" || bad "kartu artikel cuma $kartu (harap ≥ 8)"
[ "$(hitung "$TMP/blog.html" 'Sorotan')" -ge 1 ] && ok "kartu sorotan (★ Sorotan) ada" || bad "kartu sorotan tidak ditemukan"

code="$(fetch '/blog/?page=2' "$TMP/page2.html")"
kartu2="$(hitung "$TMP/page2.html" 'data-search=')"
[ "$code" = "200" ] && [ "$kartu2" -ge 1 ] && ok "/blog/?page=2 → 200, kartu: $kartu2" \
  || bad "/blog/?page=2 → HTTP $code, kartu: $kartu2"

code="$(fetch '/blog/?category=Ekspor' "$TMP/kat.html")"
[ "$code" = "200" ] && [ "$(hitung "$TMP/kat.html" 'data-search=')" -ge 1 ] \
  && ok "/blog/?category=Ekspor → 200 & terfilter" || bad "/blog/?category=Ekspor → HTTP $code"

judul "2. Header cache (hCDN)"
curl -sL --max-time 25 -D "$TMP/blog.head" -o /dev/null "$BASE/blog/" >/dev/null
grep -qi 's-maxage' "$TMP/blog.head" && ok "Cache-Control memuat s-maxage (CDN boleh cache)" \
  || bad "Cache-Control tanpa s-maxage — PublicPageCache tidak jalan?"
grep -qi '^set-cookie' "$TMP/blog.head" && bad "ada Set-Cookie → hCDN cenderung BYPASS cache" \
  || ok "tanpa Set-Cookie"

judul "3. RSS feed"
code="$(fetch '/blog/feed' "$TMP/feed.xml")"
item="$(hitung "$TMP/feed.xml" '<item>')"
[ "$code" = "200" ] && [ "$item" -ge 10 ] && ok "/blog/feed → 200, $item item" \
  || bad "/blog/feed → HTTP $code, item: $item (harap ≥ 10)"
grep -qi '<rss' "$TMP/feed.xml" && ok "struktur RSS ada" || bad "struktur <rss> tidak ditemukan"

judul "4. Halaman artikel + invariant gambar"
url="$(grep -oE '<link>[^<]*/blog/[^<]*</link>' "$TMP/feed.xml" | head -1 | sed -E 's#</?link>##g')"
if [ -z "$url" ]; then
  bad "tidak bisa ambil URL artikel dari RSS"
else
  path="${url#"$BASE"}"
  code="$(fetch "$path" "$TMP/post.html")"
  [ "$code" = "200" ] && ok "artikel uji: $path → 200" || bad "$path → HTTP $code"

  og="$(grep -oE '<meta property="og:image" content="[^"]+"' "$TMP/post.html" | head -1 | sed -E 's/.*content="([^"]+)"$/\1/')"
  case "$og" in
    http*) ok "og:image absolut: ${og:0:80}" ;;
    '')    bad "og:image tidak ada di halaman artikel" ;;
    *)     bad "og:image tidak absolut: $og" ;;
  esac

  if [ -n "$og" ]; then
    # og:image harus muncul lagi di HTML sebagai gambar yang ditampilkan
    # (<img src> atau background-image:url). Dulu URL-nya BEDA bentuk
    # (/storage/x.jpg vs https://host/storage/x.jpg) sehingga gambar sosial
    # dan gambar halaman bisa menunjuk berkas yang sama dengan URL tak sinkron.
    n="$(hitung "$TMP/post.html" "$og")"
    if [ "$n" -ge 2 ]; then
      ok "og:image dipakai juga oleh gambar hero (URL identik, $n kemunculan)"
    else
      # Coba bentuk yang entity HTML-nya sudah di-decode (&amp; → &).
      og_plain="$(printf '%s' "$og" | sed 's/&amp;/\&/g')"
      n="$(hitung "$TMP/post.html" "$og_plain")"
      [ "$n" -ge 2 ] && ok "og:image dipakai juga oleh gambar hero (URL identik, $n kemunculan)" \
        || bad "og:image tidak dipakai oleh gambar hero — resolver gambar terbelah lagi?"
    fi
  fi

  [ "$(hitung "$TMP/post.html" 'application/ld+json')" -ge 1 ] && ok "JSON-LD ada" || bad "JSON-LD tidak ada"
  # Tipe schema artikel yang dipakai template: "Article" (lihat show.blade.php).
  n="$(hitung_re "$TMP/post.html" '"@type": ?"(Article|BlogPosting|NewsArticle)"')"
  [ "$n" -ge 1 ] && ok "schema artikel (Article/BlogPosting) ada" || bad "schema artikel tidak ada di JSON-LD"
  [ "$(hitung "$TMP/post.html" 'BreadcrumbList')" -ge 1 ] && ok "schema BreadcrumbList ada" || bad "schema BreadcrumbList tidak ada"
fi

judul "5. Sitemap & ads.txt"
code="$(fetch '/sitemap.xml' "$TMP/sitemap.xml")"
# Laravel bisa menyajikan <urlset> langsung atau <sitemapindex> yang menunjuk
# sitemap lain (mis. sitemap_static.xml) — dua-duanya sah.
if [ "$code" = "200" ] && grep -qE '<(urlset|sitemapindex)' "$TMP/sitemap.xml"; then
  ok "/sitemap.xml → 200 & urlset/sitemapindex ada"
else
  bad "/sitemap.xml → HTTP $code (urlset/sitemapindex tidak ditemukan)"
fi

code="$(fetch '/ads.txt' "$TMP/ads.txt")"
size="$(wc -c < "$TMP/ads.txt" | tr -d ' ')"
[ "$code" = "200" ] && [ "$size" -gt 10 ] && ok "/ads.txt → 200 ($size byte)" || bad "/ads.txt → HTTP $code, $size byte"

judul "6. SEO head, ikon situs, kanonikal (kalibrasi layout blog m2b.co.id)"
# Bagian ini memeriksa perbaikan audit SEO 22 Okt 2026. Domain yang tidak
# memakai modul blog ini (mis. sitemapindex ala dira.co.id) bisa FAIL di sini
# tanpa berarti ada regresi.
code="$(fetch '/' "$TMP/home.html")"
head_hilang=""
for pola in 'rel="icon"' 'apple-touch-icon' 'rel="manifest"' 'name="theme-color"'; do
  grep -qF -- "$pola" "$TMP/home.html" || head_hilang="$head_hilang $pola"
done
[ "$code" = "200" ] && [ -z "$head_hilang" ] && ok "home → 200, head memuat ikon/manifest/theme-color" \
  || bad "home → HTTP $code; pola yang hilang:$head_hilang"

# favicon.ico sempat dijawab 200 tapi 0 byte → Google tanpa ikon di SERP.
# hCDN bisa menyimpan respons lama itu (cache-control max-age 7 hari) di URL
# polos /favicon.ico, jadi gate ini memakai cache-buster untuk memeriksa berkas
# yang benar-benar disajikan origin. URL polos diperiksa terpisah sebagai
# peringatan (bukan kegagalan) karena ia sembuh sendiri setelah TTL habis.
code="$(curl -sL --max-time 25 -o "$TMP/favicon.ico" -w '%{http_code}' "$BASE/favicon.ico?cb=$RANDOM")"
size="$(wc -c < "$TMP/favicon.ico" | tr -d ' ')"
[ "$code" = "200" ] && [ "$size" -gt 1024 ] && ok "/favicon.ico → 200 ($size byte)" \
  || bad "/favicon.ico → HTTP $code, $size byte (harus > 1 KB)"

code="$(curl -sL --max-time 25 -o "$TMP/favicon-polos.ico" -w '%{http_code}' "$BASE/favicon.ico")"
size="$(wc -c < "$TMP/favicon-polos.ico" | tr -d ' ')"
if [ "$code" = "200" ] && [ "$size" -gt 1024 ]; then
  ok "URL polos /favicon.ico → 200 ($size byte)"
else
  warn "URL polos /favicon.ico → HTTP $code, $size byte (entri hCDN lama, self-heal ≤ 7 hari; purge CDN di hPanel untuk mempercepat)"
fi

kanon="$(grep -oE '<link rel="canonical" href="[^"]+"' "$TMP/blog.html" | head -1 | sed -E 's/.*href="([^"]+)".*/\1/')"
[ "$kanon" = "$BASE/blog/" ] && ok "kanonikal /blog/: $kanon" \
  || bad "kanonikal /blog/ = '$kanon' (harus $BASE/blog/ — /blog di-redirect 301 ke /blog/)"

grep -qF '<meta name="robots" content="index, follow">' "$TMP/blog.html" \
  && ok "robots halaman blog: index, follow" || bad "robots halaman blog bukan index, follow"

code="$(fetch '/blog/?search=bea' "$TMP/search.html")"
grep -qF '<meta name="robots" content="noindex, follow">' "$TMP/search.html" \
  && ok "robots halaman ?search=: noindex, follow" \
  || bad "halaman hasil pencarian masih index,follow (HTTP $code)"

thumb="$(hitung "$TMP/blog.html" '<img src=')"
[ "$thumb" -ge 5 ] && ok "thumbnail kartu berupa <img>: $thumb" || bad "thumbnail kartu <img> cuma $thumb"
[ "$(hitung "$TMP/blog.html" 'background-image:url(')" -eq 0 ] \
  && ok "tidak ada thumbnail background-image (tak terindeks Google Images)" \
  || bad "masih ada thumbnail background-image di /blog/"

[ "$(hitung "$TMP/sitemap.xml" "<loc>$BASE/blog/</loc>")" -ge 1 ] \
  && ok "sitemap memuat $BASE/blog/ (bentuk ber-trailing-slash)" \
  || bad "sitemap tidak memuat $BASE/blog/"
[ "$(hitung "$TMP/sitemap.xml" "<loc>$BASE/blog</loc>")" -eq 0 ] \
  && ok "sitemap tidak memuat URL /blog yang di-redirect" \
  || bad "sitemap masih memuat <loc>$BASE/blog</loc> (URL itu 301 → /blog/)"

code="$(fetch '/robots.txt' "$TMP/robots.txt")"
if [ "$code" = "200" ] && ! grep -q '/blog/sitemap.xml' "$TMP/robots.txt"; then
  ok "/robots.txt → 200 & tidak menunjuk sitemap yang di-redirect"
else
  bad "/robots.txt → HTTP $code & masih memuat /blog/sitemap.xml (URL itu 301 → /sitemap.xml)"
fi

if [ -f "$TMP/post.html" ]; then
  h1="$(hitung "$TMP/post.html" '<h1')"
  [ "$h1" -eq 1 ] && ok "artikel punya tepat 1 <h1>" || bad "jumlah <h1> di halaman artikel: $h1 (harus 1)"

  # wc -m menghitung karakter (bukan byte) supaya elipsis "…" tidak dihitung 3.
  desc="$(grep -oE '<meta name="description" content="[^"]*"' "$TMP/post.html" | head -1 | sed -E 's/.*content="([^"]*)"/\1/')"
  desc_len="$(printf '%s' "$desc" | wc -m | tr -d ' ')"
  [ "$desc_len" -le 155 ] && ok "meta description artikel $desc_len karakter (≤155)" \
    || bad "meta description artikel $desc_len karakter (Google memangkas di ±155)"
fi

if [ "$BASE" = "https://m2b.co.id" ]; then
  www="$(curl -s -o /dev/null -w '%{http_code}' --max-time 25 https://www.m2b.co.id/)"
  [ "$www" = "301" ] && ok "https://www.m2b.co.id/ → 301 ke non-www" \
    || bad "https://www.m2b.co.id/ → HTTP $www (harus 301, dulu 200 = duplikat host)"

  # Path /blog/* ditangani public_html/blog/.htaccess (per-dir terdalam di
  # LiteSpeed), jadi aturan www di .htaccess doc root TIDAK berlaku di sana —
  # dulu https://www.m2b.co.id/blog/ menjawab 200 = seluruh arsip blog punya
  # duplikat host. Slug artikel diambil dari $path (item RSS pertama) supaya
  # tidak ada slug hard-code yang bisa basi.
  www_blog="$(curl -s -o /dev/null -w '%{http_code}' --max-time 25 https://www.m2b.co.id/blog/)"
  www_artikel=""
  if [ -n "${path:-}" ]; then
    www_artikel="$(curl -s -o /dev/null -w '%{http_code}' --max-time 25 "https://www.m2b.co.id$path")"
  fi
  [ "$www_blog" = "301" ] && [ "$www_artikel" = "301" ] \
    && ok "www /blog/ & www $path → 301 ke non-www" \
    || bad "www /blog/=$www_blog, www ${path:-<tak ada>}=$www_artikel (harus 301)"
fi

printf '\n\033[1mHasil: %d lolos, %d gagal\033[0m (base: %s)\n' "$PASSED" "$FAIL" "$BASE"
exit "$FAIL"
