<?php

namespace Database\Seeders;

use App\Models\JobVacancy;
use Illuminate\Database\Seeder;

class JobVacancySeeder extends Seeder
{
    /**
     * Mengisi data awal lowongan kerja beserta referensi berkas logo.
     */
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Backend Developer (Laravel)',
                'company' => 'PT Nusantara Digital',
                'location' => 'Yogyakarta',
                'salary' => 8500000,
                'job_type' => 'full-time',
                'logo' => 'logos/nusantara-digital.png',
                'description' => 'Mengembangkan REST API internal dengan Laravel 12, menulis unit test, dan merawat integrasi layanan pembayaran. Kualifikasi: menguasai PHP, Eloquent, serta dasar pengujian otomatis.',
            ],
            [
                'title' => 'UI/UX Designer',
                'company' => 'CV Kreasi Visual',
                'location' => 'Bandung',
                'salary' => 7000000,
                'job_type' => 'contract',
                'logo' => 'logos/kreasi-visual.png',
                'description' => 'Merancang alur pengguna dan purwarupa antarmuka untuk produk klien ritel. Diutamakan terbiasa dengan Figma, design system, dan pengujian kegunaan skala kecil.',
            ],
            [
                'title' => 'Data Analyst',
                'company' => 'Tokoloka Indonesia',
                'location' => 'Jakarta',
                'salary' => 9500000,
                'job_type' => 'full-time',
                'logo' => 'logos/tokoloka.png',
                'description' => 'Menyusun laporan penjualan mingguan, merawat dasbor metrik, dan menerjemahkan data transaksi menjadi rekomendasi stok. Keterampilan SQL dan spreadsheet lanjutan menjadi syarat utama.',
            ],
            [
                'title' => 'Staff Administrasi',
                'company' => 'PT Sinergi Pangan',
                'location' => 'Semarang',
                'salary' => 3500000,
                'job_type' => 'part-time',
                'logo' => 'logos/sinergi-pangan.png',
                'description' => 'Mengelola arsip dokumen pengadaan, menjadwalkan rapat divisi, dan merekap absensi karyawan pabrik. Jam kerja empat hari per minggu.',
            ],
            [
                'title' => 'DevOps Engineer',
                'company' => 'Grup Rekayasa Mandiri',
                'location' => 'Surabaya',
                'salary' => 12000000,
                'job_type' => 'full-time',
                'logo' => 'logos/rekayasa-mandiri.png',
                'description' => 'Membangun pipeline CI/CD, mengelola klaster Kubernetes, dan memantau ketersediaan layanan produksi. Pengalaman Docker serta konfigurasi server Linux menjadi nilai tambah.',
            ],
            [
                'title' => 'Web Developer Intern',
                'company' => 'Yayasan Literasi Cerdas',
                'location' => 'Yogyakarta',
                'salary' => 2000000,
                'job_type' => 'internship',
                'logo' => 'logos/literasi-cerdas.png',
                'description' => 'Membantu pemeliharaan situs perpustakaan digital, memperbaiki tampilan halaman katalog, dan mendokumentasikan perubahan kode. Terbuka untuk mahasiswa tingkat akhir.',
            ],
            [
                'title' => 'Frontend Engineer',
                'company' => 'PT Solusi Awan Nusantara',
                'location' => 'Remote',
                'salary' => 10000000,
                'job_type' => 'full-time',
                'logo' => 'logos/solusi-awan.png',
                'description' => 'Mengembangkan antarmuka aplikasi manajemen proyek berbasis Vue dan Tailwind, menjaga performa halaman, serta berkolaborasi harian dengan tim desain.',
            ],
            [
                'title' => 'Mobile Developer',
                'company' => 'Koperasi Digital Sejahtera',
                'location' => 'Yogyakarta',
                'salary' => null,
                'job_type' => 'part-time',
                'logo' => 'logos/koperasi-digital.png',
                'description' => 'Merancang aplikasi simpanan anggota berbasis Flutter, menguji pada perangkat kelas menengah, dan menyiapkan rilis awal ke Play Store internal.',
            ],
        ];

        foreach ($jobs as $job) {
            JobVacancy::firstOrCreate(['title' => $job['title'], 'company' => $job['company']], $job);
        }
    }
}
