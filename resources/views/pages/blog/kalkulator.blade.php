@extends('layouts.app')

@section('title', 'Kalkulator Bea Masuk & Pajak Impor 2026 — M2B')
@section('description', 'Simulasi perhitungan bea masuk, PPN 11%, PPh Pasal 22 impor, dan nilai pabean CIF secara online dan instan sesuai regulasi Kementerian Keuangan & CEISA 4.0.')

@section('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebApplication",
  "name": "Kalkulator Bea Masuk dan Simulasi Pajak Impor M2B",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "All",
  "url": "https://m2b.co.id/blog/kalkulator-bea-masuk",
  "description": "Simulasi perhitungan bea masuk, PPN 11%, PPh Pasal 22 impor, dan nilai pabean CIF secara online dan instan.",
  "publisher": {
    "@@type": "Organization",
    "name": "PT. Mora Multi Berkah (M2B)"
  }
}
</script>
<style>
.pabean-calc-wrapper {
    background-color: #f7f5f0;
    min-height: 100vh;
    padding-top: 150px;
    padding-bottom: 80px;
    font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    color: #1a1a1a;
}
.pabean-calc-container {
    max-width: 1060px;
    margin: 0 auto;
    padding: 0 20px;
}
.pabean-calc-breadcrumb {
    font-size: 13px;
    color: #666;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pabean-calc-breadcrumb a {
    color: #1e3a5f;
    text-decoration: none;
    font-weight: 500;
}
.pabean-calc-breadcrumb a:hover { text-decoration: underline; }
.pabean-calc-header {
    text-align: center;
    margin-bottom: 40px;
}
.pabean-calc-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #e8f0fe;
    color: #1e3a5f;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 16px;
    border: 1px solid rgba(30, 58, 95, 0.15);
}
.pabean-calc-title {
    font-family: 'Syne', sans-serif;
    font-size: clamp(28px, 4vw, 40px);
    font-weight: 800;
    color: #0f0f14;
    margin: 0 0 14px 0;
    line-height: 1.25;
}
.pabean-calc-subtitle {
    font-size: 15.5px;
    color: #555;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}
.pabean-calc-card-main {
    background: #ffffff;
    border-radius: 24px;
    padding: 38px;
    box-shadow: 0 12px 36px rgba(0,0,0,0.06);
    border: 1px solid #e2ddd5;
    margin-bottom: 36px;
}
.pabean-calc-grid {
    display: grid;
    grid-template-columns: 1.05fr 0.95fr;
    gap: 36px;
    align-items: stretch;
}
@media (max-width: 820px) {
    .pabean-calc-wrapper { padding-top: 130px; }
    .pabean-calc-card-main { padding: 24px; }
    .pabean-calc-grid { grid-template-columns: 1fr; gap: 32px; }
}
.pabean-calc-form-title {
    font-family: 'Syne', sans-serif;
    font-size: 19px;
    font-weight: 700;
    color: #0f0f14;
    margin: 0 0 22px 0;
    padding-bottom: 12px;
    border-bottom: 2px solid #f0ede8;
}
.pabean-calc-group {
    margin-bottom: 22px;
}
.pabean-calc-label {
    display: block;
    font-size: 13.5px;
    font-weight: 700;
    color: #0f0f14 !important;
    margin-bottom: 8px;
}
.pabean-calc-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}
.pabean-calc-prefix {
    position: absolute;
    left: 16px;
    font-weight: 700;
    color: #64748b;
    font-size: 15px;
    pointer-events: none;
    z-index: 2;
}
.pabean-calc-suffix {
    position: absolute;
    right: 16px;
    font-weight: 700;
    color: #64748b;
    font-size: 15px;
    pointer-events: none;
    z-index: 2;
}
.pabean-calc-input {
    width: 100% !important;
    box-sizing: border-box !important;
    padding: 13px 16px !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 12px !important;
    font-size: 16px !important;
    font-family: 'DM Sans', sans-serif !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    background-color: #ffffff !important;
    transition: all .2s ease !important;
}
.pabean-calc-input:focus {
    outline: none !important;
    border-color: #1e3a5f !important;
    background-color: #ffffff !important;
    box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12) !important;
}
.pabean-calc-input.has-prefix { padding-left: 46px !important; }
.pabean-calc-input.has-suffix { padding-right: 46px !important; }
.pabean-calc-select {
    width: 100% !important;
    box-sizing: border-box !important;
    padding: 13px 16px !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 12px !important;
    font-size: 14px !important;
    font-family: 'DM Sans', sans-serif !important;
    font-weight: 600 !important;
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    background-color: #ffffff !important;
    cursor: pointer !important;
    transition: all .2s ease !important;
}
.pabean-calc-select:focus {
    outline: none !important;
    border-color: #1e3a5f !important;
    box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12) !important;
}
.pabean-calc-hint {
    font-size: 12px;
    color: #64748b;
    margin-top: 6px;
    line-height: 1.4;
}

/* Results Box */
.pabean-calc-results {
    background: #0f172a;
    border-radius: 20px;
    padding: 30px;
    color: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.18);
}
.pabean-calc-results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255,255,255,0.12);
    padding-bottom: 16px;
    margin-bottom: 20px;
}
.pabean-calc-results-title {
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: #f5b91c;
}
.pabean-calc-results-badge {
    background: rgba(245, 185, 28, 0.15);
    color: #f5b91c;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.5px;
}
.pabean-calc-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
    font-size: 13.5px;
    color: #cbd5e1;
}
.pabean-calc-row.divider {
    border-top: 1px solid rgba(255,255,255,0.1);
    margin-top: 8px;
    padding-top: 12px;
}
.pabean-calc-val {
    font-family: 'DM Mono', monospace, sans-serif;
    font-weight: 700;
    color: #ffffff;
    font-size: 14.5px;
}
.pabean-calc-val.gold { color: #f5b91c; }
.pabean-calc-total-box {
    margin-top: 26px;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.16);
}
.pabean-calc-total-label {
    font-size: 11.5px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 4px;
}
.pabean-calc-total-val {
    font-family: 'Syne', 'DM Mono', monospace;
    font-size: 28px;
    font-weight: 800;
    color: #f5b91c;
    margin-bottom: 6px;
    line-height: 1.2;
}
.pabean-calc-landed-hint {
    font-size: 12.5px;
    color: #94a3b8;
    margin-bottom: 22px;
}
.pabean-calc-btn-wa {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    box-sizing: border-box;
    padding: 14px 20px;
    background: #f5b91c;
    color: #0f0f14;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 14px;
    transition: all .2s ease;
    box-shadow: 0 4px 14px rgba(245, 185, 28, 0.3);
}
.pabean-calc-btn-wa:hover {
    background: #ffd44d;
    transform: translateY(-1px);
}
.pabean-calc-expl-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 32px;
    border: 1px solid #e2ddd5;
    margin-bottom: 36px;
}
.pabean-calc-expl-title {
    font-family: 'Syne', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: #0f0f14;
    margin: 0 0 12px 0;
}
.pabean-calc-expl-list {
    margin: 12px 0 18px 0;
    padding-left: 20px;
    font-size: 14px;
    line-height: 1.8;
    color: #334155;
}
.pabean-calc-disclaimer {
    font-size: 12.5px;
    color: #64748b;
    border-top: 1px solid #f0ede8;
    padding-top: 14px;
    margin: 0;
    font-style: italic;
    line-height: 1.5;
}
</style>
@endsection

@section('content')
<div class="pabean-calc-wrapper">
    <div class="pabean-calc-container">
        {{-- Breadcrumb --}}
        <div class="pabean-calc-breadcrumb">
            <a href="/">Beranda</a>
            <span>›</span>
            <a href="/blog">Blog</a>
            <span>›</span>
            <span>Kalkulator Bea Masuk</span>
        </div>

        {{-- Header --}}
        <div class="pabean-calc-header">
            <div class="pabean-calc-badge">
                <span>⚙️</span> Interactive Customs Tool
            </div>
            <h1 class="pabean-calc-title">
                Kalkulator Bea Masuk &amp; Pajak Impor
            </h1>
            <p class="pabean-calc-subtitle">
                Simulasi estimasi perhitungan Bea Masuk, PPN 11%, PPh Pasal 22 Impor, dan total billing pabean sesuai formula baku Direktorat Jenderal Bea dan Cukai (DJBC).
            </p>
        </div>

        {{-- Interactive Alpine.js Calculator --}}
        <div class="pabean-calc-card-main"
             x-data="{
                 cifUsd: 10000,
                 kursPajak: 16200,
                 bmPercent: 7.5,
                 pphType: '2.5',
                 ppnPercent: 11,

                 get cifIdr() {
                     return (parseFloat(this.cifUsd) || 0) * (parseFloat(this.kursPajak) || 0);
                 },
                 get bmIdr() {
                     return this.cifIdr * ((parseFloat(this.bmPercent) || 0) / 100);
                 },
                 get nilaiImpor() {
                     return this.cifIdr + this.bmIdr;
                 },
                 get ppnIdr() {
                     return this.nilaiImpor * ((parseFloat(this.ppnPercent) || 0) / 100);
                 },
                 get pphPercent() {
                     return parseFloat(this.pphType) || 0;
                 },
                 get pphIdr() {
                     return this.nilaiImpor * (this.pphPercent / 100);
                 },
                 get totalBilling() {
                     return this.bmIdr + this.ppnIdr + this.pphIdr;
                 },
                 get totalLandedCost() {
                     return this.cifIdr + this.totalBilling;
                 },
                 formatRupiah(val) {
                     return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val);
                 },
                 formatNumber(val) {
                     return new Intl.NumberFormat('id-ID').format(val);
                 }
             }">

            <div class="pabean-calc-grid">
                {{-- Form Inputs --}}
                <div>
                    <h2 class="pabean-calc-form-title">1. Parameter Transaksi Impor</h2>

                    <div class="pabean-calc-group">
                        <label class="pabean-calc-label">Nilai Pabean CIF (USD)</label>
                        <div class="pabean-calc-input-wrapper">
                            <span class="pabean-calc-prefix">$</span>
                            <input type="number" step="any" min="0" x-model="cifUsd" class="pabean-calc-input has-prefix">
                        </div>
                        <div class="pabean-calc-hint">Nilai Cost, Insurance, &amp; Freight dalam valuta USD.</div>
                    </div>

                    <div class="pabean-calc-group">
                        <label class="pabean-calc-label">Kurs Pajak Kemenkeu (NDBM)</label>
                        <div class="pabean-calc-input-wrapper">
                            <span class="pabean-calc-prefix">Rp</span>
                            <input type="number" step="any" min="1" x-model="kursPajak" class="pabean-calc-input has-prefix">
                        </div>
                        <div class="pabean-calc-hint">Kurs mingguan resmi Menteri Keuangan saat dokumen diajukan.</div>
                    </div>

                    <div class="pabean-calc-group">
                        <label class="pabean-calc-label">Tarif Bea Masuk (%)</label>
                        <div class="pabean-calc-input-wrapper">
                            <input type="number" step="0.1" min="0" max="100" x-model="bmPercent" class="pabean-calc-input has-suffix">
                            <span class="pabean-calc-suffix">%</span>
                        </div>
                        <div class="pabean-calc-hint">Gunakan 0% jika komoditas menggunakan Form SKA FTA (ACFTA, ATIGA, dll).</div>
                    </div>

                    <div class="pabean-calc-group">
                        <label class="pabean-calc-label">Status Legalitas Importir (PPh 22)</label>
                        <select x-model="pphType" class="pabean-calc-select">
                            <option value="2.5">Memiliki NIB / API Aktif (Tarif 2.5%)</option>
                            <option value="7.5">Non-API / Perseorangan (Tarif 7.5%)</option>
                            <option value="0.5">Komoditas Tertentu Kedelai/Gandum (Tarif 0.5%)</option>
                            <option value="0">Pembebasan PPh Pasal 22 / Fasilitas (0%)</option>
                        </select>
                    </div>
                </div>

                {{-- Results Card --}}
                <div class="pabean-calc-results">
                    <div>
                        <div class="pabean-calc-results-header">
                            <span class="pabean-calc-results-title">Hasil Simulasi Pabean</span>
                            <span class="pabean-calc-results-badge">CEISA 4.0 Standard</span>
                        </div>

                        <div>
                            <div class="pabean-calc-row">
                                <span>Nilai Pabean (CIF IDR):</span>
                                <span class="pabean-calc-val" x-text="formatRupiah(cifIdr)"></span>
                            </div>
                            <div class="pabean-calc-row">
                                <span>Bea Masuk (<span x-text="bmPercent"></span>%):</span>
                                <span class="pabean-calc-val gold" x-text="formatRupiah(bmIdr)"></span>
                            </div>
                            <div class="pabean-calc-row divider">
                                <span>Nilai Impor Dasar Pajak:</span>
                                <span class="pabean-calc-val" x-text="formatRupiah(nilaiImpor)"></span>
                            </div>
                            <div class="pabean-calc-row">
                                <span>PPN Impor (11%):</span>
                                <span class="pabean-calc-val gold" x-text="formatRupiah(ppnIdr)"></span>
                            </div>
                            <div class="pabean-calc-row">
                                <span>PPh Pasal 22 (<span x-text="pphPercent"></span>%):</span>
                                <span class="pabean-calc-val gold" x-text="formatRupiah(pphIdr)"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Total Highlight --}}
                    <div class="pabean-calc-total-box">
                        <div class="pabean-calc-total-label">Total Billing Pabean (Pajak + Bea)</div>
                        <div class="pabean-calc-total-val" x-text="formatRupiah(totalBilling)"></div>
                        <div class="pabean-calc-landed-hint">
                            Total Estimasi Landed Cost: <strong style="color:#ffffff;" x-text="formatRupiah(totalLandedCost)"></strong>
                        </div>

                        {{-- WhatsApp Action --}}
                        <div>
                            <a :href="'https://wa.me/6281263027818?text=' + encodeURIComponent('Halo Tim M2B, saya telah menghitung estimasi impor dengan CIF $' + formatNumber(cifUsd) + ' dan total billing ' + formatRupiah(totalBilling) + '. Saya ingin konsultasi jasa kepabeanan PPJK dan pengurusan PIB.')"
                               target="_blank" rel="noopener noreferrer"
                               class="pabean-calc-btn-wa">
                                <span>💬</span> Konsultasikan via WhatsApp PPJK
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Explanatory Regulatory Context --}}
        <div class="pabean-calc-expl-card">
            <h3 class="pabean-calc-expl-title">Dasar Rumus &amp; Ketentuan Perhitungan Kepabeanan</h3>
            <p style="font-size: 14px; color: #475569; margin-bottom: 10px;">
                Perhitungan di atas mengacu pada <strong>UU No. 17 Tahun 2006 tentang Kepabeanan</strong> dan <strong>PMK No. 190/PMK.04/2022</strong> tentang Pengeluaran Barang Impor untuk Dipakai:
            </p>
            <ul class="pabean-calc-expl-list">
                <li><strong>Nilai Pabean (IDR)</strong> = Nilai CIF (USD) × Kurs Pajak Mingguan Menkeu</li>
                <li><strong>Bea Masuk</strong> = Nilai Pabean (IDR) × % Tarif Bea Masuk MFN / FTA</li>
                <li><strong>Nilai Impor</strong> = Nilai Pabean (IDR) + Bea Masuk</li>
                <li><strong>PPN Impor</strong> = Nilai Impor × 11% (UU HPP No. 7 Tahun 2021)</li>
                <li><strong>PPh Pasal 22</strong> = Nilai Impor × (2.5% bagi pemilik API aktif / 7.5% non-API)</li>
                <li><strong>Total Tagihan Billing</strong> = Bea Masuk + PPN Impor + PPh Pasal 22</li>
            </ul>
            <p class="pabean-calc-disclaimer">
                Disclaimer: Hasil kalkulator ini merupakan simulasi estimasi administratif. Penetapan akhir tarif dan nilai pabean resmi ditetapkan oleh Pejabat Bea dan Cukai melalui modul CEISA 4.0 saat PIB BC 2.0 didaftarkan.
            </p>
        </div>
    </div>
</div>
@endsection
