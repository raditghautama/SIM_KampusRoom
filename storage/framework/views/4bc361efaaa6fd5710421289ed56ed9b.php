<?php $__env->startSection('title', 'Laporan Peminjaman Ruangan'); ?>
<?php $__env->startSection('page_heading', 'Laporan Rekapitulasi Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<!-- FILTER CARD -->
<div class="card card-custom border-0 p-4 shadow-sm mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3 pb-3 border-bottom">
        <div>
            <h5 class="fw-bold mb-1"><i class="fa-solid fa-filter me-2 text-primary"></i>Filter Laporan Peminjaman</h5>
            <small class="text-muted">Pilih rentang tanggal, ruangan, dan status peminjaman untuk merekap data</small>
        </div>
        <div class="d-flex gap-2">
            <!-- Tombol Export PDF -->
            <a href="<?php echo e(route('admin.reports.pdf', request()->query())); ?>" class="btn btn-danger rounded-pill px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Export PDF</span>
            </a>
            <!-- Tombol Cetak / Print -->
            <a href="<?php echo e(route('admin.reports.print', request()->query())); ?>" target="_blank" class="btn btn-secondary rounded-pill px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Laporan</span>
            </a>
        </div>
    </div>

    <form action="<?php echo e(route('admin.reports.index')); ?>" method="GET" class="row g-3">
        <div class="col-12 col-md-3">
            <label class="form-label small fw-bold text-secondary">Dari Tanggal</label>
            <input type="date" name="start_date" class="form-control" value="<?php echo e($startDate); ?>">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label small fw-bold text-secondary">Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control" value="<?php echo e($endDate); ?>">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label small fw-bold text-secondary">Filter Ruangan</label>
            <select name="room_id" class="form-select">
                <option value="">Semua Ruangan</option>
                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($r->id); ?>" <?php echo e($roomId == $r->id ? 'selected' : ''); ?>><?php echo e($r->name); ?> (<?php echo e($r->code); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label small fw-bold text-secondary">Filter Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="approved" <?php echo e($status === 'approved' ? 'selected' : ''); ?>>Disetujui (Approved)</option>
                <option value="pending" <?php echo e($status === 'pending' ? 'selected' : ''); ?>>Menunggu (Pending)</option>
                <option value="rejected" <?php echo e($status === 'rejected' ? 'selected' : ''); ?>>Ditolak (Rejected)</option>
            </select>
        </div>

        <div class="col-12 text-end pt-2">
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-light rounded-pill px-3 me-2">Reset</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Terapkan Filter
            </button>
        </div>
    </form>
</div>

<!-- RINGKASAN REKAP -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm text-center">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem;">Total Rekap</small>
            <h3 class="fw-bold text-dark my-1"><?php echo e($summary['total']); ?></h3>
            <span class="text-secondary small">Data Terfilter</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm text-center border-start border-success border-4">
            <small class="text-success fw-bold text-uppercase" style="font-size: 0.72rem;">Disetujui</small>
            <h3 class="fw-bold text-success my-1"><?php echo e($summary['approved']); ?></h3>
            <span class="text-secondary small">Peminjaman Selesai/Aktif</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm text-center border-start border-warning border-4">
            <small class="text-warning-emphasis fw-bold text-uppercase" style="font-size: 0.72rem;">Menunggu (Pending)</small>
            <h3 class="fw-bold text-warning my-1"><?php echo e($summary['pending']); ?></h3>
            <span class="text-secondary small">Belum Diproses</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm text-center border-start border-danger border-4">
            <small class="text-danger fw-bold text-uppercase" style="font-size: 0.72rem;">Ditolak</small>
            <h3 class="fw-bold text-danger my-1"><?php echo e($summary['rejected']); ?></h3>
            <span class="text-secondary small">Tidak Disetujui</span>
        </div>
    </div>
</div>

<!-- TABEL LAPORAN -->
<div class="card card-custom border-0 shadow-sm overflow-hidden">
    <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 text-dark">
            <i class="fa-solid fa-list-check me-2 text-primary"></i>
            Daftar Data Peminjaman (Periode: <?php echo e(\Carbon\Carbon::parse($startDate)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($endDate)->format('d/m/Y')); ?>)
        </h6>
        <span class="badge bg-light text-dark border"><?php echo e($reservations->count()); ?> Data</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase fw-bold">
                <tr>
                    <th class="ps-4 py-3" style="width: 50px;">No</th>
                    <th class="py-3">Tanggal & Waktu</th>
                    <th class="py-3">Ruangan</th>
                    <th class="py-3">Peminjam</th>
                    <th class="py-3">Keperluan Kegiatan</th>
                    <th class="py-3">Status</th>
                    <th class="pe-4 py-3 text-end">Disetujui Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-4 fw-medium text-muted"><?php echo e($index + 1); ?></td>
                        <td>
                            <div class="fw-bold text-dark"><?php echo e($res->formatted_date); ?></div>
                            <small class="text-muted"><i class="fa-regular fa-clock me-1"></i><?php echo e($res->formatted_time); ?></small>
                        </td>
                        <td>
                            <div class="fw-bold text-dark"><?php echo e($res->room->name); ?></div>
                            <small class="text-muted"><i class="fa-solid fa-location-dot me-1 text-danger"></i><?php echo e($res->room->building); ?></small>
                        </td>
                        <td>
                            <div class="fw-bold text-dark"><?php echo e($res->user->name); ?></div>
                            <small class="text-muted font-monospace"><?php echo e($res->user->identity_number); ?> (<?php echo e($res->user->user_type_label); ?>)</small>
                        </td>
                        <td>
                            <div class="text-dark small text-truncate" style="max-width: 250px;" title="<?php echo e($res->purpose); ?>">
                                <?php echo e($res->purpose); ?>

                            </div>
                            <?php if($res->admin_notes): ?>
                                <small class="text-secondary d-block fst-italic">Catatan: <?php echo e($res->admin_notes); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?php echo e($res->status_badge); ?> rounded-pill px-3 py-1">
                                <?php echo e($res->status_label); ?>

                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <span class="text-muted small"><?php echo e($res->approver ? $res->approver->name : '-'); ?></span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary opacity-50"></i>
                            <div class="fw-bold">Tidak ada data peminjaman dalam rentang tanggal ini</div>
                            <small>Silakan ubah rentang tanggal atau filter lainnya di atas.</small>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>