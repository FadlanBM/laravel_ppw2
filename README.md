# Praktikum Pemrograman Web 2 (PPW-2) — Pertemuan 8: Fitur Pelengkap CRUD

Repositori ini memuat implementasi proyek praktikum mata kuliah **Pemrograman Web 2 (PPW / PPWL)** pada Program Studi D-IV Teknologi Rekayasa Perangkat Lunak, Departemen Teknik Elektro dan Informatika, Sekolah Vokasi, Universitas Gadjah Mada.

---

## 👤 Informasi Mahasiswa & Dosen Pengampu

- **Nama**: Fadlan Buwono Mukti
- **NIM**: 25/565721/SV/26984
- **Kelas**: A1
- **Program Studi**: D-IV Teknologi Rekayasa Perangkat Lunak
- **Departemen**: Teknik Elektro dan Informatika, Sekolah Vokasi, Universitas Gadjah Mada
- **Dosen Pengampu**: Ir. Dinar Nugroho Pratomo, S.Kom., M.IM., M.Cs.
- **Tahun Akademik**: 2026

---

## 📚 Deskripsi Proyek

Proyek ini dibangun menggunakan **Laravel 12 (PHP 8.4)** dengan fokus pada penyempurnaan operasi **CRUD (*Create, Read, Update, Delete*)** pada entitas data buku. Fitur-fitur pelengkap yang diintegrasikan bertujuan meningkatkan integritas data (*data integrity*), validasi masukan yang andal (*server-side validation*), serta pengalaman pengguna (*user experience*) yang komunikatif melalui pemformatan angka dan penanggalan, komponen kalender grafis, umpan balik flash session, pagination, dan mekanisme pencarian data.

---

## 🚀 Fitur yang Diimplementasikan (Sesuai Modul Pertemuan 8)

### 1. Pengerjaan Latihan Praktikum

1. **Pemformatan Data Tanggal (Carbon) dan Harga (Rupiah)**
   - **Model (`app/Models/Buku.php`)**: Mendaftarkan atribut `tgl_terbit` ke dalam properti `$dates = ['tgl_terbit']` dan `$casts = ['tgl_terbit' => 'date', 'harga' => 'integer']`.
   - **View (`resources/views/buku/index.blade.php`)**: Memformat harga ke format mata uang Rupiah dengan pemisah ribuan `Rp {{ number_format($buku->harga, 0, ',', '.') }}` dan tanggal terbit ke format Indonesia `{{ $buku->tgl_terbit->format('d/m/Y') }}`.

2. **Komponen Datepicker pada Formulir Tambah dan Edit**
   - Integrasi Bootstrap Datepicker dan pustaka Font Awesome pada layout induk `resources/views/layout/master.blade.php`.
   - Penggunaan kelas masukan `.datepicker` dengan inisialisasi format tanggal `yyyy-mm-dd`, auto-close, dan today highlight pada berkas `create.blade.php` dan `edit.blade.php`.

3. **Penerapan Flash Message Feedback**
   - Pemanfaatan HTTP Session flash message pada `BukuController.php` dengan sintaks:
     ```php
     return redirect('/buku')->with('pesan', 'Data buku berhasil disimpan');
     ```
   - Penangkapan pesan di antarmuka `index.blade.php` menggunakan `@if (Session::has('pesan'))` dengan komponen Alert Bootstrap 5 berwarna hijau (`alert-success`).

4. **Validasi Formulir Sisi Server (Server-side Validation)**
   - Proteksi input pada metode `store()` dan `update()` dengan aturan validasi:
     - `judul`: `required|string`
     - `penulis`: `required|string|max:30`
     - `harga`: `required|numeric`
     - `tgl_terbit`: `required|date`
   - Penanganan error pada tampilan menggunakan perulangan `@foreach ($errors->all() as $error)` dan penanda visual is-invalid pada field input.

5. **Pagination Data Buku**
   - Pembatasan pemanggilan data per halaman menggunakan metode Eloquent `Buku::orderBy('id', 'desc')->paginate(5)`.
   - Penomoran indeks dinamis berlanjut antarhalaman menggunakan rumus:
     ```php
     $no = $batas * ($data_buku->currentPage() - 1);
     ```
   - Navigasi halaman menggunakan komponen bawaan `$data_buku->links()` yang terintegrasi dengan Bootstrap 5 pada `AppServiceProvider.php`.

---

### 2. Pengerjaan Tugas Praktikum

1. **Tugas 1: Flash Message Komprehensif pada Seluruh Operasi CRUD**
   - Penerapan pesan notifikasi spesifik untuk setiap aksi:
     - **Tambah (`store`)**: `Data buku berhasil disimpan`
     - **Ubah (`update`)**: `Data buku berhasil diubah`
     - **Hapus (`destroy`)**: `Data buku berhasil dihapus`
   - Pembuatan antarmuka formulir pengeditan `resources/views/buku/edit.blade.php` yang memuat data eksisting secara otomatis.

2. **Tugas 2: Kustomisasi Pesan Validasi Berbahasa Indonesia**
   - Pengiriman array pesan kesalahan kustom (`$messages`) pada `$request->validate()`:
     ```php
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
     ```

3. **Tugas 3: Fitur Searching (Pencarian) Data Buku & Pagination Hasil**
   - Pendaftaran rute pencarian: `Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search')`.
   - Implementasi kueri filter pada `BukuController::search`:
     ```php
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
     ```
   - Formulir kotak pencarian pada `index.blade.php` serta pembuatan view khusus `resources/views/buku/search.blade.php` yang menampilkan:
     - Badge informasi jumlah hasil ditemukan (`Ditemukan {jumlah_buku} data buku dengan kata kunci: "{cari}"`).
     - Alert peringatan kuning jika data tidak ditemukan beserta tombol kembali ke katalog utama.
     - Navigasi pagination khusus hasil pencarian.

---

## 🧪 Pengujian Otomatis (Automated Testing)

Keandalan seluruh fungsionalitas diuji secara otomatis menggunakan framework pengujian **Pest / PHPUnit** pada berkas `tests/Feature/BukuCrudFeatureTest.php`.

Rangkaian 8 skenario pengujian mencakup:
1. `test_index_page_displays_books_and_pagination`: Verifikasi halaman indeks, pemformatan harga Rupiah, dan counter jumlah buku.
2. `test_create_page_renders_successfully`: Verifikasi halaman tambah buku dan komponen datepicker.
3. `test_store_validation_errors_in_indonesian`: Verifikasi pencegahan input kosong dan kebenaran pesan galat Bahasa Indonesia.
4. `test_store_success_with_flash_message`: Verifikasi penyimpanan buku baru dan penerimaan flash message sukses.
5. `test_update_success_with_flash_message`: Verifikasi pembaruan data buku pada database dan notifikasi flash ubah.
6. `test_destroy_success_with_flash_message`: Verifikasi penghapusan data buku dari database dan notifikasi flash hapus.
7. `test_search_feature_finds_matching_books`: Verifikasi fitur pencarian dengan kata kunci yang menghasilkan data cocok.
8. `test_search_feature_shows_warning_when_not_found`: Verifikasi fitur pencarian saat kata kunci tidak ditemukan.

Jalankan pengujian otomatis dengan perintah:
```bash
php artisan test
```

Hasil pengujian: **18 passed (56 assertions), 100% lolos pengujian**.

---

## 🛣️ Daftar Rute Aplikasi (Routes)

| Method | URI | Name | Action / Controller | Keterangan |
|---|---|---|---|---|
| `GET` | `/` | - | Closure | Redirect ke `/buku` |
| `GET` | `/buku` | `buku.index` | `BukuController@index` | Menampilkan katalog buku & pagination |
| `GET` | `/buku/create` | `buku.create` | `BukuController@create` | Form tambah buku (datepicker) |
| `POST` | `/buku` | `buku.store` | `BukuController@store` | Simpan buku baru & validasi |
| `GET` | `/buku/edit/{id}` | `buku.edit` | `BukuController@edit` | Form edit buku (datepicker) |
| `POST` | `/buku/update/{id}` | `buku.update` | `BukuController@update` | Simpan perubahan data buku |
| `POST` | `/buku/delete/{id}` | `buku.destroy` | `BukuController@destroy` | Hapus data buku |
| `GET` | `/buku/search` | `buku.search` | `BukuController@search` | Pencarian buku (judul / penulis) |
| `GET` | `/login` | `login` | `AuthController@showLoginForm` | Form login |
| `POST` | `/login` | - | `AuthController@login` | Proses otentikasi login |
| `GET` | `/register` | `register` | `AuthController@showRegisterForm` | Form registrasi akun |
| `POST` | `/register` | - | `AuthController@register` | Proses pendaftaran akun |
| `POST` | `/logout` | `logout` | `AuthController@logout` | Proses logout |
| `GET` | `/dashboard` | `dashboard` | Closure (auth middleware) | Halaman dashboard pengguna |

---

## 💻 Panduan Menjalankan Proyek Secara Lokal

1. **Clone Repositori**:
   ```bash
   git clone git@github.com:FadlanBM/laravel_ppw2.git
   cd laravel_ppw2
   ```

2. **Instalasi Dependensi PHP**:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi dan Seeder Basis Data**:
   ```bash
   php artisan migrate:fresh --seed --class=BukuSeeder
   ```

5. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Akses aplikasi pada peramban melalui alamat: [http://localhost:8000/buku](http://localhost:8000/buku).

6. **Menjalankan Pengujian Otomatis**:
   ```bash
   php artisan test
   ```
