<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['instansi' => 'Kementerian Hak Asasi Manusia', 'anggaran' => 2534000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Kementerian Dalam Negeri', 'anggaran' => 90000000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Badan Pengusahaan Kawasan Perdagangan Bebas dan Pelabuhan Bebas Batam', 'anggaran' => 4596180000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Badan Pengatur Hilir Minyak dan Gas Bumi', 'anggaran' => 195000000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Badan Meteorologi, Klimatologi dan Geofisika', 'anggaran' => 200000000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Kementerian Energi dan Sumber Daya Mineral', 'anggaran' => 3000000000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Kementerian Hukum', 'anggaran' => 800000000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Badan Pusat Statistik', 'anggaran' => 3812400000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Kementerian Dalam Negeri', 'anggaran' => 556400000, 'rekomendasi' => 'Tidak Dilanjutkan'],
            ['instansi' => 'Kementerian Dalam Negeri', 'anggaran' => 750000000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Kementerian Dalam Negeri', 'anggaran' => 1200000000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Kementerian Dalam Negeri', 'anggaran' => 450000000, 'rekomendasi' => 'Dilanjutkan'],
            ['instansi' => 'Kementerian Dalam Negeri', 'anggaran' => 320000000, 'rekomendasi' => 'Tidak Dilanjutkan'],
            ['instansi' => 'Kementerian Dalam Negeri', 'anggaran' => 150000000, 'rekomendasi' => 'Tidak Dilanjutkan'],
        ];

        DB::table('clearance')->insert($data);
    }
}
