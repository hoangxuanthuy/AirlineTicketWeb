<?php
use App\Http\Controllers\AirportController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\TravelClassController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FlightServiceController;
use App\Http\Controllers\FlightDetailsController;
use App\Http\Controllers\SeatDetailsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentStatusController;
use App\Http\Controllers\FlightCostController;
use App\Http\Controllers\ServiceOfferingController;



// Airport API Routes
Route::get('/airports', [AirportController::class, 'index']);
Route::get('/airports/{id}', [AirportController::class, 'show']);
Route::post('/airports', [AirportController::class, 'store']);
Route::put('/airports/{id}', [AirportController::class, 'update']);
Route::delete('/airports/{id}', [AirportController::class, 'destroy']);

// Passenger API Routes
Route::get('/passengers', [PassengerController::class, 'index']);
Route::get('/passengers/{id}', [PassengerController::class, 'show']);
Route::post('/passengers', [PassengerController::class, 'store']);
Route::put('/passengers/{id}', [PassengerController::class, 'update']);
Route::delete('/passengers/{id}', [PassengerController::class, 'destroy']);

// Travel Class API Routes
Route::get('/travel-classes', [TravelClassController::class, 'index']);
Route::get('/travel-classes/{id}', [TravelClassController::class, 'show']);
Route::post('/travel-classes', [TravelClassController::class, 'store']);
Route::put('/travel-classes/{id}', [TravelClassController::class, 'update']);
Route::delete('/travel-classes/{id}', [TravelClassController::class, 'destroy']);

// Calendar API Routes
Route::get('/calendars', [CalendarController::class, 'index']);
Route::get('/calendars/{id}', [CalendarController::class, 'show']);
Route::post('/calendars', [CalendarController::class, 'store']);
Route::put('/calendars/{id}', [CalendarController::class, 'update']);
Route::delete('/calendars/{id}', [CalendarController::class, 'destroy']);

// Flight Service API Routes
Route::get('/flight-services', [FlightServiceController::class, 'index']);
Route::get('/flight-services/{id}', [FlightServiceController::class, 'show']);
Route::post('/flight-services', [FlightServiceController::class, 'store']);
Route::put('/flight-services/{id}', [FlightServiceController::class, 'update']);
Route::delete('/flight-services/{id}', [FlightServiceController::class, 'destroy']);



// Seat Details API Routes
Route::get('/seat-details', [SeatDetailsController::class, 'index']);
Route::get('/seat-details/{id}', [SeatDetailsController::class, 'show']);
Route::post('/seat-details', [SeatDetailsController::class, 'store']);
Route::put('/seat-details/{id}', [SeatDetailsController::class, 'update']);
Route::delete('/seat-details/{id}', [SeatDetailsController::class, 'destroy']);

// Reservation API Routes
Route::get('/reservations', [ReservationController::class, 'index']);
Route::get('/reservations/{id}', [ReservationController::class, 'show']);
Route::post('/reservations', [ReservationController::class, 'store']);
Route::put('/reservations/{id}', [ReservationController::class, 'update']);
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);

// Payment Status API Routes
Route::get('/payment-statuses', [PaymentStatusController::class, 'index']);
Route::get('/payment-statuses/{id}', [PaymentStatusController::class, 'show']);
Route::post('/payment-statuses', [PaymentStatusController::class, 'store']);
Route::put('/payment-statuses/{id}', [PaymentStatusController::class, 'update']);
Route::delete('/payment-statuses/{id}', [PaymentStatusController::class, 'destroy']);

// Flight Cost API Routes
Route::get('/flight-costs', [FlightCostController::class, 'index']);
Route::get('/flight-costs/{id}', [FlightCostController::class, 'show']);
Route::post('/flight-costs', [FlightCostController::class, 'store']);
Route::put('/flight-costs/{id}', [FlightCostController::class, 'update']);
Route::delete('/flight-costs/{id}', [FlightCostController::class, 'destroy']);

// Service Offering API Routes
Route::get('/service-offerings', [ServiceOfferingController::class, 'index']);
Route::get('/service-offerings/{id}', [ServiceOfferingController::class, 'show']);
Route::post('/service-offerings', [ServiceOfferingController::class, 'store']);
Route::put('/service-offerings/{id}', [ServiceOfferingController::class, 'update']);
Route::delete('/service-offerings/{id}', [ServiceOfferingController::class, 'destroy']);

//tested api ========================================================================


// Flight Details API Routes
Route::get('/flight-details', [FlightDetailsController::class, 'index']);
Route::get('/flight-details/{id}', [FlightDetailsController::class, 'show']);
Route::post('/flight-details', [FlightDetailsController::class, 'store']);
Route::put('/flight-details/{id}', [FlightDetailsController::class, 'update']);
Route::delete('/flight-details/{id}', [FlightDetailsController::class, 'destroy']);