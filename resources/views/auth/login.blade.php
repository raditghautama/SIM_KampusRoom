@extends('layouts.auth')

@section('title', 'Masuk ke Akun - SIKAM')

@section('content')
<div class="split-card row g-0">
    <!-- SISI KIRI (Dark Navy Blue SaaS Branding) -->
    <div class="col-lg-5 split-card-left">
        <div>
            <!-- Badge Atas -->
            <div class="mb-4">
                <span class="portal-badge">
                    <i class="fa-solid fa-building-columns me-1"></i>
                    PORTAL AKADEMIK
                </span>
            </div>

            <!-- Logo Kampus & Judul -->
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="campus-logo-box bg-white bg-opacity-10 p-2 rounded-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-door-open fa-2x text-info"></i>
                </div>
            </div>

            <h1 class="brand-title fw-bold text-white mt-3 mb-1" style="font-size: 1.8rem; letter-spacing: 0.5px;">SIKAM</h1>

            <!-- Subtitle -->
            <div class="brand-subtitle text-uppercase fw-semibold mb-3 text-info" style="font-size: 0.75rem; letter-spacing: 0.5px; opacity: 0.9;">
                SISTEM INFORMASI KAMPUSROOM
            </div>

            <!-- Deskripsi Singkat -->
            <p class="brand-desc mb-4 text-white-50" style="font-size: 0.85rem; line-height: 1.5;">
                Platform cerdas pengelolaan dan peminjaman fasilitas kampus: Auditorium, Ruang Seminar Smart Class, Lab AI, Ruang Rapat, dan Amphitheater secara terintegrasi dan real-time.
            </p>
        </div>

        <!-- Checklist Fitur Bawah -->
        <div class="feature-checklist mt-auto pt-3">
            <div class="d-flex align-items-center mb-2">
                <div class="check-icon-circle me-3 bg-primary bg-opacity-25 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                    <i class="fa-solid fa-bolt" style="font-size: 0.75rem;"></i>
                </div>
                <span class="text-light fw-medium small">Status Ruangan Kosong/Terisi Real-Time</span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="check-icon-circle me-3 bg-primary bg-opacity-25 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                    <i class="fab fa-whatsapp" style="font-size: 0.85rem;"></i>
                </div>
                <span class="text-light fw-medium small">Approval Otomatis & Notifikasi WhatsApp</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="check-icon-circle me-3 bg-primary bg-opacity-25 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                    <i class="fa-solid fa-shield-halved" style="font-size: 0.75rem;"></i>
                </div>
                <span class="text-light fw-medium small">Multi-Role Mahasiswa, Dosen & Admin</span>
            </div>
        </div>
    </div>

    <!-- SISI KANAN (White SaaS Login Form) -->
    <div class="col-lg-7 split-card-right d-flex flex-column justify-content-between p-4 p-md-5 bg-white">
        <div>
            <!-- Header Kanan -->
            <div class="mb-4">
                <h2 class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.01em;">Masuk ke Akun</h2>
                <p class="text-muted small mb-0">Silakan masukkan NIM / NIDN dan kata sandi Anda.</p>
            </div>

            <!-- Flash & Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 px-3 mb-3 border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 px-3 mb-3 border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3 border-0 shadow-sm">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <!-- Form Input 1: USERNAME (NIDN / NIM / Username) -->
                <div class="mb-3">
                    <label for="identity_number" class="form-label text-uppercase fw-bold text-secondary mb-1" style="font-size: 0.75rem;">
                        NOMOR IDENTITAS <span class="text-muted fw-normal">(NIM / NIDN / Username)</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border @error('identity_number') border-danger @enderror"><i class="fa-solid fa-id-card text-muted"></i></span>
                        <input type="text" 
                               name="identity_number" 
                               id="identity_number" 
                               class="form-control bg-light border @error('identity_number') is-invalid @enderror" 
                               value="{{ old('identity_number') }}" 
                               placeholder="Contoh: 2421400096 atau admin01" 
                               required 
                               autofocus>
                    </div>
                </div>

                <!-- Form Input 2: PASSWORD -->
                <div class="mb-3">
                    <label for="password" class="form-label text-uppercase fw-bold text-secondary mb-1" style="font-size: 0.75rem;">
                        PASSWORD
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border @error('password') border-danger @enderror"><i class="fa-solid fa-key text-muted"></i></span>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control bg-light border @error('password') is-invalid @enderror" 
                               placeholder="••••••••" 
                               required>
                        <button class="btn btn-outline-secondary border" type="button" id="togglePasswordBtn" title="Lihat / Sembunyikan Password">
                            <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Lupa Password -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                        <label class="form-check-label small text-secondary" for="rememberMe">
                            Ingat saya di perangkat ini
                        </label>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2 mb-3" style="background: linear-gradient(135deg, #1d4ed8, #2563eb); border: none;">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span class="fw-semibold">Masuk ke Sistem</span>
                </button>
            </form>

            
        </div>

        <!-- Footer Copyright Bawah -->
        <div class="footer-copyright text-center text-muted small mt-4 pt-3 border-top">
            <div class="fw-bold mb-1" style="font-size: 0.75rem;">&copy; {{ date('Y') }} SIKAM</div>
            <div style="font-size: 0.7rem; opacity: 0.75;">Sistem Informasi KampusRoom</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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

    // Helper Isi Otomatis Akun Demo
    function fillCredentials(id, pass) {
        document.getElementById('identity_number').value = id;
        document.getElementById('password').value = pass;
    }
</script>
@endpush
