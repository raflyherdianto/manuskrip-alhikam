<!-- Upload Karya Modal -->
<div class="modal fade" id="uploadKaryaModal" tabindex="-1" aria-labelledby="uploadKaryaModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadKaryaModalLabel">
                    <i class="bi bi-cloud-upload me-2"></i>Unggah Manuskrip Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadKaryaForm" action="{{ route('karya.store.activity') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Nama User (Disabled) -->
                        <div class="col-md-6 mb-3">
                            <label for="user_name" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" id="user_name" class="form-control" value="{{ Auth::user()->name }}" disabled>
                        </div>

                        <!-- NIM (Disabled) -->
                        <div class="col-md-6 mb-3">
                            <label for="user_nim" class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" id="user_nim" class="form-control" value="{{ Auth::user()->nim ?? '-' }}" disabled>
                        </div>
                    </div>

                    <!-- Hidden user_id -->
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                        <!-- buatkan info tambahkan padding -->
                        <div class="form-text" style="padding-bottom: 0.5rem;">Tulis judul lengkap manuskrip anda.</div>
                        <input type="text" class="form-control" id="title" name="title" required placeholder="Contoh: Digitalisasi Kitab Fathul Mu'in Bab Shalat">
                    </div>

                    <!-- Jenis Karya Dropdown with Manual Input -->
                    <div class="mb-3">
                        <label for="jenis_karya" class="form-label">Jenis Manuskrip <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Pilih jenis manuskrip yang sesuai atau tambahkan manual jika tidak ada.</div>
                        <select class="form-select" id="jenis_karya" name="jenis_karya_id">
                            <option value="">Pilih Jenis Manuskrip</option>
                            @foreach($jenisKaryas as $jenisKarya)
                                <option value="{{ $jenisKarya->id }}">{{ $jenisKarya->nama }}</option>
                            @endforeach
                            <option value="manual_input">+ Tambahkan Manual</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="jenis_karya_manual" name="jenis_karya_manual" placeholder="Masukkan jenis manuskrip baru">
                    </div>

                    <!-- Kategori Input with Autocomplete -->
                    <div class="mb-3">
                        <label for="kategori_input" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Ketik kata kunci atau tema manuskrip. Pilih dari daftar jika ada yang cocok atau masukkan yang baru.</div>
                        <div class="position-relative">
                            <input type="text" class="form-control" id="kategori_input" name="kategori_input" placeholder="Ketik kategori manuskrip..." autocomplete="off" required>
                            <input type="hidden" id="kategori_id" name="kategori_id" value="">
                            <input type="hidden" id="kategori_manual" name="kategori_manual" value="">
                            <div id="kategori_suggestions" class="autocomplete-suggestions"></div>
                        </div>
                    </div>

                    <!-- Description with Text Editor -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Jelaskan isi manuskrip secara singkat.</div>
                        <div id="editor" style="height: 200px; border: 1px solid #ced4da; border-radius: 0.25rem;"></div>
                        <textarea name="description" id="description" class="d-none"></textarea>
                    </div>

                    <!-- Source -->
                    <div class="mb-3">
                        <label for="source" class="form-label">Sumber <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Sebutkan sumber inspirasi atau referensi manuskrip (jika ada).</div>
                        <input type="text" class="form-control" id="source" name="source" required placeholder="Contoh: Diadaptasi dari Perpustakaan Kuno Pesantren Al-Hikam, Disalin dari naskah asli tahun 1890, dll">
                    </div>

                    <!-- Date -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Isi tanggal saat manuskrip diunggah.</div>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <!-- Penerbit hanya tampilan saja tanpa input (Disabled) -->
                    <div class="mb-3">
                        <label for="penerbit" class="form-label">Penerbit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="penerbit" value="Pesantren Mahasiswa Al-Hikam Malang" disabled>
                    </div>

                    <!-- Pembimbing (Admin) -->
                    <div class="mb-3">
                        <label for="pembimbing_id" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Pilih nama penulis atau pembimbing manuskrip.</div>
                        <select class="form-select" id="pembimbing_id" name="pembimbing_id" required>
                            <option value="">Pilih Pembimbing</option>
                            @foreach($pembimbings as $pembimbing)
                                <option value="{{ $pembimbing->id }}">{{ $pembimbing->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rights -->
                    <div class="mb-3">
                        <label for="rights" class="form-label">Hak Akses <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Pilih siapa saja yang dapat melihat manuskrip.</div>
                        <select class="form-select" id="rights" name="rights" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="Semua">Semua</option>
                            <option value="Terbatas">Terbatas</option>
                        </select>
                    </div>

                    <!-- Relation -->
                    <div class="mb-3">
                        <label for="relation" class="form-label">Hubungan <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Jelaskan keterkaitan manuskrip ini dengan manuskrip, proyek, atau kegiatan lain.</div>
                        <input type="text" class="form-control" id="relation" name="relation" required placeholder="Contoh: Bagian dari kajian kitab kuning, Manuskrip ini adalah bagian dari proyek kelas, pameran pondok, atau lomba">
                    </div>

                    <!-- Language -->
                    <div class="mb-3">
                        <label for="language_id" class="form-label">Bahasa <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Pilih bahasa utama yang digunakan dalam manuskrip.</div>
                        <select class="form-select" id="language_id" name="language_id" required>
                            <option value="">Pilih Bahasa</option>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Coverage -->
                    <div class="mb-3">
                        <label for="coverage" class="form-label">Cakupan <span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Sebutkan lokasi, waktu atau ruang lingkup manuskrip.</div>
                        <input type="text" class="form-control" id="coverage" name="coverage" required placeholder="Contoh: Kota Malang, 2026 atau Pesantren Al-Hikam Malang, 2026">
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label for="files" class="form-label">Unggah File (Multiple)<span class="text-danger">*</span></label>
                        <div class="form-text" style="padding-bottom: 0.5rem;">Pilih file manuskrip yang ingin diunggah.</div>
                        <input type="file" class="form-control" id="files" name="files[]" multiple required>
                        <div class="form-text">
                            File manuskrip yang diunggah hanya diperbolehkan dalam format PDF, JPG, PNG, PPT, dan MP4 dengan ukuran file maksimal 15 MB
                        </div>

                        <!-- Upload Progress Bar -->
                        <div id="uploadProgressContainer" class="mt-3" style="display: none;">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">Mengunggah file...</span>
                                <span id="uploadProgressPercent" class="text-muted small">0%</span>
                            </div>
                            <div class="progress" style="height: 20px;">
                                <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                                     role="progressbar"
                                     style="width: 0%;"
                                     aria-valuenow="0"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                            <div id="uploadStatus" class="text-center mt-2 small text-muted"></div>
                        </div>
                    </div>

                    {{-- <!-- Thumbnail Upload -->
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Upload Thumbnail</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept=".jpg,.jpeg,.png">
                        <div class="form-text">
                            Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal 5MB.
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i> Unggah Manuskrip
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Kategori Autocomplete Styles -->
<style>
.autocomplete-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 1050;
    background: #fff;
    border: 1px solid #ced4da;
    border-top: none;
    border-radius: 0 0 0.25rem 0.25rem;
    max-height: 200px;
    overflow-y: auto;
    display: none;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.autocomplete-suggestions.show {
    display: block;
}
.autocomplete-suggestion {
    padding: 10px 12px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.15s ease;
}
.autocomplete-suggestion:last-child {
    border-bottom: none;
}
.autocomplete-suggestion:hover,
.autocomplete-suggestion.active {
    background-color: #f8f9fa;
}
.autocomplete-suggestion .match {
    font-weight: 600;
    color: #1F304B;
}
.autocomplete-new-item {
    background-color: #e7f1ff;
    color: #0d6efd;
    font-style: italic;
}
.autocomplete-new-item:hover {
    background-color: #d0e5ff;
}
</style>

<!-- Kategori Data for Autocomplete -->
<script>
window.kategorisData = @json($kategoris->map(function($s) { return ['id' => $s->id, 'nama' => $s->nama]; }));
</script>
