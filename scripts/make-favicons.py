#!/usr/bin/env python3
"""Generate proportional brand favicons from the approved symbol using Pillow."""
from pathlib import Path
from PIL import Image
PUBLIC = Path(__file__).resolve().parent.parent / "public"


def main() -> None:
    # Approved symbol, cropped without tagline. Contain preserves its aspect ratio.
    import base64
    from io import BytesIO
    from PIL import ImageOps

    PUBLIC.mkdir(parents=True, exist_ok=True)
    with Image.open(PUBLIC / 'images/favicon-symbol.png') as source:
        square = Image.new('RGBA', (512, 512), (0, 0, 0, 0))
        symbol = ImageOps.contain(source.convert('RGBA'), (480, 480), Image.Resampling.LANCZOS)
        square.alpha_composite(symbol, ((512 - symbol.width) // 2, (512 - symbol.height) // 2))
    square.save(PUBLIC / 'favicon.ico', sizes=[(16, 16), (32, 32), (48, 48), (64, 64), (128, 128), (256, 256)])
    for size in (96, 192, 512):
        square.resize((size, size), Image.Resampling.LANCZOS).save(PUBLIC / f"favicon-{size}x{size}.png", optimize=True)
    apple = Image.new('RGB', (512, 512), 'white')
    apple.paste(square, mask=square.getchannel('A'))
    apple.resize((180, 180), Image.Resampling.LANCZOS).save(PUBLIC / 'apple-touch-icon.png', optimize=True)
    buffer = BytesIO()
    square.save(buffer, format='PNG', optimize=True)
    encoded = base64.b64encode(buffer.getvalue()).decode('ascii')
    # Raster artwork embedded in SVG, not an artificial vector conversion.
    svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><image width="512" height="512" href="data:image/png;base64,' + encoded + '"/></svg>'
    (PUBLIC / 'favicon.svg').write_text(svg, encoding='utf-8')

    for name in ("favicon.ico", "favicon-96x96.png", "favicon-192x192.png",
                 "favicon-512x512.png", "apple-touch-icon.png", "favicon.svg"):
        print(f"{name}: {(PUBLIC / name).stat().st_size} byte")


if __name__ == "__main__":
    main()
