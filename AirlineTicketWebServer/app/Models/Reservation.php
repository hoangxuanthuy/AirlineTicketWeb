<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'Reservation';
    protected $primaryKey = 'Reservation_ID';
    public $timestamps = false;

    protected $fillable = [
        'Passenger_ID',
        'Seat_ID',
        'Date_Of_Reservation',
    ];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'Passenger_ID');
    }

    public function seatDetails()
    {
        return $this->belongsTo(SeatDetails::class, 'Seat_ID');
    }
}
