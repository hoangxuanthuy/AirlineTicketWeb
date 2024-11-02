<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $table = 'airports';
    protected $primaryKey = 'airport_id';
    public $timestamps = false;

    protected $fillable = ['airport_id', 'name', 'location'];

    // Relationships
    public function incomingFlights()
    {
        return $this->hasMany(Flight::class, 'destination_airport_id');
    }

    public function outgoingFlights()
    {
        return $this->hasMany(Flight::class, 'departure_airport_id');
    }
}
