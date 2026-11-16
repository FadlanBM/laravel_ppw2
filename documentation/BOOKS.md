# Books: Gallery dan Penggunaan SEO

Studi kasus kedua modul diadaptasi menjadi website Books, bukan postingan umum atau portofolio personal.

## Batas
- Base adalah commit lokal `560be67`, tidak ada pull/fetch/merge branch dev.
- Branch pekerjaan: `pertemuan_11` sesuai tugas Gallery.
- BAB XI Deploy Project (Heroku) sengaja tidak dikerjakan. Tidak ada deployment/server yang diubah.
- Aset sampul dan foto contoh adalah ilustrasi praktikum yang dirender sebagai berkas PNG. Screenshot bukti adalah tangkapan browser aplikasi Laravel nyata, bukan mockup.

## Jalankan
```sh
composer install
cp .env.example .env
php artisan key:generate
# Gunakan SQLite default, buat database/database.sqlite jika belum ada.
php artisan migrate --seed
php artisan storage:link
php artisan serve
```
Bagi instalasi sebelumnya: jalankan `php artisan migrate` lalu `php artisan db:seed --class=BooksGallerySeeder`. Jangan memakai migrate:fresh pada database berisi data penting.

- Katalog publik: `/list-buku`
- Detail SEO: `/detail-buku/{buku_seo}`
- Galeri publik: `/gallery` (30 foto per halaman; hanya picture bukan NULL/kosong)
- Tambah/edit/hapus foto dan ganti sampul: login admin, navigasi Galeri / detail buku.
- Akun seeder lokal: `fadlan@mail.ugm.ac.id` / `password123`; hanya akun demonstrasi, jangan dipakai produksi.

## Implementasi
Migration menambah buku_seo (unik), foto pada books, dan tabel book_photos dengan foreign key buku_id. Slug buku stabil ketika judul diganti; tabrakan ditangani suffix. Model Buku menyediakan photos(). Slug galeri disimpan pada galeri_seo. Upload divalidasi JPG/PNG dan disimpan ke disk public. Penggantian menyimpan berkas baru, memperbarui DB, lalu menghapus berkas lama; bila penyimpanan DB gagal berkas baru dibersihkan. Lightbox2 2.11.5 dan Bootstrap 5.3.3 tersedia lokal beserta lisensinya.

## Verifikasi
`php artisan test`: 36 passed, 149 assertions. Tes khusus Books mencakup slug unik, katalog/detail/404, relasi galeri, upload/ganti/hapus beserta storage, otorisasi dan validasi.
Playwright: katalog, URL slug, Lightbox next/close, pagination, login, validasi form, upload, edit/ganti, hapus, sampul, mobile tanpa overflow; 13 screenshot di documentation/screenshots/books. `verification.json` mencatat daftar bukti. Tidak ada JS pageerror/respons 500 pada alur ini.
