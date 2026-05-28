<!-- Edit Karya Modal -->
<div class="modal fade" id="editKaryaModal" tabindex="-1" aria-labelledby="editKaryaModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
            <div class="modal-header">
                <h5 class="modal-title" id="editKaryaModalLabel">
                    <i class="bi bi-pencil me-2"></i>Edit Manuskrip
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editKaryaForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <!-- Hidden karya_id -->
                    <input type="hidden" name="id" id="edit_karya_id">

                    <!-- Jenis Karya Dropdown with Manual Input -->
                    <div class="mb-3">
                        <label for="edit_jenis_karya" class="form-label">Jenis Manuskrip <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_jenis_karya" name="jenis_karya_id">
                            <option value="">Pilih Jenis Manuskrip</option>
                            @foreach($jenisKaryas as $jenisKarya)
                                <option value="{{ $jenisKarya->id }}">{{ $jenisKarya->nama }}</option>
                            @endforeach
                            <option value="manual_input">+ Tambahkan Manual</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="edit_jenis_karya_manual" name="jenis_karya_manual" placeholder="Masukkan jenis manuskrip baru">
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>

                    <!-- Kategori Dropdown with Manual Input -->
                    <div class="mb-3">
                        <label for="edit_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_kategori" name="kategori_id">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                            <option value="manual_input">+ Tambahkan Manual</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="edit_kategori_manual" name="kategori_manual" placeholder="Masukkan kategori baru">
                    </div>

                    <!-- Description with Text Editor -->
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <div id="edit_editor" style="height: 200px; border: 1px solid #ced4da; border-radius: 0.25rem;"></div>
                        <textarea name="description" id="edit_description" class="d-none"></textarea>
                    </div>

                    <!-- Source -->
                    <div class="mb-3">
                        <label for="edit_source" class="form-label">Sumber</label>
                        <input type="text" class="form-control" id="edit_source" name="source">
                    </div>

                    <!-- Date -->
                    <div class="mb-3">
                        <label for="edit_date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_date" name="date" required>
                    </div>

                    <!-- Pembimbing (Admin) -->
                    <div class="mb-3">
                        <label for="edit_pembimbing_id" class="form-label">Pembimbing <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_pembimbing_id" name="pembimbing_id" required>
                            <option value="">Pilih Pembimbing</option>
                            @foreach($pembimbings as $pembimbing)
                                <option value="{{ $pembimbing->id }}">{{ $pembimbing->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rights -->
                    <div class="mb-3">
                        <label for="edit_rights" class="form-label">Hak Akses <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_rights" name="rights" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="Semua">Semua</option>
                            <option value="Terbatas">Terbatas</option>
                        </select>
                    </div>

                    <!-- Relation -->
                    <div class="mb-3">
                        <label for="edit_relation" class="form-label">Relasi</label>
                        <input type="text" class="form-control" id="edit_relation" name="relation">
                    </div>

                    <!-- Language -->
                    <div class="mb-3">
                        <label for="edit_language_id" class="form-label">Bahasa <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_language_id" name="language_id" required>
                            <option value="">Pilih Bahasa</option>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Coverage -->
                    <div class="mb-3">
                        <label for="edit_coverage" class="form-label">Cakupan</label>
                        <input type="text" class="form-control" id="edit_coverage" name="coverage">
                    </div>

                    <!-- File Upload (Optional) -->
                    <div class="mb-3">
                        <label for="edit_files" class="form-label">Unggah File Baru (Opsional)</label>
                        <input type="file" class="form-control" id="edit_files" name="edit_files[]" multiple>
                        <div class="form-text">
                            Jika mengunggah file baru, file lama akan dihapus dan diganti dengan file baru. File manuskrip yang diunggah hanya diperbolehkan dalam format PDF, JPG, PNG, PPT, dan MP4 dengan ukuran file maksimal 15 MB
                        </div>

                        <!-- Edit Upload Progress Bar -->
                        <div id="editUploadProgressContainer" class="mt-3" style="display: none;">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">Mengunggah file...</span>
                                <span id="editUploadProgressPercent" class="text-muted small">0%</span>
                            </div>
                            <div class="progress" style="height: 20px;">
                                <div id="editUploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                                     role="progressbar"
                                     style="width: 0%;"
                                     aria-valuenow="0"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                            <div id="editUploadStatus" class="text-center mt-2 small text-muted"></div>
                        </div>
                    </div>

                    <!-- Thumbnail Upload (Optional) -->
                    {{-- <div class="mb-3">
                        <label for="edit_thumbnail" class="form-label">Upload Thumbnail Baru (Opsional)</label>
                        <input type="file" class="form-control" id="edit_thumbnail" name="thumbnail" accept=".jpg,.jpeg,.png">
                        <div class="form-text">
                            Kosongkan jika tidak ingin mengubah thumbnail. Format: JPG, JPEG, PNG. Maksimal 5MB.
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
