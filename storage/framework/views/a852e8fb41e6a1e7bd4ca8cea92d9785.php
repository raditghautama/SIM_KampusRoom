<?php $__env->startSection('title', 'Masuk ke Akun - SIMPEL Universitas Nurul Jadid'); ?>

<?php $__env->startSection('content'); ?>
<div class="split-card row g-0">
    <!-- SISI KIRI (Dark Navy Blue Background) -->
    <div class="col-lg-5 split-card-left">
        <div>
            <!-- Badge Atas -->
            <div class="mb-4">
                <span class="portal-badge">
                    <i class="fa-solid fa-mobile-screen-button me-1"></i>
                    PORTAL AKADEMIK
                </span>
            </div>

            <!-- Logo Kampus & Judul -->
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="campus-logo-box">
                    <!-- Pastikan menyesuaikan path logo Universitas Nurul Jadid -->
                    <img src="<?php echo e(asset('assets/img/logounuja.png')); ?>" alt="Logo Universitas Nurul Jadid" class="img-fluid" style="max-height: 48px;">
                </div>
            </div>

            <h1 class="brand-title fw-bold text-white mt-3 mb-1" style="font-size: 1.8rem; letter-spacing: 0.5px;">SIKAM</h1>

            <!-- Subtitle -->
            <div class="brand-subtitle text-uppercase fw-semibold mb-3" style="font-size: 0.75rem; letter-spacing: 0.5px; opacity: 0.9;">
                SISTEM INFORMASI KAMPUS ROOM
            </div>

            <!-- Deskripsi Singkat -->
            <p class="brand-desc mb-4" style="font-size: 0.85rem; opacity: 0.75; line-height: 1.5;">
                Platform integrasi evaluasi perkuliahan dan pemantauan kinerja perkuliahan Universitas Nurul Jadid.
            </p>
        </div>

        <!-- Checklist Fitur Bawah -->
        <div class="feature-checklist mt-auto">
            <div class="d-flex align-items-center mb-3">
                <div class="check-icon-circle me-3">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-light fw-medium" style="font-size: 0.85rem; opacity: 0.9;">Terintegrasi dengan SIMPT Kampus</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="check-icon-circle me-3">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <span class="text-light fw-medium" style="font-size: 0.85rem; opacity: 0.9;">Akses Keamanan Data Terenkripsi</span>
            </div>
        </div>
    </div>

    <!-- SISI KANAN (White Background) -->
    <div class="col-lg-7 split-card-right d-flex flex-column justify-content-between p-4 p-md-5">
        <div>
            <!-- Header Kanan -->
            <div class="mb-4">
                <h2 class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.01em;">Masuk ke Akun</h2>
                <p class="text-muted small mb-0">Silakan lengkapi kredensial identitas Anda di bawah ini.</p>
            </div>

            <!-- Flash & Error Messages -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 px-3 mb-3 border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check me-1"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="alert alert-info alert-dismissible fade show rounded-3 small py-2 px-3 mb-3 border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-info me-1"></i> <?php echo e(session('info')); ?>

                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show rounded-3 small py-2 px-3 mb-3 border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> <?php echo e(session('warning')); ?>

                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 px-3 mb-3 border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3 border-0 shadow-sm">
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form action="<?php echo e(route('login.post')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <!-- Form Input 1: USERNAME (nidn / nim / nip) -->
                <div class="mb-3">
                    <label for="identity_number" class="form-label-custom text-uppercase fw-bold text-secondary" style="font-size: 0.75rem;">
                        USERNAME <span class="text-muted fw-normal fs-7">(nidn / nim / nip)</span>
                    </label>
                    <div class="input-group-custom d-flex align-items-center rounded-3 bg-light px-3 py-1 border">
                        <span class="text-muted me-2"><i class="fa-solid fa-id-card"></i></span>
                        <input type="text" 
                               name="identity_number" 
                               id="identity_number" 
                               class="form-control bg-transparent border-0 shadow-none <?php $__errorArgs = ['identity_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('identity_number')); ?>" 
                               placeholder="Masukkan NIDN / NIM atau Username" 
                               required 
                               autofocus>
                    </div>
                </div>

                <!-- Form Input 2: PASSWORD -->
                <div class="mb-4">
                    <label for="password" class="form-label-custom text-uppercase fw-bold text-secondary" style="font-size: 0.75rem;">
                        PASSWORD
                    </label>
                    <div class="input-group-custom d-flex align-items-center rounded-3 bg-light px-3 py-1 border">
                        <span class="text-muted me-2"><i class="fa-solid fa-key"></i></span>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control bg-transparent border-0 shadow-none <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               placeholder="••••••••" 
                               required>
                        <button class="btn border-0 p-0 text-muted shadow-none" type="button" id="togglePasswordBtn" title="Lihat / Sembunyikan Password">
                            <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary w-100 py-2-5 shadow-sm d-flex align-items-center justify-content-center gap-2 mb-4 rounded-3" style="background: linear-gradient(135deg, #2563eb, #3b82f6); border: none;">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span class="fw-semibold">Masuk Sistem Sekarang</span>
                </button>
            </form>
        </div>

        <!-- Footer Copyright Bawah -->
        <div class="footer-copyright text-center text-muted small mt-4">
            <div class="fw-bold mb-1" style="font-size: 0.75rem;">&copy; <?php echo e(date('Y')); ?> UNIVERSITAS NURUL JADID</div>
            <div style="font-size: 0.7rem; opacity: 0.75;">SIKAM - Sistem Informasi Kampus Room</div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Fitur Toggle Show/Hide Password (Ikon Mata)
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                    toggleBtn.setAttribute('title', 'Sembunyikan Password');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                    toggleBtn.setAttribute('title', 'Lihat Password');
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/auth/login.blade.php ENDPATH**/ ?>