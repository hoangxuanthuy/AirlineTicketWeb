<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['amount', 'date']; // Add your fillable fields here
}
