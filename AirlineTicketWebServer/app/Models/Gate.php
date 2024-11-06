<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    use HasFactory;

    protected $table = 'Gate';
    protected $primaryKey = 'gate_id';
    public $timestamps = false;

    protected $fillable = [
        'gate_id', 
        'airport_id'
    ];

    public function airport()
    {
        return $this->belongsTo(Airport::class, 'airport_id');
    }

    public function flight()
    {
        return $this->hasMany(Flight::class, 'gate_id');
    }
}
