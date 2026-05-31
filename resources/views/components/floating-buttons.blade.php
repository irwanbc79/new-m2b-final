{{-- ═══ Floating Buttons — kanan: eBook + WhatsApp ═══ --}}
<div style="position:fixed;bottom:28px;right:20px;z-index:9991;display:flex;flex-direction:column;gap:12px;align-items:flex-end">
  <a href="https://ebook.m2b.co.id" target="_blank" rel="noopener"
    style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;border-radius:24px;background:#f5b91c;color:#0f0f14;text-decoration:none;font-weight:700;font-size:12px;box-shadow:0 4px 14px rgba(245,185,28,0.4);transition:transform .2s,box-shadow .2s;white-space:nowrap"
    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(245,185,28,0.5)'"
    onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(245,185,28,0.4))'">
    📘 E-Book
  </a>

  {{-- WhatsApp dengan quick reply chips --}}
  <div x-data="{ waOpen: false }" style="display:flex;flex-direction:column;align-items:flex-end;gap:8px">

    {{-- Quick reply chips --}}
    <div x-show="waOpen"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 translate-y-2"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-end="opacity-0"
      style="display:flex;flex-direction:column;gap:6px;align-items:flex-end"
      x-cloak>
      <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20mau%20minta%20penawaran%20harga"
        target="_blank" rel="noopener"
        style="padding:8px 14px;border-radius:20px;background:#fff;border:1.5px solid #25D366;color:#075e54;font-size:12px;font-weight:700;text-decoration:none;box-shadow:0 2px 10px rgba(0,0,0,0.1);white-space:nowrap">
        💰 Minta Penawaran Harga
      </a>
      <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20konsultasi%20gratis"
        target="_blank" rel="noopener"
        style="padding:8px 14px;border-radius:20px;background:#fff;border:1.5px solid #25D366;color:#075e54;font-size:12px;font-weight:700;text-decoration:none;box-shadow:0 2px 10px rgba(0,0,0,0.1);white-space:nowrap">
        🎓 Konsultasi Gratis
      </a>
      <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20cek%20status%20shipment%20saya"
        target="_blank" rel="noopener"
        style="padding:8px 14px;border-radius:20px;background:#fff;border:1.5px solid #25D366;color:#075e54;font-size:12px;font-weight:700;text-decoration:none;box-shadow:0 2px 10px rgba(0,0,0,0.1);white-space:nowrap">
        📦 Cek Status Shipment
      </a>
    </div>

    {{-- WA Button utama --}}
    <button @click="waOpen = !waOpen" class="wa-btn"
      :style="waOpen ? 'transform:rotate(45deg);transition:transform .2s' : 'transition:transform .2s'"
      style="width:56px;height:56px;border-radius:50%;background:#25D366;border:none;display:flex;align-items:center;justify-content:center;font-size:26px;box-shadow:0 8px 24px rgba(37,211,102,0.4);cursor:pointer"
      aria-label="WhatsApp M2B">
      <span x-show="!waOpen">💬</span>
      <span x-show="waOpen" x-cloak style="font-size:20px;line-height:1">✕</span>
    </button>
  </div>
</div>

{{-- ═══ Sticky Mobile CTA Bar ═══ --}}
<div x-data="{ showBar: false }"
  x-init="window.addEventListener('scroll', () => { showBar = window.scrollY > 500 })"
  x-show="showBar"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 translate-y-4"
  x-transition:enter-end="opacity-100 translate-y-0"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-end="opacity-0 translate-y-4"
  class="show-mobile"
  x-cloak
  style="position:fixed;bottom:0;left:0;right:0;z-index:9990;background:#fff;border-top:1px solid #e5e2dc;padding:10px 16px;display:flex;gap:8px;box-shadow:0 -4px 20px rgba(0,0,0,0.1)">
  <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20konsultasi%20gratis"
    target="_blank" rel="noopener"
    style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:12px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:13px">
    💬 Konsultasi Gratis
  </a>
  <a href="https://portal.m2b.co.id" target="_blank" rel="noopener"
    style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:12px;border-radius:10px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:700;font-size:13px">
    🔐 Login Portal
  </a>
</div>
