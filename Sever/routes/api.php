<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SinhVien\SinhVienController;
use App\Http\Controllers\Authenication\AuthController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Promotion\PromotionController;
use App\Http\Controllers\Parameter\ParameterController;
use App\Http\Controllers\Luggage\LuggageController;
use App\Http\Controllers\Gate\GateController;
use App\Http\Controllers\Airport\AirportController;
use App\Http\Controllers\SeatClass\SeatClassController;
use App\Http\Controllers\Airplane\AirplaneController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Flight\FlightController;
use App\Http\Controllers\Ticket\TicketController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Revenue\RevenueController;

// Route for Auth
Route::get('user', [AuthController::class, 'user']); 
Route::post('register', [AuthController::class, 'register']);
Route::post('registercus', [AuthController::class, 'registercus']);
Route::post('login', [AuthController::class, 'login']);

// Routes for Roles
Route::get('roles', [RoleController::class, 'index']); // Lấy danh sách tất cả các roles
Route::post('roles', [RoleController::class, 'createRole']); // Tạo role mới
Route::put('roles/{id}', [RoleController::class, 'updateRole']); // Cập nhật role
Route::delete('roles/{id}', [RoleController::class, 'destroyRole']); // Xóa mềm role

// Routes for Promotion Management
Route::get('promotions', [PromotionController::class, 'getAllPromotions']);
Route::post('promotions', [PromotionController::class, 'createPromotion']);
Route::put('promotions/{promotionId}', [PromotionController::class, 'updatePromotion']);
Route::delete('promotions/{promotionId}', [PromotionController::class, 'deletePromotion']);

// Routes for Parameters
Route::get('parameters', [ParameterController::class, 'getAllParameters']);
Route::put('parameters/{parameterId}', [ParameterController::class, 'updateParameter']);

// Routes for Luggage Management
Route::get('luggage', [LuggageController::class, 'getAllLuggage']);
Route::post('luggage', [LuggageController::class, 'createLuggage']);
Route::put('luggage/{luggageId}', [LuggageController::class, 'updateLuggage']);
Route::delete('luggage/{luggageId}', [LuggageController::class, 'deleteLuggage']);

// Routes for Gate Management
Route::get('gates', [GateController::class, 'getAllGates']);
Route::post('gates', [GateController::class, 'createGate']);
Route::put('gates/{gateId}', [GateController::class, 'updateGate']);
Route::delete('gates/{gateId}', [GateController::class, 'deleteGate']);

// Routes for Airport Management
Route::get('airports', [AirportController::class, 'getAllAirports']);
Route::post('airports', [AirportController::class, 'createAirport']);
Route::put('airports/{airportId}', [AirportController::class, 'updateAirport']);
Route::delete('airports/{airportId}', [AirportController::class, 'deleteAirport']);

// Routes for SeatClass
Route::get('seats', [SeatClassController::class, 'getAllSeatClasses']);
Route::post('seats', [SeatClassController::class, 'createSeatClass']);
Route::put('seats/{seatClassId}', [SeatClassController::class, 'updateSeatClass']);
Route::delete('seats/{seatClassId}', [SeatClassController::class, 'deleteSeatClass']);

// Routes for Airplane
Route::get('airplanes', [AirplaneController::class, 'getAllAirplanes']);
Route::post('airplanes', [AirplaneController::class, 'createAirplane']);
Route::put('airplanes/{airplaneId}', [AirplaneController::class, 'updateAirplane']);
Route::delete('airplanes/{airplaneId}', [AirplaneController::class, 'deleteAirplane']);

// Routes for Customer
Route::get('searchcus', [ClientController::class, 'searchCustomer']);
Route::get('customers/count', [ClientController::class, 'countCustomers']);
Route::post('customers', [ClientController::class, 'createClient']);
Route::put('customers/{customerId}', [ClientController::class, 'updateClient']);
Route::delete('customers/{customerId}', [ClientController::class, 'deleteClient']);

// Routes for Flights
Route::get('flights', [FlightController::class, 'getAllFlights']);
Route::post('flights', [FlightController::class, 'createFlight']);
Route::put('flights/{flightId}', [FlightController::class, 'updateFlight']);
Route::delete('flights/{flightId}', [FlightController::class, 'deleteFlight']);

// Routes for Ticket
Route::get('tickets', [TicketController::class, 'getAllTickets']);
Route::post('tickets', [TicketController::class, 'createTicket']);
Route::put('tickets/{ticketId}', [TicketController::class, 'updateTicket']);
Route::delete('tickets/{ticketId}', [TicketController::class, 'deleteTicket']);

// Routes for Account
Route::get('accounts', [AccountController::class, 'getAllAccounts']);
Route::post('accounts', [AccountController::class, 'createAccount']);
Route::put('accounts/{accountId}', [AccountController::class, 'updateAccount']);
Route::delete('accounts/{accountId}', [AccountController::class, 'deleteAccount']);

// Revenue
Route::get('revenue', [RevenueController::class, 'getRevenueStatistics']);
