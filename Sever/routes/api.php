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
Route::middleware('auth:sanctum')->get('user', [AuthController::class, 'user']); 
Route::post('register', [AuthController::class, 'register']);
Route::post('registercus', [AuthController::class, 'registercus']);
Route::post('login', [AuthController::class, 'login']);

// Routes for Roles

Route::middleware('auth:sanctum')->get('roles', [RoleController::class, 'index']); // Lấy danh sách tất cả các roles
Route::post('roles', [RoleController::class, 'createRole']); // Tạo role mới
Route::put('roles/{id}', [RoleController::class, 'updateRole']); // Cập nhật role
Route::delete('roles/{id}', [RoleController::class, 'destroyRole']); // Xóa mềm role

// Routes for Promotion Management
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Lấy danh sách các chương trình khuyến mãi (admin, giám đốc)
    Route::get('promotions', [PromotionController::class, 'getAllPromotions']);

    // Thêm chương trình khuyến mãi mới (admin, giám đốc)
    Route::post('promotions', [PromotionController::class, 'createPromotion']);

    // Cập nhật chương trình khuyến mãi (admin, giám đốc)
    Route::put('promotions/{promotionId}', [PromotionController::class, 'updatePromotion']);

    // Xóa chương trình khuyến mãi (admin, giám đốc)
    Route::delete('promotions/{promotionId}', [PromotionController::class, 'deletePromotion']);
});

// Routes for Parameters
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('parameters', [ParameterController::class, 'getAllParameters']);
    Route::put('parameters/{parameterId}', [ParameterController::class, 'updateParameter']);
});

// Routes for Luggage Management (Requires user to be authenticated)
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Lấy danh sách hành lý (admin, director)
    Route::get('luggage', [LuggageController::class, 'getAllLuggage']);

    // Thêm hành lý mới (admin, director)
    Route::post('luggage', [LuggageController::class, 'createLuggage']);

    // Cập nhật hành lý (admin, director)
    Route::put('luggage/{luggageId}', [LuggageController::class, 'updateLuggage']);

    // Xóa hành lý (admin, director)
    Route::delete('luggage/{luggageId}', [LuggageController::class, 'deleteLuggage']);
});
// Routes for Gate Management (Yêu cầu đăng nhập và có quyền)
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Lấy danh sách cổng bay (chỉ Admin và Giám đốc mới có quyền)
    Route::get('gates', [GateController::class, 'getAllGates']);

    // Thêm mới cổng bay (chỉ Admin và Giám đốc mới có quyền)
    Route::post('gates', [GateController::class, 'createGate']);

    // Cập nhật thông tin cổng bay (chỉ Admin và Giám đốc mới có quyền)
    Route::put('gates/{gateId}', [GateController::class, 'updateGate']);

    // Xóa cổng bay (chỉ Admin và Giám đốc mới có quyền)
    Route::delete('gates/{gateId}', [GateController::class, 'deleteGate']);
});

// Routes for Airport Management
Route::middleware(['auth:sanctum'])->group(function () {
    // Lấy danh sách các sân bay (admin, giám đốc)
    Route::get('airports', [AirportController::class, 'getAllAirports']);

    // Thêm sân bay mới (admin, giám đốc)
    Route::post('airports', [AirportController::class, 'createAirport']);

    // Cập nhật sân bay (admin, giám đốc)
    Route::put('airports/{airportId}', [AirportController::class, 'updateAirport']);

    // Xóa sân bay (admin, giám đốc)
    Route::delete('airports/{airportId}', [AirportController::class, 'deleteAirport']);
});

// Routes for SeatClass
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Lấy danh sách các hạng ghế
    Route::get('seats', [SeatClassController::class, 'getAllSeatClasses']);

    // Thêm hạng ghế mới
    Route::post('seats', [SeatClassController::class, 'createSeatClass']);

    // Cập nhật thông tin hạng ghế
    Route::put('seats/{seatClassId}', [SeatClassController::class, 'updateSeatClass']);

    // Xóa hạng ghế
    Route::delete('seats/{seatClassId}', [SeatClassController::class, 'deleteSeatClass']);
});

// Routes for Airplane
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('airplanes', [AirplaneController::class, 'getAllAirplanes']);
    Route::post('airplanes', [AirplaneController::class, 'createAirplane']);
    Route::put('airplanes/{airplaneId}', [AirplaneController::class, 'updateAirplane']);
    Route::delete('airplanes/{airplaneId}', [AirplaneController::class, 'deleteAirplane']);
});
// Routes for Customer
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('searchcus', [ClientController::class, 'searchCustomer']);
    Route::get('customers/count', [ClientController::class, 'countCustomers']); // Lấy danh sách khách hàng
    Route::post('customers', [ClientController::class, 'createClient']); // Thêm mới khách hàng
    Route::put('customers/{customerId}', [ClientController::class, 'updateClient']); // Cập nhật thông tin khách hàng
    Route::delete('customers/{customerId}', [ClientController::class, 'deleteClient']); // Xóa khách hàng
});

// Routes for Flights
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('flights', [FlightController::class, 'getAllFlights']); // Lấy danh sách chuyến bay
    Route::post('flights', [FlightController::class, 'createFlight']); // Thêm mới chuyến bay
    Route::put('flights/{flightId}', [FlightController::class, 'updateFlight']); // Cập nhật thông tin chuyến bay
    Route::delete('flights/{flightId}', [FlightController::class, 'deleteFlight']); // Xóa chuyến bay
});
//Routes for Ticket
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('tickets', [TicketController::class, 'getAllTickets']); // Lấy danh sách vé
    Route::post('tickets', [TicketController::class, 'createTicket']); // Thêm vé mới
    Route::put('tickets/{ticketId}', [TicketController::class, 'updateTicket']); // Cập nhật thông tin vé
    Route::delete('tickets/{ticketId}', [TicketController::class, 'deleteTicket']); // Xóa vé
});
//Routes for Account
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('accounts', [AccountController::class, 'getAllAccounts']); // Lấy danh sách tài khoản
    Route::post('accounts', [AccountController::class, 'createAccount']); // Thêm tài khoản mới
    Route::put('accounts/{accountId}', [AccountController::class, 'updateAccount']); // Cập nhật thông tin tài khoản
    Route::delete('accounts/{accountId}', [AccountController::class, 'deleteAccount']); // Xóa tài khoản
});
//Revenue
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('revenue', [RevenueController::class, 'getRevenueStatistics']); // Lấy thống kê doanh thu
});
