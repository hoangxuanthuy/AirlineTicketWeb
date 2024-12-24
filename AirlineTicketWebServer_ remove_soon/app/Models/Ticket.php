<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'Ticket';
    protected $primaryKey = 'ticket_id';
    public $timestamps = false;

    protected $fillable = [
        'ticket_id', 
        'seat_id', 
        'promotion_id', 
        'client_id', 
        'luggage_id', 
        'flight_id', 
        'ticket_issuance_date', 
        'status'
    ];

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function luggage()
    {
        return $this->belongsTo(Luggage::class, 'luggage_id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }
}
