<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueMonth extends Model
{
    use HasFactory;

    protected $table = 'RevenueMonth';
    protected $primaryKey = 'month_report_id';
    public $timestamps = false;

    protected $fillable = [
        'month_report_id', 
        'month', 
        'flight_id', 
        'first_class_tickets', 
        'second_class_tickets', 
        'revenue', 
        'revenue_ratio'
    ];

    // Relationships
    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function revenueYear()
    {
        return $this->belongsTo(RevenueYear::class, 'month_report_id');
    }
}
