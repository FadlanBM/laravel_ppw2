<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Books | Katalog & Galeri')</title>
<meta name="description" content="@yield('description', 'Jelajahi katalog buku dan galeri foto melalui Books.')">
@hasSection('canonical')<link rel="canonical" href="@yield('canonical')">@endif
<link href="/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="/dist/css/lightbox.min.css" rel="stylesheet">
<style>body{background:#f5f2eb;color:#173f37;font-family:system-ui,sans-serif}.brand{font-family:Georgia,serif;font-size:1.9rem;font-weight:bold}.navbar{background:#173f37}.eyebrow{letter-spacing:.16em;font-size:.75rem;font-weight:bold;text-transform:uppercase;color:#977545}.page-title{font-family:Georgia,serif;font-size:3.3rem}.book-card{border:0;background:#fffdf9;border-radius:14px;overflow:hidden;box-shadow:0 8px 22px #183c3510}.cover{height:245px;width:100%;object-fit:contain;padding:20px;background:#e8e5dc}.gallery-image{height:240px;width:100%;object-fit:cover}.btn-primary{background:#23594d;border-color:#23594d}.btn-primary:hover{background:#173f37;border-color:#173f37}.form-label{font-weight:600}.muted{color:#6b7772}.empty-cover{height:245px;display:grid;place-items:center;background:#e8e5dc;color:#6a756f}footer{border-top:1px solid #d9dfd6}</style>
</head><body>
<nav class="navbar navbar-dark py-3"><div class="container d-flex gap-3 flex-wrap"><a class="navbar-brand brand" href="{{ route('books.catalog') }}">Books<span style="color:#d8b77b">.</span></a><div class="d-flex gap-3 align-items-center"><a class="text-white text-decoration-none" href="{{ route('books.catalog') }}">Katalog</a><a class="text-white text-decoration-none" href="{{ route('gallery.index') }}">Galeri</a>@auth<a class="text-white" href="{{ route('buku.index') }}">Kelola Buku</a><form action="{{ route('logout') }}" method="post">@csrf<button class="btn btn-outline-light btn-sm">Logout</button></form>@else<a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Login Pengelola</a>@endauth</div></div></nav>
<main class="container py-5">@if(session('success'))<div class="alert alert-success" role="alert">{{ session('success') }}</div>@endif @yield('content')</main>
<footer class="container py-4 mt-4 muted small">Books / Praktikum Pemrograman Web 2 / Fadlan Buwono Mukti</footer>
<script src="/dist/js/lightbox-plus-jquery.min.js"></script><script>lightbox.option({resizeDuration:150,wrapAround:true,albumLabel:'Gambar %1 dari %2'});</script>
</body></html>
