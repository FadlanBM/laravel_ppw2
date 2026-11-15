@extends('layout.master')

@section('title', 'Edit Lowongan - Portal Lowongan Kerja')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Lowongan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h4 class="mb-0 fw-bold"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Edit Lowongan</h4>
        <p class="text-muted small mb-0 mt-1">Mengubah data lowongan <code>#{{ $job->id }}</code> milik {{ $job->company }}.</p>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('jobs._form', ['submitLabel' => 'Perbarui Lowongan'])
        </form>
    </div>
</div>
@endsection
