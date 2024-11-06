<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'Client';
    protected $primaryKey = 'client_id';
    public $timestamps = false;

    protected $fillable = [
        'client_id', 
        'client_name', 
        'citizen_id', 
        'phone', 
        'gender', 
        'birth_day', 
        'country'
    ];

    // Relationships
    public function booking()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'client_id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'account_id', 'client_id');
    }
}
