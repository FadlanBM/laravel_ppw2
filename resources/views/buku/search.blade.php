@extends('layout.master')

@section('title', 'Hasil Pencarian Buku - Praktikum Pemrograman Web 2')

@section('content')
<div class="row mb-3 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark m-0">Hasil Pencarian Buku</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Semua Buku
        </a>
    </div>
</div>

{{-- Search Box --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('buku.search') }}" method="GET" class="row g-2 justify-content-end">
            <div class="col-md-5">
                <div class="input-group">
                    <input type="text" name="kata" class="form-control" placeholder="Cari judul atau penulis..." value="{{ $cari }}" required>
                    <button class="btn btn-primary" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari Ulang
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Status Pencarian (Tugas 3) --}}
@if (count($data_buku) > 0)
    <div class="alert alert-success shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-info me-2"></i>Ditemukan <strong>{{ $jumlah_buku }}</strong> data buku dengan kata kunci: "<strong>{{ $cari }}</strong>"
    </div>

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 60px;" class="text-center">No</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Tgl. Terbit</th>
                            <th scope="col" style="width: 160px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_buku as $buku)
                            <tr>
                                <td class="text-center">{{ ++$no }}</td>
                                <td class="fw-semibold">{{ $buku->judul }}</td>
                                <td>{{ $buku->penulis }}</td>
                                <td>Rp {{ number_format($buku->harga, 0, ',', '.') }}</td>
                                <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning text-dark me-1" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination Pencarian --}}
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <div>
            <strong>Jumlah Ditemukan:</strong> <span class="badge bg-primary fs-6">{{ $jumlah_buku }}</span>
        </div>
        <div>
            {{ $data_buku->appends(['kata' => $cari])->links() }}
        </div>
    </div>
@else
    <div class="alert alert-warning text-center shadow-sm py-4 mb-4" role="alert">
        <h4 class="alert-heading fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i>Data Tidak Ditemukan!</h4>
        <p class="mb-3">Tidak ditemukan buku dengan kata kunci: "<strong>{{ $cari }}</strong>". Silakan coba kata kunci lain.</p>
        <a href="{{ route('buku.index') }}" class="btn btn-warning text-dark fw-semibold">
            <i class="fa-solid fa-rotate-left me-1"></i> Kembali ke Daftar Buku
        </a>
    </div>
@endif
@endsection
