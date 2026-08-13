<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceArea extends Model
{
    protected $fillable = [
        'city_name',
        'state',
        'zipcode',
        'status',
    ];
}
