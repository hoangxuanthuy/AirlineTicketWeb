<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'taikhoan';
    protected $primaryKey = 'MaTK';
    public $timestamps = false;

    protected $fillable = [
        'MaTK', 
        'Email', 
        'Matkhau', 
        'Ten', 
        'CCCD', 
        'Sdt'
    ];

    // Relationships
    public function khach()
    {
        return $this->belongsTo(Khach::class, 'MaTK', 'MaKH');
    }
}
