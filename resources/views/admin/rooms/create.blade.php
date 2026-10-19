@extends('layouts.app')

@section('title', 'Tambah Ruangan')
@section('page_heading', 'Tambah Ruangan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Formulir Tambah Ruangan</h5>
                    <p class="text-muted small mb-0">Isi detail ruangan kampus yang dapat dipinjam oleh sivitas akademika.</p>
                </div>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-8">
                        <label for="name" class="form-label small fw-semibold text-secondary">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Auditorium Utama Rektorat" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="code" class="form-label small fw-semibold text-secondary">Kode Ruangan <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="Contoh: AUD-01" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="building" class="form-label small fw-semibold text-secondary">Gedung / Lokasi <span class="text-danger">*</span></label>
                        <input type="text" name="building" id="building" class="form-control @error('building') is-invalid @enderror" value="{{ old('building') }}" placeholder="Contoh: Gedung Rektorat Lt. 3" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="capacity" class="form-label small fw-semibold text-secondary">Kapasitas (Orang) <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" id="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', 50) }}" min="1" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="status" class="form-label small fw-semibold text-secondary">Status Operasional <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="facilities" class="form-label small fw-semibold text-secondary">Fasilitas Ruangan</label>
                    <textarea name="facilities" id="facilities" class="form-control @error('facilities') is-invalid @enderror" rows="2" placeholder="Contoh: Proyektor Laser, Sound System, AC 4 Unit, Mic Wireless, WiFi High Speed, Podium (Pisahkan dengan koma)">{{ old('facilities') }}</textarea>
                    <small class="text-muted">Pisahkan setiap fasilitas dengan tanda koma.</small>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label small fw-semibold text-secondary">Deskripsi & Catatan Penggunaan</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Jelaskan peraturan atau spesifikasi detail ruangan...">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label small fw-semibold text-secondary">Foto Ruangan (Maks. 3MB)</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, atau WEBP. Jika dikosongkan, gambar default akan digunakan.</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
