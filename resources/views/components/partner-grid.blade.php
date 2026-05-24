<section class="py-10 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <p class="text-center text-xs font-semibold tracking-widest text-gray-400 uppercase mb-8">
            Telah Terintegrasi &amp; Dipercaya Oleh
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-5 lg:grid-cols-10 gap-6 items-center justify-items-center">
            @foreach([
                ['images/partners/ditjen_bea_cukai.jpg', 'Dirjen Bea & Cukai RI'],
                ['images/partners/pelindo.png',          'PT Pelabuhan Indonesia'],
                ['images/partners/lnsw.jpeg',            'LNSW'],
                ['images/partners/alfi.png',             'ALFI'],
                ['images/partners/kadin.jpeg',           'KADIN'],
                ['images/partners/oss.png',              'OSS RI'],
                ['images/partners/dira_baraka.jpg',      'PT. Dira Baraka Mulia'],
                ['images/partners/mentarisamuderaabadi.jpeg', 'PT. Mentari Samudera Abadi'],
                ['images/partners/supcon.jpeg',          'PT. Supcon Technology'],
                ['images/partners/graha_segara.jpg',     'PT. Graha Segara'],
            ] as [$img, $alt])
            <div class="group flex justify-center w-full">
                <img src="{{ asset($img) }}"
                     alt="{{ $alt }}"
                     class="h-10 sm:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
                     loading="lazy">
            </div>
            @endforeach
        </div>

    </div>
</section>
