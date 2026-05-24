const { useState, useEffect, useMemo, useRef } = React;

// ─── Article Data (from real blog repo) ───────────────────────────────────
const articles = [
  {
    slug: 'aturan-baru-bea-cukai-2026-merk-tipe-satuan-terkecil',
    title: 'Waspada Aturan Baru Bea Cukai 2026: Kewajiban Merk, Tipe, dan Satuan Terkecil pada PIB',
    excerpt: 'Mulai Januari 2026, DJBC resmi memperketat pengawasan administratif melalui kebijakan internalisasi kewajiban penyampaian merk, tipe, dan satuan barang terkecil. Apa yang harus disiapkan importir?',
    cat: 'Bea Cukai', date: '22 Jan 2026', readTime: 3, author: 'Tim M2B',
    featured: true, img: 'https://images.unsplash.com/photo-1554415707-6e8cfc93fe23?auto=format&fit=crop&w=900&q=80',
    tags: ['bea cukai', 'regulasi', 'PIB']
  },
  {
    slug: 'cara-pilih-freight-forwarder-terpercaya',
    title: 'Cara Memilih Freight Forwarder Terpercaya: 10+ Kriteria Wajib Cek',
    excerpt: 'Pernah dengar UMKM yang rugi puluhan juta karena salah pilih freight forwarder? Berikut 10+ kriteria wajib yang harus Anda cek sebelum memilih.',
    cat: 'Ekspor', date: '25 Sep 2025', readTime: 23, author: 'Tim M2B',
    img: 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=900&q=80',
    tags: ['ekspor', 'freight forwarder', 'tips']
  },
  {
    slug: 'cara-menghitung-landed-cost-impor-anti-boncos',
    title: 'Cara Menghitung Landed Cost Impor: Anti Boncos untuk Importir Pemula',
    excerpt: 'Banyak importir bingung menghitung total biaya impor. Artikel ini bahas komponen bea masuk, PPN, PPh impor, dan biaya tersembunyi lainnya secara sederhana.',
    cat: 'Impor', date: '18 Apr 2026', readTime: 7, author: 'Tim M2B',
    img: 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=900&q=80',
    tags: ['impor', 'landed cost', 'pajak']
  },
  {
    slug: 'cara-ekspor-barang-umkm-2026',
    title: 'Cara Ekspor Barang UMKM 2026: Panduan Lengkap dari A sampai Z',
    excerpt: 'Ekspor bukan hanya untuk perusahaan besar. UMKM Indonesia bisa go global dengan persiapan yang tepat. Berikut langkah-langkah praktisnya.',
    cat: 'UMKM', date: '15 Apr 2026', readTime: 8, author: 'Tim M2B',
    img: 'https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&w=900&q=80',
    tags: ['umkm', 'ekspor', 'panduan']
  },
  {
    slug: 'air-vs-sea-freight-indonesia',
    title: 'Air Freight vs Sea Freight: Mana yang Paling Cocok untuk Bisnis Anda?',
    excerpt: 'Perbandingan lengkap antara pengiriman udara dan laut — biaya, kecepatan, kapasitas, dan jenis barang. Pilih sesuai kebutuhan ekspormu.',
    cat: 'Ekspor', date: '12 Apr 2026', readTime: 10, author: 'Tim M2B',
    img: 'https://images.unsplash.com/photo-1583836631365-8e76e3c0bc4f?auto=format&fit=crop&w=900&q=80',
    tags: ['air freight', 'sea freight', 'logistik']
  },
  {
    slug: 'cara-impor-barang-china-indonesia',
    title: 'Cara Impor Barang dari China ke Indonesia: Panduan Step-by-Step',
    excerpt: 'Impor dari China masih jadi rute paling populer. Berikut panduan lengkap mulai dari cari supplier, negosiasi, hingga barang tiba di Indonesia.',
    cat: 'Impor', date: '10 Apr 2026', readTime: 6, author: 'Tim M2B',
    img: 'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?auto=format&fit=crop&w=900&q=80',
    tags: ['impor', 'china', 'panduan']
  },
  {
    slug: 'avoiding-red-channel-indonesia-customs-hs-code-guide',
    title: 'Hindari Jalur Merah Bea Cukai: Panduan Lengkap HS Code untuk Importir',
    excerpt: 'Salah HS Code = barang tertahan + denda. Pelajari cara mengklasifikasikan barang dengan benar untuk hindari jalur merah dan pemeriksaan fisik.',
    cat: 'Bea Cukai', date: '5 Apr 2026', readTime: 9, author: 'Tim M2B',
    img: 'https://images.unsplash.com/photo-1577415124269-fc1140a69e91?auto=format&fit=crop&w=900&q=80',
    tags: ['bea cukai', 'HS code', 'jalur merah']
  },
  {
    slug: 'biaya-pengiriman-internasional-2025',
    title: 'Update Biaya Pengiriman Internasional 2026: USA, China, Eropa, Timur Tengah',
    excerpt: 'Estimasi biaya kirim FCL/LCL ke berbagai negara. Update terbaru kurs, freight rate, dan biaya tambahan yang perlu Anda tahu.',
    cat: 'Tips & Info', date: '3 Apr 2026', readTime: 5, author: 'Tim M2B',
    img: 'https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?auto=format&fit=crop&w=900&q=80',
    tags: ['biaya', 'shipping rate', 'internasional']
  },
  {
    slug: 'checklist-dokumen-ekspor-umkm-timur-tengah',
    title: 'Checklist Dokumen Ekspor UMKM ke Timur Tengah: Lengkap & Up-to-Date',
    excerpt: 'Pasar Timur Tengah punya regulasi unik. Berikut checklist dokumen wajib mulai dari Halal Certificate hingga SASO untuk ekspor lancar.',
    cat: 'UMKM', date: '28 Mar 2026', readTime: 8, author: 'Tim M2B',
    img: 'https://images.unsplash.com/photo-1565023008842-b9d3a3a8b9e6?auto=format&fit=crop&w=900&q=80',
    tags: ['umkm', 'ekspor', 'timur tengah']
  },
];

const categories = [
  { id: 'Semua',      color: '#0B1120',         bg: '#fff' },
  { id: 'Ekspor',     color: 'var(--cat-ekspor)',     bg: 'var(--cat-ekspor-bg)' },
  { id: 'Impor',      color: 'var(--cat-impor)',      bg: 'var(--cat-impor-bg)' },
  { id: 'UMKM',       color: 'var(--cat-umkm)',       bg: 'var(--cat-umkm-bg)' },
  { id: 'Bea Cukai',  color: 'var(--cat-bea)',        bg: 'var(--cat-bea-bg)' },
  { id: 'Tips & Info',color: 'var(--cat-tips)',       bg: 'var(--cat-tips-bg)' },
];

const catStyle = (cat) => categories.find(c => c.id === cat) || categories[0];

// ─── Reusable: Category Badge ─────────────────────────────────────────────
const CatBadge = ({ cat, size = 'md' }) => {
  const s = catStyle(cat);
  return (
    <span style={{
      display: 'inline-block',
      padding: size === 'sm' ? '2px 8px' : '3px 11px',
      borderRadius: 12,
      background: s.bg,
      color: s.color,
      fontSize: size === 'sm' ? 10 : 11,
      fontWeight: 700,
      letterSpacing: 0.4,
      textTransform: 'uppercase',
      fontFamily: "'Plus Jakarta Sans', sans-serif",
    }}>{cat}</span>
  );
};

// ─── Nav (consistent with landing) ────────────────────────────────────────
function Nav() {
  const [scrolled, setScrolled] = useState(false);
  useEffect(() => {
    const fn = () => setScrolled(window.scrollY > 30);
    window.addEventListener('scroll', fn);
    return () => window.removeEventListener('scroll', fn);
  }, []);

  return (
    <nav style={{
      position: 'sticky', top: 0, zIndex: 100,
      background: scrolled ? 'rgba(248,245,238,0.96)' : 'var(--warm-white)',
      backdropFilter: 'blur(12px)',
      borderBottom: '1px solid var(--cream-dark)',
      boxShadow: scrolled ? '0 2px 24px rgba(11,17,32,0.08)' : 'none',
      transition: 'all .25s',
    }}>
      <div style={{ maxWidth: 1200, margin: '0 auto', padding: '0 32px', height: 72, display: 'flex', alignItems: 'center', gap: 24 }}>
        {/* Logo + Blog label */}
        <a href="M2B Landing Page.html" style={{ display: 'flex', alignItems: 'center', gap: 12, flexShrink: 0, textDecoration: 'none' }}>
          <img src="assets/logo-m2b-clean.png" alt="M2B" style={{ height: 44, width: 'auto', filter: 'drop-shadow(0 2px 6px rgba(11,17,32,0.15))' }} />
          <div style={{ borderLeft: '1px solid var(--cream-dark)', paddingLeft: 12, display: 'flex', flexDirection: 'column', lineHeight: 1.1 }}>
            <span style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 18, color: 'var(--navy)', letterSpacing: -0.4 }}>Blog</span>
            <span style={{ fontSize: 10, color: 'var(--text-soft)', fontWeight: 600, letterSpacing: 0.8, marginTop: 2 }}>LOGISTIK · EKSPOR-IMPOR</span>
          </div>
        </a>

        {/* Nav: link back to landing + categories */}
        <div style={{ display: 'flex', gap: 4, flex: 1, justifyContent: 'center' }}>
          <a href="M2B Landing Page.html" style={navLinkStyle(false)}>← Beranda</a>
          <div style={{ width: 1, height: 18, background: 'var(--cream-dark)', margin: '0 8px', alignSelf: 'center' }} />
          {['Ekspor','Impor','UMKM','Bea Cukai'].map(c => (
            <a key={c} href={`#cat-${c.replace(/\s+/g,'-')}`} style={navLinkStyle(false)}>{c}</a>
          ))}
        </div>

        {/* Search + CTA */}
        <SearchBar />
        <a href="https://wa.me/6281263027818" target="_blank" rel="noopener noreferrer" style={{
          padding: '9px 18px', borderRadius: 20, background: 'var(--gold)', color: 'var(--navy)',
          fontWeight: 800, fontSize: 13, textDecoration: 'none', flexShrink: 0,
          boxShadow: '0 4px 12px rgba(245,185,28,0.3)',
        }}>Konsultasi Gratis</a>
      </div>
    </nav>
  );
}

function navLinkStyle(active) {
  return {
    padding: '6px 14px', borderRadius: 20,
    fontSize: 13, fontWeight: 600, textDecoration: 'none',
    color: active ? 'var(--cream)' : 'var(--text-mid)',
    background: active ? 'var(--navy)' : 'transparent',
    transition: 'all .15s',
  };
}

function SearchBar() {
  const [open, setOpen] = useState(false);
  const [q, setQ] = useState('');
  return (
    <div style={{ position: 'relative', flexShrink: 0 }}>
      <button onClick={() => setOpen(!open)} style={{
        width: 36, height: 36, borderRadius: 18,
        background: 'var(--cream-dark)', border: 'none', cursor: 'pointer',
        display: 'flex', alignItems: 'center', justifyContent: 'center',
        fontSize: 14, color: 'var(--text-mid)',
      }}>🔍</button>
      {open && (
        <div style={{
          position: 'absolute', top: 44, right: 0,
          width: 320, background: '#fff', borderRadius: 12,
          border: '1px solid var(--cream-dark)',
          boxShadow: '0 12px 36px rgba(11,17,32,0.15)',
          padding: 12, zIndex: 10,
        }}>
          <input autoFocus value={q} onChange={e => setQ(e.target.value)}
            placeholder="Cari artikel… bea cukai, ekspor, UMKM"
            style={{
              width: '100%', padding: '10px 14px', borderRadius: 8,
              border: '1px solid var(--cream-dark)', outline: 'none',
              fontSize: 14, fontFamily: 'inherit',
            }}
          />
          <div style={{ marginTop: 10 }}>
            <div style={{ fontSize: 10, color: 'var(--text-soft)', letterSpacing: 1, fontWeight: 700, textTransform: 'uppercase', marginBottom: 6 }}>Pencarian Populer</div>
            <div style={{ display: 'flex', gap: 6, flexWrap: 'wrap' }}>
              {['bea cukai 2026','HS code','impor china','ekspor UMKM','FCL vs LCL','landed cost'].map(t => (
                <span key={t} onClick={() => setQ(t)} style={{
                  padding: '4px 10px', background: 'var(--cream)',
                  borderRadius: 12, fontSize: 11, color: 'var(--text-mid)',
                  cursor: 'pointer', border: '1px solid var(--cream-dark)',
                }}>{t}</span>
              ))}
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

// ─── News Ticker ──────────────────────────────────────────────────────────
function NewsTicker() {
  const items = [
    '🔥 Aturan Baru Bea Cukai 2026 — Wajib Cantumkan Merk, Tipe & Satuan Terkecil',
    '📦 Volume Ekspor CPO Sumut Q1 2026 Naik 12%',
    '⚓ Pelabuhan Belawan Tambah Kapasitas — Target 4 Juta TEU',
    '🚢 Slot FCL Rute Medan-Shanghai Q2 2026 Cepat Terisi',
    '💱 Kurs Bea Cukai Hari Ini: USD 16.480 · CNY 2.270',
  ];
  const doubled = [...items, ...items];
  return (
    <div style={{ background: 'var(--navy)', padding: '10px 0', borderBottom: `2px solid var(--gold)`, overflow: 'hidden' }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: 16 }}>
        <div style={{ flexShrink: 0, background: 'var(--gold)', color: 'var(--navy)', padding: '4px 14px', fontSize: 10, fontWeight: 800, letterSpacing: 1.2 }}>LATEST</div>
        <div className="ticker-track" style={{ gap: 56 }}>
          {doubled.map((t, i) => (
            <span key={i} style={{ color: 'rgba(248,245,238,0.85)', fontSize: 12.5, fontWeight: 500 }}>{t}</span>
          ))}
        </div>
      </div>
    </div>
  );
}

// ─── Hero Section with Featured ───────────────────────────────────────────
function Hero() {
  const featured = articles.find(a => a.featured) || articles[0];
  const side = articles.filter(a => a !== featured).slice(0, 3);

  return (
    <section style={{ background: 'var(--cream)', padding: '32px 32px 48px' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto' }}>
        {/* Breadcrumb */}
        <div style={{ fontSize: 12, color: 'var(--text-soft)', marginBottom: 16 }}>
          <a href="M2B Landing Page.html" style={{ color: 'var(--text-soft)', textDecoration: 'none' }}>Home</a>
          <span style={{ margin: '0 6px' }}>/</span>
          <span style={{ color: 'var(--navy)', fontWeight: 600 }}>Blog</span>
        </div>

        {/* Page heading */}
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end', marginBottom: 28 }}>
          <div>
            <h1 style={{
              fontFamily: 'Syne', fontWeight: 800, fontSize: 42, lineHeight: 1.05,
              color: 'var(--navy)', letterSpacing: -1.5, marginBottom: 10,
            }}>
              Insight Logistik &<br/>Panduan Ekspor-Impor
            </h1>
            <p style={{ fontSize: 16, color: 'var(--text-mid)', maxWidth: 520, lineHeight: 1.7 }}>
              Update regulasi bea cukai, tips logistik, strategi shipment — disusun oleh tim ahli PT. Mora Multi Berkah.
            </p>
          </div>
          <div style={{ textAlign: 'right' }}>
            <div style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 32, color: 'var(--gold)' }}>129+</div>
            <div style={{ fontSize: 12, color: 'var(--text-soft)' }}>Artikel Tersedia</div>
          </div>
        </div>

        {/* Featured + side cards */}
        <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: 20 }}>
          <FeaturedCard article={featured} />
          <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
            {side.map(a => <SideCard key={a.slug} article={a} />)}
          </div>
        </div>
      </div>
    </section>
  );
}

function FeaturedCard({ article }) {
  return (
    <a href={`#${article.slug}`} style={{ textDecoration: 'none', display: 'block', position: 'relative', borderRadius: 24, overflow: 'hidden', minHeight: 440, cursor: 'pointer', boxShadow: '0 12px 40px rgba(11,17,32,0.15)' }}>
      <img src={article.img} alt={article.title} style={{ position: 'absolute', inset: 0, width: '100%', height: '100%', objectFit: 'cover' }} />
      <div style={{
        position: 'absolute', inset: 0,
        background: 'linear-gradient(180deg, rgba(11,17,32,0.2) 0%, rgba(11,17,32,0.5) 50%, rgba(11,17,32,0.92) 100%)',
      }} />
      {/* Editor's pick badge */}
      <div style={{ position: 'absolute', top: 20, left: 20, display: 'flex', gap: 8 }}>
        <span style={{
          background: 'var(--gold)', color: 'var(--navy)',
          padding: '4px 12px', borderRadius: 20, fontSize: 10,
          fontWeight: 800, letterSpacing: 1, textTransform: 'uppercase',
        }}>⭐ Editor's Pick</span>
      </div>
      <div style={{ position: 'absolute', bottom: 0, left: 0, right: 0, padding: '28px 28px' }}>
        <div style={{ marginBottom: 12 }}>
          <CatBadge cat={article.cat} />
        </div>
        <h2 style={{
          fontFamily: 'Syne', fontWeight: 800, fontSize: 26,
          color: 'var(--cream)', lineHeight: 1.2, letterSpacing: -0.5,
          marginBottom: 12, maxWidth: 600,
        }}>{article.title}</h2>
        <p style={{ color: 'rgba(248,245,238,0.7)', fontSize: 14, lineHeight: 1.6, marginBottom: 16, maxWidth: 560 }}>
          {article.excerpt.substring(0, 140)}…
        </p>
        <div style={{ display: 'flex', alignItems: 'center', gap: 14, flexWrap: 'wrap' }}>
          <div style={{
            background: 'var(--gold)', color: 'var(--navy)',
            padding: '8px 16px', borderRadius: 20,
            fontWeight: 800, fontSize: 12, display: 'inline-flex', alignItems: 'center', gap: 6,
          }}>Baca Selengkapnya →</div>
          <span style={{ color: 'rgba(248,245,238,0.6)', fontSize: 12 }}>
            ⏱ {article.readTime} menit baca · {article.date}
          </span>
        </div>
      </div>
    </a>
  );
}

function SideCard({ article }) {
  return (
    <a href={`#${article.slug}`} style={{
      display: 'flex', gap: 12, padding: 12,
      background: 'var(--warm-white)', borderRadius: 16,
      border: '1px solid var(--cream-dark)', textDecoration: 'none',
      transition: 'all .15s', alignItems: 'flex-start',
    }}>
      <img src={article.img} alt="" style={{
        width: 96, height: 96, borderRadius: 10,
        objectFit: 'cover', flexShrink: 0,
      }} />
      <div style={{ flex: 1, minWidth: 0 }}>
        <CatBadge cat={article.cat} size="sm" />
        <div style={{
          fontFamily: 'Syne', fontWeight: 700, fontSize: 14,
          color: 'var(--navy)', lineHeight: 1.35, marginTop: 6, marginBottom: 6,
          display: '-webkit-box', WebkitLineClamp: 3, WebkitBoxOrient: 'vertical', overflow: 'hidden',
        }}>{article.title}</div>
        <div style={{ fontSize: 11, color: 'var(--text-soft)' }}>
          {article.date} · {article.readTime} min
        </div>
      </div>
    </a>
  );
}

// ─── Stats Banner ─────────────────────────────────────────────────────────
function StatsBanner() {
  const stats = [
    { num: '129+', label: 'Artikel Mendalam' },
    { num: '5K+', label: 'Pembaca Bulanan' },
    { num: '4', label: 'Kategori Topik' },
    { num: '100%', label: 'Ditulis Tim Ahli M2B' },
  ];
  return (
    <div style={{ background: 'var(--warm-white)', borderTop: '1px solid var(--cream-dark)', borderBottom: '1px solid var(--cream-dark)' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto', padding: '24px 32px', display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: 24 }}>
        {stats.map((s, i) => (
          <div key={i} style={{ textAlign: 'center', borderRight: i < 3 ? '1px solid var(--cream-dark)' : 'none' }}>
            <div style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 28, color: 'var(--navy)' }}>{s.num}</div>
            <div style={{ fontSize: 12, color: 'var(--text-soft)', marginTop: 4 }}>{s.label}</div>
          </div>
        ))}
      </div>
    </div>
  );
}

// ─── Category Filter Pills ────────────────────────────────────────────────
function CategoryFilter({ active, setActive }) {
  return (
    <div style={{ display: 'flex', gap: 8, flexWrap: 'wrap', marginBottom: 28 }}>
      {categories.map(c => (
        <button key={c.id} onClick={() => setActive(c.id)} style={{
          padding: '7px 16px', borderRadius: 20, border: 'none',
          background: active === c.id ? 'var(--navy)' : 'var(--warm-white)',
          color: active === c.id ? 'var(--cream)' : 'var(--text-mid)',
          fontFamily: 'Plus Jakarta Sans', fontWeight: 700, fontSize: 13,
          cursor: 'pointer', transition: 'all .15s',
          border: active === c.id ? 'none' : '1px solid var(--cream-dark)',
        }}>{c.id}</button>
      ))}
    </div>
  );
}

// ─── Article Card (grid) ──────────────────────────────────────────────────
function ArticleCard({ article }) {
  const [hover, setHover] = useState(false);
  return (
    <a href={`#${article.slug}`}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        display: 'flex', flexDirection: 'column', textDecoration: 'none',
        background: 'var(--warm-white)', borderRadius: 16,
        border: '1px solid var(--cream-dark)',
        overflow: 'hidden', transition: 'all .2s',
        boxShadow: hover ? '0 12px 40px rgba(11,17,32,0.10)' : 'none',
        transform: hover ? 'translateY(-3px)' : 'none',
      }}>
      <div style={{ aspectRatio: '16/9', overflow: 'hidden' }}>
        <img src={article.img} alt="" style={{
          width: '100%', height: '100%', objectFit: 'cover',
          transform: hover ? 'scale(1.05)' : 'scale(1)', transition: 'transform .35s',
        }} />
      </div>
      <div style={{ padding: 18, flex: 1, display: 'flex', flexDirection: 'column' }}>
        <CatBadge cat={article.cat} size="sm" />
        <h3 style={{
          fontFamily: 'Syne', fontWeight: 700, fontSize: 16,
          color: 'var(--navy)', lineHeight: 1.38, marginTop: 10, marginBottom: 8,
        }}>{article.title}</h3>
        <p style={{
          fontSize: 13, color: 'var(--text-mid)', lineHeight: 1.6,
          marginBottom: 14, flex: 1,
          display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical', overflow: 'hidden',
        }}>{article.excerpt}</p>
        <div style={{
          display: 'flex', justifyContent: 'space-between', alignItems: 'center',
          fontSize: 11, color: 'var(--text-soft)',
          paddingTop: 12, borderTop: '1px solid var(--cream-dark)',
        }}>
          <span>{article.date} · ⏱ {article.readTime} min</span>
          <span style={{
            width: 26, height: 26, borderRadius: 13,
            background: hover ? 'var(--navy)' : 'var(--cream)',
            color: hover ? 'var(--cream)' : 'var(--text-mid)',
            display: 'flex', alignItems: 'center', justifyContent: 'center',
            fontSize: 12, transition: 'all .15s',
          }}>→</span>
        </div>
      </div>
    </a>
  );
}

// ─── Native In-Feed AdSense Card ──────────────────────────────────────────
function InFeedAd({ slot }) {
  return (
    <div className="ad-placeholder" data-slot={slot} style={{
      borderRadius: 16, padding: 20, minHeight: 320,
      display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center',
      gap: 8, textAlign: 'center',
    }}>
      <div style={{ fontSize: 32, opacity: 0.5 }}>📣</div>
      <div style={{ fontSize: 14, fontWeight: 700, color: '#666', textTransform: 'none', letterSpacing: 0 }}>Native In-Feed Ad</div>
      <div style={{ fontSize: 10, color: '#aaa', maxWidth: 200, lineHeight: 1.5, textTransform: 'none', letterSpacing: 0 }}>
        Google AdSense slot — tampil seperti kartu artikel asli
      </div>
    </div>
  );
}

// ─── Mid-Page Lead Magnet CTA ────────────────────────────────────────────
function LeadMagnetCTA() {
  return (
    <div style={{
      background: 'linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%)',
      borderRadius: 20, padding: '36px 32px', margin: '32px 0',
      position: 'relative', overflow: 'hidden',
    }}>
      <div style={{
        position: 'absolute', top: -50, right: -50, width: 250, height: 250,
        background: `radial-gradient(circle, var(--gold) 0%, transparent 70%)`,
        opacity: 0.2, pointerEvents: 'none',
      }} />
      <div style={{ position: 'relative', display: 'flex', alignItems: 'center', gap: 32, flexWrap: 'wrap' }}>
        <div style={{ flex: 1, minWidth: 280 }}>
          <span style={{
            background: 'rgba(245,185,28,0.18)', color: 'var(--gold)',
            padding: '4px 12px', borderRadius: 20, fontSize: 10,
            fontWeight: 800, letterSpacing: 1, textTransform: 'uppercase',
          }}>🎁 Gratis</span>
          <h3 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 26,
            color: 'var(--cream)', marginTop: 12, marginBottom: 8, lineHeight: 1.15, letterSpacing: -0.5,
          }}>Bingung Mulai Ekspor-Impor?</h3>
          <p style={{ color: 'rgba(248,245,238,0.7)', fontSize: 14, lineHeight: 1.7, marginBottom: 20, maxWidth: 480 }}>
            Konsultasi langsung dengan tim ahli M2B. Audit kebutuhan logistik bisnismu — gratis, tanpa komitmen.
          </p>
          <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap' }}>
            <a href="https://wa.me/6281263027818" target="_blank" rel="noopener noreferrer" style={{
              background: 'var(--gold)', color: 'var(--navy)',
              padding: '11px 22px', borderRadius: 20,
              fontWeight: 800, fontSize: 13, textDecoration: 'none',
              boxShadow: '0 6px 18px rgba(245,185,28,0.4)',
            }}>💬 Konsultasi via WhatsApp</a>
            <a href="https://ebook.m2b.co.id" target="_blank" rel="noopener noreferrer" style={{
              border: '1.5px solid rgba(248,245,238,0.3)', color: 'var(--cream)',
              padding: '11px 22px', borderRadius: 20,
              fontWeight: 700, fontSize: 13, textDecoration: 'none',
            }}>📚 E-Book Ekspor</a>
          </div>
        </div>
        {/* Decorative */}
        <div style={{ flexShrink: 0, fontSize: 80, opacity: 0.15 }}>🚀</div>
      </div>
    </div>
  );
}

// ─── Sidebar Components ──────────────────────────────────────────────────
function SidebarAd() {
  return (
    <div className="ad-placeholder" data-slot="SLOT_D_SIDEBAR (300×600)" style={{
      width: '100%', height: 600, marginBottom: 20,
    }}>
      300×600
    </div>
  );
}

function NewsletterSignup({ compact }) {
  const [email, setEmail] = useState('');
  return (
    <div style={{
      background: 'var(--navy)', borderRadius: 16, padding: compact ? 20 : 28,
      color: 'var(--cream)', marginBottom: 20, position: 'relative', overflow: 'hidden',
    }}>
      <div style={{
        position: 'absolute', top: -30, right: -30, width: 120, height: 120,
        background: `radial-gradient(circle, var(--gold) 0%, transparent 70%)`,
        opacity: 0.15,
      }} />
      <div style={{ position: 'relative' }}>
        <div style={{ fontSize: 24, marginBottom: 8 }}>📬</div>
        <h4 style={{
          fontFamily: 'Syne', fontWeight: 800, fontSize: 18,
          color: 'var(--cream)', marginBottom: 6, letterSpacing: -0.3, lineHeight: 1.2,
        }}>Newsletter M2B</h4>
        <p style={{ fontSize: 12, color: 'rgba(248,245,238,0.6)', lineHeight: 1.6, marginBottom: 14 }}>
          Update regulasi bea cukai, jadwal kapal, dan tips ekspor langsung di inbox-mu. Gratis, mingguan.
        </p>
        <input value={email} onChange={e => setEmail(e.target.value)}
          placeholder="email@bisnismu.com"
          style={{
            width: '100%', padding: '10px 12px', borderRadius: 8,
            border: '1px solid rgba(248,245,238,0.15)',
            background: 'rgba(248,245,238,0.05)', color: 'var(--cream)',
            fontSize: 13, fontFamily: 'inherit', outline: 'none', marginBottom: 8,
          }}
        />
        <button style={{
          width: '100%', padding: '10px', borderRadius: 8,
          background: 'var(--gold)', color: 'var(--navy)',
          border: 'none', fontWeight: 800, fontSize: 13, cursor: 'pointer',
          fontFamily: 'inherit',
        }}>Subscribe →</button>
        <div style={{ fontSize: 10, color: 'rgba(248,245,238,0.4)', marginTop: 8, textAlign: 'center' }}>
          5K+ pelaku bisnis sudah bergabung
        </div>
      </div>
    </div>
  );
}

function SidebarRecent() {
  const recent = articles.slice(0, 5);
  return (
    <div style={{ marginBottom: 20 }}>
      <div style={{
        fontFamily: 'Syne', fontWeight: 800, fontSize: 13,
        color: 'var(--navy)', textTransform: 'uppercase', letterSpacing: 1,
        marginBottom: 14, paddingBottom: 10, borderBottom: '2px solid var(--navy)',
      }}>📅 Artikel Terbaru</div>
      {recent.map((a, i) => (
        <a key={a.slug} href={`#${a.slug}`} style={{
          display: 'flex', gap: 10, padding: '10px 0',
          borderBottom: i < recent.length - 1 ? '1px solid var(--cream-dark)' : 'none',
          textDecoration: 'none', alignItems: 'flex-start',
        }}>
          <div style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 18,
            color: 'var(--gold)', flexShrink: 0, width: 24,
          }}>{i + 1}</div>
          <div style={{ flex: 1, minWidth: 0 }}>
            <div style={{
              fontFamily: 'Plus Jakarta Sans', fontWeight: 600, fontSize: 12.5,
              color: 'var(--navy)', lineHeight: 1.4,
              display: '-webkit-box', WebkitLineClamp: 3, WebkitBoxOrient: 'vertical', overflow: 'hidden',
            }}>{a.title}</div>
            <div style={{ fontSize: 10, color: 'var(--text-soft)', marginTop: 4 }}>{a.date}</div>
          </div>
        </a>
      ))}
    </div>
  );
}

function SidebarCategories() {
  const counts = useMemo(() => {
    const m = {};
    articles.forEach(a => { m[a.cat] = (m[a.cat] || 0) + 1; });
    return m;
  }, []);
  return (
    <div style={{ marginBottom: 20 }}>
      <div style={{
        fontFamily: 'Syne', fontWeight: 800, fontSize: 13,
        color: 'var(--navy)', textTransform: 'uppercase', letterSpacing: 1,
        marginBottom: 14, paddingBottom: 10, borderBottom: '2px solid var(--navy)',
      }}>🗂 Kategori</div>
      {categories.filter(c => c.id !== 'Semua').map(c => (
        <a key={c.id} href={`#cat-${c.id.replace(/\s+/g,'-')}`} style={{
          display: 'flex', justifyContent: 'space-between', alignItems: 'center',
          padding: '10px 12px', borderRadius: 8, marginBottom: 4,
          textDecoration: 'none', transition: 'background .15s',
        }} onMouseEnter={e => e.currentTarget.style.background = 'var(--cream-dark)'}
           onMouseLeave={e => e.currentTarget.style.background = 'transparent'}>
          <span style={{ fontSize: 13, color: 'var(--text-main)', fontWeight: 600 }}>{c.id}</span>
          <span style={{
            background: c.bg, color: c.color,
            padding: '2px 10px', borderRadius: 12,
            fontSize: 11, fontWeight: 700,
          }}>{counts[c.id] || 0}</span>
        </a>
      ))}
    </div>
  );
}

function SidebarTags() {
  const tags = [...new Set(articles.flatMap(a => a.tags))];
  return (
    <div style={{ marginBottom: 20 }}>
      <div style={{
        fontFamily: 'Syne', fontWeight: 800, fontSize: 13,
        color: 'var(--navy)', textTransform: 'uppercase', letterSpacing: 1,
        marginBottom: 14, paddingBottom: 10, borderBottom: '2px solid var(--navy)',
      }}>🏷 Tags Populer</div>
      <div style={{ display: 'flex', gap: 6, flexWrap: 'wrap' }}>
        {tags.map(t => (
          <a key={t} href="#" style={{
            padding: '4px 10px', background: 'var(--cream-dark)',
            borderRadius: 12, fontSize: 11, color: 'var(--text-mid)',
            textDecoration: 'none', fontWeight: 600,
          }}>#{t}</a>
        ))}
      </div>
    </div>
  );
}

function StickyConsultCTA() {
  return (
    <div style={{
      background: 'linear-gradient(135deg, var(--gold) 0%, #e8a90b 100%)',
      borderRadius: 16, padding: 22, color: 'var(--navy)',
      boxShadow: '0 8px 24px rgba(245,185,28,0.3)',
    }}>
      <div style={{ fontSize: 28, marginBottom: 8 }}>💬</div>
      <div style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 18, marginBottom: 6, letterSpacing: -0.3, lineHeight: 1.2 }}>
        Butuh Konsultasi Langsung?
      </div>
      <p style={{ fontSize: 12, lineHeight: 1.6, marginBottom: 14, color: 'rgba(11,17,32,0.75)' }}>
        Diskusikan kebutuhan ekspor-impormu dengan tim ahli M2B. Gratis, respon dalam 5 menit.
      </p>
      <a href="https://wa.me/6281263027818" target="_blank" rel="noopener noreferrer" style={{
        display: 'block', textAlign: 'center', textDecoration: 'none',
        padding: '10px', background: 'var(--navy)', color: 'var(--cream)',
        borderRadius: 8, fontWeight: 800, fontSize: 13,
      }}>WhatsApp Sekarang →</a>
      <div style={{ fontSize: 10, marginTop: 8, textAlign: 'center', color: 'rgba(11,17,32,0.5)' }}>
        +62 812-6302-7818 · sales@m2b.co.id
      </div>
    </div>
  );
}

// ─── Main Article Grid + Sidebar ─────────────────────────────────────────
function ArticleSection() {
  const [active, setActive] = useState('Semua');
  const filtered = active === 'Semua' ? articles : articles.filter(a => a.cat === active);

  // Splice in-feed ads every 3 cards
  const grid = [];
  filtered.forEach((a, i) => {
    grid.push({ type: 'article', article: a });
    if ((i + 1) % 3 === 0 && i < filtered.length - 1) {
      grid.push({ type: 'ad', slot: `SLOT_E_INFEED (#${Math.floor(i / 3) + 1})` });
    }
  });

  return (
    <section style={{ padding: '48px 32px', background: 'var(--cream)' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto' }}>
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 300px', gap: 40 }}>
          {/* Main grid */}
          <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 22 }}>
              <h2 style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 24, color: 'var(--navy)', letterSpacing: -0.6 }}>
                Semua Artikel
              </h2>
              <div style={{ fontSize: 12, color: 'var(--text-soft)' }}>
                {filtered.length} artikel · diurutkan dari terbaru
              </div>
            </div>

            <CategoryFilter active={active} setActive={setActive} />

            {/* Leaderboard ad above grid */}
            <div className="ad-placeholder" data-slot="SLOT_A_LEADERBOARD (728×90)" style={{
              width: '100%', height: 90, marginBottom: 24,
            }}>728×90 LEADERBOARD</div>

            {/* Article grid with in-feed ads */}
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(2, 1fr)', gap: 20 }}>
              {grid.map((item, i) => (
                item.type === 'article'
                  ? <ArticleCard key={item.article.slug} article={item.article} />
                  : <InFeedAd key={'ad-' + i} slot={item.slot} />
              ))}
            </div>

            {/* Lead Magnet CTA */}
            <LeadMagnetCTA />

            {/* Pagination */}
            <div style={{ display: 'flex', justifyContent: 'center', gap: 6, marginTop: 24 }}>
              {[1, 2, 3, 4, 5].map(p => (
                <button key={p} style={{
                  width: 36, height: 36, borderRadius: 18, border: 'none',
                  background: p === 1 ? 'var(--navy)' : 'var(--warm-white)',
                  color: p === 1 ? 'var(--cream)' : 'var(--text-mid)',
                  fontWeight: 700, fontSize: 13, cursor: 'pointer',
                  fontFamily: 'inherit',
                  border: p === 1 ? 'none' : '1px solid var(--cream-dark)',
                }}>{p}</button>
              ))}
              <button style={{
                padding: '0 14px', height: 36, borderRadius: 18, border: '1px solid var(--cream-dark)',
                background: 'var(--warm-white)', color: 'var(--text-mid)', cursor: 'pointer',
                fontWeight: 700, fontSize: 13, fontFamily: 'inherit',
              }}>Berikutnya →</button>
            </div>
          </div>

          {/* Sidebar */}
          <aside>
            <div style={{ position: 'sticky', top: 90 }}>
              <StickyConsultCTA />
              <div style={{ height: 20 }} />
              <NewsletterSignup />
              <SidebarRecent />
              <SidebarCategories />
              <SidebarAd />
              <SidebarTags />
            </div>
          </aside>
        </div>
      </div>
    </section>
  );
}

// ─── Editor's Picks / Curated Lists ──────────────────────────────────────
function EditorPicks() {
  const lists = [
    { icon: '🚀', title: 'Panduan UMKM Go Global', desc: 'Series lengkap untuk UMKM yang ingin mulai ekspor', count: 12, color: 'var(--cat-umkm)' },
    { icon: '🇨🇳', title: 'Impor dari China', desc: 'Tips & strategi impor dari supplier China', count: 8, color: 'var(--cat-impor)' },
    { icon: '📋', title: 'Update Regulasi 2026', desc: 'Aturan baru bea cukai & perdagangan internasional', count: 6, color: 'var(--cat-bea)' },
    { icon: '💰', title: 'Hemat Biaya Logistik', desc: 'Cara potong cost shipping tanpa kompromi kualitas', count: 9, color: 'var(--cat-ekspor)' },
  ];
  return (
    <section style={{ background: 'var(--warm-white)', padding: '56px 32px', borderTop: '1px solid var(--cream-dark)' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 36 }}>
          <span style={{
            background: 'rgba(245,185,28,0.18)', color: 'var(--gold-dim)',
            padding: '4px 12px', borderRadius: 20, fontSize: 11,
            fontWeight: 800, letterSpacing: 1, textTransform: 'uppercase',
          }}>📚 Reading Lists</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 32,
            color: 'var(--navy)', letterSpacing: -0.8, marginTop: 14, marginBottom: 8,
          }}>Editor's Curated Collections</h2>
          <p style={{ color: 'var(--text-mid)', fontSize: 14, maxWidth: 500, margin: '0 auto' }}>
            Series artikel terkurasi sesuai topik — baca berurutan untuk pemahaman maksimal.
          </p>
        </div>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: 16 }}>
          {lists.map((l, i) => (
            <a key={i} href="#" style={{
              padding: 22, borderRadius: 16, textDecoration: 'none',
              background: 'var(--cream)', border: '1px solid var(--cream-dark)',
              transition: 'all .2s',
            }} onMouseEnter={e => { e.currentTarget.style.transform = 'translateY(-3px)'; e.currentTarget.style.boxShadow = '0 12px 32px rgba(11,17,32,0.08)'; }}
               onMouseLeave={e => { e.currentTarget.style.transform = 'none'; e.currentTarget.style.boxShadow = 'none'; }}>
              <div style={{ fontSize: 32, marginBottom: 12 }}>{l.icon}</div>
              <div style={{
                fontFamily: 'Syne', fontWeight: 800, fontSize: 16,
                color: 'var(--navy)', marginBottom: 6, lineHeight: 1.25,
              }}>{l.title}</div>
              <div style={{ fontSize: 12, color: 'var(--text-mid)', lineHeight: 1.6, marginBottom: 14 }}>{l.desc}</div>
              <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', fontSize: 12 }}>
                <span style={{ color: l.color, fontWeight: 700 }}>{l.count} artikel</span>
                <span style={{ color: 'var(--text-soft)' }}>→</span>
              </div>
            </a>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── Trending Topics ──────────────────────────────────────────────────────
function TrendingTopics() {
  const topics = [
    { tag: 'bea cukai 2026', up: '+312%' },
    { tag: 'impor china', up: '+187%' },
    { tag: 'HS code', up: '+98%' },
    { tag: 'UMKM ekspor', up: '+75%' },
    { tag: 'landed cost', up: '+62%' },
    { tag: 'FCL LCL', up: '+44%' },
  ];
  return (
    <section style={{ background: 'var(--navy)', padding: '40px 32px' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: 24, flexWrap: 'wrap' }}>
          <div style={{ flexShrink: 0 }}>
            <div style={{
              fontFamily: 'Syne', fontWeight: 800, fontSize: 24,
              color: 'var(--cream)', letterSpacing: -0.5, lineHeight: 1.2,
            }}>🔥 Topik Trending<br/>Minggu Ini</div>
          </div>
          <div style={{ flex: 1, display: 'flex', gap: 10, flexWrap: 'wrap' }}>
            {topics.map((t, i) => (
              <a key={i} href="#" style={{
                padding: '10px 16px', borderRadius: 16,
                background: 'rgba(248,245,238,0.06)', border: '1px solid rgba(248,245,238,0.1)',
                textDecoration: 'none', display: 'flex', alignItems: 'center', gap: 10,
                transition: 'all .15s',
              }} onMouseEnter={e => { e.currentTarget.style.background = 'rgba(245,185,28,0.15)'; e.currentTarget.style.borderColor = 'var(--gold)'; }}
                 onMouseLeave={e => { e.currentTarget.style.background = 'rgba(248,245,238,0.06)'; e.currentTarget.style.borderColor = 'rgba(248,245,238,0.1)'; }}>
                <span style={{ color: 'var(--cream)', fontWeight: 600, fontSize: 13 }}>#{t.tag}</span>
                <span style={{
                  background: 'rgba(34,197,94,0.15)', color: '#4ade80',
                  padding: '2px 8px', borderRadius: 10, fontSize: 10, fontWeight: 700,
                }}>{t.up}</span>
              </a>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── Pre-Footer Final CTA ─────────────────────────────────────────────────
function PreFooterCTA() {
  return (
    <section style={{
      background: 'var(--cream-dark)', padding: '60px 32px',
      borderTop: '1px solid var(--cream-dark)',
    }}>
      <div style={{ maxWidth: 900, margin: '0 auto', textAlign: 'center' }}>
        <span style={{
          background: 'var(--gold)', color: 'var(--navy)',
          padding: '5px 14px', borderRadius: 20, fontSize: 11,
          fontWeight: 800, letterSpacing: 1, textTransform: 'uppercase',
        }}>🎯 1-on-1 Consultation</span>
        <h2 style={{
          fontFamily: 'Syne', fontWeight: 800, fontSize: 36,
          color: 'var(--navy)', letterSpacing: -1, marginTop: 16, marginBottom: 14, lineHeight: 1.1,
        }}>Baca artikel saja belum cukup?</h2>
        <p style={{
          fontSize: 16, color: 'var(--text-mid)', lineHeight: 1.7,
          maxWidth: 540, margin: '0 auto 28px',
        }}>
          Tim ahli M2B siap mendampingi langsung kebutuhan ekspor-impor bisnismu — dari konsultasi awal, dokumentasi, hingga shipment door-to-door.
        </p>
        <div style={{ display: 'flex', gap: 12, justifyContent: 'center', flexWrap: 'wrap' }}>
          <a href="https://wa.me/6281263027818" target="_blank" rel="noopener noreferrer" style={{
            background: '#25D366', color: '#fff',
            padding: '13px 28px', borderRadius: 20,
            fontWeight: 800, fontSize: 14, textDecoration: 'none',
            display: 'inline-flex', alignItems: 'center', gap: 8,
          }}>💬 Chat WhatsApp Sekarang</a>
          <a href="M2B Landing Page.html#about" style={{
            background: 'transparent', color: 'var(--navy)',
            padding: '13px 28px', borderRadius: 20,
            border: '1.5px solid var(--navy)',
            fontWeight: 700, fontSize: 14, textDecoration: 'none',
          }}>Pelajari Layanan M2B</a>
        </div>
      </div>
    </section>
  );
}

// ─── Footer (consistent with landing) ────────────────────────────────────
function Footer() {
  return (
    <footer style={{ background: '#ffffff', borderTop: '4px solid var(--navy)', padding: '56px 32px 24px' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto' }}>
        <div style={{ display: 'grid', gridTemplateColumns: '1.4fr 1fr 1fr 1fr', gap: 40, marginBottom: 40 }}>
          <div>
            <img src="assets/logo-m2b-clean.png" alt="M2B" style={{ height: 64, marginBottom: 14, filter: 'drop-shadow(0 4px 12px rgba(11,17,32,0.12))' }} />
            <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 14, color: 'var(--navy)', marginBottom: 6 }}>PT. Mora Multi Berkah</div>
            <div style={{ fontSize: 12, color: 'var(--text-soft)', lineHeight: 1.7, marginBottom: 16 }}>
              Freight Forwarder & Customs Broker.<br/>Medan, Sumatera Utara.
            </div>
            <div style={{ display: 'flex', gap: 8 }}>
              {['💼','📷','📘','▶'].map((i, k) => (
                <a key={k} href="#" style={{
                  width: 32, height: 32, borderRadius: 8,
                  border: '1px solid var(--cream-dark)', background: 'var(--cream)',
                  display: 'flex', alignItems: 'center', justifyContent: 'center',
                  fontSize: 13, textDecoration: 'none',
                }}>{i}</a>
              ))}
            </div>
          </div>
          {[
            { title: 'Topik', links: ['Ekspor','Impor','UMKM','Bea Cukai','Tips & Info'] },
            { title: 'Resources', links: ['Semua Artikel','Arsip','Tags','Newsletter','E-Book ↗'] },
            { title: 'Perusahaan', links: ['About M2B','Layanan','Kontak','Portal M2B ↗'] },
          ].map(col => (
            <div key={col.title}>
              <div style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 12, color: 'var(--gold-dim)', textTransform: 'uppercase', letterSpacing: 1, marginBottom: 16 }}>{col.title}</div>
              {col.links.map(l => (
                <div key={l} style={{ marginBottom: 10 }}>
                  <a href="#" style={{ color: 'var(--text-mid)', textDecoration: 'none', fontSize: 13 }}>{l}</a>
                </div>
              ))}
            </div>
          ))}
        </div>
        <div style={{
          borderTop: '1px solid var(--cream-dark)', paddingTop: 20,
          display: 'flex', justifyContent: 'space-between', flexWrap: 'wrap', gap: 12,
          fontSize: 12, color: 'var(--text-soft)',
        }}>
          <span>© 2026 PT. Mora Multi Berkah. All rights reserved.</span>
          <span style={{ color: 'var(--gold-dim)', fontWeight: 700 }}>LOGISTIC · SOLUTION · PARTNER</span>
        </div>
      </div>
    </footer>
  );
}

// ─── Reading Progress Bar (shows at top while scrolling) ─────────────────
function ReadingProgress() {
  const [w, setW] = useState(0);
  useEffect(() => {
    const fn = () => {
      const scroll = window.scrollY;
      const height = document.documentElement.scrollHeight - window.innerHeight;
      setW(height > 0 ? (scroll / height) * 100 : 0);
    };
    window.addEventListener('scroll', fn);
    return () => window.removeEventListener('scroll', fn);
  }, []);
  return <div className="reading-progress" style={{ width: `${w}%` }} />;
}

// ─── WhatsApp Float (consistent with landing) ────────────────────────────
function WhatsAppFloat() {
  const [hover, setHover] = useState(false);
  return (
    <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20baca%20blog-nya%20dan%20ingin%20konsultasi" target="_blank" rel="noopener noreferrer"
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        position: 'fixed', bottom: 24, right: 24, zIndex: 50,
        display: 'flex', alignItems: 'center', gap: 10,
        background: '#25D366', color: '#fff',
        padding: hover ? '14px 22px' : '14px 16px',
        borderRadius: 999, boxShadow: '0 8px 28px rgba(37,211,102,0.45)',
        textDecoration: 'none', fontWeight: 700, fontSize: 14,
        transition: 'all .25s',
      }}>
      <svg width="22" height="22" viewBox="0 0 24 24" fill="#fff">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
      <span style={{ maxWidth: hover ? 200 : 0, overflow: 'hidden', whiteSpace: 'nowrap', transition: 'max-width .25s' }}>
        Chat dengan tim M2B
      </span>
    </a>
  );
}

// ─── App ──────────────────────────────────────────────────────────────────
function App() {
  return (
    <>
      <ReadingProgress />
      <NewsTicker />
      <Nav />
      <Hero />
      <StatsBanner />
      <ArticleSection />
      <EditorPicks />
      <TrendingTopics />
      <PreFooterCTA />
      <Footer />
      <WhatsAppFloat />
    </>
  );
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(<App />);
