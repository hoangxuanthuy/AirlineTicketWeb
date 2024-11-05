<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueMonth extends Model
{
    use HasFactory;

    protected $table = 'ct_bcdt_thang';
    protected $primaryKey = 'MaBCT';
    public $timestamps = false;

    protected $fillable = [
        'MaBCT', 
        'Thang', 
        'MaCB', 
        'SoVeHang1', 
        'SoVeHang2', 
        'DoanhThu', 
        'TiLe'
    ];

    // Relationships
    public function chuyenBay()
    {
        return $this->belongsTo(ChuyenBay::class, 'MaCB');
    }

    public function bcdtNam()
    {
        return $this->belongsTo(BCDT_Nam::class, 'MaBCT');
    }
}
