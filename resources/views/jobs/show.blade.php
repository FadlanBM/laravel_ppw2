@extends('layout.master')

@section('title', $job->title.' - Portal Lowongan Kerja')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Lowongan</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $job->title }}</li>
    </ol>
</nav>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex align-items-start flex-wrap gap-3">
            @if ($job->logo)
                <img src="{{ asset('storage/'.$job->logo) }}" alt="Logo {{ $job->company }}"
                     class="rounded border bg-white p-1" style="width:104px;height:104px;object-fit:contain;">
            @else
                <div class="rounded border bg-light d-flex align-items-center justify-content-center"
                     style="width:104px;height:104px;">
                    <i class="fa-solid fa-building text-secondary fs-1"></i>
                </div>
            @endif

            <div class="flex-grow-1">
                <h3 class="fw-bold mb-1">{{ $job->title }}</h3>
                <p class="text-muted mb-2"><i class="fa-solid fa-building-columns me-1"></i>{{ $job->company }}</p>
                <span class="badge {{ $job->job_type_badge }}">{{ $job->job_type_label }}</span>
                <span class="badge bg-secondary"><i class="fa-solid fa-location-dot me-1"></i>{{ $job->location }}</span>
                <span class="badge bg-dark">{{ $job->salary_formatted ?? 'Gaji dirahasiakan' }}</span>
            </div>
        </div>

        <hr class="my-4">

        <h5 class="fw-bold">Deskripsi Pekerjaan</h5>
        <p class="text-secondary" style="white-space: pre-line;">{{ $job->description }}</p>

        <ul class="list-unstyled small text-muted mt-4 mb-0">
            <li>Dibuat: {{ $job->created_at->format('d/m/Y H:i') }}</li>
            <li>Terakhir diperbarui: {{ $job->updated_at->format('d/m/Y H:i') }}</li>
        </ul>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning text-dark">
                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
            </a>
            <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
@endsection
