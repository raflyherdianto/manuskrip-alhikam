@extends('layouts.app')

@section('content')
    <div class="homepage-wrapper">
        <!-- FAQ Header Section -->
        <section class="guide-header-section">
            <div class="hero-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="guide-header-content" data-aos="fade-up">
                            <div class="hero-badge mb-4">
                                <span class="badge-icon">❓</span>
                                <span>FAQ</span>
                            </div>
                            <h1 class="guide-title">Frequently Asked Questions</h1>
                            <p class="guide-subtitle">Temukan jawaban atas pertanyaan yang sering diajukan tentang Platform Digital Manuskrip Pesantren</p>
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

        <!-- FAQ Content -->
        <div class="container py-5">
            <div class="faq-container">
                <!-- FAQ Item 1 -->
                <div class="faq-item">
                    <div class="faq-header">
                        <div class="faq-number">01</div>
                        <h3 class="faq-question">Apa itu platform digital manuskrip pesantren?</h3>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <p>Platform digital manuskrip pesantren adalah website yang digunakan untuk menyimpan, mengelola, dan mempublikasikan manuskrip secara digital sebagai upaya pelestarian warisan intelektual Islam.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item">
                    <div class="faq-header">
                        <div class="faq-number">02</div>
                        <h3 class="faq-question">Siapa yang dapat menggunakan website ini?</h3>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <p>Website ini dapat digunakan oleh mahasiswa, pengelola manuskrip, dan administrator sistem sesuai hak akses masing-masing.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item">
                    <div class="faq-header">
                        <div class="faq-number">03</div>
                        <h3 class="faq-question">Apakah Pengguna harus login untuk mengakses website?</h3>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <p>Pengguna dapat menelusuri daftar manuskrip tanpa login. Namun, untuk mengunggah manuskrip atau melihat file secara lengkap, pengguna perlu login terlebih dahulu.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="faq-item">
                    <div class="faq-header">
                        <div class="faq-number">04</div>
                        <h3 class="faq-question">File apa yang dapat diunggah?</h3>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <p>File manuskrip diunggah dalam format PDF sesuai ketentuan sistem.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item">
                    <div class="faq-header">
                        <div class="faq-number">05</div>
                        <h3 class="faq-question">Bagaimana jika manuskrip belum terpublikasi?</h3>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <p>Manuskrip yang diunggah akan melalui proses verifikasi konten oleh admin dan verifikasi metadata oleh superadmin terlebih dahulu. Jika manuskrip belum sesuai, pengguna dapat melakukan revisi dan mengunggah ulang.</p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="faq-item">
                    <div class="faq-header">
                        <div class="faq-number">06</div>
                        <h3 class="faq-question">Bagaimana cara mencari manuskrip?</h3>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <p>Pengguna dapat menggunakan kolom pencarian berdasarkan kata kunci atau judul, nama pengarang atau menggunakan filter seperti tahun terbit, angkatan mahasiswa, bidang keilmuan, kategori manuskrip, dan jenis manuskrip.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="faq-cta">
                <div class="faq-cta-content">
                    <h3 class="faq-cta-title">Masih ada pertanyaan?</h3>
                    <p class="faq-cta-text">Jangan ragu untuk menghubungi kami jika Anda memerlukan bantuan lebih lanjut</p>
                    <a href="{{ route('about') }}" class="btn-cta-custom">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>Hubungi Kami</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* ========================================
       FAQ PAGE STYLES
       ======================================== */

    /* Guide Header Section - Matching guide page */
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
    }

    /* Hero Badge */
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 2rem;
        font-weight: 600;
        color: #FFFFFF;
        font-size: 0.95rem;
    }

    .badge-icon {
        font-size: 1.25rem;
    }

    /* Hero Overlay */
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    /* Hero Shapes - Decorative elements */
    .hero-shapes {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
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
        right: -50px;
        animation: float 6s ease-in-out infinite;
    }

    .shape-2 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -30px;
        animation: float 8s ease-in-out infinite;
    }

    .shape-3 {
        width: 150px;
        height: 150px;
        top: 50%;
        left: 20%;
        animation: float 7s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    /* FAQ Page Wrapper */
    .homepage-wrapper {
        min-height: 100vh;
        background: #F7FAFC;
    }

    /* FAQ Container */
    .faq-container {
        max-width: 900px;
        margin: 0 auto;
    }

    /* FAQ Item */
    .faq-item {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: all var(--transition-md);
        border-left: 4px solid transparent;
    }

    .faq-item:hover {
        transform: translateX(8px);
        box-shadow: var(--shadow-lg);
        border-left-color: var(--primary-color);
    }

    .faq-header {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        margin-bottom: 1rem;
    }

    .faq-number {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: var(--shadow-sm);
        font-family: var(--font-heading);
    }

    .faq-question {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        padding-top: 0.5rem;
        line-height: 1.4;
    }

    .faq-answer {
        display: flex;
        gap: 1rem;
        margin-left: 65px;
        padding: 1rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: var(--radius-md);
    }

    .faq-icon {
        width: 30px;
        height: 30px;
        background: var(--success-color);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .faq-answer p {
        font-size: 1rem;
        line-height: 1.7;
        color: var(--dark-gray);
        margin: 0;
        text-align: justify;
    }

    /* CTA Section */
    .faq-cta {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: var(--radius-xl);
        padding: 3rem;
        margin: 3rem auto;
        text-align: center;
        box-shadow: var(--shadow-lg);
        max-width: 900px;
    }

    .faq-cta-content {
        color: var(--white);
    }

    .faq-cta-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        font-family: var(--font-heading);
    }

    .faq-cta-text {
        font-size: 1.125rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }

    .btn-cta-custom {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2.5rem;
        background: var(--white);
        color: var(--primary-color);
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 1.125rem;
        text-decoration: none;
        transition: all var(--transition-md);
        box-shadow: var(--shadow-md);
    }

    .btn-cta-custom:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
        background: var(--lighter-gray);
    }

    /* Back Button */
    .btn-back-custom {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background: var(--white);
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: var(--radius-md);
        font-weight: 600;
        text-decoration: none;
        transition: all var(--transition-md);
        box-shadow: var(--shadow-sm);
    }

    .btn-back-custom:hover {
        background: var(--primary-color);
        color: var(--white);
        transform: translateX(-5px);
        box-shadow: var(--shadow-md);
    }

    /* Responsive Design - Mobile First */
    @media (max-width: 575.98px) {
        .guide-header-section {
            min-height: 40vh;
            padding: 2rem 1rem;
        }

        .faq-item {
            padding: 1.5rem;
        }

        .faq-header {
            flex-direction: column;
            gap: 1rem;
        }

        .faq-number {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }

        .faq-question {
            font-size: 1.1rem;
            padding-top: 0;
        }

        .faq-answer {
            margin-left: 0;
            flex-direction: column;
            align-items: flex-start;
        }

        .faq-answer p {
            font-size: 0.95rem;
        }

        .faq-cta {
            padding: 2rem 1.5rem;
        }

        .faq-cta-title {
            font-size: 1.5rem;
        }

        .faq-cta-text {
            font-size: 1rem;
        }

        .btn-cta-custom {
            width: 100%;
            justify-content: center;
        }

        .btn-back-custom {
            width: 100%;
            justify-content: center;
        }
    }

    /* Tablet */
    @media (min-width: 576px) and (max-width: 991.98px) {
        .faq-answer {
            margin-left: 0;
            margin-top: 1rem;
        }
    }
    </style>

@endsection
