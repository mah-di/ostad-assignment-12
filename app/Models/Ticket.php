<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'seat_id',
        'fare_id',
    ];

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function fare()
    {
        return $this->belongsTo(Fare::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

}
