@forelse($karyas as $karya)
    @php
        $firstFile = $karya->files->first();
        $format = $firstFile ? strtoupper($firstFile->format) : 'FILE';

        $authorName = $karya->user->name ?? 'Unknown';
        $nameParts = explode(' ', $authorName);
        if (count($nameParts) > 2) {
            $displayName = $nameParts[0] . ' ' . $nameParts[1];
            $remaining = array_slice($nameParts, 2);
            $abbreviation = implode('', array_map(fn($part) => strtoupper(substr($part, 0, 1)), $remaining));
            $displayName .= ' ' . $abbreviation;
        } else {
            $displayName = $authorName;
        }

        $angkatan = $karya->user->angkatan ?? '-';
        $jurusanNama = $karya->user->jurusan->nama ?? '-';
        $formattedDate = \Carbon\Carbon::parse($karya->date)->locale('id')->isoFormat('D MMMM YYYY');

        // Generate slug from title
        $slug = \Illuminate\Support\Str::slug($karya->title);
        $nim = $karya->user->nim ?? 'unknown';
        $karyaId = $karya->id;
    @endphp
    <div class="karya-item" data-aos="fade-up">
        <div class="karya-thumbnail" style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; gap: 15px; padding: 20px;">
            <img src="{{ asset('assets/img/logo-title.png') }}" alt="Logo" style="height: 60px; width: auto; object-fit: contain;">
            <span style="color: #333; font-size: 1.1rem; font-weight: 600; text-align: left; line-height: 1.3;">Manuskrip Digital<br>Pesantren Al-Hikam</span>
            <div class="karya-badge">{{ $format }}</div>
        </div>

        <div class="karya-content">
            <div class="karya-meta">
                <div class="karya-meta-item">
                    <i class="bi bi-person"></i>
                    <span>{{ $displayName }}</span>
                </div>
                <div class="karya-meta-item">
                    <i class="bi bi-mortarboard"></i>
                    <span>{{ $angkatan }} - {{ $jurusanNama }}</span>
                </div>
                <div class="karya-meta-item">
                    <i class="bi bi-calendar"></i>
                    <span>{{ $formattedDate }}</span>
                </div>
            </div>

            <h3 class="karya-title">{{ $karya->title }}</h3>

            <div class="karya-description">
                {{ Str::limit(strip_tags($karya->description), 120) }}
            </div>

            <a href="{{ route('karya.detail', [$karyaId, $nim, $slug]) }}" class="btn-detail">
                <span>Lihat Detail</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
@empty
    <div class="no-results">
        <i class="bi bi-inbox"></i>
        <h3>Tidak Ada Manuskrip</h3>
        <p>Tidak ada manuskrip yang sesuai dengan filter yang dipilih</p>
    </div>
@endforelse
