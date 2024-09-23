<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightDetails extends Model
{
    protected $table = 'flight_details'; // Use snake_case
    protected $primaryKey = 'Flight_ID';
    public $timestamps = false;

    protected $fillable = [
        'Source_Airport_ID',
        'Destination_Airport_ID',
        'Departure_Date_Time',
        'Arrival_Date_Time',
        'Airplane_Type',
    ];

    public function sourceAirport()
    {
        return $this->belongsTo(Airport::class, 'Source_Airport_ID');
    }

    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class, 'Destination_Airport_ID');
    }
}
