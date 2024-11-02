<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'ticket_id';
    public $timestamps = false;

    protected $fillable = [
        'ticket_id', 
        'flight_id', 
        'account_id', 
        'class_id', 
        'promotion_id', 
        'issue_date', 
        'status', 
        'luggage_id' 
    ];

 
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function seatClass()
    {
        return $this->belongsTo(SeatClass::class, 'class_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function luggage()
    {
        return $this->belongsTo(Luggage::class, 'luggage_id'); 
    }
}
