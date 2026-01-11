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
        // Buat user admin
        User::updateOrCreate(
            ['email' => 'admin@polcabot.com'],
            [
                'username' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
            
        );

        // Buat user biasa untuk testing
        User::updateOrCreate(
            ['email' => 'test@polcabot.com'],
            [
                'username' => 'Test User',
                'password' => Hash::make('123456'),
                'role' => 'user',
            ]
        );

        // Jalankan seeder untuk knowledge base
        $this->call([
            OrganisasiKnowledgeSeeder::class,
            JurusanKnowledgeSeeder::class,
            BeasiswaKnowledgeSeeder::class,
            DaftarKnowledgeSeeder::class,
        ]);
    }
}