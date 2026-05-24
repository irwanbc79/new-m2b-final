<section class="py-10 bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <p class="text-center text-xs font-semibold tracking-widest text-gray-400 uppercase mb-8">
            Telah Terintegrasi &amp; Dipercaya Oleh
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 items-center justify-items-center">
            @foreach([
                ['images/partners/ditjen_bea_cukai.jpg', 'Dirjen Bea & Cukai RI'],
                ['images/partners/pelindo.png',          'PT Pelabuhan Indonesia'],
                ['images/partners/lnsw.jpeg',            'LNSW'],
                ['images/partners/alfi.png',             'ALFI'],
                ['images/partners/kadin.jpeg',           'KADIN'],
                ['images/partners/oss.png',              'OSS RI'],
                ['images/partners/mentarisamuderaabadi.jpeg', 'PT. Mentari Samudera Abadi'],
                ['images/partners/graha_segara.jpg',     'PT. Graha Segara'],
            ] as [$img, $alt])
            <div class="group flex justify-center w-full">
                <img src="{{ asset($img) }}"
                     alt="{{ $alt }}"
                     class="h-12 w-auto object-contain opacity-55 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
                     loading="lazy">
            </div>
            @endforeach
        </div>

    </div>
</section>
