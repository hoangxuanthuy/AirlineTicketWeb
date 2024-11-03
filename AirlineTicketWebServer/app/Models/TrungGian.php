<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrungGian extends Model
{
    use HasFactory;

    protected $table = 'trunggian';
    protected $primaryKey = ['MaCB', 'MaSBTG'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'MaCB', 
        'MaSBTG', 
        'ThoiGianDung'
    ];

    public function chuyenBay()
    {
        return $this->belongsTo(ChuyenBay::class, 'MaCB');
    }

    public function sanBay()
    {
        return $this->belongsTo(SanBay::class, 'MaSBTG');
    }
}
