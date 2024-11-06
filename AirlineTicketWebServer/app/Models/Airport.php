<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $table = 'Airport';
    protected $primaryKey = 'airport_id';
    public $timestamps = false;

    protected $fillable = [
        'airport_id', 
        'airport_name', 
        'address'
    ];

    // Relationships
    public function departure_airport()
    {
        return $this->hasMany(Flight::class, 'departure_airport_id');
    }

    public function arrival_airport()
    {
        return $this->hasMany(Flight::class, 'arrival_airport_id');
    }

    public function gate()
    {
        return $this->hasMany(Gate::class, 'airport_id');
    }

    public function intermediate()
    {
        return $this->hasMany(Intermediate::class, 'intermediate_airport_id');
    }
}
