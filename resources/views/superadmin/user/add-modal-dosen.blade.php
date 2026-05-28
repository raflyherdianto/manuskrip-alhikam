<!-- Add Dosen Modal -->
<div class="modal fade" id="addDosenModal" tabindex="-1" aria-labelledby="addDosenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDosenModalLabel">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Dosen
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addDosenForm">
                <input type="hidden" id="addDosenNim" value="">
                <input type="hidden" id="addDosenAngkatan" value="">
                <input type="hidden" id="addDosenVerified" value="1">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addDosenName" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addDosenName" required>
                    </div>
                    <div class="mb-3">
                        <label for="addDosenNip" class="form-label">NIP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addDosenNip" required>
                    </div>
                    <div class="mb-3">
                        <label for="addDosenEmail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="addDosenEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="addDosenPassword" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="addDosenPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="addDosenJenisKelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="addDosenJenisKelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addDosenJurusan" class="form-label">Jurusan</label>
                        <select class="form-select" id="addDosenJurusan">
                            <option value="">Pilih Jurusan</option>
                            @foreach(\App\Models\Jurusan::orderBy('nama')->get() as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addDosenProdi" class="form-label">Program Studi</label>
                        <select class="form-select" id="addDosenProdi" disabled>
                            <option value="">Pilih Jurusan Dahulu</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
