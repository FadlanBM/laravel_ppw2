@extends('layout.master')

@section('title', 'Data Buku - Praktikum Pemrograman Web 2')

@section('content')
<div class="row mb-3 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark m-0">Data Buku</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('buku.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Tambah Buku
        </a>
    </div>
</div>

{{-- Flash Message (Latihan 3 & Tugas 1) --}}
@if (Session::has('pesan'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ Session::get('pesan') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Search Box (Tugas 3) --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('buku.search') }}" method="GET" class="row g-2 justify-content-end">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="kata" class="form-control" placeholder="Cari judul atau penulis..." required>
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Buku --}}
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
                    @forelse ($data_buku as $buku)
                        <tr>
                            <td class="text-center">{{ ++$no }}</td>
                            <td class="fw-semibold">{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                            {{-- Format Rupiah dengan number_format (Latihan 1) --}}
                            <td>Rp {{ number_format($buku->harga, 0, ',', '.') }}</td>
                            {{-- Format Tanggal Indonesia d/m/Y via Carbon (Latihan 1) --}}
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
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination & Counter (Latihan 5) --}}
<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
    <div>
        <strong>Jumlah Buku:</strong> <span class="badge bg-secondary fs-6">{{ $jumlah_buku }}</span>
    </div>
    <div>
        {{ $data_buku->links() }}
    </div>
</div>
@endsection
