<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;
    protected $table = 'airports';

    protected $fillable = ['airport_id', 'airport_name', 'address'];

    public $timestamps = false;
}
