<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary"><i class="fa-solid fa-briefcase me-2"></i>Job Portal</h3>
                    <p class="text-muted">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="card-title fw-bold mb-4">Login</h4>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

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

                        <form method="POST" action="{{ url('/login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password:</label>
                                <input type="password" name="password" id="password" class="form-control" required placeholder="Kata sandi">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <span class="text-muted small">Belum punya akun?</span>
                            <a href="{{ route('register') }}" class="small text-decoration-none fw-semibold">Daftar sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
