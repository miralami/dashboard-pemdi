<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Pilih Instansi - Dashboard PEMDI</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .form-container {
                background: white;
                border-radius: 1rem;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                max-height: 90vh;
                overflow-y: auto;
            }
            .search-input:focus, .select-input:focus {
                outline: none;
                border-color: #667eea;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }
        </style>
    </head>
    <body class="min-h-screen flex items-center justify-center p-6">
        <div class="form-container w-full max-w-md p-8">
            <div class="text-center mb-8">
                <img src="{{ asset('images/LogoPANRB.png') }}" alt="Logo PANRB" class="h-16 w-16 mx-auto mb-4">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard PEMDI</h1>
                <p class="text-gray-600">Pilih instansi untuk melihat dashboard</p>
            </div>

            <form id="institutionForm" action="{{ route('dashboard') }}" method="GET" class="space-y-6">
                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Instansi
                    </label>
                    <select id="category" name="category" class="select-input w-full px-4 py-3 border border-gray-300 rounded-lg transition-all duration-200">
                        <option value="">Semua Kategori</option>
                    </select>
                </div>

                <!-- Institution Select -->
                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Instansi
                    </label>
                    <select id="institution" name="kode" required class="select-input w-full px-4 py-3 border border-gray-300 rounded-lg transition-all duration-200">
                        <option value="">-- Pilih Instansi --</option>
                    </select>
                    <p id="loadingText" class="text-sm text-gray-500 mt-2 hidden">Memuat data...</p>
                    <p id="noResults" class="text-sm text-gray-500 mt-2 hidden">Tidak ada instansi ditemukan</p>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Lihat Dashboard
                </button>
            </form>
        </div>

        <script>
            let institutions = [];
            let categories = [];

            // Fetch categories on page load
            async function fetchCategories() {
                try {
                    const response = await fetch('/api/categories');
                    categories = await response.json();

                    const categorySelect = document.getElementById('category');
                    categories.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat;
                        option.textContent = cat;
                        categorySelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error fetching categories:', error);
                }
            }

            // Fetch institutions with filters
            async function fetchInstitutions() {
                const category = document.getElementById('category').value;
                const loadingText = document.getElementById('loadingText');
                const noResults = document.getElementById('noResults');
                const institutionSelect = document.getElementById('institution');

                loadingText.classList.remove('hidden');
                noResults.classList.add('hidden');

                try {
                    const params = new URLSearchParams();
                    if (category) params.append('category', category);

                    const response = await fetch(`/api/institutions?${params.toString()}`);
                    institutions = await response.json();

                    // Clear existing options except the first one
                    institutionSelect.innerHTML = '<option value="">-- Pilih Instansi --</option>';

                    if (institutions.length === 0) {
                        noResults.classList.remove('hidden');
                    } else {
                        institutions.forEach(inst => {
                            const option = document.createElement('option');
                            option.value = inst.kode;
                            option.textContent = `${inst.nama_instansi} ${inst.kategori ? '(' + inst.kategori + ')' : ''}`;
                            institutionSelect.appendChild(option);
                        });
                    }
                } catch (error) {
                    console.error('Error fetching institutions:', error);
                    noResults.classList.remove('hidden');
                } finally {
                    loadingText.classList.add('hidden');
                }
            }

            // Category filter
            document.getElementById('category').addEventListener('change', function() {
                fetchInstitutions();
            });

            // Initialize
            document.addEventListener('DOMContentLoaded', function() {
                fetchCategories();
                fetchInstitutions();
            });
        </script>
    </body>
</html>
