<!-- Detail Karya Modal -->
<div class="modal fade" id="detailKaryaModal" tabindex="-1" aria-labelledby="detailKaryaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKaryaModalLabel">
                    <i class="bi bi-eye me-2"></i>Detail Manuskrip
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5 class="text-primary" id="detail_title"></h5>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jenis Manuskrip:</label>
                        <p id="detail_jenis_karya" class="mb-0"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kategori:</label>
                        <p id="detail_kategori" class="mb-0"></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Deskripsi:</label>
                        <div id="detail_description" class="border p-3 rounded bg-light"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kontributor:</label>
                        <p id="detail_kontributor" class="mb-0"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pembimbing:</label>
                        <p id="detail_pembimbing" class="mb-0"></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal:</label>
                        <p id="detail_date" class="mb-0"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Bahasa:</label>
                        <p id="detail_language" class="mb-0"></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hak Akses:</label>
                        <p id="detail_rights" class="mb-0"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status:</label>
                        <p id="detail_status" class="mb-0"></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Relasi:</label>
                        <p id="detail_relation" class="mb-0"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Cakupan:</label>
                        <p id="detail_coverage" class="mb-0"></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Sumber:</label>
                        <p id="detail_source" class="mb-0"></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Keterangan Revisi:</label>
                        <p id="detail_keterangan" class="mb-0"></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">File:</label>
                        <div id="detail_files"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
