// ========================================
// CAROUSEL FUNCTIONALITY WITH AUTO-SCROLL
// ========================================

let currentIndex = 0;
let autoScrollInterval;
const SCROLL_INTERVAL = 3500; // Auto-scroll setiap 3.5 detik

document.addEventListener('DOMContentLoaded', function() {
    initializeCarousel();
    startAutoScroll();

    // Pause auto-scroll when hovering over carousel
    const carouselWrapper = document.querySelector('.karya-carousel-wrapper');
    if (carouselWrapper) {
        carouselWrapper.addEventListener('mouseenter', stopAutoScroll);
        carouselWrapper.addEventListener('mouseleave', startAutoScroll);
    }
});

function initializeCarousel() {
    const track = document.getElementById('karyaTrack');
    const cards = document.querySelectorAll('.karya-card');

    if (!track || cards.length === 0) return;

    // Create indicators
    createIndicators(cards.length);

    // Set initial position
    updateCarousel();
}

function getCardsPerView() {
    const width = window.innerWidth;
    if (width < 576) return 1; // Mobile
    if (width < 992) return 2; // Tablet
    if (width < 1400) return 3; // Desktop
    return 3; // Large Desktop
}

function moveCarousel(direction) {
    const cards = document.querySelectorAll('.karya-card');
    const cardsPerView = getCardsPerView();
    const maxIndex = Math.max(0, cards.length - cardsPerView);

    if (direction === 'next') {
        currentIndex = Math.min(currentIndex + 1, maxIndex);
    } else {
        currentIndex = Math.max(currentIndex - 1, 0);
    }

    updateCarousel();
    resetAutoScroll();
}

function updateCarousel() {
    const track = document.getElementById('karyaTrack');
    const cards = document.querySelectorAll('.karya-card');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (!track || cards.length === 0) return;

    const cardsPerView = getCardsPerView();
    const cardWidth = cards[0].offsetWidth;
    const gap = 24; // 1.5rem in pixels
    const offset = currentIndex * (cardWidth + gap);

    track.style.transform = `translateX(-${offset}px)`;

    // Update button states
    if (prevBtn) prevBtn.disabled = currentIndex === 0;
    if (nextBtn) nextBtn.disabled = currentIndex >= cards.length - cardsPerView;

    // Update indicators
    updateIndicators();
}

function createIndicators(totalCards) {
    const indicatorsContainer = document.getElementById('carouselIndicators');
    if (!indicatorsContainer) return;

    indicatorsContainer.innerHTML = '';
    const cardsPerView = getCardsPerView();
    const totalPages = Math.ceil(totalCards / cardsPerView);

    for (let i = 0; i < totalPages; i++) {
        const dot = document.createElement('div');
        dot.className = 'indicator-dot';
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => {
            currentIndex = i * cardsPerView;
            if (currentIndex >= totalCards - cardsPerView) {
                currentIndex = totalCards - cardsPerView;
            }
            updateCarousel();
            resetAutoScroll();
        });
        indicatorsContainer.appendChild(dot);
    }
}

function updateIndicators() {
    const dots = document.querySelectorAll('.indicator-dot');
    const cardsPerView = getCardsPerView();
    const currentPage = Math.floor(currentIndex / cardsPerView);

    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentPage);
    });
}

function startAutoScroll() {
    stopAutoScroll(); // Clear any existing interval
    autoScrollInterval = setInterval(() => {
        const cards = document.querySelectorAll('.karya-card');
        const cardsPerView = getCardsPerView();
        const maxIndex = Math.max(0, cards.length - cardsPerView);

        currentIndex++;

        // Loop back to start when reaching the end
        if (currentIndex > maxIndex) {
            currentIndex = 0;
        }

        updateCarousel();
    }, SCROLL_INTERVAL);
}

function stopAutoScroll() {
    if (autoScrollInterval) {
        clearInterval(autoScrollInterval);
        autoScrollInterval = null;
    }
}

function resetAutoScroll() {
    stopAutoScroll();
    startAutoScroll();
}

// Handle window resize
let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        const cards = document.querySelectorAll('.karya-card');
        const cardsPerView = getCardsPerView();
        const maxIndex = Math.max(0, cards.length - cardsPerView);

        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }

        createIndicators(cards.length);
        updateCarousel();
    }, 250);
});

// ========================================
// READ MORE FUNCTIONALITY
// ========================================

function toggleDescription(element) {
    const descriptionText = element.parentElement;
    const isExpanded = descriptionText.classList.contains('expanded');

    if (isExpanded) {
        descriptionText.classList.remove('expanded');
        element.textContent = 'Read more';
    } else {
        descriptionText.classList.add('expanded');
        element.textContent = 'Read less';
    }
}

// ========================================
// MODAL FUNCTIONALITY
// ========================================

function tampilkanModalJenis(profesi) {
    closeAllModals();

    const profesiId = profesi === 'guru' ? 1 : 2;

    fetch(`/jenis-karya/profesi/${profesiId}`)
        .then(res => res.json())
        .then(data => {
            let isi = '';
            if (data.length === 0) {
                isi = `<div class="col-12 text-center text-muted py-4">
                    <p>Tidak ada jenis karya untuk ${profesi}.</p>
                </div>`;
            } else {
                data.forEach(jenis => {
                    isi += `
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="modal-card">
                                <div class="modal-card-image">
                                    <img src="${jenis.foto_path ? '/storage/' + jenis.foto_path : 'https://via.placeholder.com/300x200/6C63FF/ffffff?text=No+Image'}"
                                        alt="${jenis.nama}">
                                </div>
                                <div class="modal-card-content">
                                    <h6 class="modal-card-title">${jenis.nama}</h6>
                                    <a href="/jelajahi/${profesi}/${jenis.nama}" class="btn-modal-action">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="11" cy="11" r="8"/>
                                            <path d="m21 21-4.35-4.35"/>
                                        </svg>
                                        <span>Lihat</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            document.getElementById('profesi-terpilih').innerText = profesi.charAt(0).toUpperCase() + profesi.slice(1);
            document.getElementById('list-jenis-karya').innerHTML = isi;

            const modalJenis = new bootstrap.Modal(document.getElementById('modal-jenis-karya'));
            modalJenis.show();
        })
        .catch(err => {
            console.error("Gagal ambil data jenis karya:", err);
        });
}

function closeAllModals() {
    const modalJenis = bootstrap.Modal.getInstance(document.getElementById('modal-jenis-karya'));
    if (modalJenis) modalJenis.hide();

    const modalUnggah = bootstrap.Modal.getInstance(document.getElementById('modal-unggah'));
    if (modalUnggah) modalUnggah.hide();

    const modalJelajahi = bootstrap.Modal.getInstance(document.getElementById('modal-jelajahi'));
    if (modalJelajahi) modalJelajahi.hide();

    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
}

function bukaModalJelajahi() {
    closeAllModals();

    const showSiswa = 1;
    const showGuru = 1;

    if (showSiswa === 1 && showGuru === 0) {
        tampilkanModalJenis('siswa');
    } else if (showGuru === 1 && showSiswa === 0) {
        tampilkanModalJenis('guru');
    } else {
        const modal = new bootstrap.Modal(document.getElementById('modal-jelajahi'));
        modal.show();
    }
}

// Clean up backdrop on click
document.addEventListener('click', function() {
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop && !document.body.classList.contains('modal-open')) {
        backdrop.remove();
    }
});
