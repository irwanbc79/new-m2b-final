@props(['type' => null, 'format' => 'auto'])
@php
$publisherId = config('services.adsense.publisher_id');
$slotId = $type
    ? (config("services.adsense.slot_{$type}") ?: config('services.adsense.slot_id'))
    : config('services.adsense.slot_id');
$publisherIsValid = is_string($publisherId)
    && preg_match('/^ca-pub-\d{16}$/', $publisherId) === 1;
$slotIsValid = is_string($slotId)
    && preg_match('/^\d{10}$/', $slotId) === 1
$minHeight = match($type) {
    'in_content' => '250px',
    'post_read'  => '280px',
    'in_feed'    => '250px',
    default      => '250px',
};
$isLazy = in_array($type, ['in_content', 'post_read', 'in_feed']);
@endphp

@if($publisherIsValid && $slotIsValid)
<div class="ad-container ad-block-{{ $type ?? 'default' }}" style="margin:32px auto;text-align:center;min-height:{{ $minHeight }};contain:layout style;width:100%;max-width:100%" aria-label="Advertisement">
    <div style="font-size:10px;color:#9ca3af;text-transform:uppercase;letter-spacing:1px;font-family:monospace;text-align:center;margin-bottom:6px">Iklan</div>
    <ins class="adsbygoogle"
         style="display:block;min-height:{{ $minHeight }}"
         data-ad-client="{{ $publisherId }}"
         data-ad-slot="{{ $slotId }}"
         data-ad-format="{{ $format }}"
         data-full-width-responsive="true"
         @if($isLazy) data-ad-lazy="true" @endif></ins>
    @if(!$isLazy)
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    @endif
</div>
@elseif(config('app.env') !== 'production')
<div style="margin:32px 0;padding:18px;background:repeating-linear-gradient(45deg,#f0ede8,#f0ede8 10px,#fff 10px,#fff 20px);border:1px dashed #ccc;border-radius:8px;text-align:center">
    <span style="font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:1px">AdSense [{{ $type ?? 'default' }}] — konfigurasi slot tidak valid</span>
</div>
@endif
