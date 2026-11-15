<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    /**
     * Aturan validasi beserta pesan berbahasa Indonesia.
     */
    private function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'location' => 'required|string|max:100',
            'company' => 'required|string|max:100',
            'salary' => 'nullable|numeric|min:0',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    private function messages(): array
    {
        return [
            'title.required' => 'Judul lowongan wajib diisi.',
            'title.max' => 'Judul lowongan maksimal 150 karakter.',
            'description.required' => 'Deskripsi pekerjaan wajib diisi.',
            'location.required' => 'Lokasi kerja wajib diisi.',
            'location.max' => 'Lokasi kerja maksimal 100 karakter.',
            'company.required' => 'Nama perusahaan wajib diisi.',
            'company.max' => 'Nama perusahaan maksimal 100 karakter.',
            'salary.numeric' => 'Gaji harus berupa angka tanpa titik atau koma.',
            'salary.min' => 'Gaji tidak boleh bernilai negatif.',
            'job_type.required' => 'Jenis pekerjaan wajib dipilih.',
            'job_type.in' => 'Jenis pekerjaan tidak dikenali.',
            'logo.image' => 'Berkas logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus JPG, JPEG, atau PNG.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
        ];
    }

    /**
     * Menampilkan daftar lowongan dalam bentuk kartu beserta ringkasan statistik.
     */
    public function index()
    {
        $jobs = JobVacancy::orderBy('created_at', 'desc')->paginate(6);

        $statistik = [
            'total' => JobVacancy::count(),
            'perusahaan' => JobVacancy::distinct('company')->count('company'),
            'full_time' => JobVacancy::where('job_type', 'full-time')->count(),
            'magang' => JobVacancy::where('job_type', 'internship')->count(),
        ];

        return view('jobs.index', compact('jobs', 'statistik'));
    }

    /**
     * Menampilkan form tambah lowongan.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Menyimpan lowongan baru sekaligus memproses unggahan logo perusahaan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        JobVacancy::create($validated);

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan "'.$validated['title'].'" berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu lowongan.
     */
    public function show(string $id)
    {
        $job = JobVacancy::findOrFail($id);

        return view('jobs.show', compact('job'));
    }

    /**
     * Menampilkan form edit lowongan.
     */
    public function edit(string $id)
    {
        $job = JobVacancy::findOrFail($id);

        return view('jobs.edit', compact('job'));
    }

    /**
     * Memperbarui lowongan; logo lama dihapus dari storage bila diganti.
     */
    public function update(Request $request, string $id)
    {
        $job = JobVacancy::findOrFail($id);

        $validated = $request->validate($this->rules(), $this->messages());

        if ($request->hasFile('logo')) {
            if ($job->logo) {
                Storage::disk('public')->delete($job->logo);
            }

            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $job->update($validated);

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan "'.$job->title.'" berhasil diperbarui.');
    }

    /**
     * Menghapus lowongan beserta berkas logo yang tersimpan.
     */
    public function destroy(string $id)
    {
        $job = JobVacancy::findOrFail($id);

        if ($job->logo) {
            Storage::disk('public')->delete($job->logo);
        }

        $judul = $job->title;
        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan "'.$judul.'" berhasil dihapus.');
    }
}
