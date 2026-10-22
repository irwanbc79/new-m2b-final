#!/usr/bin/env python3
"""Generator favicon M2B (satu kali jalan, bukan bagian dari runtime Laravel).

Sebelum ini `public/favicon.ico` ada tapi 0 byte dan TIDAK ADA satu pun
`<link rel="icon">` di layout, jadi Google tidak punya ikon untuk ditampilkan di
hasil pencarian (audit SEO m2b.co.id, 2026-10-22).

Desain disamakan dengan identitas situs: kotak membulat dengan gradasi
navy #1e3a5f → #0b1120, monogram "M2B" putih (Arial Bold, tersedia di macOS),
dan garis aksen biru #4a9eda.

Berkas yang dihasilkan (semua di public/):
  favicon.ico            16/32/48 px, multi-size (browser tab, Google)
  favicon-96x96.png      Google Search + Android
  favicon-192x192.png    manifest PWA
  favicon-512x512.png    manifest PWA / splash
  apple-touch-icon.png   180 px, full-bleed tanpa transparansi (iOS memask
                         sendiri sudutnya; ikon transparan jadi kotak hitam)

`favicon.svg` ditulis manual di public/ karena hanya berisi bentuk geometris +
<text>, tidak butuh fontTools.

Butuh: Pillow (`python3 -m pip install pillow`).
Jalan: `python3 scripts/make-favicons.py` dari root repo.
"""
from pathlib import Path

from PIL import Image, ImageDraw, ImageFont

BRAND_NAVY = (30, 58, 95)    # #1e3a5f
BRAND_DARK = (11, 17, 32)    # #0b1120
BRAND_ACCENT = (74, 158, 218)  # #4a9eda
FONT_BOLD = "/System/Library/Fonts/Supplemental/Arial Bold.ttf"
TEXT = "M2B"
SUPERSAMPLE = 4
PUBLIC = Path(__file__).resolve().parent.parent / "public"


def gradient(size: int) -> Image.Image:
    """Gradasi vertikal navy → dark, ukuran size × size."""
    column = Image.new("RGB", (1, size))
    for y in range(size):
        t = y / max(1, size - 1)
        column.putpixel(
            (0, y),
            tuple(round(BRAND_NAVY[i] + (BRAND_DARK[i] - BRAND_NAVY[i]) * t) for i in range(3)),
        )
    return column.resize((size, size))


def fitted_font(canvas: int, target_width: float) -> ImageFont.FreeTypeFont:
    """Arial Bold paling besar yang lebarnya masuk target_width × canvas."""
    size = int(canvas * 0.5)
    while size > 8:
        font = ImageFont.truetype(FONT_BOLD, size)
        left, _, right, _ = ImageDraw.Draw(Image.new("L", (1, 1))).textbbox((0, 0), TEXT, font=font)
        if (right - left) <= canvas * target_width:
            return font
        size -= 4
    return ImageFont.truetype(FONT_BOLD, 8)


def icon(size: int, bleed: bool = False) -> Image.Image:
    """Ikon ukuran akhir `size` px. bleed=True → tanpa sudut membulat & opak."""
    canvas = size * SUPERSAMPLE
    base = Image.new("RGBA", (canvas, canvas), (0, 0, 0, 0) if not bleed else BRAND_DARK + (255,))

    layer = gradient(canvas).convert("RGBA")
    mask = Image.new("L", (canvas, canvas), 255)
    if not bleed:
        ImageDraw.Draw(mask).rounded_rectangle(
            [0, 0, canvas - 1, canvas - 1], radius=int(canvas * 0.22), fill=255
        )
    base.paste(layer, (0, 0), mask)

    draw = ImageDraw.Draw(base)
    font = fitted_font(canvas, 0.62)
    draw.text((canvas / 2, canvas * 0.45), TEXT, font=font, fill=(255, 255, 255, 255), anchor="mm")

    if not bleed:
        bar_w, bar_h = canvas * 0.34, canvas * 0.05
        bar_x, bar_y = (canvas - bar_w) / 2, canvas * 0.70
        draw.rounded_rectangle(
            [bar_x, bar_y, bar_x + bar_w, bar_y + bar_h], radius=bar_h / 2, fill=BRAND_ACCENT + (255,)
        )

    return base.resize((size, size), Image.LANCZOS)


FAVICON_SVG = """<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" role="img" aria-label="M2B">
  <!-- Ikon tab browser: kotak membulat, gradasi navy, monogram M2B, aksen biru.
       Versi SVG dipakai browser modern; PNG/ICO di public/ untuk Google & iOS. -->
  <defs>
    <linearGradient id="m2b" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0" stop-color="#1e3a5f"/>
      <stop offset="1" stop-color="#0b1120"/>
    </linearGradient>
  </defs>
  <rect width="64" height="64" rx="14" fill="url(#m2b)"/>
  <text x="32" y="32" text-anchor="middle" dominant-baseline="central"
        font-family="Arial, Helvetica, sans-serif" font-size="27" font-weight="700"
        letter-spacing="-0.5" fill="#ffffff">M2B</text>
  <rect x="21" y="45" width="22" height="3.2" rx="1.6" fill="#4a9eda"/>
</svg>
"""


def main() -> None:
    PUBLIC.mkdir(parents=True, exist_ok=True)

    icon(48).save(PUBLIC / "favicon.ico", sizes=[(16, 16), (32, 32), (48, 48)])
    for size in (96, 192, 512):
        icon(size).save(PUBLIC / f"favicon-{size}x{size}.png", optimize=True)
    icon(180, bleed=True).save(PUBLIC / "apple-touch-icon.png", optimize=True)
    (PUBLIC / "favicon.svg").write_text(FAVICON_SVG, encoding="utf-8")

    for name in ("favicon.ico", "favicon-96x96.png", "favicon-192x192.png",
                 "favicon-512x512.png", "apple-touch-icon.png", "favicon.svg"):
        print(f"{name}: {(PUBLIC / name).stat().st_size} byte")


if __name__ == "__main__":
    main()
