<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    use HasFactory;

    protected $fillable = [
        'trip_id',
        'route_id',
        'journey_id',
        'passenger_email',
        'payable',
        'pin',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'passenger_email', 'email', 'passenger');
    }

}
