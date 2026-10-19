@extends('layouts.app')

@section('title', 'Manajemen Ruangan')
@section('page_heading', 'Daftar Ruangan Kampus')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark">Data Master Ruangan</h4>
        <p class="text-muted small mb-0">Kelola informasi ruangan, kapasitas, fasilitas, dan status operasional.</p>
    </div>
    <div>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Tambah Ruangan
        </a>
    </div>
</div>

<!-- FILTER & SEARCH BAR -->
<div class="card card-custom p-3 mb-4">
    <form action="{{ route('admin.rooms.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-12 col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, kode, atau fasilitas..." value="{{ $search }}">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="available" {{ $status === 'available' ? 'selected' : '' }}>Tersedia</option>
                <option value="maintenance" {{ $status === 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <button type="submit" class="btn btn-primary w-100 rounded-3">
                <i class="fa-solid fa-filter me-1"></i> Filter
            </button>
        </div>
        @if($search || $status)
            <div class="col-12 col-md-2">
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary w-100 rounded-3">Reset</a>
            </div>
        @endif
    </form>
</div>

<!-- TABEL / CARD DAFTAR RUANGAN (RESPONSIF MOBILE-FRIENDLY) -->
<div class="card card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th class="ps-3 ps-md-4">Ruangan & Lokasi</th>
                        <th>Kode</th>
                        <th>Kapasitas</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th class="text-end pe-3 ps-md-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td class="ps-3 ps-md-4">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $room->image_url }}" alt="{{ $room->name }}" class="rounded-3 object-fit-cover shadow-sm" style="width: 54px; height: 54px;">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $room->name }}</div>
                                        <small class="text-muted"><i class="fa-solid fa-location-dot me-1 text-danger"></i>{{ $room->building }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border fw-semibold">{{ $room->code }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark"><i class="fa-solid fa-users text-secondary me-1"></i>{{ $room->capacity }}</span>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Orang</small>
                            </td>
                            <td style="max-width: 250px;">
                                <div class="text-truncate small text-secondary" title="{{ $room->facilities }}">
                                    {{ $room->facilities ?: 'Tidak ada keterangan fasilitas.' }}
                                </div>
                            </td>
                            <td>
                                @if($room->status === 'available')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                        <i class="fa-solid fa-circle-check me-1"></i> Tersedia
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Maintenance
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-3 ps-md-4">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-light btn-sm text-primary border rounded-pill px-3" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger border rounded-pill px-3" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-door-closed fa-3x mb-2 d-block opacity-50"></i>
                                Tidak ada data ruangan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($rooms->hasPages())
        <div class="card-footer bg-transparent py-3 px-4 border-0">
            {{ $rooms->links() }}
        </div>
    @endif
</div>
@endsection
