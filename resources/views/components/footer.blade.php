<!-- resources/views/components/footer.blade.php -->
<style>
    .footer-title-custom {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 1.65rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        white-space: nowrap;
    }
    
    .footer-subtitle-custom {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        white-space: nowrap;
    }

    @media (max-width: 1199.98px) {
        .footer-title-custom {
            font-size: 1.4rem;
            white-space: normal;
            text-align: center;
        }
        .footer-subtitle-custom {
            font-size: 0.85rem;
            white-space: normal;
            text-align: center;
        }
    }

    @media (max-width: 767.98px) {
        .footer-title-custom {
            font-size: 1.35rem;
        }
        .footer-subtitle-custom {
            font-size: 0.85rem;
        }
    }
</style>

<footer class="footer-modern text-white py-5 mt-auto">
    <div class="container-fluid footer-container-custom">
        <div class="row row-cols-1 row-cols-md-auto text-center text-md-start py-4 gx-4 gy-4 d-flex justify-content-between w-100">
            <div class="col-md px-3">
                <div class="footer-brand mb-3">
                    <h2 class="footer-title-custom">Manuskrip Digital Pesantren</h2>
                    <p class="footer-subtitle-custom mb-0">Pesantren Mahasiswa Al-Hikam Malang</p>
                </div>
            </div>

            <div class="d-none d-xl-flex align-items-stretch justify-content-center px-2">
                <div class="footer-divider"></div>
            </div>

            <div class="col-md px-3">
                <div class="footer-logo-container">
                    <img src="{{ asset('assets/img/logo-title.png') }}" alt="Logo" class="img-fluid footer-logo">
                </div>
            </div>

            <div class="d-none d-xl-flex align-items-stretch justify-content-center px-2">
                <div class="footer-divider"></div>
            </div>

            <div class="col-md px-3">
                <h6 class="footer-section-title">Kontak</h6>
                <div class="footer-contact">
                    <p class="footer-contact-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>Jl. Cengger Ayam No.25, Lowokwaru, Malang</span>
                    </p>
                    <p class="footer-contact-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>(0341) 475387</span>
                    </p>
                    <p class="footer-contact-item mb-0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <span>alhikam@gmail.com</span>
                    </p>
                </div>
            </div>

            <div class="d-none d-xl-flex align-items-stretch justify-content-center px-2">
                <div class="footer-divider"></div>
            </div>

            <div class="col-md px-3">
                <h6 class="footer-section-title">Navigasi</h6>
                <ul class="list-unstyled footer-nav">
                    <li><a href="{{ route('guide') }}" class="footer-link">Panduan Unggah</a></li>
                    <li><a href="{{ route('about') }}" class="footer-link">Tentang Kami</a></li>
                    <li><a href="{{ route('faq') }}" class="footer-link">FAQ</a></li>
                    <li><a href="{{ route('activity') }}" class="footer-link">Aktivitas</a></li>
                </ul>
            </div>

            <div class="d-none d-xl-flex align-items-stretch justify-content-center px-2">
                <div class="footer-divider"></div>
            </div>

            <div class="col-md px-3">
                <h6 class="footer-section-title">Temukan Kami</h6>
                <div class="footer-social-links">
                    <a href="https://www.instagram.com/alhikam_malang" class="footer-social-link" target="_blank" rel="noopener">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                        <span>@alhikam_malang</span>
                    </a>
                    <a href="https://www.youtube.com/c/AlhikamTV" class="footer-social-link" target="_blank" rel="noopener">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/>
                            <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/>
                        </svg>
                        <span>Al-Hikam TV</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="footer-bottom text-center py-3">
    <small>&copy; {{ date('Y') }} Pesantren Mahasiswa Al-Hikam Malang. All rights reserved.</small>
</div>
