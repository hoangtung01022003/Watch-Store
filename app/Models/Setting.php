<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'facebook_url',
        'zalo_url',
        'phone',
    ];
}
