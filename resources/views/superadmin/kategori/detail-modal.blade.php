<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="bi bi-info-circle"></i> Detail Kategori
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="detail-group">
                    <label class="detail-label">Nama Kategori</label>
                    <p class="detail-value" id="detailNama">-</p>
                </div>
                <div class="detail-group">
                    <label class="detail-label">Tanggal Dibuat</label>
                    <p class="detail-value" id="detailCreated">-</p>
                </div>
                <div class="detail-group mb-0">
                    <label class="detail-label">Terakhir Diperbarui</label>
                    <p class="detail-value" id="detailUpdated">-</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.modal-content {
    border: none;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
}

.modal-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: var(--white);
    border-radius: var(--radius-xl) var(--radius-xl) 0 0;
    padding: var(--space-5);
}

.modal-header .modal-title {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-weight: 600;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.modal-body {
    padding: var(--space-6);
}

.detail-group {
    margin-bottom: var(--space-5);
}

.detail-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-600);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: var(--space-2);
}

.detail-value {
    font-size: 1rem;
    font-weight: 500;
    color: var(--gray-900);
    margin: 0;
}

.modal-footer {
    padding: var(--space-5);
    border-top: 1px solid var(--gray-200);
}

.btn-secondary {
    background: var(--gray-600);
    color: var(--white);
    border: none;
    padding: var(--space-3) var(--space-5);
    border-radius: var(--radius-md);
    font-weight: 500;
}

.btn-secondary:hover {
    background: var(--gray-700);
    color: var(--white);
}
</style>
