<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_id',
        'destination_id',
        'name',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class)->orderBy('id', 'desc');
    }

    public function origin()
    {
        return $this->belongsTo(Stop::class, 'origin_id', 'id', 'origin');
    }

    public function destination()
    {
        return $this->belongsTo(Stop::class, 'destination_id', 'id', 'destination');
    }

    // Don't eager load this
    public function stops()
    {
        if ($this->status == "up") return $this->belongsToMany(Stop::class, 'route_stops');

        return $this->belongsToMany(Stop::class, 'route_stops')->orderBy('created_at', 'desc');
    }

}
