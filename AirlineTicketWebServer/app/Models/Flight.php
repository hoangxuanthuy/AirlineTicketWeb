<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight  extends Model
{
    use HasFactory;

    protected $table = 'Flight';
    protected $primaryKey = 'flight_id';
    public $timestamps = false;

    protected $fillable = [
        'flight_id', 
        'plane_id', 
        'departure_airport_id', 
        'arrival_airport_id', 
        'gate_id', 
        'flight_time', 
        'departure_date_time', 
        'unit_price'
    ];

    // Relationships
    public function plane()
    {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    public function departure_airport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    public function arrival_airport()
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }

    public function gate()
    {
        return $this->belongsTo(Gate::class, 'gate_id');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'flight_id');
    }

    public function intermediate()
    {
        return $this->hasMany(Intermediate::class, 'flight_id');
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'flight_id');
    }

    public function seat_flight()
    {
        return $this->hasMany(SeatFlight::class, 'flight_id');
    }

    public function revenue_month()
    {
        return $this->hasMany(RevenueMonth::class, 'flight_id');
    }
}
