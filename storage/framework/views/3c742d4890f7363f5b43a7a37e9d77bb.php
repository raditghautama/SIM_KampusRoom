<?php $__env->startSection('title', 'Edit Data Pengguna'); ?>
<?php $__env->startSection('page_heading', 'Edit Data Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card card-custom border-0 shadow-sm p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                <div>
                    <h4 class="fw-bold mb-1">Edit Pengguna: <?php echo e($user->name); ?></h4>
                    <p class="text-muted small mb-0">ID Pengguna: <strong><?php echo e($user->identity_number); ?></strong> &bull; Peran: <span class="badge <?php echo e($user->user_type_badge); ?>"><?php echo e($user->user_type_label); ?></span></p>
                </div>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row g-3">
                    <!-- Kategori Pengguna -->
                    <div class="col-12 col-md-6">
                        <label for="user_type" class="form-label small fw-bold text-secondary">Kategori Pengguna <span class="text-danger">*</span></label>
                        <select name="user_type" id="user_type" class="form-select <?php $__errorArgs = ['user_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="mahasiswa" <?php echo e(old('user_type', $user->user_type) === 'mahasiswa' ? 'selected' : ''); ?>>Mahasiswa (Peminjam)</option>
                            <option value="dosen" <?php echo e(old('user_type', $user->user_type) === 'dosen' ? 'selected' : ''); ?>>Dosen (Peminjam)</option>
                            <option value="tendik" <?php echo e(old('user_type', $user->user_type) === 'tendik' ? 'selected' : ''); ?>>Tenaga Kependidikan</option>
                            <option value="admin" <?php echo e(old('user_type', $user->user_type) === 'admin' ? 'selected' : ''); ?>>Administrator Sarpras</option>
                        </select>
                        <?php $__errorArgs = ['user_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Nomor Identitas (NIM / NIDN / NIP) -->
                    <div class="col-12 col-md-6">
                        <label for="identity_number" class="form-label small fw-bold text-secondary">NIM / NIDN / Username <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border <?php $__errorArgs = ['identity_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><i class="fa-solid fa-id-card text-muted"></i></span>
                            <input type="text" name="identity_number" id="identity_number" class="form-control <?php $__errorArgs = ['identity_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('identity_number', $user->identity_number)); ?>" required>
                        </div>
                        <?php $__errorArgs = ['identity_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="col-12">
                        <label for="name" class="form-label small fw-bold text-secondary">Nama Lengkap Pengguna <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $user->name)); ?>" required>
                        </div>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Nomor WhatsApp / HP -->
                    <div class="col-12 col-md-6">
                        <label for="no_hp" class="form-label small fw-bold text-secondary">Nomor WhatsApp / HP Aktif <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><i class="fab fa-whatsapp text-success"></i></span>
                            <input type="text" name="no_hp" id="no_hp" class="form-control <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('no_hp', $user->no_hp)); ?>" required>
                        </div>
                        <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Alamat Email -->
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label small fw-bold text-secondary">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $user->email)); ?>">
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Program Studi / Departemen -->
                    <div class="col-12">
                        <label for="department" class="form-label small fw-bold text-secondary">Program Studi / Fakultas / Bagian <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><i class="fa-solid fa-building-columns text-muted"></i></span>
                            <input type="text" name="department" id="department" class="form-control <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('department', $user->department)); ?>" required>
                        </div>
                        <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 my-2">
                            <div class="small fw-bold text-secondary mb-1">
                                <i class="fa-solid fa-lock text-warning me-1"></i> Ganti Password (Opsional)
                            </div>
                            <small class="text-muted d-block mb-3">Kosongkan kedua isian di bawah ini jika Anda tidak ingin mereset password pengguna ini.</small>

                            <div class="row g-2">
                                <div class="col-12 col-md-6">
                                    <label class="form-label small text-secondary">Password Baru</label>
                                    <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Isi untuk ganti password">
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small text-secondary">Ulangi Password Baru</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>