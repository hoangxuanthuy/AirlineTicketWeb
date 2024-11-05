<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $table = 'thamso';
    public $timestamps = false;

    protected $fillable = [
        'TGBayToiThieu', 
        'SoSBTGToiDA', 
        'TGDungToiThieu', 
        'TGDungToiDa', 
        'TGDatVeChamNhat', 
        'TGHuyVeChamNhat'
    ];
}
