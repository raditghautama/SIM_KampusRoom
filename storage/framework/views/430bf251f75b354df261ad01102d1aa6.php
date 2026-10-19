<?php $__env->startSection('title', 'Detail Ruangan: ' . $room->name); ?>
<?php $__env->startSection('page_heading', 'Detail & Jadwal Ruangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-3">
    <a href="<?php echo e(route('peminjam.room-catalog')); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Katalog
    </a>
</div>

<div class="row g-4">
    <!-- Kolom Kiri: Spesifikasi & Foto Ruangan -->
    <div class="col-12 col-lg-7">
        <div class="card card-custom overflow-hidden mb-4">
            <div class="position-relative" style="height: 320px;">
                <img src="<?php echo e($room->image_url); ?>" alt="<?php echo e($room->name); ?>" class="w-100 h-100 object-fit-cover">
                <div class="position-absolute bottom-0 start-0 m-3">
                    <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2 text-white">
                        Kode: <?php echo e($room->code); ?>

                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <h4 class="fw-bold text-dark mb-0"><?php echo e($room->name); ?></h4>
                    <?php if($room->status === 'available'): ?>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                            <i class="fa-solid fa-circle-check me-1"></i> Tersedia untuk Dipinjam
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2">
                            <i class="fa-solid fa-wrench me-1"></i> Sedang Pemeliharaan
                        </span>
                    <?php endif; ?>
                </div>

                <div class="d-flex align-items-center gap-4 text-muted mb-3 py-2 border-top border-bottom small">
                    <div>
                        <i class="fa-solid fa-location-dot text-danger me-1"></i> <?php echo e($room->building); ?>

                    </div>
                    <div>
                        <i class="fa-solid fa-users text-primary me-1"></i> Kapasitas <?php echo e($room->capacity); ?> Orang
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-2">Deskripsi Ruangan</h6>
                <p class="text-secondary small mb-4">
                    <?php echo e($room->description ?: 'Ruangan representatif yang dikelola oleh Bagian Sarana dan Prasarana Kampus.'); ?>

                </p>

                <h6 class="fw-bold text-dark mb-2">Fasilitas Tersedia:</h6>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php $__empty_1 = true; $__currentLoopData = $room->facilities_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 small">
                            <i class="fa-solid fa-circle-check text-success me-1"></i> <?php echo e($f); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span class="text-muted small">Tidak ada keterangan fasilitas.</span>
                    <?php endif; ?>
                </div>

                <?php if($room->status === 'available'): ?>
                    <div class="d-grid">
                        <a href="<?php echo e(route('peminjam.reservations.create', ['room_id' => $room->id])); ?>" class="btn btn-primary rounded-pill py-2 fw-semibold shadow-sm">
                            <i class="fa-solid fa-paper-plane me-2"></i> Ajukan Peminjaman Ruangan Ini
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Jadwal Terpakai (7 Hari ke Depan) -->
    <div class="col-12 col-lg-5">
        <div class="card card-custom">
            <div class="card-header bg-transparent border-0 pt-3 px-3 px-md-4">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-regular fa-calendar-check text-primary me-2"></i>Agenda Terjadwal (7 Hari ke Depan)
                </h6>
                <small class="text-muted">Jadwal yang sudah disetujui (tidak dapat dibooking di jam ini)</small>
            </div>

            <div class="card-body p-3 px-md-4">
                <?php $__empty_1 = true; $__currentLoopData = $upcomingSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 bg-light rounded-4 mb-3 border-start border-4 border-primary">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold small text-dark"><i class="fa-regular fa-calendar me-1"></i><?php echo e($sch->formatted_date); ?></span>
                            <span class="badge bg-primary-subtle text-primary fw-semibold"><?php echo e($sch->formatted_time); ?></span>
                        </div>
                        <div class="small fw-semibold text-secondary text-truncate"><?php echo e($sch->purpose); ?></div>
                        <div class="small text-muted" style="font-size: 0.75rem;">
                            Peminjam: <?php echo e($sch->user->name); ?> (<?php echo e($sch->user->department); ?>)
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fa-regular fa-calendar-plus fa-3x mb-2 d-block opacity-50"></i>
                        Belum ada jadwal terpakai dalam 7 hari ke depan.<br>
                        <span class="text-success fw-semibold small">Ruangan masih kosong dan bebas dipilih!</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/user/rooms/show.blade.php ENDPATH**/ ?>