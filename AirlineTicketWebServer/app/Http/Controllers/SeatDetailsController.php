<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeatDetails;
class SeatDetailsController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seatDetails = SeatDetails::with(['flightDetails', 'travelClass'])->get();
        return response()->json($seatDetails);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Travel_Class_ID' => 'required|exists:Travel_Class,Travel_Class_ID',
            'Flight_ID' => 'required|exists:Flight_Details,Flight_ID',
        ]);

        $seatDetail = SeatDetails::create($request->all());

        return response()->json($seatDetail, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seatDetail = SeatDetails::with(['flightDetails', 'travelClass'])->findOrFail($id);
        return response()->json($seatDetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Travel_Class_ID' => 'sometimes|required|exists:Travel_Class,Travel_Class_ID',
            'Flight_ID' => 'sometimes|required|exists:Flight_Details,Flight_ID',
        ]);

        $seatDetail = SeatDetails::findOrFail($id);
        $seatDetail->update($request->all());

        return response()->json($seatDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seatDetail = SeatDetails::findOrFail($id);
        $seatDetail->delete();

        return response()->json(null, 204);
    }
}
