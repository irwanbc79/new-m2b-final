@props(['type' => null, 'format' => 'auto'])
@php
$publisherId = config('services.adsense.publisher_id');
$slotId = $type
    ? (config("services.adsense.slot_{$type}") ?: config('services.adsense.slot_id'))
    : config('services.adsense.slot_id');
@endphp

@if($publisherId && $publisherId !== 'ca-pub-XXXXXXXXXXXXXXXX')
<div style="margin:32px 0;text-align:center;overflow:hidden" aria-label="Advertisement">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="{{ $publisherId }}"
         data-ad-slot="{{ $slotId }}"
         data-ad-format="{{ $format }}"
         data-full-width-responsive="true"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</div>
@elseif(config('app.env') !== 'production')
<div style="margin:32px 0;padding:18px;background:repeating-linear-gradient(45deg,#f0ede8,#f0ede8 10px,#fff 10px,#fff 20px);border:1px dashed #ccc;border-radius:8px;text-align:center">
    <span style="font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:1px">AdSense [{{ $type ?? 'default' }}]</span>
</div>
@endif
