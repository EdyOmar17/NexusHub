<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'is_working',
        'has_backup',
        'is_hacked',
        'hacked_description',
        'username',
        'password',
        'priority',
        'website_status',
        'server_name'
    ];
}
