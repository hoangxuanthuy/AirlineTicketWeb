<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOffering extends Model
{
    protected $table = 'Service_Offering';
    protected $primaryKey = ['Travel_Class_ID', 'Service_ID'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'Offered_YN',
        'From_Month',
        'To_Month',
    ];

    public function travelClass()
    {
        return $this->belongsTo(TravelClass::class, 'Travel_Class_ID');
    }

    public function flightService()
    {
        return $this->belongsTo(FlightService::class, 'Service_ID');
    }
}
