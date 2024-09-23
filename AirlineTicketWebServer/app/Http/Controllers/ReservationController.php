<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
class ReservationController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['passenger', 'seatDetails'])->get();
        return response()->json($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Passenger_ID' => 'required|exists:Passenger,Passenger_ID',
            'Seat_ID' => 'required|exists:Seat_Details,Seat_ID',
            'Date_Of_Reservation' => 'required|date',
        ]);

        $reservation = Reservation::create($request->all());

        return response()->json($reservation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::with(['passenger', 'seatDetails'])->findOrFail($id);
        return response()->json($reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Passenger_ID' => 'sometimes|required|exists:Passenger,Passenger_ID',
            'Seat_ID' => 'sometimes|required|exists:Seat_Details,Seat_ID',
            'Date_Of_Reservation' => 'sometimes|required|date',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->all());

        return response()->json($reservation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(null, 204);
    }
}
