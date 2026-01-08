<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpbeData extends Model
{
    protected $table = 'spbe_data';

    protected $fillable = [
        'kode',
        'tahun',
        'nama_instansi',
        'kategori',
        'daerah',
        'nilai',
        'indeks',
    ];

    protected $casts = [
        'nilai' => 'array',
        'indeks' => 'decimal:10',
    ];

    /**
     * Get the latest data for a specific kode
     */
    public static function getLatestByKode(string $kode)
    {
        return static::where('kode', $kode)
            ->orderBy('tahun', 'desc')
            ->first();
    }

    /**
     * Get all data for the latest year
     */
    public static function getLatestYear()
    {
        $latestYear = static::max('tahun');
        return static::where('tahun', $latestYear)->get();
    }

    /**
     * Get frontend-friendly data (id, nama_instansi, indeks)
     */
    public function toFrontendArray(): array
    {
        return [
            'id' => $this->kode,
            'nama_instansi' => $this->nama_instansi,
            'indeks' => (float) $this->indeks,
        ];
    }
}
