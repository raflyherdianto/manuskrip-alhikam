#!/bin/bash

# ===========================================
# POST-MIGRATION SCRIPT
# Jalankan setelah deploy.sh berhasil
# ===========================================

echo "Running post-migration tasks..."

# Update existing users with sub_jurusan_id based on their jurusan
docker exec smkn3malang-web php artisan tinker --execute="
    \$jurusanMapping = [
        // RPL
        1 => ['RPL 1' => 1, 'RPL 2' => 2, 'RPL 3' => 3],
        // MM
        2 => ['MM 1' => 4, 'MM 2' => 5],
        // TKJ
        3 => ['TKJ 1' => 6, 'TKJ 2' => 7],
        // BC
        4 => ['BC 1' => 8, 'BC 2' => 9],
        // DPIB
        5 => ['DPIB 1' => 10, 'DPIB 2' => 11],
        // TP
        6 => ['TP 1' => 12, 'TP 2' => 13],
        // TKRO
        7 => ['TKRO 1' => 14, 'TKRO 2' => 15, 'TKRO 3' => 16],
        // TBSM
        8 => ['TBSM 1' => 17, 'TBSM 2' => 18],
        // TAV
        9 => ['TAV 1' => 19, 'TAV 2' => 20],
        // TITL
        10 => ['TITL 1' => 21, 'TITL 2' => 22],
    ];

    // Get users with role 'user' (siswa) who don't have sub_jurusan_id
    \$users = \App\Models\User::where('role', 'user')
        ->whereNull('sub_jurusan_id')
        ->whereNotNull('jurusan_id')
        ->get();

    foreach (\$users as \$user) {
        if (isset(\$jurusanMapping[\$user->jurusan_id])) {
            // Assign first sub_jurusan for now
            \$firstSubJurusan = array_values(\$jurusanMapping[\$user->jurusan_id])[0];
            \$user->sub_jurusan_id = \$firstSubJurusan;
            \$user->save();
        }
    }

    echo 'Updated ' . \$users->count() . ' users with sub_jurusan_id';
"

echo "Post-migration completed!"
