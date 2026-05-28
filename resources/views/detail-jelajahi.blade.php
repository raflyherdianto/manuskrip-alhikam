<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/img/logo-title.png') }}" type="image/png">
    <title>Manuskrip Digital Pesantren - {{ $karya->title }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/homepage.css') }}?v=1.1">

    <style>
        :root {
            --primary: #0d7a50;
            --secondary: #10b981;
            --dark: #2D3748;
            --gray: #718096;
            --light-gray: #F7FAFC;
            --border: #E2E8F0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--light-gray);
            min-height: 100vh;
        }

        .detail-header {
            background: linear-gradient(135deg, #095c3a 0%, #10b981 100%);
            padding: 2rem 0 4rem;
            margin-bottom: -2rem;
            position: relative;
        }

        .detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            text-decoration: none;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }

        .back-button:hover {
            color: rgba(255, 255, 255, 0.8);
            transform: translateX(-5px);
        }

        .detail-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .karya-hero {
            position: relative;
            width: 100%;
            height: 400px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .karya-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .karya-hero.no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #095c3a 0%, #10b981 100%);
            color: white;
            font-size: 3rem;
            font-weight: 600;
        }

        .format-badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: rgba(13, 122, 80, 0.95);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            backdrop-filter: blur(10px);
        }

        .detail-content {
            padding: 2rem;
        }

        .detail-title {
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--light-gray);
            border-radius: 12px;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .meta-label {
            font-size: 0.75rem;
            color: var(--gray);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-value {
            font-size: 0.95rem;
            color: var(--dark);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .meta-value i {
            color: var(--primary);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: var(--primary);
        }

        .description-content {
            line-height: 1.8;
            color: #4a5568;
            margin-bottom: 2rem;
        }

        .files-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            background: var(--light-gray);
            border-radius: 12px;
            border: 2px solid var(--border);
            transition: all 0.3s;
        }

        .file-item:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 99, 255, 0.15);
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .file-icon {
            width: 48px;
            height: 48px;
            background: var(--primary);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .file-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .file-name {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .file-meta {
            font-size: 0.8rem;
            color: var(--gray);
        }

        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }

        .btn-download:hover {
            background: var(--secondary);
            color: white;
            transform: translateY(-2px);
        }

        .info-box {
            background: linear-gradient(135deg, rgba(9, 92, 58, 0.08) 0%, rgba(16, 185, 129, 0.08) 100%);
            border-left: 4px solid var(--primary);
            padding: 1.25rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .info-box-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-box-text {
            color: var(--gray);
            font-size: 0.9rem;
            margin: 0;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .detail-header {
                padding: 1.5rem 0 3rem;
            }

            .karya-hero {
                height: 250px;
            }

            .detail-content {
                padding: 1.5rem;
            }

            .meta-grid {
                grid-template-columns: 1fr;
                padding: 1rem;
            }

            .format-badge {
                top: 1rem;
                right: 1rem;
                padding: 0.4rem 1rem;
                font-size: 0.75rem;
            }

            .file-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .btn-download {
                width: 100%;
                justify-content: center;
            }
        }

        @media (min-width: 769px) {
            .files-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    @include('components.nav')

    <!-- Header -->
    <div class="detail-header">
        <div class="detail-container">
            <a href="{{ url()->previous() }}" class="back-button" data-aos="fade-right">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="detail-container">
        <div class="detail-card" data-aos="fade-up">
            <!-- Hero Image -->
            @php
                $firstFile = $karya->files->first();
                $format = $firstFile ? strtoupper($firstFile->format) : 'FILE';
            @endphp

            <div class="karya-hero" style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; gap: 20px;">
                <img src="{{ asset('assets/img/logo-title.png') }}" alt="Logo" style="height: 100px; width: auto; object-fit: contain;">
                <span style="color: #333; font-size: 1.6rem; font-weight: 600; text-align: left; line-height: 1.3;">Manuskrip Digital<br>Pesantren Al-Hikam</span>
                <div class="format-badge">{{ $format }}</div>
            </div>

            <!-- Content -->
            <div class="detail-content">
                <h1 class="detail-title">{{ $karya->title }}</h1>

                <!-- Meta Information -->
                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-person"></i> Penulis</span>
                        <span class="meta-value">
                            <i class="bi bi-person-circle"></i>
                            {{ $karya->user->name ?? 'Unknown' }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-list-ol"></i> NIM</span>
                        <span class="meta-value">
                            <i class="bi bi-list-ol"></i>
                            {{ $karya->user->nim ?? 'Unknown' }}
                        </span>
                    </div>

                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-mortarboard"></i> Angkatan & Jurusan</span>
                        <span class="meta-value">
                            <i class="bi bi-mortarboard-fill"></i>
                            {{ $karya->user->angkatan ?? '-' }} - {{ $karya->user->jurusan->nama ?? '-' }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-calendar"></i> Tanggal</span>
                        <span class="meta-value">
                            <i class="bi bi-calendar-check"></i>
                            {{ \Carbon\Carbon::parse($karya->date)->locale('id')->isoFormat('D MMMM YYYY') }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-filter-square"></i> Jenis Manuskrip</span>
                        <span class="meta-value">
                            <i class="bi bi-filter-square-fill"></i>
                            {{ $karya->jenisKarya->nama ?? '-' }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-book"></i> Kategori</span>
                        <span class="meta-value">
                            <i class="bi bi-book-fill"></i>
                            {{ $karya->kategori->nama ?? '-' }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-person-badge"></i> Pembimbing</span>
                        <span class="meta-value">
                            <i class="bi bi-person-badge-fill"></i>
                            {{ $karya->pembimbing->name ?? '-' }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-globe"></i> Bahasa</span>
                        <span class="meta-value">
                            <i class="bi bi-translate"></i>
                            {{ $karya->language->nama ?? '-' }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-building"></i> Penerbit</span>
                        <span class="meta-value">
                            <i class="bi bi-building-fill"></i>
                            Pesantren Mahasiswa Al-Hikam Malang
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label"><i class="bi bi-eye"></i> Hak Akses</span>
                        <span class="meta-value">
                            <i class="bi bi-eye-fill"></i>
                            {{ $karya->rights ?? '-' }}
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <div class="section-title">
                    <i class="bi bi-file-text"></i>
                    <span>Deskripsi</span>
                </div>
                <div class="description-content">
                    {!! $karya->description !!}
                </div>

                <!-- Hubungan -->
                @if($karya->relation)
                <div class="info-box">
                    <div class="info-box-title">
                        <i class="bi bi-link-45deg"></i>
                        Hubungan
                    </div>
                    <p class="info-box-text">{{ $karya->relation }}</p>
                </div>
                @endif

                <!-- Cakupan -->
                @if($karya->coverage)
                <div class="info-box">
                    <div class="info-box-title">
                        <i class="bi bi-globe2"></i>
                        Cakupan
                    </div>
                    <p class="info-box-text">{{ $karya->coverage }}</p>
                </div>
                @endif

                <!-- Additional Info -->
                @if($karya->source)
                <div class="info-box">
                    <div class="info-box-title">
                        <i class="bi bi-info-circle-fill"></i>
                        Sumber
                    </div>
                    <p class="info-box-text">{{ $karya->source }}</p>
                </div>
                @endif

                <!-- Files -->
                @if($karya->files->count() > 0)
                <div class="section-title">
                    <i class="bi bi-files"></i>
                    <span>File Manuskrip</span>
                </div>
                <div class="files-grid">
                    @foreach($karya->files as $file)
                        <div class="file-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="file-info">
                                <div class="file-icon">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div class="file-details">
                                    <div class="file-name">{{ strtoupper($file->format) }} File</div>
                                    <div class="file-meta">
                                        <i class="bi bi-hdd"></i> {{ number_format($file->size / 1024, 2) }} KB
                                    </div>
                                </div>
                            </div>
                            @auth
                                <a href="{{ route('file.download', basename($file->file_path)) }}" class="btn-download" target="_blank">
                                    <i class="bi bi-eye"></i>
                                    <span>Lihat Manuskrip</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-download" onclick="sessionStorage.setItem('karya_intended', '{{ url()->current() }}')">
                                    <i class="bi bi-eye"></i>
                                    <span>Lihat Manuskrip</span>
                                </a>
                            @endauth
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    @include('components.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>
