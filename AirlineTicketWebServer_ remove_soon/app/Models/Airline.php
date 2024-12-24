<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $table = 'Airline';
    protected $primaryKey = 'airline_id';
    public $timestamps = false;

    protected $fillable = [
        'airline_id', 
        'airline_name'
    ];

    // Relationships
    public function plane()
    {
        return $this->hasMany(Plane::class, 'airline_id');
    }
}
