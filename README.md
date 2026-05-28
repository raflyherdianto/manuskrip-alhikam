<p align="center">
  <img src="public/assets/img/logo-title.png" width="120" alt="Manuskrip Al-Hikam Logo">
</p>

<h1 align="center">Digital Repository Manuskrip Al-Hikam</h1>
<p align="center">Platform Digital Pengelolaan dan Publikasi Manuskrip, Karya Keilmuan, dan Naskah Keislaman Mahasiswa Pesantren Mahasiswa Al-Hikam Malang</p>

---

## Tentang Digital Repository Manuskrip Al-Hikam

**Digital Repository Manuskrip Al-Hikam** adalah platform digital berbasis web yang dirancang khusus untuk memfasilitasi penyimpanan, pengelolaan, verifikasi, serta publikasi manuskrip digital, kitab, catatan kajian, arsip keilmuan, dan naskah keislaman mahasiswa Pesantren Mahasiswa Al-Hikam Malang.

Platform ini dikembangkan sebagai bagian dari Tugas Akhir Program Studi **D4 Perpustakaan Digital, Universitas Negeri Malang**.

---

## Fitur Utama

- **Unggah Manuskrip & Karya**: Mahasiswa dapat mengunggah berbagai jenis naskah keislaman (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG, MP4).
- **Advanced Dynamic Filter (Responsive)**: Halaman penjelajahan manuskrip dilengkapi filter dinamis (Tahun, Angkatan, Jenis Manuskrip, Jurusan, Program Studi, dan Kategori Manuskrip) yang responsif dan memuat data secara instan menggunakan teknologi AJAX & Debouncing.
- **Dashboard Dosen (Admin)**: Dosen penelaah dapat meninjau, memverifikasi, serta menyetujui kelayakan manuskrip yang diajukan oleh mahasiswa sebelum dipublikasikan secara luas.
- **Dashboard Superadmin**: Manajemen data master secara dinamis:
  - **Manajemen Pengguna**: Pembedaan antarmuka dan pengelolaan dosen (dengan NIP) serta mahasiswa (dengan NIM & Angkatan).
  - **Manajemen Jurusan & Program Studi**: Penyesuaian data akademik Pesantren Al-Hikam (misal: Jurusan Tarbiyah, Ekonomi & Bisnis Islam; Prodi PAI, PGMI, Ekonomi Syariah, Manajemen Pendidikan).
  - **Manajemen Kategori Keilmuan**: Kategorisasi naskah berdasarkan disiplin keilmuan Islam (Akidah, Tafsir, Hadis, Fikih, Tasawuf, Nahwu, Sharaf).
- **Notifikasi Email Otomatis**: Pemberitahuan seketika ke alamat email mahasiswa saat naskah yang diajukan dalam proses penelaahan atau telah disetujui.
- **Visualisasi Statistik**: Dasbor interaktif berupa grafik perkembangan jumlah naskah masuk setiap bulan dan setiap tahun.

---

## Teknologi Utama

- **Backend**: PHP 8.4+, Laravel 10
- **Frontend**: Bootstrap 5, Vite, Vanilla JS (AJAX & Debouncing)
- **Database**: MySQL

---

## Mode Pengembangan (Lokal)

### Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js dan NPM
- MySQL 8.0 atau lebih tinggi

### Langkah Install
1. **Clone Repositori**:
   ```bash
   git clone https://github.com/raflyherdianto/manuskrip-alhikam.git
   cd manuskrip-alhikam
   ```
2. **Instal Dependensi**:
   ```bash
   composer install
   npm install
   ```
3. **Konfigurasi Environment**:
   Salin `.env.example` ke `.env` dan sesuaikan pengaturan database Anda.
4. **Setup Database & Seeding**:
   ```bash
   php artisan key:generate
   php artisan migrate:fresh --seed
   php artisan storage:link
   ```
5. **Jalankan Aplikasi**:
   ```bash
   npm run dev
   # Buka tab terminal baru
   php artisan serve
   ```

---

## Panduan Deployment Produksi (AWS EC2 & Docker)

Aplikasi dideploy secara otomatis menggunakan alur kerja **GitHub Actions** ke server **AWS EC2 (t4g.medium) Linux Ubuntu** dengan proses kompilasi citra (build) kontainer langsung di server tujuan (lokal EC2) tanpa menggunakan Docker Hub.

### Prasyarat di Server EC2
1. Pastikan **Docker** dan **Docker Compose** telah terinstal di server EC2.
2. Pastikan kontainer database MySQL bernama `global-mysql` telah aktif dan berjalan di dalam Docker network bernama `shared-network`.
3. Buat folder proyek secara manual sekali di direktori home user `ubuntu`:
   ```bash
   mkdir -p ~/manuskrip-alhikam
   ```
4. Buat berkas `.env` secara manual di dalam folder tersebut dan isi dengan konfigurasi produksi:
   ```bash
   nano ~/manuskrip-alhikam/.env
   ```
   *Catatan penting untuk berkas `.env` produksi:*
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL=https://domain-anda.com`
   - `DB_HOST=global-mysql` *(harus menggunakan nama kontainer database MySQL eksternal Anda)*

### Langkah Setup GitHub Secrets
Untuk mengaktifkan deployment otomatis melalui CI/CD, tambahkan rahasia berikut di menu **Settings > Secrets and variables > Actions** di repositori GitHub Anda:

1. `SSH_HOST`: Alamat IP Publik VPS EC2 Anda.
2. `SSH_USERNAME`: Username SSH untuk masuk ke EC2 (biasanya `ubuntu`).
3. `SSH_PRIVATE_KEY`: Kunci privat SSH (`id_rsa` Anda) yang memiliki hak akses masuk ke server EC2.

Setelah rahasia ditambahkan, setiap kali Anda melakukan `git push` ke cabang `main` atau `master`, GitHub Actions akan secara otomatis melakukan SSH ke server EC2, melakukan penarikan kode terbaru, merakit citra Docker baru, dan menjalankan kontainer aplikasi yang aman.

---

## Tim Pengembang

- **Penulis**: Aghnia Tsania Syahputri - Program Studi D4 Perpustakaan Digital, Universitas Negeri Malang.
- **Pembimbing**: Setiawan, S.Sos., M.IP. - Universitas Negeri Malang.

---

## Lisensi
Aplikasi dikembangkan khusus untuk keperluan akademik dan dokumentasi Pesantren Mahasiswa Al-Hikam Malang.
