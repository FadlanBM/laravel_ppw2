<?php

namespace Tests\Feature;

use App\Models\Buku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksGalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_upload_replace_delete_and_book_relation(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $admin = \App\Models\User::factory()->create(['level' => 'admin']);
        $book = Buku::create(['judul' => 'Galeri Buku', 'penulis' => 'Fadlan', 'harga' => 50000, 'tgl_terbit' => '2026-01-01']);
        $file = fn () => \Illuminate\Http\UploadedFile::fake()->createWithContent('foto.png', file_get_contents(base_path('tests/Fixtures/logo.png')));
        $this->actingAs($admin)->post('/gallery', ['buku_id' => $book->id, 'title' => 'Foto Buku', 'description' => 'Sampul depan', 'picture' => $file()])->assertRedirect('/gallery');
        $photo = \App\Models\BookPhoto::firstOrFail();
        $original = $photo->picture;
        $this->assertSame($book->id, $photo->buku_id);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($original);
        $this->get('/detail-buku/'.$book->buku_seo)->assertSee('Foto Buku');
        $this->put('/gallery/'.$photo->id, ['buku_id' => $book->id, 'title' => 'Foto Baru', 'description' => 'Sampul baru', 'picture' => $file()])->assertRedirect('/gallery');
        $photo->refresh();
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing($original);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($photo->picture);
        $this->delete('/gallery/'.$photo->id)->assertRedirect('/gallery');
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing($photo->picture);
        $this->assertDatabaseMissing('book_photos', ['id' => $photo->id]);
    }

    public function test_cover_upload_validation_and_gallery_authorization(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $book = Buku::create(['judul' => 'Cover', 'penulis' => 'Fadlan', 'harga' => 10000, 'tgl_terbit' => '2026-01-01']);
        $this->post('/gallery', [])->assertRedirect('/login');
        $user = \App\Models\User::factory()->create(['level' => 'user']);
        $this->actingAs($user)->post('/gallery', [])->assertForbidden();
        $this->post('/books/'.$book->id.'/cover', [])->assertForbidden();
        $admin = \App\Models\User::factory()->create(['level' => 'admin']);
        $this->actingAs($admin)->post('/gallery', [])->assertSessionHasErrors(['buku_id', 'title', 'description', 'picture']);
        $this->post('/gallery', ['buku_id' => $book->id, 'title' => 'Invalid', 'description' => 'File bukan gambar', 'picture' => \Illuminate\Http\UploadedFile::fake()->create('test.pdf', 5)])->assertSessionHasErrors('picture');
        $file = fn () => \Illuminate\Http\UploadedFile::fake()->createWithContent('cover.png', file_get_contents(base_path('tests/Fixtures/logo.png')));
        $this->post('/books/'.$book->id.'/cover', ['foto' => $file()])->assertRedirect();
        $old = $book->fresh()->foto;
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($old);
        $this->post('/books/'.$book->id.'/cover', ['foto' => $file()])->assertRedirect();
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing($old);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($book->fresh()->foto);
    }

    public function test_books_get_unique_seo_slugs_and_public_detail(): void
    {
        $data = ['judul' => 'Buku Laravel', 'penulis' => 'Fadlan', 'harga' => 75000, 'tgl_terbit' => '2026-01-01'];
        $first = Buku::create($data);
        $second = Buku::create($data);
        $this->assertSame('buku-laravel', $first->buku_seo);
        $this->assertSame('buku-laravel-2', $second->buku_seo);
        $this->get('/list-buku')->assertOk()->assertSee('Buku Laravel');
        $this->get('/detail-buku/'.$first->buku_seo)->assertOk()->assertSee('Buku Laravel');
        $this->get('/detail-buku/tidak-ada')->assertNotFound();
    }
}
