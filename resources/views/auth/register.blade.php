<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Register - Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary"><i class="fa-solid fa-briefcase me-2"></i>Job Portal</h3>
                    <p class="text-muted">Buat akun baru untuk memulai pencarian pekerjaan</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="card-title fw-bold mb-4">Form Register</h4>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="Nama Lengkap">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="Alamat Email">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password:</label>
                                <input type="password" name="password" id="password" class="form-control" required placeholder="Kata Sandi (min. 6 karakter)">
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password:</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Ulangi Kata Sandi">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="fa-solid fa-user-plus me-1"></i> Daftar
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <span class="text-muted small">Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="small text-decoration-none fw-semibold">Login di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
