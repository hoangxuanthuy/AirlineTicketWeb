<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'khuyenmai';
    protected $primaryKey = 'MaKM';
    public $timestamps = false;

    protected $fillable = [
        'MaKM', 
        'TenKM', 
        'NgayBatDau', 
        'NgayKetThuc', 
        'PhanTramKM'
    ];

    public function phieuDat()
    {
        return $this->hasMany(PhieuDat::class, 'MaKM');
    }

    public function veCB()
    {
        return $this->hasMany(VeCB::class, 'MaKM');
    }
}
