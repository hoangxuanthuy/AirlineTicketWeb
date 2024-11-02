<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luggage extends Model
{
    use HasFactory;

    protected $table = 'luggages';
    protected $primaryKey = 'luggage_id';
    public $timestamps = false;

    protected $fillable = ['luggage_id', 'weight', 'price'];

    // Relationships
}
