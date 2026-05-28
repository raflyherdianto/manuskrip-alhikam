<!-- Add Modal -->
<div class="modal fade" id="addLanguageModal" tabindex="-1" aria-labelledby="addLanguageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLanguageModalLabel">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Bahasa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addLanguageForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addLanguageNama" class="form-label">Nama Bahasa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addLanguageNama" required>
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
