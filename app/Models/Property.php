<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    //
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'description',
        'type',
        'total_rooms',
        'available_rooms',
        'price_per_month',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function transactionLog()
    {
        return $this->hasMany(TransactionLog::class);
    }
}
