<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="bi bi-pencil"></i>
                    Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editUserId">
                    <input type="hidden" id="editUserRole">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editName" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="editEmail" required>
                            </div>
                        </div>
                    </div>

                    <!-- NIP for Dosen -->
                    <div class="row" id="editNipRow" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editNip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="editNip">
                            </div>
                        </div>
                    </div>

                    <!-- NIM for Mahasiswa -->
                    <div class="row" id="editNimRow" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editNim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="editNim">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editJenisKelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="editJenisKelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="editAngkatanRow">
                            <div class="mb-3">
                                <label for="editAngkatan" class="form-label">Angkatan</label>
                                <input type="text" class="form-control" id="editAngkatan" placeholder="Contoh: 2024">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6" id="editJurusanContainer">
                            <div class="mb-3">
                                <label for="editJurusan" class="form-label">Jurusan</label>
                                <select class="form-select" id="editJurusan">
                                    <option value="">Pilih Jurusan</option>
                                    @foreach(\App\Models\Jurusan::orderBy('nama')->get() as $jurusan)
                                        <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="editJurusanHidden" value="">
                        <div class="col-md-6" id="editProdiRow">
                            <div class="mb-3">
                                <label for="editProdi" class="form-label">Program Studi</label>
                                <select class="form-select" id="editProdi">
                                    <option value="">Pilih Program Studi</option>
                                </select>
                                <small class="form-text text-muted">Pilih Jurusan terlebih dahulu</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editVerified" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                                <select class="form-select" id="editVerified" required>
                                    <option value="1">Terverifikasi</option>
                                    <option value="0">Belum Terverifikasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="editPassword" placeholder="Kosongkan jika tidak ingin mengubah">
                                <small class="text-muted">Minimal 8 karakter</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editPasswordConfirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="editPasswordConfirmation" placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
