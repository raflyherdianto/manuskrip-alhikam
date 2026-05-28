@extends('layouts.app')

@section('content')
    <div class="about-page-wrapper">
        <!-- Header Section -->
        <section class="guide-header-section">
            <div class="hero-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="guide-header-content" data-aos="fade-up">
                            <div class="hero-badge mb-4">
                                <span class="badge-icon">ℹ️</span>
                                <span>Tentang Kami</span>
                            </div>
                            <h1 class="guide-title">Manuskrip Digital</h1>
                            <p class="guide-subtitle">Platform digital berbasis web untuk penyimpanan, pengelolaan, dan publikasi manuskrip Pesantren Mahasiswa Al-Hikam Malang</p>
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

        <!-- Main Content -->
        <div class="container py-5">
            <div class="row g-4">
                <!-- Left Column - About Content -->
                <div class="col-lg-7">
                    <div class="content-card">
                        <div class="content-header">
                            <div class="content-header-icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                    <path d="M2 17l10 5 10-5"/>
                                    <path d="M2 12l10 5 10-5"/>
                                </svg>
                            </div>
                            <h2 class="content-title">Tentang Platform</h2>
                        </div>
                        <p class="content-text">
                            Platform Digital Manuskrip Pesantren merupakan website repository berbasis web yang dikembangkan sebagai sarana digitalisasi, pengelolaan, dan pelestarian manuskrip di Pondok Pesantren Mahasiswa Al-Hikam Malang. Website ini bertujuan untuk mendukung keberlanjutan warisan intelektual Islam melalui penyimpanan manuskrip secara digital agar lebih mudah diakses, dikelola, dan dimanfaatkan oleh pengguna.
                        </p>
                        <p class="content-text">
                            Melalui platform ini, pengguna dapat mengunggah manuskrip, menelusuri koleksi yang telah dipublikasikan, serta mengakses informasi manuskrip secara terstruktur menggunakan metadata standar Dublin Core. Pengembangan website ini diharapkan mampu menjadi media preservasi digital yang mendukung pelestarian pengetahuan Islam di lingkungan pesantren mahasiswa.
                        </p>

                        <!-- Team Cards -->
                        <div class="team-section mt-5">
                            <h3 class="team-section-title">Tim Pengembang</h3>

                            <!-- Penulis Card -->
                            <div class="team-card">
                                <div class="team-card-content">
                                    <div class="team-image-wrapper">
                                        <img src="{{ asset('assets/img/pembimbing.png') }}" alt="Penulis" class="team-image">
                                    </div>
                                    <div class="team-info">
                                        <span class="team-role">PENULIS</span>
                                        <h4 class="team-name">Setiawan, S.Sos., M.IP.</h4>
                                        <p class="team-position">Asisten Ahli</p>
                                        <p class="team-department">Program Studi D4 Perpustakaan Digital</p>
                                        <p class="team-institution">Universitas Negeri Malang</p>
                                        <a href="mailto:setiawan@um.ac.id" class="team-email">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                                <polyline points="22,6 12,13 2,6"/>
                                            </svg>
                                            <span>setiawan@um.ac.id</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Contact & Map -->
                <div class="col-lg-5">
                    <!-- Contact Card -->
                    <div class="content-card mb-4">
                        <div class="content-header">
                            <div class="content-header-icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <h2 class="content-title">Informasi Kontak</h2>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <div class="contact-info">
                                <span class="contact-label">Admin</span>
                                <p class="contact-value">Ahmad Rijal Pahlevi</p>
                                <a href="tel:085732741256" class="contact-link">085732741256</a>
                            </div>
                        </div>
                    </div>

                    <!-- Map Card -->
                    <div class="content-card">
                        <div class="content-header">
                            <div class="content-header-icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <h2 class="content-title">Lokasi</h2>
                        </div>
                        <div class="map-wrapper">
                            <iframe
                                title="Lokasi Pesantren"
                                src="https://www.google.com/maps?q=-7.9475484,112.6316872&output=embed"
                                width="100%"
                                height="300"
                                style="border:0; border-radius: var(--radius-md);"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* ========================================
       GUIDE HEADER STYLES - MOBILE FIRST
       ======================================== */

    /* Guide Header Section */
    .guide-header-section {
        position: relative;
        min-height: 50vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #095c3a 0%, #10b981 100%);
        overflow: hidden;
        padding: 3rem 1rem;
    }

    .guide-header-content {
        position: relative;
        z-index: 2;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1.25rem;
        border-radius: 2rem;
        color: #FFFFFF;
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .badge-icon {
        font-size: 1.25rem;
    }

    .guide-title {
        font-family: 'Space Grotesk', 'Inknut Antiqua', serif;
        font-size: clamp(1.75rem, 5vw, 3rem);
        font-weight: 700;
        color: #FFFFFF;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .guide-subtitle {
        font-size: clamp(1rem, 2.5vw, 1.25rem);
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"/></svg>');
        opacity: 0.3;
        z-index: 1;
    }

    .hero-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
        z-index: 0;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
    }

    .shape-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
    }

    .shape-2 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
    }

    .shape-3 {
        width: 150px;
        height: 150px;
        top: 50%;
        left: 10%;
    }

    /* About Page Styles */
    .about-page-wrapper {
        min-height: 100vh;
        background: #F7FAFC;
        padding-bottom: 3rem;
    }

    /* Remove old page-header-section styles */

    /* Content Card */
    .content-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        height: auto;
    }

    .content-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--primary-light);
    }

    .content-header-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .content-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
        font-family: var(--font-heading);
    }

    .content-text {
        font-size: 1.05rem;
        line-height: 1.8;
        color: var(--dark-gray);
        margin-bottom: 1rem;
        text-align: justify;
    }

    /* Team Section */
    .team-section {
        margin-top: 2rem;
    }

    .team-section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1.5rem;
        font-family: var(--font-heading);
    }

    .team-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: all var(--transition-md);
    }

    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .team-card-content {
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
    }

    .team-card-content.reverse {
        flex-direction: row-reverse;
    }

    .team-image-wrapper {
        flex-shrink: 0;
    }

    .team-image {
        width: 120px;
        height: 150px;
        object-fit: cover;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
    }

    .team-info {
        flex: 1;
    }

    .team-role {
        display: inline-block;
        background: var(--primary-color);
        color: var(--white);
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .team-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0.5rem 0;
    }

    .team-position,
    .team-department,
    .team-institution {
        font-size: 0.95rem;
        color: var(--gray);
        margin: 0.25rem 0;
    }

    .team-email {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-color);
        text-decoration: none;
        margin-top: 0.5rem;
        font-size: 0.9rem;
        transition: all var(--transition-sm);
    }

    .team-email:hover {
        color: var(--primary-dark);
        transform: translateX(3px);
    }

    /* Contact Section */
    .contact-item {
        display: flex;
        gap: 1rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: var(--radius-md);
        transition: all var(--transition-md);
    }

    .contact-item:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-sm);
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-info {
        flex: 1;
    }

    .contact-label {
        display: block;
        font-size: 0.875rem;
        color: var(--gray);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .contact-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .contact-link {
        display: inline-block;
        color: var(--primary-color);
        text-decoration: none;
        font-size: 0.95rem;
        margin-top: 0.25rem;
        transition: all var(--transition-sm);
    }

    .contact-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Map Wrapper */
    .map-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
    }

    /* Responsive Design - Mobile First */
    @media (max-width: 575.98px) {
        .guide-header-section {
            min-height: 40vh;
            padding: 2rem 1rem;
        }

        .content-card {
            padding: 1.5rem;
        }

        .content-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .content-title {
            font-size: 1.25rem;
        }

        .content-text {
            font-size: 1rem;
        }

        .team-card-content {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .team-card-content.reverse {
            flex-direction: column-reverse;
            align-items: center;
            text-align: center;
        }

        .team-info {
            text-align: center !important;
        }

        .team-email {
            justify-content: center;
        }

        .team-image {
            width: 100px;
            height: 130px;
        }

        .map-wrapper iframe {
            height: 250px;
        }

        .contact-item {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }

    /* Tablet */
    @media (min-width: 576px) and (max-width: 991.98px) {
        .team-card-content {
            gap: 1rem;
        }

        .team-image {
            width: 100px;
            height: 130px;
        }

        .map-wrapper iframe {
            height: 250px;
        }
    }
    </style>

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 600,
            once: true,
            offset: 50
        });
    </script>

@endsection
