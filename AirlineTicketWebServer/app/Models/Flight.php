<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $table = 'flights';
    protected $primaryKey = 'flight_id';
    public $timestamps = false;

    protected $fillable = [
        'flight_id', 
        'aircraft_id', 
        'destination_airport_id', 
        'departure_airport_id', 
        'departure_time', 
        'arrival_time', 
        'price', 
        'gate_id' // Added gate_id here
    ];

    // Relationships
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'flight_id');
    }

    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }

    public function departureAirport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id');
    }

    public function gate()
    {
        return $this->belongsTo(FlightGate::class, 'gate_id'); // Added relationship to FlightGate
    }
}
