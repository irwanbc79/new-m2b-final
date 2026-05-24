const { useState, useEffect } = React;

function Nav({ active = 'Karir' }) {
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
            { l: 'Beranda', h: 'M2B Landing Page.html' },
            { l: 'Layanan', h: 'M2B Landing Page.html#layanan' },
            { l: 'Blog', h: 'M2B Blog.html' },
            { l: 'Tentang', h: 'M2B About.html' },
            { l: 'Tim', h: 'M2B Tim.html' },
            { l: 'Karir', h: '#', active: active === 'Karir' },
          ].map(item => (
            <a key={item.l} href={item.h} style={{
              padding: '6px 14px', borderRadius: 20, fontSize: 13, fontWeight: 600, textDecoration: 'none',
              color: item.active ? 'var(--cream)' : 'var(--text-mid)',
              background: item.active ? 'var(--navy)' : 'transparent',
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

function Hero() {
  return (
    <section style={{
      background: 'linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%)',
      padding: '88px 32px 96px', position: 'relative', overflow: 'hidden',
    }}>
      <div style={{
        position: 'absolute', top: -150, right: -100, width: 500, height: 500,
        background: `radial-gradient(circle, var(--gold) 0%, transparent 65%)`,
        opacity: 0.12, pointerEvents: 'none',
      }} />
      <div style={{ maxWidth: 980, margin: '0 auto', position: 'relative', textAlign: 'center' }}>
        <div style={{ fontSize: 12, color: 'rgba(248,245,238,0.5)', marginBottom: 24 }}>
          <a href="M2B Landing Page.html" style={{ color: 'rgba(248,245,238,0.5)', textDecoration: 'none' }}>Home</a>
          <span style={{ margin: '0 8px' }}>/</span>
          <span style={{ color: 'var(--gold)', fontWeight: 600 }}>Karir</span>
        </div>
        <span style={{
          display: 'inline-block', padding: '5px 14px', borderRadius: 20,
          background: 'rgba(245,185,28,0.18)', color: 'var(--gold)',
          fontSize: 11, fontWeight: 800, letterSpacing: 1.4, textTransform: 'uppercase', marginBottom: 24,
        }}>💼 Karir di M2B</span>
        <h1 style={{
          fontFamily: 'Syne', fontWeight: 800, fontSize: 56, lineHeight: 1.05,
          color: 'var(--cream)', letterSpacing: -1.8, marginBottom: 22,
        }}>
          Tumbuh bareng kami,<br/>
          <span style={{ color: 'var(--gold)' }}>satu shipment dalam satu waktu.</span>
        </h1>
        <p style={{
          fontFamily: 'Lora', fontSize: 18, color: 'rgba(248,245,238,0.78)',
          lineHeight: 1.7, maxWidth: 620, margin: '0 auto', fontStyle: 'italic',
        }}>
          Kami bukan startup yang berjanji bean bag dan ping-pong. Tapi kami menawarkan sesuatu yang lebih langka: pekerjaan yang berarti, tim yang saling jaga, dan kepercayaan untuk tumbuh.
        </p>
      </div>
    </section>
  );
}

function HonestNote() {
  return (
    <section style={{ background: 'var(--cream)', padding: '64px 32px', borderTop: '1px solid var(--cream-dark)' }}>
      <div style={{ maxWidth: 800, margin: '0 auto' }}>
        <div style={{
          background: 'var(--warm-white)', borderRadius: 20,
          padding: '36px 40px', border: '1px solid var(--cream-dark)',
          borderLeft: `5px solid var(--crimson)`,
          boxShadow: '0 12px 32px rgba(11,17,32,0.06)',
        }}>
          <div style={{ fontSize: 32, marginBottom: 14 }}>📌</div>
          <div style={{ fontSize: 11, color: 'var(--crimson)', fontWeight: 800, letterSpacing: 1.4, textTransform: 'uppercase', marginBottom: 10 }}>Catatan Jujur</div>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 26, color: 'var(--navy)',
            letterSpacing: -0.5, lineHeight: 1.25, marginBottom: 14,
          }}>Kami merekrut sesuai kebutuhan, bukan setiap saat.</h2>
          <p style={{ fontFamily: 'Lora', fontSize: 16, color: 'var(--text-main)', lineHeight: 1.85, marginBottom: 16 }}>
            Saat ini kami <strong>tidak selalu memiliki lowongan terbuka</strong>. Setiap penambahan tim adalah keputusan yang kami pertimbangkan matang — disesuaikan dengan beban kerja, pertumbuhan klien, dan kebutuhan operasional perusahaan.
          </p>
          <p style={{ fontFamily: 'Lora', fontSize: 16, color: 'var(--text-main)', lineHeight: 1.85, marginBottom: 0 }}>
            Tapi pintu kami <strong>tidak pernah tertutup untuk talenta yang tepat.</strong> Kirimkan lamaran spontanmu, dan kami akan menyimpannya. Saat posisi yang cocok terbuka — entah 2 minggu lagi atau 6 bulan lagi — kamu akan jadi orang pertama yang kami hubungi.
          </p>
        </div>
      </div>
    </section>
  );
}

function WhyJoin() {
  const reasons = [
    { icon: '🎯', t: 'Pekerjaan yang Berarti', d: 'Setiap shipment yang kamu kawal adalah bisnis seseorang. Pekerjaan kami punya dampak nyata — tidak ada hari yang sia-sia.' },
    { icon: '📚', t: 'Belajar Setiap Hari', d: 'Industri logistik berubah cepat. Regulasi baru, teknologi baru, rute baru — kamu akan terus berkembang.' },
    { icon: '🤝', t: 'Tim yang Saling Jaga', d: 'Tidak ada budaya "itu bukan tugas saya". Kami saling backup, terutama saat shipment kritis butuh banyak tangan.' },
    { icon: '⚡', t: 'Diberi Kepercayaan', d: 'Kami tidak micromanage. Kamu diberi ruang untuk membuat keputusan dan belajar dari hasilnya.' },
    { icon: '🌱', t: 'Karir yang Tumbuh', d: '60% supervisor kami mulai dari posisi entry. Kami percaya membangun talent dari dalam.' },
    { icon: '💚', t: 'Work-Life Yang Sehat', d: 'Kantor tutup jam 17.00. Tidak ada Slack di luar jam kerja. Period.' },
  ];
  return (
    <section style={{ background: 'var(--warm-white)', padding: '80px 32px', borderTop: '1px solid var(--cream-dark)' }}>
      <div style={{ maxWidth: 1100, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 48 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(245,185,28,0.18)', color: 'var(--gold-dim)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase', marginBottom: 14,
          }}>Kenapa M2B?</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 36, color: 'var(--navy)',
            letterSpacing: -1, lineHeight: 1.1, marginBottom: 12,
          }}>Yang kami tawarkan, secara jujur.</h2>
          <p style={{ fontSize: 15, color: 'var(--text-mid)', maxWidth: 540, margin: '0 auto' }}>
            Bukan janji muluk, tapi nilai-nilai yang kami pegang setiap hari.
          </p>
        </div>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 18 }}>
          {reasons.map((r, i) => (
            <div key={i} style={{
              padding: '26px 24px', background: 'var(--cream)',
              borderRadius: 14, border: '1px solid var(--cream-dark)',
            }}>
              <div style={{ fontSize: 30, marginBottom: 14 }}>{r.icon}</div>
              <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 17, color: 'var(--navy)', marginBottom: 8 }}>{r.t}</div>
              <p style={{ fontSize: 13.5, color: 'var(--text-mid)', lineHeight: 1.7 }}>{r.d}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

function PotentialRoles() {
  const roles = [
    { dept: 'Operations', color: '#0ea5e9', roles: ['Operations Supervisor','Fleet Coordinator','Warehouse Associate'] },
    { dept: 'Customs & Docs', color: '#7c3aed', roles: ['Customs Officer (PPJK)','Documentation Specialist','Trade Compliance Analyst'] },
    { dept: 'Sales & CS', color: '#16a34a', roles: ['Sales Consultant','Account Manager','Customer Care Officer'] },
    { dept: 'Support', color: '#ea580c', roles: ['Finance & Billing','HR Generalist','Marketing Communication'] },
  ];
  return (
    <section style={{ background: 'var(--cream)', padding: '80px 32px' }}>
      <div style={{ maxWidth: 1100, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 40 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(11,17,32,0.06)', color: 'var(--navy)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase', marginBottom: 14,
          }}>🗂 Posisi yang Mungkin Kami Cari</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 30, color: 'var(--navy)',
            letterSpacing: -0.8, lineHeight: 1.15, marginBottom: 10,
          }}>Departemen di M2B.</h2>
          <p style={{ fontSize: 14, color: 'var(--text-mid)', maxWidth: 560, margin: '0 auto' }}>
            Daftar di bawah ini bukan lowongan terbuka, melainkan posisi yang secara berkala kami butuhkan. Kirim lamaranmu di departemen yang paling sesuai dengan latar belakangmu.
          </p>
        </div>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(2, 1fr)', gap: 18 }}>
          {roles.map((r, i) => (
            <div key={i} style={{
              padding: '28px 28px', background: 'var(--warm-white)',
              borderRadius: 16, border: '1px solid var(--cream-dark)',
              borderTop: `4px solid ${r.color}`,
            }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: 10, marginBottom: 16 }}>
                <div style={{ width: 8, height: 8, borderRadius: '50%', background: r.color }} />
                <div style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 18, color: 'var(--navy)' }}>{r.dept}</div>
              </div>
              <ul style={{ listStyle: 'none', padding: 0 }}>
                {r.roles.map(role => (
                  <li key={role} style={{
                    padding: '10px 0', borderBottom: '1px solid var(--cream-dark)',
                    fontSize: 14, color: 'var(--text-main)', fontWeight: 500,
                    display: 'flex', justifyContent: 'space-between', alignItems: 'center',
                  }}>
                    <span>{role}</span>
                    <span style={{ fontSize: 10, color: 'var(--text-soft)', fontWeight: 600, letterSpacing: 0.5 }}>Sesuai Kebutuhan</span>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

function HiringProcess() {
  const steps = [
    { n: '01', t: 'Kirim Lamaran', d: 'Email CV + cover letter ke karir@m2b.co.id, atau WhatsApp dengan portofolio singkat.' },
    { n: '02', t: 'Kami Simpan & Pelajari', d: 'Setiap lamaran kami baca dan simpan di database talent kami.' },
    { n: '03', t: 'Saat Posisi Terbuka', d: 'Kami hubungi kandidat yang paling cocok. Bisa 2 minggu, bisa 6 bulan.' },
    { n: '04', t: 'Wawancara + Trial', d: 'Wawancara 1×, trial 1–2 minggu untuk lihat kecocokan tim.' },
    { n: '05', t: 'Welcome to M2B', d: 'Onboarding 1 bulan, mentoring 3 bulan. Tumbuh bersama tim.' },
  ];
  return (
    <section style={{ background: 'var(--warm-white)', padding: '80px 32px', borderTop: '1px solid var(--cream-dark)' }}>
      <div style={{ maxWidth: 1000, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 48 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(245,185,28,0.18)', color: 'var(--gold-dim)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase', marginBottom: 14,
          }}>Proses Rekrutmen</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 30, color: 'var(--navy)',
            letterSpacing: -0.8,
          }}>5 langkah dari lamaran hingga bergabung.</h2>
        </div>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(5, 1fr)', gap: 12, position: 'relative' }}>
          <div style={{ position: 'absolute', top: 32, left: '10%', right: '10%', height: 2, background: 'var(--cream-dark)' }} />
          {steps.map((s, i) => (
            <div key={i} style={{ textAlign: 'center', position: 'relative', zIndex: 1 }}>
              <div style={{
                width: 64, height: 64, borderRadius: '50%',
                background: 'var(--warm-white)', border: '3px solid var(--gold)',
                display: 'flex', alignItems: 'center', justifyContent: 'center',
                margin: '0 auto 14px', fontFamily: 'Syne', fontWeight: 800, fontSize: 16, color: 'var(--navy)',
                boxShadow: '0 0 0 6px var(--warm-white)',
              }}>{s.n}</div>
              <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 14, color: 'var(--navy)', marginBottom: 6 }}>{s.t}</div>
              <p style={{ fontSize: 12, color: 'var(--text-mid)', lineHeight: 1.6 }}>{s.d}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

function ApplyForm() {
  const [submitted, setSubmitted] = useState(false);
  return (
    <section style={{ background: 'var(--cream)', padding: '80px 32px' }}>
      <div style={{ maxWidth: 720, margin: '0 auto' }}>
        <div style={{ textAlign: 'center', marginBottom: 36 }}>
          <span style={{
            display: 'inline-block', padding: '4px 12px', borderRadius: 20,
            background: 'rgba(11,17,32,0.06)', color: 'var(--navy)',
            fontSize: 11, fontWeight: 800, letterSpacing: 1.2, textTransform: 'uppercase', marginBottom: 14,
          }}>📨 Kirim Lamaran Spontan</span>
          <h2 style={{
            fontFamily: 'Syne', fontWeight: 800, fontSize: 32, color: 'var(--navy)',
            letterSpacing: -0.8, lineHeight: 1.15, marginBottom: 10,
          }}>Tertarik bergabung? Mulai dari sini.</h2>
          <p style={{ fontSize: 14, color: 'var(--text-mid)', maxWidth: 480, margin: '0 auto' }}>
            Form di bawah akan langsung sampai ke tim HRD kami. Kami baca semua, dan kami akan hubungi saat ada kecocokan.
          </p>
        </div>

        {submitted ? (
          <div style={{
            background: 'var(--warm-white)', borderRadius: 20, padding: '40px 32px',
            border: '1px solid var(--cream-dark)', textAlign: 'center',
          }}>
            <div style={{ fontSize: 56, marginBottom: 14 }}>✅</div>
            <h3 style={{ fontFamily: 'Syne', fontWeight: 800, fontSize: 22, color: 'var(--navy)', marginBottom: 10 }}>Lamaranmu sudah kami terima.</h3>
            <p style={{ fontSize: 14, color: 'var(--text-mid)', lineHeight: 1.7 }}>
              Tim HRD M2B akan membaca dan menyimpannya. Saat posisi cocok terbuka, kami akan menghubungi via email atau WhatsApp.
            </p>
          </div>
        ) : (
          <form onSubmit={e => { e.preventDefault(); setSubmitted(true); }} style={{
            background: 'var(--warm-white)', borderRadius: 20, padding: 36,
            border: '1px solid var(--cream-dark)',
            boxShadow: '0 12px 32px rgba(11,17,32,0.06)',
          }}>
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16, marginBottom: 16 }}>
              <Field label="Nama Lengkap" placeholder="Misal: Sari Wulandari" required />
              <Field label="Email" type="email" placeholder="email@kamu.com" required />
            </div>
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16, marginBottom: 16 }}>
              <Field label="No. WhatsApp" placeholder="+62 812-xxxx-xxxx" required />
              <Field label="Departemen Diminati" select options={['Operations','Customs & Docs','Sales & CS','Support','Tidak yakin — pilih saja']} required />
            </div>
            <Field label="Pengalaman Singkat" textarea placeholder="Ceritakan dalam 2-3 kalimat — apa pengalamanmu di industri logistik atau bidang lain yang relevan?" required />
            <Field label="Link CV / Portofolio" placeholder="Google Drive, Dropbox, atau LinkedIn URL" />
            <div style={{
              padding: '14px 18px', background: 'var(--cream)', borderRadius: 10,
              fontSize: 12, color: 'var(--text-mid)', lineHeight: 1.7, marginBottom: 20,
              border: '1px solid var(--cream-dark)',
            }}>
              <strong style={{ color: 'var(--navy)' }}>💡 Tips:</strong> Jangan kirim CV template generik. Cerita singkat tentang kenapa M2B menarik untukmu akan sangat membantu. Kami menghargai kejujuran lebih dari sertifikat panjang.
            </div>
            <button type="submit" style={{
              width: '100%', padding: 14, border: 'none', borderRadius: 10,
              background: 'var(--gold)', color: 'var(--navy)',
              fontFamily: 'Plus Jakarta Sans', fontWeight: 800, fontSize: 15,
              cursor: 'pointer', boxShadow: '0 6px 18px rgba(245,185,28,0.35)',
            }}>📨 Kirim Lamaran</button>
            <div style={{ fontSize: 11, color: 'var(--text-soft)', textAlign: 'center', marginTop: 12 }}>
              Atau email langsung ke <a href="mailto:karir@m2b.co.id" style={{ color: 'var(--navy)', fontWeight: 700 }}>karir@m2b.co.id</a>
            </div>
          </form>
        )}
      </div>
    </section>
  );
}

function Field({ label, type = 'text', placeholder, textarea, select, options, required }) {
  const baseStyle = {
    width: '100%', padding: '11px 14px', borderRadius: 8,
    border: '1px solid var(--cream-dark)', outline: 'none',
    fontSize: 14, fontFamily: 'inherit', background: 'var(--cream)',
    color: 'var(--text-main)', resize: 'vertical', marginBottom: 16,
  };
  return (
    <label style={{ display: 'block' }}>
      <div style={{ fontSize: 12, color: 'var(--text-mid)', fontWeight: 600, marginBottom: 6 }}>
        {label} {required && <span style={{ color: 'var(--crimson)' }}>*</span>}
      </div>
      {textarea ? (
        <textarea placeholder={placeholder} required={required} rows={4} style={baseStyle} />
      ) : select ? (
        <select required={required} style={baseStyle}>
          <option value="">Pilih departemen...</option>
          {options.map(o => <option key={o} value={o}>{o}</option>)}
        </select>
      ) : (
        <input type={type} placeholder={placeholder} required={required} style={baseStyle} />
      )}
    </label>
  );
}

function Footer() {
  return (
    <footer style={{ background: '#ffffff', borderTop: '4px solid var(--navy)', padding: '48px 32px 24px' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto', textAlign: 'center' }}>
        <img src="assets/logo-m2b-clean.png" alt="M2B" style={{ height: 56, margin: '0 auto 16px', filter: 'drop-shadow(0 4px 12px rgba(11,17,32,0.12))' }} />
        <div style={{ fontFamily: 'Syne', fontWeight: 700, fontSize: 14, color: 'var(--navy)', marginBottom: 4 }}>PT. Mora Multi Berkah</div>
        <div style={{ fontSize: 10, color: 'var(--crimson)', fontWeight: 700, letterSpacing: 1.4, marginBottom: 18 }}>LOGISTIC · SOLUTION · PARTNER</div>
        <div style={{ display: 'flex', gap: 16, justifyContent: 'center', flexWrap: 'wrap', marginBottom: 20, fontSize: 13 }}>
          {[['Beranda','M2B Landing Page.html'],['Blog','M2B Blog.html'],['Tentang','M2B About.html'],['Tim','M2B Tim.html'],['Kontak','mailto:karir@m2b.co.id']].map(([l, h]) => (
            <a key={l} href={h} style={{ color: 'var(--text-mid)', textDecoration: 'none' }}>{l}</a>
          ))}
        </div>
        <div style={{ borderTop: '1px solid var(--cream-dark)', paddingTop: 16, fontSize: 12, color: 'var(--text-soft)' }}>
          © 2026 PT. Mora Multi Berkah. All rights reserved.
        </div>
      </div>
    </footer>
  );
}

function App() {
  return (
    <>
      <Nav active="Karir" />
      <Hero />
      <HonestNote />
      <WhyJoin />
      <PotentialRoles />
      <HiringProcess />
      <ApplyForm />
      <Footer />
    </>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App />);
