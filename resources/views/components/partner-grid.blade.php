<section class="py-10 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <p class="text-center text-xs font-semibold tracking-widest text-gray-400 uppercase mb-8">
            Telah Terintegrasi &amp; Dipercaya Oleh
        </p>

        <div class="grid grid-cols-2 gap-6 md:grid-cols-4 lg:grid-cols-8 items-center justify-items-center">
            @foreach([
                ['🏛️', 'Dirjen Bea & Cukai RI', 'partners/beacukai.png'],
                ['⚓',  'PT Pelabuhan Indonesia', 'partners/pelindo.png'],
                ['🌐', 'LNSW', 'partners/insw.png'],
                ['🤝', 'ALFI', 'partners/alfi.png'],
                ['🏢', 'PT. Dira Baraka Mulia', null],
                ['🌊', 'PT. Mentari Samudera Abadi', null],
                ['⚙️', 'PT. Supcon Technology', null],
                ['🏭', 'PT. Graha Segara', null],
            ] as [$icon, $name, $img])
            <div class="group flex flex-col items-center justify-center gap-1 w-full transition-all duration-300">
                @if($img && file_exists(public_path($img)))
                    <img src="{{ asset($img) }}" alt="{{ $name }}"
                         class="h-10 sm:h-12 object-contain opacity-60 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                @else
                    <div class="flex flex-col items-center gap-1 px-3 py-2 rounded-lg border border-gray-200 bg-gray-50 opacity-60 group-hover:opacity-100 group-hover:border-blue-900 group-hover:bg-white transition-all duration-300 w-full">
                        <span class="text-xl grayscale group-hover:grayscale-0 transition-all duration-300">{{ $icon }}</span>
                        <span class="text-center text-[10px] font-bold text-gray-700 leading-tight">{{ $name }}</span>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
