<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class BooksCatalogController extends Controller
{
    public function cover(\Illuminate\Http\Request $request, Buku $buku)
    {
        $request->validate(['foto' => 'required|image|mimes:jpg,jpeg,png|max:2048']);
        $old = $buku->foto;
        $path = $request->file('foto')->store('books/covers', 'public');
        try {
            $buku->update(['foto' => $path]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
            throw $e;
        }
        if ($old) \Illuminate\Support\Facades\Storage::disk('public')->delete($old);
        return back()->with('success', 'Sampul buku berhasil diperbarui.');
    }

    public function index()
    {
        $books = Buku::latest('id')->paginate(12);
        return view('books.catalog', compact('books'));
    }

    public function show(string $title)
    {
        $book = Buku::where('buku_seo', $title)->firstOrFail();
        $photos = $book->photos()->whereNotNull('picture')->where('picture', '!=', '')->latest('id')->get();
        return view('books.detail', compact('book', 'photos'));
    }
}
