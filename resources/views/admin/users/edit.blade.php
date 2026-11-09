@extends('layouts.app')

@section('title', 'Edit Data Pengguna')
@section('page_heading', 'Edit Data Pengguna')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card card-custom border-0 shadow-sm p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                <div>
                    <h4 class="fw-bold mb-1">Edit Pengguna: {{ $user->name }}</h4>
                    <p class="text-muted small mb-0">ID Pengguna: <strong>{{ $user->identity_number }}</strong> &bull; Peran: <span class="badge {{ $user->user_type_badge }}">{{ $user->user_type_label }}</span></p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Kategori Pengguna -->
                    <div class="col-12 col-md-6">
                        <label for="user_type" class="form-label small fw-bold text-secondary">Kategori Pengguna <span class="text-danger">*</span></label>
                        <select name="user_type" id="user_type" class="form-select @error('user_type') is-invalid @enderror" required>
                            <option value="mahasiswa" {{ old('user_type', $user->user_type) === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa (Peminjam)</option>
                            <option value="dosen" {{ old('user_type', $user->user_type) === 'dosen' ? 'selected' : '' }}>Dosen (Peminjam)</option>
                            <option value="tendik" {{ old('user_type', $user->user_type) === 'tendik' ? 'selected' : '' }}>Tenaga Kependidikan</option>
                            <option value="admin" {{ old('user_type', $user->user_type) === 'admin' ? 'selected' : '' }}>Administrator Sarpras</option>
                        </select>
                        @error('user_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor Identitas (NIM / NIDN / NIP) -->
                    <div class="col-12 col-md-6">
                        <label for="identity_number" class="form-label small fw-bold text-secondary">NIM / NIDN / Username <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border @error('identity_number') border-danger @enderror"><i class="fa-solid fa-id-card text-muted"></i></span>
                            <input type="text" name="identity_number" id="identity_number" class="form-control @error('identity_number') is-invalid @enderror" value="{{ old('identity_number', $user->identity_number) }}" required>
                        </div>
                        @error('identity_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="col-12">
                        <label for="name" class="form-label small fw-bold text-secondary">Nama Lengkap Pengguna <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border @error('name') border-danger @enderror"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor WhatsApp / HP -->
                    <div class="col-12 col-md-6">
                        <label for="no_hp" class="form-label small fw-bold text-secondary">Nomor WhatsApp / HP Aktif <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border @error('no_hp') border-danger @enderror"><i class="fab fa-whatsapp text-success"></i></span>
                            <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp) }}" required>
                        </div>
                        @error('no_hp')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Email -->
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label small fw-bold text-secondary">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border @error('email') border-danger @enderror"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Program Studi / Departemen -->
                    <div class="col-12">
                        <label for="department" class="form-label small fw-bold text-secondary">Program Studi / Fakultas / Bagian <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border @error('department') border-danger @enderror"><i class="fa-solid fa-building-columns text-muted"></i></span>
                            <input type="text" name="department" id="department" class="form-control @error('department') is-invalid @enderror" value="{{ old('department', $user->department) }}" required>
                        </div>
                        @error('department')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 my-2">
                            <div class="small fw-bold text-secondary mb-1">
                                <i class="fa-solid fa-lock text-warning me-1"></i> Ganti Password (Opsional)
                            </div>
                            <small class="text-muted d-block mb-3">Kosongkan kedua isian di bawah ini jika Anda tidak ingin mereset password pengguna ini.</small>

                            <div class="row g-2">
                                <div class="col-12 col-md-6">
                                    <label class="form-label small text-secondary">Password Baru</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Isi untuk ganti password">
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small text-secondary">Ulangi Password Baru</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
