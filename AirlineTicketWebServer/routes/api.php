<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;

// Ticket routes
Route::get('/tickets', [TicketController::class, 'index']);
Route::post('/tickets', [TicketController::class, 'store']);
Route::put('/tickets/{id}', [TicketController::class, 'updateTicketInfo']);
Route::delete('/tickets/{id}', [TicketController::class, 'destroy']);
Route::get('/ticket/{id}', [TicketController::class, 'getTicketById']);

// Client routes
Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients/{id}', [ClientController::class, 'show']);
Route::put('/clients/{id}', [ClientController::class, 'update']);
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

Route::get('/revenues/{year}/{month}', [RevenueController::class, 'getRevenueByMonth']);

// Account routes
Route::post('/signup', [AccountController::class, 'signup']);
Route::post('/login', [AccountController::class, 'login']);

Route::get('/check-database-connection', [RevenueController::class, 'checkDatabaseConnection']);



Route::post('/admin/login', [AdminController::class, 'login']);