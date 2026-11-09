<?php $__env->startSection('title', 'Pengaturan Akun & Profil'); ?>
<?php $__env->startSection('page_heading', 'Pengaturan Akun & Keamanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <!-- KOLOM KIRI: KARTU IDENTITAS USER -->
    <div class="col-12 col-lg-4">
        <div class="card card-custom border-0 shadow-sm p-4 text-center h-100">
            <div class="position-relative d-inline-block mx-auto mb-3">
                <div class="rounded-circle bg-primary bg-gradient text-white d-flex align-items-center justify-content-center shadow-sm fw-bold mx-auto" 
                     style="width: 88px; height: 88px; font-size: 2.2rem;">
                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                </div>
                <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-white rounded-circle" title="Akun Aktif"></span>
            </div>

            <h4 class="fw-bold mb-1 text-dark"><?php echo e($user->name); ?></h4>
            <div class="text-muted small mb-2 font-monospace"><?php echo e($user->identity_number); ?></div>

            <div class="d-flex justify-content-center gap-2 mb-3">
                <span class="badge <?php echo e($user->role === 'admin' ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-primary-subtle text-primary border border-primary-subtle'); ?> px-3 py-1 rounded-pill">
                    <i class="fa-solid fa-shield-halved me-1"></i> <?php echo e($user->user_type_label); ?>

                </span>
            </div>

            <hr class="text-secondary opacity-25 my-3">

            <div class="text-start small">
                <div class="d-flex align-items-center gap-2 py-2 border-bottom border-light">
                    <span class="text-muted" style="width: 24px;"><i class="fa-solid fa-building-columns"></i></span>
                    <span class="text-muted">Unit / Prodi:</span>
                    <strong class="ms-auto text-dark text-end"><?php echo e($user->department ?? '-'); ?></strong>
                </div>
                <div class="d-flex align-items-center gap-2 py-2 border-bottom border-light">
                    <span class="text-muted" style="width: 24px;"><i class="fab fa-whatsapp text-success"></i></span>
                    <span class="text-muted">WhatsApp:</span>
                    <strong class="ms-auto text-dark"><?php echo e($user->no_hp ?? '-'); ?></strong>
                </div>
                <div class="d-flex align-items-center gap-2 py-2 border-bottom border-light">
                    <span class="text-muted" style="width: 24px;"><i class="fa-solid fa-envelope"></i></span>
                    <span class="text-muted">Email:</span>
                    <strong class="ms-auto text-dark text-truncate" style="max-width: 170px;"><?php echo e($user->email ?? '-'); ?></strong>
                </div>
                <div class="d-flex align-items-center gap-2 py-2">
                    <span class="text-muted" style="width: 24px;"><i class="fa-solid fa-calendar-check"></i></span>
                    <span class="text-muted">Terdaftar:</span>
                    <strong class="ms-auto text-dark"><?php echo e($user->created_at ? $user->created_at->format('d M Y') : '-'); ?></strong>
                </div>
            </div>

            <?php if($user->role === 'peminjam'): ?>
                <div class="mt-4 p-3 bg-light rounded-4 text-start">
                    <div class="small fw-bold text-secondary mb-1">
                        <i class="fa-solid fa-info-circle text-primary me-1"></i> Status Peminjaman
                    </div>
                    <div class="d-flex justify-content-between small text-muted">
                        <span>Total Peminjaman:</span>
                        <strong class="text-dark"><?php echo e($user->reservations()->count()); ?> kali</strong>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- KOLOM KANAN: FORM EDIT PROFIL & GANTI PASSWORD -->
    <div class="col-12 col-lg-8">
        <div class="d-flex flex-column gap-4">
            
            <!-- FORM 1: INFORMASI PRIBADI -->
            <div class="card card-custom border-0 shadow-sm p-4">
                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                    <div class="bg-primary-subtle text-primary p-2 rounded-3">
                        <i class="fa-solid fa-address-card fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Informasi Pribadi</h5>
                        <small class="text-muted">Perbarui data identitas dan kontak aktif Anda</small>
                    </div>
                </div>

                <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row g-3">
                        <!-- Nomor Identitas (Readonly) -->
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-secondary">Nomor Identitas (NIM / NIDN / NIP)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border"><i class="fa-solid fa-id-badge text-muted"></i></span>
                                <input type="text" class="form-control bg-light" value="<?php echo e($user->identity_number); ?>" readonly disabled>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Nomor identitas ditetapkan oleh sistem sarpras.</small>
                        </div>

                        <!-- Peran / Kategori (Readonly) -->
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-secondary">Kategori Pengguna</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border"><i class="fa-solid fa-user-tag text-muted"></i></span>
                                <input type="text" class="form-control bg-light" value="<?php echo e($user->user_type_label); ?>" readonly disabled>
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label small fw-bold text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
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
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('no_hp', $user->no_hp)); ?>" placeholder="Contoh: 6281234567890" required>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Digunakan admin untuk konfirmasi approval via WhatsApp.</small>
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
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $user->email)); ?>" placeholder="nama@campus.ac.id">
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
                        <div class="col-12 col-md-6">
                            <label for="department" class="form-label small fw-bold text-secondary">Program Studi / Instansi / Unit <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><i class="fa-solid fa-landmark text-muted"></i></span>
                                <input type="text" name="department" id="department" class="form-control <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('department', $user->department)); ?>" placeholder="Contoh: S1 Teknik Informatika" required>
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
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- FORM 2: PENGATURAN PASSWORD & KEAMANAN -->
            <div class="card card-custom border-0 shadow-sm p-4">
                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                    <div class="bg-warning-subtle text-warning-emphasis p-2 rounded-3">
                        <i class="fa-solid fa-shield-keyhole fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Ubah Password Akun</h5>
                        <small class="text-muted">Ganti password secara berkala untuk menjaga keamanan akun Anda</small>
                    </div>
                </div>

                <form action="<?php echo e(route('profile.password')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row g-3">
                        <!-- Password Saat Ini (Lama) -->
                        <div class="col-12">
                            <label for="current_password" class="form-label small fw-bold text-secondary">Password Saat Ini (Lama) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="current_password" id="current_password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Ketikkan password saat ini..." required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassVisibility('current_password', 'eye1')">
                                    <i class="fa-regular fa-eye" id="eye1"></i>
                                </button>
                            </div>
                            <?php $__errorArgs = ['current_password'];
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

                        <!-- Password Baru -->
                        <div class="col-12 col-md-6">
                            <label for="new_password" class="form-label small fw-bold text-secondary">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><i class="fa-solid fa-key text-muted"></i></span>
                                <input type="password" name="password" id="new_password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Minimal 8 karakter..." required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassVisibility('new_password', 'eye2')">
                                    <i class="fa-regular fa-eye" id="eye2"></i>
                                </button>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Gunakan kombinasi huruf dan angka.</small>
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

                        <!-- Konfirmasi Password Baru -->
                        <div class="col-12 col-md-6">
                            <label for="password_confirmation" class="form-label small fw-bold text-secondary">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border"><i class="fa-solid fa-check-double text-muted"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru..." required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassVisibility('password_confirmation', 'eye3')">
                                    <i class="fa-regular fa-eye" id="eye3"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-warning rounded-pill px-4 py-2 fw-semibold shadow-sm">
                            <i class="fa-solid fa-key me-1"></i> Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function togglePassVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/profile/index.blade.php ENDPATH**/ ?>