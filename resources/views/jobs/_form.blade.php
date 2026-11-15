{{-- Partial form dipakai bersama oleh halaman tambah dan edit lowongan --}}
@csrf

@if ($errors->any())
    <div class="alert alert-danger">
        <p class="fw-bold mb-2"><i class="fa-solid fa-triangle-exclamation me-2"></i>Data belum dapat diproses:</p>
        <ul class="mb-0 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <label for="title" class="form-label fw-semibold">Judul Lowongan</label>
        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $job->title ?? '') }}" placeholder="Contoh: Backend Developer (Laravel)">
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="job_type" class="form-label fw-semibold">Jenis Pekerjaan</label>
        <select id="job_type" name="job_type" class="form-select @error('job_type') is-invalid @enderror">
            @foreach (['full-time' => 'Full-time', 'part-time' => 'Part-time', 'contract' => 'Kontrak', 'internship' => 'Magang'] as $value => $label)
                <option value="{{ $value }}" @selected(old('job_type', $job->job_type ?? 'full-time') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('job_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="company" class="form-label fw-semibold">Nama Perusahaan</label>
        <input type="text" id="company" name="company" class="form-control @error('company') is-invalid @enderror"
               value="{{ old('company', $job->company ?? '') }}" placeholder="Contoh: PT Nusantara Digital">
        @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="location" class="form-label fw-semibold">Lokasi Kerja</label>
        <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror"
               value="{{ old('location', $job->location ?? '') }}" placeholder="Contoh: Yogyakarta">
        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="salary" class="form-label fw-semibold">Gaji (Rp)</label>
        <input type="number" id="salary" name="salary" min="0" step="1000"
               class="form-control @error('salary') is-invalid @enderror"
               value="{{ old('salary', $job->salary ?? '') }}" placeholder="Contoh: 7500000">
        <div class="form-text">Kosongkan bila nominal gaji dirahasiakan.</div>
        @error('salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="logo" class="form-label fw-semibold">Logo Perusahaan</label>
        <input type="file" id="logo" name="logo" accept=".jpg,.jpeg,.png"
               class="form-control @error('logo') is-invalid @enderror">
        <div class="form-text">JPG/PNG, maksimal 2 MB. {{ isset($job) && $job->logo ? 'Biarkan kosong bila logo tidak diganti.' : '' }}</div>
        @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label fw-semibold">Deskripsi Pekerjaan</label>
        <textarea id="description" name="description" rows="5"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Tuliskan tanggung jawab, kualifikasi, dan benefit singkat.">{{ old('description', $job->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    @if (isset($job) && $job->logo)
        <div class="col-12">
            <p class="form-label fw-semibold mb-1">Logo Saat Ini</p>
            <img src="{{ asset('storage/'.$job->logo) }}" alt="Logo {{ $job->company }}"
                 class="rounded border bg-white p-1" style="width:96px;height:96px;object-fit:contain;">
            <p class="text-muted small mb-0 mt-1">Berkas: <code>{{ $job->logo }}</code></p>
        </div>
    @endif
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa-solid fa-floppy-disk me-1"></i> {{ $submitLabel }}
    </button>
    <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>
