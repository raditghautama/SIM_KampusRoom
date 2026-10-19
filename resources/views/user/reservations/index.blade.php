@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya')
@section('page_heading', 'Riwayat Peminjaman Ruangan')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark">Status & Riwayat Peminjaman Saya</h4>
        <p class="text-muted small mb-0">Pantau perkembangan status pengajuan peminjaman ruangan kampus Anda.</p>
    </div>
    <div>
        <a href="{{ route('peminjam.reservations.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Ajukan Peminjaman Baru
        </a>
    </div>
</div>

<!-- TABS FILTER STATUS -->
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('peminjam.reservations.index') }}" class="btn {{ empty($status) ? 'btn-primary' : 'btn-light border' }} btn-sm rounded-pill px-3 py-2 fw-semibold">
        Semua Pengajuan
    </a>
    <a href="{{ route('peminjam.reservations.index', ['status' => 'pending']) }}" class="btn {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-light border' }} btn-sm rounded-pill px-3 py-2 fw-semibold">
        <i class="fa-solid fa-hourglass-half me-1"></i> Menunggu (Pending)
    </a>
    <a href="{{ route('peminjam.reservations.index', ['status' => 'approved']) }}" class="btn {{ $status === 'approved' ? 'btn-success text-white' : 'btn-light border' }} btn-sm rounded-pill px-3 py-2 fw-semibold">
        <i class="fa-solid fa-check me-1"></i> Disetujui
    </a>
    <a href="{{ route('peminjam.reservations.index', ['status' => 'rejected']) }}" class="btn {{ $status === 'rejected' ? 'btn-danger text-white' : 'btn-light border' }} btn-sm rounded-pill px-3 py-2 fw-semibold">
        <i class="fa-solid fa-xmark me-1"></i> Ditolak
    </a>
</div>

<!-- CARD LIST / TABEL ADAPTIF (100% RESPONSIVE) -->
<div class="row g-3">
    @forelse($reservations as $res)
        <div class="col-12">
            <div class="card card-custom p-3 p-md-4 card-hover">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <!-- Detail Ruangan & Waktu -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-primary-subtle text-primary rounded-4 p-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 54px; height: 54px;">
                            <i class="fa-solid fa-door-open fa-lg"></i>
                        </div>
                        <div>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                <span class="badge bg-light text-primary border fw-bold">{{ $res->room->code }}</span>
                                <h5 class="fw-bold text-dark mb-0">{{ $res->room->name }}</h5>
                                <span class="badge rounded-pill {{ $res->status_badge }} px-3 py-1 ms-sm-2">
                                    {{ $res->status_label }}
                                </span>
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $res->room->building }}
                            </div>
                            
                            <div class="d-flex flex-wrap gap-3 text-secondary small">
                                <div>
                                    <i class="fa-regular fa-calendar text-primary me-1"></i>
                                    <strong>{{ $res->formatted_date }}</strong>
                                </div>
                                <div>
                                    <i class="fa-regular fa-clock text-primary me-1"></i>
                                    <strong>{{ $res->formatted_time }}</strong>
                                </div>
                                @if($res->proposal_file)
                                    <div>
                                        <a href="{{ asset('storage/' . $res->proposal_file) }}" target="_blank" class="text-decoration-none text-primary">
                                            <i class="fa-solid fa-file-pdf me-1"></i> Berkas Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-2 text-dark small bg-light p-2 rounded-3" style="max-width: 600px;">
                                <strong>Keperluan:</strong> {{ $res->purpose }}
                            </div>

                            @if($res->admin_notes)
                                <div class="mt-2 text-muted small border-start border-3 border-info ps-2" style="font-size: 0.8rem;">
                                    <strong>Catatan Sarpras:</strong> {{ $res->admin_notes }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Side -->
                    <div class="text-md-end pt-2 pt-md-0 border-top border-md-0">
                        @if($res->status === 'pending')
                            <form action="{{ route('peminjam.reservations.cancel', $res->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permohonan peminjaman ini?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                    <i class="fa-solid fa-ban me-1"></i> Batalkan Pengajuan
                                </button>
                            </form>
                        @elseif($res->status === 'approved')
                            <span class="text-success small fw-semibold d-block">
                                <i class="fa-solid fa-circle-check me-1"></i> Siap Digunakan
                            </span>
                            <small class="text-muted" style="font-size: 0.72rem;">Harap datang tepat waktu</small>
                        @elseif($res->status === 'rejected')
                            <span class="text-danger small fw-semibold d-block">
                                <i class="fa-solid fa-circle-xmark me-1"></i> Ditolak Sarpras
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card card-custom p-5 text-center">
                <i class="fa-solid fa-clock-rotate-left fa-3x text-muted opacity-50 mb-3"></i>
                <h5 class="fw-bold text-dark">Belum ada riwayat peminjaman</h5>
                <p class="text-muted small">Anda belum pernah mengajukan peminjaman ruangan atau filter status saat ini kosong.</p>
                <div>
                    <a href="{{ route('peminjam.reservations.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> Ajukan Peminjaman Sekarang
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- PAGINASI -->
@if($reservations->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $reservations->links() }}
    </div>
@endif
@endsection
