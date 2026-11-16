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
        'foto',
    ];

    protected static function booted(): void
    {
        static::saving(function (Buku $book) {
            if (! $book->buku_seo) {
                $base = \Illuminate\Support\Str::slug($book->judul) ?: 'buku';
                $slug = $base;
                $n = 2;
                while (static::where('buku_seo', $slug)->where('id', '!=', $book->id ?? 0)->exists()) {
                    $slug = $base.'-'.$n++;
                }
                $book->buku_seo = $slug;
            }
        });
    }

    public function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BookPhoto::class, 'buku_id');
    }

    /**
     * Property dates untuk integrasi Carbon (konvensi modul praktikum)
     */
    protected $dates = ['tgl_terbit'];

    protected $casts = [
        'tgl_terbit' => 'date',
        'harga' => 'integer',
    ];
}
