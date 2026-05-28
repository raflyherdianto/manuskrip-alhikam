<?php

namespace Database\Seeders;

use App\Models\JenisKarya;
use Illuminate\Database\Seeder;

class JenisKaryaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisKaryas = [
            'Kitab',
            'Catatan Kajian',
            'Manuskrip Digital',
            'Arsip Keilmuan',
            'Naskah Keislaman',
        ];

        foreach ($jenisKaryas as $jenis) {
            JenisKarya::create([
                'nama' => $jenis,
            ]);
        }

        $this->command->info('Data jenis karya/manuskrip berhasil di-seed!');
    }
}
