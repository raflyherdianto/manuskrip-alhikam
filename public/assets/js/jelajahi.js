// Auto-filter without reload using AJAX
let filterTimeout;

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const year = document.getElementById('yearFilter').value;
    const angkatan = document.getElementById('angkatanFilter').value;
    const jurusan = document.getElementById('jurusanFilter').value;
    const prodi = document.getElementById('prodiFilter').value;
    const kategori = document.getElementById('kategoriFilter').value;
    const jenisKarya = document.getElementById('jenisKaryaFilter').value;

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (year) params.append('year', year);
    if (angkatan) params.append('angkatan', angkatan);
    if (jurusan) params.append('jurusan_id', jurusan);
    if (prodi) params.append('prodi_id', prodi);
    if (kategori) params.append('kategori_id', kategori);
    if (jenisKarya) params.append('jenis_karya_id', jenisKarya);

    // Show loading spinner immediately for responsiveness
    const karyaGrid = document.getElementById('karyaGrid');
    karyaGrid.innerHTML = `
        <div class="d-flex flex-column justify-content-center align-items-center w-100 py-5" style="grid-column: 1/-1; gap: 15px;">
            <div class="spinner-custom"></div>
            <span style="color: #666; font-size: 0.95rem; font-weight: 500;">Memuat manuskrip...</span>
        </div>
    `;

    // AJAX request
    fetch(jelajahiRoute + '?' + params.toString(), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        karyaGrid.innerHTML = data.html;

        // Re-initialize AOS for new elements
        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }
    })
    .catch(error => {
        console.error('Error loading data:', error);
        karyaGrid.innerHTML = `
            <div class="no-results">
                <i class="bi bi-exclamation-circle text-danger"></i>
                <h3>Gagal Memuat Manuskrip</h3>
                <p>Silakan coba beberapa saat lagi</p>
            </div>
        `;
    });
}

// Load Prodi based on Jurusan
function loadProdi(jurusanId, selectedId = null) {
    const prodiSelect = document.getElementById('prodiFilter');

    if (!jurusanId) {
        prodiSelect.innerHTML = '<option value="">Pilih Jurusan Dahulu</option>';
        prodiSelect.disabled = true;
        return;
    }

    fetch(prodiApiRoute + '/' + jurusanId)
        .then(response => response.json())
        .then(data => {
            prodiSelect.innerHTML = '<option value="">Semua Program Studi</option>';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.nama;
                if (selectedId && item.id == selectedId) {
                    option.selected = true;
                }
                prodiSelect.appendChild(option);
            });
            prodiSelect.disabled = false;
        })
        .catch(error => {
            console.error('Error loading program studi:', error);
            prodiSelect.innerHTML = '<option value="">Gagal memuat</option>';
            prodiSelect.disabled = true;
        });
}

// Search with debounce (lowered to 300ms for responsiveness)
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(applyFilters, 300);
});

// Instant filter on select change
document.getElementById('yearFilter').addEventListener('change', applyFilters);
document.getElementById('angkatanFilter').addEventListener('change', applyFilters);
document.getElementById('jurusanFilter').addEventListener('change', function() {
    // Reset prodi filter first so we don't query using previous prodi
    const prodiSelect = document.getElementById('prodiFilter');
    prodiSelect.value = "";
    loadProdi(this.value);
    applyFilters();
});
document.getElementById('prodiFilter').addEventListener('change', applyFilters);
document.getElementById('kategoriFilter').addEventListener('change', applyFilters);
document.getElementById('jenisKaryaFilter').addEventListener('change', applyFilters);

// Initialize Prodi on page load if Jurusan is selected
document.addEventListener('DOMContentLoaded', function() {
    if (typeof initialJurusanId !== 'undefined' && initialJurusanId) {
        loadProdi(initialJurusanId, initialProdiId);
    }
});
