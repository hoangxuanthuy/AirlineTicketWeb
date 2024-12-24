<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $table = 'Parameter';
    public $timestamps = false;

    protected $fillable = [
        'min_flight_time', 
        'max_intermediate_airport', 
        'min_stopover_time', 
        'max_stopover_time', 
        'latest_booking_time', 
        'latest_cancellation_time'
    ];
}
