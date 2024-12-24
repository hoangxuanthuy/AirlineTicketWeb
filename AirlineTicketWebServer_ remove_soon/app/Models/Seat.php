<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $table = 'Seat';
    protected $primaryKey = 'seat_id';
    public $timestamps = false;

    protected $fillable = [
        'seat_id', 
        'seat_class_id', 
        'plane_id'
    ];

    // Relationships
    public function seatClass()
    {
        return $this->belongsTo(SeatClass::class, 'seat_class_id');
    }

    public function plane()
    {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'seat_id');
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'seat_id');
    }

    public function seatFlight()
    {
        return $this->hasMany(SeatFlight::class, 'seat_id');
    }
}
