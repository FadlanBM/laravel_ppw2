@extends('books.layout')
@section('title', 'Books | Katalog Buku')
@section('canonical', route('books.catalog'))
@section('content')
<div class="eyebrow mb-3">Koleksi Pilihan / Katalog Buku</div><div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3"><div><h1 class="page-title">Cerita baru, setiap halaman.</h1><p class="muted">Temukan buku, kenali penulis, dan jelajahi galeri di balik setiap judul.</p></div><span class="badge bg-success p-3">{{ $books->total() }} buku</span></div>
<div class="row g-4">@forelse($books as $book)<div class="col-sm-6 col-lg-3"><article class="book-card h-100">@if($book->foto)<img class="cover" src="{{ asset('storage/'.$book->foto) }}" alt="Sampul {{ $book->judul }}">@else<div class="empty-cover">Belum ada sampul</div>@endif<div class="p-3"><p class="eyebrow">{{ $book->penulis }}</p><h2 class="h5">{{ $book->judul }}</h2><p class="muted small">Rp {{ number_format($book->harga,0,',','.') }} / {{ $book->tgl_terbit->format('Y') }}</p><a class="btn btn-primary w-100" href="{{ route('galeri.buku', $book->buku_seo) }}">Lihat buku & galeri</a></div></article></div>@empty<p>Belum ada buku.</p>@endforelse</div><div class="mt-4">{{ $books->links() }}</div>
@endsection
