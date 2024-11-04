<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GheChuyenBay extends Model
{
    use HasFactory;

    protected $table = 'ghechuyenbay';
    protected $primaryKey = ['MaGhe', 'MaCB'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'MaGhe', 
        'MaCB', 
        'TinhTrang'
    ];

    public function gheNgoi()
    {
        return $this->belongsTo(GheNgoi::class, 'MaGhe');
    }

    public function chuyenBay()
    {
        return $this->belongsTo(ChuyenBay::class, 'MaCB');
    }
}
