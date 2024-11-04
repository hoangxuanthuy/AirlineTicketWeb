<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MayBay extends Model
{
    use HasFactory;

    protected $table = 'maybay';
    protected $primaryKey = 'MaMB';
    public $timestamps = false;

    protected $fillable = [
        'MaMB', 
        'TenMB', 
        'MaHB', 
        'SLHang1', 
        'SLHang2'
    ];

    public function hangBay()
    {
        return $this->belongsTo(HangBay::class, 'MaHB');
    }

    public function gheNgoi()
    {
        return $this->hasMany(GheNgoi::class, 'MaMB');
    }

    public function chuyenBay()
    {
        return $this->hasMany(ChuyenBay::class, 'MaMB');
    }
}
