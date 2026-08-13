<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderAvailability extends Model
{
    protected $fillable = ['provider_id', 'day', 'start_time', 'end_time', 'status'];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}