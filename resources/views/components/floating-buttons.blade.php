{{-- ═══ Floating Buttons ═══ --}}

{{-- Right side: eBook + WhatsApp --}}
<div style="position:fixed;bottom:28px;right:20px;z-index:9991;display:flex;flex-direction:column;gap:12px;align-items:flex-end">
  {{-- eBook CTA --}}
  <a href="https://ebook.m2b.co.id" target="_blank" rel="noopener"
    style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;border-radius:24px;background:#f5b91c;color:#0f0f14;text-decoration:none;font-weight:700;font-size:12px;box-shadow:0 4px 14px rgba(245,185,28,0.4);transition:transform .2s,box-shadow .2s;white-space:nowrap"
    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(245,185,28,0.5)'"
    onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(245,185,28,0.4)'">
    📘 E-Book
  </a>
  {{-- WhatsApp --}}
  <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20konsultasi%20gratis" target="_blank" rel="noopener"
    class="wa-btn"
    style="width:56px;height:56px;border-radius:50%;background:#25D366;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:26px;box-shadow:0 8px 24px rgba(37,211,102,0.4)"
    aria-label="WhatsApp M2B">
    💬
  </a>
</div>

{{-- Left side: Language switcher --}}
<div x-data="{ lang: localStorage.getItem('m2b_lang') || 'id' }"
     x-init="$watch('lang', v => { localStorage.setItem('m2b_lang', v); document.documentElement.setAttribute('lang', v); })"
     style="position:fixed;bottom:90px;left:20px;z-index:9991;display:flex;flex-direction:column;gap:8px">
  <button @click="lang = lang === 'id' ? 'en' : 'id'"
    style="width:48px;height:48px;border-radius:50%;border:2px solid #e5e2dc;background:#fff;cursor:pointer;font-size:20px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 10px rgba(0,0,0,0.1);transition:transform .2s"
    onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform=''"
    :aria-label="lang === 'id' ? 'Switch to English' : 'Ganti ke Bahasa Indonesia'"
    :title="lang === 'id' ? 'Switch to English' : 'Ganti ke Bahasa Indonesia'">
    <span x-text="lang === 'id' ? '🇮🇩' : '🇬🇧'"></span>
  </button>
</div>
