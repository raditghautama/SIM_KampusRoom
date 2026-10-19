<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Peminjaman Ruangan - CampusRoom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            padding: 20px;
        }
        .header-kop {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }
        .header-kop h4 {
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-kop p {
            margin: 2px 0;
            font-size: 13px;
        }
        table {
            font-size: 12px;
        }
        .ttd-box {
            float: right;
            text-align: center;
            width: 250px;
            margin-top: 40px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <div class="no-print mb-4 d-flex justify-content-between align-items-center bg-light p-3 rounded border">
        <div>
            <strong>Mode Cetak Laporan Peminjaman</strong>
            <div class="small text-muted">Gunakan tombol di samping untuk mencetak atau menyimpan sebagai PDF.</div>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary btn-sm px-3">
                Cetak Sekarang (Print)
            </button>
            <button onclick="window.close()" class="btn btn-secondary btn-sm px-3">
                Tutup
            </button>
        </div>
    </div>

    <!-- KOP SURAT RESMI -->
    <div class="header-kop">
        <h4>YAYASAN NURUL JADID PAITON</h4>
        <h4>UNIVERSITAS NURUL JADID</h4>
        <h4>BIRO SARANA DAN PRASARANA (SARPRAS)</h4>
        <p>PP. Nurul Jadid Karanganyar Paiton &bull; Telepon: (0888) 30 77077 &bull; Email: sarpras@campusroom.ac.id</p>
    </div>

    <div class="text-center mb-4">
        <h5 class="fw-bold text-decoration-underline mb-1">REKAPITULASI PEMINJAMAN RUANGAN KAMPUS</h5>
        <div class="small">
            Periode: <strong><?php echo e(\Carbon\Carbon::parse($startDate)->translatedFormat('d F Y')); ?></strong> s/d <strong><?php echo e(\Carbon\Carbon::parse($endDate)->translatedFormat('d F Y')); ?></strong>
            <?php if($selectedRoom): ?>
                | Ruangan: <strong><?php echo e($selectedRoom->name); ?></strong>
            <?php endif; ?>
        </div>
    </div>

    <table class="table table-bordered table-sm align-middle">
        <thead class="table-light text-center">
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal & Jam</th>
                <th style="width: 20%;">Ruangan</th>
                <th style="width: 25%;">Peminjam / Instansi</th>
                <th style="width: 25%;">Keperluan Agenda</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td>
                        <?php echo e($res->formatted_date); ?><br>
                        <small class="text-muted"><?php echo e($res->formatted_time); ?></small>
                    </td>
                    <td>
                        <strong><?php echo e($res->room->name); ?></strong><br>
                        <small><?php echo e($res->room->code); ?> - <?php echo e($res->room->building); ?></small>
                    </td>
                    <td>
                        <strong><?php echo e($res->user->name); ?></strong><br>
                        <small><?php echo e($res->user->identifier); ?> (<?php echo e($res->user->department); ?>)</small>
                    </td>
                    <td><?php echo e($res->purpose); ?></td>
                    <td class="text-center">
                        <span class="fw-bold"><?php echo e(strtoupper($res->status)); ?></span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-3">Tidak ada data peminjaman untuk periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="ttd-box">
        <div>Paiton, <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></div>
        <div>Kepala Biro Sarana dan Prasarana,</div>
        <div style="height: 70px;"></div>
        <div class="fw-bold text-decoration-underline">Ir. Hendra Gunawan, M.T.</div>
        <div>NIP. 197805122003121002</div>
    </div>

    <script>
        // Auto trigger print dialog on preview open if desired
        window.onload = function() {
            // window.print();
        }
    </script>
</body>
</html>
<?php /**PATH D:\laragon\www\campusroom\resources\views/admin/reports/print.blade.php ENDPATH**/ ?>