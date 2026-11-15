@extends('layout.master')

@section('title', 'Daftar Lowongan - Portal Lowongan Kerja')

@section('content')
<div class="row mb-3 align-items-center">
    <div class="col-md-7">
        <h2 class="fw-bold text-dark m-0">Daftar Lowongan Kerja</h2>
        <p class="text-muted mb-0">Kelola lowongan yang tampil pada portal beserta logo perusahaan.</p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <a href="{{ route('jobs.create') }}" class="btn btn-success shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Tambah Lowongan
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted small mb-1">Total Lowongan</p>
                <h3 class="fw-bold mb-0">{{ $statistik['total'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted small mb-1">Perusahaan Terdaftar</p>
                <h3 class="fw-bold mb-0">{{ $statistik['perusahaan'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted small mb-1">Full-time</p>
                <h3 class="fw-bold mb-0">{{ $statistik['full_time'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted small mb-1">Program Magang</p>
                <h3 class="fw-bold mb-0">{{ $statistik['magang'] }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
    @forelse ($jobs as $job)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-start mb-3">
                        @if ($job->logo)
                            <img src="{{ asset('storage/'.$job->logo) }}" alt="Logo {{ $job->company }}"
                                 class="rounded border bg-white me-3" style="width:64px;height:64px;object-fit:contain;">
                        @else
                            <div class="rounded border bg-light d-flex align-items-center justify-content-center me-3"
                                 style="width:64px;height:64px;">
                                <i class="fa-solid fa-building text-secondary fs-4"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1">{{ $job->title }}</h5>
                            <p class="text-muted small mb-1">
                                <i class="fa-solid fa-building-columns me-1"></i>{{ $job->company }}
                            </p>
                            <span class="badge {{ $job->job_type_badge }}">{{ $job->job_type_label }}</span>
                        </div>
                    </div>

                    <p class="text-secondary small flex-grow-1">{{ Str::limit($job->description, 110) }}</p>

                    <ul class="list-unstyled small text-muted mb-3">
                        <li class="mb-1"><i class="fa-solid fa-location-dot me-2"></i>{{ $job->location }}</li>
                        <li><i class="fa-solid fa-money-bill-wave me-2"></i>
                            {{ $job->salary_formatted ?? 'Gaji tidak dicantumkan' }}
                        </li>
                    </ul>

                    <div class="d-flex gap-2">
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-warning text-dark">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="ms-auto"
                              onsubmit="return confirm('Hapus lowongan {{ $job->title }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5 text-muted">
                    <i class="fa-regular fa-folder-open fs-1 mb-3 d-block"></i>
                    Belum ada lowongan yang tersimpan. Mulai dengan menekan tombol Tambah Lowongan.
                </div>
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
    <div>
        <strong>Total data:</strong> <span class="badge bg-secondary fs-6">{{ $jobs->total() }}</span>
    </div>
    <div>{{ $jobs->links() }}</div>
</div>
@endsection
