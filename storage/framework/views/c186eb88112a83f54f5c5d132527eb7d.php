<?php $__env->startSection('title', 'Edit Ruangan'); ?>
<?php $__env->startSection('page_heading', 'Edit Ruangan: ' . $room->name); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Perbarui Data Ruangan</h5>
                    <p class="text-muted small mb-0">Ubah informasi spesifikasi atau status ruangan kampus.</p>
                </div>
                <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3">
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.rooms.update', $room->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-8">
                        <label for="name" class="form-label small fw-semibold text-secondary">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $room->name)); ?>" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="code" class="form-label small fw-semibold text-secondary">Kode Ruangan <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('code', $room->code)); ?>" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="building" class="form-label small fw-semibold text-secondary">Gedung / Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="building" id="building" class="form-control <?php $__errorArgs = ['building'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('building', $room->building)); ?>" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="capacity" class="form-label small fw-semibold text-secondary">Kapasitas (Orang) <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" id="capacity" class="form-control <?php $__errorArgs = ['capacity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('capacity', $room->capacity)); ?>" min="1" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="status" class="form-label small fw-semibold text-secondary">Status Operasional <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="available" <?php echo e(old('status', $room->status) === 'available' ? 'selected' : ''); ?>>Tersedia</option>
                            <option value="maintenance" <?php echo e(old('status', $room->status) === 'maintenance' ? 'selected' : ''); ?>>Pemeliharaan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="facilities" class="form-label small fw-semibold text-secondary">Fasilitas Ruangan</label>
                    <textarea name="facilities" id="facilities" class="form-control <?php $__errorArgs = ['facilities'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="2"><?php echo e(old('facilities', $room->facilities)); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label small fw-semibold text-secondary">Deskripsi & Catatan Penggunaan</label>
                    <textarea name="description" id="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"><?php echo e(old('description', $room->description)); ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label small fw-semibold text-secondary">Ganti Foto Ruangan</label>
                    <?php if($room->image): ?>
                        <div class="mb-2">
                            <img src="<?php echo e($room->image_url); ?>" alt="Preview" class="rounded-3 shadow-sm" style="max-height: 120px; object-fit: cover;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" id="image" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto saat ini.</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-check me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/admin/rooms/edit.blade.php ENDPATH**/ ?>