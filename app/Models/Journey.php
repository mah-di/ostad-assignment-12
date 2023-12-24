<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'route_id',
        'departure',
        'arrival',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function getDeparture()
    {
        $dt = new DateTime($this->departure);

        return $dt->format('h:i:s A | d M Y');
    }

    public function getDepartureDate()
    {
        $dt = new DateTime($this->departure);

        return $dt->format('d M Y');
    }

    public function getArrival()
    {
        $dt = new DateTime($this->arrival);

        return $dt->format('h:i:s A | d M Y');
    }

}
