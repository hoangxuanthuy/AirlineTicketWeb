<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightGate extends Model
{
    use HasFactory;

    protected $table = 'flight_gates';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id', 'airport_id'];

    // Relationships
    public function airport()
    {
        return $this->belongsTo(Airport::class, 'airport_id');
    }

    public function flights()
    {
        return $this->hasMany(Flight::class, 'gate_id');
    }
}
