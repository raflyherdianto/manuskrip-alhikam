@auth('admin')
@php 
    $admin = auth('admin')->user(); 
    $notifCount = $admin->unreadNotifications->count(); 
@endphp

<div class="p-3 d-flex justify-content-between w-100">
    <div class="fw-bold mx-2" style="font-size: 28px">
        @switch(true)
            @case(Request::is('admin'))
                Beranda
                @break
            @case(Request::is('admin/arsip*'))
                Arsip
                @break
            @case(Request::is('admin/karya*'))
                Karya
                @break
            @case(Request::is('admin/admin/konfirmasi/*/pratinjau*'))
                Pratinjau Karya
                @break
            @case(Request::is('admin/konfirmasi*'))
                Konfirmasi
                @break
            @case(Request::is('admin/publikasi*'))
                Publikasi
                @break
            @default
                Halaman
        @endswitch
    </div>

    <div class="d-flex gap-5 mx-5">
        <!-- Tombol Notifikasi -->
        <button style="width: 33px; position: relative;" data-bs-toggle="modal" data-bs-target="#notifModal">
            <img src="{{ asset('assets/img/notif.png') }}" alt="Notifikasi">
            @if($notifCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
            @endif
        </button>


    </div>
</div>

<!-- Modal Notifikasi -->
<div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="notifModalLabel">📩 Notifikasi Masuk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                @forelse($admin->unreadNotifications as $notification)
                    <a href="{{ url('admin/admin/konfirmasi/' . $notification->data['karya_id'] . '/pratinjau') }}" class="list-group-item list-group-item-action mb-2 border rounded shadow-sm">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 text-primary">
                                🔔 {{ $notification->data['message'] }}
                            </h6>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2"></i>
                        <p class="mt-2 mb-0">Tidak ada notifikasi baru.</p>
                    </div>
                @endforelse
            </div>
            @if($notifCount)
            <div class="modal-footer">
                <form action="{{ route('admin.notifikasi.baca') }}" method="POST" class="ms-auto">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary">Tandai semua sebagai dibaca</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

@endauth

<!-- Pembatas -->
<div style="height: 10px; width: 100%; background-color: #1F304B;"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
