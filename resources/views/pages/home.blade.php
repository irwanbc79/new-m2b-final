@extends('layouts.app')

@section('head')
<style>
@media(max-width:768px){
  .home-hero-h1{font-size:34px!important;letter-spacing:-1px!important}
  .home-hero{padding:60px 20px!important;min-height:auto!important}
  .home-services-grid{grid-template-columns:1fr!important}
  .home-testimonials-grid{grid-template-columns:1fr!important}
  .home-blog-grid{grid-template-columns:1fr!important}
  .home-process-grid{grid-template-columns:1fr!important;gap:32px!important}
  .home-features-grid{grid-template-columns:1fr!important}
  .home-about-grid{grid-template-columns:1fr!important;gap:32px!important}
  .home-route-inputs{grid-template-columns:1fr!important}
  .home-stats{gap:20px!important}
  .home-estimator{padding:48px 20px!important}
  .home-faq{padding:60px 20px!important}
  
  .home-modal-grid {
    grid-template-columns: 1fr!important;
    max-height: 90vh!important;
    overflow-y: auto!important;
  }
  .home-modal-left {
    min-height: auto!important;
    padding: 24px!important;
  }
  .home-modal-right {
    padding: 24px!important;
    overflow-y: visible!important;
  }
}
@media(min-width:769px) and (max-width:1024px){
  .home-services-grid{grid-template-columns:repeat(2,1fr)!important}
  .home-testimonials-grid{grid-template-columns:repeat(2,1fr)!important}
  .home-blog-grid{grid-template-columns:repeat(2,1fr)!important}
  .home-features-grid{grid-template-columns:repeat(2,1fr)!important}
  .home-about-grid{gap:32px!important}
}

.home-section {
  padding: 80px 40px !important;
}
@media(max-width:768px){
  .home-section {
    padding: 48px 20px !important;
  }
}

.home-hero-container {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
  padding: 80px 40px !important;
  width: 100%;
}
@media(max-width:768px){
  .home-hero-container {
    padding: 60px 20px !important;
  }
}

.home-process-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0;
  position: relative;
}
.home-features-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}
.home-about-grid {
  display: grid;
  grid-template-columns: 1fr 1.4fr;
  gap: 56px;
}
.home-route-inputs {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

.home-modal-grid {
  display: grid;
  grid-template-columns: 1.1fr 1fr;
}
.home-modal-left {
  min-height: 480px;
}
.home-modal-right {
  overflow-y: auto;
}

/* Glassmorphism Service Cards */
.estimator-btn {
  padding: 24px 16px;
  border-radius: 16px;
  border: 1.5px solid rgba(255, 255, 255, 0.08);
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  color: #fff;
  cursor: pointer;
  text-align: center;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  position: relative;
}
.estimator-btn:hover {
  transform: translateY(-4px);
  background: rgba(30, 58, 95, 0.25);
  border-color: rgba(74, 158, 218, 0.4);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25), 0 0 15px rgba(74, 158, 218, 0.15);
}
.estimator-btn.active {
  background: linear-gradient(135deg, rgba(30, 58, 95, 0.8) 0%, rgba(15, 32, 67, 0.8) 100%) !important;
  border-color: #4a9eda !important;
  box-shadow: 0 0 0 3px rgba(74, 158, 218, 0.25), 0 8px 24px rgba(74, 158, 218, 0.15) !important;
}
.estimator-btn-icon-wrapper {
  width: 58px;
  height: 58px;
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.05);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.05);
}
.estimator-btn:hover .estimator-btn-icon-wrapper {
  background: rgba(74, 158, 218, 0.15);
  transform: scale(1.1);
}
.estimator-btn.active .estimator-btn-icon-wrapper {
  background: rgba(74, 158, 218, 0.25);
  color: #4a9eda;
}

/* Import Calculator Styles */
.calc-input {
  background: rgba(255, 255, 255, 0.05) !important;
  border: 1px solid rgba(255, 255, 255, 0.15) !important;
  border-radius: 8px !important;
  color: #fff !important;
  padding: 10px 12px !important;
  font-size: 14px !important;
  font-family: inherit !important;
  width: 100% !important;
  transition: all 0.2s !important;
  outline: none !important;
}
.calc-input:focus {
  border-color: #4a9eda !important;
  background: rgba(255, 255, 255, 0.08) !important;
  box-shadow: 0 0 0 2px rgba(74, 158, 218, 0.2) !important;
}
.calc-input[readonly] {
  background: rgba(255, 255, 255, 0.02) !important;
  color: rgba(255, 255, 255, 0.6) !important;
  border-color: rgba(255, 255, 255, 0.08) !important;
  cursor: not-allowed !important;
}
.calc-select {
  background: #1e293b !important;
  border: 1px solid rgba(255, 255, 255, 0.15) !important;
  border-radius: 8px !important;
  color: #fff !important;
  padding: 10px 12px !important;
  font-size: 14px !important;
  font-weight: 600 !important;
  width: 100% !important;
  outline: none !important;
  cursor: pointer !important;
}
.calc-select:focus {
  border-color: #4a9eda !important;
}
.calc-preset-btn {
  background: rgba(255, 255, 255, 0.04) !important;
  border: 1px solid rgba(255, 255, 255, 0.08) !important;
  color: rgba(255, 255, 255, 0.7) !important;
  padding: 6px 12px !important;
  border-radius: 20px !important;
  font-size: 11.5px !important;
  font-weight: 700 !important;
  cursor: pointer !important;
  transition: all 0.2s !important;
}
.calc-preset-btn:hover {
  background: rgba(255, 255, 255, 0.08) !important;
  color: #fff !important;
  border-color: rgba(255, 255, 255, 0.2) !important;
}
.calc-preset-btn.active {
  background: #1e3a5f !important;
  color: #fff !important;
  border-color: #4a9eda !important;
  box-shadow: 0 0 8px rgba(74, 158, 218, 0.25) !important;
}
.calc-label {
  display: block !important;
  font-size: 11px !important;
  font-weight: 700 !important;
  color: rgba(255, 255, 255, 0.65) !important;
  margin-bottom: 5px !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
}
.calc-table {
  width: 100% !important;
  border-collapse: collapse !important;
  margin: 16px 0 !important;
  font-size: 13.5px !important;
}
.calc-table th {
  background: rgba(255, 255, 255, 0.05) !important;
  color: rgba(255, 255, 255, 0.8) !important;
  font-weight: 700 !important;
  text-align: left !important;
  padding: 12px 16px !important;
  border-bottom: 1.5px solid rgba(255, 255, 255, 0.12) !important;
}
.calc-table td {
  padding: 14px 16px !important;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
  color: rgba(255, 255, 255, 0.9) !important;
}
.calc-table tr:hover td {
  background: rgba(255, 255, 255, 0.01) !important;
}

@media print {
  body > * {
    display: none !important;
  }
  #print-calc-area, #print-calc-area * {
    display: block !important;
    visibility: visible !important;
  }
  #print-calc-area {
    position: absolute !important;
    left: 0 !important;
    top: 0 !important;
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    background: #0B132B !important;
    color: #fff !important;
  }
  .print-hide {
    display: none !important;
  }
}
</style>
@endsection


@section('content')

{{-- ═══ HERO ═══ --}}
<section x-data="{
    openCalculator: false,
    calcStep: 'input',
    fobVal: 0,
    selectedCurrency: 'USD',
    manualKurs: {{ $rates['pajak']['rates']['USD'] ?? 17805.00 }},
    isAutoKurs: true,
    selectedPreset: 'custom',
    bmRate: 10,
    bmtpRate: 0,
    ppnRate: 11,
    ppnbmRate: 0,
    pphRate: 7.5,
    dendaRate: 0,
    hasApi: false,
    ratesMap: {
      USD: {{ $rates['pajak']['rates']['USD'] ?? 17805.00 }},
      CNY: {{ $rates['pajak']['rates']['CNY'] ?? 2627.25 }},
      SGD: {{ $rates['pajak']['rates']['SGD'] ?? 13944.36 }},
      EUR: {{ $rates['pajak']['rates']['EUR'] ?? 20728.94 }}
    },
    syncCurrency() {
      if (this.isAutoKurs && this.ratesMap[this.selectedCurrency]) {
        this.manualKurs = this.ratesMap[this.selectedCurrency];
      }
    },
    presets: {
      elektronik: { bm: 0, ppn: 11, ppnbm: 0, pphApi: 10, pphNonApi: 10, bmtp: 0, denda: 0 },
      pakaian: { bm: 25, ppn: 11, ppnbm: 0, pphApi: 7.5, pphNonApi: 7.5, bmtp: 0, denda: 0 },
      makanan: { bm: 5, ppn: 11, ppnbm: 0, pphApi: 2.5, pphNonApi: 7.5, bmtp: 0, denda: 0 },
      kosmetik: { bm: 15, ppn: 11, ppnbm: 0, pphApi: 7.5, pphNonApi: 7.5, bmtp: 0, denda: 0 },
      sepatu: { bm: 30, ppn: 11, ppnbm: 0, pphApi: 7.5, pphNonApi: 7.5, bmtp: 0, denda: 0 },
      custom: { bm: 10, ppn: 11, ppnbm: 0, pphApi: 7.5, pphNonApi: 7.5, bmtp: 0, denda: 0 }
    },
    applyPreset(name) {
      this.selectedPreset = name;
      const p = this.presets[name];
      this.bmRate = p.bm;
      this.ppnRate = p.ppn;
      this.ppnbmRate = p.ppnbm;
      this.pphRate = this.hasApi ? p.pphApi : p.pphNonApi;
      this.bmtpRate = p.bmtp;
      this.dendaRate = p.denda;
    },
    updateApiToggle() {
      const p = this.presets[this.selectedPreset] || this.presets.custom;
      if (this.selectedPreset === 'elektronik') {
        this.pphRate = 10;
      } else {
        this.pphRate = this.hasApi ? p.pphApi : p.pphNonApi;
      }
    },
    getNilaiPabean() {
      return (parseFloat(this.fobVal) || 0) * (parseFloat(this.manualKurs) || 0);
    },
    getBeaMasuk() {
      const raw = this.getNilaiPabean() * (parseFloat(this.bmRate) / 100);
      return Math.ceil(raw / 1000) * 1000;
    },
    getBmtp() {
      const raw = this.getNilaiPabean() * (parseFloat(this.bmtpRate) / 100);
      return Math.ceil(raw / 1000) * 1000;
    },
    getNilaiImpor() {
      const bmUnrounded = this.getNilaiPabean() * (parseFloat(this.bmRate) / 100);
      return this.getNilaiPabean() + bmUnrounded;
    },
    getPpn() {
      const raw = this.getNilaiImpor() * (parseFloat(this.ppnRate) / 100);
      return Math.ceil(raw);
    },
    getPpnbm() {
      const raw = this.getNilaiImpor() * (parseFloat(this.ppnbmRate) / 100);
      return Math.ceil(raw);
    },
    getPph() {
      const raw = this.getNilaiImpor() * (parseFloat(this.pphRate) / 100);
      return Math.ceil(raw);
    },
    getDenda() {
      const raw = this.getBeaMasuk() * (parseFloat(this.dendaRate) / 100);
      return Math.ceil(raw);
    },
    getTotalPungutan() {
      return this.getBeaMasuk() + this.getBmtp() + this.getPpn() + this.getPpnbm() + this.getPph() + this.getDenda();
    },
    formatNumber(val, decimals = 2) {
      return new Intl.NumberFormat('id-ID', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }).format(val);
    },
    formatIDR(val) {
      return 'Rp ' + this.formatNumber(val, 2);
    },
    getWaMessage() {
      const fob = parseFloat(this.fobVal) || 0;
      const cur = this.selectedCurrency;
      const kurs = this.manualKurs;
      const pabean = this.getNilaiPabean();
      const bm = this.getBeaMasuk();
      const bmtp = this.getBmtp();
      const ppn = this.getPpn();
      const ppnbm = this.getPpnbm();
      const pph = this.getPph();
      const denda = this.getDenda();
      const total = this.getTotalPungutan();
      
      let text = 'Halo M2B, saya ingin berkonsultasi mengenai pengapalan impor dengan estimasi pungutan berikut:\n\n';
      text += `- FOB: ${cur} ${this.formatNumber(fob, 2)}\n`;
      text += `- Kurs Pajak: Rp ${this.formatNumber(kurs, 2)}\n`;
      text += `- Nilai Pabean: ${this.formatIDR(pabean)}\n\n`;
      text += `Detail Estimasi Pungutan:\n`;
      text += `1. Bea Masuk (${this.bmRate}%): ${this.formatIDR(bm)}\n`;
      if (bmtp > 0) text += `2. BMTP (${this.bmtpRate}%): ${this.formatIDR(bmtp)}\n`;
      text += `3. PPN (${this.ppnRate}%): ${this.formatIDR(ppn)}\n`;
      if (ppnbm > 0) text += `4. PPnBM (${this.ppnbmRate}%): ${this.formatIDR(ppnbm)}\n`;
      text += `5. PPh (${this.pphRate}%): ${this.formatIDR(pph)}\n`;
      if (denda > 0) text += `6. Denda (${this.dendaRate}%): ${this.formatIDR(denda)}\n`;
      text += `-------------------------------------------\n`;
      text += `Jumlah Pungutan: ${this.formatIDR(total)}\n\n`;
      text += 'Mohon dibantu info kelayakan impor dan quotation pengirimannya. Terima kasih.';
      return encodeURIComponent(text);
    },
    copyToClipboard() {
      const fob = parseFloat(this.fobVal) || 0;
      const cur = this.selectedCurrency;
      const kurs = this.manualKurs;
      const pabean = this.getNilaiPabean();
      const bm = this.getBeaMasuk();
      const bmtp = this.getBmtp();
      const ppn = this.getPpn();
      const ppnbm = this.getPpnbm();
      const pph = this.getPph();
      const denda = this.getDenda();
      const total = this.getTotalPungutan();
      
      let text = 'SIMULASI PERHITUNGAN BESARAN BEA MASUK DAN PAJAK YANG HARUS DILUNASI\n';
      text += 'PT MORA MULTI BERKAH (M2B) - Mitra Logistik & Customs Broker\n';
      text += '====================================================================\n';
      text += `FOB (${cur})        : ${this.formatNumber(fob, 2)}\n`;
      text += `Kurs (${cur})       : Rp ${this.formatNumber(kurs, 2)}\n`;
      text += `Nilai Pabean       : Rp ${this.formatNumber(pabean, 2)}\n`;
      text += '--------------------------------------------------------------------\n';
      text += `1. Bea Masuk (${this.bmRate}%)               : ${this.formatIDR(bm)}\n`;
      text += `2. BMTP (${this.bmtpRate}%)                    : ${this.formatIDR(bmtp)}\n`;
      text += `3. PPN (${this.ppnRate}%)                    : ${this.formatIDR(ppn)}\n`;
      text += `4. PPnBM (${this.ppnbmRate}%)                  : ${this.formatIDR(ppnbm)}\n`;
      text += `5. PPh (${this.pphRate}%)                    : ${this.formatIDR(pph)}\n`;
      text += `6. Denda (${this.dendaRate}%)                  : ${this.formatIDR(denda)}\n`;
      text += '--------------------------------------------------------------------\n';
      text += `JUMLAH PUNGUTAN IMPOR      : ${this.formatIDR(total)}\n`;
      text += '====================================================================\n';
      text += 'Hubungi M2B via sales@m2b.co.id / WhatsApp 0812-6302-7818';
      
      navigator.clipboard.writeText(text);
      alert('Hasil perhitungan berhasil disalin ke clipboard!');
    },
    printResults() {
      window.print();
    },
    resetCalculator() {
      this.fobVal = 0;
      this.selectedPreset = 'custom';
      this.bmRate = 10;
      this.bmtpRate = 0;
      this.ppnRate = 11;
      this.ppnbmRate = 0;
      this.pphRate = 7.5;
      this.dendaRate = 0;
      this.hasApi = false;
      this.calcStep = 'input';
      this.syncCurrency();
    }
  }" style="position:relative;min-height:640px;display:flex;align-items:center;overflow:hidden">
  <div style="position:absolute;inset:0;background-image:url(https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?auto=format&fit=crop&w=1600&q=80);background-size:cover;background-position:center"></div>
  <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(11,17,32,0.92) 40%,rgba(11,17,32,0.55) 75%,rgba(11,17,32,0.25) 100%)"></div>
  <div class="home-hero-container" style="display:flex;flex-direction:column;gap:28px;width:100%">
    <!-- Top Part: H1 & Desc -->
    <div style="max-width:620px;width:100%">
      <div style="display:flex;gap:8px;margin-bottom:22px;flex-wrap:wrap">
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(255,255,255,0.15);color:#fff;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Freight Forwarder</span>
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(255,255,255,0.15);color:#fff;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Customs Broker</span>
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.4);color:#7eb3e8;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase">Medan · Indonesia</span>
      </div>
      <h1 style="font-family:Syne;font-weight:800;font-size:54px;line-height:1.06;color:#fff;letter-spacing:-1.8px;margin-bottom:22px" class="home-hero-h1">
        <span x-text="$store.lang.t('Ekspor & Impor', 'Export & Import', '进出口服务', 'الاستيراد والتصدير')">Ekspor &amp; Impor</span><br>
        <span style="color:#4a9eda" x-text="$store.lang.t('Lebih Mudah,', 'Made Easy,', '更便捷，', 'أصبح سهلاً،')">Lebih Mudah,</span><br>
        <span x-text="$store.lang.t('Lebih Aman.', 'Made Secure.', '更安全。', 'أصبح آمناً.')">Lebih Aman.</span>
      </h1>
      <p style="font-size:17px;color:rgba(255,255,255,0.78);line-height:1.7;max-width:480px;margin-bottom:0">
        <span x-show="lang==='id'">End-to-end freight forwarding &amp; customs brokerage. Dari dokumen, bea cukai, hingga door-to-door delivery — M2B handle semuanya.</span>
        <span x-show="lang==='en'" x-cloak>End-to-end freight forwarding &amp; customs brokerage. From documents, customs clearance, to door-to-door delivery — M2B handles it all.</span>
        <span x-show="lang==='zh'" x-cloak>端到端货运代理与报关服务。从文件处理、清关到门到门交付——M2B 为您一手包办。</span>
        <span x-show="lang==='ar'" x-cloak>شحن شامل من الباب إلى الباب وتخليص جمركي. من المستندات والتخليص الجمركي إلى التسليم من الباب إلى الباب — M2B تتولى كل شيء.</span>
      </p>
    </div>

    <!-- Cards Row: Portal M2B (Left) & Kurs Pajak (Right) -->
    <div style="display:flex;gap:20px;flex-wrap:wrap;align-items:stretch;width:100%;max-width:1080px">
      <!-- Portal M2B Card -->
      <div style="flex:1;min-width:300px;max-width:520px;background:rgba(255,255,255,0.08);backdrop-filter:blur(16px);border-radius:14px;padding:18px 22px;border:1px solid rgba(255,255,255,0.18);box-shadow:0 12px 36px rgba(0,0,0,0.25);display:flex;flex-direction:column;justify-content:space-between">
        <div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
            <div style="width:36px;height:36px;border-radius:8px;background:#1e3a5f;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0">🔐</div>
            <div>
              <div style="font-family:Syne;font-weight:700;font-size:13px;color:#fff">Portal M2B</div>
              <div style="font-size:11px;color:rgba(255,255,255,0.45)">ERP & Client Portal — portal.m2b.co.id</div>
            </div>
            <span style="margin-left:auto;padding:2px 9px;border-radius:10px;background:rgba(74,158,218,0.2);color:#4a9eda;font-size:10px;font-weight:700;border:1px solid rgba(74,158,218,0.3)">LIVE</span>
          </div>
          <p style="font-size:13px;color:rgba(255,255,255,0.55);margin-bottom:14px;line-height:1.6">
            <span x-show="lang==='id'">Pantau status shipment, unduh dokumen, invoice, dan laporan logistik real-time.</span>
            <span x-show="lang==='en'" x-cloak>Monitor shipment status, download documents, invoices &amp; logistics reports in real-time.</span>
            <span x-show="lang==='zh'" x-cloak>实时监控货物 status，下载文件、发票及物流报告。</span>
            <span x-show="lang==='ar'" x-cloak>راقب حالة الشحنة، وحمل المستندات، والفواتير، والتقارير اللوجستية في الوقت الفعلي.</span>
          </p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:auto">
          <a href="https://portal.m2b.co.id" target="_blank" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:10px 14px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:700;font-size:13px;white-space:nowrap" x-text="$store.lang.t('🔐 Login Portal', '🔐 Portal Login', '🔐 登录门户', '🔐 دخول البوابة')">🔐 Login Portal</a>
          <a href="https://portal.m2b.co.id/register" target="_blank" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:10px 14px;border-radius:8px;background:rgba(255,255,255,0.08);color:#fff;text-decoration:none;font-weight:600;font-size:13px;border:1px solid rgba(255,255,255,0.2);white-space:nowrap" x-text="$store.lang.t('✏️ Daftar Akun', '✏️ Register Account', '✏️ 注册账户', '✏️ تسجيل الحساب')">✏️ Daftar Akun</a>
        </div>
      </div>

      <!-- Right Column: Kurs Pajak Widget -->
      <div class="hero-widget-wrapper" style="flex:1.1;min-width:300px;max-width:540px;z-index:2;position:relative">
        <div style="background:rgba(255,255,255,0.03);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1.5px solid rgba(255,255,255,0.08);border-radius:18px;padding:16px 20px;box-shadow:0 20px 50px rgba(0,0,0,0.3);width:100%;height:100%;display:flex;flex-direction:column;justify-content:space-between">
          <div>
            <!-- Widget Header -->
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;flex-wrap:wrap;gap:8px">
              <div style="display:flex;align-items:center;gap:6px">
                <span style="display:inline-block;width:6px;height:6px;background:#10b981;border-radius:50%;box-shadow:0 0 6px #10b981;animation:pulse 2s infinite"></span>
                <span style="font-family:Syne;font-weight:700;font-size:12.5px;color:#fff" x-text="$store.lang.t('Kurs Pajak Kemenkeu', 'Customs Tax Rate', '海关税率', 'سعر الضريبة الجمركية')">Kurs Pajak Kemenkeu</span>
              </div>
              <span style="padding:2px 6px;border-radius:6px;background:rgba(245,185,28,0.15);color:#f5b91c;font-size:8px;font-weight:700;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('Mingguan', 'Weekly', '每周', 'أسبوعي')">Mingguan</span>
            </div>

            <!-- Period info -->
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid rgba(255,255,255,0.08);font-size:9.5px;color:rgba(255,255,255,0.4);flex-wrap:wrap;gap:4px">
              <div>
                <span x-text="$store.lang.t('Periode:', 'Period:', '期限:', 'الفترة:')">Periode:</span>
                <span style="color:#f5b91c;font-weight:700;margin-left:2px">{{ $rates['pajak']['period'] ?? '03 Jun - 09 Jun 2026' }}</span>
              </div>
              <div style="font-size:8px">
                KMK No. {{ $rates['pajak']['kmk'] ?? '25/MK/EF.2/2026' }}
              </div>
            </div>
            
            <!-- Currency List (Horizontal Grid) -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(105px, 1fr)); gap: 8px;">
              <!-- USD -->
              <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04);border-radius:12px;padding:8px 6px;text-align:center;display:flex;flex-direction:column;align-items:center;gap:3px">
                <span style="font-size:16px">🇺🇸</span>
                <span style="font-weight:700;font-size:10px;color:rgba(255,255,255,0.4)">USD</span>
                <span style="font-family:Syne;font-weight:700;font-size:11px;color:#fff;white-space:nowrap">Rp {{ number_format($rates['pajak']['rates']['USD'] ?? 17805.00, 2, ',', '.') }}</span>
              </div>
              <!-- CNY -->
              <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04);border-radius:12px;padding:8px 6px;text-align:center;display:flex;flex-direction:column;align-items:center;gap:3px">
                <span style="font-size:16px">🇨🇳</span>
                <span style="font-weight:700;font-size:10px;color:rgba(255,255,255,0.4)">CNY</span>
                <span style="font-family:Syne;font-weight:700;font-size:11px;color:#fff;white-space:nowrap">Rp {{ number_format($rates['pajak']['rates']['CNY'] ?? 2627.25, 2, ',', '.') }}</span>
              </div>
              <!-- SGD -->
              <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04);border-radius:12px;padding:8px 6px;text-align:center;display:flex;flex-direction:column;align-items:center;gap:3px">
                <span style="font-size:16px">🇸🇬</span>
                <span style="font-weight:700;font-size:10px;color:rgba(255,255,255,0.4)">SGD</span>
                <span style="font-family:Syne;font-weight:700;font-size:11px;color:#fff;white-space:nowrap">Rp {{ number_format($rates['pajak']['rates']['SGD'] ?? 13944.36, 2, ',', '.') }}</span>
              </div>
              <!-- EUR -->
              <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04);border-radius:12px;padding:8px 6px;text-align:center;display:flex;flex-direction:column;align-items:center;gap:3px">
                <span style="font-size:16px">🇪🇺</span>
                <span style="font-weight:700;font-size:10px;color:rgba(255,255,255,0.4)">EUR</span>
                <span style="font-family:Syne;font-weight:700;font-size:11px;color:#fff;white-space:nowrap">Rp {{ number_format($rates['pajak']['rates']['EUR'] ?? 20728.94, 2, ',', '.') }}</span>
              </div>
            </div>
          </div>

          <!-- Link to Estimator -->
          <a href="#" @click.prevent="openCalculator = true; calcStep = 'input'" style="display:block;margin-top:12px;padding-top:8px;border-top:1px solid rgba(255,255,255,0.05);text-align:center;color:#4a9eda;font-size:10px;font-weight:700;text-decoration:none;transition:opacity 0.2s" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1" x-text="$store.lang.t('Hitung Estimasi Bea Masuk →', 'Calculate Import Duties →', '计算进口税费 →', 'حساب الرسوم الجمركية ←')">
            Hitung Estimasi Bea Masuk →
          </a>
        </div>
      </div>
    </div>

    <!-- Row 2: Buttons -->
    <div class="flex gap-3 flex-wrap" x-data="{ open: false }" style="width:100%;max-width:1080px">
      <a :href="$store.lang.t('https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20mau%20konsultasi%20gratis', 'https://wa.me/6281263027818?text=Hello%20M2B,%20I%20would%20like%20a%20free%20consultation', 'https://wa.me/6281263027818?text=您好M2B，我想进行免费咨询', 'https://wa.me/6281263027818?text=مرحباً%20M2B،%20أرغب%20في%20استشارة%20مجانية')" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:15px;transition:all .18s"
        x-text="$store.lang.t('💬 Konsultasi GRATIS', '💬 Free Consultation', '💬 免费咨询', '💬 استشارة مجانية')">💬 Konsultasi GRATIS</a>

      <button @click="open = true"
              class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-lg border border-white/30 backdrop-blur-sm transition-all duration-300 cursor-pointer">
          <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
          </svg>
          <span x-text="$store.lang.t('Tonton Profil M2B', 'Watch M2B Profile', '观看 M2B 简介视频', 'مشاهدة الملف التعريفي لـ M2B')">Tonton Profil M2B</span> <span class="text-xs opacity-60">(16d)</span>
      </button>

      <a href="#layanan" style="display:inline-flex;align-items:center;gap:8px;padding:13px 24px;border-radius:8px;color:#fff;text-decoration:none;font-weight:600;font-size:15px;border:1.5px solid rgba(255,255,255,0.25);background:rgba(255,255,255,0.05)"
        x-text="$store.lang.t('Lihat Layanan →', 'View Services →', '查看服务 →', 'عرض الخدمات ←')">Lihat Layanan →</a>

      {{-- YouTube Modal --}}
      <div x-show="open"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0"
           x-transition:enter-end="opacity-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100"
           x-transition:leave-end="opacity-0"
           @keydown.escape.window="open = false"
           class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 sm:p-6 backdrop-blur-sm"
           style="display: none;">
          <div @click.outside="open = false"
               class="relative w-full max-w-4xl bg-black rounded-2xl shadow-2xl overflow-hidden aspect-video border border-gray-800">
              <button @click="open = false"
                      class="absolute top-4 right-4 z-10 p-2 bg-black/50 hover:bg-red-600 rounded-full text-white transition-colors">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
              </button>
              <template x-if="open">
                  <iframe class="w-full h-full"
                          src="https://www.youtube.com/embed/ZkZVVKRXuuA?autoplay=1&rel=0&modestbranding=1"
                          title="PT. Mora Multi Berkah Official"
                          frameborder="0"
                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                          allowfullscreen>
                  </iframe>
              </template>
          </div>
      </div>
    </div>

    <!-- Row 3: Stats -->
    <div style="display:flex;gap:32px;margin-top:20px;border-top:1px solid rgba(255,255,255,0.18);padding-top:20px;flex-wrap:wrap;width:100%;max-width:1080px" class="home-stats">
      @foreach([
        ['target'=>5,   'label_id'=>'Tahun berpengalaman', 'label_en'=>'Years of experience',  'label_zh'=>'年行业经验', 'label_ar'=>'سنوات الخبرة',  'suffix'=>'+'],
        ['target'=>100, 'label_id'=>'Klien aktif',          'label_en'=>'Active clients',       'label_zh'=>'活跃客户',   'label_ar'=>'عميل نشط',    'suffix'=>'+'],
        ['target'=>20,  'label_id'=>'Negara tujuan',        'label_en'=>'Destination countries','label_zh'=>'覆盖国家',   'label_ar'=>'وجهة شحن',    'suffix'=>'+'],
      ] as $stat)
      <div x-data="{ count: 0 }"
           x-intersect.once="
             let start = null, target = {{ $stat['target'] }};
             const step = (ts) => {
               if (!start) start = ts;
               const progress = Math.min((ts - start) / 1800, 1);
               count = Math.floor(progress * target);
               if (progress < 1) requestAnimationFrame(step);
             };
             requestAnimationFrame(step);
           ">
        <div style="font-family:Syne;font-weight:800;font-size:28px;color:#4a9eda;line-height:1">
          <span x-text="count + '{{ $stat['suffix'] }}'">{{ $stat['target'] }}{{ $stat['suffix'] }}</span>
        </div>
        <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-top:6px" x-text="$store.lang.t('{{ $stat['label_id'] }}', '{{ $stat['label_en'] }}', '{{ $stat['label_zh'] }}', '{{ $stat['label_ar'] }}')">{{ $stat['label_id'] }}</div>
      </div>
      @endforeach
      <div>
        <div style="font-family:Syne;font-weight:800;font-size:28px;color:#4a9eda;line-height:1">A–Z</div>
        <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-top:6px" x-text="$store.lang.t('Layanan end-to-end', 'End-to-end service', '端到端一站式服务', 'خدمة متكاملة من البداية للنهاية')">Layanan end-to-end</div>
      </div>
    </div>
  </div>

  {{-- Customs Calculator Modal --}}
  <div x-show="openCalculator" x-cloak @click="openCalculator = false"
    class="print-hide"
    style="position:fixed;inset:0;z-index:10000;background:rgba(11,17,32,0.85);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:center;padding:20px">
    
    <div id="print-calc-area" @click.stop 
      style="background:#0B132B;border-radius:24px;max-width:960px;width:100%;max-height:94vh;overflow-y:auto;box-shadow:0 30px 70px rgba(0,0,0,0.8);border:1px solid rgba(255,255,255,0.08);display:flex;flex-direction:column;position:relative">
      
      <!-- STEP 1: INPUT FORM -->
      <div x-show="calcStep === 'input'" style="padding:32px;display:flex;flex-direction:column;gap:20px">
        <!-- Header -->
        <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,0.08);padding-bottom:16px">
          <div>
            <h3 style="font-family:Syne;font-weight:800;font-size:24px;color:#fff;letter-spacing:-0.5px" x-text="$store.lang.t('Kalkulator Pajak Impor', 'Import Tax Calculator', '进口税费计算器', 'حاسبة ضرائب الاستيراد')">Kalkulator Pajak Impor</h3>
            <p style="font-size:12px;color:rgba(255,255,255,0.5);margin-top:4px" x-text="$store.lang.t('Simulasi bea masuk & pajak dalam rangka impor secara cepat & akurat', 'Simulate import duties & taxes (PDRI) quickly & accurately', '快速准确地模拟计算进口关税及进口环节税', 'محاكاة الرسوم الجمركية وضرائب الاستيراد بسرعة ودقة')"></p>
          </div>
          <button @click="openCalculator = false" style="background:rgba(255,255,255,0.05);border:none;border-radius:50%;color:rgba(255,255,255,0.6);width:36px;height:36px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">✕</button>
        </div>

        <!-- Presets -->
        <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);border-radius:14px;padding:16px">
          <div style="font-size:10.5px;font-weight:800;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:10px;letter-spacing:0.5px" x-text="$store.lang.t('Pilih Kategori Barang (Preset):', 'Select Goods Category Preset:', '货物品类预设：', 'اختر الفئة المحددة مسبقاً للسلع:')">Pilih Kategori Barang (Preset):</div>
          <div style="display:flex;flex-wrap:wrap;gap:8px">
            <button @click="applyPreset('elektronik')" :class="selectedPreset === 'elektronik' && 'active'" class="calc-preset-btn">💻 Elektronik</button>
            <button @click="applyPreset('pakaian')" :class="selectedPreset === 'pakaian' && 'active'" class="calc-preset-btn">👕 Pakaian & Tekstil</button>
            <button @click="applyPreset('makanan')" :class="selectedPreset === 'makanan' && 'active'" class="calc-preset-btn">🍎 Makanan & Minuman</button>
            <button @click="applyPreset('kosmetik')" :class="selectedPreset === 'kosmetik' && 'active'" class="calc-preset-btn">💄 Kosmetik & Skincare</button>
            <button @click="applyPreset('sepatu')" :class="selectedPreset === 'sepatu' && 'active'" class="calc-preset-btn">👟 Sepatu & Tas</button>
            <button @click="applyPreset('custom')" :class="selectedPreset === 'custom' && 'active'" class="calc-preset-btn">⚙️ Custom / Manual</button>
          </div>
        </div>

        <!-- Money Inputs -->
        <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:20px">
          <!-- FOB Value Input -->
          <div>
            <label class="calc-label" x-text="$store.lang.t('Nilai FOB (Harga Barang)', 'FOB Value (Goods Value)', '离岸价格 FOB (货值)', 'قيمة البضاعة (FOB)')">Nilai FOB (Harga Barang)</label>
            <div style="position:relative">
              <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-weight:800;color:rgba(255,255,255,0.4);font-size:14px" x-text="selectedCurrency"></span>
              <input type="number" x-model.number="fobVal" placeholder="0.00" style="padding-left:55px" class="calc-input" />
            </div>
            <p style="font-size:10px;color:rgba(255,255,255,0.4);margin-top:6px" x-text="$store.lang.t('*FOB (Free on Board) tidak termasuk freight dan asuransi', '*FOB (Free on Board) excludes freight and insurance', '*FOB (离岸价格) 不包含国际运费和保险费', '*FOB لا تشمل الشحن والتأمين')"></p>
          </div>

          <!-- Currency & Exchange Rate -->
          <div style="display:grid;grid-template-columns:1fr 1.1fr;gap:12px">
            <div>
              <label class="calc-label" x-text="$store.lang.t('Mata Uang', 'Currency', '币种', 'العملة')">Mata Uang</label>
              <select x-model="selectedCurrency" @change="syncCurrency()" class="calc-select">
                <option value="USD">🇺🇸 USD</option>
                <option value="CNY">🇨🇳 CNY</option>
                <option value="SGD">🇸🇬 SGD</option>
                <option value="EUR">🇪🇺 EUR</option>
              </select>
            </div>
            <div>
              <label class="calc-label">
                <span x-text="$store.lang.t('Kurs Pajak', 'Tax Rate', '海关税率', 'سعر الصرف')">Kurs Pajak</span>
                <span style="font-size:9px;color:#10b981;font-weight:700" x-show="isAutoKurs">(AUTO)</span>
              </label>
              <input type="number" x-model.number="manualKurs" :readonly="isAutoKurs" class="calc-input" style="font-weight:700" />
              <label style="display:flex;align-items:center;gap:6px;margin-top:6px;font-size:9.5px;color:rgba(255,255,255,0.5);cursor:pointer">
                <input type="checkbox" x-model="isAutoKurs" @change="syncCurrency()" />
                <span x-text="$store.lang.t('Gunakan Kurs Kemenkeu', 'Use Kemenkeu Rate', '使用财政部汇率', 'استخدام سعر وزارة المالية')">Gunakan Kurs Kemenkeu</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Custom Percentages Inputs Grid -->
        <div style="background:rgba(255,255,255,0.01);border:1px solid rgba(255,255,255,0.05);border-radius:14px;padding:20px;display:flex;flex-direction:column;gap:14px">
          <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,0.05);padding-bottom:10px">
            <span style="font-size:11px;font-weight:800;text-transform:uppercase;color:rgba(255,255,255,0.6);letter-spacing:0.5px" x-text="$store.lang.t('Detail Parameter Tarif Pajak (%)', 'Tax Rate Details (%)', '税率参数详情 (%)', 'تفاصيل معدلات الضرائب (%)')">Detail Parameter Tarif Pajak (%)</span>
            <!-- API Toggle -->
            <label style="display:flex;align-items:center;gap:6px;font-size:11px;cursor:pointer;font-weight:700;color:#4a9eda">
              <input type="checkbox" x-model="hasApi" @change="updateApiToggle()" />
              <span x-text="$store.lang.t('Memiliki API / NIB', 'Have API / NIB License', '拥有 API / NIB 证书', 'لديه رخصة استيراد API')">Memiliki API / NIB</span>
            </label>
          </div>
          
          <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:10px">
            <div>
              <label class="calc-label" style="text-align:center">BM</label>
              <div style="position:relative">
                <input type="number" step="0.1" x-model.number="bmRate" class="calc-input" style="text-align:center;padding-right:16px" />
                <span style="position:absolute;right:6px;top:50%;transform:translateY(-50%);font-size:9.5px;color:rgba(255,255,255,0.3)">%</span>
              </div>
            </div>
            <div>
              <label class="calc-label" style="text-align:center">BMTP</label>
              <div style="position:relative">
                <input type="number" step="0.1" x-model.number="bmtpRate" class="calc-input" style="text-align:center;padding-right:16px" />
                <span style="position:absolute;right:6px;top:50%;transform:translateY(-50%);font-size:9.5px;color:rgba(255,255,255,0.3)">%</span>
              </div>
            </div>
            <div>
              <label class="calc-label" style="text-align:center">PPN</label>
              <div style="position:relative">
                <input type="number" step="0.1" x-model.number="ppnRate" class="calc-input" style="text-align:center;padding-right:16px" />
                <span style="position:absolute;right:6px;top:50%;transform:translateY(-50%);font-size:9.5px;color:rgba(255,255,255,0.3)">%</span>
              </div>
            </div>
            <div>
              <label class="calc-label" style="text-align:center">PPnBM</label>
              <div style="position:relative">
                <input type="number" step="0.1" x-model.number="ppnbmRate" class="calc-input" style="text-align:center;padding-right:16px" />
                <span style="position:absolute;right:6px;top:50%;transform:translateY(-50%);font-size:9.5px;color:rgba(255,255,255,0.3)">%</span>
              </div>
            </div>
            <div>
              <label class="calc-label" style="text-align:center">PPh</label>
              <div style="position:relative">
                <input type="number" step="0.1" x-model.number="pphRate" class="calc-input" style="text-align:center;padding-right:16px" />
                <span style="position:absolute;right:6px;top:50%;transform:translateY(-50%);font-size:9.5px;color:rgba(255,255,255,0.3)">%</span>
              </div>
            </div>
            <div>
              <label class="calc-label" style="text-align:center">Denda</label>
              <div style="position:relative">
                <input type="number" step="0.1" x-model.number="dendaRate" class="calc-input" style="text-align:center;padding-right:16px" />
                <span style="position:absolute;right:6px;top:50%;transform:translateY(-50%);font-size:9.5px;color:rgba(255,255,255,0.3)">%</span>
              </div>
            </div>
          </div>
          
          <div style="background:rgba(74,158,218,0.05);border-left:3px solid #4a9eda;padding:10px 14px;border-radius:4px;font-size:11px;color:rgba(255,255,255,0.8);line-height:1.5">
            <span x-show="hasApi" x-text="$store.lang.t('💡 Dengan API / NIB (misal melalui Jasa Undername M2B), tarif PPh Impor Anda dipotong menjadi 2.5%!', '💡 With API / NIB (e.g. via M2B Undername Import Service), your Import PPh is reduced to 2.5%!', '💡 拥有 API / NIB 证书（例如通过 M2B 进出口代理），您的进口所得税 (PPh) 将降至 2.5%！', '💡 مع رخصة API / NIB (مثل خدمة M2B Undername)، يتم تخفيض ضريبة PPh إلى 2.5%!')"></span>
            <span x-show="!hasApi" x-text="$store.lang.t('💡 Tanpa API / NIB, Anda dikenakan tarif PPh standar (7.5% - 10%). Gunakan Jasa Undername M2B untuk menghemat Pajak Impor Anda!', '💡 Without API / NIB, standard PPh rate (7.5% - 10%) applies. Use M2B Undername Import Service to save on taxes!', '💡 没有 API / NIB 证书，您将适用标准所得税率 (7.5% - 10%)。建议使用 M2B 进出口代理以节省进口税！', '💡 بدون رخصة API / NIB، تنطبق ضريبة PPh القياسية (7.5% - 10%). استخدم خدمة M2B Undername للتوفير!')"></span>
          </div>
        </div>

        <!-- Submit Button -->
        <button @click="calcStep = 'result'" style="background:linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%);color:#fff;border:none;border-radius:10px;padding:16px;font-weight:800;font-size:15px;cursor:pointer;text-align:center;box-shadow:0 8px 25px rgba(59,130,246,0.3);transition:transform 0.2s" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'" x-text="$store.lang.t('Hitung Estimasi Sekarang →', 'Calculate Estimation Now →', '立即计算估算 →', 'احسب التقدير الآن ←')">
          Hitung Estimasi Sekarang →
        </button>
      </div>

      <!-- STEP 2: RESULTS SCREEN (MATCHING SCREENSHOT) -->
      <div x-show="calcStep === 'result'" style="display:flex;flex-direction:column;flex:1">
        
        <!-- Header Panel (Bright Gradient Blue) -->
        <div style="background:linear-gradient(90deg, #1e40af 0%, #4338ca 100%);padding:20px 24px;border-radius:24px 24px 0 0;display:flex;align-items:center;justify-content:space-between">
          <div>
            <h2 style="font-family:Syne;font-weight:800;font-size:18px;color:#fff;letter-spacing:-0.5px;text-transform:uppercase" x-text="$store.lang.t('Hasil Perhitungan Besaran Bea Masuk', 'Result of Import Duty Calculation', '海关关税及进口环节税计算结果', 'نتيجة حساب الرسوم الجمركية')">Hasil Perhitungan Besaran Bea Masuk</h2>
            <p style="font-size:11.5px;color:rgba(255,255,255,0.8);margin-top:2px" x-text="$store.lang.t('DAN PAJAK YANG HARUS DILUNASI', 'AND TAXES TO BE SETTLED', '及应当缴纳的进口环节税费', 'الرسوم والضرائب الواجب تسويتها')">DAN PAJAK YANG HARUS DILUNASI</p>
          </div>
          <div style="display:flex;align-items:center;gap:10px" class="print-hide">
            <button @click="printResults()" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:8px;color:#fff;font-weight:700;font-size:11.5px;padding:8px 16px;cursor:pointer;display:inline-flex;align-items:center;gap:6px">
              <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
              <span x-text="$store.lang.t('PRINT', 'PRINT', '打印', 'طباعة')">PRINT</span>
            </button>
            <button @click="openCalculator = false" style="background:rgba(255,255,255,0.15);border:none;border-radius:8px;color:#fff;width:34px;height:34px;cursor:pointer;font-size:16px;font-weight:700;display:inline-flex;align-items:center;justify-content:center">✕</button>
          </div>
        </div>

        <!-- Body Content -->
        <div style="padding:24px 32px 32px 32px;display:flex;flex-direction:column;gap:18px">
          
          <!-- Top Card Panels (3 Columns since Exemption is omitted) -->
          <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:14px">
            <!-- FOB Card -->
            <div style="background:rgba(88,28,135,0.12);border:1px solid rgba(139,92,246,0.25);border-radius:12px;padding:12px 18px">
              <div style="font-size:10px;font-weight:800;color:rgba(255,255,255,0.4);text-transform:uppercase" x-text="'FOB (' + selectedCurrency + ')'">FOB (USD)</div>
              <div style="font-family:Syne;font-weight:800;font-size:20px;color:#c084fc;margin-top:4px" x-text="formatNumber(fobVal, 2)">5.000,00</div>
            </div>
            <!-- Kurs Card -->
            <div style="background:rgba(6,78,59,0.15);border:1px solid rgba(16,185,129,0.25);border-radius:12px;padding:12px 18px">
              <div style="font-size:10px;font-weight:800;color:rgba(255,255,255,0.4);text-transform:uppercase" x-text="'KURS (' + selectedCurrency + ')'">KURS (USD)</div>
              <div style="font-family:Syne;font-weight:800;font-size:20px;color:#34d399;margin-top:4px" x-text="formatIDR(manualKurs)">Rp 17.805,00</div>
            </div>
            <!-- Nilai Pabean Card -->
            <div style="background:rgba(159,18,57,0.12);border:1px solid rgba(244,63,94,0.25);border-radius:12px;padding:12px 18px">
              <div style="font-size:10px;font-weight:800;color:rgba(255,255,255,0.4);text-transform:uppercase" x-text="$store.lang.t('NILAI PABEAN', 'CUSTOMS VALUE', '海关完税价格', 'القيمة الجمركية')">NILAI PABEAN</div>
              <div style="font-family:Syne;font-weight:800;font-size:20px;color:#fda4af;margin-top:4px" x-text="formatIDR(getNilaiPabean())">Rp 88.134.750,00</div>
            </div>
          </div>

          <!-- Table Results -->
          <div style="overflow-x:auto">
            <table class="calc-table">
              <thead>
                <tr>
                  <th style="width:50px">No</th>
                  <th x-text="$store.lang.t('Jenis Pungutan', 'Type of Levy', '税费种类', 'نوع الضريبة')">Jenis Pungutan</th>
                  <th x-text="$store.lang.t('Perhitungan', 'Calculation', '计算公式', 'الحساب')">Perhitungan</th>
                  <th style="text-align:right" x-text="$store.lang.t('Nilai Pungutan (Rp)', 'Levy Value (Rp)', '应缴金额 (Rp)', 'قيمة الضريبة بالروبية')">Nilai Pungutan (Rp)</th>
                </tr>
              </thead>
              <tbody>
                <!-- Row 1: BM -->
                <tr>
                  <td>1.</td>
                  <td style="font-weight:700">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#f97316;margin-right:8px"></span>
                    <span x-text="$store.lang.t('Bea Masuk (BM)', 'Import Duty (BM)', '进口关税 (BM)', 'الرسوم الجمركية')">Bea Masuk (BM)</span>
                  </td>
                  <td style="color:rgba(255,255,255,0.6)" x-text="bmRate + '% x ' + $store.lang.t('Nilai Pabean', 'Customs Value', '完税价格', 'القيمة الجمركية')">10% x Nilai Pabean</td>
                  <td style="text-align:right;font-weight:800;color:#f97316;font-family:monospace" x-text="formatNumber(getBeaMasuk(), 2)">8.814.000,00</td>
                </tr>
                <!-- Row 2: BMTP -->
                <tr>
                  <td>2.</td>
                  <td style="font-weight:700">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#ef4444;margin-right:8px"></span>
                    <span x-text="$store.lang.t('Bea Masuk Tindakan Pengamanan (BMTP)', 'Safeguard Duty (BMTP)', '保障措施关税 (BMTP)', 'رسوم الحماية الجمركية')">Bea Masuk Tindakan Pengamanan (BMTP)</span>
                  </td>
                  <td style="color:rgba(255,255,255,0.6)" x-text="bmtpRate + '% x ' + $store.lang.t('Nilai Pabean', 'Customs Value', '完税价格', 'القيمة الجمركية')">0% x Nilai Pabean</td>
                  <td style="text-align:right;font-weight:800;color:#ef4444;font-family:monospace" x-text="formatNumber(getBmtp(), 2)">0,00</td>
                </tr>
                <!-- Row 3: PPN -->
                <tr>
                  <td>3.</td>
                  <td style="font-weight:700">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#38bdf8;margin-right:8px"></span>
                    <span x-text="$store.lang.t('PPN', 'VAT', '进口增值税 (PPN)', 'ضريبة القيمة المضافة')">PPN</span>
                  </td>
                  <td style="color:rgba(255,255,255,0.6)" x-text="ppnRate + '% x (' + $store.lang.t('Nilai Pabean + Bea Masuk', 'Customs Value + Duty', '完税价格 + 关税', 'القيمة الجمركية + الرسوم') + ')'">11% x (Nilai Pabean + Bea Masuk)</td>
                  <td style="text-align:right;font-weight:800;color:#38bdf8;font-family:monospace" x-text="formatNumber(getPpn(), 2)">10.664.305,00</td>
                </tr>
                <!-- Row 4: PPnBM -->
                <tr>
                  <td>4.</td>
                  <td style="font-weight:700">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#ec4899;margin-right:8px"></span>
                    <span x-text="$store.lang.t('PPnBM', 'Luxury Goods Tax (PPnBM)', '奢侈品税 (PPnBM)', 'ضريبة السلع الفاخرة')">PPnBM</span>
                  </td>
                  <td style="color:rgba(255,255,255,0.6)" x-text="ppnbmRate + '% x (' + $store.lang.t('Nilai Pabean + Bea Masuk', 'Customs Value + Duty', '完税价格 + 关税', 'القيمة الجمركية + الرسوم') + ')'">0% x (Nilai Pabean + Bea Masuk)</td>
                  <td style="text-align:right;font-weight:800;color:#ec4899;font-family:monospace" x-text="formatNumber(getPpnbm(), 2)">0,00</td>
                </tr>
                <!-- Row 5: PPh -->
                <tr>
                  <td>5.</td>
                  <td style="font-weight:700">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#eab308;margin-right:8px"></span>
                    <span x-text="$store.lang.t('PPh', 'Income Tax (PPh)', '所得税 (PPh)', 'ضريبة الدخل')">PPh</span>
                  </td>
                  <td style="color:rgba(255,255,255,0.6)" x-text="pphRate + '% x (' + $store.lang.t('Nilai Pabean + Bea Masuk', 'Customs Value + Duty', '完税价格 + 关税', 'القيمة الجمركية + الرسوم') + ')'">5% x (Nilai Pabean + Bea Masuk)</td>
                  <td style="text-align:right;font-weight:800;color:#eab308;font-family:monospace" x-text="formatNumber(getPph(), 2)">4.847.412,00</td>
                </tr>
                <!-- Row 6: Denda -->
                <tr>
                  <td>6.</td>
                  <td style="font-weight:700">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#ef4444;margin-right:8px"></span>
                    <span x-text="$store.lang.t('Denda', 'Fine', '罚金/滞纳金', 'الغرامة')">Denda</span>
                  </td>
                  <td style="color:rgba(255,255,255,0.6)" x-text="dendaRate + '% x ' + $store.lang.t('Bea Masuk', 'Import Duty', '关税金额', 'الرسوم الجمركية')">0% x Bea Masuk</td>
                  <td style="text-align:right;font-weight:800;color:#ef4444;font-family:monospace" x-text="formatNumber(getDenda(), 2)">0,00</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Total (Violent Background) -->
          <div style="background:rgba(124,58,237,0.15);border:1px solid rgba(124,58,237,0.3);border-radius:12px;padding:16px 24px;display:flex;align-items:center;justify-content:space-between">
            <span style="font-family:Syne;font-weight:800;font-size:18px;color:#fff;text-transform:uppercase" x-text="$store.lang.t('Jumlah Pungutan (Rp)', 'Total Levies (Rp)', '进口税费总计 (Rp)', 'إجمالي الرسوم والضرائب (روبية)')">Jumlah Pungutan (Rp)</span>
            <span style="font-family:Syne;font-weight:800;font-size:24px;color:#fff" x-text="formatNumber(getTotalPungutan(), 2)">24.325.717,00</span>
          </div>

          <!-- Disclaimer -->
          <div style="background:rgba(15,23,42,0.6);border:1px solid rgba(99,102,241,0.15);border-radius:10px;padding:12px 16px;font-size:11px;color:rgba(255,255,255,0.55);line-height:1.5;display:flex;align-items:start;gap:10px">
            <span style="font-size:14px;color:#a78bfa;margin-top:-2px">ℹ</span>
            <span x-text="$store.lang.t('Perhitungan berdasarkan kurs pajak resmi Kementerian Keuangan RI periode ' + '{{ $rates['pajak']['period'] ?? '03 Jun - 09 Jun 2026' }}' + '. Hasil ini bersifat simulasi.', 'Calculations are based on the official tax rate of the Ministry of Finance RI for period ' + '{{ $rates['pajak']['period'] ?? '03 Jun - 09 Jun 2026' }}' + '. This result is a simulation.', '计算依据印尼财政部官方海关税率汇率周期（' + '{{ $rates['pajak']['period'] ?? '03 Jun - 09 Jun 2026' }}' + '）。该结果仅作为模拟参考。', 'تعتمد الحسابات على أسعار الصرف الرسمية الصادرة عن وزارة المالية للفترة ' + '{{ $rates['pajak']['period'] ?? '03 Jun - 09 Jun 2026' }}' + '. هذه النتيجة هي مجرد محاكاة.')"></span>
          </div>

          <!-- Print-hide Action Buttons Footer -->
          <div style="display:flex;gap:12px;margin-top:10px" class="print-hide">
            <button @click="calcStep = 'input'" style="flex:1;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.15);color:#fff;padding:14px;border-radius:10px;font-weight:700;font-size:13px;cursor:pointer;transition:all 0.2s" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.06)'" x-text="$store.lang.t('← Hitung Ulang / Ubah Data', '← Recalculate / Edit Inputs', '← 重新计算 / 修改数据', '← إعادة حساب / تعديل البيانات')">
              ← Hitung Ulang / Ubah Data
            </button>
            <a :href="'https://wa.me/6281263027818?text=' + getWaMessage()" target="_blank"
               style="flex:1.5;background:#25D366;color:#fff;text-align:center;padding:14px;border-radius:10px;text-decoration:none;font-weight:800;font-size:13px;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 8px 20px rgba(37,211,102,0.3);transition:transform 0.2s"
               onmouseover="this.style.transform='scale(1.01)'" onmouseout="this.style.transform='none'">
              <span>💬</span>
              <span x-text="$store.lang.t('Konsultasi Logistik & Pengapalan via WhatsApp', 'WhatsApp Logistics & Shipping Consultation', '微信/WhatsApp 咨询进口物流与出运', 'استشارة اللوجستيات والشحن عبر الواتساب')">Konsultasi Logistik & Pengapalan via WhatsApp</span>
            </a>
          </div>

        </div>

      </div>

    </div>

  </div>
</section>



{{-- ═══ MITRA STRATEGIS ═══ --}}
<x-partner-grid />

{{-- ═══ SERVICES ═══ --}}
<section id="layanan" class="home-section" style="background:#f7f5f0" x-data="{ openService: null }">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('Layanan', 'Services', '服务', 'الخدمات')">Layanan</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:36px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px" x-text="$store.lang.t('Semua Kebutuhan Logistik, Satu Atap', 'All Your Logistics Needs, Under One Roof', '一站式物流解决方案', 'جميع احتياجاتك اللوجستية تحت سقف واحد')">Semua Kebutuhan Logistik, Satu Atap</h2>
      <p style="color:#666;font-size:16px;max-width:500px;margin:0 auto" x-text="$store.lang.t('Klik setiap layanan untuk pelajari detail lengkap.', 'Click each service to learn the full details.', '点击各服务项目以了解详情。', 'انقر فوق كل خدمة لمعرفة التفاصيل الكاملة.')">Klik setiap layanan untuk pelajari detail lengkap.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px" class="home-services-grid">
      @php
      $services = [
        [
          'icon' => '📤',
          'title' => ['id' => 'Export Handling', 'en' => 'Export Handling', 'zh' => '出口代理服务', 'ar' => 'تخليص الصادرات'],
          'badge' => ['id' => 'Paling Populer', 'en' => 'Most Popular', 'zh' => '最受欢迎', 'ar' => 'الأكثر شعبية'],
          'desc' => [
            'id' => 'PEB, packing list, COO/SKA, dan pengiriman ke 20+ negara. Legal & tepat waktu.',
            'en' => 'PEB, packing list, COO/SKA, and shipping to 20+ countries. Legal & on time.',
            'zh' => '报关（PEB）、装箱单、原产地证（COO）及全球 20 多个国家的运输服务。合规且准时。',
            'ar' => 'إعلان الصادرات (PEB)، قائمة التعبئة، شهادة المنشأ (COO/SKA)، والشحن إلى أكثر من ٢٠ دولة. قانوني وفي الوقت المحدد.'
          ],
          'modalTitle' => ['id' => 'Export Handling', 'en' => 'Export Handling', 'zh' => '出口代理服务', 'ar' => 'تخليص الصادرات'],
          'tagline' => [
            'id' => 'Bisnismu siap mendunia. Dokumen yang menahanmu.',
            'en' => 'Your business is ready to go global. Don\'t let paperwork hold you back.',
            'zh' => '您的业务已准备好走向世界。别让繁琐的文件阻碍您。',
            'ar' => 'عملك جاهز للانطلاق عالمياً. لا تدع المعاملات الورقية تعيقك.'
          ],
          'bullets' => [
            'id' => ['PEB (Pemberitahuan Ekspor Barang) — proses 1×24 jam', 'COO/SKA Form A, D, E, AK — sesuai negara tujuan', 'Packing List & Commercial Invoice format internasional', 'Bill of Lading & Sea Waybill koordinasi langsung shipping line', 'Konsultasi HS Code untuk hindari salah klasifikasi', 'Tracking real-time hingga barang diterima'],
            'en' => ['PEB (Export Declaration) — 24-hour processing', 'COO/SKA Form A, D, E, AK — according to destination country', 'International format Packing List & Commercial Invoice', 'Bill of Lading & Sea Waybill direct shipping line coordination', 'HS Code consultation to avoid misclassification', 'Real-time tracking until cargo is received'],
            'zh' => ['出口申报（PEB）— 24小时内处理完毕', '原产地证（COO/SKA）A、D、E、AK 格式 — 根据目的国提供', '国际标准格式的装箱单与商业发票', '提单（B/L）与海运单直接与船公司协调', '海关编码（HS Code）咨询以避免归类错误', '实时追踪直至货物送达接收人'],
            'ar' => ['إعلان الصادرات (PEB) — معالجة خلال ٢٤ ساعة', 'شهادة المنشأ نموذج A, D, E, AK — حسب بلد المقصد', 'قائمة التعبئة والفاتورة التجارية بالتنسيق الدولي', 'تنسيق بوليصة الشحن وبوليصة الشحن البحري مباشرة مع خط الشحن', 'استشارة رمز النظام المنسق (HS Code) لتجنب التصنيف الخاطئ', 'تتبع في الوقت الفعلي حتى استلام البضائع']
          ],
          'statNum' => '500+',
          'statLabel' => [
            'id' => 'Shipment ekspor selesai tahun lalu',
            'en' => 'Export shipments completed last year',
            'zh' => '去年完成的出口货运量',
            'ar' => 'شحنة تصدير اكتملت العام الماضي'
          ]
        ],
        [
          'icon' => '📥',
          'title' => ['id' => 'Import Handling', 'en' => 'Import Handling', 'zh' => '进口代理服务', 'ar' => 'تخليص الواردات'],
          'badge' => null,
          'desc' => [
            'id' => 'PIB, estimasi bea & pajak (PDRI), hingga penyerahan ke gudang. Tanpa hidden cost.',
            'en' => 'PIB, duties & taxes estimation (PDRI), to warehouse delivery. No hidden costs.',
            'zh' => '报关（PIB）、税费估算（PDRI）直至送达仓库。无任何隐藏费用。',
            'ar' => 'إعلان الواردات (PIB)، تقدير الرسوم والضرائب (PDRI)، حتى التسليم إلى المستودع. بدون تكاليف خفية.'
          ],
          'modalTitle' => ['id' => 'Import Handling', 'en' => 'Import Handling', 'zh' => '进口代理服务', 'ar' => 'تخليص الواردات'],
          'tagline' => [
            'id' => 'Stop bayar 2× untuk barang yang sama.',
            'en' => 'Stop paying twice for the exact same cargo.',
            'zh' => '不要为同样的货物支付双倍费用。',
            'ar' => 'توقف عن الدفع مرتين لنفس البضائع.'
          ],
          'bullets' => [
            'id' => ['PIB (Pemberitahuan Impor Barang) — full digital CEISA 4.0', 'Kalkulasi Bea Masuk + PPN + PPh 22 transparan', 'Pengawalan jalur hijau & merah di Bea Cukai', 'Customs Clearance Belawan, Tanjung Priok, Tanjung Perak', 'Storage minimal — koordinasi pickup di hari yang sama', 'Asuransi all-risk tersedia'],
            'en' => ['PIB (Import Declaration) — full digital CEISA 4.0', 'Transparent Import Duty + VAT + PPh 22 calculation', 'Green & red lane inspection handling at Customs', 'Customs Clearance Belawan, Tanjung Priok, Tanjung Perak', 'Minimal storage fees — same-day pickup coordination', 'All-risk cargo insurance available'],
            'zh' => ['进口申报（PIB）— 数字化 CEISA 4.0 系统', '透明计算关税 + 增值税 + PPh 22 进口税', '海关绿色与红色通道查验协助', '棉兰 Belawan、雅加达 Tanjung Priok、泗水 Tanjung Perak 港口清关', '仓储时间最小化 — 安排当天提货', '提供全险货运保险服务'],
            'ar' => ['إعلان الواردات (PIB) — رقمي بالكامل CEISA 4.0', 'حساب شفاف للرسوم الجمركية + ضريبة القيمة المضافة + ضريبة الدخل 22', 'مرافقة وفحص المسار الأخضر والأحمر في الجمارك', 'التخليص الجمركي في بيلاوان، تانجونغ بريوك، تانجونغ بيراك', 'الحد الأدنى من التخزين — التنسيق للاستلام في نفس اليوم', 'تأمين شامل على البضائع متاح']
          ],
          'statNum' => '0',
          'statLabel' => [
            'id' => 'Hidden cost dalam quote kami',
            'en' => 'Hidden costs in our quotes',
            'zh' => '我们报价中的隐藏费用',
            'ar' => 'تكاليف خفية في عروض أسعارنا'
          ]
        ],
        [
          'icon' => '🛃',
          'title' => ['id' => 'Customs Clearance', 'en' => 'Customs Clearance', 'zh' => '报关清关服务', 'ar' => 'التخليص الجمركي'],
          'badge' => null,
          'desc' => [
            'id' => 'Bea cukai di pelabuhan utama Indonesia — Belawan, Tanjung Priok, Soekarno-Hatta.',
            'en' => 'Customs clearance at Indonesia\'s main ports — Belawan, Tanjung Priok, Soekarno-Hatta.',
            'zh' => '印尼各大港口的清关服务 — Belawan、Tanjung Priok、Soekarno-Hatta。',
            'ar' => 'التخليص الجمركي في الموانئ الرئيسية بإندونيسيا — بيلاوان، تانجونغ بريوك، سوكارنو هاتا.'
          ],
          'modalTitle' => ['id' => 'Customs Clearance', 'en' => 'Customs Clearance', 'zh' => '报关清关服务', 'ar' => 'التخليص الجمركي'],
          'tagline' => [
            'id' => 'Setiap menit di Bea Cukai = uang yang menguap.',
            'en' => 'Every minute delayed at Customs is money evaporated.',
            'zh' => '海关耽误的每一分钟都是在流失金钱。',
            'ar' => 'كل دقيقة تأخير في الجمارك تعني تبخر الأموال.'
          ],
          'bullets' => [
            'id' => ['Pengurusan PIB & PEB sesuai PMK terbaru', 'NHI (Nota Hasil Intelijen) preemptive check', 'Penanganan Lartas (barang dilarang/terbatas)', 'Pendampingan pemeriksaan fisik (jalur merah)', 'Banding & keberatan jika ada penetapan', 'Update regulasi PMK & PER-BC real-time'],
            'en' => ['PIB & PEB processing according to latest Ministry regulations', 'NHI (Intelligence Report Note) preemptive checks', 'Lartas (restricted/prohibited goods) handling', 'Representation during physical inspection (red lane)', 'Appeals & disputes for tariff valuation changes', 'Real-time Ministry of Finance & Customs regulation updates'],
            'zh' => ['根据最新财政部规定办理 PIB 和 PEB', 'NHI（情报结果通知）预防性核查', '限制/禁止进口类货物的特殊处理', '红道物理查验时的现场陪同协助', '如遇税则争议进行申诉与抗辩', '实时跟进最新财政部与海关法规动态'],
            'ar' => ['معالجة PIB و PEB وفقاً لأحدث لوائح وزارة المالية', 'فحوصات استباقية لـ NHI (مذكرة تقرير الاستخبارات)', 'التعامل مع السلع المقيدة أو المحظورة (Lartas)', 'المرافقة أثناء الفحص المادي (المسار الأحمر)', 'الاستئناف والاعتراض في حالة وجود تعديل في الرسوم', 'تحديثات في الوقت الفعلي للوائح الجمارك ووزارة المالية']
          ],
          'statNum' => '1-3 hari',
          'statLabel' => [
            'id' => 'Rata-rata waktu clearance',
            'en' => 'Average clearance time',
            'zh' => '平均清关时间',
            'ar' => 'متوسط وقت التخليص الجمركي'
          ]
        ],
        [
          'icon' => '🚚',
          'title' => ['id' => 'Door-to-Door', 'en' => 'Door-to-Door', 'zh' => '双清门到门', 'ar' => 'من الباب إلى الباب'],
          'badge' => null,
          'desc' => [
            'id' => 'Layanan end-to-end dari gudang pengirim ke pintu penerima, lintas negara.',
            'en' => 'End-to-end service from shipper\'s warehouse to recipient\'s door, cross-border.',
            'zh' => '跨国门到门服务，从发货人仓库直接送达收货人门口。',
            'ar' => 'خدمة متكاملة من مستودع المرسل إلى باب المستلم، عبر الحدود.'
          ],
          'modalTitle' => ['id' => 'Door-to-Door', 'en' => 'Door-to-Door', 'zh' => '双清门到门服务', 'ar' => 'من الباب إلى الباب'],
          'tagline' => [
            'id' => 'Dari gudangmu ke pintu pembeli. Kami yang tanggung.',
            'en' => 'From your warehouse to buyer\'s door. We handle the rest.',
            'zh' => '从您的仓库到买家门口，中间环节交给我们。',
            'ar' => 'من مستودعك إلى باب المشتري. نحن نتولى الباقي.'
          ],
          'bullets' => [
            'id' => ['Pickup dari gudang/pabrik dengan armada terpercaya', 'Konsolidasi LCL & FCL untuk biaya optimal', 'Customs clearance di Indonesia & negara tujuan', 'Last-mile delivery ke alamat penerima', 'Single point of contact — 1 PIC dari awal hingga akhir', 'Proof of Delivery digital langsung ke email'],
            'en' => ['Pickup from warehouse/factory with trusted fleet', 'LCL & FCL consolidation for optimized costs', 'Customs clearance in Indonesia & destination country', 'Last-mile delivery to recipient\'s address', 'Single point of contact — 1 dedicated PIC from start to finish', 'Digital Proof of Delivery sent directly to email'],
            'zh' => ['使用信赖车队从工厂/仓库提货', '拼箱（LCL）与整柜（FCL）集运以优化运输成本', '印尼及目的国的进出口双清关关务办理', '派送到收货人指定地址的末端配送', '单一联系窗口 — 从头到尾一站式专人跟单', '电子签收单（POD）直接发送至您的邮箱'],
            'ar' => ['الاستلام من المستودع/المصنع بأسطول موثوق', 'تجميع LCL و FCL للتكلفة المثلى', 'التخليص الجمركي في إندونيسيا وبلد المقصد', 'التسليم النهائي إلى عنوان المستلم', 'نقطة اتصال واحدة — مسؤول واحد من البداية إلى النهاية', 'إثبات التسليم الرقمي مباشرة إلى البريد الإلكتروني']
          ],
          'statNum' => '25+',
          'statLabel' => [
            'id' => 'Negara tujuan door-to-door',
            'en' => 'Door-to-door destination countries',
            'zh' => '门到门覆盖国家数量',
            'ar' => 'وجهة شحن من الباب إلى الباب'
          ]
        ],
        [
          'icon' => '📝',
          'title' => ['id' => 'Undername Import', 'en' => 'Undername Import', 'zh' => '买单进口代理(Undername)', 'ar' => 'الاستيراد باسم الغير'],
          'badge' => ['id' => 'Untuk UMKM', 'en' => 'For SMEs', 'zh' => '适合中小企业', 'ar' => 'للشركات الصغيرة'],
          'desc' => [
            'id' => 'Solusi bagi importir tanpa API (Angka Pengenal Impor). 100% legal dan aman.',
            'en' => 'Solutions for importers without an Import License (API). 100% legal & secure.',
            'zh' => '针对无进口资质（API）进口商的解决方案。100%合规安全。',
            'ar' => 'حلول للمستوردين الذين ليس لديهم رخصة استيراد (API). قانوني وآمن ١٠٠٪.'
          ],
          'modalTitle' => ['id' => 'Undername Import', 'en' => 'Undername Import', 'zh' => '买单进口代理(Undername)', 'ar' => 'الاستيراد باسم الغير'],
          'tagline' => [
            'id' => 'Belum punya API/NIB? Tetap bisa impor — legal.',
            'en' => 'Don\'t have API/NIB yet? You can still import — legally.',
            'zh' => '还没有进口资质（API/NIB）？您依然可以合规进口。',
            'ar' => 'ليس لديك رخصة استيراد بعد؟ لا يزال بإمكانك الاستيراد بشكل قانوني.'
          ],
          'bullets' => [
            'id' => ['100% legal — terdaftar resmi sebagai importir di Bea Cukai', 'Kontrak jelas: kamu pemilik barang, kami importir of record', 'Cocok untuk first-time importer & UMKM', 'Pengurusan PIB pakai data M2B', 'Bea masuk + pajak dibayar M2B, kamu reimburse', 'Berlanjut ke API/NIB sendiri saat bisnis scale'],
            'en' => ['100% legal — officially registered importer at Customs', 'Clear contract: you own the goods, we are the importer of record', 'Perfect for first-time importers & SMEs', 'PIB import declaration processed using M2B licenses', 'Duties & taxes paid by M2B, then reimbursed by you', 'Easily transition to your own licenses as business scales'],
            'zh' => ['100% 合规 — 在海关正式注册的特许进口商资质', '清晰的合同约束：货物所有权归您，我司仅作为登记进口商', '适合首次进口商和跨境电商、中小企业', '使用 M2B 进出口抬头办理 PIB 进口申报', '关税与进口税由 M2B 垫付，您再实报实销', '在业务规模扩大后，协助您申请自己的 NIB/API 资质'],
            'ar' => ['قانوني ١٠٠٪ — مستورد مسجل رسمياً في الجمارك', 'عقد واضح: أنت صاحب البضاعة، ونحن المستورد الرسمي المسجل', 'مناسب للمستوردين الجدد والشركات الصغيرة والمتوسطة', 'معالجة إعلان استيراد PIB باستخدام بيانات M2B', 'الرسوم الجمركية والضرائب تدفعها M2B ثم تقوم أنت بسدادها', 'الانتقال إلى رخصتك الخاصة عندما يتوسع عملك']
          ],
          'statNum' => '60+',
          'statLabel' => [
            'id' => 'UMKM kami bantu via undername',
            'en' => 'SMEs helped via undername services',
            'zh' => '我们协助买单进口的中小企业数量',
            'ar' => 'شركة صغيرة ومتوسطة ساعدناها'
          ]
        ],
        [
          'icon' => '💡',
          'title' => ['id' => 'Konsultasi Logistik', 'en' => 'Logistics Consultation', 'zh' => '物流策划与咨询', 'ar' => 'الاستشارات اللوجستية'],
          'badge' => ['id' => 'Gratis', 'en' => 'Free', 'zh' => '免费', 'ar' => 'مجاني'],
          'desc' => [
            'id' => 'Panduan ekspor-impor dari tim ahli — perencanaan moda hingga estimasi biaya.',
            'en' => 'Export-import guidance from experts — logistics modes planning to cost estimation.',
            'zh' => '专家团队提供的进出口指导 — 包含运输方式规划到全链条费用估算。',
            'ar' => 'توجيهات الاستيراد والتصدير من فريق الخبراء — تخطيط الوسائط إلى تقدير التكاليف.'
          ],
          'modalTitle' => ['id' => 'Konsultasi Logistik', 'en' => 'Logistics Consultation', 'zh' => '物流策划与咨询', 'ar' => 'الاستشارات اللوجستية'],
          'tagline' => [
            'id' => 'Sebelum salah pilih, tanyakan dulu — tanpa bayar.',
            'en' => 'Ask first before choosing the wrong mode — completely free.',
            'zh' => '在做出错误选择之前先咨询 — 完全免费。',
            'ar' => 'اسأل أولاً قبل الاختيار الخاطئ — مجاناً بالكامل.'
          ],
          'bullets' => [
            'id' => ['Audit kebutuhan logistik bisnismu — gratis 30 menit', 'Pemilihan moda: sea freight, air freight, atau multimoda', 'Optimasi rute & jadwal pengiriman', 'Estimasi total cost (freight + bea + pajak + handling)', 'Strategi negosiasi dengan supplier/buyer luar negeri', 'Rekomendasi Incoterms (FOB, CIF, DDP) sesuai bisnismu'],
            'en' => ['Audit your business logistics needs — free 30 minutes', 'Logistics mode selection: sea freight, air freight, or multimodal', 'Route and shipping schedule optimization', 'Total cost estimation (freight + duties + taxes + handling)', 'Negotiation strategy advice with foreign suppliers/buyers', 'Incoterms recommendation (FOB, CIF, DDP) tailored to your business'],
            'zh' => ['免费 30 分钟分析您的业务物流链条与需求', '运输方式选择：海运、空运或多式联运规划', '物流路线与发运船期优化排程', '总费用预算（包含运费、海关税费及港口杂费等）', '与国外供应商或买家的国际贸易条款协商策略', '根据您的商业模式推荐最合适的贸易术语（FOB, CIF, DDP）'],
            'ar' => ['تدقيق الاحتياجات اللوجستية لعملك — ٣٠ دقيقة مجاناً', 'اختيار الوسيلة: الشحن البحري، الجوي، أو متعدد الوسائط', 'تحسين المسار وجدول الشحن', 'تقدير التكلفة الإجمالية (الشحن + الرسوم + الضرائب + المناولة)', 'استراتيجية التفاوض مع الموردين/المشترين الأجانب', 'توصية بمصطلحات Incoterms (FOB, CIF, DDP) المناسبة لعملك']
          ],
          'statNum' => '5 menit',
          'statLabel' => [
            'id' => 'Rata-rata respon WhatsApp',
            'en' => 'Average WhatsApp response time',
            'zh' => '微信/WhatsApp 平均响应时间',
            'ar' => 'متوسط وقت رد الواتساب'
          ]
        ]
      ];
      @endphp
      @foreach($services as $i => $s)
      <div @click="openService = {{ $i }}" style="background:{{ $i === 0 ? '#0f0f14' : '#fff' }};border:1px solid {{ $i === 0 ? '#0f0f14' : '#e5e2dc' }};border-radius:12px;padding:28px 24px;transition:all .2s;cursor:pointer;position:relative"
        onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,0.12)';this.style.borderColor='#1e3a5f'"
        onmouseout="this.style.transform='none';this.style.boxShadow='0 1px 4px rgba(0,0,0,0.04)';this.style.borderColor='{{ $i === 0 ? '#0f0f14' : '#e5e2dc' }}'">
        @if($s['badge'])
        <div style="position:absolute;top:20px;right:20px;background:#1e3a5f;color:#fff;font-size:10px;padding:3px 10px;border-radius:10px;font-weight:700;letter-spacing:0.5px;text-transform:uppercase" x-text="$store.lang.t('{{ $s['badge']['id'] }}', '{{ $s['badge']['en'] }}', '{{ $s['badge']['zh'] }}', '{{ $s['badge']['ar'] }}')">{{ $s['badge']['id'] }}</div>
        @endif
        <div style="font-size:28px;margin-bottom:14px">{{ $s['icon'] }}</div>
        <div style="font-family:Syne;font-weight:700;font-size:17px;margin-bottom:8px;color:{{ $i === 0 ? '#fff' : '#0f0f14' }}" x-text="$store.lang.t('{{ $s['title']['id'] }}', '{{ $s['title']['en'] }}', '{{ $s['title']['zh'] }}', '{{ $s['title']['ar'] }}')">{{ $s['title']['id'] }}</div>
        <div style="font-size:13px;color:{{ $i === 0 ? 'rgba(255,255,255,0.55)' : '#777' }};line-height:1.7;margin-bottom:14px" x-text="$store.lang.t('{{ $s['desc']['id'] }}', '{{ $s['desc']['en'] }}', '{{ $s['desc']['zh'] }}', '{{ $s['desc']['ar'] }}')">{{ $s['desc']['id'] }}</div>
        <div style="font-size:12px;color:#4a9eda;font-weight:700;display:flex;align-items:center;gap:6px" x-text="$store.lang.t('Pelajari lebih lanjut →', 'Learn more →', '查看详情 →', 'معرفة المزيد ←')">Pelajari lebih lanjut →</div>
      </div>
      @endforeach
    </div>
  </div>
 
  {{-- Service Modals --}}
  @foreach($services as $i => $s)
  <div x-show="openService === {{ $i }}" x-cloak @click="openService = null"
    style="position:fixed;inset:0;z-index:1000;background:rgba(11,17,32,0.78);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;padding:24px">
    <div @click.stop class="home-modal-grid" style="background:#fff;border-radius:20px;max-width:960px;width:100%;max-height:92vh;overflow:hidden;display:grid;box-shadow:0 32px 80px rgba(0,0,0,0.5)">
      <div class="home-modal-left" style="position:relative;background:#0B1120;display:flex;flex-direction:column;justify-content:space-between;padding:36px">
        <div>
          <div style="font-size:40px;margin-bottom:16px">{{ $s['icon'] }}</div>
          @if($s['badge'])<span style="display:inline-block;padding:4px 12px;border-radius:20px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:18px" x-text="$store.lang.t('{{ $s['badge']['id'] }}', '{{ $s['badge']['en'] }}', '{{ $s['badge']['zh'] }}', '{{ $s['badge']['ar'] }}')">{{ $s['badge']['id'] }}</span>@endif
          <h2 style="font-family:Syne;font-weight:800;font-size:28px;color:#fff;letter-spacing:-1px;line-height:1.1;margin-bottom:14px" x-text="$store.lang.t('{{ $s['modalTitle']['id'] }}', '{{ $s['modalTitle']['en'] }}', '{{ $s['modalTitle']['zh'] }}', '{{ $s['modalTitle']['ar'] }}')">{{ $s['modalTitle']['id'] }}</h2>
          <p style="font-style:italic;font-size:17px;color:#f5b91c;line-height:1.45">"{{ $s['tagline']['id'] }}"</p>
          <p x-show="lang === 'en'" style="font-style:italic;font-size:17px;color:#f5b91c;line-height:1.45" x-cloak>"{{ $s['tagline']['en'] }}"</p>
          <p x-show="lang === 'zh'" style="font-style:italic;font-size:17px;color:#f5b91c;line-height:1.45" x-cloak>"{{ $s['tagline']['zh'] }}"</p>
          <p x-show="lang === 'ar'" style="font-style:italic;font-size:17px;color:#f5b91c;line-height:1.45" x-cloak>"{{ $s['tagline']['ar'] }}"</p>
        </div>
        <div style="padding:20px 24px;background:rgba(245,185,28,0.12);border:1px solid rgba(245,185,28,0.35);border-radius:14px">
          <div style="font-family:Syne;font-weight:800;font-size:32px;color:#f5b91c;line-height:1">{{ $s['statNum'] }}</div>
          <div style="font-size:12px;color:rgba(255,255,255,0.75);margin-top:4px" x-text="$store.lang.t('{{ $s['statLabel']['id'] }}', '{{ $s['statLabel']['en'] }}', '{{ $s['statLabel']['zh'] }}', '{{ $s['statLabel']['ar'] }}')">{{ $s['statLabel']['id'] }}</div>
        </div>
      </div>
      <div class="home-modal-right" style="padding:36px;position:relative">
        <button @click="openService = null" style="position:absolute;top:14px;right:14px;width:32px;height:32px;border-radius:50%;background:#fff;border:1px solid #e5e2dc;cursor:pointer;font-size:16px;color:#666">✕</button>
        <div style="font-size:11px;color:#999;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;margin-bottom:14px" x-text="$store.lang.t('Yang Kami Lakukan', 'What We Do', '我们所做的服务', 'ما نقوم به')">Yang Kami Lakukan</div>
        
        @foreach(['id', 'en', 'zh', 'ar'] as $langKey)
        <div x-show="lang === '{{ $langKey }}'" {!! $langKey !== 'id' ? 'x-cloak' : '' !!}>
          @foreach($s['bullets'][$langKey] as $j => $bullet)
          <div style="display:flex;gap:12px;padding:10px 0;{{ $j < count($s['bullets'][$langKey])-1 ? 'border-bottom:1px solid #f0ede8' : '' }};align-items:flex-start">
            <div style="width:20px;height:20px;border-radius:50%;background:rgba(30,58,95,0.1);color:#1e3a5f;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;flex-shrink:0;margin-top:1px">✓</div>
            <div style="font-size:13.5px;color:#1A1F2E;line-height:1.65;flex:1">{{ $bullet }}</div>
          </div>
          @endforeach
        </div>
        @endforeach

        <div style="margin-top:20px;padding-top:20px;border-top:1px solid #e5e2dc;display:flex;flex-direction:column;gap:10px">
          <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('Halo M2B, saya tertarik layanan ' + '{{ $s['title']['id'] }}', 'Hello M2B, I am interested in ' + '{{ $s['title']['en'] }}', '您好M2B，我对我们的' + '{{ $s['title']['zh'] }}' + '感兴趣', 'مرحباً M2B، أنا مهتم بخدمة ' + '{{ $s['title']['ar'] }}'))" target="_blank" style="background:#25D366;color:#fff;text-align:center;padding:13px;border-radius:10px;text-decoration:none;font-weight:800;font-size:14px;display:flex;align-items:center;justify-content:center;gap:8px" x-text="$store.lang.t('💬 Konsultasi via WhatsApp', '💬 Consult via WhatsApp', '💬 微信/WhatsApp咨询', '💬 استشارة عبر الواتساب')">💬 Konsultasi via WhatsApp</a>
          <a href="mailto:sales@m2b.co.id" style="background:transparent;color:#0f0f14;text-align:center;padding:12px;border-radius:10px;text-decoration:none;font-weight:700;font-size:13px;border:1.5px solid #d0cdc8" x-text="$store.lang.t('📧 Email sales@m2b.co.id', '📧 Email sales@m2b.co.id', '📧 发送邮件至 sales@m2b.co.id', '📧 البريد الإلكتروني sales@m2b.co.id')">📧 Email sales@m2b.co.id</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</section>

{{-- ═══ PROCESS ═══ --}}
<section id="proses" class="home-section" style="background:#f7f5f0">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:52px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('Cara Kerja', 'How It Works', '服务流程', 'آلية العمل')">Cara Kerja</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:34px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px" x-text="$store.lang.t('4 Langkah Mudah', '4 Simple Steps', '简单 4 步', '٤ خطوات بسيطة')">4 Langkah Mudah</h2>
      <p style="color:#666;max-width:440px;margin:0 auto" x-text="$store.lang.t('Prosesnya sederhana — kami yang kerja keras, kamu yang tenang.', 'Simple process — we handle the hard work, you stay worry-free.', '流程简单——繁琐工作交给我们，您只需安心等待。', 'عملية بسيطة — نحن نتولى العمل الشاق، وأنت تظل مرتاح البال.')">Prosesnya sederhana — kami yang kerja keras, kamu yang tenang.</p>
    </div>
    <div class="home-process-grid">
      <div class="hide-mobile" style="position:absolute;top:44px;left:12.5%;right:12.5%;height:2px;background:linear-gradient(90deg,#1e3a5f,#c7d7f9);z-index:0"></div>
      @php
      $steps = [
        [
          'icon' => '💬',
          'title' => ['id' => 'Konsultasi Gratis', 'en' => 'Free Consultation', 'zh' => '免费咨询', 'ar' => 'استشارة مجانية'],
          'desc' => [
            'id' => 'Hubungi kami via WhatsApp atau form. Ceritakan kebutuhan ekspor/impor kamu.',
            'en' => 'Contact us via WhatsApp or form. Tell us your export/import needs.',
            'zh' => '通过微信/WhatsApp或表单联系我们。告诉我们您的进出口需求。',
            'ar' => 'اتصل بنا عبر الواتساب أو النموذج. أخبرنا باحتياجاتك للاستيراد أو التصدير.'
          ]
        ],
        [
          'icon' => '📄',
          'title' => ['id' => 'Penawaran Transparan', 'en' => 'Transparent Quote', 'zh' => '透明报价', 'ar' => 'عرض أسعار شفاف'],
          'desc' => [
            'id' => 'Kami kirim quote detail — biaya, estimasi waktu, dokumen. Tanpa hidden fee.',
            'en' => 'We send a detailed quote — cost, timeline, documents. No hidden fees.',
            'zh' => '我们发送详细的报价——包含费用、时间估算、文件，无隐藏费用。',
            'ar' => 'نرسل عرض أسعار مفصلاً — التكلفة، والجدول الزمني، والمستندات. بدون رسوم خفية.'
          ]
        ],
        [
          'icon' => '⚙️',
          'title' => ['id' => 'Proses Dokumen', 'en' => 'Document Processing', 'zh' => '单证报关办理', 'ar' => 'معالجة المستندات'],
          'desc' => [
            'id' => 'Tim M2B mengurus semua dokumen dan bea cukai. Kamu update via portal real-time.',
            'en' => 'M2B team handles all documents & customs. Track real-time updates via portal.',
            'zh' => 'M2B 团队处理所有单证和清关事宜。您可以通过客户门户实时追踪。',
            'ar' => 'يتولى فريق M2B جميع المستندات والجمارك. تابع التحديثات في الوقت الفعلي عبر البوابة.'
          ]
        ],
        [
          'icon' => '✅',
          'title' => ['id' => 'Barang Terkirim', 'en' => 'Goods Delivered', 'zh' => '货物安全送达', 'ar' => 'تسليم البضائع'],
          'desc' => [
            'id' => 'Barang tiba aman di tujuan. Tracking tersedia hingga pengiriman selesai.',
            'en' => 'Goods arrive safely at destination. Full tracking available until delivery is complete.',
            'zh' => '货物安全抵达目的地。全程提供追踪，直至交付完成。',
            'ar' => 'تصل البضائع بأمان إلى وجهتها. التتبع متاح حتى اكتمال التسليم.'
          ]
        ]
      ];
      @endphp
      @foreach($steps as $k => $step)
      <div style="text-align:center;padding:0 20px;position:relative;z-index:1">
        <div style="width:56px;height:56px;border-radius:50%;background:#fff;border:3px solid #1e3a5f;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;box-shadow:0 0 0 6px #f7f5f0">{{ $step['icon'] }}</div>
        <div style="font-family:Syne;font-weight:800;font-size:48px;color:rgba(30,58,95,0.1);position:absolute;top:-8px;left:50%;transform:translateX(-50%);line-height:1">0{{ $k+1 }}</div>
        <div style="font-family:Syne;font-weight:700;font-size:15px;margin-bottom:8px" x-text="$store.lang.t('{{ $step['title']['id'] }}', '{{ $step['title']['en'] }}', '{{ $step['title']['zh'] }}', '{{ $step['title']['ar'] }}')">{{ $step['title']['id'] }}</div>
        <div style="font-size:13px;color:#777;line-height:1.7" x-text="$store.lang.t('{{ $step['desc']['id'] }}', '{{ $step['desc']['en'] }}', '{{ $step['desc']['zh'] }}', '{{ $step['desc']['ar'] }}')">{{ $step['desc']['id'] }}</div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ WHY US ═══ --}}
<section class="home-section" style="background:#0f0f14;color:#fff">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.3);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('Keunggulan', 'Why Us', '我们的优势', 'ميزاتنا')">Keunggulan</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:36px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px;color:#fff" x-text="$store.lang.t('Mengapa Memilih Kami?', 'Why Choose Us?', '为什么选择我们？', 'لماذا تختارنا؟')">Mengapa Memilih Kami?</h2>
      <p style="color:rgba(255,255,255,0.55);max-width:540px;margin:0 auto;font-size:15px" x-text="$store.lang.t('Lebih dari sekadar jasa ekspedisi — M2B adalah mitra strategis untuk kelancaran bisnismu.', 'More than just a freight service — M2B is your strategic partner for business success.', '不仅仅是货运代理——M2B 是您商业成功的战略合作伙伴。', 'أكثر من مجرد خدمة شحن — M2B هي شريكك الاستراتيجي لنجاح عملك.')">Lebih dari sekadar jasa ekspedisi — M2B adalah mitra strategis untuk kelancaran bisnismu.</p>
    </div>
    <div class="home-features-grid">
      @php
      $features = [
        [
          'icon' => '✓',
          'title' => ['id' => 'Terdaftar dan Berpengalaman', 'en' => 'Registered & Experienced', 'zh' => '资质齐全与经验丰富', 'ar' => 'مسجل وذو خبرة'],
          'desc' => [
            'id' => 'Resmi terdaftar di Dirjen Bea Cukai, NIB, dan asosiasi industri logistik Indonesia.',
            'en' => 'Officially registered with the Directorate General of Customs, NIB, and Indonesian logistics associations.',
            'zh' => '在印尼海关总署官方注册，拥有 NIB 资质及印尼物流行业协会会员资格。',
            'ar' => 'مسجل رسمياً لدى المديرية العامة للجمارك، ورقم تعريف الأعمال (NIB)، وجمعيات قطاع اللوجستيات الإندونيسية.'
          ],
          'stat' => '500+',
          'statLabel' => ['id' => 'Shipment berhasil diselesaikan', 'en' => 'Shipments successfully completed', 'zh' => '成功完成货运量', 'ar' => 'شحنة اكتملت بنجاح'],
          'wa_id' => 'Halo M2B, saya ingin cek legalitas dan pengalaman M2B',
          'wa_en' => 'Hello M2B, I would like to check M2Bs legality and experience',
          'wa_zh' => '您好M2B，我想了解M2B的资质与行业经验。',
          'wa_ar' => 'مرحباً M2B، أرغب في التحقق من قانونية وخبرة M2B'
        ],
        [
          'icon' => '💎',
          'title' => ['id' => 'Harga Transparan, Tanpa Hidden Cost', 'en' => 'Transparent Pricing, No Hidden Costs', 'zh' => '报价透明，无隐藏费用', 'ar' => 'تسعير شفاف، بدون تكاليف خفية'],
          'desc' => [
            'id' => 'Quote rinci dan jujur. Tidak ada surprise di akhir transaksi.',
            'en' => 'Detailed and honest quotes. No surprises at the end of the transaction.',
            'zh' => '详细且诚实的报价。交易结束时绝无隐性惊喜费用。',
            'ar' => 'عروض أسعار مفصلة وصادقة. لا مفاجآت في نهاية المعاملة.'
          ],
          'stat' => '0',
          'statLabel' => ['id' => 'Hidden cost dalam setiap quote', 'en' => 'Hidden costs in every quote', 'zh' => '每次报价中的隐藏费用', 'ar' => 'تكاليف خفية في كل عرض سعر'],
          'wa_id' => 'Halo M2B, saya minta quote transparan',
          'wa_en' => 'Hello M2B, I would like a transparent quote',
          'wa_zh' => '您好M2B，我想申请一份透明报价。',
          'wa_ar' => 'مرحباً M2B، أرغب في الحصول على عرض أسعار شفاف'
        ],
        [
          'icon' => '⚓',
          'title' => ['id' => 'Jaringan Kuat di Pelabuhan Utama', 'en' => 'Strong Port Network', 'zh' => '各大港口强大的操作网络', 'ar' => 'شبكة قوية في الموانئ الرئيسية'],
          'desc' => [
            'id' => 'Akses langsung ke Belawan, Tanjung Priok, dan Tanjung Perak.',
            'en' => 'Direct access to Belawan, Tanjung Priok, and Tanjung Perak ports.',
            'zh' => '直接对接棉兰 Belawan、雅加达 Tanjung Priok 和泗水 Tanjung Perak 等主要港口。',
            'ar' => 'وصول مباشر إلى موانئ بيلاوان، وتانجونغ بريوك، وتانجونغ بيراك.'
          ],
          'stat' => '3',
          'statLabel' => ['id' => 'Pelabuhan utama Indonesia', 'en' => 'Major ports in Indonesia', 'zh' => '印尼主要操作港口', 'ar' => 'موانئ رئيسية في إندونيسيا'],
          'wa_id' => 'Halo M2B, saya butuh info customs di pelabuhan',
          'wa_en' => 'Hello M2B, I need customs info at the ports',
          'wa_zh' => '您好M2B，我需要了解港口的清关信息。',
          'wa_ar' => 'مرحباً M2B، أحتاج إلى معلومات الجمارك في الموانئ'
        ],
        [
          'icon' => '⚡',
          'title' => ['id' => 'Komunikasi Cepat & Profesional', 'en' => 'Fast & Professional Communication', 'zh' => '快速且专业的沟通响应', 'ar' => 'تواصل سريع واحترافي'],
          'desc' => [
            'id' => 'Respon rapi via WhatsApp, email, atau Portal M2B kapan saja.',
            'en' => 'Quick response via WhatsApp, email, or M2B Portal anytime.',
            'zh' => '随时通过微信/WhatsApp、电子邮件 or M2B 客户门户获得快速专业的回复。',
            'ar' => 'استجابة سريعة عبر الواتساب، البريد الإلكتروني، أو بوابة M2B في أي وقت.'
          ],
          'stat' => '< 5 menit',
          'statLabel' => ['id' => 'Rata-rata waktu respons', 'en' => 'Average response time', 'zh' => '平均响应时间', 'ar' => 'متوسط وقت الاستجابة'],
          'wa_id' => 'Halo M2B',
          'wa_en' => 'Hello M2B',
          'wa_zh' => '您好M2B',
          'wa_ar' => 'مرحباً M2B'
        ],
        [
          'icon' => '🎯',
          'title' => ['id' => 'Dukungan Personal Sesuai Kebutuhan', 'en' => 'Personalized Support', 'zh' => '量身定制的专属顾问支持', 'ar' => 'دعم شخصي مخصص'],
          'desc' => [
            'id' => 'Setiap shipment ditangani konsultan dedikasi, bukan template generik.',
            'en' => 'Every shipment handled by a dedicated consultant, not a generic template.',
            'zh' => '每一票货物均由专属顾问跟进处理，非通用模板化服务。',
            'ar' => 'كل شحنة يتم التعامل معها بواسطة مستشار مخصص، وليس نموذجاً عاماً.'
          ],
          'stat' => '1 PIC',
          'statLabel' => ['id' => 'Untuk setiap klien & shipment', 'en' => 'Per client & shipment', 'zh' => '对接每位客户及每票货物', 'ar' => 'لكل عميل وشحنة'],
          'wa_id' => 'Halo M2B, saya butuh konsultan dedikasi',
          'wa_en' => 'Hello M2B, I need a dedicated consultant',
          'wa_zh' => '您好M2B，我需要一位专属的顾问服务。',
          'wa_ar' => 'مرحباً M2B، أحتاج إلى مستشار مخصص'
        ],
        [
          'icon' => '🛡',
          'title' => ['id' => 'Penanganan Barang Aman & Terjamin', 'en' => 'Safe & Secured Cargo Handling', 'zh' => '货物安全且有保障的装卸', 'ar' => 'مناولة بضائع آمنة ومضمونة'],
          'desc' => [
            'id' => 'Proteksi penuh dari gudang hingga tujuan akhir. Asuransi tersedia.',
            'en' => 'Full protection from warehouse to final destination. Insurance available.',
            'zh' => '从发货仓库到最终目的地的全方位保护。可提供货运保险。',
            'ar' => 'حماية كاملة من المستودع إلى الوجهة النهائية. التأمين متاح.'
          ],
          'stat' => '100%',
          'statLabel' => ['id' => 'Shipment terlindungi asuransi', 'en' => 'Shipments covered by insurance', 'zh' => '保价货物的保险覆盖率', 'ar' => 'شحنات مغطاة بالتأمين'],
          'wa_id' => 'Halo M2B, saya ingin info asuransi kargo',
          'wa_en' => 'Hello M2B, I would like cargo insurance info',
          'wa_zh' => '您好M2B，我想了解货运保险的相关信息。',
          'wa_ar' => 'مرحباً M2B، أرغب في معرفة معلومات تأمين البضائع'
        ]
      ];
      @endphp
      @foreach($features as $f)
      <div x-data="{ hov: false }" @mouseenter="hov=true" @mouseleave="hov=false"
        style="padding:26px 22px;border-radius:14px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);transition:all .25s;cursor:default;display:flex;flex-direction:column"
        :style="hov ? 'background:rgba(30,58,95,0.22);border-color:rgba(74,158,218,0.35);transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,0.3)' : ''">
        <div style="width:46px;height:46px;border-radius:12px;background:rgba(30,58,95,0.45);color:#4a9eda;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;margin-bottom:16px;transition:background .25s"
          :style="hov ? 'background:rgba(30,58,95,0.7)' : ''">{{ $f['icon'] }}</div>
        <div style="font-family:Syne;font-weight:700;font-size:16px;color:#fff;margin-bottom:8px" x-text="$store.lang.t('{{ $f['title']['id'] }}', '{{ $f['title']['en'] }}', '{{ $f['title']['zh'] }}', '{{ $f['title']['ar'] }}')">{{ $f['title']['id'] }}</div>
        <div style="font-size:13px;color:rgba(255,255,255,0.55);line-height:1.7;flex:1" x-text="$store.lang.t('{{ $f['desc']['id'] }}', '{{ $f['desc']['en'] }}', '{{ $f['desc']['zh'] }}', '{{ $f['desc']['ar'] }}')">{{ $f['desc']['id'] }}</div>
        <div x-show="hov" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
          style="margin-top:18px;padding-top:16px;border-top:1px solid rgba(74,158,218,0.25)">
          <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:12px">
            <span style="font-family:Syne;font-weight:800;font-size:26px;color:#4a9eda;line-height:1">{{ $f['stat'] }}</span>
            <span style="font-size:12px;color:rgba(255,255,255,0.4);line-height:1.3" x-text="$store.lang.t('{{ $f['statLabel']['id'] }}', '{{ $f['statLabel']['en'] }}', '{{ $f['statLabel']['zh'] }}', '{{ $f['statLabel']['ar'] }}')">{{ $f['statLabel']['id'] }}</span>
          </div>
          <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('{{ $f['wa_id'] }}', '{{ $f['wa_en'] }}', '{{ $f['wa_zh'] }}', '{{ $f['wa_ar'] }}'))" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:6px;padding:9px 14px;border-radius:8px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:12px" x-text="$store.lang.t('💬 Tanya Sekarang', '💬 Ask Now', '💬 立即咨询', '💬 استفسر الآن')">💬 Tanya Sekarang</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ ABOUT PREVIEW ═══ --}}
<section id="about" class="home-section" style="background:#fff;border-top:1px solid #e5e2dc">
  <div class="home-about-grid" style="max-width:1100px;margin:0 auto;align-items:center">
    <div style="position:relative">
      <div style="border-radius:16px;overflow:hidden;aspect-ratio:4/5;border:1px solid #e5e2dc;box-shadow:0 16px 48px rgba(0,0,0,0.12);position:relative">
        <picture style="display:block;width:100%;height:100%">
          <source srcset="{{ asset('images/director-eka.webp') }}" type="image/webp">
          <img src="{{ asset('images/director-eka.jpg') }}" alt="Eka Mayang Sari Harahap, S.E." style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block">
        </picture>
        <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top,rgba(11,17,32,0.8),transparent);padding:20px 18px 16px">
          <div style="font-family:Syne;font-weight:800;font-size:14px;color:#fff">Eka Mayang Sari Harahap, S.E.</div>
          <div style="font-size:11px;color:rgba(255,255,255,0.7)" x-text="$store.lang.t('Direktur — PT. Mora Multi Berkah', 'Director — PT. Mora Multi Berkah', '董事长 — PT. Mora Multi Berkah', 'المدير — PT. Mora Multi Berkah')">Direktur — PT. Mora Multi Berkah</div>
        </div>
      </div>
    </div>
    <div>
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('Tentang Kami', 'About Us', '关于我们', 'من نحن')">Tentang Kami</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:32px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:18px;line-height:1.2">
        <span x-show="lang==='id'">Freight Forwarder & Jasa Logistik<br><span style="color:#1e3a5f">Terpercaya di Indonesia.</span></span>
        <span x-show="lang==='en'" x-cloak>Trusted Freight Forwarder &<br><span style="color:#1e3a5f">Logistics Partner in Indonesia.</span></span>
        <span x-show="lang==='zh'" x-cloak>印尼值得信赖的<br><span style="color:#1e3a5f">货运代理与物流合作伙伴。</span></span>
        <span x-show="lang==='ar'" x-cloak>وكيل شحن وشريك لوجستي<br><span style="color:#1e3a5f">موثوق به في إندونيسيا.</span></span>
      </h2>
      <p style="font-size:15px;color:#555;line-height:1.85;margin-bottom:18px">
        <span x-show="lang==='id'">Kami adalah perusahaan <strong>freight forwarder</strong> sekaligus <strong>PPJK</strong> yang berbasis di Medan, Sumatera Utara — Indonesia. Kami menyediakan layanan logistik ekspor-impor secara menyeluruh, mulai dari pengurusan dokumen, customs clearance, hingga pengiriman barang ke berbagai destinasi nasional maupun internasional.</span>
        <span x-show="lang==='en'" x-cloak>We are a <strong>freight forwarding</strong> and <strong>PPJK</strong> company based in Medan, North Sumatra — Indonesia. We provide comprehensive export-import logistics services, from document processing and customs clearance to cargo delivery across domestic and international destinations.</span>
        <span x-show="lang==='zh'" x-cloak>我们是一家总部位于印尼苏门答腊省棉兰市的<strong>货运代理</strong>与<strong>报关（PPJK）</strong>公司。我们提供全方位的进出口物流服务，包括单证处理、海关清关，以及向印尼国内及全球各目的地的货物运输。</span>
        <span x-show="lang==='ar'" x-cloak>نحن شركة <strong>شحن</strong> و <strong>تخليص جمركي (PPJK)</strong> مقرها في ميدان، شمال سومطرة — إندونيسيا. نحن نقدم خدمات لوجستية شاملة للاستيراد والتصدير، بدءاً من معالجة المستندات والتخليص الجمركي إلى تسليم البضائع إلى مختلف الوجهات المحلية والدولية.</span>
      </p>
      <p style="font-size:15px;color:#555;line-height:1.85;margin-bottom:24px">
        <span x-show="lang==='id'">Kami hadir untuk membantu UMKM maupun perusahaan besar dengan solusi logistik yang andal dan terukur sesuai kebutuhan Anda.</span>
        <span x-show="lang==='en'" x-cloak>We support both SMEs and large corporations with reliable, scalable logistics solutions tailored to your business needs.</span>
        <span x-show="lang==='zh'" x-cloak>我们致力于为中小企业及大型企业提供可靠、可定制的物流解决方案，满足您的不同业务需求。</span>
        <span x-show="lang==='ar'" x-cloak>نحن هنا لمساعدة الشركات الصغيرة والمتوسطة وكذلك الشركات الكبرى بحلول لوجستية موثوقة وقابلة للتطوير وفقاً لاحتياجاتك.</span>
      </p>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px">
        @php
        $aboutStats = [
          ['🏆', '5+ Tahun', ['id' => 'Berpengalaman', 'en' => 'Years of Exp.', 'zh' => '年行业经验', 'ar' => 'سنوات خبرة']],
          ['🌍', '20+', ['id' => 'Negara Tujuan', 'en' => 'Destinations', 'zh' => '覆盖国家/地区', 'ar' => 'وجهات شحن']],
          ['🤝', '100+', ['id' => 'Klien Aktif', 'en' => 'Active Clients', 'zh' => '活跃客户', 'ar' => 'عملاء نشطين']]
        ];
        @endphp
        @foreach($aboutStats as $stat)
        <div style="padding:14px 16px;border-radius:8px;border:1px solid #e5e2dc;background:#fafaf8">
          <div style="font-size:18px;margin-bottom:4px">{{ $stat[0] }}</div>
          <div style="font-family:Syne;font-weight:800;font-size:16px;color:#1e3a5f">{{ $stat[1] }}</div>
          <div style="font-size:11px;color:#888" x-text="$store.lang.t('{{ $stat[2]['id'] }}', '{{ $stat[2]['en'] }}', '{{ $stat[2]['zh'] }}', '{{ $stat[2]['ar'] }}')">{{ $stat[2]['id'] }}</div>
        </div>
        @endforeach
      </div>
      <a href="{{ route('about') }}" style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:14px" x-text="$store.lang.t('Selengkapnya →', 'Learn More →', '了解更多 →', 'تفاصيل أكثر ←')">Selengkapnya →</a>
    </div>
  </div>
</section>

{{-- ═══ QUICK QUOTE ESTIMATOR ═══ --}}
<section class="home-section" style="background:#0f0f14" x-data="{
  step: 1,
  service: '',
  origin: '',
  dest: '',
  weight: '',
  getLabel: function(s) {
    const l = Alpine.store('lang').current;
    const labels = {
      'export': { id: '📤 Export Handling', en: '📤 Export Handling', zh: '📤 出口代理服务', ar: '📤 تخليص الصادرات' },
      'import': { id: '📥 Import Handling', en: '📥 Import Handling', zh: '📥 进口代理服务', ar: '📥 تخليص الواردات' },
      'customs': { id: '🛃 Customs Clearance', en: '🛃 Customs Clearance', zh: '🛃 报关清关服务', ar: '🛃 التخليص الجمركي' },
      'door': { id: '🚚 Door-to-Door', en: '🚚 Door-to-Door', zh: '🚚 双清门到门', ar: '🚚 من الباب إلى الباب' }
    };
    return (labels[s] ? labels[s][l] : s);
  }
}">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.3);color:#4a9eda;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('Estimasi Gratis', 'Free Estimator', '免费估算', 'حاسبة تقديرية')">Free Estimator</span>
    <h2 style="font-family:Syne;font-weight:800;font-size:34px;color:#fff;letter-spacing:-0.8px;margin-top:12px;margin-bottom:8px" x-text="$store.lang.t('Estimasi Biaya Logistik', 'Logistics Cost Estimator', '物流费用估算', 'حاسبة تكاليف اللوجستيات')">Estimasi Biaya Logistik</h2>
    <p style="color:rgba(255,255,255,0.5);font-size:15px;margin-bottom:40px" x-text="$store.lang.t('Pilih layanan dan kami akan bantu estimasi kebutuhan Anda via WhatsApp — gratis, cepat, tanpa komitmen.', 'Select a service and we\'ll estimate your needs via WhatsApp — free, fast, no commitment.', '选择一项服务，我们将通过微信/WhatsApp帮您估算需求——免费、快速、无约束。', 'اختر خدمة وسنساعدك في تقدير احتياجاتك عبر الواتساب — مجاني، سريع، وبدون التزامات.')">Pilih layanan dan kami akan bantu estimasi kebutuhan Anda via WhatsApp — gratis, cepat, tanpa komitmen.</p>

    {{-- Step 1: Pilih Layanan --}}
    <div x-show="step === 1">
      <div style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:20px;font-weight:600;text-transform:uppercase;letter-spacing:1px" x-text="$store.lang.t('Langkah 1 dari 3 — Pilih Layanan', 'Step 1 of 3 — Select Service', '第 1 步（共 3 步）— 选择服务', 'الخطوة ١ من ٣ — اختر الخدمة')">Langkah 1 dari 3 — Pilih Layanan</div>
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;max-width:520px;margin:0 auto 28px">
        @php
        $estimatorServices = [
          'export'  => ['📤', ['id' => 'Export Handling', 'en' => 'Export Handling', 'zh' => '出口代理服务', 'ar' => 'تخليص الصادرات'], ['id' => 'PEB, COO/SKA, ke 20+ negara', 'en' => 'PEB, COO/SKA, to 20+ countries', 'zh' => '报关(PEB)、原产地证，至20多国', 'ar' => 'إعلان الصادرات، شهادة المنشأ، إلى ٢٠+ دولة']],
          'import'  => ['📥', ['id' => 'Import Handling', 'en' => 'Import Handling', 'zh' => '进口代理服务', 'ar' => 'تخليص الواردات'], ['id' => 'PIB, kalkulasi bea & pajak', 'en' => 'PIB, duties & taxes calculation', 'zh' => '报关(PIB)、关税与税费估算', 'ar' => 'إعلان الواردات، حساب الرسوم والضرائب']],
          'customs' => ['🛃', ['id' => 'Customs Clearance', 'en' => 'Customs Clearance', 'zh' => '报关清关服务', 'ar' => 'التخليص الجمركي'], ['id' => 'Belawan, Priok, Perak', 'en' => 'Belawan, Priok, Perak ports', 'zh' => '棉兰、雅加达、泗水主要港口', 'ar' => 'موانئ بيلاوان، بريوك، بيراك']],
          'door'    => ['🚚', ['id' => 'Door-to-Door', 'en' => 'Door-to-Door', 'zh' => '双清门到门', 'ar' => 'من الباب إلى الباب'], ['id' => 'Gudang pengirim → pintu penerima', 'en' => 'Shipper warehouse → recipient door', 'zh' => '发货人仓库 → 收货人门口', 'ar' => 'مستودع المرسل ← باب المستلم']],
        ];
        @endphp
        @foreach($estimatorServices as $val => $info)
        <button @click="service = '{{ $val }}'; step = 2"
          :class="service === '{{ $val }}' ? 'estimator-btn active' : 'estimator-btn'">
          <div class="estimator-btn-icon-wrapper">
            <span>{{ $info[0] }}</span>
          </div>
          <span style="font-family:Syne;font-weight:700;font-size:14px;display:block" x-text="$store.lang.t('{{ $info[1]['id'] }}', '{{ $info[1]['en'] }}', '{{ $info[1]['zh'] }}', '{{ $info[1]['ar'] }}')">{{ $info[1]['id'] }}</span>
          <span style="font-size:11px;color:rgba(255,255,255,0.45);display:block;line-height:1.4" x-text="$store.lang.t('{{ $info[2]['id'] }}', '{{ $info[2]['en'] }}', '{{ $info[2]['zh'] }}', '{{ $info[2]['ar'] }}')">{{ $info[2]['id'] }}</span>
        </button>
        @endforeach
      </div>
    </div>

    {{-- Step 2: Origin & Destination --}}
    <div x-show="step === 2">
      <div style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:16px;font-weight:600;text-transform:uppercase;letter-spacing:1px" x-text="$store.lang.t('Langkah 2 dari 3 — Rute Pengiriman', 'Step 2 of 3 — Shipping Route', '第 2 步（共 3 步）— 运输路线', 'الخطوة ٢ من ٣ — مسار الشحن')">Langkah 2 dari 3 — Rute Pengiriman</div>
      <div class="home-route-inputs" style="max-width:480px;margin:0 auto 20px">
        <div>
          <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-bottom:6px;text-align:left" x-text="$store.lang.t('Asal / Origin', 'Origin', '出发地 (Origin)', 'المصدر / المنشأ')">Asal / Origin</div>
          <input x-model="origin" type="text" :placeholder="$store.lang.t('Mis: Medan, Jakarta', 'e.g. Medan, Jakarta', '例如：棉兰、雅加达', 'مثال: ميدان، جاكرتا')" style="width:100%;padding:12px 14px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.08);color:#fff;font-size:14px;font-family:\'DM Sans\';outline:none" onfocus="this.style.borderColor=\'#4a9eda\'" onblur="this.style.borderColor=\'rgba(255,255,255,0.15)\'">
        </div>
        <div>
          <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-bottom:6px;text-align:left" x-text="$store.lang.t('Tujuan / Destination', 'Destination', '目的地 (Destination)', 'الوجهة / المقصد')">Tujuan / Destination</div>
          <input x-model="dest" type="text" :placeholder="$store.lang.t('Mis: Singapura, China', 'e.g. Singapore, China', '例如：新加坡、中国', 'مثال: سنغافورة، الصين')" style="width:100%;padding:12px 14px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.08);color:#fff;font-size:14px;font-family:\'DM Sans\';outline:none" onfocus="this.style.borderColor=\'#4a9eda\'" onblur="this.style.borderColor=\'rgba(255,255,255,0.15)\'">
        </div>
      </div>
      <div style="display:flex;gap:12px;justify-content:center;max-width:480px;margin:0 auto">
        <button @click="step = 1" style="padding:12px 20px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.2);background:transparent;color:#fff;cursor:pointer;font-family:\'DM Sans\';font-size:14px" x-text="$store.lang.t('← Kembali', '← Back', '← 返回', '← عودة')">← Kembali</button>
        <button @click="if(origin && dest) step = 3" style="flex:1;padding:12px;border-radius:8px;background:#1e3a5f;color:#fff;border:none;cursor:pointer;font-family:\'DM Sans\';font-size:14px;font-weight:700" x-text="$store.lang.t('Lanjut →', 'Next →', '下一步 →', 'التالي ←')">Lanjut →</button>
      </div>
    </div>

    {{-- Step 3: Weight + Final CTA --}}
    <div x-show="step === 3">
      <div style="font-size:13px;color:rgba(255,255,255,0.5);margin-bottom:16px;font-weight:600;text-transform:uppercase;letter-spacing:1px" x-text="$store.lang.t('Langkah 3 dari 3 — Estimasi Muatan', 'Step 3 of 3 — Cargo Estimate', '第 3 步（共 3 步）— 货物估算', 'الخطوة ٣ من ٣ — تقدير الشحنة')">Langkah 3 dari 3 — Estimasi Muatan</div>
      <div style="max-width:480px;margin:0 auto">
        <div style="margin-bottom:20px">
          <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-bottom:6px;text-align:left" x-text="$store.lang.t('Berat / Volume Kargo (opsional)', 'Cargo Weight / Volume (optional)', '货物重量 / 体积（选填）', 'وزن / حجم الشحنة (اختياري)')">Berat / Volume Kargo (opsional)</div>
          <input x-model="weight" type="text" :placeholder="$store.lang.t('Mis: 500 kg, 1 FCL 20ft, 2 CBM', 'e.g. 500 kg, 1 FCL 20ft, 2 CBM', '例如：500公斤、20尺柜、2 CBM', 'مثال: ٥٠٠ كجم، حاوية ٢٠ قدم، ٢ CBM')" style="width:100%;padding:12px 14px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.08);color:#fff;font-size:14px;font-family:\'DM Sans\';outline:none" onfocus="this.style.borderColor=\'#4a9eda\'" onblur="this.style.borderColor=\'rgba(255,255,255,0.15)\'">
        </div>
        <div style="background:rgba(30,58,95,0.3);border:1px solid rgba(30,58,95,0.5);border-radius:12px;padding:16px;margin-bottom:20px;text-align:left">
          <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-bottom:8px;font-weight:600" x-text="$store.lang.t('RINGKASAN REQUEST', 'REQUEST SUMMARY', '申请信息摘要', 'ملخص الطلب')">RINGKASAN REQUEST</div>
          <div style="font-size:14px;color:#fff"><span x-text="$store.lang.t('🎯 Layanan: ', '🎯 Service: ', '🎯 服务项目：', '🎯 الخدمة: ')">🎯 Layanan: </span><strong x-text="getLabel(service)"></strong></div>
          <div style="font-size:14px;color:#fff;margin-top:4px"><span x-text="$store.lang.t('🗺️ Rute: ', '🗺️ Route: ', '🗺️ 路线：', '🗺️ المسار: ')">🗺️ Rute: </span><strong x-text="origin + ' → ' + dest"></strong></div>
          <div x-show="weight" style="font-size:14px;color:#fff;margin-top:4px"><span x-text="$store.lang.t('⚖️ Muatan: ', '⚖️ Cargo: ', '⚖️ 货物信息：', '⚖️ الشحنة: ')">⚖️ Muatan: </span><strong x-text="weight"></strong></div>
        </div>
        <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent(
          $store.lang.t(
            'Halo M2B, saya ingin estimasi biaya untuk:\n- Layanan: ' + getLabel(service) + '\n- Rute: ' + origin + ' → ' + dest + (weight ? '\n- Muatan: ' + weight : '') + '\n\nMohon bantu estimasi dan quote-nya ya. Terima kasih.',
            'Hello M2B, I would like a cost estimate for:\n- Service: ' + getLabel(service) + '\n- Route: ' + origin + ' → ' + dest + (weight ? '\n- Cargo: ' + weight : '') + '\n\nPlease help with the estimation and quote. Thank you.',
            '您好M2B，我想获取以下服务的费用估算：\n- 服务类型：' + getLabel(service) + '\n- 运输路线：' + origin + ' → ' + dest + (weight ? '\n- 货物规格：' + weight : '') + '\n\n请协助提供估算和报价。谢谢！',
            'مرحباً M2B، أرغب في الحصول على تقدير تكلفة لـ:\n- الخدمة: ' + getLabel(service) + '\n- المسار: ' + origin + ' → ' + dest + (weight ? '\n- الشحنة: ' + weight : '') + '\n\nيرجى المساعدة في التقدير وعرض الأسعار. شكراً لك.'
          )
        )"
          target="_blank"
          style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:16px;border-radius:10px;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:16px;margin-bottom:12px">
          <span x-text="$store.lang.t('💬 Kirim ke WhatsApp & Minta Quote', '💬 Send to WhatsApp & Request Quote', '💬 发送至微信/WhatsApp并获取报价', '💬 الإرسال إلى الواتساب وطلب عرض أسعار')">💬 Kirim ke WhatsApp & Minta Quote</span>
        </a>
        <button @click="step = 2" style="width:100%;padding:12px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.2);background:transparent;color:rgba(255,255,255,0.6);cursor:pointer;font-family:\'DM Sans\';font-size:14px" x-text="$store.lang.t('← Edit Rute', '← Edit Route', '← 修改路线', '← تعديل المسار')">← Edit Rute</button>
      </div>
    </div>

    {{-- Progress indicators --}}
    <div style="display:flex;justify-content:center;gap:8px;margin-top:32px">
      @for($n = 1; $n <= 3; $n++)
      <div :style="step >= {{ $n }} ? 'background:#4a9eda;width:24px' : 'background:rgba(255,255,255,0.15);width:8px'" style="height:4px;border-radius:4px;transition:all .3s"></div>
      @endfor
    </div>
  </div>
</section>

{{-- ═══ FAQ ═══ --}}
<section class="home-section" style="background:#f7f5f0;border-top:1px solid #e5e2dc">
  <div style="max-width:780px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('FAQ', 'FAQ', '常见问题', 'الأسئلة الشائعة')">FAQ</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:34px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px" x-text="$store.lang.t('Pertanyaan yang Sering Diajukan', 'Frequently Asked Questions', '常见问题解答', 'الأسئلة الشائعة')">Pertanyaan yang Sering Diajukan</h2>
      <p style="color:#666;font-size:15px" x-text="$store.lang.t('Semua yang ingin Anda tahu tentang layanan ekspor-impor M2B.', 'Everything you want to know about M2B export-import services.', '您想了解的关于 M2B 进出口服务的一切。', 'كل ما تريد معرفته عن خدمات الاستيراد والتصدير من M2B.')">Semua yang ingin Anda tahu tentang layanan ekspor-impor M2B.</p>
    </div>
    <div x-data="{ open: null }">
      @php
      $faqs = [
        [
          'q' => [
            'id' => 'Berapa estimasi biaya customs clearance di M2B?',
            'en' => 'How much does customs clearance cost at M2B?',
            'zh' => 'M2B 的报关清关服务费用大概是多少？',
            'ar' => 'ما هي تكلفة التخليص الجمركي في M2B؟'
          ],
          'a' => [
            'id' => 'Biaya customs clearance bervariasi tergantung HS Code, nilai barang, dan jenis jalur (hijau/merah). M2B memberikan kalkulasi transparan termasuk bea masuk, PPN, PPh 22, dan handling fee — tanpa hidden cost. Hubungi kami untuk quote gratis.',
            'en' => 'Customs clearance fees vary depending on the HS Code, cargo value, and inspection lane (green/red). M2B provides transparent calculations including import duty, VAT, PPh 22, and handling fees — no hidden costs. Contact us for a free quote.',
            'zh' => '报关费用取决于海关编码（HS Code）、货物价值以及查验通道（绿道/红道）。M2B 提供透明的计算，包括进口税、增值税、所得税（PPh 22）及操作手续费——绝无隐藏费用。请联系我们获取免费报价。',
            'ar' => 'تختلف رسوم التخليص الجمركي حسب رمز النظام المنسق (HS Code)، وقيمة البضاعة، ومسار الفحص (أخضر/أحمر). تقدم M2B حسابات شفافة تشمل الرسوم الجمركية، وضريبة القيمة المضافة، وضريبة الدخل 22، ورسوم المناولة — بدون تكاليف خفية. اتصل بنا للحصول على عرض أسعار مجاني.'
          ]
        ],
        [
          'q' => [
            'id' => 'Apakah M2B bisa mengurus impor untuk UMKM yang belum punya API?',
            'en' => 'Can M2B handle imports for SMEs without an Import License (API)?',
            'zh' => 'M2B 能否为还没有进口资质（API）的中小企业办理进口？',
            'ar' => 'هل يمكن لـ M2B التعامل مع الواردات للمشاريع الصغيرة والمتوسطة التي ليس لديها رخصة استيراد (API)؟'
          ],
          'a' => [
            'id' => 'Ya! Kami menyediakan layanan Undername Import khusus untuk importir yang belum memiliki Angka Pengenal Impor (API). 100% legal — M2B bertindak sebagai importir of record, sementara Anda tetap pemilik sah barang.',
            'en' => 'Yes! We offer Undername Import services specifically for importers without an API (Import Registration Number). 100% legal — M2B acts as the importer of record, while you remain the legal owner of the goods.',
            'zh' => '是的！我们专门为没有进口许可证（API）的进口商提供买单进口（Undername）服务。100%合规合法——M2B 作为名义进口商，而您仍是货物的合法所有者。',
            'ar' => 'نعم! نحن نقدم خدمات الاستيراد باسم الغير (Undername Import) خصيصاً للمستوردين الذين ليس لديهم رخصة استيراد (API). قانوني ١٠٠٪ — تعمل M2B كمستورد مسجل، بينما تظل أنت المالك القانوني للبضائع.'
          ]
        ],
        [
          'q' => [
            'id' => 'Berapa lama proses customs clearance di Pelabuhan Belawan?',
            'en' => 'How long does customs clearance take at Belawan Port?',
            'zh' => '在棉兰 Belawan 港口清关需要多长时间？',
            'ar' => 'كم من الوقت يستغرق التخليص الجمركي في ميناء بيلاوان؟'
          ],
          'a' => [
            'id' => 'Rata-rata 1–3 hari kerja untuk jalur hijau. Jalur merah bisa 3–7 hari tergantung kompleksitas pemeriksaan. M2B memiliki akses langsung ke sistem CEISA 4.0 dan relasi kuat di pelabuhan Belawan, Tanjung Priok, dan Tanjung Perak.',
            'en' => 'Average 1–3 working days for the green lane. Red lane can take 3–7 days depending on inspection complexity. M2B has direct access to the CEISA 4.0 system and strong relationships at Belawan, Tanjung Priok, and Tanjung Perak ports.',
            'zh' => '绿色通道平均为 1-3 个工作日。红色通道查验可能需要 3-7 天，具体取决于检查的复杂程度。M2B 直接对接 CEISA 4.0 系统，并在 Belawan、Tanjung Priok 和 Tanjung Perak 港口拥有强大的关务协作关系。',
            'ar' => 'المتوسط ١-٣ أيام عمل للمسار الأخضر. يمكن أن يستغرق المسار الأحمر من ٣-٧ أيام حسب تعقيد الفحص. تتمتع M2B بالوصول المباشر إلى نظام CEISA 4.0 وعلاقات قوية في موانئ بيلاوان، وتانجونغ بريوك، وتانجونغ بيراك.'
          ]
        ],
        [
          'q' => [
            'id' => 'Dokumen apa saja yang diperlukan untuk ekspor?',
            'en' => 'What documents are required for export?',
            'zh' => '出口需要准备哪些单证文件？',
            'ar' => 'ما هي المستندات المطلوبة للتصدير؟'
          ],
          'a' => [
            'id' => 'Untuk ekspor standar: Commercial Invoice, Packing List, Bill of Lading/AWB, dan COO/SKA (Certificate of Origin) jika diperlukan negara tujuan. M2B membantu menyiapkan dan memverifikasi semua dokumen hingga PEB (Pemberitahuan Ekspor Barang).',
            'en' => 'For standard export: Commercial Invoice, Packing List, Bill of Lading/AWB, and COO/SKA (Certificate of Origin) if required by the destination country. M2B helps prepare and verify all documents up to the PEB (Export Customs Declaration).',
            'zh' => '标准出口需要：商业发票、装箱单、海运提单/空运单，以及目的国要求的原产地证（COO/SKA）。M2B 协助准备并审核所有文件，直至完成出口申报（PEB）。',
            'ar' => 'للتصدير القياسي: الفاتورة التجارية، قائمة التعبئة، بوليصة الشحن/AWB، وشهادة المنشأ (COO/SKA) إذا كان بلد المقصد يتطلب ذلك. تساعد M2B في إعداد والتحقق من جميع المستندات حتى إعلان الصادرات (PEB).'
          ]
        ],
        [
          'q' => [
            'id' => 'Apakah M2B menyediakan layanan door-to-door ke luar negeri?',
            'en' => 'Does M2B provide door-to-door service overseas?',
            'zh' => 'M2B 是否提供海外双清门到门服务？',
            'ar' => 'هل تقدم M2B خدمة من الباب إلى الباب في الخارج؟'
          ],
          'a' => [
            'id' => 'Ya! Kami melayani door-to-door ke 25+ negara — dari pickup di gudang Anda, customs clearance di Indonesia, pengiriman internasional, customs di negara tujuan, hingga last-mile delivery. Satu PIC dari awal hingga akhir.',
            'en' => 'Yes! We serve door-to-door to 25+ countries — from pickup at your warehouse, customs clearance in Indonesia, international shipping, customs at the destination, to last-mile delivery. One dedicated PIC from start to finish.',
            'zh' => '是的！我们为前往全球25多个国家提供门到门服务——从您仓库提货、印尼出口报关、国际段运输、目的国进口清关，直至最后一公里派送。全程由单一专人（PIC）跟单服务。',
            'ar' => 'نعم! نحن نخدم من الباب إلى الباب إلى ٢٥+ دولة — بدءاً من الاستلام من مستودعك، والتخليص الجمركي في إندونيسيا، والشحن الدولي، والجمارك في بلد المقصد، إلى التسليم النهائي. مسؤول اتصال واحد من البداية إلى النهاية.'
          ]
        ],
        [
          'q' => [
            'id' => 'Bagaimana cara melacak status shipment saya?',
            'en' => 'How do I track my shipment status?',
            'zh' => '如何跟踪我的货物状态？',
            'ar' => 'كيف يمكنني تتبع حالة شحنتي؟'
          ],
          'a' => [
            'id' => 'Anda dapat menghubungi langsung tim M2B via WhatsApp (+62 812-6302-7818) untuk update real-time status shipment. Tim kami merespons dalam hitungan menit selama jam operasional (Senin–Sabtu, 08.00–17.00 WIB).',
            'en' => 'Contact the M2B team directly via WhatsApp (+62 812-6302-7818) for real-time shipment updates. Our team responds within minutes during business hours (Monday–Saturday, 08:00–17:00 WIB).',
            'zh' => '您可以在工作时间（周一至周六，印尼西部时间 08:00-17:00）直接通过微信/WhatsApp（+62 812-6302-7818）联系 M2B 团队以获取货物的实时状态更新，我们的团队会在几分钟内进行回复。',
            'ar' => 'اتصل بفريق M2B مباشرة عبر الواتساب (+62 812-6302-7818) للحصول على تحديثات الشحنة في الوقت الفعلي. يستجيب فريقنا خلال دقائق خلال ساعات العمل (الإثنين–السبت، 08:00–17:00 بتوقيت غرب إندونيسيا).'
          ]
        ]
      ];
      @endphp
      @foreach($faqs as $i => $faq)
      <div style="border-bottom:1px solid #e5e2dc;padding:4px 0">
        <button @click="open = open === {{ $i }} ? null : {{ $i }}"
          style="width:100%;text-align:left;padding:20px 0;background:transparent;border:none;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px;font-family:\'DM Sans\',sans-serif">
          <span style="font-family:Syne;font-weight:700;font-size:16px;color:#0f0f14;line-height:1.4" x-text="$store.lang.t('{{ addslashes($faq['q']['id']) }}', '{{ addslashes($faq['q']['en']) }}', '{{ addslashes($faq['q']['zh']) }}', '{{ addslashes($faq['q']['ar']) }}')">{{ $faq['q']['id'] }}</span>
          <span :style="open === {{ $i }} ? 'transform:rotate(45deg)' : ''" style="flex-shrink:0;width:28px;height:28px;border-radius:50%;background:rgba(30,58,95,0.1);display:flex;align-items:center;justify-content:center;font-size:16px;color:#1e3a5f;transition:transform .2s;font-weight:700">+</span>
        </button>
        <div x-show="open === {{ $i }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100" style="padding:0 0 20px">
          <p style="font-size:15px;color:#555;line-height:1.8;padding:16px 20px;background:#fff;border-radius:10px;border-left:3px solid #1e3a5f">
            <span x-text="$store.lang.t('{{ addslashes($faq['a']['id']) }}', '{{ addslashes($faq['a']['en']) }}', '{{ addslashes($faq['a']['zh']) }}', '{{ addslashes($faq['a']['ar']) }}')">{{ $faq['a']['id'] }}</span>
          </p>
          @if($i === 0)
          <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('Halo M2B, saya minta quote customs clearance', 'Hello M2B, I would like a customs clearance quote', '您好M2B，我想申请一份清关报价。', 'مرحباً M2B، أرغب في الحصول على عرض أسعار للتخليص الجمركي.'))" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;font-size:13px;color:#25D366;font-weight:600;text-decoration:none" x-text="$store.lang.t('💬 Minta Quote Sekarang →', '💬 Request Quote Now →', '💬 立即获取报价 →', '💬 اطلب عرض أسعار الآن ←')">💬 Minta Quote Sekarang →</a>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    <div style="margin-top:36px;text-align:center">
      <p style="color:#777;font-size:14px;margin-bottom:16px" x-text="$store.lang.t('Pertanyaan lain? Tim M2B siap membantu.', 'Have other questions? The M2B team is ready to help.', '还有其他问题？M2B 团队随时为您提供帮助。', 'هل لديك أسئلة أخرى؟ فريق M2B مستعد للمساعدة.')">Pertanyaan lain? Tim M2B siap membantu.</p>
      <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('Halo M2B, saya punya pertanyaan', 'Hello M2B, I have a question', '您好M2B，我还有其他疑问。', 'مرحباً M2B، لدي استفسار آخر'))" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:14px" x-text="$store.lang.t('💬 Tanya via WhatsApp', '💬 Ask via WhatsApp', '💬 通过微信/WhatsApp咨询', '💬 اسأل عبر الواتساب')">💬 Tanya via WhatsApp</a>
    </div>
  </div>
</section>

{{-- ═══ TESTIMONIALS ═══ --}}
<section class="home-section" style="background:#fff;border-top:1px solid #e5e2dc">
  <div style="max-width:1200px;margin:0 auto">
    <div style="text-align:center;margin-bottom:48px">
      <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('Testimoni', 'Testimonials', '客户评价', 'آراء العملاء')">Testimoni</span>
      <h2 style="font-family:Syne;font-weight:800;font-size:34px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:12px" x-text="$store.lang.t('Dipercaya Ratusan Klien', 'Trusted by Hundreds of Clients', '赢得数百家客户的信赖', 'موثوق به من مئات العملاء')">Dipercaya Ratusan Klien</h2>
      <p style="color:#666" x-text="$store.lang.t('Dari UKM hingga perusahaan ekspor skala besar.', 'From SMEs to large-scale export companies.', '涵盖中小型跨境商户到大型出口集团。', 'من الشركات الصغيرة والمتوسطة إلى شركات التصدير واسعة النطاق.')">Dari UKM hingga perusahaan ekspor skala besar.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px" class="home-testimonials-grid">
      @php
      $testimonials = [
        [
          'name' => 'Edy Serdawanto',
          'title' => ['id' => 'Direktur — PT. Dira Baraka Mulia', 'en' => 'Director — PT. Dira Baraka Mulia', 'zh' => '董事长 — PT. Dira Baraka Mulia', 'ar' => 'مدير — PT. Dira Baraka Mulia'],
          'quote' => [
            'id' => '"Penanganan impor dengan biaya yang jelas dan terukur, tepat waktu. Sangat layak menjadi rekan bisnis Anda."',
            'en' => '"Import handling with clear, measurable costs and on-time delivery. Very worthy of being your business partner."',
            'zh' => '"进口操作费用清晰透明、交货准时，非常值得信赖的商业合作伙伴。"',
            'ar' => '"مناولة واردات بتكاليف واضحة ومدروسة، وفي الوقت المحدد. تستحق بجدارة أن تكون شريكك التجاري."'
          ]
        ],
        [
          'name' => 'Mr. Jhonson',
          'title' => ['id' => 'GM — Anhui Imp & Export Co., Ltd', 'en' => 'GM — Anhui Imp & Export Co., Ltd', 'zh' => '总经理 — 安徽进出口有限公司', 'ar' => 'المدير العام — شركة آنهوي للاستيراد والتصدير المحدودة'],
          'quote' => [
            'id' => '"Game-changer bagi bisnis kami! Tim di M2B sangat andal, efisien, dan selalu responsif."',
            'en' => '"Game-changer for our business! The team at M2B is reliable, efficient, and always responsive."',
            'zh' => '"这是我们业务的变革者！M2B 的团队非常可靠、高效，且始终能快速响应。"',
            'ar' => '"نقلة نوعية لعملنا! الفريق في M2B موثوق وفعال ومتجاوب دائماً."'
          ]
        ],
        [
          'name' => 'Sarah Aulia',
          'title' => ['id' => 'Online Business Owner — Medan', 'en' => 'Online Business Owner — Medan', 'zh' => '电商主 — 棉兰', 'ar' => 'صاحبة عمل تجاري عبر الإنترنت — ميدان'],
          'quote' => [
            'id' => '"Tim M2B sangat suportif dan transparan. Tidak ada biaya tersembunyi — ini yang kami cari."',
            'en' => '"M2B team is very supportive and transparent. No hidden fees — exactly what we were looking for."',
            'zh' => '"M2B 团队非常给予支持且高度透明。没有任何隐藏费用——这正是我们所寻找的。"',
            'ar' => '"فريق M2B متعاون وشفاف للغاية. لا توجد رسوم خفية — هذا بالضبط ما كنا نبحث عنه."'
          ]
        ]
      ];
      @endphp
      @foreach($testimonials as $t)
      <div style="background:#f7f5f0;border-radius:12px;padding:28px 24px;border:1px solid #e5e2dc">
        <div style="color:#f5b91c;font-size:18px;margin-bottom:12px">★★★★★</div>
        <p style="font-size:14px;color:#444;line-height:1.75;margin-bottom:20px;font-style:italic" x-text="$store.lang.t('{{ addslashes($t['quote']['id']) }}', '{{ addslashes($t['quote']['en']) }}', '{{ addslashes($t['quote']['zh']) }}', '{{ addslashes($t['quote']['ar']) }}')">{{ $t['quote']['id'] }}</p>
        <div style="display:flex;gap:10px;align-items:center">
          <div style="width:40px;height:40px;border-radius:50%;background:rgba(30,58,95,0.1);border:2px solid rgba(30,58,95,0.2);display:flex;align-items:center;justify-content:center;font-family:Syne;font-weight:800;color:#1e3a5f;font-size:16px">{{ substr($t['name'],0,1) }}</div>
          <div>
            <div style="font-weight:700;font-size:14px">{{ $t['name'] }}</div>
            <div style="font-size:12px;color:#999" x-text="$store.lang.t('{{ $t['title']['id'] }}', '{{ $t['title']['en'] }}', '{{ $t['title']['zh'] }}', '{{ $t['title']['ar'] }}')">{{ $t['title']['id'] }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ LATEST BLOG ═══ --}}
@if($latestPosts->count() > 0)
<section id="berita" class="home-section" style="background:#fff;border-top:1px solid #e5e2dc">
  <div style="max-width:1200px;margin:0 auto">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:32px;flex-wrap:wrap;gap:16px">
      <div>
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;background:rgba(30,58,95,0.1);color:#1e3a5f;font-size:11px;font-weight:600;letter-spacing:0.3px;text-transform:uppercase" x-text="$store.lang.t('Artikel Terbaru', 'Latest Articles', '最新文章', 'أحدث المقالات')">Artikel Terbaru</span>
        <h2 style="font-family:Syne;font-weight:800;font-size:34px;letter-spacing:-0.8px;margin-top:12px;margin-bottom:6px" x-text="$store.lang.t('Update Logistik & Shipment', 'Logistics & Shipment Updates', '物流与货运动态', 'تحديثات اللوجستيات والشحن')">Update Logistik & Shipment</h2>
        <p style="color:#666;font-size:15px" x-text="$store.lang.t('Info terkini seputar pelabuhan, regulasi, dan kegiatan pengiriman.', 'Latest info on ports, regulations, and shipping activities.', '关于港口、法规和航运活动的最新信息。', 'أحدث المعلومات حول الموانئ، واللوائح، وأنشطة الشحن.')">Info terkini seputar pelabuhan, regulasi, dan kegiatan pengiriman.</p>
      </div>
      <a href="{{ route('blog.index') }}" style="font-size:13px;color:#1e3a5f;font-weight:600;text-decoration:none" x-text="$store.lang.t('Lihat semua artikel →', 'View all articles →', '查看全部文章 →', 'عرض جميع المقالات ←')">Lihat semua artikel →</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px" class="home-blog-grid">
      @foreach($latestPosts as $post)
      <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;border-radius:12px;overflow:hidden;border:1px solid #e5e2dc;background:#fff;display:flex;flex-direction:column;transition:box-shadow .2s" onmouseover="this.style.boxShadow='0 8px 32px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
        @if($post->featured_image)
        <div style="height:200px;background-image:url({{ Str::startsWith($post->featured_image, ['http://', 'https://']) ? $post->featured_image : Storage::url($post->featured_image) }});background-size:cover;background-position:center"></div>
        @else
        <div style="height:200px;background:linear-gradient(135deg,#1e3a5f,#2a5298);display:flex;align-items:center;justify-content:center;font-size:48px">📦</div>
        @endif
        <div style="padding:20px 22px;flex:1;display:flex;flex-direction:column">
          @if($post->category)<span style="display:inline-block;padding:3px 8px;border-radius:4px;background:#1e3a5f;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase;margin-bottom:10px">{{ $post->category }}</span>@endif
          <h3 style="font-family:Syne;font-weight:700;font-size:16px;line-height:1.4;color:#0f0f14;margin-bottom:10px;flex:1">{{ $post->title }}</h3>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;font-size:12px;color:#999">
            <span>{{ $post->published_at?->format('d M Y') }}</span>
            <span style="color:#1e3a5f;font-weight:600" x-text="$store.lang.t('Baca →', 'Read →', '阅读全文 →', 'اقرأ ←')">Baca →</span>
          </div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ═══ CTA SECTION ═══ --}}
<section class="home-section" style="background:#0f0f14">
  <div style="max-width:700px;margin:0 auto;text-align:center">
    <h2 style="font-family:Syne;font-weight:800;font-size:40px;color:#fff;letter-spacing:-1px;margin-bottom:16px;line-height:1.1">
      <span x-text="$store.lang.t('Siap Ekspor atau Impor?', 'Ready to Export or Import?', '准备好进行进出口了吗？', 'هل أنت جاهز للتصدير أو الاستيراد؟')">Siap Ekspor atau Impor?</span><br>
      <span style="color:#4a9eda" x-text="$store.lang.t('Mulai Hari Ini.', 'Start Today.', '今天就联系我们。', 'ابدأ اليوم.')">Mulai Hari Ini.</span>
    </h2>
    <p style="color:rgba(255,255,255,0.5);font-size:16px;margin-bottom:36px;line-height:1.7" x-text="$store.lang.t('Konsultasi gratis, quote transparan, respon cepat. Tidak ada komitmen sebelum kamu setuju.', 'Free consultation, transparent quote, fast response. No commitment until you agree.', '免费咨询、透明报价、快速响应。在您完全同意前，无需承担任何义务。', 'استشارة مجانية، عرض أسعار شفاف، استجابة سريعة. لا التزام حتى توافق.')">Konsultasi gratis, quote transparan, respon cepat. Tidak ada komitmen sebelum kamu setuju.</p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
      <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent($store.lang.t('Halo M2B, saya mau konsultasi', 'Hello M2B, I would like a consultation', '您好M2B，我想进行咨询。', 'مرحباً M2B، أرغب في الحصول على استشارة'))" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border-radius:8px;background:#1e3a5f;color:#fff;text-decoration:none;font-weight:600;font-size:16px" x-text="$store.lang.t('💬 Chat WhatsApp Sekarang', '💬 Chat on WhatsApp Now', '💬 立即进行微信/WhatsApp咨询', '💬 تحدث معنا عبر الواتساب الآن')">💬 Chat WhatsApp Sekarang</a>
      <a href="mailto:sales@m2b.co.id" style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;border-radius:8px;color:#fff;text-decoration:none;font-weight:600;font-size:16px;border:1.5px solid rgba(255,255,255,0.25);background:rgba(255,255,255,0.06)" x-text="$store.lang.t('📧 Email Kami', '📧 Email Us', '📧 给我们发送邮件', '📧 أرسل لنا بريداً إلكترونياً')">📧 Email Kami</a>
    </div>
  </div>
</section>

@endsection
