<?php $__env->startSection('title', 'Approval Peminjaman'); ?>
<?php $__env->startSection('page_heading', 'Manajemen Persetujuan Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark">Daftar Pengajuan Peminjaman Ruangan</h4>
        <p class="text-muted small mb-0">Tinjau proposal, validasi bentrok jadwal, setujui/tolak permohonan, dan kirim notifikasi WhatsApp.</p>
    </div>
</div>

<!-- FILTER & SEARCH -->
<div class="card card-custom p-3 mb-4">
    <form action="<?php echo e(route('admin.reservations.index')); ?>" method="GET" class="row g-2 align-items-center">
        <div class="col-12 col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama peminjam, NIM, atau ruangan..." value="<?php echo e($search); ?>">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending" <?php echo e($status === 'pending' ? 'selected' : ''); ?>>Menunggu Konfirmasi (Pending)</option>
                <option value="approved" <?php echo e($status === 'approved' ? 'selected' : ''); ?>>Disetujui (Approved)</option>
                <option value="rejected" <?php echo e($status === 'rejected' ? 'selected' : ''); ?>>Ditolak (Rejected)</option>
                <option value="cancelled" <?php echo e($status === 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
            </select>
        </div>
        <div class="col-6 col-md-3">
            <input type="date" name="date" class="form-control" value="<?php echo e($date); ?>">
        </div>
        <div class="col-12 col-md-2">
            <button type="submit" class="btn btn-primary w-100 rounded-3">
                <i class="fa-solid fa-filter me-1"></i> Saring Data
            </button>
        </div>
    </form>
</div>

<!-- DAFTAR PENGAJUAN (TABLE RESPONSIVE DENGAN ADAPTASI MOBILE) -->
<div class="card card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th class="ps-3 ps-md-4">Peminjam</th>
                        <th>Ruangan Kampus</th>
                        <th>Jadwal Peminjaman</th>
                        <th>Keperluan & Berkas</th>
                        <th>Status</th>
                        <th class="text-end pe-3 pe-md-4">Aksi Sarpras</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-3 ps-md-4">
                                <div class="fw-bold text-dark"><?php echo e($res->user->name); ?></div>
                                <div class="small text-muted"><?php echo e($res->user->identifier); ?> &bull; <?php echo e($res->user->department); ?></div>
                                <?php if($res->user->phone): ?>
                                    <div class="small mt-1">
                                        <a href="https://wa.me/<?php echo e($res->user->formatted_phone); ?>" target="_blank" class="text-success text-decoration-none fw-semibold">
                                            <i class="fab fa-whatsapp me-1"></i><?php echo e($res->user->phone); ?>

                                        </a>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border fw-semibold"><?php echo e($res->room->code); ?></span>
                                <div class="fw-semibold text-dark small mt-1"><?php echo e($res->room->name); ?></div>
                                <small class="text-muted"><i class="fa-solid fa-location-dot me-1 text-danger"></i><?php echo e($res->room->building); ?></small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark small"><i class="fa-regular fa-calendar text-primary me-1"></i><?php echo e($res->formatted_date); ?></div>
                                <div class="small text-muted"><i class="fa-regular fa-clock text-secondary me-1"></i><?php echo e($res->formatted_time); ?></div>
                            </td>
                            <td style="max-width: 260px;">
                                <div class="small text-secondary mb-1" style="white-space: normal;">
                                    <strong>Agenda:</strong> <?php echo e($res->purpose); ?>

                                </div>
                                <?php if($res->proposal_file): ?>
                                    <a href="<?php echo e(asset('storage/' . $res->proposal_file)); ?>" target="_blank" class="btn btn-light btn-sm border rounded-pill px-2 py-0 text-primary small">
                                        <i class="fa-solid fa-paperclip me-1"></i> Lihat Surat/Proposal
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted" style="font-size: 0.75rem;">Tanpa lampiran file</span>
                                <?php endif; ?>

                                <?php if($res->admin_notes): ?>
                                    <div class="mt-1 p-1 px-2 bg-light rounded text-muted" style="font-size: 0.75rem;">
                                        <strong>Catatan Admin:</strong> <?php echo e($res->admin_notes); ?>

                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge rounded-pill <?php echo e($res->status_badge); ?> px-3 py-1">
                                    <?php echo e($res->status_label); ?>

                                </span>
                            </td>
                            <td class="text-end pe-3 pe-md-4">
                                <div class="d-inline-flex flex-column flex-sm-row gap-1 align-items-end">
                                    <?php if($res->status === 'pending'): ?>
                                        <!-- Tombol Setujui -->
                                        <form action="<?php echo e(route('admin.reservations.approve', $res->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" onclick="return confirm('Apakah Anda yakin ingin MENYETUJUI peminjaman ini?')">
                                                <i class="fa-solid fa-check me-1"></i> Setujui
                                            </button>
                                        </form>

                                        <!-- Tombol Tolak (Modal Trigger) -->
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#rejectResModal<?php echo e($res->id); ?>">
                                            <i class="fa-solid fa-xmark me-1"></i> Tolak
                                        </button>
                                    <?php endif; ?>

                                    <!-- Tombol WhatsApp Interaktif Manual -->
                                    <?php if($res->whatsapp_url): ?>
                                        <a href="<?php echo e($res->whatsapp_url); ?>" target="_blank" class="btn btn-wa btn-sm rounded-pill px-3 shadow-sm" title="Hubungi Pemohon via WhatsApp">
                                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <!-- Modal Penolakan -->
                                <div class="modal fade" id="rejectResModal<?php echo e($res->id); ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form action="<?php echo e(route('admin.reservations.reject', $res->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="modal-header border-bottom">
                                                    <h6 class="modal-title fw-bold text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i>Konfirmasi Penolakan Peminjaman</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <div class="bg-light p-3 rounded-3 mb-3 small">
                                                        <div><strong>Peminjam:</strong> <?php echo e($res->user->name); ?> (<?php echo e($res->user->identifier); ?>)</div>
                                                        <div><strong>Ruangan:</strong> <?php echo e($res->room->name); ?></div>
                                                        <div><strong>Tanggal:</strong> <?php echo e($res->formatted_date); ?> (<?php echo e($res->formatted_time); ?>)</div>
                                                    </div>
                                                    <label class="form-label small fw-semibold text-secondary">Alasan Penolakan <span class="text-danger">*</span></label>
                                                    <textarea name="admin_notes" class="form-control rounded-3" rows="3" required placeholder="Tuliskan alasan spesifik (misal: Ruangan sedang direnovasi / Bentrok kegiatan pimpinan)..."></textarea>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger rounded-pill px-4">Tolak Peminjaman</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-calendar-xmark fa-3x mb-2 d-block opacity-50"></i>
                                Tidak ada data permohonan peminjaman yang cocok dengan filter.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($reservations->hasPages()): ?>
        <div class="card-footer bg-transparent py-3 px-4 border-0">
            <?php echo e($reservations->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\campusroom\resources\views/admin/reservations/index.blade.php ENDPATH**/ ?>