<!-- Add Modal -->
<div class="modal fade" id="addJenisKaryaModal" tabindex="-1" aria-labelledby="addJenisKaryaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJenisKaryaModalLabel">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Jenis Manuskrip
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addJenisKaryaForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addJenisKaryaNama" class="form-label">Nama Jenis Manuskrip <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addJenisKaryaNama" required>
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
