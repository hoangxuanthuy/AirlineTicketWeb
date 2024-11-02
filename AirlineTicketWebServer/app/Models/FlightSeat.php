<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightSeat extends Model
{
    use HasFactory;

    protected $table = 'flight_seats';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id', 
        'flight_id', 
        'status'
    ];

    // Relationships
    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }
}
