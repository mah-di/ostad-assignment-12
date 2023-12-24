<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function journeyOrigin()
    {
        return $this->hasMany(Journey::class, 'origin_id', 'id');
    }

    public function journeyDestination()
    {
        return $this->hasMany(Journey::class, 'destination_id', 'id');
    }

    public function tripOrigin()
    {
        return $this->hasMany(Trip::class, 'origin_id', 'id');
    }

    public function tripDestination()
    {
        return $this->hasMany(Trip::class, 'destination_id', 'id');
    }

    public function fareOrigin()
    {
        return $this->hasMany(Fare::class, 'origin_id', 'id');
    }

    public function fareDestination()
    {
        return $this->hasMany(Fare::class, 'destination_id', 'id');
    }

    public function routes()
    {
        return $this->belongsToMany(Route::class);
    }

}
