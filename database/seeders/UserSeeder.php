<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch Jurusans and Prodis
        $tarbiyah = Jurusan::where('nama', 'Tarbiyah')->first();
        $ekonomi = Jurusan::where('nama', 'Ekonomi dan Bisnis Islam')->first();

        $tarbiyahId = $tarbiyah ? $tarbiyah->id : 1;
        $ekonomiId = $ekonomi ? $ekonomi->id : 2;

        $prodiEkonomi = Prodi::where('nama', 'Ekonomi Syariah')->first();
        $prodiPai = Prodi::where('nama', 'Pendidikan Agama Islam (PAI)')->first();
        $prodiMpi = Prodi::where('nama', 'Manajemen Pendidikan')->first();
        $prodiPgmi = Prodi::where('nama', 'Pendidikan Guru Madrasah Ibtidaiyah (PGMI)')->first();

        // 1. Predictable Mahasiswa Test Accounts
        User::create([
            'name' => 'Ahmad Fauzi',
            'nim' => '20210001',
            'nip' => null,
            'email' => 'mahasiswa1@gmail.com',
            'password' => Hash::make('password123'),
            'jenis_kelamin' => 'L',
            'angkatan' => '2021',
            'jurusan_id' => $ekonomiId,
            'prodi_id' => $prodiEkonomi ? $prodiEkonomi->id : null,
            'role' => 'user',
            'verified' => true,
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'nim' => '20220002',
            'nip' => null,
            'email' => 'mahasiswa2@gmail.com',
            'password' => Hash::make('password123'),
            'jenis_kelamin' => 'P',
            'angkatan' => '2022',
            'jurusan_id' => $tarbiyahId,
            'prodi_id' => $prodiPai ? $prodiPai->id : null,
            'role' => 'user',
            'verified' => true,
        ]);

        // 2. Predictable Dosen Test Accounts
        User::create([
            'name' => 'Dr. H. M. Lukman, M.Ag.',
            'nim' => null,
            'nip' => '19850101001',
            'email' => 'dosen1@gmail.com',
            'password' => Hash::make('password123'),
            'jenis_kelamin' => 'L',
            'angkatan' => null,
            'jurusan_id' => $tarbiyahId,
            'prodi_id' => $prodiPai ? $prodiPai->id : null,
            'role' => 'admin',
            'verified' => true,
        ]);

        User::create([
            'name' => 'Dr. Hj. Rahmawati, M.E.',
            'nim' => null,
            'nip' => '19880202002',
            'email' => 'dosen2@gmail.com',
            'password' => Hash::make('password123'),
            'jenis_kelamin' => 'P',
            'angkatan' => null,
            'jurusan_id' => $ekonomiId,
            'prodi_id' => $prodiEkonomi ? $prodiEkonomi->id : null,
            'role' => 'admin',
            'verified' => true,
        ]);

        // 3. Generate Random Mahasiswa (role = 'user')
        $mahasiswaNames = [
            'Muhammad Ali', 'Farhan Hidayat', 'Zulkifli', 'Yusuf Habibi', 'Rizky Ramadhan',
            'Fatimah Zahra', 'Aisyah Humaira', 'Khadijah', 'Zahra Salsabila', 'Naila Rahma'
        ];

        $angkatans = ['2021', '2022', '2023', '2024'];
        $jurusans = Jurusan::all();

        foreach ($mahasiswaNames as $index => $name) {
            $jurusan = $jurusans->random();
            $prodi = Prodi::where('jurusan_id', $jurusan->id)->get()->random();
            $nim = '20' . rand(21, 24) . str_pad(rand(100, 999), 4, '0', STR_PAD_LEFT);
            $jenisKelamin = ($index < 5) ? 'L' : 'P';

            User::create([
                'name' => $name,
                'nim' => $nim,
                'nip' => null,
                'email' => strtolower(str_replace(' ', '', $name)) . '@student.ac.id',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => $jenisKelamin,
                'angkatan' => $angkatans[array_rand($angkatans)],
                'jurusan_id' => $jurusan->id,
                'prodi_id' => $prodi->id,
                'role' => 'user',
                'verified' => rand(0, 1) === 1,
            ]);
        }

        // 4. Generate Random Dosen (role = 'admin')
        $dosenNames = [
            'Prof. Ahmad Yani, M.A.', 'Drs. KH. M. Basri, M.Th.I.', 'Dr. KH. Abdullah Munir, M.Pd.'
        ];

        foreach ($dosenNames as $index => $name) {
            $jurusan = $jurusans->random();
            $prodi = Prodi::where('jurusan_id', $jurusan->id)->get()->random();
            $nip = '19' . rand(70, 95) . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . rand(100, 999);

            User::create([
                'name' => $name,
                'nim' => null,
                'nip' => $nip,
                'email' => strtolower(str_replace(['.', ',', ' '], '', $name)) . '@lecturer.ac.id',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'angkatan' => null,
                'jurusan_id' => $jurusan->id,
                'prodi_id' => $prodi->id,
                'role' => 'admin',
                'verified' => true,
            ]);
        }

        $this->command->info('Data Mahasiswa & Dosen berhasil di-seed!');
    }
}
