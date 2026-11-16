<?php

namespace App\Http\Controllers;

use App\Models\BookPhoto;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = BookPhoto::with('buku')->whereNotNull('picture')->where('picture', '!=', '')->latest('id')->paginate(30);
        return view('books.gallery', compact('photos'));
    }

    public function create()
    {
        return view('books.photo-form', ['photo' => new BookPhoto, 'books' => Buku::orderBy('judul')->get()]);
    }

    public function edit(BookPhoto $gallery)
    {
        return view('books.photo-form', ['photo' => $gallery, 'books' => Buku::orderBy('judul')->get()]);
    }

    private function validated(Request $request, bool $required): array
    {
        return $request->validate([
            'buku_id' => 'required|exists:books,id',
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:5000',
            'picture' => ($required ? 'required' : 'nullable').'|image|mimes:jpg,jpeg,png|max:1999',
        ], ['picture.required' => 'Pilih gambar buku.', 'buku_id.required' => 'Pilih buku terkait.', 'title.required' => 'Judul foto wajib diisi.']);
    }

    private function uniqueSlug(string $title, ?int $except = null): string
    {
        $base = Str::slug($title) ?: 'foto';
        $slug = $base;
        $n = 2;
        while (BookPhoto::where('galeri_seo', $slug)->where('id', '!=', $except ?? 0)->exists()) {
            $slug = $base.'-'.$n++;
        }
        return $slug;
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['picture'] = $request->file('picture')->store('books/gallery', 'public');
        $data['galeri_seo'] = $this->uniqueSlug($data['title']);
        try {
            BookPhoto::create($data);
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($data['picture']);
            throw $e;
        }
        return redirect('/gallery')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function update(Request $request, BookPhoto $gallery)
    {
        $data = $this->validated($request, false);
        $oldPath = $gallery->picture;
        $newPath = $request->hasFile('picture') ? $request->file('picture')->store('books/gallery', 'public') : null;
        unset($data['picture']);
        if ($newPath) $data['picture'] = $newPath;
        $data['galeri_seo'] = $this->uniqueSlug($data['title'], $gallery->id);
        try {
            $gallery->update($data);
        } catch (\Throwable $e) {
            if ($newPath) Storage::disk('public')->delete($newPath);
            throw $e;
        }
        if ($newPath && $oldPath) Storage::disk('public')->delete($oldPath);
        return redirect('/gallery')->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(BookPhoto $gallery)
    {
        $path = $gallery->picture;
        $gallery->delete();
        if ($path) Storage::disk('public')->delete($path);
        return redirect('/gallery')->with('success', 'Foto berhasil dihapus.');
    }
}
