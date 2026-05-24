const { useState, useEffect, useRef } = React;

// ─── Nav (same as Blog) ───────────────────────────────────────────────────
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
      <div style={{ maxWidth: 1200, margin: '0 auto', padding: '0 32px', height: 88, display: 'flex', alignItems: 'center', gap: 24 }}>
        <a href="M2B Landing Page.html" style={{ display: 'flex', alignItems: 'center', gap: 16, flexShrink: 0, textDecoration: 'none' }}>
          <img src="assets/logo-m2b-clean.png" alt="M2B" style={{ height: 60, filter: 'drop-shadow(0 4px 12px rgba(11,17,32,0.18))' }} />
          <div style={{ display: 'flex', flexDirection: 'column', lineHeight: 1.1, borderLeft: '1.5px solid var(--cream-dark)', paddingLeft: 16 }}>
            <span style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 17, color: 'var(--navy)', letterSpacing: -0.3, marginBottom: 4 }}>PT. Mora Multi Berkah</span>
            <span style={{ fontSize: 10.5, color: 'var(--crimson)', fontWeight: 700, letterSpacing: 1.6 }}>LOGISTIC · SOLUTION · PARTNER</span>
          </div>
        </a>

        <div style={{ display: 'flex', gap: 4, flex: 1, justifyContent: 'center' }}>
          {[
            { l: 'Beranda', href: 'M2B Landing Page.html' },
            { l: 'Layanan', href: 'M2B Landing Page.html#layanan' },
            { l: 'Blog', href: 'M2B Blog.html' },
            { l: 'Tentang', href: '#', active: true },
            { l: 'Kontak', href: 'M2B Landing Page.html#about' },
          ].map(item => (
            <a key={item.l} href={item.href} style={{
              padding: '6px 14px', borderRadius: 20,
              fontSize: 13, fontWeight: 600, textDecoration: 'none',
              color: item.active ? 'var(--cream)' : 'var(--text-mid)',
              background: item.active ? 'var(--navy)' : 'transparent',
              transition: 'all .15s',
            }}>{item.l}</a>
          ))}
        </div>

        <a href="https://wa.me/6281263027818" target="_blank" rel="noopener noreferrer" style={{
          padding: '9px 18px', borderRadius: 20, background: 'var(--gold)', color: 'var(--navy)',
          fontWeight: 800, fontSize: 13, textDecoration: 'none', flexShrink: 0,
          boxShadow: '0 4px 12px rgba(245,185,28,0.3)',
        }}>Konsultasi Gratis</a>
      </div>
    </nav>
  );
}

// ─── Hero ─────────────────────────────────────────────────────────────────
function Hero() {
  return (
    <section style={{
      background: 'linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%)',
      padding: '80px 32px 100px', position: 'relative', overflow: 'hidden',
    }}>
      {/* Decorative gradient */}
      <div style={{
        position: 'absolute', top: -150, right: -100, width: 500, height: 500,
        background: `radial-gradient(circle, var(--gold) 0%, transparent 65%)`,
        opacity: 0.12, pointerEvents: 'none',
      }} />

      <div style={{ maxWidth: 1100, margin: '0 auto', position: 'relative' }}>
        {/* Breadcrumb */}
        <div style={{ fontSize: 12, color: 'rgba(248,245,238,0.5)', marginBottom: 18 }}>
          <a href="M2B Landing Page.html" style={{ color: 'rgba(248,245,238,0.5)', textDecoration: 'none' }}>Home</a>
          <span style={{ margin: '0 8px' }}>/</span>
          <span style={{ color: 'var(--gold)', fontWeight: 600 }}>Tentang Kami</span>
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: '1.4fr 1fr', gap: 56, alignItems: 'center' }}>
          <div>
            <span style={{
              display: 'inline-block', padding: '5px 14px', borderRadius: 20,
              background: 'rgba(245,185,28,0.18)', color: 'var(--gold)',
              fontSize: 11, fontWeight: 800, letterSpacing: 1.4, textTransform: 'uppercase',
              marginBottom: 24,
            }}>Tentang PT. Mora Multi Berkah</span>

            <h1 style={{
              fontFamily: 'Syne', fontWeight: 800, fontSize: 52, lineHeight: 1.06,
              color: 'var(--cream)', letterSpacing: -1.8, marginBottom: 24,
            }}>
              Membantu UMKM Indonesia<br/>
              <span style={{ color: 'var(--gold)' }}>menembus pasar global</span><br/>
              sejak 2019.
            </h1>

            <p style={{
              fontFamily: 'Lora', fontSize: 18, color: 'rgba(248,245,238,0.78)',
              lineHeight: 1.75, maxWidth: 540, marginBottom: 32, fontStyle: 'italic',
            }}>
              Kami bukan freight forwarder terbesar. Tapi kami percaya, di balik setiap shipment ada bisnis dengan mimpi — dan tugas kami adalah memastikan mimpi itu sampai ke tujuannya, tepat waktu dan tepat biaya.
            </p>

            <div style={{ display: 'flex', gap: 12, flexWrap: 'wrap' }}>
              <a href="#cerita" style={{
                background: 'var(--gold)', color: 'var(--navy)',
                padding: '12px 24px', borderRadius: 10,
                fontWeight: 800, fontSize: 14, textDecoration: 'none',
                display: 'inline-flex', alignItems: 'center', gap: 8,
              }}>📖 Baca Cerita Kami</a>
              <a href="https://wa.me/6281263027818" target="_blank" rel="noopener noreferrer" style={{
                border: '1.5px solid rgba(248,245,238,0.3)',
                color: 'var(--cream)', padding: '12px 24px', borderRadius: 10,
                fontWeight: 700, fontSize: 14, textDecoration: 'none',
              }}>💬 Bicara dengan Kami</a>
            </div>
          </div>

          {/* Director Card */}
          <div style={{ position: 'relative' }}>
            <div style={{
              background: 'var(--cream)',
              borderRadius: 20, padding: 28,
              boxShadow: '0 24px 64px rgba(0,0,0,0.4)',
              border: '1px solid rgba(248,245,238,0.1)',
              transform: 'rotate(2deg)',
            }}>
              <div style={{
                aspectRatio: '4/5', borderRadius: 14, overflow: 'hidden',
                marginBottom: 18, position: 'relative',
                background: 'linear-gradient(135deg, #d5d0c8 0%, #b8b3aa 100%)',
              }}>
                <div style={{
                  position: 'absolute', inset: 0,
                  display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center',
                  color: 'rgba(0,0,0,0.3)', fontSize: 13, gap: 8,
                }}>
                  <div style={{ fontSize: 64 }}>👤</div>
                  <div>Foto Direktur</div>
                  <div style={{ fontSize: 11, color: 'rgba(0,0,0,0.4)' }}>(upload via tweak)</div>
                </div>
                {/* Gold accent corner */}
                <div style={{
                  position: 'absolute', top: 0, right: 0,
                  width: 40, height: 40,
                  background: 'var(--gold)',
                  clipPath: 'polygon(100% 0, 100% 100%, 0 0)',
                }} />
              </div>
              <div style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 18, color: 'var(--navy)', letterSpacing: -0.2 }}>Eka Mayang Sari</div>
              <div style={{ fontSize: 13, color: 'var(--text-mid)', marginTop: 2, marginBottom: 12 }}>Direktur — PT. Mora Multi Berkah</div>
              <div style={{ display: 'flex', alignItems: 'center', gap: 6, fontSize: 11, color: 'var(--gold-dim)' }}>
                <span style={{ width: 6, height: 6, borderRadius: '50%', background: 'var(--gold)' }} />
                <span style={{ fontWeight: 700 }}>5+ tahun di industri logistik Indonesia</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── Story Section ────────────────────────────────────────────────────────
function StorySection() {
  return (
    <section id="cerita" style={{ background: 'var(--cream)', padding: '88px 32px' }}>
      <div style={{ maxWidth: 880, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 56 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(245,185,28,0.18)', color: 'var(--gold-dim)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase',
            marginBottom: 16,
          }}>📖 Cerita Kami</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 40,
            color: 'var(--navy)', letterSpacing: -1.2, lineHeight: 1.1,
          }}>
            Berawal dari satu pertanyaan sederhana:<br/>
            <span style={{ color: 'var(--gold-dim)' }}>"Kenapa logistik harus serumit ini?"</span>
          </h2>
        </div>

        {/* Story body */}
        <div style={{ fontFamily: 'Lora', fontSize: 18, color: 'var(--text-main)', lineHeight: 1.95 }}>
          <p style={{ marginBottom: 24 }}>
            <span style={{
              float: 'left', fontFamily: 'Syne', fontSize: '5em', fontWeight: 900, lineHeight: 0.78,
              marginRight: 12, marginTop: 6, color: 'var(--navy)',
            }}>S</span>
            iang itu di sebuah kafe di Medan, seorang pemilik UKM datang ke kami dengan tumpukan dokumen — invoice salah, packing list tidak match, dan barang yang sudah dua minggu nyangkut di pelabuhan Belawan. Dia sudah membayar tiga jasa berbeda, namun tidak ada yang bisa memberinya kepastian. <strong>Bisnisnya nyaris berhenti.</strong>
          </p>

          <p style={{ marginBottom: 24 }}>
            Cerita itu bukan kasus pertama yang kami dengar. Pada 2019, kami melihat fenomena yang sama berulang: <em>pelaku usaha kecil dan menengah di Sumatera Utara — bahkan di seluruh Indonesia — terbentur tembok logistik internasional yang rumit, mahal, dan tidak transparan.</em> Banyak yang mundur sebelum benar-benar mencoba.
          </p>

          <p style={{
            background: 'var(--warm-white)', borderLeft: `4px solid var(--gold)`,
            padding: '20px 24px', borderRadius: '0 12px 12px 0',
            margin: '32px 0', fontStyle: 'italic',
            color: 'var(--navy)', position: 'relative',
          }} className="quote-mark">
            Kami sadar — masalahnya bukan ekspor-impor itu sendiri. Masalahnya adalah kurangnya partner yang benar-benar peduli. Yang mau menjelaskan, bukan sekadar mengirim invoice.
          </p>

          <p style={{ marginBottom: 24 }}>
            Dari pemikiran itulah <strong>PT. Mora Multi Berkah</strong> lahir. Kami memilih nama "Mora" — dari bahasa Latin yang berarti <em>"persinggahan"</em> atau tempat berhenti dalam perjalanan panjang. Karena begitulah peran yang ingin kami isi: <strong>tempat singgah yang andal dalam perjalanan barang dari satu titik ke titik lainnya</strong>, di mana pun di dunia.
          </p>

          <p style={{ marginBottom: 24 }}>
            Mulai dari kantor kecil di kawasan Graha Metropolitan dengan tim 3 orang, kami menangani shipment pertama: pengiriman <strong>50 dus produk makanan ringan dari UKM Medan ke Malaysia</strong>. Klien itu masih bersama kami sampai sekarang — sekarang mereka mengekspor ke 8 negara.
          </p>

          <h3 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 24,
            color: 'var(--navy)', marginTop: 48, marginBottom: 16, letterSpacing: -0.5,
          }}>Yang berubah, yang tetap.</h3>

          <p style={{ marginBottom: 24 }}>
            Lima tahun berlalu. Tim kami sekarang lebih dari 15 orang. Klien aktif kami mencapai 100+ pelaku usaha — dari UMKM yang baru mau coba ekspor, hingga perusahaan besar yang mengirim ratusan kontainer per bulan. Kami melayani lebih dari 20 negara dan menjadi mitra resmi Dirjen Bea Cukai, terdaftar di ALFI, KADIN, dan LNSW.
          </p>

          <p style={{ marginBottom: 24 }}>
            Tapi <strong>satu hal yang tidak berubah:</strong> komitmen kami menjawab telepon klien sebelum dering kelima. Menjelaskan setiap rincian biaya — bahkan yang Rp 50.000. Memberi tahu jika ada penundaan, sebelum klien yang bertanya. Membantu klien yang baru pertama kali ekspor seperti kami membantu klien tetap.
          </p>

          <p style={{ marginBottom: 16 }}>
            Karena kami percaya, <strong>freight forwarder bukan profesi tentang kontainer dan dokumen.</strong> Ini profesi tentang kepercayaan — dan setiap shipment adalah ujiannya.
          </p>

          <p style={{ marginBottom: 0, textAlign: 'right', fontStyle: 'italic', color: 'var(--text-mid)', fontSize: 16 }}>
            — Tim PT. Mora Multi Berkah, Medan
          </p>
        </div>
      </div>
    </section>
  );
}

// ─── Timeline ─────────────────────────────────────────────────────────────
function Timeline() {
  const milestones = [
    { year: '2019', title: 'M2B Didirikan', desc: 'PT. Mora Multi Berkah resmi berdiri di Medan dengan tim 3 orang. Shipment pertama: 50 dus makanan ringan UKM ke Malaysia.', icon: '🌱' },
    { year: '2020', title: 'Resmi Terdaftar di Bea Cukai', desc: 'Mendapat izin resmi sebagai PPJK (Pengusaha Pengurusan Jasa Kepabeanan). Sertifikasi NIB & NPWP lengkap.', icon: '📋' },
    { year: '2021', title: 'Ekspansi ke Asia Timur', desc: 'Mulai melayani rute reguler China–Indonesia. Tim grow ke 8 orang. Mencapai 30+ klien aktif.', icon: '🌏' },
    { year: '2022', title: 'Bergabung dengan ALFI & KADIN', desc: 'Menjadi anggota resmi asosiasi logistik nasional. Mulai melayani impor B2B skala menengah.', icon: '🤝' },
    { year: '2023', title: 'Layanan Door-to-Door', desc: 'Meluncurkan layanan end-to-end ke 15+ negara. Total kontainer dilayani per tahun: 200+.', icon: '🚚' },
    { year: '2024', title: 'Portal Digital M2B', desc: 'Launching dashboard online untuk klien — tracking real-time, dokumen digital, dan kalkulator biaya impor.', icon: '💻' },
    { year: '2026', title: 'Hari Ini', desc: '100+ klien aktif, 20+ negara tujuan, tim 15+ profesional logistik. Misi belum selesai.', icon: '⭐', active: true },
  ];

  return (
    <section style={{ background: 'var(--warm-white)', padding: '80px 32px', borderTop: '1px solid var(--cream-dark)' }}>
      <div style={{ maxWidth: 900, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 48 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(11,17,32,0.06)', color: 'var(--navy)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase',
            marginBottom: 14,
          }}>📅 Perjalanan Kami</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 36,
            color: 'var(--navy)', letterSpacing: -1, lineHeight: 1.1,
          }}>Tujuh tahun, banyak shipment, satu komitmen.</h2>
        </div>

        <div style={{ position: 'relative', paddingLeft: 48 }}>
          {/* Vertical line */}
          <div style={{
            position: 'absolute', left: 0, top: 8, bottom: 8,
            width: 2, background: 'linear-gradient(180deg, var(--gold) 0%, var(--cream-dark) 100%)',
          }} />

          {milestones.map((m, i) => (
            <div key={i} style={{ position: 'relative', paddingBottom: 32, marginBottom: 0 }}>
              <div className="timeline-dot" style={m.active ? { background: 'var(--crimson)', boxShadow: `0 0 0 4px rgba(139,30,43,0.18), 0 0 0 8px rgba(139,30,43,0.08)` } : {}} />
              <div style={{
                background: 'var(--cream)', borderRadius: 14,
                padding: '20px 24px', border: `1px solid ${m.active ? 'var(--crimson)' : 'var(--cream-dark)'}`,
                position: 'relative',
                boxShadow: m.active ? '0 8px 28px rgba(139,30,43,0.12)' : '0 1px 4px rgba(0,0,0,0.03)',
              }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: 12, marginBottom: 8 }}>
                  <span style={{ fontSize: 22 }}>{m.icon}</span>
                  <span style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 18, color: m.active ? 'var(--crimson)' : 'var(--navy)' }}>{m.year}</span>
                  {m.active && (
                    <span style={{
                      padding: '2px 8px', background: 'var(--crimson)', color: '#fff',
                      borderRadius: 10, fontSize: 9, fontWeight: 800, letterSpacing: 1, textTransform: 'uppercase',
                    }}>Sekarang</span>
                  )}
                </div>
                <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 16, color: 'var(--navy)', marginBottom: 6 }}>{m.title}</div>
                <p style={{ fontSize: 14, color: 'var(--text-mid)', lineHeight: 1.7 }}>{m.desc}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── Mission Vision Values ────────────────────────────────────────────────
function MissionVision() {
  const cards = [
    {
      icon: '🎯',
      label: 'MISI',
      title: 'Membuat ekspor-impor jadi mudah, terutama untuk UMKM.',
      desc: 'Kami menyederhanakan kompleksitas logistik internasional menjadi langkah-langkah jelas yang bisa dipahami siapa saja — bahkan oleh yang baru pertama kali ekspor.',
      color: 'var(--gold)',
    },
    {
      icon: '🔭',
      label: 'VISI',
      title: 'Menjadi mitra logistik terpercaya bagi 1.000 pelaku bisnis Indonesia.',
      desc: 'Bukan jadi yang terbesar — tapi jadi yang paling banyak dipercaya. Karena kepercayaan adalah aset yang tidak bisa dibeli, hanya bisa dibangun setiap shipment.',
      color: 'var(--crimson)',
    },
  ];

  const values = [
    { icon: '🔍', t: 'Transparansi', d: 'Tidak ada biaya tersembunyi. Setiap rupiah kami jelaskan.' },
    { icon: '⚡', t: 'Responsif', d: 'Pesan WhatsApp dijawab dalam menit, bukan jam atau hari.' },
    { icon: '🎓', t: 'Mau Mengajari', d: 'Kami senang menjelaskan, bahkan untuk pertanyaan paling dasar.' },
    { icon: '🤝', t: 'Long-Term', d: 'Klien bukan transaksi. Mereka adalah partner perjalanan.' },
    { icon: '📐', t: 'Detail', d: 'Satu komma salah di PIB bisa berakibat fatal. Kami obsesif soal detail.' },
    { icon: '🛡', t: 'Kepatuhan', d: 'Semua sesuai regulasi. Tidak ada jalan pintas yang melanggar hukum.' },
  ];

  return (
    <section style={{ background: 'var(--cream)', padding: '80px 32px' }}>
      <div style={{ maxWidth: 1100, margin: '0 auto' }}>
        {/* Mission & Vision */}
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 24, marginBottom: 64 }}>
          {cards.map((c, i) => (
            <div key={i} style={{
              background: 'var(--warm-white)', borderRadius: 20,
              padding: '32px 28px', border: `1px solid var(--cream-dark)`,
              borderTop: `5px solid ${c.color}`,
              position: 'relative', overflow: 'hidden',
            }}>
              <div style={{
                position: 'absolute', top: -40, right: -40, width: 160, height: 160,
                background: c.color, opacity: 0.06, borderRadius: '50%',
              }} />
              <div style={{ position: 'relative' }}>
                <div style={{ fontSize: 40, marginBottom: 14 }}>{c.icon}</div>
                <span style={{
                  fontFamily: 'Syne', fontWeight: 800, fontSize: 11,
                  color: c.color, letterSpacing: 2, textTransform: 'uppercase',
                }}>{c.label}</span>
                <h3 style={{
                  fontFamily: 'Syne', fontWeight: 800, fontSize: 22,
                  color: 'var(--navy)', letterSpacing: -0.5, lineHeight: 1.2,
                  marginTop: 8, marginBottom: 14,
                }}>{c.title}</h3>
                <p style={{ fontSize: 15, color: 'var(--text-mid)', lineHeight: 1.75 }}>{c.desc}</p>
              </div>
            </div>
          ))}
        </div>

        {/* Values */}
        <div>
          <div style={{ textAlign: 'center', marginBottom: 32 }}>
            <span style={{
              display: 'inline-block', padding: '4px 12px', borderRadius: 20,
              background: 'rgba(11,17,32,0.06)', color: 'var(--navy)',
              fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase',
              marginBottom: 14,
            }}>Nilai yang Kami Pegang</span>
            <h2 style={{
              fontFamily: 'Syne', fontWeight: 800, fontSize: 28,
              color: 'var(--navy)', letterSpacing: -0.8,
            }}>6 prinsip yang menemani setiap shipment.</h2>
          </div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 16 }}>
            {values.map((v, i) => (
              <div key={i} style={{
                padding: '22px 20px', background: 'var(--warm-white)',
                borderRadius: 14, border: '1px solid var(--cream-dark)',
              }}>
                <div style={{ fontSize: 26, marginBottom: 10 }}>{v.icon}</div>
                <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 16, color: 'var(--navy)', marginBottom: 6 }}>{v.t}</div>
                <p style={{ fontSize: 13, color: 'var(--text-mid)', lineHeight: 1.65 }}>{v.d}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── Numbers ──────────────────────────────────────────────────────────────
function Numbers() {
  const stats = [
    { num: '5+', label: 'Tahun Berkarya', sub: 'di industri logistik Indonesia' },
    { num: '100+', label: 'Klien Aktif', sub: 'dari UMKM hingga korporasi' },
    { num: '20+', label: 'Negara Tujuan', sub: 'di Asia, Eropa, Amerika' },
    { num: '200+', label: 'Kontainer/Tahun', sub: 'dilayani dengan aman' },
    { num: '94%', label: 'On-Time Delivery', sub: 'sesuai ETA yang dijanjikan' },
    { num: '0', label: 'Hidden Cost', sub: 'transparan dari awal hingga akhir' },
  ];

  return (
    <section style={{ background: 'var(--navy)', padding: '72px 32px', color: 'var(--cream)' }}>
      <div style={{ maxWidth: 1100, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 48 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(245,185,28,0.18)', color: 'var(--gold)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase',
            marginBottom: 14,
          }}>By the Numbers</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 36,
            color: 'var(--cream)', letterSpacing: -1, lineHeight: 1.1,
          }}>Angka yang kami tumbuhkan,<br/>bersama klien-klien kami.</h2>
        </div>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 0 }}>
          {stats.map((s, i) => (
            <div key={i} style={{
              padding: '32px 28px', textAlign: 'center',
              borderRight: (i + 1) % 3 !== 0 ? '1px solid rgba(248,245,238,0.08)' : 'none',
              borderBottom: i < 3 ? '1px solid rgba(248,245,238,0.08)' : 'none',
            }}>
              <div style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 56, color: 'var(--gold)', lineHeight: 1 }}>{s.num}</div>
              <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 15, marginTop: 12, marginBottom: 6 }}>{s.label}</div>
              <div style={{ fontSize: 12, color: 'rgba(248,245,238,0.55)', lineHeight: 1.6 }}>{s.sub}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── Office + Legalitas ───────────────────────────────────────────────────
function OfficeAndLegal() {
  return (
    <section style={{ background: 'var(--warm-white)', padding: '80px 32px' }}>
      <div style={{ maxWidth: 1100, margin: '0 auto' }}>
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 48, alignItems: 'center', marginBottom: 64 }}>
          <div>
            <span style={{
              display: 'inline-block', padding: '4px 12px', borderRadius: 20,
              background: 'rgba(245,185,28,0.18)', color: 'var(--gold-dim)',
              fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase',
              marginBottom: 14,
            }}>🏢 Kantor Kami</span>
            <h2 style={{
              fontFamily: 'Syne', fontWeight: 800, fontSize: 30,
              color: 'var(--navy)', letterSpacing: -0.8, lineHeight: 1.15, marginBottom: 16,
            }}>Datang langsung. Pintu kami terbuka.</h2>
            <p style={{ fontSize: 15, color: 'var(--text-mid)', lineHeight: 1.75, marginBottom: 24 }}>
              Kami percaya hubungan bisnis terbaik dibangun lewat tatap muka. Mampir ke kantor kami di Medan — kami siapkan kopi dan diskusi tentang kebutuhan logistik bisnismu.
            </p>
            <div style={{ background: 'var(--cream)', borderRadius: 14, padding: '20px 22px', border: '1px solid var(--cream-dark)' }}>
              <div style={{ fontSize: 11, color: 'var(--text-soft)', textTransform: 'uppercase', letterSpacing: 1, fontWeight: 700, marginBottom: 4 }}>Alamat Kantor</div>
              <div style={{ fontFamily: 'Syne', fontSize: 16, fontWeight: 700, color: 'var(--navy)', marginBottom: 14, lineHeight: 1.45 }}>
                Jl. Kapten Sumarsono,<br/>Komp. Graha Metropolitan Blok G No. 14<br/>Medan – 20114
              </div>
              <div style={{ display: 'flex', gap: 12, fontSize: 13 }}>
                <a href="https://maps.app.goo.gl/qxDf2EHjkEngXNGP7" target="_blank" rel="noopener noreferrer" style={{
                  background: 'var(--navy)', color: 'var(--cream)',
                  padding: '8px 14px', borderRadius: 8, fontWeight: 700, textDecoration: 'none',
                }}>🧭 Lihat Peta</a>
                <a href="mailto:info@m2b.co.id" style={{
                  border: '1.5px solid var(--cream-dark)', color: 'var(--navy)',
                  padding: '8px 14px', borderRadius: 8, fontWeight: 700, textDecoration: 'none',
                }}>📧 info@m2b.co.id</a>
              </div>
            </div>
          </div>

          {/* Map */}
          <div style={{ borderRadius: 20, overflow: 'hidden', boxShadow: '0 16px 48px rgba(11,17,32,0.12)', border: '1px solid var(--cream-dark)' }}>
            <iframe
              title="M2B Office Location"
              src="https://www.google.com/maps?q=PT+Mora+Multi+Berkah+Medan&output=embed"
              style={{ width: '100%', height: 360, border: 0, display: 'block' }}
              loading="lazy"
            />
          </div>
        </div>

        {/* Legalitas */}
        <div style={{ borderTop: '1px solid var(--cream-dark)', paddingTop: 48 }}>
          <div style={{ textAlign: 'center', marginBottom: 32 }}>
            <span style={{
              display: 'inline-block', padding: '4px 12px', borderRadius: 20,
              background: 'rgba(11,17,32,0.06)', color: 'var(--navy)',
              fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase',
              marginBottom: 14,
            }}>🛡 Legalitas & Kemitraan</span>
            <h3 style={{
              fontFamily: 'Syne', fontWeight: 800, fontSize: 24,
              color: 'var(--navy)', letterSpacing: -0.6,
            }}>Resmi, terdaftar, dan diawasi.</h3>
          </div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(6, 1fr)', gap: 12 }}>
            {['Dirjen Bea Cukai RI','ALFI','KADIN','LNSW','NIB Resmi','NPWP'].map(l => (
              <div key={l} style={{
                padding: '20px 12px', textAlign: 'center',
                background: 'var(--cream)', borderRadius: 10,
                border: '1px solid var(--cream-dark)',
                fontFamily: 'Syne', fontWeight: 700, fontSize: 12,
                color: 'var(--navy)', letterSpacing: 0.3,
              }}>{l}</div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── Final CTA ────────────────────────────────────────────────────────────
function FinalCTA() {
  return (
    <section style={{
      background: 'linear-gradient(135deg, var(--gold) 0%, var(--gold-dim) 100%)',
      padding: '72px 32px', position: 'relative', overflow: 'hidden',
    }}>
      <div style={{
        position: 'absolute', bottom: -100, left: -100, width: 400, height: 400,
        background: 'radial-gradient(circle, var(--navy) 0%, transparent 65%)',
        opacity: 0.1, pointerEvents: 'none',
      }} />
      <div style={{ maxWidth: 800, margin: '0 auto', textAlign: 'center', position: 'relative' }}>
        <h2 style={{
          fontFamily: 'Syne', fontWeight: 800, fontSize: 40,
          color: 'var(--navy)', letterSpacing: -1.2, lineHeight: 1.1, marginBottom: 16,
        }}>Cerita kami sudah selesai.<br/>Sekarang giliran <em style={{ fontStyle: 'italic' }}>ceritamu</em>.</h2>
        <p style={{ fontSize: 17, color: 'rgba(11,17,32,0.75)', lineHeight: 1.7, marginBottom: 32 }}>
          Kami ingin tahu kebutuhan bisnismu. Ceritakan ke kami — tanpa biaya, tanpa komitmen, tanpa basa-basi.
        </p>
        <div style={{ display: 'flex', gap: 14, justifyContent: 'center', flexWrap: 'wrap' }}>
          <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20baca%20cerita%20kalian%20dan%20ingin%20konsultasi" target="_blank" rel="noopener noreferrer" style={{
            background: 'var(--navy)', color: 'var(--cream)',
            padding: '14px 30px', borderRadius: 12,
            fontWeight: 800, fontSize: 15, textDecoration: 'none',
            display: 'inline-flex', alignItems: 'center', gap: 8,
            boxShadow: '0 8px 24px rgba(11,17,32,0.25)',
          }}>💬 Chat dengan Tim M2B</a>
          <a href="M2B Landing Page.html#layanan" style={{
            background: 'transparent', color: 'var(--navy)',
            padding: '14px 30px', borderRadius: 12,
            border: '2px solid var(--navy)',
            fontWeight: 700, fontSize: 15, textDecoration: 'none',
          }}>Lihat Layanan Kami →</a>
        </div>
      </div>
    </section>
  );
}

// ─── Footer ───────────────────────────────────────────────────────────────
function Footer() {
  return (
    <footer style={{ background: '#ffffff', borderTop: '4px solid var(--navy)', padding: '56px 32px 24px' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto' }}>
        <div style={{ display: 'grid', gridTemplateColumns: '1.4fr 1fr 1fr 1fr', gap: 40, marginBottom: 40 }}>
          <div>
            <img src="assets/logo-m2b-clean.png" alt="M2B" style={{ height: 72, marginBottom: 16, filter: 'drop-shadow(0 4px 12px rgba(11,17,32,0.12))' }} />
            <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 15, color: 'var(--navy)', marginBottom: 4 }}>PT. Mora Multi Berkah</div>
            <div style={{ fontSize: 11, color: 'var(--crimson)', fontWeight: 700, letterSpacing: 1.4, marginBottom: 14 }}>LOGISTIC · SOLUTION · PARTNER</div>
            <div style={{ fontSize: 12, color: 'var(--text-soft)', lineHeight: 1.75 }}>
              Jl. Kapten Sumarsono, Komp. Graha Metropolitan Blok G No. 14<br/>Medan – 20114
            </div>
          </div>
          {[
            { title: 'Navigasi', links: [['Beranda','M2B Landing Page.html'],['Layanan','M2B Landing Page.html#layanan'],['Blog','M2B Blog.html'],['Tentang Kami','#']] },
            { title: 'Kontak', links: [['+62 812-6302-7818','tel:+6281263027818'],['info@m2b.co.id','mailto:info@m2b.co.id'],['sales@m2b.co.id','mailto:sales@m2b.co.id'],['Senin–Sabtu · 08–17 WIB','#']] },
            { title: 'Resources', links: [['E-Book ↗','https://ebook.m2b.co.id'],['Toolkit ↗','https://ebook.m2b.co.id/toolkit.html'],['Portal M2B ↗','#'],['Newsletter','#']] },
          ].map(col => (
            <div key={col.title}>
              <div style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 12, color: 'var(--gold-dim)', textTransform: 'uppercase', letterSpacing: 1, marginBottom: 16 }}>{col.title}</div>
              {col.links.map(([l, h]) => (
                <div key={l} style={{ marginBottom: 10 }}>
                  <a href={h} style={{ color: 'var(--text-mid)', textDecoration: 'none', fontSize: 13 }}>{l}</a>
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
          <span>NIB · NPWP · ALFI · KADIN · LNSW · Bea Cukai RI</span>
        </div>
      </div>
    </footer>
  );
}

function WhatsAppFloat() {
  const [hover, setHover] = useState(false);
  return (
    <a href="https://wa.me/6281263027818" target="_blank" rel="noopener noreferrer"
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        position: 'fixed', bottom: 24, right: 24, zIndex: 50,
        display: 'flex', alignItems: 'center', gap: 10,
        background: '#25D366', color: '#fff',
        padding: hover ? '14px 22px' : '14px 16px',
        borderRadius: 999, boxShadow: '0 8px 28px rgba(37,211,102,0.45)',
        textDecoration: 'none', fontWeight: 700, fontSize: 14,
        transition: 'all .25s',
        animation: 'wapulse 2.5s ease-in-out infinite',
      }}>
      <svg width="22" height="22" viewBox="0 0 24 24" fill="#fff">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
      <span style={{ maxWidth: hover ? 200 : 0, overflow: 'hidden', whiteSpace: 'nowrap', transition: 'max-width .25s' }}>
        Chat dengan Tim M2B
      </span>
    </a>
  );
}

// ─── App ──────────────────────────────────────────────────────────────────
function App() {
  return (
    <>
      <Nav />
      <Hero />
      <StorySection />
      <Timeline />
      <MissionVision />
      <Numbers />
      <OfficeAndLegal />
      <FinalCTA />
      <Footer />
      <WhatsAppFloat />
    </>
  );
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(<App />);
