<section class="py-10 bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <p class="text-center text-xs font-semibold tracking-widest text-gray-400 uppercase mb-8">
            Telah Terintegrasi &amp; Dipercaya Oleh
        </p>

        @php
        $partners = [
            // Baris 1: Pemerintah & Regulator
            ['images/partners/ditjen_bea_cukai.jpg',      'Dirjen Bea & Cukai RI'],
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
            ['images/partners/indopla_1.png',              'Indoplas'],
            ['images/partners/mentarisamuderaabadi.jpeg',  'PT. Mentari Samudera Abadi'],
            ['images/partners/graha_segara.jpg',           'PT. Graha Segara'],
        ];
        @endphp

        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:28px 24px;align-items:center">
            @foreach($partners as [$img, $alt])
            <div style="display:flex;justify-content:center;align-items:center;width:120px">
                <img src="{{ asset($img) }}"
                     alt="{{ $alt }}"
                     style="max-height:44px;width:auto;max-width:120px;filter:grayscale(1);opacity:0.55;transition:all 0.3s"
                     onmouseover="this.style.filter='grayscale(0)';this.style.opacity='1'"
                     onmouseout="this.style.filter='grayscale(1)';this.style.opacity='0.55'"
                     loading="lazy">
            </div>
            @endforeach
        </div>

    </div>
</section>
