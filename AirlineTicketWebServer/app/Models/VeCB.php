<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeCB extends Model
{
    use HasFactory;

    protected $table = 'vecb';
    protected $primaryKey = 'MaVe';
    public $timestamps = false;

    protected $fillable = [
        'MaVe', 
        'MaGhe', 
        'MaKM', 
        'MaKH', 
        'MaHL', 
        'MaCB', 
        'NgayXuatVe', 
        'Tinhtrang'
    ];

    public function gheNgoi()
    {
        return $this->belongsTo(GheNgoi::class, 'MaGhe');
    }

    public function khuyenMai()
    {
        return $this->belongsTo(KhuyenMai::class, 'MaKM');
    }

    public function khach()
    {
        return $this->belongsTo(Khach::class, 'MaKH');
    }

    public function hanhLy()
    {
        return $this->belongsTo(HanhLy::class, 'MaHL');
    }

    public function chuyenBay()
    {
        return $this->belongsTo(ChuyenBay::class, 'MaCB');
    }
}
