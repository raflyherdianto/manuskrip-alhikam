<!-- Edit Modal -->
<div class="modal fade" id="editJenisKaryaModal" tabindex="-1" aria-labelledby="editJenisKaryaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJenisKaryaModalLabel">
                    <i class="bi bi-pencil"></i>
                    Edit Jenis Manuskrip
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editJenisKaryaForm">
                <div class="modal-body">
                    <input type="hidden" id="editJenisKaryaId">
                    <div class="mb-3">
                        <label for="editJenisKaryaNama" class="form-label">Nama Jenis Manuskrip <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editJenisKaryaNama" required>
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
