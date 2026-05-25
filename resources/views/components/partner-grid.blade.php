<section class="py-10 bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <p class="text-center text-xs font-semibold tracking-widest text-gray-400 uppercase mb-8">
            Telah Terintegrasi &amp; Dipercaya Oleh
        </p>

        <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:28px 20px;align-items:center;justify-items:center">
            @foreach([
                {{-- Baris 1: Pemerintah & Regulator --}}
                ['images/partners/ditjen_bea_cukai.jpg', 'Dirjen Bea & Cukai RI'],
                ['images/partners/ceisa.png',            'CEISA'],
                ['images/partners/karantina.png',        'Badan Karantina Indonesia'],
                ['images/partners/kemendag.png',         'Kementerian Perdagangan RI'],
                ['images/partners/lnsw.jpeg',            'LNSW'],
                ['images/partners/oss.png',              'OSS RI'],
                {{-- Baris 2: Pelabuhan, Asosiasi & Klien --}}
                ['images/partners/pelindo.png',          'PT Pelabuhan Indonesia'],
                ['images/partners/bnct.png',             'BNCT'],
                ['images/partners/alfi.png',             'ALFI'],
                ['images/partners/kadin.jpeg',           'KADIN'],
                ['images/partners/mentarisamuderaabadi.jpeg', 'PT. Mentari Samudera Abadi'],
                ['images/partners/graha_segara.jpg',     'PT. Graha Segara'],
            ] as [$img, $alt])
            <div class="group flex justify-center items-center w-full">
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
