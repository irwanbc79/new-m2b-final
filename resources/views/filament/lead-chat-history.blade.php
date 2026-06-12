@php $history = $getState(); @endphp

@if(empty($history))
    <p class="text-sm text-gray-400 italic">(tidak ada riwayat percakapan — lead masuk langsung via form)</p>
@else
    <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2">
        @foreach($history as $msg)
            @if($msg['role'] === 'user')
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-500 mb-1">Pengunjung</span>
                    <div class="bg-blue-50 border border-blue-100 text-blue-900 text-sm rounded-2xl rounded-tr-sm px-4 py-2 max-w-[85%] leading-relaxed">
                        {{ $msg['content'] }}
                    </div>
                </div>
            @else
                <div class="flex flex-col items-start">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-teal-600 mb-1">🤖 MORA</span>
                    <div class="bg-teal-50 border border-teal-100 text-teal-900 text-sm rounded-2xl rounded-tl-sm px-4 py-2 max-w-[85%] leading-relaxed">
                        {{ $msg['content'] }}
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <p class="text-xs text-gray-400 mt-3">{{ count($history) }} pesan dalam percakapan ini</p>
@endif
