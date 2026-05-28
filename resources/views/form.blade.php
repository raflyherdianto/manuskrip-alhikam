@extends('layouts.app')

@section('content')

<div class="mb-5 container bg-white px-5 pb-5 mt-5" style="border-radius: 20px; border-top: 20px solid #1F304B">
    <div class="fw-bold mt-2" style="font-size: 36px; font-family: 'Instrument Sans', sans-serif">
        Dublin Core
    </div>
    <div style="font-size: 24px; font-family: 'Instrument Sans', sans-serif">
        Silahkan mengisi data dibawah ini dengan lengkap dan benar!
    </div>
    <div class="mb-5 fw-bold" style="font-size: 20px; font-family: 'Instrument Sans', sans-serif">
        (*) Tanda ini menunjukkan bahwa kolom pada formulir wajib diisi.
    </div>

    <form class="" action="{{ route('karya.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="jenis_karya_id" value="{{ $jenisKarya->id }}">

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Judul <span class="text-danger">*</span>
            </label>
            <div class="w-100">
                <div class="mb-1">
                  <span>Tulis judul lengkap manuskrip anda</span>
                  <br>
                  <small class="text-muted d-block" style="font-size: 12px;">
                      <strong>Contoh:</strong>  “Digitalisasi Kitab Fathul Mu'in Bab Shalat”
                  </small>
                </div>
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
              Subjek <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Masukkan subjek atau kata kunci manuskrip anda</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “fiqih, tasawuf, manuskrip keagamaan, sejarah Islam”
                    </small>
                </div>
                <input type="text" name="subject" class="form-control" required>
            </div>
        </div>


        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Deskripsi <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Jelaskan isi manuskrip secara singkat (minimal 10 kata)</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “Manuskrip penjelasan tentang fiqih ibadah mazhab Syafi'i, ditulis tangan oleh KH. Hasyim Asy'ari.”
                    </small>
                </div>

                <textarea name="description" class="form-control" required></textarea>
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Pencipta <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Tulis nama lengkap pembuat manuskrip</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “Ahmad Fauzi”
                    </small>
                </div>

                <input type="text" name="creator" class="form-control" value="{{ $user->name ?? '' }}" required>
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Sumber <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Sebutkan sumber inspirasi atau referensi manuskrip (jika ada)</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “Diadaptasi dari Perpustakaan Kuno Pesantren Al-Hikam, Disalin dari naskah asli tahun 1890”
                    </small>
                </div>

                <input type="text" name="source" class="form-control">
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Penerbit
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Pilih penerbit manuskrip</span>
                </div>

                <select name="publisher" class="form-select" required>
                    <option disabled>-</option>
                    <option value="Pesantren Mahasiswa Al-Hikam Malang ">Pesantren Mahasiswa Al-Hikam Malang</option>
                </select>
            </div>
        </div>


        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Tanggal <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Isi tanggal saat manuskrip diunggah</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “14/08/2025”
                    </small>
                </div>

                <input type="date" name="date" class="form-control" required>
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Kontributor <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Tulis nama penulis atau pembimbing manuskrip</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “Ibu Siti Nuraini, S.Pd.”
                    </small>
                </div>

                <input type="text" name="contributor" class="form-control" required>
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Hak Akses <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Pilih siapa saja yang dapat melihat manuskrip</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “Semua” (untuk Pesantren Al-Hikam) atau “Terbatas”
                    </small>
                </div>

                <select name="rights" class="form-select" required>
                    <option disabled></option>
                    <option value="Semua">Semua</option>
                    <option value="Terbatas">Terbatas</option>
                </select>
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Hubungan <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Jelaskan keterkaitan manuskrip ini dengan manuskrip, proyek, atau kegiatan lain</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “Bagian dari proyek busana adat, manuskrip ini adalah bagian dari proyek kelas, pameran sekolah, atau lomba”
                    </small>
                </div>

                <input type="text" name="relation" class="form-control">
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Bahasa <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Pilih bahasa utama yang digunakan dalam manuskrip</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “Indonesia”
                    </small>
                </div>

                <select id="language" name="language" class="form-select" required>
                    <option value="" selected disabled>Pilih bahasa</option>
                    <option value="Indonesia">Bahasa Indonesia</option>
                    <option value="English">English</option>
                    <option value="Malaysia">Bahasa Melayu</option>
                    <option value="Jawa">Bahasa Jawa</option>
                    <option value="Sunda">Bahasa Sunda</option>
                    <option value="Arabic">Arabic (العربية)</option>
                    <option value="Chinese">Chinese (中文)</option>
                    <option value="Japanese">Japanese (日本語)</option>
                    <option value="Korean">Korean (한국어)</option>
                    <option value="French">French (Français)</option>
                    <option value="German">German (Deutsch)</option>
                    <option value="Spanish">Spanish (Español)</option>
                    <option value="Portuguese">Portuguese (Português)</option>
                    <option value="Russian">Russian (Русский)</option>
                    <option value="Hindi">Hindi (हिन्दी)</option>
                    <option value="Bengali">Bengali (বাংলা)</option>
                    <option value="Tamil">Tamil (தமிழ்)</option>
                    <option value="Turkish">Turkish (Türkçe)</option>
                    <option value="Italian">Italian (Italiano)</option>
                    <option value="Dutch">Dutch (Nederlands)</option>
                  </select>

            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Jenis
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Jenis manuskrip</span>
                </div>

                <div class="form-control" style="background-color: #efefef">Manuskrip {{ $jenisKarya->nama ?? '-' }}</div>
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Identitas <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Masukkan NIM anda</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “20224567”
                    </small>
                </div>

                <input type="number" name="identifier" class="form-control" required>
            </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-md-row">
            <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%;">
                Cakupan <span class="text-danger">*</span>
            </label>

            <div class="w-100">
                <div class="mb-1">
                    <span>Sebutkan lokasi, waktu atau ruang lingkup manuskrip</span>
                    <br>
                    <small class="text-muted d-block" style="font-size: 12px;">
                        <strong>Contoh:</strong> “Kota Malang, 2026 atau Pesantren Al-Hikam Malang, 2026”
                    </small>
                </div>

                <input type="text" name="coverage" class="form-control">
            </div>
        </div>

       <div id="file-upload-wrapper">
            <div class="file-upload-group mb-3">
                <div class="mb-3 d-flex flex-column flex-md-row">
                     <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Unggah File <span class="text-danger">*</span></label>
                    <div class="w-100 d-flex gap-2">
                        <div class="flex-grow-1">
                            <span>Pilih file manuskrip yang ingin diunggah (maksimal 50 MB)</span>
                            <br>
                            <small class="text-muted d-block" style="font-size: 12px;">
                                <strong>Contoh:</strong> Klik “Pilih File” lalu pilih file sesuai manuskrip anda
                            </small>
                            <input type="file" name="file[]" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm mt-4" onclick="removeFileUpload(this)">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-between mt-5">
            <button type="button" class="btn btn-secondary" onclick="addFileUpload()">+ File</button>
            <button class="btn text-white" style="background-color: #1F304B">Unggah</button>
        </div>
    </form>
</div>
<!-- Modal Sukses -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
    <div class="modal-content bg-white">
      <div class="modal-body text-center">
        <div style="font-size:25px" class="fw-bold mb-3">
            Unggahan Anda Berhasil Dilakukan,<br>
            Silahkan Tunggu Dimenu Aktivitas Secara Berkala!
        </div>
        <img src="{{ asset('assets/img/success.png') }}" class="m-auto" style="width: 110px;" alt="">
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tetap di Halaman</button>
        <a href="/" class="btn btn-light">Keluar dari Halaman</a>
      </div>
    </div>
  </div>
</div>

@if (session('success'))
<script>
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
</script>
@endif
<style>
    @media (max-width: 768px) {
        label.fw-bold {
            margin-bottom: 0.5rem;
        }
    }
</style>


<script>
function addFileUpload() {
    const wrapper = document.getElementById('file-upload-wrapper');
    const group = document.createElement('div');
    group.classList.add('file-upload-group', 'mb-3');
    group.innerHTML = `
            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">
                    Format
                </label>
                <div class="w-100">
                    <span>Pilih salah satu format manuskrip anda</span>
                    <select name="format[]" class="form-select" required>
                        <option value="pdf">PDF</option>
                        <option value="jpg">JPG</option>
                        <option value="mp4">MP4</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold">File</label>
                <div class="w-100 d-flex gap-2">
                    <div class="flex-grow-1">
                        <span>Unggah Manuskrip Anda</span>
                        <span style="font-size: 12px"> *MAX FILE 15MB </span>
                        <input type="file" name="file[]" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm mt-4" onclick="removeFileUpload(this)">Hapus</button>
                </div>
            </div>
    `;
    wrapper.appendChild(group);
}

function removeFileUpload(button) {
    const group = button.closest('.file-upload-group');
    group.remove();
}
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
      $('#language').select2({
        placeholder: "Pilih atau ketik bahasa...",
        allowClear: true
      });
    });
</script>

@endsection
