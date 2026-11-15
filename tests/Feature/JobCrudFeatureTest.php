<?php

namespace Tests\Feature;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JobCrudFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['level' => 'admin']);
    }

    /**
     * Berkas PNG asli dipakai agar aturan validasi "image" ikut teruji
     * tanpa bergantung pada ekstensi GD di mesin pengujian.
     */
    private function logoUpload(string $nama = 'logo.png'): UploadedFile
    {
        return UploadedFile::fake()->createWithContent(
            $nama,
            file_get_contents(base_path('tests/Fixtures/logo.png'))
        );
    }

    public function test_admin_can_open_index_and_see_statistics(): void
    {
        JobVacancy::create([
            'title' => 'Backend Developer',
            'description' => 'Mengembangkan API.',
            'location' => 'Yogyakarta',
            'company' => 'PT Uji Coba',
            'salary' => 8000000,
            'job_type' => 'full-time',
        ]);

        $response = $this->actingAs($this->admin())->get('/jobs');

        $response->assertStatus(200);
        $response->assertSee('Daftar Lowongan Kerja');
        $response->assertSee('Total Lowongan');
        $response->assertSee('Backend Developer');
        $response->assertSee('Rp 8.000.000');
    }

    public function test_store_requires_mandatory_fields(): void
    {
        $response = $this->actingAs($this->admin())->post('/jobs', [
            'title' => '',
            'description' => '',
            'location' => '',
            'company' => '',
            'job_type' => 'tidak-valid',
            'logo' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors(['title', 'description', 'location', 'company', 'job_type', 'logo']);
        $this->assertSame(0, JobVacancy::count());
    }

    public function test_admin_can_store_vacancy_with_logo_upload(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin())->post('/jobs', [
            'title' => 'UI/UX Designer',
            'description' => 'Merancang antarmuka produk.',
            'location' => 'Bandung',
            'company' => 'CV Kreasi',
            'salary' => 7000000,
            'job_type' => 'contract',
            'logo' => $this->logoUpload(),
        ]);

        $response->assertRedirect(route('jobs.index'));

        $job = JobVacancy::firstOrFail();
        $this->assertSame('UI/UX Designer', $job->title);
        $this->assertNotNull($job->logo);
        Storage::disk('public')->assertExists($job->logo);
    }

    public function test_admin_can_update_vacancy_and_replace_logo(): void
    {
        Storage::fake('public');

        $logoLama = $this->logoUpload('lama.png')->store('logos', 'public');
        $job = JobVacancy::create([
            'title' => 'Data Analyst',
            'description' => 'Menyusun laporan.',
            'location' => 'Jakarta',
            'company' => 'Tokoloka',
            'salary' => 9000000,
            'job_type' => 'full-time',
            'logo' => $logoLama,
        ]);

        $response = $this->actingAs($this->admin())->put('/jobs/'.$job->id, [
            'title' => 'Senior Data Analyst',
            'description' => 'Menyusun laporan dan dasbor.',
            'location' => 'Jakarta',
            'company' => 'Tokoloka',
            'salary' => 11000000,
            'job_type' => 'part-time',
            'logo' => $this->logoUpload('baru.png'),
        ]);

        $response->assertRedirect(route('jobs.index'));

        $job->refresh();
        $this->assertSame('Senior Data Analyst', $job->title);
        $this->assertSame(11000000, $job->salary);
        $this->assertSame('part-time', $job->job_type);
        $this->assertNotSame($logoLama, $job->logo);
        Storage::disk('public')->assertMissing($logoLama);
        Storage::disk('public')->assertExists($job->logo);
    }

    public function test_admin_can_delete_vacancy_and_its_logo(): void
    {
        Storage::fake('public');

        $logo = $this->logoUpload('hapus.png')->store('logos', 'public');
        $job = JobVacancy::create([
            'title' => 'Staff Administrasi',
            'description' => 'Mengelola arsip.',
            'location' => 'Semarang',
            'company' => 'PT Sinergi',
            'job_type' => 'internship',
            'logo' => $logo,
        ]);

        $response = $this->actingAs($this->admin())->delete('/jobs/'.$job->id);

        $response->assertRedirect(route('jobs.index'));
        $this->assertSame(0, JobVacancy::count());
        Storage::disk('public')->assertMissing($logo);
    }

    public function test_regular_user_cannot_access_jobs_module(): void
    {
        $user = User::factory()->create(['level' => 'user']);

        $this->actingAs($user)->get('/jobs')->assertStatus(403);
        $this->actingAs($user)->post('/jobs', [])->assertStatus(403);
    }
}
