<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="bi bi-pencil-square"></i> Edit Bahasa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editLanguageId">
                    <div class="mb-3">
                        <label for="editNama" class="form-label">Nama Bahasa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editNama" name="nama" required placeholder="Masukkan nama bahasa">
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

.form-control {
    padding: var(--space-3) var(--space-4);
    border: 2px solid var(--gray-300);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    transition: var(--transition);
}

.form-control:focus {
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
