<?php $__env->startSection('title', 'Manajemen Ruangan'); ?>
<?php $__env->startSection('page_heading', 'Daftar Ruangan Kampus'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark">Data Master Ruangan</h4>
        <p class="text-muted small mb-0">Kelola informasi ruangan, kapasitas, fasilitas, dan status operasional.</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.rooms.create')); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Tambah Ruangan
        </a>
    </div>
</div>

<!-- FILTER & SEARCH BAR -->
<div class="card card-custom p-3 mb-4">
    <form action="<?php echo e(route('admin.rooms.index')); ?>" method="GET" class="row g-2 align-items-center">
        <div class="col-12 col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, kode, atau fasilitas..." value="<?php echo e($search); ?>">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="available" <?php echo e($status === 'available' ? 'selected' : ''); ?>>Tersedia</option>
                <option value="maintenance" <?php echo e($status === 'maintenance' ? 'selected' : ''); ?>>Pemeliharaan</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <button type="submit" class="btn btn-primary w-100 rounded-3">
                <i class="fa-solid fa-filter me-1"></i> Filter
            </button>
        </div>
        <?php if($search || $status): ?>
            <div class="col-12 col-md-2">
                <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn btn-outline-secondary w-100 rounded-3">Reset</a>
            </div>
        <?php endif; ?>
    </form>
</div>

<!-- TABEL / CARD DAFTAR RUANGAN (RESPONSIF MOBILE-FRIENDLY) -->
<div class="card card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th class="ps-3 ps-md-4">Ruangan & Lokasi</th>
                        <th>Kode</th>
                        <th>Kapasitas</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th class="text-end pe-3 ps-md-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-3 ps-md-4">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="<?php echo e($room->image_url); ?>" alt="<?php echo e($room->name); ?>" class="rounded-3 object-fit-cover shadow-sm" style="width: 54px; height: 54px;">
                                    <div>
                                        <div class="fw-bold text-dark"><?php echo e($room->name); ?></div>
                                        <small class="text-muted"><i class="fa-solid fa-location-dot me-1 text-danger"></i><?php echo e($room->building); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border fw-semibold"><?php echo e($room->code); ?></span>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark"><i class="fa-solid fa-users text-secondary me-1"></i><?php echo e($room->capacity); ?></span>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Orang</small>
                            </td>
                            <td style="max-width: 250px;">
                                <div class="text-truncate small text-secondary" title="<?php echo e($room->facilities); ?>">
                                    <?php echo e($room->facilities ?: 'Tidak ada keterangan fasilitas.'); ?>

                                </div>
                            </td>
                            <td>
                                <?php if($room->status === 'available'): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                        <i class="fa-solid fa-circle-check me-1"></i> Tersedia
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Maintenance
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3 ps-md-4">
                                <div class="d-inline-flex gap-1">
                                    <a href="<?php echo e(route('admin.rooms.edit', $room->id)); ?>" class="btn btn-light btn-sm text-primary border rounded-pill px-3" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.rooms.destroy', $room->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-light btn-sm text-danger border rounded-pill px-3" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-door-closed fa-3x mb-2 d-block opacity-50"></i>
                                Tidak ada data ruangan yang ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($rooms->hasPages()): ?>
        <div class="card-footer bg-transparent py-3 px-4 border-0">
            <?php echo e($rooms->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/admin/rooms/index.blade.php ENDPATH**/ ?>