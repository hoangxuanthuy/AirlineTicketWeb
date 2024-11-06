<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatFlight extends Model
{
    use HasFactory;

    protected $table = 'SeatFlight';
    protected $primaryKey = ['seat_id', 'flight_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'seat_id', 
        'flight_id', 
        'status'
    ];

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }
}
