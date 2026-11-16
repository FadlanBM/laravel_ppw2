@extends('layout.master')

@section('title', 'Detail Buku: ' . $buku->judul . ' - Praktikum Pemrograman Web 2')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('buku.index') }}" class="text-decoration-none">Data Buku</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $buku->judul }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-dark">
                    <i class="fa-solid fa-book-open me-2 text-primary"></i>Detail Buku
                </h4>
                <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Katalog
                </a>
            </div>
            <div class="card-body p-4">
                <div class="row g-4 align-items-center">
                    <div class="col-md-4 text-center">
                        @if ($buku->cover)
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="img-fluid rounded shadow-sm" style="max-height: 320px; object-fit: cover;">
                        @else
                            <div class="bg-secondary-subtle border rounded d-flex flex-column justify-content-center align-items-center text-muted shadow-sm mx-auto p-4" style="height: 280px; max-width: 220px;">
                                <i class="fa-solid fa-image fa-3x mb-2 text-secondary"></i>
                                <span class="fw-semibold">Tidak Ada Cover</span>
                                <small class="text-muted text-center mt-1">Cover belum diunggah untuk buku ini</small>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h3 class="fw-bold text-dark mb-2">{{ $buku->judul }}</h3>
                        <p class="text-muted mb-4"><i class="fa-solid fa-user-pen me-2"></i>Ditulis oleh <span class="fw-semibold text-dark">{{ $buku->penulis }}</span></p>

                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th style="width: 180px;" class="text-muted ps-0"><i class="fa-solid fa-tag me-2 text-primary"></i>Harga Buku</th>
                                        <td class="fs-5 fw-bold text-success">Rp {{ number_format($buku->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted ps-0"><i class="fa-solid fa-calendar-days me-2 text-primary"></i>Tanggal Terbit</th>
                                        <td>{{ $buku->tgl_terbit->format('d F Y') }} <span class="text-muted small">({{ $buku->tgl_terbit->diffForHumans() }})</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted ps-0"><i class="fa-solid fa-clock me-2 text-primary"></i>Ditambahkan Pada</th>
                                        <td>{{ $buku->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted ps-0"><i class="fa-solid fa-pen-nib me-2 text-primary"></i>Terakhir Diperbarui</th>
                                        <td>{{ $buku->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span class="text-muted small">ID Buku: <code>#{{ $buku->id }}</code></span>
                            @if(Auth::user()->level === 'admin')
                                <div class="d-flex gap-2">
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning text-dark fw-semibold">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Buku
                                    </a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa-solid fa-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
