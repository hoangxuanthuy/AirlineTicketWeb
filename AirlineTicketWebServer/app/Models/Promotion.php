<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';
    protected $primaryKey = 'promotion_id';
    public $timestamps = false;

    protected $fillable = ['promotion_id', 'name', 'discount_amount', 'start_date', 'end_date'];

    // Relationships
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'promotion_id');
    }
}
