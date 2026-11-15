<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Perpustakaan - Praktikum Web 2')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- Font Awesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-layer-group me-2"></i>PPW-2 Sistem Manajemen
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto">
                    @auth
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-gauge me-1"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                            <i class="fa-solid fa-book me-1"></i> Data Buku
                        </a>
                        {{-- Proteksi Menu Navbar: Hanya level Admin yang dapat melihat menu Data Pengguna --}}
                        @if(Auth::check() && Auth::user()->level === 'admin')
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <i class="fa-solid fa-users-gear me-1"></i> Data Pengguna
                            </a>
                            <a class="nav-link {{ request()->routeIs('jobs.*') ? 'active' : '' }}" href="{{ route('jobs.index') }}">
                                <i class="fa-solid fa-briefcase me-1"></i> Lowongan
                            </a>
                        @endif
                    @endauth
                </div>
                <div class="navbar-nav ms-auto align-items-center">
                    @auth
                        <span class="navbar-text text-white me-3">
                            <i class="fa-solid fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            @if(Auth::user()->level === 'admin')
                                <span class="badge bg-danger ms-1">Admin</span>
                            @else
                                <span class="badge bg-success ms-1">User</span>
                            @endif
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                            </button>
                        </form>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        @yield('content')
    </div>

    <!-- Scripts: jQuery, Bootstrap 5 Bundle, Bootstrap Datepicker -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
</body>
</html>
