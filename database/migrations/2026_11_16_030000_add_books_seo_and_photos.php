<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('buku_seo')->nullable()->unique();
            $table->string('foto')->nullable();
        });
        foreach (DB::table('books')->orderBy('id')->get() as $book) {
            $base = Str::slug($book->judul) ?: 'buku';
            $slug = $base;
            $n = 2;
            while (DB::table('books')->where('buku_seo', $slug)->exists()) {
                $slug = $base.'-'.$n++;
            }
            DB::table('books')->where('id', $book->id)->update(['buku_seo' => $slug]);
        }
        Schema::create('book_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('books')->cascadeOnDelete();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('picture')->nullable();
            $table->string('galeri_seo')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_photos');
        Schema::table('books', fn (Blueprint $table) => $table->dropColumn(['buku_seo', 'foto']));
    }
};
