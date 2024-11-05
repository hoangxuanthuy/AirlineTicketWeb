<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'phieudat';
    protected $primaryKey = 'MaPD';
    public $timestamps = false;

    protected $fillable = [
        'MaPD', 
        'MaGhe', 
        'MaCB', 
        'MaKH', 
        'MaHL', 
        'MaKM', 
        'TinhTrang', 
        'NgayXuatVe'
    ];

    public function chuyenBay()
    {
        return $this->belongsTo(ChuyenBay::class, 'MaCB');
    }

    public function gheNgoi()
    {
        return $this->belongsTo(GheNgoi::class, 'MaGhe');
    }

    public function khach()
    {
        return $this->belongsTo(Khach::class, 'MaKH');
    }

    public function hanhLy()
    {
        return $this->belongsTo(HanhLy::class, 'MaHL');
    }

    public function khuyenMai()
    {
        return $this->belongsTo(KhuyenMai::class, 'MaKM');
    }
}
