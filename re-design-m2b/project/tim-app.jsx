const { useState, useEffect } = React;

// ─── Shared Nav ───────────────────────────────────────────────────────────
function Nav({ active = 'Tim' }) {
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
            { l: 'Tentang', href: 'M2B About.html' },
            { l: 'Tim', href: '#', active: active === 'Tim' },
            { l: 'Karir', href: 'M2B Karir.html', active: active === 'Karir' },
          ].map(item => (
            <a key={item.l} href={item.href} style={{
              padding: '6px 14px', borderRadius: 20, fontSize: 13, fontWeight: 600, textDecoration: 'none',
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

// ─── Hero ────────────────────────────────────────────────────────────────
function Hero() {
  return (
    <section style={{
      background: 'linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%)',
      padding: '88px 32px 100px', position: 'relative', overflow: 'hidden',
    }}>
      <div style={{
        position: 'absolute', top: -150, right: -100, width: 500, height: 500,
        background: `radial-gradient(circle, var(--gold) 0%, transparent 65%)`,
        opacity: 0.12, pointerEvents: 'none',
      }} />
      <div style={{ maxWidth: 1100, margin: '0 auto', position: 'relative', textAlign: 'center' }}>
        <div style={{ fontSize: 12, color: 'rgba(248,245,238,0.5)', marginBottom: 24 }}>
          <a href="M2B Landing Page.html" style={{ color: 'rgba(248,245,238,0.5)', textDecoration: 'none' }}>Home</a>
          <span style={{ margin: '0 8px' }}>/</span>
          <span style={{ color: 'var(--gold)', fontWeight: 600 }}>Tim Kami</span>
        </div>
        <span style={{
          display: 'inline-block', padding: '5px 14px', borderRadius: 20,
          background: 'rgba(245,185,28,0.18)', color: 'var(--gold)',
          fontSize: 11, fontWeight: 800, letterSpacing: 1.4, textTransform: 'uppercase', marginBottom: 24,
        }}>👥 Meet the Team</span>
        <h1 style={{
          fontFamily: 'Syne', fontWeight: 800, fontSize: 56, lineHeight: 1.05,
          color: 'var(--cream)', letterSpacing: -1.8, marginBottom: 22, maxWidth: 820, margin: '0 auto 22px',
        }}>
          Di balik setiap shipment, ada<br/>
          <span style={{ color: 'var(--gold)' }}>tim yang peduli dengan bisnismu.</span>
        </h1>
        <p style={{
          fontFamily: 'Lora', fontSize: 19, color: 'rgba(248,245,238,0.78)',
          lineHeight: 1.7, maxWidth: 620, margin: '0 auto', fontStyle: 'italic',
        }}>
          Kami bukan robot freight forwarder. Kami orang-orang yang memilih industri ini karena percaya logistik bisa jadi lebih manusiawi.
        </p>
      </div>
    </section>
  );
}

// ─── Founder Section ─────────────────────────────────────────────────────
function Founder() {
  return (
    <section style={{ background: 'var(--cream)', padding: '80px 32px', borderTop: '1px solid var(--cream-dark)' }}>
      <div style={{ maxWidth: 1080, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 48 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(139,30,43,0.10)', color: 'var(--crimson)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase', marginBottom: 14,
          }}>👑 Pendiri & Pimpinan</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 32, color: 'var(--navy)', letterSpacing: -0.8,
          }}>Visi yang memulai semuanya.</h2>
        </div>

        <div style={{
          display: 'grid', gridTemplateColumns: '1fr 1.4fr', gap: 48, alignItems: 'center',
          background: 'var(--warm-white)', borderRadius: 24, padding: 40,
          border: '1px solid var(--cream-dark)', boxShadow: '0 16px 48px rgba(11,17,32,0.06)',
        }}>
          {/* Director photo */}
          <div style={{ position: 'relative' }}>
            <div style={{
              aspectRatio: '4/5', borderRadius: 18, overflow: 'hidden',
              background: 'linear-gradient(135deg, #d5d0c8 0%, #b8b3aa 100%)',
              position: 'relative', boxShadow: '0 16px 40px rgba(11,17,32,0.18)',
            }}>
              <div style={{
                position: 'absolute', inset: 0,
                display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center',
                color: 'rgba(0,0,0,0.3)', fontSize: 13, gap: 8,
              }}>
                <div style={{ fontSize: 72 }}>👤</div>
                <div>Foto Direktur</div>
              </div>
              <div style={{
                position: 'absolute', top: 0, right: 0, width: 56, height: 56,
                background: 'var(--gold)', clipPath: 'polygon(100% 0, 100% 100%, 0 0)',
              }} />
              <div style={{
                position: 'absolute', bottom: 16, left: 16,
                background: 'var(--gold)', color: 'var(--navy)',
                padding: '4px 10px', borderRadius: 6,
                fontSize: 10, fontWeight: 800, letterSpacing: 1, textTransform: 'uppercase',
              }}>Founder</div>
            </div>
          </div>
          {/* Bio */}
          <div>
            <div style={{ fontSize: 11, color: 'var(--gold-dim)', fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase', marginBottom: 8 }}>Direktur Utama</div>
            <h3 style={{
              fontFamily: 'Syne', fontWeight: 800, fontSize: 36, color: 'var(--navy)',
              letterSpacing: -1, lineHeight: 1.05, marginBottom: 12,
            }}>Eka Mayang Sari</h3>
            <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap', marginBottom: 20 }}>
              {['5+ Tahun di Logistik','Customs Specialist','Trade Compliance'].map(t => (
                <span key={t} style={{
                  padding: '4px 12px', borderRadius: 14,
                  background: 'var(--cream)', border: '1px solid var(--cream-dark)',
                  fontSize: 11, fontWeight: 600, color: 'var(--text-mid)',
                }}>{t}</span>
              ))}
            </div>
            <p style={{ fontFamily: 'Lora', fontSize: 16, color: 'var(--text-main)', lineHeight: 1.85, marginBottom: 16 }}>
              "Saya membangun M2B karena terlalu sering melihat pelaku UMKM kalah sebelum sempat mencoba — semata karena logistik dianggap terlalu rumit. Kami hadir untuk mengubah cerita itu."
            </p>
            <p style={{ fontSize: 14, color: 'var(--text-mid)', lineHeight: 1.75 }}>
              Eka memulai kariernya di industri logistik internasional pada 2015 sebelum mendirikan PT. Mora Multi Berkah pada 2019. Berpengalaman menangani lebih dari 500 transaksi ekspor-impor lintas negara, ia kini memimpin tim M2B dengan filosofi sederhana: <strong>setiap klien layak diperlakukan seperti satu-satunya klien.</strong>
            </p>
            <div style={{
              marginTop: 24, paddingTop: 20, borderTop: '1px solid var(--cream-dark)',
              display: 'flex', alignItems: 'center', gap: 16, flexWrap: 'wrap',
            }}>
              <a href="mailto:eka@m2b.co.id" style={{
                display: 'inline-flex', alignItems: 'center', gap: 6,
                padding: '8px 14px', background: 'var(--navy)', color: 'var(--cream)',
                borderRadius: 8, textDecoration: 'none', fontSize: 13, fontWeight: 700,
              }}>📧 eka@m2b.co.id</a>
              <a href="#" style={{ fontSize: 13, color: 'var(--text-soft)', textDecoration: 'none' }}>💼 LinkedIn</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── Team Grid ───────────────────────────────────────────────────────────
function TeamGrid() {
  const team = [
    { name: 'Budi Santoso', role: 'Head of Operations', dept: 'Operations', tag: 'Senior · 6 tahun', desc: 'Mengawal semua shipment harian. Hafal jadwal kapal Belawan-Shanghai luar kepala.', color: '#0ea5e9' },
    { name: 'Sari Anjani', role: 'Customs Specialist', dept: 'Customs', tag: 'PPJK Bersertifikat', desc: 'Ahli dalam pengurusan PIB & PEB. Track record: 0 jalur merah di 2024.', color: '#7c3aed' },
    { name: 'Rizky Hidayat', role: 'Senior Sales Consultant', dept: 'Sales', tag: 'Top Performer 2024', desc: 'Konsultan pertama yang dihubungi klien baru. Sabar menjelaskan ekspor untuk pemula.', color: '#16a34a' },
    { name: 'Anissa Putri', role: 'Documentation Lead', dept: 'Docs', tag: 'Detail-Obsessed', desc: 'Memastikan setiap dokumen lolos pemeriksaan. Tidak ada coma tertinggal di tangan Anissa.', color: '#ea580c' },
    { name: 'Doni Pratama', role: 'Fleet Coordinator', dept: 'Logistics', tag: '24/7 Standby', desc: 'Koordinator armada darat & last-mile. Selalu standby untuk shipment urgent.', color: '#dc2626' },
    { name: 'Lina Marsha', role: 'Customer Care Manager', dept: 'CS', tag: 'Avg Respon 4 Menit', desc: 'Suara di balik WhatsApp M2B. Klien bilang Lina lebih tepat waktu dari alarm.', color: '#0891b2' },
    { name: 'Fajar Nugraha', role: 'Trade Compliance', dept: 'Legal', tag: 'Bea Cukai Insider', desc: 'Mengikuti tiap update regulasi DJBC. Pencegah masalah sebelum jadi masalah.', color: '#9333ea' },
    { name: 'Indah Wulandari', role: 'Finance & Billing', dept: 'Finance', tag: 'Transparent', desc: 'Memastikan invoice rinci sampai sen terakhir. Tidak ada surprise di tagihan.', color: '#65a30d' },
  ];

  return (
    <section style={{ background: 'var(--warm-white)', padding: '88px 32px', borderTop: '1px solid var(--cream-dark)' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 48 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(11,17,32,0.06)', color: 'var(--navy)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase', marginBottom: 14,
          }}>🚀 Tim Inti</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 38, color: 'var(--navy)',
            letterSpacing: -1, lineHeight: 1.1, marginBottom: 12,
          }}>Orang-orang yang membuat semuanya<br/>bergerak setiap hari.</h2>
          <p style={{ fontSize: 15, color: 'var(--text-mid)', maxWidth: 540, margin: '0 auto' }}>
            8 profesional dengan total 50+ tahun pengalaman gabungan di industri logistik & customs.
          </p>
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: 20 }}>
          {team.map((m, i) => (
            <TeamCard key={i} member={m} />
          ))}
        </div>
      </div>
    </section>
  );
}

function TeamCard({ member: m }) {
  const [hover, setHover] = useState(false);
  return (
    <div className="member-card"
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        background: 'var(--cream)', borderRadius: 16, overflow: 'hidden',
        border: `1px solid var(--cream-dark)`,
        transition: 'all .25s',
        boxShadow: hover ? '0 16px 40px rgba(11,17,32,0.12)' : '0 1px 4px rgba(0,0,0,0.03)',
        transform: hover ? 'translateY(-4px)' : 'none',
        position: 'relative',
      }}>
      {/* Photo */}
      <div style={{
        aspectRatio: '1', position: 'relative', overflow: 'hidden',
        background: `linear-gradient(135deg, ${m.color}25 0%, ${m.color}10 100%)`,
      }}>
        <div style={{
          position: 'absolute', inset: 0,
          display: 'flex', alignItems: 'center', justifyContent: 'center',
          fontSize: 72, color: m.color, opacity: 0.4,
        }}>👤</div>
        {/* Dept badge */}
        <div style={{
          position: 'absolute', top: 12, left: 12,
          background: m.color, color: '#fff',
          padding: '3px 10px', borderRadius: 10,
          fontSize: 10, fontWeight: 800, letterSpacing: 1, textTransform: 'uppercase',
        }}>{m.dept}</div>
        {/* Tag floating */}
        <div style={{
          position: 'absolute', bottom: 12, left: 12, right: 12,
          background: 'rgba(11,17,32,0.85)', backdropFilter: 'blur(8px)',
          padding: '6px 12px', borderRadius: 6,
          fontSize: 10, color: 'var(--gold)', fontWeight: 700, letterSpacing: 0.5,
          opacity: hover ? 1 : 0, transform: hover ? 'translateY(0)' : 'translateY(8px)',
          transition: 'all .25s',
        }}>⭐ {m.tag}</div>
      </div>
      {/* Info */}
      <div style={{ padding: 18 }}>
        <div style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 16, color: 'var(--navy)', marginBottom: 4 }}>{m.name}</div>
        <div style={{ fontSize: 12, color: m.color, fontWeight: 600, marginBottom: 10 }}>{m.role}</div>
        <p style={{ fontSize: 12, color: 'var(--text-mid)', lineHeight: 1.65 }}>{m.desc}</p>
      </div>
    </div>
  );
}

// ─── Culture / Working at M2B ────────────────────────────────────────────
function Culture() {
  const items = [
    { icon: '☕', t: 'Morning Brief', d: '15 menit setiap pagi — sinkronisasi shipment hari ini, tidak ada yang ketinggalan.' },
    { icon: '📚', t: 'Selalu Belajar', d: 'Setiap regulasi baru → tim langsung training. Klien dapat info paling update.' },
    { icon: '🤝', t: 'Tim Lintas Dept', d: 'Sales, Operations, Customs duduk bersama tiap minggu — tidak ada silos.' },
    { icon: '🎯', t: 'OKR Quarterly', d: 'Target jelas setiap kuartal. Bukan untuk score, tapi untuk grow bareng.' },
    { icon: '🌱', t: 'Career Growth', d: '60% supervisor M2B mulai dari posisi entry. Promosi berbasis hasil.' },
    { icon: '💚', t: 'Work-Life Balance', d: 'Kantor tutup jam 17.00. Tidak ada Slack di luar jam kerja. Period.' },
  ];
  return (
    <section style={{ background: 'var(--cream)', padding: '80px 32px' }}>
      <div style={{ maxWidth: 1100, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 48 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(245,185,28,0.18)', color: 'var(--gold-dim)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase', marginBottom: 14,
          }}>🌟 Cara Kami Bekerja</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 32, color: 'var(--navy)',
            letterSpacing: -0.8, lineHeight: 1.15,
          }}>Budaya kerja yang kami bangun, bersama.</h2>
        </div>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 16 }}>
          {items.map((it, i) => (
            <div key={i} style={{
              padding: '24px 22px', background: 'var(--warm-white)',
              borderRadius: 14, border: '1px solid var(--cream-dark)',
            }}>
              <div style={{ fontSize: 28, marginBottom: 12 }}>{it.icon}</div>
              <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 16, color: 'var(--navy)', marginBottom: 8 }}>{it.t}</div>
              <p style={{ fontSize: 13, color: 'var(--text-mid)', lineHeight: 1.7 }}>{it.d}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── Join Us CTA ─────────────────────────────────────────────────────────
function JoinCTA() {
  return (
    <section style={{
      background: 'linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%)',
      padding: '72px 32px', position: 'relative', overflow: 'hidden',
    }}>
      <div style={{
        position: 'absolute', top: -100, right: -100, width: 400, height: 400,
        background: 'radial-gradient(circle, var(--gold) 0%, transparent 65%)',
        opacity: 0.15, pointerEvents: 'none',
      }} />
      <div style={{ maxWidth: 800, margin: '0 auto', textAlign: 'center', position: 'relative' }}>
        <span style={{
          display: 'inline-block', padding: '5px 14px', borderRadius: 20,
          background: 'rgba(245,185,28,0.18)', color: 'var(--gold)',
          fontSize: 11, fontWeight: 800, letterSpacing: 1.4, textTransform: 'uppercase', marginBottom: 20,
        }}>💼 Career @ M2B</span>
        <h2 style={{
          fontFamily: 'Syne', fontWeight: 800, fontSize: 38, color: 'var(--cream)',
          letterSpacing: -1.2, lineHeight: 1.15, marginBottom: 14,
        }}>Ingin bergabung dengan tim ini?</h2>
        <p style={{ fontSize: 16, color: 'rgba(248,245,238,0.7)', lineHeight: 1.7, marginBottom: 28 }}>
          Kami selalu terbuka untuk berkenalan dengan talent terbaik di industri logistik.
        </p>
        <a href="M2B Karir.html" style={{
          background: 'var(--gold)', color: 'var(--navy)',
          padding: '14px 32px', borderRadius: 12,
          fontWeight: 800, fontSize: 15, textDecoration: 'none',
          display: 'inline-flex', alignItems: 'center', gap: 8,
          boxShadow: '0 8px 24px rgba(245,185,28,0.3)',
        }}>Lihat Karir di M2B →</a>
      </div>
    </section>
  );
}

// ─── Footer (consistent) ─────────────────────────────────────────────────
function Footer() {
  return (
    <footer style={{ background: '#ffffff', borderTop: '4px solid var(--navy)', padding: '56px 32px 24px' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto' }}>
        <div style={{ display: 'grid', gridTemplateColumns: '1.4fr 1fr 1fr 1fr', gap: 40, marginBottom: 40 }}>
          <div>
            <img src="assets/logo-m2b-clean.png" alt="M2B" style={{ height: 72, marginBottom: 16, filter: 'drop-shadow(0 4px 12px rgba(11,17,32,0.12))' }} />
            <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 15, color: 'var(--navy)', marginBottom: 4 }}>PT. Mora Multi Berkah</div>
            <div style={{ fontSize: 11, color: 'var(--crimson)', fontWeight: 700, letterSpacing: 1.4, marginBottom: 14 }}>LOGISTIC · SOLUTION · PARTNER</div>
            <div style={{ fontSize: 12, color: 'var(--text-soft)', lineHeight: 1.75 }}>Medan, Sumatera Utara</div>
          </div>
          {[
            { title: 'Perusahaan', links: [['Tentang','M2B About.html'],['Tim Kami','#'],['Karir','M2B Karir.html'],['Portal M2B ↗','#']] },
            { title: 'Layanan', links: [['Ekspor','M2B Landing Page.html#layanan'],['Impor','M2B Landing Page.html#layanan'],['Customs','M2B Landing Page.html#layanan'],['Door-to-Door','M2B Landing Page.html#layanan']] },
            { title: 'Resources', links: [['Blog','M2B Blog.html'],['E-Book ↗','https://ebook.m2b.co.id'],['Toolkit ↗','https://ebook.m2b.co.id/toolkit.html'],['Newsletter','#']] },
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
        <div style={{ borderTop: '1px solid var(--cream-dark)', paddingTop: 20, display: 'flex', justifyContent: 'space-between', flexWrap: 'wrap', gap: 12, fontSize: 12, color: 'var(--text-soft)' }}>
          <span>© 2026 PT. Mora Multi Berkah</span>
          <span>NIB · NPWP · ALFI · KADIN · LNSW</span>
        </div>
      </div>
    </footer>
  );
}

function WhatsAppFloat() {
  return (
    <a href="https://wa.me/6281263027818" target="_blank" rel="noopener noreferrer" style={{
      position: 'fixed', bottom: 24, right: 24, zIndex: 50,
      display: 'flex', alignItems: 'center', gap: 10,
      background: '#25D366', color: '#fff', padding: '14px 18px',
      borderRadius: 999, boxShadow: '0 8px 28px rgba(37,211,102,0.45)',
      textDecoration: 'none', fontWeight: 700, fontSize: 14,
    }}>
      <svg width="22" height="22" viewBox="0 0 24 24" fill="#fff">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
      <span>Chat Tim M2B</span>
    </a>
  );
}

function App() {
  return (
    <>
      <Nav active="Tim" />
      <Hero />
      <Founder />
      <TeamGrid />
      <Culture />
      <JoinCTA />
      <Footer />
      <WhatsAppFloat />
    </>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
