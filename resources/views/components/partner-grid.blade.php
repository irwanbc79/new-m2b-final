<section style="padding:48px 40px;background:#fff;border-bottom:1px solid #f0ede8">
    <div style="max-width:960px;margin:0 auto">

        <div style="text-align:center;margin-bottom:36px">
            <p style="font-size:11px;font-weight:700;letter-spacing:2.5px;color:#bbb;text-transform:uppercase;margin-bottom:10px">Ekosistem &amp; Mitra Strategis</p>
            <p style="font-size:14px;color:#999;line-height:1.6">Terintegrasi dengan regulasi, asosiasi, dan ekosistem logistik Indonesia</p>
        </div>

        @php
        $partners = [
            // Baris 1: Pemerintah & Regulator
            ['images/partners/logo_bc.jpeg',               'Dirjen Bea & Cukai RI'],
            ['images/partners/ceisa.png',                  'CEISA 4.0'],
            ['images/partners/karantina.png',              'Badan Karantina Indonesia'],
            ['images/partners/kemendag.png',               'Kementerian Perdagangan RI'],
            ['images/partners/lnsw.jpeg',                  'LNSW'],
            ['images/partners/oss.png',                    'OSS RI'],
            ['images/partners/bpom.jpg',                   'BPOM RI'],
            ['images/partners/e_ska.svg',                  'e-SKA Kemendag'],
            // Baris 2: Pelabuhan, Asosiasi & Mitra
            ['images/partners/pelindo.png',                'PT Pelabuhan Indonesia'],
            ['images/partners/bnct.png',                   'BNCT'],
            ['images/partners/alfi.png',                   'ALFI'],
            ['images/partners/kadin.jpeg',                 'KADIN'],
            ['images/partners/celebi.jpg',                 'Celebi Cargo'],
            ['images/partners/pertamina.png',              'Pertamina'],
            ['images/partners/indopla_1.png',              'Indoplas'],
            ['images/partners/mentarisamuderaabadi.jpeg',  'PT. Mentari Samudera Abadi'],
            ['images/partners/graha_segara.jpg',           'PT. Graha Segara'],
        ];
        @endphp

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:14px">
            @foreach($partners as [$img, $alt])
            <div style="height:80px;background:#fafaf8;border:1px solid #efefed;border-radius:10px;display:flex;align-items:center;justify-content:center;padding:14px 18px;transition:border-color .2s,background .2s;cursor:default"
                 onmouseover="this.style.borderColor='#c8c5bf';this.style.background='#fff'"
                 onmouseout="this.style.borderColor='#efefed';this.style.background='#fafaf8'">
                <img src="{{ asset($img) }}" alt="{{ $alt }}"
                     style="max-width:100%;max-height:44px;width:auto;height:auto;object-fit:contain;filter:grayscale(1);opacity:0.5;transition:all 0.3s"
                     onmouseover="this.style.filter='grayscale(0)';this.style.opacity='1'"
                     onmouseout="this.style.filter='grayscale(1)';this.style.opacity='0.5'"
                     onerror="this.parentElement.style.visibility='hidden'"
                     loading="lazy">
            </div>
            @endforeach
        </div>

    </div>
</section>
