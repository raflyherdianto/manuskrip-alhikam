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

        <form class="" action="{{ route('karya.update', ['id' => $karya->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')


            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Judul</label>
                <div class="w-100">
                    <span>*Masukkan judul lengkap manuskrip anda</span>
                <input type="text" name="title" class="form-control" required value="{{ old('title', $karya->title) }}">
                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Subjek</label>
                <div class="w-100">
                    <span>*Masukkan subjek atau kata kunci manuskrip anda </span><span style="font-size: 12px"> *contoh: fiqih, tasawuf, dll </span>
                    <input type="text" name="subject" class="form-control" required value="{{ old('subject', $karya->subject) }}">
                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Deskripsi</label>
                <div class="w-100">
                    <span>*Tulis deskripsi dari manuskrip anda </span><span style="font-size: 12px"> *minimal 10 kata contoh: naskah kuno ini menceritakan tentang... </span>
                    <textarea name="description" class="form-control" required>{{ old('description', $karya->description) }}</textarea>

                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Pencipta</label>
                <div class="w-100">
                    <span>Masukkan nama lengkap anda </span>
                <input type="text" name="creator" class="form-control" required value="{{ old('creator', $karya->creator) }}">

                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Sumber</label>
                <div class="w-100">
                    <span>Masukkan sumber terkait manuskrip anda  </span>
                    <input type="text" name="source" class="form-control" value="{{ old('source', $karya->source) }}">

                </div>
            </div>
            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Penerbit</label>
                <div class="w-100">
                    <span>*Masukkan sumber Penerbit manuskrip  </span>
                <select name="publisher" class="form-select" required>
                    <option disabled {{ old('publisher', $karya->publisher) ? '' : 'selected' }}>-</option>
                    <option value="Pesantren Mahasiswa Al-Hikam Malang" {{ old('publisher', $karya->publisher) == 'Pesantren Mahasiswa Al-Hikam Malang' ? 'selected' : '' }}>Pesantren Mahasiswa Al-Hikam Malang</option>
                </select>

                </div>
            </div>


            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Tanggal</label>
                <div class="w-100">
                    <span>*Isi tanggal unggah manuskrip anda (saat ini)  </span>
                    <input type="date" name="date" class="form-control" required value="{{ old('date', $karya->date) }}">

                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Penanggung Jawab</label>
                <div class="w-100">
                    <span>*Masukan nama penanggung jawab manuskrip</span>
                    <input type="text" name="contributor" class="form-control" required
                        value="{{ old('contributor', $karya->contributor) }}">

                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Hak Akses</label>
                <div class="w-100">
                    <span>*Pilih hak akses untuk manuskrip anda</span>

                    <select name="rights" class="form-select" required>
                        <option disabled {{ old('rights', $karya->rights) ? '' : 'selected' }}></option>
                        <option value="Semua" {{ old('rights', $karya->rights) == 'Semua' ? 'selected' : '' }}>Semua</option>
                        <option value="Arsip" {{ old('rights', $karya->rights) == 'Arsip' ? 'selected' : '' }}>Arsip</option>
                    </select>

                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Hubungan</label>
                <div class="w-100">
                    <span>hubungan</span>
                <input type="text" name="relation" class="form-control" value="{{ old('relation', $karya->relation) }}">

                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Bahasa</label>
                <div class="w-100">
                    <span>*Pilih bahasa yang digunakan</span>
                    <input type="text" name="language" class="form-control" required value="{{ old('language', $karya->language) }}">

                </div>
            </div>
            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Jenis</label>
                <div class="w-100">
                    <span>*Pilih jenis manuskrip anda</span>
                    <div class="form-control" style="background-color: #efefef">Manuskrip {{ $karya->jenisKarya->nama ?? '-' }}</div>
                </div>
            </div>
            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Identitas</label>
                <div class="w-100">
                    <span>*Masukkan NIM/NIP/Nomor Identitas Anda</span>
                    <input type="number" name="identifier" class="form-control" required
                        value="{{ old('identifier', $karya->identifier) }}">

                </div>
            </div>

            <div class="mb-3 d-flex flex-column flex-md-row">
                <label class="w-md-50 fw-bold" style="font-size: 18px; width: 20%">Cakupan</label>
                <div class="w-100">
                    <span>Masukan Cakupan</span>
                    <input type="text" name="coverage" class="form-control" value="{{ old('coverage', $karya->coverage) }}">

                </div>
            </div>
           <div id="file-upload-wrapper">
                <div class="file-upload-group mb-3">
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
                         <label class="w-md-50 fw-bold" style=" width: 20%">File</label>
                        <div class="w-100 d-flex gap-2">
                            <div class="flex-grow-1">
                                <span>Unggah Manuskrip Anda</span>
                                <span style="font-size: 12px"> *MAX FILE 15MB </span>
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

@endsection
