<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $table = 'ghengoi';
    protected $primaryKey = 'MaGhe';
    public $timestamps = false;

    protected $fillable = [
        'MaGhe', 
        'MaHG', 
        'MaMB'
    ];

    // Relationships
    public function hangGhe()
    {
        return $this->belongsTo(HangGhe::class, 'MaHG');
    }

    public function mayBay()
    {
        return $this->belongsTo(MayBay::class, 'MaMB');
    }

    public function phieuDat()
    {
        return $this->hasMany(PhieuDat::class, 'MaGhe');
    }

    public function veCB()
    {
        return $this->hasMany(VeCB::class, 'MaGhe');
    }

    public function gheChuyenBay()
    {
        return $this->hasMany(GheChuyenBay::class, 'MaGhe');
    }
}
