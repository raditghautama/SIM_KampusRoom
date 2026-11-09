<?php $__env->startSection('title', 'Manajemen Pengguna'); ?>
<?php $__env->startSection('page_heading', 'Manajemen Data Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<!-- STATS ROW -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fa-solid fa-users fa-xl"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Total Pengguna</div>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo e($stats['total']); ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-info bg-opacity-10 text-info p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fa-solid fa-graduation-cap fa-xl"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Mahasiswa</div>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo e($stats['mahasiswa']); ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-success bg-opacity-10 text-success p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fa-solid fa-chalkboard-user fa-xl"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Dosen</div>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo e($stats['dosen']); ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 bg-danger bg-opacity-10 text-danger p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fa-solid fa-user-shield fa-xl"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Admin Sarpras</div>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo e($stats['admin']); ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER & ACTION BAR -->
<div class="card card-custom border-0 p-3 p-md-4 shadow-sm mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <!-- Form Search & Filter -->
        <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" class="d-flex flex-column flex-sm-row align-items-stretch gap-2 flex-grow-1" style="max-width: 600px;">
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari nama, NIM, NIDN, nomor WA, prodi..." value="<?php echo e($search); ?>">
            </div>
            <select name="user_type" class="form-select bg-light border-0" style="max-width: 180px;" onchange="this.form.submit()">
                <option value="">Semua Peran</option>
                <option value="mahasiswa" <?php echo e($userType === 'mahasiswa' ? 'selected' : ''); ?>>Mahasiswa</option>
                <option value="dosen" <?php echo e($userType === 'dosen' ? 'selected' : ''); ?>>Dosen</option>
                <option value="admin" <?php echo e($userType === 'admin' ? 'selected' : ''); ?>>Admin Sarpras</option>
            </select>
            <button type="submit" class="btn btn-secondary px-3">Filter</button>
            <?php if($search || $userType): ?>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            <?php endif; ?>
        </form>

        <!-- Tombol Tambah Pengguna -->
        <div>
            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Pengguna Baru</span>
            </a>
        </div>
    </div>
</div>

<!-- USERS TABLE -->
<div class="card card-custom border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase fw-bold">
                <tr>
                    <th class="ps-4 py-3" style="width: 50px;">No</th>
                    <th class="py-3">Pengguna</th>
                    <th class="py-3">Kategori & Peran</th>
                    <th class="py-3">Kontak WhatsApp</th>
                    <th class="py-3">Program Studi / Unit</th>
                    <th class="py-3 text-center">Total Pinjam</th>
                    <th class="pe-4 py-3 text-end" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-4 fw-medium text-muted"><?php echo e($users->firstItem() + $index); ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle <?php echo e($u->role === 'admin' ? 'bg-danger text-white' : ($u->isDosen() ? 'bg-info text-white' : 'bg-primary text-white')); ?> d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 1rem;">
                                    <?php echo e(strtoupper(substr($u->name, 0, 1))); ?>

                                </div>
                                <div>
                                    <div class="fw-bold text-dark"><?php echo e($u->name); ?></div>
                                    <small class="text-muted font-monospace">
                                        <i class="fa-solid fa-id-card me-1"></i><?php echo e($u->identity_number); ?>

                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?php echo e($u->user_type_badge); ?> rounded-pill px-3 py-1">
                                <?php echo e($u->user_type_label); ?>

                            </span>
                        </td>
                        <td>
                            <?php if($u->formatted_phone): ?>
                                <a href="https://wa.me/<?php echo e($u->formatted_phone); ?>" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1">
                                    <i class="fab fa-whatsapp"></i>
                                    <span><?php echo e($u->no_hp); ?></span>
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="text-dark small"><?php echo e($u->department ?? '-'); ?></div>
                            <?php if($u->email): ?>
                                <small class="text-muted"><?php echo e($u->email); ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($u->role === 'peminjam'): ?>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-bold">
                                    <?php echo e($u->reservations_count); ?>x
                                </span>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-inline-flex align-items-center gap-1">
                                <a href="<?php echo e(route('admin.users.edit', $u->id)); ?>" class="btn btn-sm btn-outline-primary rounded-3" title="Edit Pengguna">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <?php if($u->id !== Auth::id()): ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-3" data-bs-toggle="modal" data-bs-target="#deleteUserModal<?php echo e($u->id); ?>" title="Hapus Pengguna">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>

                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="deleteUserModal<?php echo e($u->id); ?>" tabindex="-1" aria-labelledby="deleteUserModalLabel<?php echo e($u->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-4 shadow">
                                                <div class="modal-body p-4 text-center">
                                                    <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3 d-inline-flex mb-3">
                                                        <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                                                    </div>
                                                    <h5 class="fw-bold mb-2">Hapus Pengguna?</h5>
                                                    <p class="text-muted small mb-4">
                                                        Apakah Anda yakin ingin menghapus pengguna <strong><?php echo e($u->name); ?></strong> (<?php echo e($u->identity_number); ?>)? 
                                                        Tindakan ini juga akan menghapus data peminjaman terkait dan tidak dapat dibatalkan.
                                                    </p>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                        <form action="<?php echo e(route('admin.users.destroy', $u->id)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary small py-1 px-2" title="Akun Anda Saat Ini">Akun Anda</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-user-slash fa-3x mb-3 text-secondary opacity-50"></i>
                            <div class="fw-bold">Tidak ada pengguna yang ditemukan</div>
                            <small>Coba gunakan kata kunci pencarian atau filter yang berbeda.</small>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($users->hasPages()): ?>
        <div class="p-3 border-top d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan <?php echo e($users->firstItem()); ?> s/d <?php echo e($users->lastItem()); ?> dari <?php echo e($users->total()); ?> pengguna
            </div>
            <div>
                <?php echo e($users->links()); ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/admin/users/index.blade.php ENDPATH**/ ?>