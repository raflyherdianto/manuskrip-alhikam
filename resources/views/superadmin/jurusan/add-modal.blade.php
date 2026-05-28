<!-- Add Modal -->
<div class="modal fade" id="addJurusanModal" tabindex="-1" aria-labelledby="addJurusanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJurusanModalLabel">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Jurusan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addJurusanForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addJurusanNama" class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addJurusanNama" required>
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
