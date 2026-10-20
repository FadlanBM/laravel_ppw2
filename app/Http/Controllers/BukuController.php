<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku dengan pagination dan informasi statistik ringkas.
     */
    public function index()
    {
        $batas = 5;
        $jumlah_buku = Buku::count();
        $total_harga = Buku::sum('harga');
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage() - 1);

        return view('buku.index', compact('data_buku', 'no', 'jumlah_buku', 'total_harga'));
    }

    /**
     * Menampilkan form penambahan buku baru.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Menyimpan data buku baru dengan validasi berbahasa Indonesia dan flash message.
     */
    public function store(Request $request)
    {
        $messages = [
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.',
            'penulis.required' => 'Penulis buku wajib diisi.',
            'penulis.string' => 'Nama penulis harus berupa teks.',
            'penulis.max' => 'Nama penulis tidak boleh lebih dari 30 karakter.',
            'harga.required' => 'Harga buku wajib diisi.',
            'harga.numeric' => 'Harga buku harus berupa angka.',
            'tgl_terbit.required' => 'Tanggal terbit buku wajib diisi.',
            'tgl_terbit.date' => 'Format tanggal terbit tidak valid.',
        ];

        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
        ], $messages);

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return redirect('/buku')->with('pesan', 'Data buku berhasil disimpan');
    }

    /**
     * Menampilkan form edit buku berdasarkan ID.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);

        return view('buku.edit', compact('buku'));
    }

    /**
     * Memperbarui data buku dengan validasi dan flash message.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.',
            'penulis.required' => 'Penulis buku wajib diisi.',
            'penulis.string' => 'Nama penulis harus berupa teks.',
            'penulis.max' => 'Nama penulis tidak boleh lebih dari 30 karakter.',
            'harga.required' => 'Harga buku wajib diisi.',
            'harga.numeric' => 'Harga buku harus berupa angka.',
            'tgl_terbit.required' => 'Tanggal terbit buku wajib diisi.',
            'tgl_terbit.date' => 'Format tanggal terbit tidak valid.',
        ];

        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
        ], $messages);

        $buku = Buku::findOrFail($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return redirect('/buku')->with('pesan', 'Data buku berhasil diubah');
    }

    /**
     * Menghapus data buku dan mengirim flash message konfirmasi.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect('/buku')->with('pesan', 'Data buku berhasil dihapus');
    }

    /**
     * Fitur pencarian buku berdasarkan judul atau penulis dengan pagination (Tugas 3).
     */
    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->input('kata');
        $data_buku = Buku::where('judul', 'like', '%'.$cari.'%')
            ->orWhere('penulis', 'like', '%'.$cari.'%')
            ->paginate($batas);
        $jumlah_buku = $data_buku->total();
        $no = $batas * ($data_buku->currentPage() - 1);

        return view('buku.search', compact('data_buku', 'no', 'cari', 'jumlah_buku'));
    }
}
