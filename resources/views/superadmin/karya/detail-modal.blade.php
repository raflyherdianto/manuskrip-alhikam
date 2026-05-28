<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="bi bi-info-circle"></i> Detail Manuskrip
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Loading State -->
                <div id="detailLoading" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-3 mb-0">Memuat detail manuskrip...</p>
                </div>

                <div class="row" id="detailContent">
                    <div class="col-md-12">
                        <div class="detail-group">
                            <label class="detail-label">Judul Manuskrip</label>
                            <p class="detail-value" id="detailTitle">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label class="detail-label">Penulis</label>
                            <p class="detail-value" id="detailUser">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label class="detail-label">Jenis Manuskrip</label>
                            <p class="detail-value" id="detailJenisKarya">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label class="detail-label">Kategori</label>
                            <p class="detail-value" id="detailKategori">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label class="detail-label">Pembimbing</label>
                            <p class="detail-value" id="detailPembimbing">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label class="detail-label">Bahasa</label>
                            <p class="detail-value" id="detailLanguage">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label class="detail-label">Status</label>
                            <p class="detail-value" id="detailStatus">-</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="detail-group">
                            <label class="detail-label">Deskripsi</label>
                            <p class="detail-value" id="detailDescription">-</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="detail-group">
                            <label class="detail-label">Tanggal</label>
                            <p class="detail-value" id="detailDate">-</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="detail-group mb-0">
                            <label class="detail-label">File Manuskrip</label>
                            <div id="detailFiles">-</div>
                        </div>
                    </div>
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

.file-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.file-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3);
    background: var(--gray-50);
    border-radius: var(--radius-md);
    border: 1px solid var(--gray-200);
}

.file-icon {
    font-size: 1.5rem;
    color: var(--primary);
}

.file-info {
    flex: 1;
}

.file-name {
    font-weight: 500;
    color: var(--gray-900);
    font-size: 0.875rem;
    margin: 0;
}

.btn-download {
    background: var(--primary);
    color: var(--white);
    border: none;
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-md);
    font-size: 0.75rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    transition: var(--transition);
}

.btn-download:hover {
    background: var(--primary-dark);
    color: var(--white);
}
</style>
