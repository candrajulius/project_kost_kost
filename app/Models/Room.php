<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $fillable = [
        'properties_id',
        'room_number',
        'status',
        'price',
    ];

    public function properties(){
        return $this->belongsTo(Property::class,'properties_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class,'room_facilities')->withTimestamps();
    }

    public function room()
    {
        return $this->hasMany(Booking::class);
    }
}
