@extends('layouts.app')

@section('content')
<div class="homepage-wrapper">
    <!-- Guide Header Section -->
    <section class="guide-header-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="guide-header-content" data-aos="fade-up">
                        <div class="hero-badge mb-4">
                            <span class="badge-icon">📋</span>
                            <span>Panduan Lengkap</span>
                        </div>
                        <h1 class="guide-title">Panduan Unggah Manuskrip</h1>
                        <p class="guide-subtitle">Ikuti langkah-langkah berikut untuk mengunggah manuskrip Anda</p>
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

    <!-- Guide Content Section -->
    <section class="guide-content-section py-5">
        <div class="container px-3 px-sm-4">
            <div class="row g-4 justify-content-center">
                <!-- Step 1 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="guide-card" data-aos="fade-up" data-aos-delay="0">
                        <div class="guide-number">1</div>
                        <div class="guide-card-content">
                            Setelah masuk ke halaman website, pengguna dapat memilih menu Unggah Manuskrip atau Jelajahi Manuskrip sesuai kebutuhan.
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="guide-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="guide-number">2</div>
                        <div class="guide-card-content">
                            Klik menu Unggah Manuskrip apabila pengguna ingin mengunggah atau mempublikasikan manuskrip ke dalam sistem repository pesantren.
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="guide-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="guide-number">3</div>
                        <div class="guide-card-content">
                            Sebelum melakukan unggah, pengguna diwajibkan login terlebih dahulu menggunakan akun yang telah terdaftar pada sistem.
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="guide-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="guide-number">4</div>
                        <div class="guide-card-content">
                            Setelah berhasil login, pengguna dapat mengisi seluruh metadata pada formulir unggah manuskrip secara lengkap.
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="guide-card" data-aos="fade-up" data-aos-delay="0">
                        <div class="guide-number">5</div>
                        <div class="guide-card-content">
                            Unggah file manuskrip dalam format digital (PDF) sesuai ketentuan yang telah ditetapkan, kemudian periksa kembali kesesuaian data dan file.
                        </div>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="guide-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="guide-number">6</div>
                        <div class="guide-card-content">
                            Klik tombol Kirim Manuskrip untuk mengirimkan data ke sistem. Manuskrip yang diunggah akan masuk ke tahap persetujuan oleh admin dan publikasi oleh superadmin.
                        </div>
                    </div>
                </div>

                <!-- Step 7 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="guide-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="guide-number">7</div>
                        <div class="guide-card-content">
                            Pengguna dapat memantau status manuskrip melalui menu aktivitas. Jika manuskrip memerlukan revisi, pengguna dapat melakukan perbaikan dan melakukan unggah ulang.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center mt-5">
                <a href="{{ url()->previous() }}" class="btn-secondary-custom btn-lg">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </section>
</div>

<style>
/* ========================================
   GUIDE PAGE STYLES - MOBILE FIRST
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

/* Decorative Elements */
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

/* Guide Content Section */
.guide-content-section {
    background-color: #F7FAFC;
    min-height: 50vh;
    padding-bottom: 4rem !important;
}

/* Guide Card */
.guide-card {
    position: relative;
    background: #FFFFFF;
    border-radius: 1rem;
    padding: 2.5rem 1.5rem 1.5rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    min-height: 180px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.guide-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(13, 122, 80, 0.2);
}

.guide-number {
    position: absolute;
    top: -15px;
    left: -10px;
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #0d7a50 0%, #095c3a 100%);
    color: #FFFFFF;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
    box-shadow: 0 4px 12px rgba(13, 122, 80, 0.4);
    z-index: 1;
}

.guide-card-content {
    font-size: 1rem;
    line-height: 1.6;
    color: #2D3748;
    text-align: left;
}

.btn-secondary-custom {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #FFFFFF;
    color: #4A5568;
    border: 1px solid #E2E8F0;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.btn-secondary-custom:hover {
    background: #F7FAFC;
    color: #2D3748;
    border-color: #CBD5E0;
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 575.98px) {
    .guide-header-section {
        min-height: 40vh;
        padding: 2rem 1rem;
    }

    .guide-content-section .container {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .guide-content-section .row {
        margin-left: 0;
        margin-right: 0;
    }

    .guide-card {
        min-height: 160px;
        padding: 2rem 1.25rem 1.25rem;
        margin-left: auto;
        margin-right: auto;
        max-width: 90%;
    }

    .guide-number {
        width: 38px;
        height: 38px;
        font-size: 1.1rem;
        top: -12px;
        left: -8px;
    }

    .guide-card-content {
        font-size: 0.95rem;
    }

    .btn-secondary-custom {
        padding: 0.75rem 1.5rem !important;
        font-size: 1rem !important;
    }
}

@media (min-width: 576px) and (max-width: 767.98px) {
    .guide-card {
        min-height: 170px;
    }
}

@media (min-width: 768px) and (max-width: 991.98px) {
    .guide-card {
        min-height: 180px;
    }
}

@media (min-width: 992px) {
    .guide-content-section {
        padding-top: 4rem !important;
    }

    .guide-card {
        min-height: 200px;
    }
}

/* Animation - fade up effect */
[data-aos="fade-up"] {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

[data-aos="fade-up"].aos-animate {
    opacity: 1;
    transform: translateY(0);
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
