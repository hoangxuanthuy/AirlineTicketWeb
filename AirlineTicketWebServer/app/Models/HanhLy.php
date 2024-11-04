<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HanhLy extends Model
{
    use HasFactory;

    protected $table = 'hanhly';
    protected $primaryKey = 'MaHL';
    public $timestamps = false;

    protected $fillable = [
        'MaHL', 
        'Cannang', 
        'Gia'
    ];

    public function phieuDat()
    {
        return $this->hasMany(PhieuDat::class, 'MaHL');
    }

    public function veCB()
    {
        return $this->hasMany(VeCB::class, 'MaHL');
    }
}
