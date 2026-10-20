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
                                <strong>You're logged in!</strong> Anda berhasil masuk ke dalam sistem Job Portal.
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded border mt-3">
                            <h5 class="fw-bold mb-3">Informasi Akun Terdaftar</h5>
                            <p class="mb-1"><strong>Nama Pengguna:</strong> {{ Auth::user()->name }}</p>
                            <p class="mb-1"><strong>Alamat Email:</strong> {{ Auth::user()->email }}</p>
                            <p class="mb-0"><strong>Waktu Bergabung:</strong> {{ Auth::user()->created_at->format('d F Y, H:i') }}</p>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="{{ route('buku.index') }}" class="btn btn-secondary me-2">
                                <i class="fa-solid fa-book me-1"></i> Kelola Data Buku
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">
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
