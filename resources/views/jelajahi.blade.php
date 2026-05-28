<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/img/logo-title.png') }}" type="image/png">
    <title>Manuskrip Digital Pesantren - Jelajahi Manuskrip</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/homepage.css') }}?v=1.1">
    <link rel="stylesheet" href="{{ asset('assets/css/jelajahi.css') }}?v=1.1">

</head>
<body>
    @include('components.nav')

    <!-- Header -->
    <div class="jelajahi-header">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="text-center">
                <div class="hero-badge" data-aos="fade-up">
                    <span class="badge-icon">🔍</span>
                    <span>Temukan Manuskrip</span>
                </div>
                <h1 data-aos="fade-up" data-aos-delay="100">Jelajahi Manuskrip</h1>
                <p data-aos="fade-up" data-aos-delay="200">Temukan berbagai koleksi manuskrip pesantren yang telah didigitalisasi dan dipublikasikan</p>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </div>

    <div class="container">
        <!-- Filters Section -->
        <div class="filters-section" data-aos="fade-up">
            <!-- Search Box -->
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Cari manuskrip berdasarkan judul atau pengarang..." value="{{ $search ?? '' }}">
            </div>

            <div class="row justify-content-center">
                <!-- Jenis Manuskrip Filter -->
                <div class="col-md-4 col-6">
                    <div class="filter-dropdown">
                        <label class="filter-group-title"><i class="bi bi-tags"></i> Jenis Manuskrip</label>
                        <select id="jenisKaryaFilter">
                            <option value="">Semua Jenis</option>
                            @foreach($jenisKaryas as $jk)
                                <option value="{{ $jk->id }}" {{ $jenis_karya_id == $jk->id ? 'selected' : '' }}>{{ $jk->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Kategori Filter -->
                <div class="col-md-4 col-6">
                    <div class="filter-dropdown">
                        <label class="filter-group-title"><i class="bi bi-book"></i> Kategori Manuskrip</label>
                        <select id="kategoriFilter">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ $kategori_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Year Filter -->
                <div class="col-md-4 col-6">
                    <div class="filter-dropdown">
                        <label class="filter-group-title"><i class="bi bi-calendar"></i> Tahun</label>
                        <select id="yearFilter">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Angkatan Filter -->
                <div class="col-md-4 col-6">
                    <div class="filter-dropdown">
                        <label class="filter-group-title"><i class="bi bi-mortarboard"></i> Angkatan</label>
                        <select id="angkatanFilter">
                            <option value="">Semua Angkatan</option>
                            @foreach($angkatans as $a)
                                <option value="{{ $a }}" {{ $angkatan == $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Jurusan Filter -->
                <div class="col-md-4 col-6">
                    <div class="filter-dropdown">
                        <label class="filter-group-title"><i class="bi bi-briefcase"></i> Jurusan</label>
                        <select id="jurusanFilter">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ $jurusan_id == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Program Studi Filter -->
                <div class="col-md-4 col-6">
                    <div class="filter-dropdown">
                        <label class="filter-group-title"><i class="bi bi-diagram-3"></i> Program Studi</label>
                        <select id="prodiFilter" {{ !$jurusan_id ? 'disabled' : '' }}>
                            <option value="">{{ !$jurusan_id ? 'Pilih Jurusan Dahulu' : 'Semua Program Studi' }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manuskrip Grid -->
        <div class="karya-grid" id="karyaGrid">
            @include('partials.karya-grid', ['karyas' => $karyas])
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

        // Pass route to external JS
        const jelajahiRoute = '{{ route("jelajahi") }}';
        const prodiApiRoute = '{{ url("api/prodi/by-jurusan") }}';
        const initialProdiId = '{{ $prodi_id ?? "" }}';
        const initialJurusanId = '{{ $jurusan_id ?? "" }}';
    </script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/jelajahi.js') }}"></script>
</body>
</html>
