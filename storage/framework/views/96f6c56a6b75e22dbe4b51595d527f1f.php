<?php $__env->startSection('title', 'Formulir Pengajuan Peminjaman'); ?>
<?php $__env->startSection('page_heading', 'Pengajuan Peminjaman Ruangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Form Pengajuan Peminjaman Ruangan</h5>
                    <p class="text-muted small mb-0">Pastikan jam peminjaman tidak bertabrakan dengan agenda lain yang sudah disetujui.</p>
                </div>
                <a href="<?php echo e(route('peminjam.room-catalog')); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Batal
                </a>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger rounded-4 py-3 px-3 mb-4 shadow-sm">
                    <div class="d-flex align-items-center gap-2 fw-bold text-danger mb-1">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Mohon Periksa Kembali Pengajuan Anda:</span>
                    </div>
                    <ul class="mb-0 ps-3 small">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('peminjam.reservations.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <!-- PILIH RUANGAN -->
                <div class="mb-3">
                    <label for="room_id" class="form-label small fw-semibold text-secondary">
                        Pilih Ruangan Kampus <span class="text-danger">*</span>
                    </label>
                    <select name="room_id" id="room_id" class="form-select <?php $__errorArgs = ['room_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required onchange="updateRoomInfo(this)">
                        <option value="">-- Pilih Ruangan yang Tersedia --</option>
                        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r->id); ?>" 
                                data-building="<?php echo e($r->building); ?>" 
                                data-capacity="<?php echo e($r->capacity); ?>" 
                                data-code="<?php echo e($r->code); ?>"
                                <?php echo e((old('room_id', request('room_id')) == $r->id) ? 'selected' : ''); ?>>
                                <?php echo e($r->name); ?> (<?php echo e($r->code); ?> - Kapasitas: <?php echo e($r->capacity); ?> org)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <div id="roomDetailPreview" class="p-3 bg-light rounded-3 mt-2 small text-secondary d-none">
                        <div class="fw-bold text-dark" id="previewRoomName">Ruangan</div>
                        <div><i class="fa-solid fa-location-dot text-danger me-1"></i> Lokasi: <span id="previewBuilding">-</span></div>
                        <div><i class="fa-solid fa-users text-primary me-1"></i> Kapasitas: <span id="previewCapacity">-</span> orang</div>
                    </div>
                </div>

                <!-- TANGGAL PEMINJAMAN -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <label for="reservation_date" class="form-label small fw-semibold text-secondary">
                            Tanggal Peminjaman <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="reservation_date" id="reservation_date" class="form-control <?php $__errorArgs = ['reservation_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('reservation_date', date('Y-m-d'))); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>

                    <!-- JAM MULAI -->
                    <div class="col-6 col-md-4">
                        <label for="start_time" class="form-label small fw-semibold text-secondary">
                            Jam Mulai <span class="text-danger">*</span>
                        </label>
                        <input type="time" name="start_time" id="start_time" class="form-control <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('start_time', '08:00')); ?>" required>
                    </div>

                    <!-- JAM SELESAI -->
                    <div class="col-6 col-md-4">
                        <label for="end_time" class="form-label small fw-semibold text-secondary">
                            Jam Selesai <span class="text-danger">*</span>
                        </label>
                        <input type="time" name="end_time" id="end_time" class="form-control <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('end_time', '11:00')); ?>" required>
                        <small class="text-muted" style="font-size: 0.72rem;">Harus lebih akhir dari jam mulai.</small>
                    </div>
                </div>

                <!-- KEPERLUAN PEMINJAMAN -->
                <div class="mb-3">
                    <label for="purpose" class="form-label small fw-semibold text-secondary">
                        Keperluan & Agenda Kegiatan <span class="text-danger">*</span>
                    </label>
                    <textarea name="purpose" id="purpose" class="form-control <?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3" placeholder="Contoh: Seminar Nasional AI, Workshop Desain BEM, Sidang Skripsi Terbuka..." required minlength="10"><?php echo e(old('purpose')); ?></textarea>
                    <small class="text-muted">Jelaskan nama acara, ormawa pengaju, dan estimasi jumlah peserta.</small>
                </div>

                <!-- UPLOAD FILE PROPOSAL / SURAT IZIN -->
                <div class="mb-4">
                    <label for="proposal_file" class="form-label small fw-semibold text-secondary">
                        Lampiran Surat Permohonan / Proposal (Opsional)
                    </label>
                    <input type="file" name="proposal_file" id="proposal_file" class="form-control <?php $__errorArgs = ['proposal_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">Format: PDF, JPG, atau PNG (Maksimal 5MB). Lampiran resmi mempercepat proses persetujuan admin Sarpras.</small>
                </div>

                <!-- NOTICE PERINGATAN BENTROK JADWAL -->
                <div class="alert alert-light border rounded-3 p-3 mb-4 small text-secondary">
                    <div class="fw-bold text-dark mb-1"><i class="fa-solid fa-circle-info text-primary me-1"></i> Ketentuan Peminjaman:</div>
                    <ul class="mb-0 ps-3">
                        <li>Sistem secara otomatis mengecek jadwal dan mencegah bentrok (ruangan dan jam yang sama tidak bisa dipesan ganda).</li>
                        <li>Pengajuan akan diverifikasi oleh Bagian Sarana dan Prasarana. Anda akan menerima update status di halaman riwayat dan via WhatsApp.</li>
                        <li>Harap menjaga kebersihan dan ketertiban fasilitas ruangan setelah acara selesai.</li>
                    </ul>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?php echo e(route('peminjam.room-catalog')); ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm fw-semibold">
                        <i class="fa-solid fa-paper-plane me-2"></i> Kirim Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function updateRoomInfo(select) {
        const preview = document.getElementById('roomDetailPreview');
        const selected = select.options[select.selectedIndex];
        
        if (select.value) {
            document.getElementById('previewRoomName').innerText = selected.text;
            document.getElementById('previewBuilding').innerText = selected.getAttribute('data-building');
            document.getElementById('previewCapacity').innerText = selected.getAttribute('data-capacity');
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
        }
    }

    // Trigger on load if already selected
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('room_id');
        if (select.value) {
            updateRoomInfo(select);
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/user/reservations/create.blade.php ENDPATH**/ ?>