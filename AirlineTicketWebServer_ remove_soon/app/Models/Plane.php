<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    use HasFactory;

    protected $table = 'Plane';
    protected $primaryKey = 'plane_id';
    public $timestamps = false;

    protected $fillable = [
        'plane_id', 
        'plane_name', 
        'airline_id', 
        'first_class_seats', 
        'second_class_seats'
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id');
    }

    public function seat()
    {
        return $this->hasMany(Seat::class, 'plane_id');
    }

    public function flight()
    {
        return $this->hasMany(Flight::class, 'plane_id');
    }
}
