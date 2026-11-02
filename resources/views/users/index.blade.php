@extends('layout.master')

@section('title', 'Manajemen Pengguna - Admin PPW-2')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="fa-solid fa-users-gear text-primary me-2"></i>Daftar Pengguna Sistem
                </h3>
                <p class="text-muted mb-0">Halaman ini dilindungi oleh middleware <code>admin</code>. Hanya pengguna dengan level Administrator yang memiliki hak akses.</p>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i> Tambah Pengguna Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th>Nama Lengkap</th>
                                <th>Alamat Email</th>
                                <th class="text-center" style="width: 140px;">Level Akses</th>
                                <th>Tanggal Dibuat</th>
                                <th class="text-center" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $u)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $users->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $u->name }}</div>
                                        @if($u->id === Auth::id())
                                            <span class="badge bg-info text-dark" style="font-size: 10px;">Akun Anda</span>
                                        @endif
                                    </td>
                                    <td>{{ $u->email }}</td>
                                    <td class="text-center">
                                        @if($u->level === 'admin')
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="fa-solid fa-shield me-1"></i> Admin
                                            </span>
                                        @else
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fa-solid fa-user me-1"></i> User
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $u->created_at ? $u->created_at->format('d/m/Y H:i') : '-' }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Pengguna">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @if($u->id !== Auth::id())
                                                <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $u->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Pengguna">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary" disabled title="Tidak dapat menghapus akun aktif sendiri">
                                                    <i class="fa-solid fa-ban"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-users-slash fs-3 d-block mb-2"></i> Belum ada data pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
                <div class="card-footer bg-white py-3">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
