<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiaData extends Model
{
    protected $table = 'sia_data';

    protected $fillable = [
        'instansi',
        'id_kategori_instansi',
        'id_daerah',
        'tingkat_kematangan',
        'proses_bisnis_as_is',
        'layanan_as_is',
        'data_info_as_is',
        'aplikasi_as_is',
        'infra_as_is',
        'keamanan_as_is',
        'proses_bisnis_to_be',
        'layanan_to_be',
        'data_info_to_be',
        'aplikasi_to_be',
        'infra_to_be',
        'keamanan_to_be',
        'peta_rencana',
        'clearance',
        'reviueval',
    ];

    protected $casts = [
        'tingkat_kematangan' => 'integer',
        'proses_bisnis_as_is' => 'integer',
        'layanan_as_is' => 'integer',
        'data_info_as_is' => 'integer',
        'aplikasi_as_is' => 'integer',
        'infra_as_is' => 'integer',
        'keamanan_as_is' => 'integer',
        'proses_bisnis_to_be' => 'integer',
        'layanan_to_be' => 'integer',
        'data_info_to_be' => 'integer',
        'aplikasi_to_be' => 'integer',
        'infra_to_be' => 'integer',
        'keamanan_to_be' => 'integer',
        'peta_rencana' => 'boolean',
        'clearance' => 'boolean',
        'reviueval' => 'boolean',
    ];

    /**
     * Get data by institution name (partial match)
     */
    public static function getByInstitutionName(string $name)
    {
        return static::where('instansi', 'like', '%' . $name . '%')->first();
    }

    /**
     * Get data by exact institution name
     */
    public static function getByExactInstitutionName(string $name)
    {
        return static::where('instansi', $name)->first();
    }
}
