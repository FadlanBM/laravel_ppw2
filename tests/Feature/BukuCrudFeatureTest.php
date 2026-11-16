<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\User;
use Database\Seeders\BukuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BukuCrudFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();
        BukuSeeder::class;
        $this->seed(BukuSeeder::class);

        $this->adminUser = User::factory()->admin()->create();
        $this->regularUser = User::factory()->create(['level' => 'user']);
    }

    private function fakeCoverUpload(string $nama = 'cover.png'): UploadedFile
    {
        return UploadedFile::fake()->createWithContent(
            $nama,
            file_get_contents(base_path('tests/Fixtures/logo.png'))
        );
    }

    public function test_index_page_displays_books_for_admin_and_regular_user(): void
    {
        // Admin dapat melihat tombol tambah buku, detail, edit, dan hapus
        $responseAdmin = $this->actingAs($this->adminUser)->get('/buku');
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('Data Buku');
        $responseAdmin->assertSee('Tambah Buku');
        $responseAdmin->assertSee('Detail');
        $responseAdmin->assertSee('Edit');
        $responseAdmin->assertSee('Hapus');

        // User biasa dapat melihat katalog buku dan tombol detail, namun tanpa tombol tambah, edit, dan hapus
        $responseUser = $this->actingAs($this->regularUser)->get('/buku');
        $responseUser->assertStatus(200);
        $responseUser->assertSee('Data Buku');
        $responseUser->assertSee('Detail');
        $responseUser->assertDontSee('Tambah Buku');
        $responseUser->assertDontSee('Edit');
        $responseUser->assertDontSee('Hapus');
    }

    public function test_show_page_displays_book_detail_for_both_admin_and_user(): void
    {
        $buku = Buku::first();

        // Pengguna biasa dapat melihat detail buku tanpa tombol edit/hapus
        $responseUser = $this->actingAs($this->regularUser)->get("/buku/{$buku->id}");
        $responseUser->assertStatus(200);
        $responseUser->assertSee('Detail Buku');
        $responseUser->assertSee($buku->judul);
        $responseUser->assertSee($buku->penulis);
        $responseUser->assertSee('Rp '.number_format($buku->harga, 0, ',', '.'));
        $responseUser->assertSee('Kembali ke Katalog');
        $responseUser->assertDontSee('Edit Buku');

        // Admin dapat melihat detail buku lengkap dengan tombol edit & hapus
        $responseAdmin = $this->actingAs($this->adminUser)->get("/buku/{$buku->id}");
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('Detail Buku');
        $responseAdmin->assertSee('Edit Buku');
        $responseAdmin->assertSee('Hapus');
    }

    public function test_show_page_returns_404_when_book_not_found(): void
    {
        $response = $this->actingAs($this->regularUser)->get('/buku/999999');
        $response->assertNotFound();
    }

    public function test_regular_user_cannot_access_create_form_and_gets_forbidden(): void
    {
        $response = $this->actingAs($this->regularUser)->get('/buku/create');
        $response->assertForbidden();
    }

    public function test_regular_user_cannot_store_book_and_gets_forbidden(): void
    {
        $response = $this->actingAs($this->regularUser)->post('/buku', [
            'judul' => 'Buku Ilegal User',
            'penulis' => 'User Biasa',
            'harga' => 50000,
            'tgl_terbit' => '2024-01-01',
        ]);
        $response->assertForbidden();
    }

    public function test_regular_user_cannot_access_edit_form_and_gets_forbidden(): void
    {
        $buku = Buku::first();
        $response = $this->actingAs($this->regularUser)->get("/buku/edit/{$buku->id}");
        $response->assertForbidden();
    }

    public function test_regular_user_cannot_update_book_and_gets_forbidden(): void
    {
        $buku = Buku::first();
        $response = $this->actingAs($this->regularUser)->post("/buku/update/{$buku->id}", [
            'judul' => 'Judul Dicoba Ubah',
            'penulis' => 'User Biasa',
            'harga' => 60000,
            'tgl_terbit' => '2024-01-01',
        ]);
        $response->assertForbidden();
    }

    public function test_regular_user_cannot_delete_book_and_gets_forbidden(): void
    {
        $buku = Buku::first();
        $response = $this->actingAs($this->regularUser)->post("/buku/delete/{$buku->id}");
        $response->assertForbidden();
    }

    public function test_admin_create_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/buku/create');
        $response->assertStatus(200);
        $response->assertSee('Tambah Buku');
        $response->assertSee('datepicker');
        $response->assertSee('Cover Buku');
    }

    public function test_admin_store_validation_errors_in_indonesian(): void
    {
        $response = $this->actingAs($this->adminUser)->post('/buku', [
            'judul' => '',
            'penulis' => '',
            'harga' => 'bukan-angka',
            'tgl_terbit' => 'bukan-tanggal',
            'cover' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors([
            'judul' => 'Judul buku wajib diisi.',
            'penulis' => 'Penulis buku wajib diisi.',
            'harga' => 'Harga buku harus berupa angka.',
            'tgl_terbit' => 'Format tanggal terbit tidak valid.',
            'cover' => 'Berkas cover harus berupa gambar.',
        ]);
    }

    public function test_admin_store_success_with_cover_upload(): void
    {
        Storage::fake('public');

        $cover = $this->fakeCoverUpload('sampul.png');

        $response = $this->actingAs($this->adminUser)->post('/buku', [
            'judul' => 'Clean Code Indonesia',
            'penulis' => 'Robert C. Martin',
            'harga' => 150000,
            'tgl_terbit' => '2024-01-15',
            'cover' => $cover,
        ]);

        $response->assertRedirect('/buku');
        $response->assertSessionHas('pesan', 'Data buku berhasil disimpan');

        $buku = Buku::where('judul', 'Clean Code Indonesia')->firstOrFail();
        $this->assertNotNull($buku->cover);
        Storage::disk('public')->assertExists($buku->cover);
    }

    public function test_admin_update_success_with_new_cover_deleting_old_cover(): void
    {
        Storage::fake('public');

        $coverLama = $this->fakeCoverUpload('lama.png');
        $pathLama = $coverLama->store('covers', 'public');

        $buku = Buku::first();
        $buku->cover = $pathLama;
        $buku->save();

        Storage::disk('public')->assertExists($pathLama);

        $coverBaru = $this->fakeCoverUpload('baru.png');

        $response = $this->actingAs($this->adminUser)->post("/buku/update/{$buku->id}", [
            'judul' => 'Judul Diperbarui',
            'penulis' => 'Penulis Baru',
            'harga' => 99000,
            'tgl_terbit' => '2023-05-20',
            'cover' => $coverBaru,
        ]);

        $response->assertRedirect('/buku');
        $response->assertSessionHas('pesan', 'Data buku berhasil diubah');

        $buku->refresh();
        $this->assertNotSame($pathLama, $buku->cover);
        Storage::disk('public')->assertMissing($pathLama);
        Storage::disk('public')->assertExists($buku->cover);
    }

    public function test_admin_destroy_success_and_deletes_cover_file(): void
    {
        Storage::fake('public');

        $cover = $this->fakeCoverUpload('hapus.png');
        $path = $cover->store('covers', 'public');

        $buku = Buku::first();
        $buku->cover = $path;
        $buku->save();

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($this->adminUser)->post("/buku/delete/{$buku->id}");

        $response->assertRedirect('/buku');
        $response->assertSessionHas('pesan', 'Data buku berhasil dihapus');
        $this->assertDatabaseMissing('books', ['id' => $buku->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_search_feature_finds_matching_books(): void
    {
        $response = $this->actingAs($this->regularUser)->get('/buku/search?kata=Andrea');
        $response->assertStatus(200);
        $response->assertSee('Ditemukan');
        $response->assertSee('Andrea Hirata');
    }

    public function test_search_feature_shows_warning_when_not_found(): void
    {
        $response = $this->actingAs($this->regularUser)->get('/buku/search?kata=BukuKhayal123456');
        $response->assertStatus(200);
        $response->assertSee('Data Tidak Ditemukan!');
    }
}
