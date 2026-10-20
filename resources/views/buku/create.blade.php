@extends('layout.master')

@section('title', 'Tambah Buku - Praktikum Pemrograman Web 2')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0 fw-bold"><i class="fa-solid fa-plus-circle me-2"></i>Tambah Buku</h4>
            </div>
            <div class="card-body p-4">
                {{-- Pesan Validasi Error (Latihan 4 & Tugas 2) --}}
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <div class="fw-bold mb-2"><i class="fa-solid fa-triangle-exclamation me-2"></i>Terjadi kesalahan pengisian form:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('buku.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Buku</label>
                        <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Masukkan judul buku">
                    </div>

                    <div class="mb-3">
                        <label for="penulis" class="form-label fw-semibold">Penulis</label>
                        <input type="text" name="penulis" id="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis') }}" placeholder="Masukkan nama penulis (maks. 30 karakter)">
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label fw-semibold">Harga (Rp)</label>
                        <input type="text" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" placeholder="Contoh: 85000">
                    </div>

                    {{-- Penerapan Datepicker (Latihan 2) --}}
                    <div class="mb-4">
                        <label for="tgl_terbit" class="form-label fw-semibold">Tanggal Terbit</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                            <input type="text" name="tgl_terbit" id="tgl_terbit" class="form-control datepicker @error('tgl_terbit') is-invalid @enderror" value="{{ old('tgl_terbit') }}" placeholder="Pilih tanggal (yyyy-mm-dd)" autocomplete="off">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Buku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
