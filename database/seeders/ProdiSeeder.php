<?php

namespace Database\Seeders;

use App\Models\Prodi;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarbiyah = Jurusan::where('nama', 'Tarbiyah')->first();
        $ekonomi = Jurusan::where('nama', 'Ekonomi dan Bisnis Islam')->first();

        // Fallbacks in case IDs are not standard
        $tarbiyahId = $tarbiyah ? $tarbiyah->id : 1;
        $ekonomiId = $ekonomi ? $ekonomi->id : 2;

        $prodis = [
            [
                'nama' => 'Ekonomi Syariah',
                'jurusan_id' => $ekonomiId,
            ],
            [
                'nama' => 'Manajemen Pendidikan',
                'jurusan_id' => $tarbiyahId,
            ],
            [
                'nama' => 'Pendidikan Agama Islam (PAI)',
                'jurusan_id' => $tarbiyahId,
            ],
            [
                'nama' => 'Pendidikan Guru Madrasah Ibtidaiyah (PGMI)',
                'jurusan_id' => $tarbiyahId,
            ],
        ];

        foreach ($prodis as $prodi) {
            Prodi::create($prodi);
        }

        $this->command->info('Data Prodi berhasil di-seed!');
    }
}
