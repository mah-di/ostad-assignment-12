<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_no',
        'number_of_seats',
    ];

    public function journeys()
    {
        return $this->hasMany(Journey::class);
    }

}
