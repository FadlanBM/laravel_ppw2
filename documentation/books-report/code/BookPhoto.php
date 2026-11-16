<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookPhoto extends Model
{
    protected $fillable = ['buku_id', 'title', 'description', 'picture', 'galeri_seo'];

    public function buku(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
