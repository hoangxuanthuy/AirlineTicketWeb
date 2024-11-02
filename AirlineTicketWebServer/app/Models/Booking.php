<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id', 
        'aircraft_id', 
        'departure_airport_id', // Changed from start_airport_id
        'destination_airport_id', 
        'gate_id', 
        'flight_times', 
        'start_flight_time', 
        'price'
    ];

    // Relationships
    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id');
    }

    public function departureAirport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id'); // Changed from startAirport
    }

    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }

    public function flightGate()
    {
        return $this->belongsTo(FlightGate::class, 'gate_id');
    }
}
