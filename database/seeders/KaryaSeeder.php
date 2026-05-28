<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karya;
use App\Models\KaryaFile;
use App\Models\User;
use App\Models\JenisKarya;
use App\Models\Kategori;
use App\Models\Language;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class KaryaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all student user IDs
        $userIds = User::where('role', 'user')->pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('Tidak ada user mahasiswa untuk di-seed karyanya.');
            return;
        }

        // Titles grouped by jurusan
        $titlesByJurusan = [
            'Tarbiyah' => [
                'Implementasi Nilai-Nilai Adab Al-Alim wal Mutaallim dalam Pembelajaran Modern',
                'Metode Menghafal Al-Qur\'an Efektif bagi Mahasantri di Pesantren Al-Hikam',
                'Manajemen Pendidikan Karakter Berbasis Boarding School',
                'Strategi Pembelajaran Nahwu-Sharaf Menggunakan Kitab Al-Amtsilah Al-Tashrifiyah',
                'Peran Pondok Pesantren dalam Pembentukan Akhlakul Karimah Mahasiswa',
            ],
            'Ekonomi dan Bisnis Islam' => [
                'Analisis Hukum Islam terhadap Praktik Layanan Paylater di E-Commerce',
                'Pengaruh Labelisasi Halal terhadap Minat Beli Kuliner di Lingkungan Pesantren',
                'Peran Baitul Maal wat Tamwil (BMT) dalam Pemberdayaan Ekonomi Umat',
                'Implementasi Akad Mudharabah pada Lembaga Keuangan Syariah',
                'Etika Bisnis Islam dalam Transaksi Jual Beli Online',
            ],
        ];

        // Descriptions grouped by jurusan
        $descriptionsByJurusan = [
            'Tarbiyah' => [
                '<p>Penelitian ini membahas tentang penerapan standar adab menuntut ilmu berdasarkan kitab klasik dalam pendidikan modern. Dengan mengintegrasikan nilai spiritual, hasil yang diperoleh menunjukkan peningkatan akhlak dan motivasi belajar mahasantri.</p>',
                '<p>Proyek ini mengkaji efektivitas metode tahfidz Al-Qur\'an yang diterapkan pada mahasiswa yang aktif kuliah. Melalui pengaturan waktu yang disiplin dan bimbingan terarah, capaian hafalan mahasantri meningkat secara signifikan.</p>',
                '<p>Manuskrip ini memuat riset mendalam tentang pengelolaan karakter mandiri melalui sistem asrama pesantren. Hasil evaluasi menunjukkan dampak positif sistem boarding school terhadap karakter mahasantri.</p>',
            ],
            'Ekonomi dan Bisnis Islam' => [
                '<p>Penelitian ini menganalisis fenomena transaksi Paylater dalam tinjauan fiqih muamalah. Melalui kajian literatur dan studi kasus, hasil riset menyimpulkan hukum serta batasan transaksi ini agar tetap syar\'i.</p>',
                '<p>Proyek ini mengeksplorasi kesadaran konsumsi produk halal di kalangan akademisi dan mahasantri. Data survei menunjukkan label halal dan reputasi produk memiliki pengaruh dominan terhadap keputusan pembelian.</p>',
                '<p>Manuskrip ini mengulas peran strategis BMT dalam memberikan pembiayaan mikro bagi pelaku usaha kecil di sekitar pesantren. Hasil riset menunjukkan peningkatan pendapatan dan kemandirian ekonomi penerima manfaat.</p>',
            ],
        ];

        $sources = [
            'Kajian Kitab Mandiri',
            'Skripsi / Tugas Akhir',
            'Tugas Mata Kuliah',
            'Karya Tulis Ilmiah',
            'Laporan Praktik Lapangan',
            'Riset Kolaboratif',
        ];

        // Get pembimbing (admin/dosen users)
        $pembimbingIds = User::where('role', 'admin')->pluck('id')->toArray();

        // Get all data for random selection
        $jenisKaryaIds = JenisKarya::pluck('id')->toArray();
        $kategoriIds = Kategori::pluck('id')->toArray();
        $languageIds = Language::pluck('id')->toArray();

        foreach ($userIds as $userId) {
            // Get user's angkatan and jurusan for folder structure
            $user = User::with('jurusan')->find($userId);
            $angkatan = $user->angkatan ?? 'Umum';
            $jurusanNama = $user->jurusan->nama ?? 'Tarbiyah';
            $folderPath = "uploads/{$angkatan}/{$jurusanNama}";

            // Get titles and descriptions based on jurusan
            $titles = $titlesByJurusan[$jurusanNama] ?? $titlesByJurusan['Tarbiyah'];
            $descriptions = $descriptionsByJurusan[$jurusanNama] ?? $descriptionsByJurusan['Tarbiyah'];

            // Create 3 karya for each user
            for ($i = 0; $i < 3; $i++) {
                $randomYear = rand(2024, 2026);
                $randomMonth = rand(1, 12);
                $randomDay = rand(1, 28);
                $randomDate = sprintf('%04d-%02d-%02d', $randomYear, $randomMonth, $randomDay);

                $karya = Karya::create([
                    'user_id' => $userId,
                    'jenis_karya_id' => $jenisKaryaIds[array_rand($jenisKaryaIds)],
                    'title' => $titles[array_rand($titles)],
                    'kategori_id' => $kategoriIds[array_rand($kategoriIds)],
                    'description' => $descriptions[array_rand($descriptions)],
                    'source' => $sources[array_rand($sources)],
                    'date' => $randomDate,
                    'pembimbing_id' => !empty($pembimbingIds) ? $pembimbingIds[array_rand($pembimbingIds)] : $userId,
                    'language_id' => !empty($languageIds) ? $languageIds[array_rand($languageIds)] : 1,
                    'coverage' => '-',
                    'rights' => 'Semua',
                    'status' => 'Terpublish',
                    'relation' => '-',
                ]);

                // Create dummy file record
                KaryaFile::create([
                    'karya_id' => $karya->id,
                    'file_path' => $folderPath . '/dummy.pdf',
                    'format' => 'pdf',
                    'size' => 1024,
                    'thumbnail' => null,
                ]);
            }
        }

        $this->command->info('Data Karya/Manuskrip berhasil di-seed!');
    }
}
