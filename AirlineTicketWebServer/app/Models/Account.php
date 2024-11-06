<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'Account';
    protected $primaryKey = 'account_id';
    public $timestamps = false;

    protected $fillable = [
        'account_id', 
        'email', 
        'password',  
        'account_name', 
        'citizen_id', 
        'phone'
    ];

    // Relationships
    public function Account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'client_id');
    }
}
