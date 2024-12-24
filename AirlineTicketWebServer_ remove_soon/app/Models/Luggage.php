<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luggage extends Model
{
    use HasFactory;

    protected $table = 'Luggage';
    protected $primaryKey = 'luggage_id';
    public $timestamps = false;

    protected $fillable = [
        'luggage_id', 
        'weight', 
        'price'
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class, 'luggage_id');
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'luggage_id');
    }
}
