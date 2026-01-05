<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DashboardCache;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'profile' => [
                'name' => 'Kementerian Koordinator Bidang Politik dan Keamanan',
                'minister' => 'Prof. Dr. Budi Gunawan, SH, M.Si, Ph.D',
                'logo' => asset('images/Kemenkopolkam.svg'),
            ],
            'spbeIndex' => [
                'value' => 3.08,
                'label' => 'Baik'
            ],
            'totalApplications' => [
                'value' => 2,
                'new' => 0
            ],
            'maturityIndex' => [
                'labels' => ['Tata Kelola', 'Manajemen', 'Layanan', 'Kebijakan'],
                'datasets' => [
                    [
                        'label' => 'Instansi',
                        'data' => [3.5, 4.2, 3.8, 4.5],
                        'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                        'borderColor' => 'rgba(255, 206, 86, 1)',
                        'pointBackgroundColor' => 'rgba(255, 206, 86, 1)',
                    ],
                    [
                        'label' => 'Nasional',
                        'data' => [2.5, 3.0, 2.8, 3.2],
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'pointBackgroundColor' => 'rgba(54, 162, 235, 1)',
                    ]
                ]
            ],
            'governanceStatus' => [
                ['component' => 'Arsitektur SPBE', 'status' => 'Sudah', 'color' => 'bg-green-100 text-green-800'],
                ['component' => 'Peta Rencana SPBE', 'status' => 'Sudah', 'color' => 'bg-green-100 text-green-800'],
                ['component' => 'Lokus Prioritas 2025-2029', 'status' => 'Ya', 'color' => 'bg-blue-100 text-blue-800'],
                ['component' => 'Lokus RPJMN', 'status' => 'Ya', 'color' => 'bg-blue-100 text-blue-800'],
                ['component' => 'Layanan Siklus Hidup', 'status' => 'Tidak', 'color' => 'bg-orange-100 text-orange-800'],
                ['component' => 'Portal Keterpaduan Layanan Digital', 'status' => 'Tidak', 'color' => 'bg-orange-100 text-orange-800'],
                ['component' => 'Kebijakan Internal', 'status' => 'Sudah', 'color' => 'bg-green-100 text-green-800'],
                ['component' => 'Audit Aplikasi', 'status' => 'Belum', 'color' => 'bg-red-100 text-red-800'],
                ['component' => 'Audit Infrastruktur', 'status' => 'Belum', 'color' => 'bg-red-100 text-red-800'],
                ['component' => 'Audit Keamanan', 'status' => 'Belum', 'color' => 'bg-red-100 text-red-800'],
                ['component' => 'Digital Government Award', 'status' => 'Tidak', 'color' => 'bg-orange-100 text-orange-800'],
            ],
            'recommendations' => [
                [
                    'title' => 'Audit Keamanan',
                    'description' => 'Melakukan penilaian keamanan aplikasi dan jaringan internal tahun 2025',
                    'icon' => 'lock'
                ],
                [
                    'title' => 'Audit Infrastruktur',
                    'description' => 'Evaluasi infrastruktur SPBE tahun 2025',
                    'icon' => 'server'
                ]
            ],
            'spbeTrend' => [
                'labels' => ['2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025'],
                'datasets' => [
                    [
                        'label' => 'Instansi',
                        'data' => [2.1, 1.9, 2.6, 2.0, 3.0, 3.1, 2.8, 3.5],
                        'borderColor' => '#6366f1',
                        'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                        'fill' => true,
                        'tension' => 0.4
                    ],
                    [
                        'label' => 'Nasional',
                        'data' => [2.5, 2.4, 2.5, 2.6, 3.1, 3.2, 3.0, 3.4],
                        'borderColor' => '#fca5a5',
                        'borderDash' => [5, 5],
                        'tension' => 0.4
                    ]
                ]
            ],
            'pemdiTrend' => [
                'labels' => ['2026', '2027', '2028', '2029'],
                'datasets' => [
                    [
                        'label' => 'Instansi',
                        'data' => [3.2, 2.6, 3.1, 1.8],
                        'borderColor' => '#6366f1',
                        'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                        'fill' => true,
                        'tension' => 0.4
                    ],
                    [
                        'label' => 'Nasional',
                        'data' => [3.0, 3.1, 3.0, 2.2],
                        'borderColor' => '#fca5a5',
                        'borderDash' => [5, 5],
                        'tension' => 0.4
                    ]
                ]
            ],
            'budget' => [
                'labels' => ['2018', '2019', '2020', '2021', '2022', '2023', '2024'],
                'datasets' => [
                    [
                        'label' => 'Total Anggaran',
                        'data' => [8.5, 9.0, 8.8, 8.2, 9.1, 9.3, 9.5],
                        'backgroundColor' => '#1e40af'
                    ],
                    [
                        'label' => 'Anggaran Disetujui',
                        'data' => [8.2, 8.8, 8.5, 8.0, 8.9, 9.0, 9.2],
                        'backgroundColor' => '#fbbf24'
                    ],
                    [
                        'label' => 'Anggaran Ditunda',
                        'data' => [0.3, 0.2, 0.3, 0.2, 1.5, 0.8, 0.0],
                        'backgroundColor' => '#991b1b'
                    ]
                ]
            ],
            'domainChanges' => [
                ['code' => 'D1', 'value' => 3.80, 'change' => 0.40, 'positive' => true],
                ['code' => 'D2', 'value' => 2.50, 'change' => 0.20, 'positive' => true],
                ['code' => 'D3', 'value' => 1.00, 'change' => -0.18, 'positive' => false],
                ['code' => 'D4', 'value' => 3.74, 'change' => 0.00, 'positive' => true],
            ]
        ];

        DashboardCache::updateOrCreate(
            ['key' => 'dashboard_data'],
            ['json_data' => $data]
        );
    }
}
