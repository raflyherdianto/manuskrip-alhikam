@extends('layouts.app')

@section('content')
    <div class="m-auto" style="width: 80%">
            <div class="d-flex align-items-center mt-5" style="width:100%; height:50px; background-color: #1F304B; font-family: 'Inknut Antiqua', serif;">
                <div class="d-flex justify-content-center align-items-center text-white mx-auto" style="font-size: 40px; width: 50%; height: 50%;">
                    Aktifitas
                </div>
            </div>
        <!-- Chart Bulanan -->
        <div class="table-responsive-custom">
            <table class="w-100" style="background-color: #D9D9D9; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #000; padding: 8px;">Judul</th>
                        <th style="border: 1px solid #000; padding: 8px;">Kategori</th>
                        <th style="border: 1px solid #000; padding: 8px;">Deskripsi</th>
                        <th style="border: 1px solid #000; padding: 8px;">Kontributor</th>
                        <th style="border: 1px solid #000; padding: 8px;">Keterangan Revisi</th>
                        <th style="border: 1px solid #000; padding: 8px;">Status</th>
                        <th style="border: 1px solid #000; padding: 8px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyas as $karya)
                        <tr>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $karya->title }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $karya->kategori->nama ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ Str::limit($karya->description, 80) }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $karya->pembimbing->name ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $karya->keterangan ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $karya->status }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">
                                <a href="{{ route('karya.show', $karya->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                <form action="{{ route('karya.destroy', $karya->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus manuskrip ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                <a href="{{route('karya.edit',['id' => $karya->id])}}" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="border: 1px solid #000; padding: 8px;">
                                Belum ada manuskrip yang diunggah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

<div class="px-5 mt-3">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
</div>
<style>
    .table-responsive-custom {
    margin-top: 20px;
    overflow-x: auto;
    width: 100%;
}

@media (max-width: 768px) {
    .table-responsive-custom table {
        min-width: 600px;
        display: block;
    }

    .table-responsive-custom th,
    .table-responsive-custom td {
        font-size: 14px;
        white-space: nowrap;
    }
}

</style>

@endsection
