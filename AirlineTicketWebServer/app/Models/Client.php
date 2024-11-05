<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'khach';
    protected $primaryKey = 'MaKH';
    public $timestamps = false;

    protected $fillable = [
        'MaKH', 
        'Ten', 
        'CCCD', 
        'Sdt', 
        'GioiTinh', 
        'NgaySinh', 
        'QuocGia'
    ];

    // Relationships
    public function phieuDat()
    {
        return $this->hasMany(PhieuDat::class, 'MaKH');
    }

    public function veCB()
    {
        return $this->hasMany(VeCB::class, 'MaKH');
    }

    public function taiKhoan()
    {
        return $this->hasOne(TaiKhoan::class, 'MaTK', 'MaKH');
    }
}
