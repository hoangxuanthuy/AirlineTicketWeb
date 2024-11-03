<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuyenBay extends Model
{
    use HasFactory;

    protected $table = 'chuyenbay';
    protected $primaryKey = 'MaCB';
    public $timestamps = false;

    protected $fillable = [
        'MaCB', 
        'MaMB', 
        'MaSBDi', 
        'MaSBDen', 
        'MaCong', 
        'TGBay', 
        'NgayGioBay', 
        'DonGia'
    ];

    // Relationships
    public function mayBay()
    {
        return $this->belongsTo(MayBay::class, 'MaMB');
    }

    public function sanBayDi()
    {
        return $this->belongsTo(SanBay::class, 'MaSBDi');
    }

    public function sanBayDen()
    {
        return $this->belongsTo(SanBay::class, 'MaSBDen');
    }

    public function congBay()
    {
        return $this->belongsTo(CongBay::class, 'MaCong');
    }

    public function phieuDat()
    {
        return $this->hasMany(PhieuDat::class, 'MaCB');
    }

    public function trungGian()
    {
        return $this->hasMany(TrungGian::class, 'MaCB');
    }

    public function veCB()
    {
        return $this->hasMany(VeCB::class, 'MaCB');
    }

    public function gheChuyenBay()
    {
        return $this->hasMany(GheChuyenBay::class, 'MaCB');
    }

    public function ct_bcdt_thang()
    {
        return $this->hasMany(CT_BCDT_Thang::class, 'MaCB');
    }
}
