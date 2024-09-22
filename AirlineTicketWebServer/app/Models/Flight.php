<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
      protected $table = 'flights';

      protected $fillable = ['plane_id', 'start_airport_id', 'end_airport_id', 'time_start', 'time_end', 'flight_time'];
  
      public $timestamps = false;
}
