<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // ...existing code...

    protected $fillable = [
        'email',
        'password',
        'account_name',
        'citizen_id',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ...existing code...
}