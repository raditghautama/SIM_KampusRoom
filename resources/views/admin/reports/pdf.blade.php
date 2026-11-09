<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Peminjaman Ruangan</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm 2cm 1.5cm;
            size: a4 landscape;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            color: #1e293b;
            line-height: 1.4;
        }

        /* KOP SURAT RESMI KAMPUS */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 80px;
            text-align: center;
        }

        .kop-text {
            text-align: center;
            padding: 0 10px;
        }

        .kop-instansi {
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .kop-kampus {
            font-size: 16pt;
            font-weight: 800;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 2px 0;
        }

        .kop-biro {
            font-size: 11pt;
            font-weight: bold;
            color: #334155;
            margin: 0;
        }

        .kop-alamat {
            font-size: 8.5pt;
            color: #64748b;
            margin-top: 4px;
        }

        /* GARIS PEMBATAS KOP GANDA (RESMI) */
        .kop-divider-thick {
            border-top: 2.5px solid #0f172a;
            margin-top: 6px;
            margin-bottom: 1.5px;
        }

        .kop-divider-thin {
            border-top: 1px solid #0f172a;
            margin-bottom: 20px;
        }

        /* JUDUL DOKUMEN */
        .doc-title {
            text-align: center;
            margin-bottom: 15px;
        }

        .doc-title h2 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 4px 0;
            color: #0f172a;
        }

        .doc-title p {
            font-size: 9pt;
            color: #475569;
            margin: 0;
        }

        /* METADATA */
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 9pt;
        }

        .meta-table td {
            padding: 2px 0;
        }

        /* TABEL DATA UTAMA */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 8.5pt;
        }

        .data-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8pt;
            border: 1px solid #cbd5e1;
            padding: 8px 6px;
            text-align: left;
        }

        .data-table td {
            border: 1px solid #cbd5e1;
            padding: 6px;
            vertical-align: top;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-approved {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-pending {
            background-color: #fef9c3;
            color: #a16207;
            border: 1px solid #fef08a;
        }

        .badge-rejected {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* TANDA TANGAN (SIGNATURE BLOCK) */
        .signature-table {
            width: 100%;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .signature-table td {
            vertical-align: top;
            font-size: 9.5pt;
        }

        .signature-space {
            height: 70px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            color: #0f172a;
        }

        .signature-nip {
            font-size: 8.5pt;
            color: #475569;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <table class="kop-table">
        <tr>
            <td class="kop-text">
                <div class="kop-kampus">UNIVERSITAS NURUL JADID</div>
                <div class="kop-biro">BIRO SARANA DAN PRASARANA KAMPUS (SARPRAS)</div>
                <div class="kop-alamat">
                    Jl. KH. Zaini Mun'im, Karanganyar, Paiton, Probolinggo, Jawa Timur 67291<br>
                    Website: www.unuja.ac.id | Email: sarpras@unuja.ac.id | Telepon: (0335) 771000
                </div>
            </td>
        </tr>
    </table>

    <div class="kop-divider-thick"></div>
    <div class="kop-divider-thin"></div>

    <!-- JUDUL LAPORAN -->
    <div class="doc-title">
        <h2>Laporan Rekapitulasi Peminjaman Ruangan & Fasilitas Kampus</h2>
        <p>
            Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</strong>
            @if($selectedRoom)
                &bull; Ruangan: <strong>{{ $selectedRoom->name }} ({{ $selectedRoom->code }})</strong>
            @endif
            @if($status)
                &bull; Status: <strong>{{ ucfirst($status) }}</strong>
            @endif
        </p>
    </div>

    <!-- METADATA RINGKASAN -->
    <table class="meta-table">
        <tr>
            <td width="50%">
                Tanggal Cetak: <strong>{{ $printDate }}</strong><br>
                Dicetak Oleh: <strong>{{ auth()->user()->name ?? 'Administrator Sarpras' }}</strong>
            </td>
            <td width="50%" class="text-right">
                Total Data: <strong>{{ $reservations->count() }} Peminjaman</strong> | 
                Disetujui: <strong style="color: #15803d;">{{ $reservations->where('status', 'approved')->count() }}</strong> | 
                Menunggu: <strong style="color: #a16207;">{{ $reservations->where('status', 'pending')->count() }}</strong> | 
                Ditolak: <strong style="color: #b91c1c;">{{ $reservations->where('status', 'rejected')->count() }}</strong>
            </td>
        </tr>
    </table>

    <!-- TABEL DATA LAPORAN -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="12%">Tanggal & Waktu</th>
                <th width="18%">Ruangan & Lokasi</th>
                <th width="18%">Peminjam (NIM / NIDN)</th>
                <th width="24%">Keperluan / Agenda Kegiatan</th>
                <th width="11%" class="text-center">Status</th>
                <th width="13%">Disetujui Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $index => $res)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ \Carbon\Carbon::parse($res->reservation_date)->format('d/m/Y') }}</strong><br>
                        <span style="color: #475569;">{{ substr($res->start_time, 0, 5) }} - {{ substr($res->end_time, 0, 5) }} WIB</span>
                    </td>
                    <td>
                        <strong>{{ $res->room->name }}</strong><br>
                        <span style="color: #64748b;">{{ $res->room->building }}</span>
                    </td>
                    <td>
                        <strong>{{ $res->user->name }}</strong><br>
                        <span style="color: #475569;">{{ $res->user->identity_number }} ({{ $res->user->user_type_label }})</span><br>
                        <span style="color: #64748b;">{{ $res->user->department ?? '-' }}</span>
                    </td>
                    <td>
                        {{ $res->purpose }}
                        @if($res->admin_notes)
                            <div style="font-size: 7.5pt; color: #475569; margin-top: 3px; font-style: italic;">
                                Catatan: {{ $res->admin_notes }}
                            </div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($res->status === 'approved')
                            <span class="badge-status badge-approved">Disetujui</span>
                        @elseif($res->status === 'pending')
                            <span class="badge-status badge-pending">Menunggu</span>
                        @elseif($res->status === 'rejected')
                            <span class="badge-status badge-rejected">Ditolak</span>
                        @else
                            <span class="badge-status">{{ ucfirst($res->status) }}</span>
                        @endif
                    </td>
                    <td>
                        {{ $res->approver ? $res->approver->name : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">
                        Tidak ada data peminjaman yang tercatat pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- AREA TANDA TANGAN (OFFICIAL SIGN-OFF) -->
    <table class="signature-table">
        <tr>
            <td width="60%">
                <div style="font-size: 8pt; color: #64748b; line-height: 1.5;">
                    * Dokumen rekapitulasi ini diterbitkan secara resmi melalui Sistem Informasi SIM CampusRoom.<br>
                    * Arsip digital tersimpan di Pusat Data Sarpras Universitas.
                </div>
            </td>
            <td width="40%" class="text-center">
                Probolinggo, {{ $printDate }}<br>
                <strong>Kepala Biro Sarana & Prasarana Kampus,</strong>
                <div class="signature-space"></div>
                <div class="signature-name">Dr. H. Ahmad Fawaid, M.Pd.I.</div>
                <div class="signature-nip">NIP. 19780815 200501 1 004</div>
            </td>
        </tr>
    </table>

</body>
</html>
