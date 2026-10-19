@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page_heading', 'Dashboard Sarpras')

@section('content')
<div class="row g-3 mb-4">
    <!-- Stat 1: Total Ruangan -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 card-hover h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Ruangan</span>
                    <h2 class="fw-bold mb-0 text-dark mt-1">{{ $stats['total_rooms'] }}</h2>
                    <small class="text-success fw-semibold"><i class="fa-solid fa-circle-check me-1"></i>{{ $stats['available_rooms'] }} Siap Dipakai</small>
                </div>
                <div class="stat-icon-box bg-primary-subtle text-primary">
                    <i class="fa-solid fa-door-open"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2: Peminjaman Pending -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 card-hover h-100 border-warning-subtle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Menunggu Approval</span>
                    <h2 class="fw-bold mb-0 text-warning-emphasis mt-1">{{ $stats['pending_reservations'] }}</h2>
                    <small class="text-muted">Perlu ditinjau Sarpras</small>
                </div>
                <div class="stat-icon-box bg-warning-subtle text-warning">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3: Peminjaman Disetujui -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 card-hover h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Disetujui Aktif</span>
                    <h2 class="fw-bold mb-0 text-success mt-1">{{ $stats['approved_reservations'] }}</h2>
                    <small class="text-muted">Total agenda valid</small>
                </div>
                <div class="stat-icon-box bg-success-subtle text-success">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4: Hari Ini -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 card-hover h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Agenda Hari Ini</span>
                    <h2 class="fw-bold mb-0 text-info mt-1">{{ $stats['today_reservations'] }}</h2>
                    <small class="text-muted">{{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}</small>
                </div>
                <div class="stat-icon-box bg-info-subtle text-info">
                    <i class="fa-solid fa-bell"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Kolom Kiri: Peminjaman Terbaru & Quick Actions -->
    <div class="col-12 col-xl-8">
        <div class="card card-custom mb-4">
            <div class="card-header bg-transparent border-0 pt-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">Permohonan Peminjaman Terbaru</h6>
                    <small class="text-muted">Daftar mahasiswa/ormawa yang mengajukan izin ruangan</small>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="card-body p-0">
                <!-- Tabel Responsif yang Rapi di HP dan Laptop -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small">
                            <tr>
                                <th class="ps-3 ps-md-4">Peminjam</th>
                                <th>Ruangan</th>
                                <th>Waktu & Tanggal</th>
                                <th>Status</th>
                                <th class="text-end pe-3 pe-md-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReservations as $res)
                                <tr>
                                    <td class="ps-3 ps-md-4">
                                        <div class="fw-semibold text-dark">{{ $res->user->name }}</div>
                                        <small class="text-muted">{{ $res->user->identifier }} &bull; {{ $res->user->department }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $res->room->code }}</span>
                                        <div class="small fw-semibold mt-1">{{ $res->room->name }}</div>
                                    </td>
                                    <td>
                                        <div class="small fw-semibold"><i class="fa-regular fa-calendar me-1 text-primary"></i>{{ $res->formatted_date }}</div>
                                        <div class="small text-muted"><i class="fa-regular fa-clock me-1"></i>{{ $res->formatted_time }}</div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill {{ $res->status_badge }} px-2 py-1">
                                            {{ $res->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3 pe-md-4">
                                        @if($res->status === 'pending')
                                            <div class="btn-group btn-group-sm">
                                                <form action="{{ route('admin.reservations.approve', $res->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm rounded-start-pill" onclick="return confirm('Setujui peminjaman ini?')">
                                                        <i class="fa-solid fa-check me-1"></i> Setujui
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-outline-danger btn-sm rounded-end-pill" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $res->id }}">
                                                    <i class="fa-solid fa-xmark"></i> Tolak
                                                </button>
                                            </div>
                                        @else
                                            @if($res->whatsapp_url)
                                                <a href="{{ $res->whatsapp_url }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill" title="Kirim WA ke Peminjam">
                                                    <i class="fab fa-whatsapp"></i> WA
                                                </a>
                                            @endif
                                        @endif

                                        <!-- Modal Tolak -->
                                        <div class="modal fade" id="rejectModal{{ $res->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content rounded-4 border-0">
                                                    <form action="{{ route('admin.reservations.reject', $res->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h6 class="modal-title fw-bold">Alasan Penolakan</h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <p class="small text-muted mb-2">Peminjaman oleh <strong>{{ $res->user->name }}</strong> untuk ruangan <strong>{{ $res->room->name }}</strong>.</p>
                                                            <label class="form-label small fw-semibold">Catatan / Alasan Penolakan:</label>
                                                            <textarea name="admin_notes" class="form-control rounded-3" rows="3" required placeholder="Contoh: Ruangan bentrok dengan agenda rektorat / Dokumen izin tidak lengkap"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger rounded-pill px-4">Tolak Peminjaman</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                        Belum ada permohonan peminjaman ruangan yang tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Jadwal Hari Ini & Akses Cepat -->
    <div class="col-12 col-xl-4">
        <!-- Quick Action Card -->
        <div class="card card-custom mb-4 bg-primary text-white border-0 p-3 p-md-4 shadow-sm" style="background: linear-gradient(135deg, #1e40af, #2563eb) !important;">
            <h6 class="fw-bold mb-2"><i class="fa-solid fa-bolt me-2"></i>Aksi Cepat Admin</h6>
            <p class="small text-white-50 mb-3">Kelola sarana prasarana dan verifikasi surat permohonan peminjaman dengan efisien.</p>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.rooms.create') }}" class="btn btn-light text-primary fw-semibold rounded-pill py-2 shadow-sm text-start ps-3">
                    <i class="fa-solid fa-plus-circle me-2"></i> Tambah Ruangan Baru
                </a>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-light fw-semibold rounded-pill py-2 text-start ps-3">
                    <i class="fa-solid fa-file-pdf me-2"></i> Cetak Laporan Peminjaman
                </a>
            </div>
        </div>

        <!-- Jadwal Hari Ini -->
        <div class="card card-custom">
            <div class="card-header bg-transparent border-0 pt-3 px-3 px-md-4">
                <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-calendar-day me-2 text-primary"></i>Agenda Ruangan Hari Ini</h6>
                <small class="text-muted">{{ count($todaySchedules) }} ruangan terpakai hari ini</small>
            </div>
            <div class="card-body p-3 px-md-4">
                @forelse($todaySchedules as $sch)
                    <div class="border-start border-primary border-3 ps-3 mb-3 py-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 0.72rem;">{{ $sch->formatted_time }}</span>
                            <span class="small text-muted">{{ $sch->room->code }}</span>
                        </div>
                        <h6 class="fw-bold mb-1 mt-1 text-dark">{{ $sch->room->name }}</h6>
                        <p class="small text-muted mb-1 text-truncate">{{ $sch->purpose }}</p>
                        <small class="text-secondary"><i class="fa-regular fa-user me-1"></i>{{ $sch->user->name }} ({{ $sch->user->department }})</small>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fa-regular fa-calendar-check fa-2x mb-2 d-block opacity-50"></i>
                        Tidak ada pemakaian ruangan hari ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
