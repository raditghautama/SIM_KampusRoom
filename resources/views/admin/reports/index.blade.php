@extends('layouts.app')

@section('title', 'Laporan Peminjaman Ruangan')
@section('page_heading', 'Laporan Rekapitulasi Peminjaman')

@section('content')
<!-- FILTER CARD -->
<div class="card card-custom border-0 p-4 shadow-sm mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3 pb-3 border-bottom">
        <div>
            <h5 class="fw-bold mb-1"><i class="fa-solid fa-filter me-2 text-primary"></i>Filter Laporan Peminjaman</h5>
            <small class="text-muted">Pilih rentang tanggal, ruangan, dan status peminjaman untuk merekap data</small>
        </div>
        <div class="d-flex gap-2">
            <!-- Tombol Export PDF -->
            <a href="{{ route('admin.reports.pdf', request()->query()) }}" class="btn btn-danger rounded-pill px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Export PDF</span>
            </a>
            <!-- Tombol Cetak / Print -->
            <a href="{{ route('admin.reports.print', request()->query()) }}" target="_blank" class="btn btn-secondary rounded-pill px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Laporan</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3">
        <div class="col-12 col-md-3">
            <label class="form-label small fw-bold text-secondary">Dari Tanggal</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label small fw-bold text-secondary">Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label small fw-bold text-secondary">Filter Ruangan</label>
            <select name="room_id" class="form-select">
                <option value="">Semua Ruangan</option>
                @foreach($rooms as $r)
                    <option value="{{ $r->id }}" {{ $roomId == $r->id ? 'selected' : '' }}>{{ $r->name }} ({{ $r->code }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label small fw-bold text-secondary">Filter Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
            </select>
        </div>

        <div class="col-12 text-end pt-2">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-light rounded-pill px-3 me-2">Reset</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Terapkan Filter
            </button>
        </div>
    </form>
</div>

<!-- RINGKASAN REKAP -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm text-center">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem;">Total Rekap</small>
            <h3 class="fw-bold text-dark my-1">{{ $summary['total'] }}</h3>
            <span class="text-secondary small">Data Terfilter</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm text-center border-start border-success border-4">
            <small class="text-success fw-bold text-uppercase" style="font-size: 0.72rem;">Disetujui</small>
            <h3 class="fw-bold text-success my-1">{{ $summary['approved'] }}</h3>
            <span class="text-secondary small">Peminjaman Selesai/Aktif</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm text-center border-start border-warning border-4">
            <small class="text-warning-emphasis fw-bold text-uppercase" style="font-size: 0.72rem;">Menunggu (Pending)</small>
            <h3 class="fw-bold text-warning my-1">{{ $summary['pending'] }}</h3>
            <span class="text-secondary small">Belum Diproses</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom border-0 p-3 shadow-sm text-center border-start border-danger border-4">
            <small class="text-danger fw-bold text-uppercase" style="font-size: 0.72rem;">Ditolak</small>
            <h3 class="fw-bold text-danger my-1">{{ $summary['rejected'] }}</h3>
            <span class="text-secondary small">Tidak Disetujui</span>
        </div>
    </div>
</div>

<!-- TABEL LAPORAN -->
<div class="card card-custom border-0 shadow-sm overflow-hidden">
    <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 text-dark">
            <i class="fa-solid fa-list-check me-2 text-primary"></i>
            Daftar Data Peminjaman (Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }})
        </h6>
        <span class="badge bg-light text-dark border">{{ $reservations->count() }} Data</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase fw-bold">
                <tr>
                    <th class="ps-4 py-3" style="width: 50px;">No</th>
                    <th class="py-3">Tanggal & Waktu</th>
                    <th class="py-3">Ruangan</th>
                    <th class="py-3">Peminjam</th>
                    <th class="py-3">Keperluan Kegiatan</th>
                    <th class="py-3">Status</th>
                    <th class="pe-4 py-3 text-end">Disetujui Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $index => $res)
                    <tr>
                        <td class="ps-4 fw-medium text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $res->formatted_date }}</div>
                            <small class="text-muted"><i class="fa-regular fa-clock me-1"></i>{{ $res->formatted_time }}</small>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $res->room->name }}</div>
                            <small class="text-muted"><i class="fa-solid fa-location-dot me-1 text-danger"></i>{{ $res->room->building }}</small>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $res->user->name }}</div>
                            <small class="text-muted font-monospace">{{ $res->user->identity_number }} ({{ $res->user->user_type_label }})</small>
                        </td>
                        <td>
                            <div class="text-dark small text-truncate" style="max-width: 250px;" title="{{ $res->purpose }}">
                                {{ $res->purpose }}
                            </div>
                            @if($res->admin_notes)
                                <small class="text-secondary d-block fst-italic">Catatan: {{ $res->admin_notes }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $res->status_badge }} rounded-pill px-3 py-1">
                                {{ $res->status_label }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <span class="text-muted small">{{ $res->approver ? $res->approver->name : '-' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary opacity-50"></i>
                            <div class="fw-bold">Tidak ada data peminjaman dalam rentang tanggal ini</div>
                            <small>Silakan ubah rentang tanggal atau filter lainnya di atas.</small>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
