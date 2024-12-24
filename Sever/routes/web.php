<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Import controller

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\ApiController;

Route::get('/data', [ApiController::class, 'getData']);