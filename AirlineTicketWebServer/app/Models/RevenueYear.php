<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueYear extends Model
{
    use HasFactory;

    protected $table = 'RevenueYear';
    protected $primaryKey = 'year';
    public $timestamps = false;

    protected $fillable = [
        'year', 
        'total_revenue'
    ];

    public function revanueDetailYear()
    {
        return $this->hasMany(RevanueDetailYear::class, 'year');
    }
}
