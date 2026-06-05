{{--
    CTA E-book BERBAYAR untuk halaman blog (funnel blog → ebook.m2b.co.id).
    Copy dibuat jujur sesuai produk asli: 22 bab, Rp 49.000, garansi 7 hari uang kembali.
    UTM dipasang agar penjualan dari blog bisa diukur di Analytics.
    Toolkit gratis tetap ditawarkan sebagai jalur lembut bagi yang belum siap beli.

    @props:
      source  — penanda UTM medium/posisi (mis. 'post', 'feed') untuk membedakan asal klik
--}}
@props(['source' => 'blog'])
@php
    $base = 'https://ebook.m2b.co.id/';
    $utm  = '?utm_source=blog&utm_medium=' . e($source) . '&utm_campaign=ebook_paid';
    $buyUrl  = $base . $utm . '#order';
    $freeUrl = $base . 'toolkit.html?utm_source=blog&utm_medium=' . e($source) . '&utm_campaign=toolkit_free';
@endphp
<div style="margin-top:32px;background:linear-gradient(135deg,#0f0f14 0%,#1e3a5f 100%);border-radius:16px;padding:32px 36px;border:1px solid rgba(245,185,28,0.25)">
  <div style="display:flex;align-items:flex-start;gap:24px;flex-wrap:wrap">
    <div style="font-size:48px;flex-shrink:0;line-height:1">📘</div>
    <div style="flex:1;min-width:240px">
      <div style="display:inline-block;background:rgba(245,185,28,0.15);color:#f5b91c;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:3px 10px;border-radius:6px;margin-bottom:10px"
        x-text="$store.lang.t('E-Book Resmi M2B', 'Official M2B E-Book', 'M2B 官方电子书', 'كتاب M2B الإلكتروني الرسمي')">E-Book Resmi M2B</div>
      <div style="font-family:Syne;font-weight:800;font-size:20px;color:#fff;line-height:1.3;margin-bottom:8px"
        x-text="$store.lang.t('Panduan Lengkap Ekspor Impor Indonesia 2026', 'Complete Guide to Indonesia Export-Import 2026', '2026年印尼进出口完整指南', 'الدليل الشامل للاستيراد والتصدير في إندونيسيا 2026')">Panduan Lengkap Ekspor Impor Indonesia 2026</div>
      <div style="font-size:14px;color:rgba(255,255,255,0.7);line-height:1.65;margin-bottom:16px"
        x-text="$store.lang.t('22 bab dari A&ndash;Z: mindset global, HS Code, dokumen inti, Incoterms 2020, landed cost, hingga strategi B2B digital. Cocok untuk pemula &amp; UMKM yang serius go global.', '22 chapters from A to Z: global mindset, HS Code, core documents, Incoterms 2020, landed cost, to B2B digital strategy. Perfect for beginners &amp; SMEs serious about going global.', '从 A 到 Z 共 22 章：全球化思维、海关编码（HS Code）、核心文件、2020 年国际贸易术语（Incoterms 2020）、到岸成本以及 B2B 数字战略。非常适合渴望走向全球的初学者和中小企业。', '٢٢ فصلاً من الألف إلى الياء: العقلية العالمية، رمز المنسق (HS Code)، المستندات الأساسية، مصطلحات التجارة الدولية ٢٠٢٠ (Incoterms 2020)، تكلفة الشحن الإجمالية، إلى استراتيجية B2B الرقمية. مثالي للمبتدئين والشركات الصغيرة والمتوسطة الجادة في التوسع العالمي.')">
        22 bab dari A&ndash;Z: mindset global, HS Code, dokumen inti, Incoterms 2020, landed cost, hingga strategi B2B digital. Cocok untuk pemula &amp; UMKM yang serius go global.
      </div>
      <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:20px">
        <span style="font-family:Syne;font-weight:800;font-size:24px;color:#f5b91c">Rp 49.000</span>
        <span style="font-size:13px;color:rgba(255,255,255,0.6)" x-text="$store.lang.t('🔒 Garansi 7 hari uang kembali', '🔒 7-day money-back guarantee', '🔒 7天退款保证', '🔒 ضمان استرداد الأموال لمدة ٧ أيام')">🔒 Garansi 7 hari uang kembali</span>
      </div>
      <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center">
        <a href="{{ $buyUrl }}" target="_blank" rel="noopener"
           style="display:inline-flex;align-items:center;gap:8px;padding:13px 26px;border-radius:10px;background:#f5b91c;color:#0f0f14;text-decoration:none;font-weight:700;font-size:14px;white-space:nowrap"
           x-text="$store.lang.t('Miliki E-Book Sekarang ↗', 'Get E-Book Now ↗', '立即获取电子书 ↗', 'احصل على -الكتاب الإلكتروني الآن ↗')">
          Miliki E-Book Sekarang ↗
        </a>
        <a href="{{ $freeUrl }}" target="_blank" rel="noopener"
           style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,0.7);text-decoration:none;font-weight:600;font-size:13px;border-bottom:1px solid rgba(255,255,255,0.3);padding-bottom:1px"
           x-text="$store.lang.t('Belum siap? Coba toolkit gratis dulu', 'Not ready? Try the free toolkit first', '还没准备好？先试用免费工具包', 'غير مستعد بعد؟ جرب مجموعة الأدوات المجانية أولاً')">
          Belum siap? Coba toolkit gratis dulu
        </a>
      </div>
    </div>
  </div>
</div>
