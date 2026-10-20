<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Aplikasi - Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container text-center">
        <div class="card shadow-sm p-4 mx-auto" style="max-width: 600px;">
            <h1 class="fw-bold text-primary mb-3">Tentang Aplikasi Job Portal</h1>
            <p class="text-muted fs-5">Aplikasi ini akan membantu pengguna mencari dan melamar pekerjaan.</p>
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary">Daftar Akun</a>
            </div>
        </div>
    </div>
</body>
</html>
