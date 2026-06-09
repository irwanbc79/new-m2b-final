<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inquiry M2B Berhasil Diterima</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f7; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #e8e8e8; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { border-bottom: 3px solid #1e3a5f; padding-bottom: 15px; margin-bottom: 20px; text-align: center; }
        .header img { height: 50px; margin-bottom: 10px; }
        .header h2 { margin: 0; color: #1e3a5f; font-size: 20px; }
        .content { font-size: 14px; color: #444; }
        .payment-box { background-color: #fffbeb; border: 1px solid #fef3c7; padding: 20px; border-radius: 6px; margin: 20px 0; color: #92400e; }
        .payment-box h4 { margin: 0 0 10px 0; color: #78350f; font-size: 15px; }
        .payment-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .payment-table th { text-align: left; padding: 6px 0; font-size: 13px; color: #78350f; border-bottom: 1px dashed #fcd34d; }
        .payment-table td { padding: 6px 0; font-size: 13px; font-weight: bold; color: #111; border-bottom: 1px dashed #fcd34d; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #1e3a5f; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; margin-top: 15px; text-align: center; }
        .footer { margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px; font-size: 11px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo_m2b_final.svg') }}" alt="M2B Logo">
            <h2>PT. Mora Multi Berkah (M2B)</h2>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $inquiry->name }}</strong>,</p>
            <p>Terima kasih telah mengajukan inquiry pabean dan pengiriman melalui portal M2B. Kami telah menerima data dan dokumen Anda.</p>

            @if($inquiry->service_type === 'paid')
                <div class="payment-box">
                    <h4>📋 Tagihan Jasa Konsultasi HS & Lartas Resmi</h4>
                    <p>Mohon selesaikan transfer pembayaran komitmen sebesar <strong>Rp 150.000,-</strong> agar tim ahli Bea Cukai M2B dapat segera memverifikasi lartas dan mengklasifikasikan barang Anda secara resmi:</p>
                    
                    <table class="payment-table">
                        <tr>
                            <th style="width: 40%">Metode Transfer</th>
                            <td>Bank Mandiri</td>
                        </tr>
                        <tr>
                            <th>Nomor Rekening</th>
                            <td style="font-size: 15px; color: #111; font-family: monospace;">1060055988896</td>
                        </tr>
                        <tr>
                            <th>Atas Nama (a.n)</th>
                            <td>PT. Mora Multi Berkah</td>
                        </tr>
                        <tr>
                            <th>Nominal Transfer</th>
                            <td style="color: #b45309; font-size: 15px;">Rp 150.000,-</td>
                        </tr>
                        @if($inquiry->invoice_no)
                        <tr>
                            <th>No. Invoice</th>
                            <td><code>{{ $inquiry->invoice_no }}</code></td>
                        </tr>
                        @endif
                    </table>

                    <p style="margin-top: 15px; font-size: 12px;">
                        *Setelah transfer, mohon konfirmasi dan lampirkan bukti pembayaran melalui link di bawah ini agar tim kami langsung memproses analisis:
                    </p>
                    <div style="text-align: center;">
                        <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20konfirmasi%20bukti%20transfer%20untuk%20Invoice%20{{ $inquiry->invoice_no }}%20barang%20{{ urlencode($inquiry->volume) }}" target="_blank" class="btn" style="background-color: #25D366;">💬 Konfirmasi via WhatsApp</a>
                    </div>
                </div>
            @else
                <p>
                    Tim *Customs Broker* dan *Freight Sales* M2B saat ini sedang memproses spesifikasi barang Anda. Estimasi biaya pengapalan dan analisis lartas akan kami kirimkan dalam waktu **15-30 menit** langsung ke WhatsApp Anda di nomor <strong>{{ $inquiry->phone }}</strong>.
                </p>
                <p>
                    Jika Anda memiliki dokumen tambahan atau ingin berkonsultasi lebih lanjut secara cepat, Anda bisa mengklik tombol di bawah ini:
                </p>
                <div style="text-align: center;">
                    <a href="https://wa.me/6281263027818?text=Halo%20M2B,%20saya%20ingin%20follow%20up%20inquiry%20perusahaan%20{{ urlencode($inquiry->company) }}" target="_blank" class="btn">💬 Hubungi Admin WhatsApp</a>
                </div>
            @endif

            <p style="margin-top: 25px;">
                Hormat kami,<br>
                <strong>Tim B2B Operations</strong><br>
                PT. Mora Multi Berkah (M2B)
            </p>
        </div>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem web M2B. Mohon tidak membalas email ini secara langsung.<br>
            Komplek Graha Metropolitan Blok G No. 24, Jl. Kapten Sumarsono, Medan 20114.
        </div>
    </div>
</body>
</html>
