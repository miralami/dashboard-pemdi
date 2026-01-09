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
        html { background: #1f4e8c !important; }
        body {
            font-family: 'Inter', sans-serif;
            background: #1f4e8c !important;
            background-image: none !important;
            background-size: 0 0 !important;
            position: relative;
        }
        /* Glassmorphism Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
        .sidebar-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Hard override to hide any residual page background images */
        *, body, html, main, #app, .min-h-screen, .bg-brand {
            background-image: none !important;
            background-size: 0 0 !important;
            background-repeat: no-repeat !important;
            background-position: center center !important;
        }
        /* Remove any ::before/::after backgrounds that could inject images */
        body::before, body::after, html::before, html::after, main::before, main::after {
            background: none !important;
            content: '';
        }
        :root {
            --brand: #255c99;
            --accent: #ffcc00;
        }
        .bg-brand { background-color: var(--brand); }
        .text-brand { color: var(--brand); }
        .border-brand { border-color: var(--brand); }

        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover { background-color: rgba(37, 92, 153, 0.1); color: #255c99; }
        .sidebar-link.active {
            background: linear-gradient(90deg, #eff6ff 0%, rgba(239, 246, 255, 0) 100%);
            color: #255c99;
            border-left: 4px solid #255c99;
        }

        .sidebar-collapsed .sidebar-expanded-only { display: none; }
        .sidebar-collapsed .sidebar-link { justify-content: center; padding-left: 0.75rem; padding-right: 0.75rem; }
        .sidebar-collapsed .sidebar-link svg { margin-right: 0 !important; }

        /* KPI cards: tighter, consistent typography with hover effect */
        .kpi-card {
            padding: 0.5rem 0.75rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .kpi-label { font-size: 10px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em; }
        .kpi-value { font-size: 18px; font-weight: 800; line-height: 1.1; color: #1e293b; }
        .kpi-unit { font-size: 11px; font-weight: 500; color: #94a3b8; }
        .kpi-sub { font-size: 10px; font-weight: 600; }

        /* Recommendation cards: slightly smaller text */
        .reco-card {
            padding: 0.45rem 0.6rem;
            transition: all 0.2s ease;
            border: 1px solid rgba(241, 245, 249, 1);
        }
        .reco-card:hover {
            background-color: #f8fafc;
            border-color: #e2e8f0;
            transform: translateX(4px);
        }
        .reco-title { font-size: 10px; font-weight: 700; color: #0f172a; line-height: 1.25; }
        .reco-desc { font-size: 9px; color: #475569; line-height: 1.3; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-brand text-slate-800">

    <div class="fixed inset-0 bg-brand" style="z-index:1;"></div>

    <div class="flex min-h-screen relative" style="z-index:2;">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-collapsed w-16 sidebar-glass h-screen sticky top-0 flex flex-col justify-between shrink-0 transition-[width] duration-300 z-10">
            <div>
                <div class="p-4 flex items-center gap-2 border-b border-white/20">
                    <img src="{{ asset('images/LogoPANRB.png') }}" alt="Logo PANRB" class="h-8 w-8 object-contain">
                    <div class="sidebar-expanded-only font-bold text-lg text-slate-800 tracking-tight">DigitalGov</div>
                    <button id="sidebarToggle" type="button" class="ml-auto inline-flex items-center justify-center h-8 w-8 rounded-lg hover:bg-white/50 text-slate-600 transition-colors" aria-label="Toggle sidebar">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>

                <div class="sidebar-expanded-only px-4 py-6 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-brand shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-800">{{ '@Admin' }}</div>
                            <div class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Administrator</div>
                        </div>
                    </div>
                </div>

                <nav class="px-3 py-4 space-y-1">
                    <a href="#" class="sidebar-link active flex items-center gap-3 px-3 py-2.5 text-sm font-semibold rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="sidebar-expanded-only">Dashboard Utama</span>
                    </a>
                </nav>
            </div>

            <div class="p-3 border-t border-white/10">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-500 hover:text-red-600 rounded-xl hover:bg-red-50 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="sidebar-expanded-only">Keluar Sistem</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 relative z-10">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6 text-white">
                <div>
                    <h1 class="text-xl font-extrabold tracking-tight drop-shadow-md">DASHBOARD PEMERINTAH DIGITAL</h1>
                    <p class="text-sm opacity-80 font-medium">Kementerian Koordinator Bidang Politik dan Keamanan</p>
                </div>
                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-xl text-xs font-bold hover:bg-white/20 flex items-center gap-2 transition-all shadow-lg active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        KEMBALI
                    </button>
                    <button class="px-4 py-2 bg-yellow-400 text-slate-900 rounded-xl text-xs font-bold hover:bg-yellow-300 flex items-center gap-2 transition-all shadow-lg active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        EXPORT DATA
                    </button>
                </div>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-12 gap-3" style="grid-template-rows: auto auto auto auto;">

                <!-- Row 1 -->
                <!-- Profile Card -->
                <div class="col-span-4 col-start-1 row-start-1 glass-card rounded-2xl p-3 flex items-center gap-4 shadow-xl border-l-4 border-l-yellow-400">
                    <div class="h-12 w-12 shrink-0 p-1 bg-white rounded-xl shadow-inner">
                        <img src="{{ asset('images/Kemenkopolkam.svg') }}" alt="Kemenkopolkam" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-brand leading-tight drop-shadow-sm">{{ $data['profile']['name'] ?? 'Nama Instansi' }}</h2>
                        <p class="text-xs text-slate-500 font-medium mt-0.5 uppercase tracking-wide opacity-80">{{ $data['profile']['minister'] ?? '-' }}</p>
                    </div>
                </div>

                <!-- SPBE Index -->
                <div class="col-span-2 col-start-5 row-start-1 glass-card rounded-2xl kpi-card shadow-xl relative overflow-hidden flex flex-col justify-between">
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div>
                            <div class="kpi-label mb-1.5 flex items-center gap-1.5">
                                <div class="p-1 bg-brand/10 rounded text-brand">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                </div>
                                Indeks SPBE
                            </div>
                            <div class="kpi-value text-2xl font-black tracking-tighter">{{ number_format($data['spbeIndex']['value'], 2, ',', '.') }} <span class="text-xs font-bold text-slate-400">/5.0</span></div>
                        </div>
                        <div class="mt-2 text-center">
                            <span class="px-3 py-1 bg-brand text-white text-[10px] rounded-full font-bold shadow-lg shadow-brand/30 uppercase tracking-widest">{{ $data['spbeIndex']['label'] }}</span>
                        </div>
                    </div>
                    <!-- Decorative background shape -->
                    <div class="absolute -bottom-6 -right-6 w-20 h-20 bg-brand/5 rounded-full blur-xl"></div>
                </div>

                <!-- Total Applications -->
                <div class="col-span-2 col-start-7 row-start-1 glass-card rounded-2xl kpi-card shadow-xl relative overflow-hidden flex flex-col justify-between">
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div>
                            <div class="kpi-label mb-1.5 flex items-center gap-1.5">
                                <div class="p-1 bg-emerald-100 rounded text-emerald-600">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                Total Aplikasi
                            </div>
                            <div class="kpi-value text-2xl font-black tracking-tighter">{{ $data['totalApplications']['value'] }} <span class="kpi-unit">Aplikasi</span></div>
                        </div>
                        <div class="mt-2 py-1 px-2 bg-emerald-50 rounded-lg">
                            <div class="kpi-sub text-emerald-600 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                +{{ $data['totalApplications']['new'] }} Baru
                            </div>
                        </div>
                    </div>
                    <!-- Decorative backdrop -->
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full rotate-45 blur-2xl"></div>
                </div>

                <!-- Capaian Indeks (Radar) - spans Row 1 & 2 -->
                <div class="col-span-4 col-start-9 row-start-1 row-span-2 glass-card rounded-2xl p-4 shadow-xl flex flex-col border border-white/40">
                    <div class="text-sm font-black text-brand mb-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 bg-brand text-white rounded-lg shadow-md shadow-brand/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <span class="tracking-tight uppercase">Radar Arsitektur SPBE</span>
                        </div>
                        <span class="text-[10px] text-slate-400 font-bold bg-slate-100 px-2 py-0.5 rounded">LIVE DATA</span>
                    </div>
                    @if(!empty($data['implementationIndex']['labels']) && !empty($data['implementationIndex']['datasets']))
                    <div class="flex-1 flex flex-col">
                        <div class="relative flex-1" style="min-height: 220px;">
                            <canvas id="implementationChart" class="absolute inset-0 w-full h-full"></canvas>
                        </div>
                        <div class="mt-4 flex justify-center gap-6 text-[10px] font-bold">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 shadow-lg shadow-yellow-400/50"></span>
                                <span class="text-slate-600 uppercase tracking-wider">Instansi</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-brand shadow-lg shadow-brand/50"></span>
                                <span class="text-slate-600 uppercase tracking-wider">Nasional</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="flex-1 flex items-center justify-center text-slate-400 text-sm italic">
                        Data tidak ditemukan
                    </div>
                    @endif
                </div>

                <!-- Row 2 -->
                <!-- Governance Status (Left Column) -->
                <div class="col-span-4 col-start-1 row-start-2 row-span-2 glass-card rounded-2xl p-2 shadow-xl flex flex-col">
                    <div class="flex items-center gap-2 mb-1 border-b border-slate-100 pb-2">
                        <div class="p-1.5 bg-brand/10 rounded-lg text-brand">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-xs font-black text-brand uppercase tracking-tight">Status Tata Kelola</h3>
                    </div>

                    <div class="rounded-xl border border-slate-100 overflow-hidden flex-1 bg-white/50 backdrop-blur-sm mt-1">
                        @if(!empty($data['governanceStatus']))
                        <div class="h-full overflow-y-auto custom-scrollbar">
                            <table class="w-full text-[10px]">
                                <thead class="bg-brand text-white sticky top-0 z-10">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-bold uppercase tracking-wider">Komponen</th>
                                        <th class="px-3 py-2 text-center font-bold uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($data['governanceStatus'] as $item)
                                    <tr class="hover:bg-brand/5 transition-colors cursor-default">
                                        <td class="px-3 py-2 text-slate-700 font-semibold">{{ $item['component'] }}</td>
                                        <td class="px-3 py-2 text-center">
                                            <span class="px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest {{ $item['color'] }} shadow-sm border border-black/5">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="flex items-center justify-center h-full text-slate-400 text-sm">
                            /* Lines 344-345 omitted */
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="col-span-4 col-start-5 row-start-2 glass-card rounded-2xl p-3 shadow-xl flex flex-col">
                    <div class="text-[10px] font-black text-brand mb-2 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <div class="p-1 bg-amber-100 rounded text-amber-600 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="uppercase tracking-widest">Rekomendasi Utama</span>
                        </div>
                        <span class="text-[8px] px-1.5 py-0.5 bg-amber-50 text-amber-700 rounded-md border border-amber-100 font-bold">PRIORITAS</span>
                    </div>
                    @if(!empty($data['recommendations']))
                    <div class="space-y-2 overflow-hidden">
                        @foreach(array_slice($data['recommendations'], 0, 2) as $rec)
                        <div class="reco-card flex items-start gap-3 bg-white/60 hover:bg-white rounded-xl border border-white/50 shadow-sm transition-all">
                            <div class="p-2 bg-brand/5 rounded-xl text-brand shrink-0 border border-brand/10">
                                @if($rec['icon'] == 'lock')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                                @endif
                            </div>
                            <div>
                                <div class="reco-title">{{ $rec['title'] }}</div>
                                <div class="reco-desc mt-0.5">{{ $rec['description'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="flex-1 flex items-center justify-center text-slate-400 text-sm italic">
                        Data tidak ditemukan
                    </div>
                    @endif
                </div>

                <!-- Row 3: Tren Indeks SPBE + Pemdi (side-by-side) -->
                <!-- Tren Indeks SPBE -->
                <div class="col-span-4 col-start-5 row-start-3 glass-card rounded-2xl p-3 shadow-xl flex flex-col">
                    <div class="text-[10px] font-black text-brand mb-2 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <div class="p-1 bg-brand/10 rounded shadow-sm">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <span class="uppercase tracking-widest">Tren Indeks SPBE</span>
                        </div>
                    </div>
                    @if(!empty($data['spbeTrend']['labels']) && !empty($data['spbeTrend']['datasets']))
                    <div class="h-40">
                        <canvas id="spbeChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-4 mt-2 text-[9px] font-black">
                        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-brand shadow-sm"></span> <span class="text-slate-500 uppercase tracking-widest">INSTANSI</span></div>
                        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-yellow-400 shadow-sm"></span> <span class="text-slate-500 uppercase tracking-widest">NASIONAL</span></div>
                    </div>
                    @else
                    <div class="flex-1 flex items-center justify-center text-slate-400 text-sm">
                        /* Lines 407-408 omitted */
                    </div>
                    @endif
                </div>

                <!-- Tren Indeks Pemdi -->
                <div class="col-span-4 col-start-9 row-start-3 glass-card rounded-2xl p-3 shadow-xl flex flex-col">
                    <div class="text-[10px] font-black text-brand mb-2 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <div class="p-1 bg-indigo-100 rounded text-indigo-600 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <span class="uppercase tracking-widest">Tren Indeks Pemdi</span>
                        </div>
                    </div>
                    @if(!empty($data['pemdiTrend']['labels']) && !empty($data['pemdiTrend']['datasets']))
                    <div class="h-40">
                        <canvas id="pemdiChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-4 mt-2 text-[9px] font-black">
                        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-indigo-500 shadow-sm"></span> <span class="text-slate-500 uppercase tracking-widest">INSTANSI</span></div>
                        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-rose-400 shadow-sm"></span> <span class="text-slate-500 uppercase tracking-widest">NASIONAL</span></div>
                    </div>
                    @else
                    <div class="flex-1 flex items-center justify-center text-slate-400 text-sm">
                        /* Lines 427-428 omitted */
                    </div>
                    @endif
                </div>

                <!-- Row 4 -->
                <!-- Budget -->
                <div class="col-span-9 col-start-1 row-start-4 glass-card rounded-2xl p-3 shadow-xl flex flex-col">
                    <div class="text-[10px] font-black text-brand mb-2 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <div class="p-1 bg-emerald-100 rounded text-emerald-600 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.6 1M12 8V6m0 0V4m0 2c-1.11 0-2.08.402-2.6 1M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z"/></svg>
                            </div>
                            <span class="uppercase tracking-widest">Alokasi Anggaran Belanja SPBE</span>
                        </div>
                    </div>
                    @if(!empty($data['budget']['labels']) && !empty($data['budget']['datasets']))
                    <div class="h-32">
                        <canvas id="budgetChart" class="w-full h-full"></canvas>
                    </div>
                    <div class="flex justify-center gap-8 mt-2 text-[8px] font-black uppercase tracking-widest text-slate-400">
                        <div class="flex items-center gap-2"><span class="w-4 h-2 rounded-sm bg-blue-800 shadow-sm"></span> TOTAL</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-2 rounded-sm bg-yellow-400 shadow-sm"></span> DISETUJUI</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-2 rounded-sm bg-rose-500 shadow-sm"></span> DITUNDA</div>
                    </div>
                    @else
                    <div class="flex-1 flex items-center justify-center text-slate-400 text-sm">
                        /* Lines 450-451 omitted */
                    </div>
                    @endif
                </div>

                <!-- Domain Changes -->
                <div class="col-span-3 col-start-10 row-start-4 glass-card rounded-2xl p-3 shadow-xl flex flex-col">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-[10px] font-black text-brand flex items-center gap-1.5">
                            <div class="p-1 bg-slate-100 rounded shadow-sm text-slate-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h4l2 3h6a1 1 0 01.894.553l2 4a1 1 0 010 .894l-2 4A1 1 0 0116 16H9l-2-3H4a1 1 0 01-1-1V4z"/></svg>
                            </div>
                            <span class="uppercase tracking-widest">DOMAIN Δ</span>
                        </div>
                        <button class="px-2 py-0.5 bg-yellow-400 text-[8px] font-black uppercase tracking-widest rounded-md text-slate-900 shadow-lg shadow-yellow-400/20 hover:bg-yellow-300 transition-all active:scale-95">FILTER</button>
                    </div>
                    @if(!empty($data['domainChanges']))
                    <div class="grid grid-cols-1 gap-1.5">
                        @foreach($data['domainChanges'] as $domain)
                        <div class="border border-white/40 rounded-xl p-2 flex items-center justify-between bg-white/40 hover:bg-white hover:shadow-md hover:border-brand/20 transition-all cursor-default group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl border border-white flex items-center justify-center bg-white shadow-sm group-hover:scale-110 transition-transform">
                                    @if($domain['change'] >= 0)
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    @else
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-[11px] font-black text-slate-800">{{ $domain['code'] }}</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Current: {{ number_format($domain['value'], 2) }}</div>
                                </div>
                            </div>
                            <div class="text-[11px] font-black px-2 py-1 rounded-lg {{ $domain['change'] >= 0 ? ($domain['change'] == 0 ? 'bg-slate-100 text-slate-500' : 'bg-emerald-50 text-emerald-600') : 'bg-rose-50 text-rose-600' }} shadow-sm">
                                {{ $domain['change'] > 0 ? '+' : '' }}{{ number_format($domain['change'], 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="flex-1 flex items-center justify-center text-slate-400 text-sm">
                        /* Lines 488-489 omitted */
                    </div>
                    @endif
                </div>

            </div>
        </main>
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

            // SPBE Implementation Index Radar Chart (D2001-D2004 from TAUVAL)
            const implementationCanvas = document.getElementById('implementationChart');
            if (implementationCanvas) {
                const implementationCtx = implementationCanvas.getContext('2d');

                // Create sophisticated gradients
                const gradientInstansi = implementationCtx.createRadialGradient(
                    implementationCanvas.width / 2, implementationCanvas.height / 2, 0,
                    implementationCanvas.width / 2, implementationCanvas.height / 2, 150
                );
                gradientInstansi.addColorStop(0, 'rgba(234, 179, 8, 0.1)');
                gradientInstansi.addColorStop(1, 'rgba(234, 179, 8, 0.4)');

                const gradientNasional = implementationCtx.createRadialGradient(
                    implementationCanvas.width / 2, implementationCanvas.height / 2, 0,
                    implementationCanvas.width / 2, implementationCanvas.height / 2, 150
                );
                gradientNasional.addColorStop(0, 'rgba(37, 92, 153, 0.1)');
                gradientNasional.addColorStop(1, 'rgba(37, 92, 153, 0.4)');

                const rawData = @json($data['implementationIndex']['datasets'] ?? []);
                const datasets = rawData.map((ds, i) => ({
                    ...ds,
                    backgroundColor: i === 0 ? gradientInstansi : gradientNasional,
                    borderColor: i === 0 ? '#eab308' : '#255c99',
                    borderWidth: 3,
                    pointBackgroundColor: i === 0 ? '#eab308' : '#255c99',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: i === 0 ? '#eab308' : '#255c99',
                    pointRadius: 4,
                    fill: true
                }));

                new Chart(implementationCtx, {
                    type: 'radar',
                    data: {
                        labels: @json($data['implementationIndex']['labels'] ?? []),
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: { top: 10, right: 30, bottom: 30, left: 30 }
                        },
                        scales: {
                            r: {
                                beginAtZero: true,
                                min: 0,
                                max: 5,
                                ticks: {
                                    display: true,
                                    stepSize: 1,
                                    font: { size: 8, weight: 'bold' },
                                    color: '#94a3b8',
                                    backdropColor: 'transparent'
                                },
                                pointLabels: {
                                    font: { size: 9, weight: '800' },
                                    color: '#475569',
                                    padding: 10
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.1)',
                                    lineWidth: 1
                                },
                                angleLines: { color: 'rgba(148, 163, 184, 0.1)' }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 11 },
                                padding: 10,
                                cornerRadius: 8,
                                displayColors: true
                            }
                        }
                    }
                });
            }

            // SPBE Trend Line Chart
            const spbeCanvas = document.getElementById('spbeChart');
            if (spbeCanvas) {
                const spbeCtx = spbeCanvas.getContext('2d');
                const gradient = spbeCtx.createLinearGradient(0, 0, 0, 150);
                gradient.addColorStop(0, 'rgba(31, 78, 140, 0.4)');
                gradient.addColorStop(1, 'rgba(31, 78, 140, 0)');

                const rawData = @json($data['spbeTrend']['datasets']);
                const datasets = rawData.map((ds, i) => ({
                    ...ds,
                    borderColor: i === 0 ? '#1f4e8c' : '#fbbf24',
                    backgroundColor: i === 0 ? gradient : 'transparent',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: i === 0,
                    pointRadius: 0,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: i === 0 ? '#1f4e8c' : '#fbbf24',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2
                }));

                new Chart(spbeCtx, {
                    type: 'line',
                    data: {
                        labels: @json($data['spbeTrend']['labels']),
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { intersect: false, mode: 'index' },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 5,
                                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                                ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(31, 78, 140, 0.9)',
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 11 },
                                padding: 12,
                                cornerRadius: 10,
                                displayColors: true
                            }
                        }
                    }
                });
            }

            // Pemdi Trend Line Chart
            const pemdiCanvas = document.getElementById('pemdiChart');
            if (pemdiCanvas) {
                const pemdiCtx = pemdiCanvas.getContext('2d');
                const gradient = pemdiCtx.createLinearGradient(0, 0, 0, 150);
                gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
                gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

                const rawData = @json($data['pemdiTrend']['datasets']);
                const datasets = rawData.map((ds, i) => ({
                    ...ds,
                    borderColor: i === 0 ? '#6366f1' : '#f43f5e',
                    backgroundColor: i === 0 ? gradient : 'transparent',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: i === 0,
                    pointRadius: 0,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: i === 0 ? '#6366f1' : '#f43f5e',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2
                }));

                new Chart(pemdiCtx, {
                    type: 'line',
                    data: {
                        labels: @json($data['pemdiTrend']['labels']),
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { intersect: false, mode: 'index' },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 5,
                                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                                ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(79, 70, 229, 0.9)',
                                padding: 12,
                                cornerRadius: 10
                            }
                        }
                    }
                });
            }

            // Budget Bar Chart
            const budgetCanvas = document.getElementById('budgetChart');
            if (budgetCanvas) {
                const budgetCtx = budgetCanvas.getContext('2d');
                new Chart(budgetCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($data['budget']['labels']),
                        datasets: @json($data['budget']['datasets']).map((ds, i) => ({
                            ...ds,
                            backgroundColor: i === 0 ? '#1e3a8a' : (i === 1 ? '#fbbf24' : '#f43f5e'),
                            borderRadius: 6,
                            barPercentage: 0.5,
                            categoryPercentage: 0.8
                        }))
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { top: 10 } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                                ticks: {
                                    font: { size: 10, weight: 'bold' },
                                    color: '#94a3b8',
                                    callback: function(value) { return value + ' M'; }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 10, weight: 'bold' }, color: '#64748b' }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e3a8a',
                                padding: 12,
                                cornerRadius: 10
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
