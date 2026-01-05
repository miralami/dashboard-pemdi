<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard PEMDI</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        :root { --brand: #255c99; }
        .bg-brand { background-color: var(--brand); }
        .text-brand { color: var(--brand); }
        .border-brand { border-color: var(--brand); }
        .sidebar-link:hover { background-color: #f3f4f6; color: #255c99; }
        .sidebar-link.active { background-color: #eff6ff; color: #255c99; border-left: 3px solid #255c99; }
        .sidebar-collapsed .sidebar-expanded-only { display: none; }
        .sidebar-collapsed .sidebar-link { justify-content: center; padding-left: 0.75rem; padding-right: 0.75rem; }
        .sidebar-collapsed .sidebar-link svg { margin-right: 0 !important; }
    </style>
</head>
<body class="bg-brand text-slate-800">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-collapsed w-16 bg-white h-screen sticky top-0 flex flex-col justify-between border-r border-slate-200 shrink-0 transition-[width] duration-200">
            <div>
                <div class="p-3 flex items-center gap-2 border-b border-slate-100">
                    <img src="{{ asset('images/LogoPANRB.png') }}" alt="Logo PANRB" class="h-8 w-8 object-contain">
                    <div class="sidebar-expanded-only font-bold text-lg text-slate-800">panrb</div>
                    <button id="sidebarToggle" type="button" class="ml-auto inline-flex items-center justify-center h-8 w-8 rounded-lg hover:bg-slate-100 text-slate-600" aria-label="Toggle sidebar">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>

                <div class="sidebar-expanded-only px-4 py-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-brand">{{ '@Admin' }}</div>
                            <div class="text-xs text-slate-500">Admin</div>
                        </div>
                    </div>
                </div>

                <nav class="px-2 py-3 space-y-1">
                    <a href="#" class="sidebar-link active flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="sidebar-expanded-only">Dashboard</span>
                    </a>
                </nav>
            </div>

            <div class="p-3">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-700 rounded-lg hover:bg-slate-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="sidebar-expanded-only">Keluar</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-3">
            <!-- Header -->
            <div class="flex justify-between items-start mb-3 text-white">
                <h1 class="text-lg font-bold max-w-3xl">Dashboard Pemerintah Digital Kementerian Koordinator Bidang Politik dan Keamanan</h1>
                <div class="flex gap-2">
                    <button class="px-3 py-1.5 bg-white text-slate-700 rounded-lg text-xs font-medium hover:bg-slate-50 flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </button>
                    <button class="px-3 py-1.5 bg-yellow-400 text-slate-900 rounded-lg text-xs font-medium hover:bg-yellow-300 flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export
                    </button>
                </div>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-12 gap-2">

                <!-- Row 1 -->
                <!-- Profile Card -->
                <div class="col-span-4 col-start-1 row-start-1 bg-white rounded-xl p-2 h-20 flex items-center gap-3 shadow-sm">
                    <div class="h-12 w-12 shrink-0">
                        <img src="{{ asset('images/Kemenkopolkam.svg') }}" alt="Kemenkopolkam" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-brand mb-0.5">{{ $data['profile']['name'] }}</h2>
                        <p class="text-[11px] text-slate-500">{{ $data['profile']['minister'] }}</p>
                    </div>
                </div>

                <!-- SPBE Index -->
                <div class="col-span-2 col-start-5 row-start-1 bg-white rounded-xl p-2 h-20 shadow-sm relative overflow-hidden">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-xs text-slate-500 mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                Nilai Indeks SPBE
                            </div>
                            <div class="text-base font-bold text-slate-800">{{ number_format($data['spbeIndex']['value'], 2, ',', '.') }} <span class="text-[11px] font-normal text-slate-400">Indeks</span></div>
                            <div class="inline-block px-2 py-0.5 bg-blue-100 text-blue-700 text-[11px] rounded font-medium">{{ $data['spbeIndex']['label'] }}</div>
                        </div>
                    </div>
                    <!-- Decorative background shape -->
                    <div class="absolute -bottom-4 -right-4 w-12 h-12 bg-blue-50 rounded-full opacity-50"></div>
                </div>

                <!-- Total Applications -->
                <div class="col-span-2 col-start-7 row-start-1 bg-white rounded-xl p-2 h-20 shadow-sm relative overflow-hidden">
                    <div class="text-xs text-slate-500 mb-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Total Aplikasi
                    </div>
                    <div class="text-base font-bold text-slate-800">{{ $data['totalApplications']['value'] }} <span class="text-[11px] font-normal text-slate-400">Aplikasi</span></div>
                    <div class="text-[11px] text-green-600 font-medium">+{{ $data['totalApplications']['new'] }} Aplikasi Tahun Ini</div>
                </div>

                <!-- Capaian Indeks (Radar) - spans Row 1 & 2 -->
                <div class="col-span-4 col-start-9 row-start-1 row-span-2 bg-white rounded-xl p-2 shadow-sm flex flex-col">
                    <div class="text-xs font-bold text-brand mb-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Capaian Indeks Kematangan
                    </div>
                    <div class="flex-1 relative">
                        <canvas id="maturityChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-4 mt-1 text-[10px]">
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-400"></span> Instansi</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-400"></span> Nasional</div>
                    </div>
                </div>

                <!-- Row 2 -->
                <!-- Governance Status (Left Column) -->
                <div class="col-span-4 col-start-1 row-start-2 row-span-2 bg-white rounded-xl p-2 shadow-sm flex flex-col">
                    <div class="flex items-center gap-2 mb-1 border-b border-slate-100 pb-1">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <h3 class="text-sm font-bold text-brand">Status Kesiapan Tata Kelola Digital</h3>
                    </div>

                    <div class="rounded-lg border border-slate-100 overflow-hidden flex-1">
                        <div class="h-full overflow-y-auto">
                            <table class="w-full text-xs">
                                <thead class="bg-brand text-white">
                                    <tr>
                                        <th class="px-2 py-1 text-left rounded-tl-lg">Komponen</th>
                                        <th class="px-2 py-1 text-center rounded-tr-lg">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($data['governanceStatus'] as $item)
                                    <tr>
                                        <td class="px-2 py-1.5 text-slate-700">{{ $item['component'] }}</td>
                                        <td class="px-2 py-1.5 text-center">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $item['color'] }}">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="col-span-4 col-start-5 row-start-2 bg-white rounded-xl p-1 shadow-sm">
                    <div class="text-xs font-bold text-brand mb-1">Rekomendasi Tindakan</div>
                    <div class="space-y-1">
                        @foreach(array_slice($data['recommendations'], 0, 2) as $rec)
                        <div class="border border-slate-200 rounded-lg p-1.5 flex items-start gap-2">
                            <div class="p-1 bg-slate-100 rounded-lg text-slate-600">
                                @if($rec['icon'] == 'lock')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                @else
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                                @endif
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-800">{{ $rec['title'] }}</div>
                                <div class="text-[9px] text-slate-500">{{ $rec['description'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Row 3: Tren Indeks SPBE + Pemdi (side-by-side) -->
                <!-- Tren Indeks SPBE -->
                <div class="col-span-4 col-start-5 row-start-3 bg-white rounded-xl p-2 shadow-sm">
                    <div class="text-xs font-bold text-brand mb-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Tren Indeks SPBE
                    </div>
                    <div class="h-40">
                        <canvas id="spbeChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-4 mt-1 text-[10px]">
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Instansi</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-300"></span> Nasional</div>
                    </div>
                </div>

                <!-- Tren Indeks Pemdi -->
                <div class="col-span-4 col-start-9 row-start-3 bg-white rounded-xl p-2 shadow-sm">
                    <div class="text-xs font-bold text-brand mb-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Tren Indeks Pemdi
                    </div>
                    <div class="h-40">
                        <canvas id="pemdiChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-4 mt-1 text-[10px]">
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Instansi</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-300"></span> Nasional</div>
                    </div>
                </div>

                <!-- Row 4 -->
                <!-- Budget -->
                <div class="col-span-9 col-start-1 row-start-4 bg-white rounded-xl p-2 shadow-sm">
                    <div class="text-xs font-bold text-brand mb-1">Anggaran Belanja SPBE</div>
                    <div class="h-32">
                        <canvas id="budgetChart" class="w-full h-full"></canvas>
                    </div>
                    <div class="flex justify-center gap-4 mt-1 text-[10px]">
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-blue-800"></span> Total Anggaran</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-yellow-400"></span> Anggaran Disetujui</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-red-800"></span> Anggaran Ditunda</div>
                    </div>
                </div>

                <!-- Domain Changes -->
                <div class="col-span-3 col-start-10 row-start-4 bg-white rounded-xl p-2 shadow-sm">
                    <div class="flex justify-between items-center mb-1">
                        <div class="text-xs font-bold text-brand">Perubahan Domain Per Tahun</div>
                        <button class="px-2 py-0.5 bg-yellow-400 text-[10px] font-bold rounded text-slate-900">Saring</button>
                    </div>
                    <div class="grid grid-cols-2 gap-1">
                        @foreach($data['domainChanges'] as $domain)
                        <div class="border border-slate-200 rounded p-1.5 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded border border-slate-200 flex flex-col items-center justify-center">
                                    @if($domain['change'] >= 0)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    @else
                                    <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-xs font-bold">{{ $domain['code'] }}</div>
                                    <div class="text-[10px] text-slate-500">{{ number_format($domain['value'], 2) }}</div>
                                </div>
                            </div>
                            <div class="text-xs font-bold {{ $domain['change'] >= 0 ? ($domain['change'] == 0 ? 'text-yellow-500' : 'text-blue-600') : 'text-red-600' }}">
                                {{ $domain['change'] > 0 ? '+' : '' }}{{ number_format($domain['change'], 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');

            function setSidebarCollapsed(isCollapsed) {
                sidebar.classList.toggle('sidebar-collapsed', isCollapsed);
                sidebar.classList.toggle('w-16', isCollapsed);
                sidebar.classList.toggle('w-56', !isCollapsed);

                const icon = toggle.querySelector('svg');
                if (isCollapsed) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />';
                } else {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />';
                }
            }

            // default: collapsed
            setSidebarCollapsed(true);
            toggle.addEventListener('click', function() {
                setSidebarCollapsed(!sidebar.classList.contains('sidebar-collapsed'));
            });

            // Maturity Radar Chart
            const maturityCtx = document.getElementById('maturityChart').getContext('2d');
            new Chart(maturityCtx, {
                type: 'radar',
                data: {
                    labels: @json($data['maturityIndex']['labels']),
                    datasets: @json($data['maturityIndex']['datasets'])
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 5,
                            ticks: { display: false },
                            pointLabels: { font: { size: 10 } }
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });

            // SPBE Trend Line Chart
            const spbeCtx = document.getElementById('spbeChart').getContext('2d');
            new Chart(spbeCtx, {
                type: 'line',
                data: {
                    labels: @json($data['spbeTrend']['labels']),
                    datasets: @json($data['spbeTrend']['datasets'])
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, max: 5, ticks: { stepSize: 1 } }
                    },
                    plugins: { legend: { display: false } }
                }
            });

            // Pemdi Trend Line Chart
            const pemdiCtx = document.getElementById('pemdiChart').getContext('2d');
            new Chart(pemdiCtx, {
                type: 'line',
                data: {
                    labels: @json($data['pemdiTrend']['labels']),
                    datasets: @json($data['pemdiTrend']['datasets'])
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, max: 5, ticks: { stepSize: 1 } }
                    },
                    plugins: { legend: { display: false } }
                }
            });

            // Budget Bar Chart
            const budgetCtx = document.getElementById('budgetChart').getContext('2d');
            new Chart(budgetCtx, {
                type: 'bar',
                data: {
                    labels: @json($data['budget']['labels']),
                    datasets: @json($data['budget']['datasets'])
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) { return value + ' M'; }
                            }
                        }
                    },
                    plugins: { legend: { display: false } },
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }
            });
        });
    </script>
</body>
</html>
