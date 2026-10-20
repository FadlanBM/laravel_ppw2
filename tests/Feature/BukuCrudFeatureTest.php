<?php

namespace Tests\Feature;

use App\Models\Buku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BukuCrudFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Database\Seeders\BukuSeeder::class;
        $this->seed(\Database\Seeders\BukuSeeder::class);
    }

    public function test_index_page_displays_books_and_pagination(): void
    {
        $response = $this->get('/buku');
        $response->assertStatus(200);
        $response->assertSee('Data Buku');
        $response->assertSee('Jumlah Buku:');
        $response->assertSee('Rp ');
    }

    public function test_create_page_renders_successfully(): void
    {
        $response = $this->get('/buku/create');
        $response->assertStatus(200);
        $response->assertSee('Tambah Buku');
        $response->assertSee('datepicker');
    }

    public function test_store_validation_errors_in_indonesian(): void
    {
        $response = $this->post('/buku', [
            'judul' => '',
            'penulis' => '',
            'harga' => 'bukan-angka',
            'tgl_terbit' => 'bukan-tanggal'
        ]);

        $response->assertSessionHasErrors([
            'judul' => 'Judul buku wajib diisi.',
            'penulis' => 'Penulis buku wajib diisi.',
            'harga' => 'Harga buku harus berupa angka.',
            'tgl_terbit' => 'Format tanggal terbit tidak valid.'
        ]);
    }

    public function test_store_success_with_flash_message(): void
    {
        $response = $this->post('/buku', [
            'judul' => 'Clean Code Indonesia',
            'penulis' => 'Robert C. Martin',
            'harga' => 150000,
            'tgl_terbit' => '2024-01-15'
        ]);

        $response->assertRedirect('/buku');
        $response->assertSessionHas('pesan', 'Data buku berhasil disimpan');
        $this->assertDatabaseHas('books', ['judul' => 'Clean Code Indonesia']);
    }

    public function test_update_success_with_flash_message(): void
    {
        $buku = Buku::first();
        $response = $this->post("/buku/update/{$buku->id}", [
            'judul' => 'Judul Diperbarui',
            'penulis' => 'Penulis Baru',
            'harga' => 99000,
            'tgl_terbit' => '2023-05-20'
        ]);

        $response->assertRedirect('/buku');
        $response->assertSessionHas('pesan', 'Data buku berhasil diubah');
        $this->assertDatabaseHas('books', ['id' => $buku->id, 'judul' => 'Judul Diperbarui']);
    }

    public function test_destroy_success_with_flash_message(): void
    {
        $buku = Buku::first();
        $response = $this->post("/buku/delete/{$buku->id}");

        $response->assertRedirect('/buku');
        $response->assertSessionHas('pesan', 'Data buku berhasil dihapus');
        $this->assertDatabaseMissing('books', ['id' => $buku->id]);
    }

    public function test_search_feature_finds_matching_books(): void
    {
        $response = $this->get('/buku/search?kata=Andrea');
        $response->assertStatus(200);
        $response->assertSee('Ditemukan');
        $response->assertSee('Andrea Hirata');
    }

    public function test_search_feature_shows_warning_when_not_found(): void
    {
        $response = $this->get('/buku/search?kata=BukuKhayal123456');
        $response->assertStatus(200);
        $response->assertSee('Data Tidak Ditemukan!');
    }
}
