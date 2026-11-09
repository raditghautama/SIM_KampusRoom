<?php $__env->startSection('title', 'Katalog & Ketersediaan Ruangan'); ?>
<?php $__env->startSection('page_heading', 'Katalog & Ketersediaan Ruangan'); ?>

<?php $__env->startSection('content'); ?>
<!-- HERO SECTION DENGAN REAL-TIME STATUS BANNER -->
<div class="card border-0 rounded-4 text-white p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
    <div class="row align-items-center">
        <div class="col-12 col-lg-8">
            <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 mb-2 font-monospace small">
                <span class="pulse-dot-green me-1"></span> Cek Ketersediaan Real-Time
            </span>
            <h2 class="fw-bold mb-2">Temukan & Cek Ruangan Kampus yang Siap Digunakan</h2>
            <p class="text-white-50 mb-3 small fs-6">
                Pantau langsung ruangan mana yang kosong (*Available*) atau terisi (*Occupied*) sesuai tanggal dan jam kegiatanmu.
            </p>

            <!-- STATISTIK CEPAT KETERSEDIAAN -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <span class="badge bg-success bg-opacity-90 rounded-pill px-3 py-2 shadow-sm">
                    <i class="fa-solid fa-circle-check me-1"></i> <?php echo e($stats['available_count']); ?> Ruang Tersedia
                </span>
                <span class="badge bg-danger bg-opacity-90 rounded-pill px-3 py-2 shadow-sm">
                    <i class="fa-solid fa-user-lock me-1"></i> <?php echo e($stats['occupied_count']); ?> Ruang Terisi / Terjadwal
                </span>
                <?php if($stats['maintenance_count'] > 0): ?>
                    <span class="badge bg-secondary rounded-pill px-3 py-2 shadow-sm">
                        <i class="fa-solid fa-wrench me-1"></i> <?php echo e($stats['maintenance_count']); ?> Pemeliharaan
                    </span>
                <?php endif; ?>
            </div>

            <!-- FORM PENCARIAN TEKS & LOKASI -->
            <form action="<?php echo e(route('peminjam.room-catalog')); ?>" method="GET" class="row g-2 bg-white p-2 rounded-4 shadow">
                <!-- Preserve Time Checking Query -->
                <input type="hidden" name="check_date" value="<?php echo e($checkDate); ?>">
                <input type="hidden" name="check_start_time" value="<?php echo e($checkStartTime); ?>">
                <input type="hidden" name="check_end_time" value="<?php echo e($checkEndTime); ?>">
                <input type="hidden" name="preset" value="<?php echo e($preset); ?>">

                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-control border-0" placeholder="Cari nama ruangan, gedung, atau fasilitas..." value="<?php echo e($search); ?>">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select name="building" class="form-select border-0 bg-light rounded-3">
                        <option value="">Semua Lokasi / Gedung</option>
                        <?php $__currentLoopData = $buildings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($b); ?>" <?php echo e($building === $b ? 'selected' : ''); ?>><?php echo e($b); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="capacity" class="form-select border-0 bg-light rounded-3">
                        <option value="">Kapasitas</option>
                        <option value="30" <?php echo e($capacity == 30 ? 'selected' : ''); ?>>&ge; 30 Orang</option>
                        <option value="50" <?php echo e($capacity == 50 ? 'selected' : ''); ?>>&ge; 50 Orang</option>
                        <option value="100" <?php echo e($capacity == 100 ? 'selected' : ''); ?>>&ge; 100 Orang</option>
                        <option value="200" <?php echo e($capacity == 200 ? 'selected' : ''); ?>>&ge; 200 Orang</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
                        Cari Ruang
                    </button>
                </div>
            </form>
        </div>
        <div class="col-12 col-lg-4 d-none d-lg-block text-end">
            <i class="fa-solid fa-building-circle-check fa-8x text-white opacity-25"></i>
        </div>
    </div>
</div>

<!-- WIDGET FILTER CEK KETERSEDIAAN WAKTU (KALENDER & JAM) -->
<div class="card card-custom border-0 p-3 p-md-4 shadow-sm mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
        <div class="d-flex align-items-center gap-2">
            <div class="bg-primary text-white p-2 rounded-3">
                <i class="fa-solid fa-calendar-days fa-lg"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0">Cek Jadwal & Ketersediaan Ruangan</h6>
                <small class="text-muted">Pilih tanggal dan rentang jam untuk memeriksa status ketersediaan</small>
            </div>
        </div>

        <!-- Quick Preset Buttons -->
        <div class="d-flex flex-wrap gap-1">
            <a href="<?php echo e(route('peminjam.room-catalog', array_merge(request()->query(), ['preset' => 'now', 'check_date' => date('Y-m-d')]))); ?>" 
               class="btn btn-sm <?php echo e($preset === 'now' ? 'btn-primary' : 'btn-outline-secondary'); ?> rounded-pill px-3">
                <i class="fa-solid fa-clock me-1"></i> Saat Ini (Sekarang)
            </a>
            <a href="<?php echo e(route('peminjam.room-catalog', array_merge(request()->query(), ['preset' => 'morning', 'check_date' => $checkDate]))); ?>" 
               class="btn btn-sm <?php echo e($preset === 'morning' ? 'btn-primary' : 'btn-outline-secondary'); ?> rounded-pill px-3">
                <i class="fa-solid fa-sun me-1"></i> Pagi (08:00 - 12:00)
            </a>
            <a href="<?php echo e(route('peminjam.room-catalog', array_merge(request()->query(), ['preset' => 'afternoon', 'check_date' => $checkDate]))); ?>" 
               class="btn btn-sm <?php echo e($preset === 'afternoon' ? 'btn-primary' : 'btn-outline-secondary'); ?> rounded-pill px-3">
                <i class="fa-solid fa-cloud-sun me-1"></i> Siang (13:00 - 17:00)
            </a>
            <a href="<?php echo e(route('peminjam.room-catalog', array_merge(request()->query(), ['preset' => 'evening', 'check_date' => $checkDate]))); ?>" 
               class="btn btn-sm <?php echo e($preset === 'evening' ? 'btn-primary' : 'btn-outline-secondary'); ?> rounded-pill px-3">
                <i class="fa-solid fa-moon me-1"></i> Malam (18:30 - 21:30)
            </a>
        </div>
    </div>

    <!-- Form Kustom Tanggal & Jam -->
    <form action="<?php echo e(route('peminjam.room-catalog')); ?>" method="GET" class="row g-2 align-items-end pt-2 border-top">
        <input type="hidden" name="search" value="<?php echo e($search); ?>">
        <input type="hidden" name="building" value="<?php echo e($building); ?>">
        <input type="hidden" name="capacity" value="<?php echo e($capacity); ?>">
        <input type="hidden" name="preset" value="custom">

        <div class="col-12 col-sm-4 col-md-3">
            <label class="form-label small fw-bold text-secondary mb-1">Pilih Tanggal</label>
            <input type="date" name="check_date" class="form-control form-control-sm" value="<?php echo e($checkDate); ?>" required>
        </div>
        <div class="col-6 col-sm-4 col-md-3">
            <label class="form-label small fw-bold text-secondary mb-1">Jam Mulai</label>
            <input type="time" name="check_start_time" class="form-control form-control-sm" value="<?php echo e($checkStartTime); ?>" required>
        </div>
        <div class="col-6 col-sm-4 col-md-3">
            <label class="form-label small fw-bold text-secondary mb-1">Jam Selesai</label>
            <input type="time" name="check_end_time" class="form-control form-control-sm" value="<?php echo e($checkEndTime); ?>" required>
        </div>
        <div class="col-12 col-md-3">
            <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3 fw-semibold">
                <i class="fa-solid fa-arrows-rotate me-1"></i> Periksa Slot Waktu
            </button>
        </div>
    </form>

    <div class="mt-2 text-secondary small bg-light p-2 rounded-3 d-flex align-items-center gap-2">
        <i class="fa-solid fa-circle-info text-primary"></i>
        <span>
            Status ketersediaan di bawah ini dihitung untuk tanggal <strong><?php echo e(\Carbon\Carbon::parse($checkDate)->translatedFormat('d F Y')); ?></strong> pukul <strong><?php echo e($checkStartTime); ?> - <?php echo e($checkEndTime); ?> WIB</strong>.
        </span>
    </div>
</div>

<!-- GRID DAFTAR RUANGAN DENGAN INDIKATOR REAL-TIME -->
<div class="row g-4">
    <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card card-custom h-100 card-hover overflow-hidden d-flex flex-column border <?php echo e($room->availability_status === 'available' ? 'border-success-subtle' : ($room->availability_status === 'occupied' ? 'border-danger-subtle' : '')); ?>">
                
                <!-- Thumbnail & Badges -->
                <div class="position-relative" style="height: 200px;">
                    <img src="<?php echo e($room->image_url); ?>" alt="<?php echo e($room->name); ?>" class="w-100 h-100 object-fit-cover">
                    
                    <!-- INDIKATOR STATUS REAL-TIME (AVAILABLE / OCCUPIED / MAINTENANCE) -->
                    <div class="position-absolute top-0 start-0 m-3">
                        <?php if($room->availability_status === 'available'): ?>
                            <span class="badge bg-success bg-opacity-95 rounded-pill px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2">
                                <span class="pulse-dot-green"></span>
                                <span>KOSONG (Tersedia)</span>
                            </span>
                        <?php elseif($room->availability_status === 'occupied'): ?>
                            <span class="badge bg-danger bg-opacity-95 rounded-pill px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2">
                                <span class="pulse-dot-red"></span>
                                <span>TERISI (Occupied)</span>
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary bg-opacity-95 rounded-pill px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2">
                                <i class="fa-solid fa-wrench"></i>
                                <span>Pemeliharaan</span>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Kapasitas Badge -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2 shadow-sm text-white">
                            <i class="fa-solid fa-users me-1"></i> <?php echo e($room->capacity); ?> Orang
                        </span>
                    </div>

                    <!-- Kode Ruangan Pill -->
                    <div class="position-absolute bottom-0 start-0 m-3">
                        <span class="badge bg-white text-dark rounded-pill px-3 py-1 shadow-sm fw-bold font-monospace">
                            <?php echo e($room->code); ?>

                        </span>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="card-body p-3 p-md-4 d-flex flex-column flex-grow-1">
                    <div class="text-muted small mb-1">
                        <i class="fa-solid fa-location-dot text-danger me-1"></i> <?php echo e($room->building); ?>

                    </div>
                    <h5 class="fw-bold text-dark mb-2"><?php echo e($room->name); ?></h5>
                    <p class="text-secondary small mb-3 text-truncate-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <?php echo e($room->description ?? 'Ruangan representatif kampus yang siap menunjang berbagai kegiatan akademik dan organisasi.'); ?>

                    </p>

                    <!-- INFORMASI KETERSEDIAAN / JADWAL AKTIF -->
                    <?php if($room->availability_status === 'occupied' && $room->active_reservation): ?>
                        <div class="p-2 mb-3 bg-danger bg-opacity-10 border border-danger-subtle rounded-3 small">
                            <div class="fw-bold text-danger d-flex align-items-center gap-1 mb-1">
                                <i class="fa-solid fa-clock"></i>
                                <span>Terisi: <?php echo e(substr($room->active_reservation->start_time, 0, 5)); ?> - <?php echo e(substr($room->active_reservation->end_time, 0, 5)); ?> WIB</span>
                            </div>
                            <div class="text-dark small text-truncate" title="<?php echo e($room->active_reservation->purpose); ?>">
                                <?php echo e($room->active_reservation->purpose); ?>

                            </div>
                            <div class="text-muted" style="font-size: 0.72rem;">
                                Oleh: <?php echo e($room->active_reservation->user->name); ?>

                            </div>
                        </div>
                    <?php elseif($room->availability_status === 'available'): ?>
                        <div class="p-2 mb-3 bg-success bg-opacity-10 border border-success-subtle rounded-3 small text-success">
                            <i class="fa-solid fa-circle-check me-1"></i> Ruangan bebas dari kegiatan pada slot waktu ini. Siap dipinjam!
                        </div>
                    <?php endif; ?>

                    <!-- Fasilitas Singkat -->
                    <?php if(!empty($room->facilities_list)): ?>
                        <div class="mb-3">
                            <small class="text-muted d-block fw-semibold mb-1">Fasilitas Utama:</small>
                            <div class="d-flex flex-wrap gap-1">
                                <?php $__currentLoopData = array_slice($room->facilities_list, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-light text-secondary border font-weight-normal" style="font-size: 0.7rem;">
                                        <i class="fa-solid fa-check text-primary me-1"></i><?php echo e($fac); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($room->facilities_list) > 3): ?>
                                    <span class="badge bg-light text-muted border" style="font-size: 0.7rem;">
                                        +<?php echo e(count($room->facilities_list) - 3); ?> lainnya
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="mt-auto pt-3 border-top d-flex gap-2">
                        <a href="<?php echo e(route('peminjam.rooms.show', $room->id)); ?>" class="btn btn-outline-secondary btn-sm rounded-pill flex-grow-1">
                            <i class="fa-solid fa-eye me-1"></i> Detail
                        </a>

                        <?php if($room->availability_status === 'available'): ?>
                            <a href="<?php echo e(route('peminjam.reservations.create', ['room_id' => $room->id, 'reservation_date' => $checkDate, 'start_time' => $checkStartTime, 'end_time' => $checkEndTime])); ?>" 
                               class="btn btn-primary btn-sm rounded-pill flex-grow-1 shadow-sm fw-semibold">
                                <i class="fa-solid fa-circle-plus me-1"></i> Pinjam Ruang
                            </a>
                        <?php elseif($room->availability_status === 'occupied'): ?>
                            <a href="<?php echo e(route('peminjam.rooms.show', $room->id)); ?>" class="btn btn-warning btn-sm rounded-pill flex-grow-1 text-dark fw-semibold">
                                <i class="fa-solid fa-calendar-check me-1"></i> Cek Jadwal
                            </a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm rounded-pill flex-grow-1" disabled>
                                Pemeliharaan
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 py-5 text-center text-muted">
            <div class="rounded-circle bg-light d-inline-flex p-4 mb-3">
                <i class="fa-solid fa-building-circle-xmark fa-3x text-secondary opacity-50"></i>
            </div>
            <h5 class="fw-bold text-dark">Tidak Ada Ruangan yang Sesuai</h5>
            <p class="small text-secondary">Silakan ubah kriteria pencarian nama ruangan atau filter lokasi di atas.</p>
            <a href="<?php echo e(route('peminjam.room-catalog')); ?>" class="btn btn-primary rounded-pill px-4 btn-sm">
                Tampilkan Semua Ruangan
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- PAGINASI -->
<?php if($rooms->hasPages()): ?>
    <div class="mt-4 d-flex justify-content-center">
        <?php echo e($rooms->links()); ?>

    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/user/catalog.blade.php ENDPATH**/ ?>