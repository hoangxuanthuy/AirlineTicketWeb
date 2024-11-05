<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueDetailYear extends Model
{
    use HasFactory;

    protected $table = 'ct_bcdt_nam';
    protected $primaryKey = 'MaBCN';
    public $timestamps = false;

    protected $fillable = [
        'MaBCN', 
        'MaBCT', 
        'Nam', 
        'SoChuyenBay', 
        'DoanhThu', 
        'TiLe'
    ];

    public function ct_bcdt_thang()
    {
        return $this->belongsTo(CT_BCDT_Thang::class, 'MaBCT');
    }
    public function ct_bcdt_nam()
    {
        return $this->belongsTo(BCDT_Nam::class, 'MaBCN');
    }
}
