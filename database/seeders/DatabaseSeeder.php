<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder Akun Administrator
        User::firstOrCreate(
            ['email' => 'fadlan@mail.ugm.ac.id'],
            [
                'name' => 'Fadlan Buwono Mukti',
                'password' => Hash::make('password123'),
                'level' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Seeder Akun Pengguna Biasa (User)
        User::firstOrCreate(
            ['email' => 'user@mail.ugm.ac.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'level' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Seeder Akun Tambahan untuk Demonstrasi CRUD Pengguna
        User::firstOrCreate(
            ['email' => 'siti.aminah@mail.ugm.ac.id'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('password123'),
                'level' => 'user',
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            BukuSeeder::class,
        ]);
    }
}
