<!-- Add Mahasiswa Modal -->
<div class="modal fade" id="addMahasiswaModal" tabindex="-1" aria-labelledby="addMahasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMahasiswaModalLabel">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Mahasiswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addMahasiswaForm">
                <input type="hidden" id="addMahasiswaNip" value="">
                <input type="hidden" id="addMahasiswaVerified" value="1">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addMahasiswaName" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addMahasiswaName" required>
                    </div>
                    <div class="mb-3">
                        <label for="addMahasiswaNim" class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addMahasiswaNim" required>
                    </div>
                    <div class="mb-3">
                        <label for="addMahasiswaEmail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="addMahasiswaEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="addMahasiswaPassword" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="addMahasiswaPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="addMahasiswaJenisKelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="addMahasiswaJenisKelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addMahasiswaAngkatan" class="form-label">Angkatan</label>
                        <input type="text" class="form-control" id="addMahasiswaAngkatan" placeholder="Contoh: 2024">
                    </div>
                    <div class="mb-3">
                        <label for="addMahasiswaJurusan" class="form-label">Jurusan</label>
                        <select class="form-select" id="addMahasiswaJurusan" @if(auth()->user()->role === 'admin') disabled @endif>
                            <option value="">Pilih Jurusan</option>
                            @foreach(\App\Models\Jurusan::orderBy('nama')->get() as $jurusan)
                                <option value="{{ $jurusan->id }}" @if(auth()->user()->role === 'admin' && auth()->user()->jurusan_id == $jurusan->id) selected @endif>{{ $jurusan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(auth()->user()->role === 'admin')
                    <input type="hidden" id="addMahasiswaJurusanHidden" value="{{ auth()->user()->jurusan_id }}">
                    @endif
                    <div class="mb-3">
                        <label for="addMahasiswaProdi" class="form-label">Program Studi</label>
                        <select class="form-select" id="addMahasiswaProdi">
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <small class="form-text text-muted">Pilih Jurusan terlebih dahulu</small>
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
