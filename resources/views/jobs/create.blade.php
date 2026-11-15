@extends('layout.master')

@section('title', 'Tambah Lowongan - Portal Lowongan Kerja')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Lowongan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
    </ol>
</nav>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h4 class="mb-0 fw-bold"><i class="fa-solid fa-briefcase me-2 text-primary"></i>Tambah Lowongan</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
            @include('jobs._form', ['submitLabel' => 'Simpan Lowongan'])
        </form>
    </div>
</div>
@endsection
