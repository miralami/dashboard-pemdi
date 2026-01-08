# Implementasi Chart Capaian Indeks Implementasi Arsitektur SPBE

## Overview

Implementasi ini mengintegrasikan data dari TAUVAL API untuk menampilkan chart capaian indeks implementasi arsitektur SPBE pada dashboard. Chart menampilkan nilai D2001-D2004 (4 domain SPBE) dengan perbandingan nilai instansi dan rata-rata nasional.

## Dictionary/Mapping Domain

### Domain SPBE dari TAUVAL

Berdasarkan struktur data TAUVAL, terdapat 4 domain utama (D2001-D2004):

| Kode Domain | Nama Domain | Deskripsi |
|-------------|-------------|-----------||
| **D2001** | Kebijakan SPBE | Domain Kebijakan SPBE |
| **D2002** | Tata Kelola SPBE | Domain Tata Kelola SPBE |
| **D2003** | Manajemen SPBE | Domain Manajemen SPBE |
| **D2004** | Layanan SPBE | Domain Layanan SPBE |

## Struktur Data

### Response TAUVAL API

```json
[
    {
        "kode": "1030",
        "tahun": "2025",
        "nama_instansi": "Kementerian Koordinator Bidang Pembangunan Manusia dan Kebudayaan",
        "kategori": "Kementerian",
        "daerah": "Pusat",
        "nilai": {
            "D2001": "0.0000000000",
            "A2001": "5.0000000000",
            "D2002": "2.4000000000",
            "A2002": "3.7500000000",
            "A2003": "3.7500000000",
            "A2004": "5.0000000000",
            "D2003": "1.0909090909",
            "A2005": "3.0000000000",
            "A2006": "2.6666666667",
            "D2004": "1.3901098901",
            "A2007": "4.3000000000",
            "A2008": "5.0000000000",
            "indeks": "4.2125000000"
        }
    }
]
```

### Output Chart Data

```json
{
    "labels": [
        "Kebijakan SPBE",
        "Tata Kelola SPBE",
        "Manajemen SPBE",
        "Layanan SPBE"
    ],
    "datasets": [
        {
            "label": "Instansi",
            "data": [0.0, 2.4, 1.09, 1.39],
            "backgroundColor": "rgba(234, 179, 8, 0.5)",
            "borderColor": "rgb(234, 179, 8)",
            "borderWidth": 2,
            "pointBackgroundColor": "rgb(234, 179, 8)",
            "pointBorderColor": "#fff",
            "pointHoverBackgroundColor": "#fff",
            "pointHoverBorderColor": "rgb(234, 179, 8)"
        },
        {
            "label": "Nasional",
            "data": [2.5, 3.0, 2.8, 3.2],
            "backgroundColor": "rgba(37, 92, 153, 0.5)",
            "borderColor": "rgb(37, 92, 153)",
            "borderWidth": 2,
            "pointBackgroundColor": "rgb(37, 92, 153)",
            "pointBorderColor": "#fff",
            "pointHoverBackgroundColor": "#fff",
            "pointHoverBorderColor": "rgb(37, 92, 153)"
        }
    ]
}
```

## Implementasi

### 1. Service Layer

#### `DashboardService.php`

Service yang memproses data untuk dashboard:

**Constants:**
- `DOMAIN_MAPPING` - Dictionary mapping 4 domain TAUVAL (D2001-D2004)

**Methods:**
- `buildArchitectureChartFromTauval(array $nilai, ?string $tahun)` - Convert data TAUVAL menjadi format chart dengan nilai instansi dan nasional
- `getNationalAveragesByDomain(?string $tahun)` - Hitung rata-rata nasional untuk setiap domain

### 2. Chart Implementation

Chart menggunakan Chart.js dengan tipe **radar chart** untuk menampilkan perbandingan Instansi vs Nasional.

**File:** `resources/views/dashboard.blade.php`

```javascript
const implementationCtx = document.getElementById('implementationChart').getContext('2d');
new Chart(implementationCtx, {
    type: 'radar',
    data: {
        labels: @json($data['implementationIndex']['labels'] ?? []),
        datasets: @json($data['implementationIndex']['datasets'] ?? [])
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            r: {
                beginAtZero: true,
                max: 5,
                ticks: { 
                    display: true,
                    stepSize: 1
                }
            }
        },
        plugins: { 
            legend: { display: false }
        }
    }
});
```

### 3. Data Source

Data berasal dari:
- **TAUVAL API** - Diambil dan disimpan ke tabel `spbe_data`
- Field `nilai` di database berisi object JSON dengan key D2001, D2002, D2003, D2004
- Nilai nasional dihitung dari rata-rata semua instansi pada tahun yang sama

## Flow Data

1. User mengakses dashboard dengan kode instansi
2. `DashboardController` memanggil `DashboardService::getDashboardData($kode)`
3. `DashboardService` mengambil data SPBE dari database (`spbe_data` table)
4. Data `nilai` field berisi D2001-D2004 dari TAUVAL
5. `buildArchitectureChartFromTauval()` memproses nilai instansi
6. `getNationalAveragesByDomain()` menghitung rata-rata nasional dari semua instansi pada tahun yang sama
7. Data chart dikirim ke view sebagai `$data['implementationIndex']`
8. Chart.js merender radar chart di dashboard

## Interpretasi Data

- **Instansi (Kuning)**: Nilai D2001-D2004 untuk instansi spesifik (0-5)
- **Nasional (Biru)**: Rata-rata nilai D2001-D2004 dari semua instansi pada tahun yang sama (0-5)

Nilai berkisar 0-5 dimana:
- 0-1.5: Sangat Kurang
- 1.5-2.5: Kurang
- 2.5-3.5: Cukup
- 3.5-4.5: Baik
- 4.5-5: Sangat Baik

## Notes

- Chart menggunakan data dari TAUVAL API yang disimpan di tabel `spbe_data`
- Nilai nasional dihitung real-time dengan caching 10 menit
- Chart type: Radar untuk visualisasi multi-dimensional
- Scale: 0-5 dengan step 1
- Data source: Field `nilai` JSON object di database
- Domains: Kebijakan SPBE, Tata Kelola SPBE, Manajemen SPBE, Layanan SPBE
