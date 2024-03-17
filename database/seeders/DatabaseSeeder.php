<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\KursiPenumpang;
use App\Models\Ship;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'nama' => 'Admin',
            'title' => 'Tn',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'hp' => '-',
            'alamat' => '-',
        ]);
        User::create([
            'nama' => 'User',
            'title' => 'Tn',
            'email' => 'user@gmail.com',
            'role' => 'pengguna',
            'password' => Hash::make('user123'),
            'hp' => '-',
            'alamat' => '-',
        ]);

        Ship::create([
            'nama_kapal' => 'KM. NATUNA EXPRESS',
            'panjang_kapal' => 40.25,
            'kapasitas_penumpang' => 148,
            'lebar_kapal' => 4.73,
            'tahun_produksi' => 2006,
        ]);
        Ship::create([
            'nama_kapal' => 'MV. MULIA KENCANA 99',
            'panjang_kapal' => 40.25,
            'kapasitas_penumpang' => 148,
            'lebar_kapal' => 4.73,
            'tahun_produksi' => 2006,
        ]);
    }
}
