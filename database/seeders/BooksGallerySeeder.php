<?php
namespace Database\Seeders;

use App\Models\Buku;
use App\Models\BookPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BooksGallerySeeder extends Seeder
{
    public function run(): void
    {
        foreach (Buku::orderBy('id')->get() as $index => $book) {
            $number = ($index % 20) + 1;
            $cover = 'books/covers/demo-'.$book->id.'.png';
            if (! $book->foto) {
                Storage::disk('public')->put($cover, file_get_contents(database_path('fixtures/books/cover-'.$number.'.png')));
                $book->update(['foto' => $cover]);
            }
            if (! $book->photos()->exists()) {
                foreach ([1 => 'Sampul dan identitas', 2 => 'Catatan pembacaan'] as $j => $label) {
                    $path = 'books/gallery/demo-'.$book->id.'-'.$j.'.png';
                    Storage::disk('public')->put($path, file_get_contents(database_path('fixtures/books/photo-'.$number.'-'.$j.'.png')));
                    BookPhoto::create(['buku_id' => $book->id, 'title' => $label.' '.$book->judul, 'description' => 'Dokumentasi visual untuk koleksi '.$book->judul.'. Aset ilustrasi praktikum.', 'picture' => $path, 'galeri_seo' => Str::slug($label.' '.$book->judul).'-'.$book->id]);
                }
            }
        }
    }
}
