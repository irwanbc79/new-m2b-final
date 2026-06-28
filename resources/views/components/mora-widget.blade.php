<link rel="stylesheet" href="{{ asset('css/mora.css') }}?v=2.0">

{{-- MORA Chat Widget --}}
<div id="mora-widget">
  {{-- Trigger button --}}
  <button id="mora-trigger" :aria-label="lang==='en' ? 'Ask MORA — M2B AI' : 'Tanya MORA — AI M2B'">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 2C6.48 2 2 6.03 2 11c0 2.67 1.19 5.07 3.07 6.74L4 22l4.44-1.55C9.56 20.81 10.76 21 12 21c5.52 0 10-4.03 10-9S17.52 2 12 2zm1 13H7v-2h6v2zm4-4H7V9h10v2z"/>
    </svg>
    <span id="mora-badge">1</span>
  </button>

  {{-- Chat panel --}}
  <div id="mora-panel" role="dialog" :aria-label="lang==='en' ? 'MORA Chat' : 'MORA Chat'">
    {{-- Header --}}
    <div id="mora-header">
      <div id="mora-avatar">🤖</div>
      <div id="mora-header-info">
        <div id="mora-header-name" x-text="lang==='en' ? 'MORA — M2B AI Assistant' : 'MORA — AI Asisten M2B'">MORA — AI Asisten M2B</div>
        <div id="mora-header-sub" x-text="lang==='en' ? 'Logistics · Export · Import' : 'Logistik · Ekspor · Impor'">Logistik · Ekspor · Impor</div>
      </div>
      <div id="mora-online-dot"></div>
      <button id="mora-close" :aria-label="lang==='en' ? 'Close' : 'Tutup'">✕</button>
    </div>

    {{-- Messages --}}
    <div id="mora-messages">
      {{-- Typing indicator (always present, toggled via JS) --}}
      <div id="mora-typing">
        <div class="mora-msg-avatar">🤖</div>
        <div class="mora-typing-dots">
          <span></span><span></span><span></span>
        </div>
      </div>
    </div>

    {{-- Quick replies --}}
    <div id="mora-quickreplies"></div>

    {{-- Lead capture form --}}
    <div id="mora-lead-form">
      <h4 x-text="lang==='en' ? '💼 Our team would like to contact you' : '💼 Tim kami ingin menghubungi Anda'">💼 Tim kami ingin menghubungi Anda</h4>
      <input id="mora-lead-name"    type="text"  :placeholder="lang==='en' ? 'Your Name *' : 'Nama Anda *'" autocomplete="name">
      <input id="mora-lead-company" type="text"  :placeholder="lang==='en' ? 'Company Name (optional)' : 'Nama perusahaan (opsional)'" autocomplete="organization">
      <input id="mora-lead-email"   type="email" :placeholder="lang==='en' ? 'Email (optional)' : 'Email (opsional)'" autocomplete="email">
      <input id="mora-lead-phone"   type="tel"   :placeholder="lang==='en' ? 'Phone/WA *' : 'Nomor HP/WA *'" autocomplete="tel">
      <button id="mora-lead-submit" x-text="lang==='en' ? 'Submit & Get Offer' : 'Kirim & Dapatkan Penawaran'">Kirim & Dapatkan Penawaran</button>
      <p id="mora-lead-skip" x-text="lang==='en' ? 'Skip' : 'Lewati saja'">Lewati saja</p>
    </div>

    {{-- Image preview area --}}
    <div id="mora-image-preview" style="display: none;">
      <img id="mora-preview-img" src="" alt="Upload Preview">
      <button id="mora-preview-remove" title="Hapus foto">✕</button>
    </div>

    {{-- Input area --}}
    <div id="mora-inputarea">
      <input type="file" id="mora-file-input" accept="image/*" style="display: none;">
      <button id="mora-attach-btn" type="button" :aria-label="lang==='en' ? 'Attach photo' : 'Lampirkan foto'">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M16.5 6v11.5c0 2.21-1.79 4-4 4s-4-1.79-4-4V5c0-3.31 2.69-6 6-6s6 2.69 6 6v10.5c0 1.38-1.12 2.5-2.5 2.5s-2.5-1.12-2.5-2.5V6H10v9.5c0 2.48 2.02 4.5 4.5 4.5s4.5-2.02 4.5-4.5V5c0-4.42-3.58-8-8-8s-8 3.58-8 8v12c0 3.87 3.13 7 7 7s7-3.13 7-7V6h-1.5z"/>
        </svg>
      </button>
      <textarea id="mora-input" rows="1" :placeholder="lang==='en' ? 'Type a message...' : 'Ketik pesan...'" :aria-label="lang==='en' ? 'Message to MORA' : 'Pesan ke MORA'"></textarea>
      <button id="mora-send" :aria-label="lang==='en' ? 'Send' : 'Kirim'">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
        </svg>
      </button>
    </div>
  </div>
</div>

<script src="{{ asset('js/mora.js') }}?v=2.0" defer></script>
