<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="bi bi-pencil-square"></i> Edit Status Manuskrip
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editKaryaId">
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="" style="display: none;">Pilih Status</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Terpublish">Terpublish</option>
                            <option value="Arsip">Diarsipkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editKeterangan" class="form-label">Catatan Revisi</label>
                        <textarea class="form-control" id="editKeterangan" name="keterangan" rows="3" placeholder="Masukkan catatan revisi (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: var(--space-2);
}

.form-control, .form-select {
    padding: var(--space-3) var(--space-4);
    border: 2px solid var(--gray-300);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    transition: var(--transition);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.15);
    outline: none;
}

.btn-primary {
    background: var(--primary);
    color: var(--white);
    border: none;
    padding: var(--space-3) var(--space-5);
    border-radius: var(--radius-md);
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
}

.btn-primary:hover {
    background: var(--primary-dark);
    color: var(--white);
}
</style>
