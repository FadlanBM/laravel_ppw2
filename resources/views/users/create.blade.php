@extends('layout.master')

@section('title', 'Tambah Pengguna - Admin PPW-2')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-user-plus text-primary me-2"></i>Formulir Tambah Pengguna Baru
                    </h5>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong class="d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Terdapat kesalahan pengisian data:</strong>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap pengguna" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="contoh: user@mail.ugm.ac.id" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Kata Sandi (Password) <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>

                    <div class="mb-4">
                        <label for="level" class="form-label fw-bold">Level Hak Akses <span class="text-danger">*</span></label>
                        <select class="form-select @error('level') is-invalid @enderror" id="level" name="level" required>
                            <option value="" disabled {{ old('level') ? '' : 'selected' }}>-- Pilih Level Akses --</option>
                            <option value="user" {{ old('level') === 'user' ? 'selected' : '' }}>User (Pengguna Biasa - Terbatas)</option>
                            <option value="admin" {{ old('level') === 'admin' ? 'selected' : '' }}>Admin (Administrator - Akses Penuh)</option>
                        </select>
                        <div class="form-text">Level Admin dapat mengakses modul data buku dan manajemen user. Level User hanya dapat mengakses modul data buku.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
