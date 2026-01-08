@extends('layouts.app')

@section('content')
    {{-- Hero Section 1: Image Slider with Captions --}}
    <section class="relative min-h-screen flex items-end overflow-hidden">
        {{-- Image Slider Container --}}
        <div id="hero-slider" class="absolute inset-0 z-0">
            {{-- Slide 1 --}}
            <div class="slide absolute inset-0 opacity-100 transition-opacity duration-1000">
                <img src="{{ asset('images/cool.jpg') }}" alt="Digital Transformation" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
            </div>
            {{-- Slide 2 --}}
            <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000">
                <img src="{{ asset('images/data stuff.jpg') }}" alt="Data Management" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
            </div>
            {{-- Slide 3 --}}
            <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000">
                <img src="{{ asset('images/jakarta tech.jpg') }}" alt="Jakarta Tech" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
            </div>
            {{-- Slide 4 --}}
            <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000">
                <img src="{{ asset('images/pak cahyono.jpeg') }}" alt="Leadership" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
            </div>
        </div>

        {{-- Content with Dynamic Captions --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-32 pt-40 w-full">
            <p class="text-gray-300 text-sm mb-6 tracking-wider uppercase font-medium">Selamat datang di website Portal Pemerintahan Digital</p>

            {{-- Dynamic Headlines --}}
            <div id="caption-container" class="relative min-h-[200px]">
                <h1 class="caption font-serif text-4xl md:text-5xl lg:text-6xl text-white leading-tight max-w-4xl">
                    <span class="italic block">Dari data yang terkelola lahir keputusan yang berdampak.</span>
                    <span class="block mt-4 text-white/90 font-sans text-2xl md:text-3xl font-light">Inilah pondasi pemerintahan digital Indonesia.</span>
                </h1>
                <h1 class="caption font-serif text-4xl md:text-5xl lg:text-6xl text-white leading-tight max-w-4xl">
                    <span class="italic block">Data adalah aset strategis bangsa.</span>
                    <span class="block mt-4 text-white/90 font-sans text-2xl md:text-3xl font-light">Kelola dengan bijak, manfaatkan untuk kemajuan.</span>
                </h1>
                <h1 class="caption font-serif text-4xl md:text-5xl lg:text-6xl text-white leading-tight max-w-4xl">
                    <span class="italic block">Inovasi teknologi untuk pelayanan publik.</span>
                    <span class="block mt-4 text-white/90 font-sans text-2xl md:text-3xl font-light">Transformasi digital menuju Indonesia maju.</span>
                </h1>
                <h1 class="caption font-serif text-4xl md:text-5xl lg:text-6xl text-white leading-tight max-w-4xl">
                    <span class="italic block">Kepemimpinan yang visioner.</span>
                    <span class="block mt-4 text-white/90 font-sans text-2xl md:text-3xl font-light">Membangun ekosistem digital yang inklusif.</span>
                </h1>
            </div>

            {{-- Slider Indicators --}}
            <div class="flex space-x-3 mt-8">
                <button class="slider-dot w-12 h-1 bg-white rounded-full transition-all duration-300" data-index="0"></button>
                <button class="slider-dot w-12 h-1 bg-white/40 rounded-full transition-all duration-300" data-index="1"></button>
                <button class="slider-dot w-12 h-1 bg-white/40 rounded-full transition-all duration-300" data-index="2"></button>
                <button class="slider-dot w-12 h-1 bg-white/40 rounded-full transition-all duration-300" data-index="3"></button>
            </div>
        </div>
    </section>

    {{-- Hero Section 2: Search/Filter --}}
    <section class="relative py-20 overflow-hidden" style="background-color: #1a365d;">
        {{-- Abstract Network Background --}}
        <div class="absolute inset-0 z-0 opacity-30">
            <div class="absolute inset-0" style="
                background-image: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                                  radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                                  radial-gradient(circle at 40% 40%, rgba(255,255,255,0.05) 0%, transparent 30%);
            "></div>
            {{-- Glowing dots pattern --}}
            <div class="absolute bottom-0 right-0 w-1/2 h-full opacity-50" style="
                background-image: radial-gradient(circle, rgba(255,215,0,0.3) 1px, transparent 1px);
                background-size: 30px 30px;
            "></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Heading --}}
            <div class="mb-10">
                <h2 class="font-serif text-3xl md:text-4xl lg:text-5xl italic leading-tight max-w-2xl" style="color: #d4af37;">
                    Data terbuka, tata kelola terbuka.<br>
                    Untuk pemerintahan yang transparan dan melayani.
                </h2>
                <p class="text-white/90 mt-6 max-w-xl text-base leading-relaxed">
                    Temukan dan pantau profiling Pemerintahan Digital (PEMDI) pada instansi pusat dan daerah di seluruh Indonesia
                </p>
            </div>

            {{-- Search Form --}}
            <div class="space-y-4">
                {{-- Dropdowns Row --}}
                <div class="flex flex-wrap gap-3">
                    {{-- Provinsi Dropdown --}}
                    <div class="relative">
                        <select name="provinsi" id="provinsi" class="appearance-none bg-white border border-gray-300 rounded-md px-4 py-2.5 pr-10 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:border-transparent min-w-[160px]" style="focus:ring-color: #d4af37;">
                            <option value="">Semua Provinsi</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Kabupaten/Kota Dropdown --}}
                    <div class="relative">
                        <select name="kabkota" id="kabkota" class="appearance-none bg-white border border-gray-300 rounded-md px-4 py-2.5 pr-10 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:border-transparent min-w-[160px]" style="focus:ring-color: #d4af37;" disabled>
                            <option value="">Semua Kab/Kota</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Kecamatan Dropdown --}}
                    <div class="relative hidden">
                        <select name="kecamatan" id="kecamatan" class="appearance-none bg-white border border-gray-300 rounded-md px-4 py-2.5 pr-10 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:border-transparent min-w-[160px]" disabled>
                            <option value="">Semua Kecamatan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Search Input Row --}}
                <div class="flex flex-wrap gap-3 items-center">
                    {{-- Search Input --}}
                    <div class="relative flex-grow max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="q"
                            id="search-input"
                            placeholder="Cari instansi..."
                            class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-300 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent shadow-sm transition-all"
                            style="focus:ring-color: #d4af37;"
                        >
                    </div>

                    {{-- Search Button --}}
                    <button type="button" id="search-button" class="font-semibold px-8 py-3 rounded-lg text-sm transition-all shadow-lg hover:shadow-xl transform hover:scale-105" style="background-color: #c9a227; color: #0f2544;">
                        CARI INSTANSI
                    </button>
                </div>

                {{-- Real-time Search Results --}}
                <div id="search-results" class="hidden mt-4 bg-white rounded-lg shadow-xl max-h-96 overflow-y-auto">
                    <div id="results-container" class="divide-y divide-gray-200">
                        <!-- Results will be populated here -->
                    </div>
                    <div id="loading-indicator" class="hidden p-4 text-center text-gray-500">
                        <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-sm">Mencari...</p>
                    </div>
                    <div id="no-results" class="hidden p-4 text-center text-gray-500">
                        <p class="text-sm">Tidak ada hasil ditemukan</p>
                    </div>
                </div>

                {{-- Login as Instansi Link --}}
                <div class="mt-6">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-white border-2 border-white/70 hover:bg-white hover:text-panrb-blue-dark px-6 py-2.5 rounded-lg text-sm transition-all font-medium">
                        LOGIN SEBAGAI INSTANSI
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========== Hero Slider Logic ==========
        const slides = document.querySelectorAll('#hero-slider .slide');
        const captions = document.querySelectorAll('#caption-container .caption');
        const dots = document.querySelectorAll('.slider-dot');
        let currentSlide = 0;
        const totalSlides = slides.length;
        const autoSlideInterval = 5000; // 5 seconds

        function goToSlide(index) {
            // Update slides
            slides.forEach((slide, i) => {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
                if (i === index) {
                    slide.classList.remove('opacity-0');
                    slide.classList.add('opacity-100');
                }
            });

            // Update captions
            captions.forEach((caption, i) => {
                caption.classList.remove('opacity-100');
                caption.classList.add('opacity-0');
                if (i === index) {
                    caption.classList.remove('opacity-0');
                    caption.classList.add('opacity-100');
                }
            });

            // Update dots
            dots.forEach((dot, i) => {
                dot.classList.remove('bg-white');
                dot.classList.add('bg-white/40');
                if (i === index) {
                    dot.classList.remove('bg-white/40');
                    dot.classList.add('bg-white');
                }
            });

            currentSlide = index;
        }

        function nextSlide() {
            const next = (currentSlide + 1) % totalSlides;
            goToSlide(next);
        }

        // Auto slide
        let slideTimer = setInterval(nextSlide, autoSlideInterval);

        // Dot click handlers
        dots.forEach((dot) => {
            dot.addEventListener('click', function() {
                clearInterval(slideTimer);
                goToSlide(parseInt(this.dataset.index));
                slideTimer = setInterval(nextSlide, autoSlideInterval);
            });
        });

        // ========== Cascading Dropdown & Real-time Search Logic ==========
        const provinsiSelect = document.getElementById('provinsi');
        const kabkotaSelect = document.getElementById('kabkota');
        const kecamatanSelect = document.getElementById('kecamatan');
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        const resultsContainer = document.getElementById('results-container');
        const loadingIndicator = document.getElementById('loading-indicator');
        const noResults = document.getElementById('no-results');

        let searchTimeout;

        // Load provinces on page load
        fetch('/api/provinces')
            .then(response => response.json())
            .then(data => {
                data.forEach(item => {
                    provinsiSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                // Initial load: show latest data once options are ready
                performSearch();
            })
            .catch(error => console.error('Error loading provinces:', error));


        // Provinsi change handler
        provinsiSelect?.addEventListener('change', function() {
            const provinsiId = this.value;
            kabkotaSelect.innerHTML = '<option value="">Semua Kab/Kota</option>';
            kecamatanSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
            kabkotaSelect.value = '';
            kabkotaSelect.disabled = true;

            if (provinsiId && provinsiId !== '') {
                // Show loading state
                kabkotaSelect.innerHTML = '<option value="">Memuat...</option>';

                // Load kabkota for selected province
                fetch(`/api/regions/kabkota/${encodeURIComponent(provinsiId)}`)
                    .then(response => response.json())
                    .then(data => {
                        kabkotaSelect.innerHTML = '<option value="">Semua Kab/Kota</option>';

                        if (data.length > 0) {
                            kabkotaSelect.disabled = false;
                            data.forEach(item => {
                                kabkotaSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                            });
                        } else {
                            kabkotaSelect.innerHTML = '<option value="">Tidak ada data</option>';
                        }

                        // Trigger search after kabkota loaded
                        performSearch();
                    })
                    .catch(error => {
                        console.error('Error loading kabkota:', error);
                        kabkotaSelect.innerHTML = '<option value="">Error memuat data</option>';
                        // Still perform search even if kabkota fails
                        performSearch();
                    });
            } else {
                // "Semua Provinsi" selected - disable kabkota and perform search
                kabkotaSelect.disabled = true;
                performSearch();
            }
        });

        // Kabkota change handler
        kabkotaSelect?.addEventListener('change', function() {
            performSearch();
        });

        // Real-time search input handler
        searchInput?.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch();
            }, 300); // Debounce 300ms
        });

        // Search button click handler
        document.getElementById('search-button')?.addEventListener('click', function() {
            performSearch();
        });

        // Click outside to close results
        document.addEventListener('click', function(event) {
            if (!searchResults.contains(event.target) && event.target !== searchInput) {
                searchResults.classList.add('hidden');
            }
        });

        // Show results when input is focused
        searchInput?.addEventListener('focus', function() {
            if (resultsContainer.children.length > 0) {
                searchResults.classList.remove('hidden');
            }
        });

        function performSearch() {
            const query = searchInput.value.trim();
            const provinsi = provinsiSelect.value;
            const kabkota = kabkotaSelect.value;

            // Show loading
            loadingIndicator.classList.remove('hidden');
            noResults.classList.add('hidden');
            resultsContainer.innerHTML = '';
            searchResults.classList.remove('hidden');

            // Build query params - only add non-empty values
            const params = new URLSearchParams();
            if (query && query !== '') params.append('q', query);
            if (provinsi && provinsi !== '') params.append('provinsi', provinsi);
            if (kabkota && kabkota !== '') params.append('kabkota', kabkota);

            fetch(`/api/search-institutions?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    loadingIndicator.classList.add('hidden');

                    if (data.length === 0) {
                        noResults.classList.remove('hidden');
                        return;
                    }

                    resultsContainer.innerHTML = '';
                    data.forEach(institution => {
                        const resultItem = document.createElement('a');
                        resultItem.href = `/dashboard?kode=${institution.kode}`;
                        resultItem.className = 'block p-4 hover:bg-gray-50 transition-colors';
                        resultItem.innerHTML = `
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm">${institution.nama_instansi}</h3>
                                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                                        ${institution.kategori ? `<span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">${institution.kategori}</span>` : ''}
                                        ${institution.daerah ? `<span class="text-xs text-gray-500">${institution.daerah}</span>` : ''}
                                    </div>
                                </div>
                                ${institution.indeks ? `<div class="ml-4"><span class="text-lg font-bold" style="color: #c9a227;">${parseFloat(institution.indeks).toFixed(2)}</span></div>` : ''}
                            </div>
                        `;
                        resultsContainer.appendChild(resultItem);
                    });
                })
                .catch(error => {
                    console.error('Search error:', error);
                    loadingIndicator.classList.add('hidden');
                    noResults.classList.remove('hidden');
                });
        }
    });
</script>
@endpush
