<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="bi bi-info-circle"></i>
                    Detail User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label>Nama Lengkap</label>
                            <p id="detailName"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label>Email</label>
                            <p id="detailEmail"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" id="detailNimRow">
                        <div class="detail-group">
                            <label>NIM</label>
                            <p id="detailNim"></p>
                        </div>
                    </div>
                    <div class="col-md-6" id="detailNipRow">
                        <div class="detail-group">
                            <label>NIP</label>
                            <p id="detailNip"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label>Role</label>
                            <p id="detailRole"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label>Jenis Kelamin</label>
                            <p id="detailJenisKelamin"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label>Angkatan</label>
                            <p id="detailAngkatan"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label>Jurusan</label>
                            <p id="detailJurusan"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" id="detailProdiRow">
                        <div class="detail-group">
                            <label>Program Studi</label>
                            <p id="detailProdi"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label>Status Verifikasi</label>
                            <p id="detailVerified"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label>Tanggal Bergabung</label>
                            <p id="detailCreatedAt"></p>
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
