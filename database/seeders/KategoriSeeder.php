<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Kayu'],
            ['nama_kategori' => 'Besi'],
            ['nama_kategori' => 'Paralon'],
            ['nama_kategori' => 'Paku'],
            ['nama_kategori' => 'Semen'],
            ['nama_kategori' => 'Kanopi'],
        ];

        foreach ($data as $kategori) {
            DB::table('kategori')->updateOrInsert(
                ['nama_kategori' => $kategori['nama_kategori']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
