@extends('layouts.auth')

@section('title', 'Daftar Akun Peminjam - Portal Akademik')

@section('content')
<div class="split-card row g-0">
    <!-- SISI KIRI (Dark Navy Blue Background) -->
    <div class="col-lg-5 split-card-left">
        <div>
            <!-- Badge Atas -->
            <div class="mb-4">
                <span class="portal-badge">
                    <i class="fa-solid fa-graduation-cap text-info"></i>
                    PORTAL AKADEMIK
                </span>
            </div>

            <!-- Logo Kampus & Judul -->
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="campus-logo-box">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h1 class="brand-title">CampusRoom</h1>
            </div>

            <!-- Subtitle -->
            <div class="brand-subtitle mb-3">
                SISTEM INFORMASI PEMINJAMAN RUANGAN KAMPUS
            </div>

            <!-- Deskripsi Singkat -->
            <p class="brand-desc mb-4">
                Pendaftaran akun peminjam sarana & prasarana kampus bagi civitas akademika, ormawa, dan unit kegiatan kampus.
            </p>
        </div>

        <!-- Checklist Fitur Bawah -->
        <div class="feature-checklist">
            <div class="d-flex align-items-center mb-3">
                <div class="check-icon-circle me-3">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-light fw-medium" style="font-size: 0.925rem;">Terintegrasi dengan SIMPT Kampus</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="check-icon-circle me-3">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <span class="text-light fw-medium" style="font-size: 0.925rem;">Akses Keamanan Data Terenkripsi</span>
            </div>
        </div>
    </div>

    <!-- SISI KANAN (White Background) -->
    <div class="col-lg-7 split-card-right">
        <div>
            <!-- Header Kanan -->
            <div class="mb-3">
                <h2 class="h4 fw-bold text-dark mb-1">Daftar Akun Peminjam</h2>
                <p class="text-muted small mb-0">Lengkapi data identitas resmi kampus untuk mengajukan peminjaman ruangan.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3 border-0 shadow-sm">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="name" class="form-label-custom">Nama Lengkap</label>
                    <div class="input-group-custom d-flex align-items-center">
                        <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required autofocus>
                    </div>
                </div>

                <!-- Nomor Identitas & No HP -->
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="identity_number" class="form-label-custom">USERNAME (NIDN / NIM / NIP)</label>
                        <div class="input-group-custom d-flex align-items-center">
                            <span class="input-group-text"><i class="fa-regular fa-id-card"></i></span>
                            <input type="text" name="identity_number" id="identity_number" class="form-control" value="{{ old('identity_number') }}" placeholder="NIDN / NIM / NIP" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="no_hp" class="form-label-custom">NO. HANDPHONE / WA</label>
                        <div class="input-group-custom d-flex align-items-center">
                            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                            <input type="tel" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>
                </div>

                <!-- Program Studi / Ormawa -->
                <div class="mb-3">
                    <label for="department" class="form-label-custom">PROGRAM STUDI / ORMAWA / UNIT</label>
                    <div class="input-group-custom d-flex align-items-center">
                        <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
                        <input type="text" name="department" id="department" class="form-control" value="{{ old('department') }}" placeholder="Contoh: S1 Informatika / BEM Fasilkom" required>
                    </div>
                </div>

                <!-- Email Opsional -->
                <div class="mb-3">
                    <label for="email" class="form-label-custom">EMAIL KAMPUS (OPSIONAL)</label>
                    <div class="input-group-custom d-flex align-items-center">
                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="nama@campusroom.ac.id">
                    </div>
                </div>

                <!-- Password & Konfirmasi -->
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <label for="password" class="form-label-custom">PASSWORD</label>
                        <div class="input-group-custom d-flex align-items-center">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Min. 6 karakter" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="password_confirmation" class="form-label-custom">ULANGI PASSWORD</label>
                        <div class="input-group-custom d-flex align-items-center">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-submit-login w-100 shadow-sm d-flex align-items-center justify-content-center gap-2 mb-3">
                    <span>Daftar Akun Sekarang</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="text-center">
                <span class="text-muted small">Sudah memiliki akun terdaftar?</span>
                <a href="{{ route('login') }}" class="text-primary fw-semibold small text-decoration-none ms-1">Masuk ke Sistem</a>
            </div>
        </div>

        <div class="footer-copyright">
            &copy; {{ date('Y') }} CampusRoom &bull; Sistem Informasi Peminjaman Ruangan Kampus. Hak Cipta Dilindungi.
        </div>
    </div>
</div>
@endsection
