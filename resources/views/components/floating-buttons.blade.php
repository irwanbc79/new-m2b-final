{{-- ═══ Floating Buttons — kanan: eBook + WhatsApp ═══ --}}
<div x-data="{
  waOpen: false,
  csModalOpen: false,
  csName: '',
  csPhone: '',
  csEmail: '',
  csCompany: '',
  loading: false,
  submitCSLead() {
    if (!this.csName.trim() || !this.csPhone.trim()) {
      alert(this.$store.lang.t(
        'Nama dan Nomor WhatsApp wajib diisi.',
        'Name and WhatsApp number are required.',
        '姓名和 WhatsApp 号码为必填项。',
        'الاسم ورقم الواتساب مطلوبان.'
      ));
      return;
    }
    this.loading = true;
    fetch('/mora/lead', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        name: this.csName,
        phone: this.csPhone,
        email: this.csEmail,
        company: this.csCompany,
        source: 'cs_form'
      })
    })
    .then(res => {
      this.loading = false;
      this.csModalOpen = false;

      // Build pre-filled message based on selected language
      let waText = '';
      const lang = localStorage.getItem('m2b_lang') || 'id';
      if (lang === 'en') {
        waText = `Hello CS M2B, I would like to consult regarding shipping/logistics.\n\nMy Details:\n- Name: ${this.csName}\n- WhatsApp: ${this.csPhone}\n- Email: ${this.csEmail || '-'}\n- Company: ${this.csCompany || '-'}`;
      } else if (lang === 'zh') {
        waText = `您好 M2B 客服，我想咨询货运/物流相关事宜。\n\n我的信息：\n- 姓名: ${this.csName}\n- WhatsApp/电话: ${this.csPhone}\n- 电子邮件: ${this.csEmail || '-'}\n- 公司名称: ${this.csCompany || '-'}`;
      } else if (lang === 'ar') {
        waText = `مرحباً خدمة عملاء M2B، أود الاستفسار بخصوص الشحن والخدمات اللوجستية.\n\nبياناتي:\n- الاسم: ${this.csName}\n- الواتساب: ${this.csPhone}\n- البريد الإلكتروني: ${this.csEmail || '-'}\n- الشركة: ${this.csCompany || '-'}`;
      } else {
        // default to Indonesian 'id'
        waText = `Halo CS M2B, saya ingin berkonsultasi mengenai pengiriman/logistik.\n\nBerikut data saya:\n- Nama: ${this.csName}\n- WhatsApp: ${this.csPhone}\n- Email: ${this.csEmail || '-'}\n- Perusahaan: ${this.csCompany || '-'}`;
      }

      const encodedText = encodeURIComponent(waText);
      const waUrl = `https://wa.me/6281263027818?text=${encodedText}`;
      window.open(waUrl, '_blank');

      // Clear fields
      this.csName = '';
      this.csPhone = '';
      this.csEmail = '';
      this.csCompany = '';
    })
    .catch(err => {
      this.loading = false;
      console.error(err);
      alert(this.$store.lang.t(
        'Terjadi kesalahan. Silakan coba lagi atau hubungi kami secara manual.',
        'An error occurred. Please try again or contact us manually.',
        '发生错误。请重试或手动联系我们。',
        'حدث خطأ. يرجى المحاولة مرة أخرى أو الاتصال بنا يدوياً.'
      ));
    });
  }
}" style="position:fixed;bottom:28px;right:20px;z-index:9991;display:flex;flex-direction:column;gap:12px;align-items:flex-end">
  <a href="https://ebook.m2b.co.id" target="_blank" rel="noopener"
    style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;border-radius:24px;background:#f5b91c;color:#0f0f14;text-decoration:none;font-weight:700;font-size:12px;box-shadow:0 4px 14px rgba(245,185,28,0.4);transition:transform .2s,box-shadow .2s;white-space:nowrap"
    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(245,185,28,0.5)'"
    onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(245,185,28,0.4)'">
    📘 E-Book
  </a>

  {{-- WhatsApp dengan quick reply chips --}}
  <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px">

    {{-- Quick reply chips --}}
    <div x-show="waOpen"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 translate-y-2"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-end="opacity-0"
      style="display:flex;flex-direction:column;gap:6px;align-items:flex-end"
      x-cloak>
      
      {{-- 1. Ajukan B2B / Minta Penawaran --}}
      <a href="#" @click.prevent="waOpen = false; window.dispatchEvent(new CustomEvent('open-b2b-modal'))"
        class="wa-chip wa-chip-b2b"
        x-text="$store.lang.t('💼 Minta Penawaran (B2B)', '💼 Request Quote (B2B)', '💼 索取报价 (B2B)', '💼 طلب عرض سعر (B2B)')">
        💼 Minta Penawaran (B2B)
      </a>

      {{-- 2. Chat dengan CS (Opens Lead Form) --}}
      <a href="#" @click.prevent="waOpen = false; csModalOpen = true"
        class="wa-chip"
        x-text="$store.lang.t('💬 Chat dengan CS', '💬 Chat with CS', '💬 与客服联系', '💬 التحدث مع خدمة العملاء')">
        💬 Chat dengan CS
      </a>

      {{-- 3. Cek Status Shipment (Direct link to portal) --}}
      <a href="https://portal.m2b.co.id" target="_blank" rel="noopener" @click="waOpen = false"
        class="wa-chip wa-chip-portal"
        x-text="$store.lang.t('📦 Cek Status Shipment', '📦 Check Shipment Status', '📦 查询运输状态', '📦 التحقق من حالة الشحنة')">
        📦 Cek Status Shipment
      </a>
    </div>

    {{-- WA Button utama --}}
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

  {{-- ═══ Modal Popup: Chat dengan CS ═══ --}}
  <div x-show="csModalOpen" class="cs-overlay" x-cloak>
    <div class="cs-modal-card" @click.away="csModalOpen = false">
      <button @click="csModalOpen = false" class="cs-close-btn" aria-label="Close">✕</button>
      
      <div>
        <div class="cs-avatar">
          💬
          <div class="cs-avatar-dot"></div>
        </div>
        <h3 x-text="$store.lang.t('Hubungi Customer Service M2B', 'Contact M2B Customer Service', '联系 M2B 客服', 'اتصل بخدمة عملاء M2B')" style="text-align:center; font-size:18px; font-weight:700; color:#1e3a5f; margin:10px 0 6px 0;">
          Hubungi Customer Service M2B
        </h3>
        <p x-text="$store.lang.t('Silakan isi data Anda untuk memulai percakapan langsung via WhatsApp.', 'Please fill in your details to start a direct chat via WhatsApp.', '请填写您的信息以开始微信/WhatsApp直接聊天。', 'يرjى ملء بياناتك لبدء دردشة مباشرة عبر الواتساب.')" style="text-align:center; font-size:12.5px; color:#5c6c7f; line-height:1.5; margin:0 0 10px 0;">
          Silakan isi data Anda untuk memulai percakapan langsung via WhatsApp.
        </p>
      </div>

      {{-- Form Inputs --}}
      <div class="cs-input-group">
        <label class="cs-input-label" x-text="$store.lang.t('Nama Lengkap *', 'Full Name *', '姓名 *', 'الاسم الكامل *')">Nama Lengkap *</label>
        <input type="text" x-model="csName" class="cs-input" :placeholder="$store.lang.t('Masukkan nama Anda', 'Enter your name', '请输入姓名', 'أدخل اسمك')">
      </div>

      <div class="cs-input-group">
        <label class="cs-input-label" x-text="$store.lang.t('Nomor WhatsApp *', 'WhatsApp Number *', 'WhatsApp Number *', 'رقم الواتساب *')">Nomor WhatsApp *</label>
        <input type="tel" x-model="csPhone" class="cs-input" :placeholder="$store.lang.t('Contoh: 08123456789', 'Example: 08123456789', '例如: 08123456789', 'مثال: 08123456789')">
      </div>

      <div class="cs-input-group">
        <label class="cs-input-label" x-text="$store.lang.t('Alamat Email', 'Email Address', '电子邮箱', 'البريد الإلكتروني')">Alamat Email</label>
        <input type="email" x-model="csEmail" class="cs-input" :placeholder="$store.lang.t('Masukkan email Anda', 'Enter your email', '请输入电子邮箱', 'أدخل بريدك الإلكتروني')">
      </div>

      <div class="cs-input-group">
        <label class="cs-input-label" x-text="$store.lang.t('Nama Perusahaan', 'Company Name', '公司名称', 'اسم الشركة')">Nama Perusahaan</label>
        <input type="text" x-model="csCompany" class="cs-input" :placeholder="$store.lang.t('Masukkan nama perusahaan', 'Enter company name', '请输入公司名称', 'أدخل اسم الشركة')">
      </div>

      <button @click="submitCSLead()" :disabled="loading" class="cs-submit-btn">
        <svg x-show="loading" class="animate-spin" style="width:18px;height:18px;fill:none;stroke:#fff;stroke-width:2" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-linecap="round"></circle>
        </svg>
        <span x-text="loading ? $store.lang.t('Mengirim...', 'Sending...', '发送中...', 'جاري الإرسال...') : $store.lang.t('Mulai Obrolan WhatsApp', 'Start WhatsApp Chat', '开始 WhatsApp 聊天', 'بدء محادثة الواتساب')">
          Mulai Obrolan WhatsApp
        </span>
      </button>
    </div>
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

{{-- Styling CSS tambahan untuk WA Menu & CS Modal Card --}}
<style>
  .wa-chip {
    padding: 9px 15px;
    border-radius: 20px;
    background: #fff;
    border: 1.5px solid #25D366;
    color: #075e54;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    white-space: nowrap;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .wa-chip:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37,211,102,0.25);
    background: #fcfdfc;
  }
  .wa-chip-portal {
    border-color: #1e3a5f;
    color: #1e3a5f;
  }
  .wa-chip-portal:hover {
    box-shadow: 0 6px 16px rgba(30,58,95,0.2);
    background: #f7f9fc;
  }
  .wa-chip-b2b {
    border-color: #f5b91c;
    color: #b0820a;
  }
  .wa-chip-b2b:hover {
    box-shadow: 0 6px 16px rgba(245,185,28,0.25);
    background: #fffdf7;
  }

  /* CS Modal Animations */
  @keyframes csFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  @keyframes csPopIn {
    from { transform: scale(0.9) translateY(20px); opacity: 0; }
    to { transform: scale(1) translateY(0); opacity: 1; }
  }
  .cs-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100vw; height: 100vh;
    background: rgba(15, 15, 20, 0.5);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 10005;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: csFadeIn 0.3s ease-out;
  }
  .cs-modal-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.18);
    border-radius: 24px;
    max-width: 420px;
    width: 90%;
    padding: 30px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    gap: 18px;
    position: relative;
    animation: csPopIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-family: system-ui, -apple-system, sans-serif;
  }
  .cs-close-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: rgba(0, 0, 0, 0.05);
    color: #4a5568;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    transition: background 0.2s, transform 0.2s;
  }
  .cs-close-btn:hover {
    background: rgba(0, 0, 0, 0.1);
    transform: scale(1.05);
  }
  .cs-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #25D366, #128C7E);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin: 0 auto 4px auto;
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.25);
    position: relative;
  }
  .cs-avatar-dot {
    width: 12px;
    height: 12px;
    background: #00e676;
    border: 2px solid #fff;
    border-radius: 50%;
    position: absolute;
    bottom: 2px;
    right: 2px;
  }
  .cs-input-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    text-align: left;
  }
  .cs-input-label {
    font-size: 12px;
    font-weight: 600;
    color: #4a5568;
  }
  .cs-input {
    width: 100%;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1.5px solid rgba(229, 226, 220, 0.8);
    background: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s, box-shadow 0.2s;
    color: #1a202c;
  }
  .cs-input:focus {
    border-color: #25D366;
    box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.15);
  }
  .cs-submit-btn {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    background: linear-gradient(135deg, #25D366, #128C7E);
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.3);
    transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 8px;
  }
  .cs-submit-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 10px 28px rgba(37, 211, 102, 0.4);
  }
  .cs-submit-btn:active:not(:disabled) {
    transform: translateY(1px);
  }
  .cs-submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
  }

  .animate-spin {
    animation: spin 1s linear infinite;
  }
  @keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
</style>
