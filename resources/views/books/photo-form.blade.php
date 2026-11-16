@extends('books.layout')
@section('title',($photo->exists?'Edit':'Tambah').' Foto | Books')
@section('content')
<div class="eyebrow mb-3">Kelola Galeri</div><h1 class="page-title mb-4">{{ $photo->exists?'Edit':'Tambah' }} Foto Buku</h1>
<div class="book-card p-4 mx-auto" style="max-width:850px">@if($errors->any())<div class="alert alert-danger" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form action="{{ $photo->exists?route('gallery.update',$photo):route('gallery.store') }}" method="post" enctype="multipart/form-data">@csrf @if($photo->exists) @method('PUT') @endif
<div class="mb-3"><label class="form-label" for="buku_id">Buku terkait</label><select class="form-select" name="buku_id" id="buku_id"><option value="">Pilih buku</option>@foreach($books as $book)<option value="{{ $book->id }}" @selected(old('buku_id',$photo->buku_id)==$book->id)>{{ $book->judul }}</option>@endforeach</select></div>
<div class="mb-3"><label for="title" class="form-label">Judul foto</label><input class="form-control" id="title" name="title" value="{{ old('title',$photo->title) }}"></div>
<div class="mb-3"><label for="description" class="form-label">Deskripsi</label><textarea class="form-control" rows="3" id="description" name="description">{{ old('description',$photo->description) }}</textarea></div>
<div class="mb-3"><label for="picture" class="form-label">Gambar JPG / PNG (maksimal 1999 KB)</label><input class="form-control" type="file" id="picture" name="picture" accept=".jpg,.jpeg,.png">@if($photo->exists)<p class="small muted mt-2">Kosongkan jika tidak mengganti gambar.</p><img style="height:150px" src="{{ asset('storage/'.$photo->picture) }}" alt="Foto saat ini">@endif</div>
<button class="btn btn-primary" type="submit">{{ $photo->exists?'Perbarui Foto':'Simpan Foto' }}</button><a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary">Batal</a></form></div>
@endsection
