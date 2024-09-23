<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightService extends Model
{
    protected $table = 'Flight_Service';
    protected $primaryKey = 'Service_ID';
    public $timestamps = false;

    protected $fillable = [
        'Service_Name',
    ];

    public function serviceOffering()
    {
        return $this->hasMany(ServiceOffering::class, 'Service_ID');
    }
}
