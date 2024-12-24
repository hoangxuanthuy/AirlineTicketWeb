<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'Promotion';
    protected $primaryKey = 'promotion_id';
    public $timestamps = false;

    protected $fillable = [
        'promotion_id', 
        'promotion_name', 
        'start_date', 
        'end_date', 
        'discount_percentage'
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class, 'promotion_id');
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'promotion_id');
    }
}
