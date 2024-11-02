<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatClass extends Model
{
    use HasFactory;

    protected $table = 'seat_classes';
    protected $primaryKey = 'class_id';
    public $timestamps = false;

    protected $fillable = ['class_id', 'name', 'price'];

    // Relationships
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'class_id');
    }
}
