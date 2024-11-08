<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intermediate extends Model
{
    use HasFactory;

    protected $table = 'Intermediate';
    protected $primaryKey = ['flight_id', 'intermediate_airport_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'airport_id', 
        'intermediate_airport_id', 
        'stopover_time',
        'note'
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function airport()
    {
        return $this->belongsTo(Airport::class, 'intermediate_airport_id');
    }
}
