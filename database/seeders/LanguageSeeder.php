<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/language.csv');

        if (!file_exists($csvFile)) {
            $this->command->warn("File CSV language tidak ditemukan: {$csvFile}");
            return;
        }

        // Deteksi dan convert encoding jika perlu
        $content = file_get_contents($csvFile);
        $encoding = mb_detect_encoding($content, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);

        if ($encoding !== 'UTF-8') {
            $content = mb_convert_encoding($content, 'UTF-8', $encoding);
            file_put_contents($csvFile, $content);
        }

        $file = fopen($csvFile, 'r');
        $header = fgetcsv($file); // Skip header row

        while (($row = fgetcsv($file)) !== false) {
            // Skip baris kosong
            if (empty(array_filter($row))) {
                continue;
            }

            // Clean dan validasi data
            $nama = trim($row[0]);

            // Skip jika nama kosong atau hanya whitespace
            if (empty($nama)) {
                continue;
            }

            Language::create([
                'nama' => $nama,
            ]);
        }

        fclose($file);
        $this->command->info('Data language berhasil di-import!');
    }
}
