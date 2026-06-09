{{-- ═══ Floating Buttons — kanan: eBook + WhatsApp ═══ --}}
<div style="position:fixed;bottom:28px;right:20px;z-index:9991;display:flex;flex-direction:column;gap:12px;align-items:flex-end">
  <a href="https://ebook.m2b.co.id" target="_blank" rel="noopener"
    style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;border-radius:24px;background:#f5b91c;color:#0f0f14;text-decoration:none;font-weight:700;font-size:12px;box-shadow:0 4px 14px rgba(245,185,28,0.4);transition:transform .2s,box-shadow .2s;white-space:nowrap"
    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(245,185,28,0.5)'"
    onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(245,185,28,0.4)'">
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
      <a :href="$store.lang.t(
          'https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20mau%20minta%20penawaran%20harga',
          'https://wa.me/6281263027818?text=Hello%20M2B,%20I%20would%20like%20to%20request%20a%20price%20quote',
          'https://wa.me/6281263027818?text=您好M2B，我想索取价格报价',
          'https://wa.me/6281263027818?text=مرحباً%20M2B،%20أرغب%20في%20طلب%20عرض%20سعر'
        )"
        target="_blank" rel="noopener"
        style="padding:8px 14px;border-radius:20px;background:#fff;border:1.5px solid #25D366;color:#075e54;font-size:12px;font-weight:700;text-decoration:none;box-shadow:0 2px 10px rgba(0,0,0,0.1);white-space:nowrap"
        x-text="$store.lang.t('💰 Minta Penawaran Harga', '💰 Request Quote', '💰 索取价格报价', '💰 طلب عرض سعر')">
        💰 Minta Penawaran Harga
      </a>
      <a href="#" @click.prevent="waOpen = false; window.dispatchEvent(new CustomEvent('open-b2b-modal'))"
        style="padding:8px 14px;border-radius:20px;background:#fff;border:1.5px solid #25D366;color:#075e54;font-size:12px;font-weight:700;text-decoration:none;box-shadow:0 2px 10px rgba(0,0,0,0.1);white-space:nowrap"
        x-text="$store.lang.t('💼 Ajukan Inquiry B2B', '💼 Submit B2B Inquiry', '💼 提交 B2B 询盘', '💼 تقديم استعلام B2B')">
        💼 Ajukan Inquiry B2B
      </a>
      <a :href="$store.lang.t(
          'https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20cek%20status%20shipment%20saya',
          'https://wa.me/6281263027818?text=Hello%20M2B,%20I%20would%20like%20to%20check%20my%20shipment%20status',
          'https://wa.me/6281263027818?text=您好M2B，我想查询我的货物运输状态',
          'https://wa.me/6281263027818?text=مرحباً%20M2B،%20أرغب%20في%20التحقق%20من%20حالة%20شحنتي'
        )"
        target="_blank" rel="noopener"
        style="padding:8px 14px;border-radius:20px;background:#fff;border:1.5px solid #25D366;color:#075e54;font-size:12px;font-weight:700;text-decoration:none;box-shadow:0 2px 10px rgba(0,0,0,0.1);white-space:nowrap"
        x-text="$store.lang.t('📦 Cek Status Shipment', '📦 Check Status', '📦 查询运输状态', '📦 التحقق من حالة الشحنة')">
        📦 Cek Status Shipment
      </a>
    </div>

    {{-- WA Button utama (diperbesar dari 56px ke 68px menggunakan kelas wa-btn-main) --}}
    <button @click="waOpen = !waOpen" class="wa-btn wa-btn-main"
      aria-label="WhatsApp M2B">
      <span x-show="!waOpen" style="display:flex;align-items:center;justify-content:center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width:36px;height:36px;fill:#fff;display:block">
          <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L3 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
        </svg>
      </span>
      <span x-show="waOpen" x-cloak style="font-size:26px;line-height:1;color:#fff;font-weight:700;display:inline-block;transition:transform 0.25s;transform:rotate(90deg)">✕</span>
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
  <a href="#" @click.prevent="window.dispatchEvent(new CustomEvent('open-b2b-modal'))"
    style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:12px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:13px"
    x-text="$store.lang.t('💼 Inquiry B2B', '💼 B2B Inquiry', '💼 B2B 询盘', '💼 استفسار B2B')">
    💼 Inquiry B2B
  </a>
  <a href="https://portal.m2b.co.id" target="_blank" rel="noopener"
    style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:12px;border-radius:10px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:700;font-size:13px"
    x-text="$store.lang.t('🔐 Login Portal', '🔐 Portal Login', '🔐 登录门户', '🔐 دخول البوابة')">
    🔐 Login Portal
  </a>
</div>
