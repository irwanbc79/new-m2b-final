<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inquiry B2B Baru</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f7; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #e8e8e8; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { border-bottom: 3px solid #1e3a5f; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #1e3a5f; font-size: 22px; }
        .header span { font-size: 12px; color: #777; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th { text-align: left; padding: 10px; border-bottom: 1px solid #eee; width: 35%; color: #666; font-size: 14px; }
        table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: bold; color: #111; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .status-paid { background-color: #d1fae5; color: #065f46; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .footer { margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px; font-size: 11px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>💼 Inquiry B2B & Customs Baru</h2>
            <span>Diterima pada: {{ now()->format('d M Y H:i') }} WIB</span>
        </div>

        <table>
            <tr>
                <th>Nama Perusahaan</th>
                <td>{{ $inquiry->company }}</td>
            </tr>
            <tr>
                <th>NPWP Perusahaan</th>
                <td>{{ $inquiry->npwp }}</td>
            </tr>
            <tr>
                <th>Nama Kontak</th>
                <td>{{ $inquiry->name }}</td>
            </tr>
            <tr>
                <th>Email Bisnis</th>
                <td><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></td>
            </tr>
            <tr>
                <th>No. HP / WhatsApp</th>
                <td><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></td>
            </tr>
            <tr>
                <th>Tipe Layanan</th>
                <td>
                    @if($inquiry->service_type === 'paid')
                        <span class="status-badge status-pending">Opsi A — Jasa Konsultasi Berbayar (Rp 150.000)</span>
                    @else
                        <span class="status-badge status-paid">Opsi B — Bundling Pengiriman M2B (GRATIS)</span>
                    @endif
                </td>
            </tr>
            @if($inquiry->invoice_no)
            <tr>
                <th>No. Invoice</th>
                <td><code>{{ $inquiry->invoice_no }}</code></td>
            </tr>
            @endif
            <tr>
                <th>Status Pembayaran</th>
                <td>
                    @if($inquiry->status === 'paid')
                        <span style="color: #059669;">LUNAS (Verifikasi Bukti Transfer)</span>
                    @elseif($inquiry->service_type === 'paid')
                        <span style="color: #dc2626;">PENDING PAYMENT (Menunggu Bukti Transfer Mandiri)</span>
                    @else
                        <span style="color: #2563eb;">KLIEN LOGISTIK (GRATIS)</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Jenis Pengiriman</th>
                <td>{{ $inquiry->shipment_type }}</td>
            </tr>
            <tr>
                <th>Estimasi Volume</th>
                <td>{{ $inquiry->volume }}</td>
            </tr>
            <tr>
                <th>Rute Pengiriman</th>
                <td>{{ $inquiry->route_origin ?? '-' }} &rarr; {{ $inquiry->route_destination ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Pengapalan</th>
                <td>{{ $inquiry->est_shipment_date ?? '-' }}</td>
            </tr>
        </table>

        <p style="font-size: 13px; color: #555;">
            *Dokumen <strong>Invoice, Packing List, atau brosur spesifikasi teknis</strong> yang diunggah oleh klien telah dilampirkan langsung pada email ini.
        </p>

        <div class="footer">
            Sistem Otomatis Leads M2B — PT. Mora Multi Berkah
        </div>
    </div>
</body>
</html>
