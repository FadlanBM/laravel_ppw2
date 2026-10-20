<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['Laskar Pelangi', 'Andrea Hirata', 85000, '2005-09-01'],
            ['Sang Pemimpi', 'Andrea Hirata', 79000, '2006-07-01'],
            ['Edensor', 'Andrea Hirata', 82000, '2007-05-01'],
            ['Maryamah Karpov', 'Andrea Hirata', 95000, '2008-11-01'],
            ['Bumi Manusia', 'Pramoedya Ananta Toer', 120000, '1980-08-25'],
            ['Anak Semua Bangsa', 'Pramoedya Ananta Toer', 115000, '1981-03-10'],
            ['Jejak Langkah', 'Pramoedya Ananta Toer', 125000, '1985-06-15'],
            ['Rumah Kaca', 'Pramoedya Ananta Toer', 130000, '1988-04-20'],
            ['Perahu Kertas', 'Dee Lestari', 78000, '2009-07-01'],
            ['Supernova: Ksatria, Puteri, dan Bintang Jatuh', 'Dee Lestari', 98000, '2001-03-05'],
            ['Supernova: Akar', 'Dee Lestari', 105000, '2002-10-12'],
            ['Partikel', 'Dee Lestari', 92000, '2012-08-18'],
            ['Negeri 5 Menara', 'Ahmad Fuadi', 88000, '2009-08-01'],
            ['Ranah 3 Warna', 'Ahmad Fuadi', 90000, '2011-02-14'],
            ['Rantau 1 Muara', 'Ahmad Fuadi', 93000, '2013-05-22'],
            ['Anak Rantau', 'Ahmad Fuadi', 87000, '2019-09-09'],
            ['Ayat-Ayat Cinta', 'Habiburrahman El Shirazy', 75000, '2004-12-01'],
            ['Pudarnya Pesona Cleopatra', 'Habiburrahman El Shirazy', 68000, '2005-06-07'],
            ['Ketika Cinta Bertasbih', 'Habiburrahman El Shirazy', 89000, '2007-08-30'],
            ['Bumi Cinta', 'Habiburrahman El Shirazy', 95000, '2010-01-16'],
        ];

        foreach ($data as $buku) {
            Buku::create([
                'judul' => $buku[0],
                'penulis' => $buku[1],
                'harga' => $buku[2],
                'tgl_terbit' => $buku[3],
            ]);
        }
    }
}
