<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = [
        'user_id',
        'owner_id',
        'properties_id',
        'room_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class,'owner_id');
    }

    public function properties()
    {
        return $this->belongsTo(Property::class,'properties_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class,'room_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class,'booking_id');
    }

}
