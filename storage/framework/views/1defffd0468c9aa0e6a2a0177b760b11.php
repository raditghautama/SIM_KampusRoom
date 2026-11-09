<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Rekapitulasi Peminjaman Ruangan - SIM CampusRoom</title>
    <link rel="stylesheet" href="<?php echo e(url('assets/vendors/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background-color: #f1f5f9;
            color: #0f172a;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            font-size: 10pt;
        }

        .sheet {
            background: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin: 20px auto;
            max-width: 1050px;
            padding: 40px 50px;
            border-radius: 8px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-text {
            text-align: center;
        }

        .kop-instansi {
            font-size: 13pt;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            font-weight: 700;
            color: #334155;
        }

        .kop-alamat {
            font-size: 8.5pt;
            color: #64748b;
            margin-top: 4px;
        }

        .kop-divider-thick {
            border-top: 2.5px solid #0f172a;
            margin-top: 8px;
            margin-bottom: 2px;
        }

        .kop-divider-thin {
            border-top: 1px solid #0f172a;
            margin-bottom: 25px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-bottom: 25px;
        }

        .data-table th {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 8px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 8pt;
        }

        .data-table td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            vertical-align: top;
        }

        .data-table tr:nth-child(even) {
            background-color: #fdfdfd;
        }

        .signature-table {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }

        .signature-space {
            height: 75px;
        }

        .signature-name {
            font-weight: 700;
            text-decoration: underline;
        }

        /* PRINT MEDIA QUERIES */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .sheet {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            @page {
                size: a4 landscape;
                margin: 1.2cm 1.5cm;
            }
        }
    </style>
</head>
<body>

    <!-- TOOLBAR AKSI (DISEMBUNYIKAN SAAT DICETAK) -->
    <div class="no-print bg-white border-bottom shadow-sm py-3 px-4 position-sticky top-0 z-3">
        <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="<?php echo e(route('admin.reports.index', request()->query())); ?>" class="btn btn-outline-secondary rounded-pill btn-sm px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Menu Laporan
                </a>
                <span class="text-muted small">| Pratinjau Dokumen Cetak Resmi</span>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.reports.pdf', request()->query())); ?>" class="btn btn-danger btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>Download PDF</span>
                </a>
                <button type="button" onclick="window.print()" class="btn btn-primary btn-sm rounded-pill px-4 d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Sekarang (Print)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- DOKUMEN CETAK A4 LANDSCAPE -->
    <div class="sheet">
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
        <div class="text-center mb-4">
            <h4 class="fw-bold mb-1 text-uppercase">Laporan Rekapitulasi Peminjaman Ruangan & Fasilitas Kampus</h4>
            <div class="text-secondary small">
                Periode: <strong><?php echo e(\Carbon\Carbon::parse($startDate)->translatedFormat('d F Y')); ?></strong> s/d <strong><?php echo e(\Carbon\Carbon::parse($endDate)->translatedFormat('d F Y')); ?></strong>
                <?php if($selectedRoom): ?>
                    &bull; Ruangan: <strong><?php echo e($selectedRoom->name); ?> (<?php echo e($selectedRoom->code); ?>)</strong>
                <?php endif; ?>
                <?php if($status): ?>
                    &bull; Status: <strong><?php echo e(ucfirst($status)); ?></strong>
                <?php endif; ?>
            </div>
        </div>

        <!-- METADATA RINGKASAN -->
        <div class="d-flex justify-content-between small text-secondary mb-3">
            <div>
                Tanggal Cetak: <strong><?php echo e($printDate); ?></strong><br>
                Dicetak Oleh: <strong><?php echo e(auth()->user()->name ?? 'Administrator Sarpras'); ?></strong>
            </div>
            <div class="text-end">
                Total Peminjaman: <strong><?php echo e($reservations->count()); ?> Data</strong><br>
                Disetujui: <strong class="text-success"><?php echo e($reservations->where('status', 'approved')->count()); ?></strong> &bull;
                Menunggu: <strong class="text-warning"><?php echo e($reservations->where('status', 'pending')->count()); ?></strong> &bull;
                Ditolak: <strong class="text-danger"><?php echo e($reservations->where('status', 'rejected')->count()); ?></strong>
            </div>
        </div>

        <!-- TABEL DATA LAPORAN -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 4%;" class="text-center">No</th>
                    <th style="width: 14%;">Tanggal & Waktu</th>
                    <th style="width: 18%;">Ruangan & Gedung</th>
                    <th style="width: 18%;">Peminjam</th>
                    <th style="width: 24%;">Keperluan Kegiatan</th>
                    <th style="width: 10%;" class="text-center">Status</th>
                    <th style="width: 12%;">Disetujui Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center"><?php echo e($index + 1); ?></td>
                        <td>
                            <strong><?php echo e(\Carbon\Carbon::parse($res->reservation_date)->format('d/m/Y')); ?></strong><br>
                            <span class="text-muted"><?php echo e(substr($res->start_time, 0, 5)); ?> - <?php echo e(substr($res->end_time, 0, 5)); ?> WIB</span>
                        </td>
                        <td>
                            <strong><?php echo e($res->room->name); ?></strong><br>
                            <span class="text-muted"><?php echo e($res->room->building); ?></span>
                        </td>
                        <td>
                            <strong><?php echo e($res->user->name); ?></strong><br>
                            <span class="text-muted"><?php echo e($res->user->identity_number); ?> (<?php echo e($res->user->user_type_label); ?>)</span><br>
                            <span class="text-muted small"><?php echo e($res->user->department ?? '-'); ?></span>
                        </td>
                        <td>
                            <?php echo e($res->purpose); ?>

                            <?php if($res->admin_notes): ?>
                                <div class="small text-muted fst-italic mt-1">Catatan: <?php echo e($res->admin_notes); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($res->status === 'approved'): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Disetujui</span>
                            <?php elseif($res->status === 'pending'): ?>
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Menunggu</span>
                            <?php elseif($res->status === 'rejected'): ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Ditolak</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary"><?php echo e(ucfirst($res->status)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="small text-muted"><?php echo e($res->approver ? $res->approver->name : '-'); ?></span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Tidak ada data peminjaman yang tercatat pada rentang periode ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- TANDA TANGAN (SIGNATURE BLOCK) -->
        <table class="signature-table">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <div class="small text-muted">
                        * Dokumen rekapitulasi ini dicetak dari SIM CampusRoom.<br>
                        * Segala perubahan status peminjaman tercatat secara elektronik.
                    </div>
                </td>
                <td style="width: 40%; text-align: center; vertical-align: top;">
                    Probolinggo, <?php echo e($printDate); ?><br>
                    <strong>Kepala Biro Sarana & Prasarana Kampus,</strong>
                    <div class="signature-space"></div>
                    <div class="signature-name">Dr. H. Ahmad Fawaid, M.Pd.I.</div>
                    <div class="small text-muted">NIP. 19780815 200501 1 004</div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
<?php /**PATH D:\laragon\www\campusroom\resources\views/admin/reports/print.blade.php ENDPATH**/ ?>