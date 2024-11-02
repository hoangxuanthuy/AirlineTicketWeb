<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    use HasFactory;

    protected $table = 'aircrafts';
    protected $primaryKey = 'aircraft_id';
    public $timestamps = false;

    protected $fillable = ['aircraft_id', 'name', 'first_class_seats', 'economy_class_seats'];

    // Relationships
    public function flights()
    {
        return $this->hasMany(Flight::class, 'aircraft_id');
    }
}
