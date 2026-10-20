<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'judul',
        'penulis',
        'harga',
        'tgl_terbit',
    ];

    /**
     * Property dates untuk integrasi Carbon (konvensi modul praktikum)
     */
    protected $dates = ['tgl_terbit'];

    protected $casts = [
        'tgl_terbit' => 'date',
        'harga' => 'integer',
    ];
}
