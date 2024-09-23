<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    protected $table = 'Passenger';
    protected $primaryKey = 'Passenger_ID';
    public $timestamps = false;

    protected $fillable = [
        'P_FirstName',
        'P_LastName',
        'P_Email',
        'P_PhoneNumber',
        'P_Address',
        'P_City',
        'P_State',
        'P_Zipcode',
        'P_Country',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'Passenger_ID');
    }
}
