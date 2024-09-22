<?php
use App\Http\Controllers\FlightController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\TicketController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Flight api
Route::get('/flights', [FlightController::class, 'index']); // List all flights
Route::get('/flights/{id}', [FlightController::class, 'show']); // Get flight details
Route::post('/flights', [FlightController::class, 'store']); // Create a new flight
Route::put('/flights/{id}', [FlightController::class, 'update']); // Update flight details
Route::delete('/flights/{id}', [FlightController::class, 'destroy']); // Delete a flight


//Airport api
Route::get('/airports', [AirportController::class, 'index']); // List all airports
Route::get('/airports/{id}', [AirportController::class, 'show']); // Get airport details

// ticket api
Route::get('/tickets/{id}', [TicketController::class, 'show']); // Get ticket details
Route::post('/tickets', [TicketController::class, 'store']); // Create a new ticket
Route::put('/tickets/{id}', [TicketController::class, 'update']); // Update ticket details