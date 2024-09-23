<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $table = 'Airport';
    protected $primaryKey = 'Airport_ID';
    public $timestamps = false;

    protected $fillable = [
        'AirportName',
        'AirportCity',
        'AirportCountry',
    ];

    public function flightDetailsSource()
    {
        return $this->hasMany(FlightDetails::class, 'Source_Airport_ID');
    }

    public function flightDetailsDestination()
    {
        return $this->hasMany(FlightDetails::class, 'Destination_Airport_ID');
    }
}
