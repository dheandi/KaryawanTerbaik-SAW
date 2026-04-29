<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\Criterion::create(['nama' => 'Kinerja', 'tipe' => 'benefit', 'bobot' => 0.25]);
        \App\Models\Criterion::create(['nama' => 'Kehadiran', 'tipe' => 'benefit', 'bobot' => 0.25]);
        \App\Models\Criterion::create(['nama' => 'Kerjasama Tim', 'tipe' => 'benefit', 'bobot' => 0.2]);
        \App\Models\Criterion::create(['nama' => 'Jumlah Kesalahan', 'tipe' => 'cost', 'bobot' => 0.15]);
        \App\Models\Criterion::create(['nama' => 'Keterlambatan', 'tipe' => 'cost', 'bobot' => 0.15]);
    }
}
