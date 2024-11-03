<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BCDT_Nam extends Model
{
    use HasFactory;

    protected $table = 'bcdt_nam';
    protected $primaryKey = 'Nam';
    public $timestamps = false;

    protected $fillable = [
        'Nam', 
        'TongDoanhThu'
    ];

    public function ct_bcdt_nam()
    {
        return $this->hasMany(CT_BCDT_Nam::class, 'Nam');
    }
}
