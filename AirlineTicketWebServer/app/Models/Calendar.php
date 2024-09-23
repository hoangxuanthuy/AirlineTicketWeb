<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'Calendar';
    protected $primaryKey = 'Day_Date';
    public $timestamps = false;

    protected $fillable = [
        'Business_Day_YN',
    ];
}
