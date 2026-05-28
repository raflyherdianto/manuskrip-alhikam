@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>{{ $karya->title }}</h3>
        <div class="bg-white p-3 karya-detail" style="border-top: 20px solid #1F304B">
            <div class="field title">
                <strong>Judul</strong>
                <div>{{ $karya->title }}</div>
            </div>
            <div class="field right">
                <strong>Hak Akses</strong>
                <div>{{ $karya->rights }}</div>
            </div>
            <div class="field subject">
                <strong>Kategori</strong>
                <div>{{ $karya->kategori->nama ?? '-' }}</div>
            </div>
            <div class="field relation">
                <strong>Hubungan</strong>
                <div>{{ $karya->relation }}</div>
            </div>
            <div class="field description">
                <strong>Deskripsi</strong>
                <div>{{ $karya->description }}</div>
            </div>
            <div class="field format">
                <strong>Format</strong>
                <div>{{ $karya->files->first()->format ?? '-' }}</div>
            </div>
            <div class="field creator">
                <strong>Pencipta</strong>
                <div>{{ $karya->creator }}</div>
            </div>
            <div class="field language">
                <strong>Bahasa</strong>
                <div>{{ $karya->language }}</div>
            </div>
            <div class="field publisher">
                <strong>Penerbit</strong>
                <div>{{ $karya->publisher }}</div>
            </div>
            <div class="field identifier">
                <strong>Identitas</strong>
                <div>{{ $karya->identifier }}</div>
            </div>
            <div class="field date">
                <strong>Tanggal</strong>
                <div>{{ $karya->date }}</div>
            </div>
            <div class="field type">
                <strong>Tipe</strong>
                <div>{{ $karya->jenisKarya->nama }}</div>
            </div>
            <div class="field source">
                <strong>Sumber</strong>
                <div>{{ $karya->source }}</div>
            </div>
            <div class="field coverage">
                <strong>Cakupan</strong>
                <div>{{ $karya->coverage }}</div>
            </div>
            <div class="field contributor">
                <strong>Kontributor</strong>
                <div>{{ $karya->contributor }}</div>
            </div>
        </div>

        <div class="bg-white mt-5 py-4 ">
            <div class="text-white mt-4 p-3 fw-bold" style="background-color: #1F304B; font-size: 36px">Dokumen Viewer</div>
            <div class="mt-3">
                @forelse($karya->files as $file)
                    @php
                        $ext = pathinfo($file->file_path, PATHINFO_EXTENSION);
                        $url = route('file.view', $file->id);
                    @endphp

                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        {{-- Tampilkan Gambar --}}
                        <img src="{{ $url }}" alt="Gambar Manuskrip" class="img-fluid rounded mb-3 m-auto" style="max-width: 100%; height: auto;">

                    @elseif (strtolower($ext) === 'pdf')
                        {{-- Tampilkan PDF --}}
                        <iframe src="{{ $url }}" type="application/pdf" width="100%" height="600px" class="mb-3" ></iframe>

                    @elseif (in_array(strtolower($ext), ['mp4', 'webm']))
                        {{-- Tampilkan Video --}}
                        <video controls width="100%" height="auto" class="mb-3 m-auto w-100">
                            <source src="{{ $url }}" type="video/{{ $ext }}">
                            Browser Anda tidak mendukung video ini.
                        </video>

                    @else
                        <p class="mb-3">File tidak dapat ditampilkan. <a href="{{ $url }}" target="_blank">Unduh file</a></p>
                    @endif
                @empty
                    <p>Tidak ada file terkait untuk manuskrip ini.</p>
                @endforelse
            </div>


        </div>
        {{-- Tambahkan field lainnya sesuai kebutuhan --}}
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>

    </div>
    <style>
        .karya-detail {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.field {
    flex: 1 1 100%;
    order: 0; /* Default order */
}

/* Desktop layout */
@media (min-width: 768px) {
    .field {
        flex: 0 0 48%;
    }

    .field.title { order: 1; }
    .field.right { order: 2; }
    .field.subject { order: 3; }
    .field.relation { order: 4; }
    .field.description { order: 5; }
    .field.format { order: 6; }
    .field.creator { order: 7; }
    .field.language { order: 8; }
    .field.publisher { order: 9; }
    .field.identifier { order: 10; }
    .field.date { order: 11; }
    .field.type { order: 12; }
    .field.source { order: 13; }
    .field.coverage { order: 14; }
    .field.contributor { order: 15; }
}

/* Mobile layout */
@media (max-width: 767.98px) {
    .field.title { order: 1; }
    .field.subject { order: 2; }
    .field.description { order: 3; }
    .field.creator { order: 4; }
    .field.publisher { order: 5; }
    .field.date { order: 6; }
    .field.source { order: 7; }
    .field.contributor { order: 8; }
    .field.right { order: 9; }
    .field.relation { order: 10; }
    .field.format { order: 11; }
    .field.language { order: 12; }
    .field.identifier { order: 13; }
    .field.type { order: 14; }
    .field.coverage { order: 15; }
}

    </style>
@endsection
