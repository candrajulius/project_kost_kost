<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_date',
        'payment_method',
        'status',
    ];

    public function bookings()
    {
        return $this->belongsTo(Booking::class,'booking_id');
    }
}
