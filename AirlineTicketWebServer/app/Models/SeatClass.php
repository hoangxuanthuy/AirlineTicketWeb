<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatClass extends Model
{
    use HasFactory;

    protected $table = 'SeatClass';
    protected $primaryKey = 'seat_class_id';
    public $timestamps = false;

    protected $fillable = [
        'seat_class_id', 
        'seat_class_name', 
        'price_ratio'
    ];

    public function seat()
    {
        return $this->hasMany(Seat::class, 'seat_class_id');
    }
}
