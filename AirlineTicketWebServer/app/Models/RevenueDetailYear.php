<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueDetailYear extends Model
{
    use HasFactory;

    protected $table = 'RevenueDetailYear ';
    protected $primaryKey = 'year_report_id';
    public $timestamps = false;

    protected $fillable = [
        'year_report_id', 
        'month_report_id', 
        'year', 
        'number_of_flights', 
        'revenue', 
        'revenue_ratio'
    ];

    public function revenueMonth()
    {
        return $this->belongsTo(RevenueMonth::class, 'month_report_id');
    }
    public function revenueYear()
    {
        return $this->belongsTo(RevenueYear::class, 'year_report_id');
    }
}
