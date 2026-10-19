@extends('layouts.app')

@section('title', 'Katalog Ruangan Kampus')
@section('page_heading', 'Katalog Ruangan & Fasilitas')

@section('content')
<!-- HERO SECTION DENGAN SEARCH BAR -->
<div class="card border-0 rounded-4 text-white p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
    <div class="row align-items-center">
        <div class="col-12 col-lg-8">
            <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 mb-2 font-monospace small">
                <i class="fa-solid fa-sparkles me-1"></i> Sistem Peminjaman Online
            </span>
            <h2 class="fw-bold mb-2">Temukan & Pinjam Ruangan Kampus untuk Kegiatanmu</h2>
            <p class="text-white-50 mb-4 small fs-6">
                Pilih ruangan sesuai kebutuhan seminar, workshop, rapat organisasi, praktikum lab, atau pentas seni tanpa ribet.
            </p>

            <!-- FORM PENCARIAN & FILTER -->
            <form action="{{ route('peminjam.room-catalog') }}" method="GET" class="row g-2 bg-white p-2 rounded-4 shadow">
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-control border-0" placeholder="Cari nama ruangan, gedung, atau fasilitas..." value="{{ $search }}">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select name="building" class="form-select border-0 bg-light rounded-3">
                        <option value="">Semua Lokasi / Gedung</option>
                        @foreach($buildings as $b)
                            <option value="{{ $b }}" {{ $building === $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="capacity" class="form-select border-0 bg-light rounded-3">
                        <option value="">Kapasitas</option>
                        <option value="30" {{ $capacity == 30 ? 'selected' : '' }}>&ge; 30 Orang</option>
                        <option value="50" {{ $capacity == 50 ? 'selected' : '' }}>&ge; 50 Orang</option>
                        <option value="100" {{ $capacity == 100 ? 'selected' : '' }}>&ge; 100 Orang</option>
                        <option value="200" {{ $capacity == 200 ? 'selected' : '' }}>&ge; 200 Orang</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
                        Cari Ruang
                    </button>
                </div>
            </form>
        </div>
        <div class="col-12 col-lg-4 d-none d-lg-block text-end">
            <i class="fa-solid fa-hotel fa-8x text-white opacity-25"></i>
        </div>
    </div>
</div>

<!-- GRID DAFTAR RUANGAN (100% RESPONSIVE: 1 KOLOM DI HP, 2 DI TABLET, 3 DI DESKTOP) -->
<div class="row g-4">
    @forelse($rooms as $room)
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card card-custom h-100 card-hover overflow-hidden d-flex flex-column">
                <!-- Thumbnail & Badges -->
                <div class="position-relative" style="height: 200px;">
                    <img src="{{ $room->image_url }}" alt="{{ $room->name }}" class="w-100 h-100 object-fit-cover">
                    
                    <!-- Status Badge -->
                    <div class="position-absolute top-0 start-0 m-3">
                        @if($room->status === 'available')
                            <span class="badge bg-success bg-opacity-90 rounded-pill px-3 py-2 shadow-sm">
                                <i class="fa-solid fa-circle-check me-1"></i> Tersedia
                            </span>
                        @else
                            <span class="badge bg-danger bg-opacity-90 rounded-pill px-3 py-2 shadow-sm">
                                <i class="fa-solid fa-wrench me-1"></i> Pemeliharaan
                            </span>
                        @endif
                    </div>

                    <!-- Kapasitas Badge -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2 shadow-sm text-white">
                            <i class="fa-solid fa-users me-1"></i> {{ $room->capacity }} Orang
                        </span>
                    </div>

                    <!-- Kode Ruangan Pill -->
                    <div class="position-absolute bottom-0 start-0 m-3">
                        <span class="badge bg-white text-dark rounded-pill px-3 py-1 shadow-sm fw-bold">
                            {{ $room->code }}
                        </span>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="card-body p-3 p-md-4 d-flex flex-column flex-grow-1">
                    <div class="text-muted small mb-1">
                        <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $room->building }}
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $room->name }}</h5>
                    <p class="text-secondary small mb-3 text-truncate-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $room->description ?: 'Ruangan representatif untuk kegiatan sivitas akademika kampus.' }}
                    </p>

                    <!-- Fasilitas Tags -->
                    <div class="mt-auto">
                        <div class="small fw-semibold text-muted mb-2">Fasilitas Utama:</div>
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @forelse(array_slice($room->facilities_list, 0, 3) as $fac)
                                <span class="badge bg-light text-secondary border rounded-pill px-2 py-1 small">
                                    <i class="fa-solid fa-check text-primary me-1"></i>{{ $fac }}
                                </span>
                            @empty
                                <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small">Standar Kampus</span>
                            @endforelse

                            @if(count($room->facilities_list) > 3)
                                <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small">
                                    +{{ count($room->facilities_list) - 3 }} lainnya
                                </span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 d-sm-flex">
                            <a href="{{ route('peminjam.rooms.show', $room->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 flex-grow-1">
                                <i class="fa-regular fa-calendar-days me-1"></i> Cek Jadwal
                            </a>
                            @if($room->status === 'available')
                                <a href="{{ route('peminjam.reservations.create', ['room_id' => $room->id]) }}" class="btn btn-primary btn-sm rounded-pill px-3 py-2 flex-grow-1 shadow-sm">
                                    <i class="fa-solid fa-paper-plane me-1"></i> Pinjam Ruang
                                </a>
                            @else
                                <button class="btn btn-secondary btn-sm rounded-pill px-3 py-2 flex-grow-1" disabled>
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card card-custom p-5 text-center">
                <i class="fa-solid fa-magnifying-glass fa-3x text-muted opacity-50 mb-3"></i>
                <h5 class="fw-bold text-dark">Tidak ada ruangan yang cocok</h5>
                <p class="text-muted small">Coba ubah kata kunci pencarian atau reset filter untuk melihat semua ruangan.</p>
                <div>
                    <a href="{{ route('peminjam.room-catalog') }}" class="btn btn-outline-primary rounded-pill px-4">
                        Lihat Semua Ruangan
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- PAGINASI -->
@if($rooms->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $rooms->links() }}
    </div>
@endif
@endsection
