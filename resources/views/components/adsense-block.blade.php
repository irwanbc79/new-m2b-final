@php
$publisherId = config('services.adsense.publisher_id');
$slotId = $slot ?? config('services.adsense.slot_id');
@endphp

@if($publisherId && $publisherId !== 'ca-pub-XXXXXXXXXXXXXXXX')
{{-- Live AdSense unit --}}
<div style="margin:28px 0;text-align:center;overflow:hidden" aria-label="Advertisement">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="{{ $publisherId }}"
         data-ad-slot="{{ $slotId }}"
         data-ad-format="{{ $format ?? 'auto' }}"
         data-full-width-responsive="true"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</div>
@else
{{-- Dev/staging placeholder — invisible to users, visible in dev --}}
@if(config('app.env') !== 'production')
<div style="margin:28px 0;padding:20px;background:repeating-linear-gradient(45deg,#f0ede8,#f0ede8 10px,#fff 10px,#fff 20px);border:1px dashed #ccc;border-radius:8px;text-align:center">
    <span style="font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:1px">AdSense Placeholder</span>
</div>
@endif
@endif
