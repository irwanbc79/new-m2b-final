(function () {
  'use strict';

  const CHAT_URL   = '/mora/chat';
  const LEAD_URL   = '/mora/lead';
  const CSRF_TOKEN = () => document.querySelector('meta[name="csrf-token"]')?.content || '';
  const STORAGE_KEY = 'mora_history';

  const TRANSLATIONS = {
    id: {
      welcome: 'Halo! Saya MORA 🤖, asisten AI dari PT. Mora Multi Berkah (M2B). Saya siap membantu Anda tentang layanan ekspor-impor, bea cukai, dan logistik. Ada yang bisa saya bantu?',
      error: 'Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kami via WhatsApp.',
      connError: 'Koneksi terputus. Silakan coba lagi atau hubungi WhatsApp kami di +62 812-6302-7818.',
      required: 'Nama dan nomor HP wajib diisi.',
      sending: 'Mengirim...',
      submitBtn: 'Kirim',
      successText: (name, phone) => `Terima kasih ${name}! Tim kami akan segera menghubungi Anda di ${phone}. Apakah ada pertanyaan lain? 😊`,
      successHist: (name) => `Terima kasih ${name}! Tim kami akan segera menghubungi Anda.`,
      quickReplies: [
        'Apa layanan utama M2B?',
        'Bagaimana proses import barang?',
        'Apa itu undername import?',
        'Cara konsultasi dengan tim M2B?',
      ]
    },
    en: {
      welcome: 'Hello! I am MORA 🤖, AI assistant from PT. Mora Multi Berkah (M2B). I am ready to help you with export-import, customs clearance, and logistics services. How can I help you?',
      error: 'Sorry, an error occurred. Please try again or contact us via WhatsApp.',
      connError: 'Connection lost. Please try again or contact our WhatsApp at +62 812-6302-7818.',
      required: 'Name and phone number are required.',
      sending: 'Sending...',
      submitBtn: 'Submit & Get Offer',
      successText: (name, phone) => `Thank you ${name}! Our team will contact you soon at ${phone}. Do you have any other questions? 😊`,
      successHist: (name) => `Thank you ${name}! Our team will contact you soon.`,
      quickReplies: [
        'What are M2B\'s main services?',
        'How is the import process?',
        'What is undername import?',
        'How to consult with M2B team?',
      ]
    },
    zh: {
      welcome: '您好！我是 MORA 🤖，PT. Mora Multi Berkah (M2B) 的 AI 助手。我很乐意为您提供进出口、清关和物流服务方面的帮助。请问有什么我可以帮您的？',
      error: '抱歉，出错了。请重试或通过 WhatsApp 与我们联系。',
      connError: '连接中断。请重试或联系我们的 WhatsApp：+62 812-6302-7818。',
      required: '姓名和电话号码是必填项。',
      sending: '发送中...',
      submitBtn: '提交并获取报价',
      successText: (name, phone) => `谢谢您 ${name}！我们的团队很快会通过 ${phone} 与您联系。您还有其他问题吗？😊`,
      successHist: (name) => `谢谢您 ${name}！我们的团队很快会与您联系。`,
      quickReplies: [
        'M2B 的主要服务是什么？',
        '如何办理进口手续？',
        '什么是挂靠/借用资质进口？',
        '如何咨询 M2B 团队？',
      ]
    },
    ar: {
      welcome: 'مرحباً! أنا مورا 🤖، المساعد الذكي لشركة PT. Mora Multi Berkah (M2B). أنا هنا لمساعدتك في خدمات الاستيراد والتصدير، والتخليص الجمركي، والخدمات اللوجستية. كيف يمكنني مساعدتك اليوم؟',
      error: 'عذراً، حدث خطأ. يرجى المحاولة مرة أخرى أو الاتصال بنا عبر الواتساب.',
      connError: 'انقطع الاتصال. يرجى المحاولة مرة أخرى أو الاتصال بنا عبر الواتساب على +62 812-6302-7818.',
      required: 'الاسم ورقم الهاتف مطلوبان.',
      sending: 'جاري الإرسال...',
      submitBtn: 'إرسال والحصول على عرض',
      successText: (name, phone) => `شكراً لك ${name}! سيتصل بك فريقنا قريباً على الرقم ${phone}. هل لديك أي أسئلة أخرى؟ 😊`,
      successHist: (name) => `شكراً لك ${name}! سيتصل بك فريقنا قريباً.`,
      quickReplies: [
        'ما هي الخدمات الرئيسية لشركة M2B؟',
        'كيف تتم عملية الاستيراد؟',
        'ما هو الاستيراد تحت اسم شركة أخرى (Undername)؟',
        'كيف يمكنني استشارة فريق M2B؟',
      ]
    }
  };

  const LEAD_KEYWORDS = [
    'harga','biaya','tarif','penawaran','quote','rate','ongkos',
    'ekspor','impor','bea cukai','undername','door-to-door','layanan',
    'price','cost','fee','offer','export','import','customs',
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

    // Read language
    const lang = localStorage.getItem('m2b_lang') || 'id';
    const t = TRANSLATIONS[lang] || TRANSLATIONS.id;
    const quickReplies = t.quickReplies;

    // Restore history
    try { history = JSON.parse(sessionStorage.getItem(STORAGE_KEY) || '[]'); } catch {}

    // Render quick replies
    quickReplies.forEach(q => {
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
    const lang = localStorage.getItem('m2b_lang') || 'id';
    const t = TRANSLATIONS[lang] || TRANSLATIONS.id;
    const welcome = t.welcome;
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
    const lang = localStorage.getItem('m2b_lang') || 'id';
    const t = TRANSLATIONS[lang] || TRANSLATIONS.id;
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
        let errText = data.error || t.error;
        if (data.error === 'Maaf, layanan sedang tidak tersedia. Silakan hubungi kami via WhatsApp.') {
          errText = t.error;
        }
        appendBubble('assistant', errText);
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
      appendBubble('assistant', t.connError);
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
    const lang    = localStorage.getItem('m2b_lang') || 'id';
    const t       = TRANSLATIONS[lang] || TRANSLATIONS.id;

    if (!name || !phone) {
      alert(t.required);
      return;
    }

    const submitBtn = el('mora-lead-submit');
    submitBtn.textContent = t.sending;
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
      const successText = t.successText(name, phone);
      const successHist = t.successHist(name);

      appendBubble('assistant', successText);
      history.push({ role: 'assistant', content: successHist });
      saveHistory();

    } catch {
      submitBtn.textContent = t.submitBtn;
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
