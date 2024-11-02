<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;


    protected $table = 'accounts';
    protected $primaryKey = 'account_id';
    public $timestamps = false;

    protected $fillable = ['account_id', 'email', 'password', 'name', 'identity_number', 'phone_number'];

    // Relationships
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'account_id');
    }
}

