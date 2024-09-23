<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightCost extends Model
{
    protected $table = 'Flight_Cost';
    protected $primaryKey = ['Seat_ID', 'Valid_From_Date'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'Valid_To_Date',
        'Cost',
    ];

    public function seatDetails()
    {
        return $this->belongsTo(SeatDetails::class, 'Seat_ID');
    }

    public function validFrom()
    {
        return $this->belongsTo(Calendar::class, 'Valid_From_Date');
    }

    public function validTo()
    {
        return $this->belongsTo(Calendar::class, 'Valid_To_Date');
    }
}
