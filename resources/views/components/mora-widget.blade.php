<link rel="stylesheet" href="{{ asset('css/mora.css') }}">

{{-- MORA Chat Widget --}}
<div id="mora-widget">
  {{-- Trigger button --}}
  <button id="mora-trigger" aria-label="Tanya MORA — AI M2B">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 2C6.48 2 2 6.03 2 11c0 2.67 1.19 5.07 3.07 6.74L4 22l4.44-1.55C9.56 20.81 10.76 21 12 21c5.52 0 10-4.03 10-9S17.52 2 12 2zm1 13H7v-2h6v2zm4-4H7V9h10v2z"/>
    </svg>
    <span id="mora-badge">1</span>
  </button>

  {{-- Chat panel --}}
  <div id="mora-panel" role="dialog" aria-label="MORA Chat">
    {{-- Header --}}
    <div id="mora-header">
      <div id="mora-avatar">🤖</div>
      <div id="mora-header-info">
        <div id="mora-header-name">MORA — AI Asisten M2B</div>
        <div id="mora-header-sub">Logistik · Ekspor · Impor</div>
      </div>
      <div id="mora-online-dot"></div>
      <button id="mora-close" aria-label="Tutup">✕</button>
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
      <h4>💼 Tim kami ingin menghubungi Anda</h4>
      <input id="mora-lead-name"    type="text"  placeholder="Nama Anda *" autocomplete="name">
      <input id="mora-lead-company" type="text"  placeholder="Nama perusahaan (opsional)" autocomplete="organization">
      <input id="mora-lead-email"   type="email" placeholder="Email (opsional)" autocomplete="email">
      <input id="mora-lead-phone"   type="tel"   placeholder="Nomor HP/WA *" autocomplete="tel">
      <button id="mora-lead-submit">Kirim & Dapatkan Penawaran</button>
      <p id="mora-lead-skip">Lewati saja</p>
    </div>

    {{-- Input area --}}
    <div id="mora-inputarea">
      <textarea id="mora-input" rows="1" placeholder="Ketik pesan..." aria-label="Pesan ke MORA"></textarea>
      <button id="mora-send" aria-label="Kirim">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
        </svg>
      </button>
    </div>
  </div>
</div>

<script src="{{ asset('js/mora.js') }}" defer></script>
