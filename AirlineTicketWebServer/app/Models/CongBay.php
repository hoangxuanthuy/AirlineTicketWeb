<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongBay extends Model
{
    use HasFactory;

    protected $table = 'congbay';
    protected $primaryKey = 'MaCong';
    public $timestamps = false;

    protected $fillable = [
        'MaCong', 
        'MaSB'
    ];

    public function sanBay()
    {
        return $this->belongsTo(SanBay::class, 'MaSB');
    }

    public function chuyenBay()
    {
        return $this->hasMany(ChuyenBay::class, 'MaCong');
    }
}
