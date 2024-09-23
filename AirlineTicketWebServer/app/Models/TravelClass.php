<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelClass extends Model
{
    protected $table = 'Travel_Class';
    protected $primaryKey = 'Travel_Class_ID';
    public $timestamps = false;

    protected $fillable = [
        'Travel_Class_Name',
        'Travel_Class_Capacity',
    ];

    public function seatDetails()
    {
        return $this->hasMany(SeatDetails::class, 'Travel_Class_ID');
    }

    public function serviceOffering()
    {
        return $this->hasMany(ServiceOffering::class, 'Travel_Class_ID');
    }
}
