<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UptimeHistory extends Model
{
    protected $table = 'uptime_history';

    protected $fillable = [
        'uptime_percentage',
        'total_sites',
        'online_sites',
    ];
}
