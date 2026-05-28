<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Superadmin',
            'nim' => null,
            'nip' => null,
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin123'),
            'jenis_kelamin' => null,
            'angkatan' => null,
            'jurusan_id' => null,
            'prodi_id' => null,
            'role' => 'superadmin',
            'verified' => true,
        ]);

        $this->command->info('Superadmin berhasil dibuat!');
    }
}
