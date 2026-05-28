@extends('layouts.app')

@section('content')
<div class="homepage-wrapper">
    <!-- Hero Section with Modern Education Theme -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-8 mx-auto text-center hero-content">
                    <div class="hero-badge mb-4">
                        <span class="badge-icon">📚</span>
                        <span>Platform Digitalisasi Manuskrip Pesantren</span>
                    </div>
                    <h1 class="hero-title mb-4" data-aos="fade-up">
                        Selamat Datang
                    </h1>
                    <p class="hero-subtitle mb-5" data-aos="fade-up" data-aos-delay="100">
                        Di Platform Digital Manuskrip Pesantren untuk menjaga keberlanjutan warisan intelektual Islam. <br>Temukan, pelajari dan lestarikan berbagai manuskrip sebagai sumber ilmu dan inspirasi
                    </p>

                    <!-- Action Buttons -->
                    <div class="hero-actions" data-aos="fade-up" data-aos-delay="200">
                        @auth
                            @if(Auth::user()->verified)
                                <a href="{{ route('activity') }}" class="btn-primary-custom btn-lg">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/>
                                    </svg>
                                    <span>Unggah Manuskrip</span>
                                </a>
                            @else
                                <a href="{{ route('activity.profile') }}" class="btn-primary-custom btn-lg">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/>
                                    </svg>
                                    <span>Unggah Manuskrip</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-primary-custom btn-lg">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/>
                                </svg>
                                <span>Unggah Manuskrip</span>
                            </a>
                        @endauth
                        <a href="{{ route('jelajahi') }}" class="btn-secondary-custom btn-lg">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.35-4.35"/>
                            </svg>
                            <span>Jelajahi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </section>

    <!-- School Banner Section -->
    <section class="school-banner-section py-5">
        <div class="container">
            <div class="school-banner-wrapper" data-aos="fade-up">
                <img src="{{ asset('assets/img/banner.jpg') }}" alt="Pesantren Mahasiswa Al-Hikam Malang" class="school-banner-img">
            </div>
        </div>
    </section>

    <!-- Manuskrip Terbaru Section -->
    <section class="karya-section py-5">
        <div class="container-fluid px-4">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <span class="section-badge">Terbaru</span>
                <h2 class="section-title">Manuskrip Terbaru</h2>
                <p class="section-subtitle">Eksplorasi manuskrip-manuskrip terbaik dari Pesantren Mahasiswa Al-Hikam Malang</p>
            </div>

            <!-- Carousel Container -->
            <div class="karya-carousel-wrapper position-relative" data-aos="fade-up" data-aos-delay="100">
                <div class="karya-carousel" id="karyaCarousel">
                    <div class="karya-track" id="karyaTrack">
                        @forelse($karyaTerbaru as $karya)
                            @php
                                // Get first file for format
                                $firstFile = $karya->files->first();
                                $format = $firstFile ? strtoupper($firstFile->format) : 'FILE';

                                // Format author name - only 2 words, if more then abbreviate
                                $authorName = $karya->user->name ?? 'Unknown';
                                $nameParts = explode(' ', $authorName);
                                if (count($nameParts) > 2) {
                                    $displayName = $nameParts[0] . ' ' . $nameParts[1];
                                    // Abbreviate remaining parts
                                    $remaining = array_slice($nameParts, 2);
                                    $abbreviation = implode('', array_map(fn($part) => strtoupper(substr($part, 0, 1)), $remaining));
                                    $displayName .= ' ' . $abbreviation;
                                } else {
                                    $displayName = $authorName;
                                }

                                // Get angkatan and jurusan
                                $angkatan = $karya->user->angkatan ?? '-';
                                $jurusanNama = $karya->user->jurusan->nama ?? '-';

                                // Format date
                                $formattedDate = \Carbon\Carbon::parse($karya->date)->locale('id')->isoFormat('D MMMM YYYY');

                                // Generate slug and nim for detail URL
                                $slug = \Illuminate\Support\Str::slug($karya->title);
                                $nim = $karya->user->nim ?? 'unknown';
                                $karyaId = $karya->id;
                            @endphp
                            <div class="karya-card">
                                <div class="karya-card-inner">
                                    <div class="karya-thumbnail" style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; gap: 15px; padding: 20px;">
                                        <img src="{{ asset('assets/img/logo-title.png') }}" alt="Logo" style="height: 60px; width: auto; object-fit: contain;">
                                        <span style="color: #333; font-size: 1.1rem; font-weight: 600; text-align: left; line-height: 1.3;">Manuskrip Digital<br>Pesantren Al-Hikam</span>
                                        <div class="karya-badge">{{ $format }}</div>
                                    </div>
                                    <div class="karya-content">
                                        <div class="karya-meta">
                                            <span class="karya-author">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                                    <circle cx="12" cy="7" r="4"/>
                                                </svg>
                                                {{ $displayName }}
                                            </span>
                                            <span class="karya-kelas-jurusan">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                                </svg>
                                                {{ $angkatan }} - {{ $jurusanNama }}
                                            </span>
                                            <span class="karya-date">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                                </svg>
                                                {{ $formattedDate }}
                                            </span>
                                        </div>
                                        <h3 class="karya-title">{{ $karya->title }}</h3>
                                        <div class="karya-description">
                                            <p class="description-text">
                                                {{ Str::limit(strip_tags($karya->description), 150) }}
                                                @if(strlen(strip_tags($karya->description)) > 150)
                                                    <span class="read-more" onclick="toggleDescription(this)">Read more</span>
                                                @endif
                                            </p>
                                        </div>
                                        <a href="{{ route('karya.detail', [$karyaId, $nim, $slug]) }}" class="btn-view-karya">
                                            <span>Lihat Detail</span>
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M5 12h14M12 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="karya-card">
                                <div class="karya-card-inner">
                                    <div class="karya-thumbnail" style="background-color: #6c757d; display: flex; align-items: center; justify-content: center;">
                                        <span style="color: white; font-size: 1.2rem; font-weight: 600;">No Preview</span>
                                        <div class="karya-badge">-</div>
                                    </div>
                                    <div class="karya-content">
                                        <div class="karya-meta">
                                            <span class="karya-author">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                                    <circle cx="12" cy="7" r="4"/>
                                                </svg>
                                                -
                                            </span>
                                            <span class="karya-kelas-jurusan">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                                </svg>
                                                - -
                                            </span>
                                            <span class="karya-date">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                                </svg>
                                                -
                                            </span>
                                        </div>
                                        <h3 class="karya-title">Belum Ada Manuskrip</h3>
                                        <div class="karya-description">
                                            <p class="description-text">
                                                Belum ada manuskrip yang dipublikasikan
                                            </p>
                                        </div>
                                        <a href="#" class="btn-view-karya" style="pointer-events: none; opacity: 0.5;">
                                            <span>Lihat Detail</span>
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M5 12h14M12 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control carousel-control-prev-custom" id="prevBtn" onclick="moveCarousel('prev')">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>
                <button class="carousel-control carousel-control-next-custom" id="nextBtn" onclick="moveCarousel('next')">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>

                <!-- Carousel Indicators -->
                <div class="carousel-indicators-custom" id="carouselIndicators"></div>
            </div>
        </div>
    </section>
</div>

@endsection
