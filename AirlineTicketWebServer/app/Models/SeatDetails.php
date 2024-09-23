<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatDetails extends Model
{
    protected $table = 'Seat_Details';
    protected $primaryKey = 'Seat_ID';
    public $timestamps = false;

    protected $fillable = [
        'Travel_Class_ID',
        'Flight_ID',
    ];

    public function flightDetails()
    {
        return $this->belongsTo(FlightDetails::class, 'Flight_ID');
    }

    public function travelClass()
    {
        return $this->belongsTo(TravelClass::class, 'Travel_Class_ID');
    }
}
