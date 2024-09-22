<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['ticked_id', 'flight_id', 'seat_id', 'luggage_id', 'status'];
  
    public $timestamps = true;
}
