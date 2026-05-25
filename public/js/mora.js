(function () {
  'use strict';

  const CHAT_URL   = '/mora/chat';
  const LEAD_URL   = '/mora/lead';
  const CSRF_TOKEN = () => document.querySelector('meta[name="csrf-token"]')?.content || '';
  const STORAGE_KEY = 'mora_history';

  const QUICK_REPLIES = [
    'Apa layanan utama M2B?',
    'Bagaimana proses import barang?',
    'Apa itu undername import?',
    'Cara konsultasi dengan tim M2B?',
  ];

  const LEAD_KEYWORDS = [
    'harga','biaya','tarif','penawaran','quote','rate','ongkos',
    'ekspor','impor','bea cukai','undername','door-to-door','layanan',
  ];

  const CONTACT_MAP = {
    ekspor   : 'export@m2b.co.id',
    'export' : 'export@m2b.co.id',
    impor    : 'import@m2b.co.id',
    'import' : 'import@m2b.co.id',
    sales    : 'sales@m2b.co.id',
    harga    : 'sales@m2b.co.id',
    tarif    : 'sales@m2b.co.id',
    quote    : 'sales@m2b.co.id',
  };

  let history    = [];
  let leadShown  = false;
  let leadDone   = false;

  // ── DOM refs ─────────────────────────────────────────────────────────
  const el = id => document.getElementById(id);

  function init() {
    const trigger  = el('mora-trigger');
    const panel    = el('mora-panel');
    const closeBtn = el('mora-close');
    const input    = el('mora-input');
    const sendBtn  = el('mora-send');
    const qrWrap   = el('mora-quickreplies');
    const leadForm = el('mora-lead-form');
    const badge    = el('mora-badge');

    if (!trigger) return;

    // Restore history
    try { history = JSON.parse(sessionStorage.getItem(STORAGE_KEY) || '[]'); } catch {}

    // Render quick replies
    QUICK_REPLIES.forEach(q => {
      const btn = document.createElement('button');
      btn.className = 'mora-qr';
      btn.textContent = q;
      btn.addEventListener('click', () => { sendMessage(q); qrWrap.style.display = 'none'; });
      qrWrap.appendChild(btn);
    });

    // Events
    trigger.addEventListener('click', () => {
      panel.classList.toggle('open');
      badge.style.display = 'none';
      if (panel.classList.contains('open') && history.length === 0) {
        showWelcome();
      }
    });

    closeBtn.addEventListener('click', () => panel.classList.remove('open'));

    sendBtn.addEventListener('click', submit);
    input.addEventListener('keydown', e => {
      if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); submit(); }
    });

    // Lead form
    el('mora-lead-submit')?.addEventListener('click', submitLead);
    el('mora-lead-skip')?.addEventListener('click', () => {
      leadForm.classList.remove('show');
      leadDone = true;
    });

    // Re-render existing history
    if (history.length > 0) {
      history.forEach(m => appendBubble(m.role, m.content, false));
    }
  }

  function showWelcome() {
    const welcome = 'Halo! Saya MORA 🤖, asisten AI dari PT. Mora Multi Berkah (M2B). Saya siap membantu Anda tentang layanan ekspor-impor, bea cukai, dan logistik. Ada yang bisa saya bantu?';
    appendBubble('assistant', welcome);
    history.push({ role: 'assistant', content: welcome });
    saveHistory();
  }

  function submit() {
    const input = el('mora-input');
    const text  = input.value.trim();
    if (!text) return;
    input.value = '';
    input.style.height = 'auto';
    sendMessage(text);
  }

  async function sendMessage(text) {
    // Hide quick replies after first message
    el('mora-quickreplies').style.display = 'none';

    appendBubble('user', text);
    history.push({ role: 'user', content: text });
    saveHistory();

    showTyping(true);

    try {
      const res = await fetch(CHAT_URL, {
        method  : 'POST',
        headers : {
          'Content-Type' : 'application/json',
          'Accept'       : 'application/json',
          'X-CSRF-TOKEN' : CSRF_TOKEN(),
        },
        body: JSON.stringify({ history }),
      });

      const data = await res.json();
      showTyping(false);

      if (!res.ok || data.error) {
        appendBubble('assistant', data.error || 'Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kami via WhatsApp.');
        return;
      }

      appendBubble('assistant', data.reply);
      history.push({ role: 'assistant', content: data.reply });
      saveHistory();

      // Check if should show lead form
      if (!leadDone && !leadShown && shouldShowLead(text)) {
        setTimeout(() => showLeadForm(), 800);
      }

    } catch (err) {
      showTyping(false);
      appendBubble('assistant', 'Koneksi terputus. Silakan coba lagi atau hubungi WhatsApp kami di +62 812-6302-7818.');
    }
  }

  function shouldShowLead(text) {
    const lower = text.toLowerCase();
    return LEAD_KEYWORDS.some(k => lower.includes(k));
  }

  function showLeadForm() {
    const form = el('mora-lead-form');
    if (!form || leadShown) return;
    leadShown = true;
    form.classList.add('show');
    scrollMessages();
  }

  async function submitLead() {
    const name    = el('mora-lead-name')?.value.trim();
    const company = el('mora-lead-company')?.value.trim();
    const email   = el('mora-lead-email')?.value.trim();
    const phone   = el('mora-lead-phone')?.value.trim();

    if (!name || !phone) {
      alert('Nama dan nomor HP wajib diisi.');
      return;
    }

    const submitBtn = el('mora-lead-submit');
    submitBtn.textContent = 'Mengirim...';
    submitBtn.disabled = true;

    try {
      await fetch(LEAD_URL, {
        method  : 'POST',
        headers : {
          'Content-Type' : 'application/json',
          'Accept'       : 'application/json',
          'X-CSRF-TOKEN' : CSRF_TOKEN(),
        },
        body: JSON.stringify({ name, company, email, phone }),
      });

      el('mora-lead-form').classList.remove('show');
      leadDone = true;
      appendBubble('assistant', `Terima kasih ${name}! Tim kami akan segera menghubungi Anda di ${phone}. Apakah ada pertanyaan lain? 😊`);
      history.push({ role: 'assistant', content: `Terima kasih ${name}! Tim kami akan segera menghubungi Anda.` });
      saveHistory();

    } catch {
      submitBtn.textContent = 'Kirim';
      submitBtn.disabled = false;
    }
  }

  function appendBubble(role, text, animate = true) {
    const messages = el('mora-messages');
    const div  = document.createElement('div');
    div.className = `mora-msg ${role === 'user' ? 'user' : 'bot'}`;

    if (!animate) div.style.animation = 'none';

    const bubble = document.createElement('div');
    bubble.className = 'mora-bubble';
    bubble.innerHTML = escapeHtml(text).replace(/\n/g, '<br>');

    if (role !== 'user') {
      const av = document.createElement('div');
      av.className = 'mora-msg-avatar';
      av.textContent = '🤖';
      div.appendChild(av);
    }

    div.appendChild(bubble);
    messages.appendChild(div);
    scrollMessages();
  }

  function showTyping(show) {
    const t = el('mora-typing');
    if (!t) return;
    t.classList.toggle('show', show);
    if (show) scrollMessages();
  }

  function scrollMessages() {
    const msgs = el('mora-messages');
    if (msgs) msgs.scrollTop = msgs.scrollHeight;
  }

  function saveHistory() {
    try { sessionStorage.setItem(STORAGE_KEY, JSON.stringify(history.slice(-20))); } catch {}
  }

  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
