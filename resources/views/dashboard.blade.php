<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <!-- Navbar Dashboard -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-briefcase me-2"></i>Job Portal Dashboard
            </a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    <i class="fa-solid fa-user-circle me-1"></i> Halo, <strong>{{ Auth::user()->name }}</strong>
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h4 class="mb-0 fw-bold text-dark">Dashboard Pengguna</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                            <div>
                                <strong>You're logged in!</strong> Anda berhasil masuk ke dalam sistem sebagai 
                                @if(Auth::user()->level === 'admin')
                                    <span class="badge bg-danger fs-6">Administrator</span>
                                @else
                                    <span class="badge bg-success fs-6">Pengguna Biasa (User)</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded border mt-3">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-id-card me-2 text-primary"></i>Informasi Akun Terdaftar</h5>
                            <p class="mb-1"><strong>Nama Pengguna:</strong> {{ Auth::user()->name }}</p>
                            <p class="mb-1"><strong>Alamat Email:</strong> {{ Auth::user()->email }}</p>
                            <p class="mb-1">
                                <strong>Level Hak Akses:</strong> 
                                @if(Auth::user()->level === 'admin')
                                    <span class="badge bg-danger">Administrator (Full Access)</span>
                                @else
                                    <span class="badge bg-success">User Biasa (Restricted)</span>
                                @endif
                            </p>
                            <p class="mb-0"><strong>Waktu Bergabung:</strong> {{ Auth::user()->created_at->format('d F Y, H:i') }}</p>
                        </div>

                        {{-- Panel Navigasi Modul Sesuai Hak Akses --}}
                        <div class="mt-4">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-shield-halved me-2 text-primary"></i>Akses Modul Sistem</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border h-100">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-dark"><i class="fa-solid fa-book me-2 text-primary"></i>Modul Data Buku</h6>
                                            <p class="text-muted small">Dapat diakses oleh semua pengguna yang telah terautentikasi (Level: Admin & User).</p>
                                            <a href="{{ route('buku.index') }}" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-arrow-right me-1"></i> Buka Katalog Buku
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border h-100 {{ Auth::user()->level === 'admin' ? 'border-primary' : 'border-danger' }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <h6 class="fw-bold text-dark"><i class="fa-solid fa-users-gear me-2 text-primary"></i>Modul Kelola User</h6>
                                                @if(Auth::user()->level === 'admin')
                                                    <span class="badge bg-success small">Diizinkan</span>
                                                @else
                                                    <span class="badge bg-danger small">Terkunci</span>
                                                @endif
                                            </div>
                                            <p class="text-muted small">
                                                Halaman dilindungi middleware <code>admin</code>. 
                                                @if(Auth::user()->level === 'admin')
                                                    Anda memiliki akses penuh untuk menambah, mengedit, dan menghapus user.
                                                @else
                                                    Akses ditolak untuk akun level User biasa.
                                                @endif
                                            </p>
                                            @if(Auth::user()->level === 'admin')
                                                <a href="{{ route('users.index') }}" class="btn btn-danger btn-sm">
                                                    <i class="fa-solid fa-users-gear me-1"></i> Kelola Data User
                                                </a>
                                            @else
                                                <a href="{{ route('users.index') }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Peringatan: Level Anda adalah User biasa. Akses ke modul ini akan diblokir oleh Middleware Admin dengan HTTP 403. Lanjutkan percobaan akses?')">
                                                    <i class="fa-solid fa-lock me-1"></i> Coba Akses (Uji 403)
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
