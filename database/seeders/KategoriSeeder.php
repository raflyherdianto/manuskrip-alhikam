<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'Akidah',
            'Tafsir',
            'Hadis',
            'Fikih',
            'Tasawuf',
            'Nahwu',
            'Sharaf',
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama' => $kategori,
            ]);
        }

        $this->command->info('Data Kategori berhasil di-seed!');
    }
}
