<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str; // Add this import
use Illuminate\Support\Facades\Cache; // Add this import
use Laravel\Sanctum\HasApiTokens; // Add this import

class Account extends Authenticatable
{
    use HasFactory, HasApiTokens; // Include HasApiTokens

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

   //function to generate jwt token
    public function generateToken($name = 'auth_token')
    {
        $token = $this->createToken($name)->plainTextToken;
        Cache::put('token_' . $this->account_id, $token, now()->addHours(2));
        return $token;
    }
}
