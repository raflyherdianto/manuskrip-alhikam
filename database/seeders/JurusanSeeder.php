<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = [
            'Tarbiyah',
            'Ekonomi dan Bisnis Islam',
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::firstOrCreate([
                'nama' => $jurusan,
            ]);
        }

        $this->command->info('Data Jurusan berhasil di-seed!');
    }
}
