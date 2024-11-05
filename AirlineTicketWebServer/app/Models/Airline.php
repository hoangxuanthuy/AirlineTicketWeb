<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $table = 'hangbay';
    protected $primaryKey = 'MaHB';
    public $timestamps = false;

    protected $fillable = [
        'MaHB', 
        'TenHangBay'
    ];

    // Relationships
    public function mayBay()
    {
        return $this->hasMany(MayBay::class, 'MaHB');
    }
}
