<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HangGhe extends Model
{
    use HasFactory;

    protected $table = 'hangghe';
    protected $primaryKey = 'MaHG';
    public $timestamps = false;

    protected $fillable = [
        'MaHG', 
        'TenHG', 
        'TiLeGia'
    ];

    public function gheNgoi()
    {
        return $this->hasMany(GheNgoi::class, 'MaHG');
    }
}
