<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardCache extends Model
{
    protected $table = 'dashboard_cache';

    protected $fillable = ['key', 'json_data'];

    protected $casts = [
        'json_data' => 'array',
    ];
}
