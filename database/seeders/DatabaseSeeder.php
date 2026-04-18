<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@etherealclinic.id',
            'password' => Hash::make('password123'), // Password admin
            'role' => 'admin',
        ]);

        // Panggil semua seeder sesuai urutan (tabel parent dulu)
        $this->call([
            SkinProblemsSeeder::class,
            SymptomsSeeder::class,
            ProblemSymptomSeeder::class,
            ProductsSeeder::class,
            TreatmentsSeeder::class,
            ProblemTreatmentSeeder::class,
        ]);
    }
}
