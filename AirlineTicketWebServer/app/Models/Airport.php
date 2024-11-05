<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $table = 'sanbay';
    protected $primaryKey = 'MaSB';
    public $timestamps = false;

    protected $fillable = [
        'MaSB', 
        'TenSB', 
        'Diachi'
    ];

    // Relationships
    public function chuyenBayDi()
    {
        return $this->hasMany(ChuyenBay::class, 'MaSBDi');
    }

    public function chuyenBayDen()
    {
        return $this->hasMany(ChuyenBay::class, 'MaSBDen');
    }

    public function congBay()
    {
        return $this->hasMany(CongBay::class, 'MaSB');
    }

    public function trungGian()
    {
        return $this->hasMany(TrungGian::class, 'MaSBTG');
    }
}
