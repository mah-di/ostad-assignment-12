<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'journey_id',
        'route_id',
        'origin_id',
        'destination_id',
    ];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function origin()
    {
        return $this->belongsTo(Stop::class, 'origin_id', 'id', 'origin');
    }

    public function destination()
    {
        return $this->belongsTo(Stop::class, 'destination_id', 'id', 'destination');
    }

}
