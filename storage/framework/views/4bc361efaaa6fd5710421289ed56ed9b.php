<?php $__env->startSection('title', 'Laporan Peminjaman'); ?>
<?php $__env->startSection('page_heading', 'Laporan & Rekapitulasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark">Rekap Laporan Peminjaman Sarpras</h4>
        <p class="text-muted small mb-0">Filter laporan berdasarkan rentang tanggal, ruangan, dan status persetujuan.</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.reports.print', request()->query())); ?>" target="_blank" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-print me-2"></i> Cetak / Export PDF
        </a>
    </div>
</div>

<!-- FILTER CARD -->
<div class="card card-custom p-4 mb-4">
    <form action="<?php echo e(route('admin.reports.index')); ?>" method="GET" class="row g-3">
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label small fw-semibold text-secondary">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="<?php echo e($startDate); ?>" required>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label small fw-semibold text-secondary">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" value="<?php echo e($endDate); ?>" required>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label small fw-semibold text-secondary">Pilihan Ruangan</label>
            <select name="room_id" class="form-select">
                <option value="">Semua Ruangan</option>
                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($r->id); ?>" <?php echo e($roomId == $r->id ? 'selected' : ''); ?>><?php echo e($r->name); ?> (<?php echo e($r->code); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label small fw-semibold text-secondary">Status Peminjaman</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="approved" <?php echo e($status === 'approved' ? 'selected' : ''); ?>>Disetujui Saja</option>
                <option value="pending" <?php echo e($status === 'pending' ? 'selected' : ''); ?>>Pending Saja</option>
                <option value="rejected" <?php echo e($status === 'rejected' ? 'selected' : ''); ?>>Ditolak Saja</option>
            </select>
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                <i class="fa-solid fa-filter me-1"></i> Terapkan Filter
            </button>
        </div>
    </form>
</div>

<!-- KPI SUMMARY MINI -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 text-center">
            <div class="small text-muted fw-semibold">Total Pengajuan</div>
            <h3 class="fw-bold mb-0 text-dark mt-1"><?php echo e($summary['total']); ?></h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 text-center">
            <div class="small text-muted fw-semibold">Disetujui</div>
            <h3 class="fw-bold mb-0 text-success mt-1"><?php echo e($summary['approved']); ?></h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 text-center">
            <div class="small text-muted fw-semibold">Menunggu (Pending)</div>
            <h3 class="fw-bold mb-0 text-warning-emphasis mt-1"><?php echo e($summary['pending']); ?></h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 text-center">
            <div class="small text-muted fw-semibold">Ditolak</div>
            <h3 class="fw-bold mb-0 text-danger mt-1"><?php echo e($summary['rejected']); ?></h3>
        </div>
    </div>
</div>

<!-- TABEL LAPORAN -->
<div class="card card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th class="ps-3 ps-md-4">No</th>
                        <th>Tanggal & Jam</th>
                        <th>Ruangan</th>
                        <th>Peminjam / Ormawa</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-3 ps-md-4 text-muted small"><?php echo e($index + 1); ?></td>
                            <td>
                                <div class="fw-semibold small"><?php echo e($res->formatted_date); ?></div>
                                <small class="text-muted"><?php echo e($res->formatted_time); ?></small>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border"><?php echo e($res->room->code); ?></span>
                                <div class="small fw-semibold mt-1"><?php echo e($res->room->name); ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold small"><?php echo e($res->user->name); ?></div>
                                <small class="text-muted"><?php echo e($res->user->identifier); ?> - <?php echo e($res->user->department); ?></small>
                            </td>
                            <td class="small text-secondary" style="max-width: 280px;">
                                <?php echo e($res->purpose); ?>

                            </td>
                            <td>
                                <span class="badge rounded-pill <?php echo e($res->status_badge); ?> px-2 py-1">
                                    <?php echo e($res->status_label); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Tidak ada catatan peminjaman dalam rentang tanggal yang dipilih.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>