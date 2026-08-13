<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'booking_no', 'customer_id', 'provider_id', 'service_id',
        'booking_date', 'booking_time', 'address', 'amount',
        'status', 'payment_status', 'remarks',
        'cancelled_by', 'cancelled_at', 'cancellation_reason', 'completed_at',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function review()
{
    return $this->hasOne(Review::class);
}
}