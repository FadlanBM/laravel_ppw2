<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel job_vacancies untuk modul portal lowongan kerja.
     */
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->string('company');
            $table->string('logo')->nullable();
            $table->integer('salary')->nullable();
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'internship'])->default('full-time');
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel job_vacancies saat rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
