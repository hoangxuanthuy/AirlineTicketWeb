<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlightDetails;

class FlightDetailsController
{
    public function index()
    {
        return FlightDetails::with(['sourceAirport', 'destinationAirport'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'Source_Airport_ID' => 'required|exists:airport,Airport_ID',
            'Destination_Airport_ID' => 'required|exists:airport,Airport_ID',
            'Departure_Date_Time' => 'required|date',
            'Arrival_Date_Time' => 'required|date|after:Departure_Date_Time',
            'Airplane_Type' => 'required|string',
        ]);

        $flightDetails = FlightDetails::create($request->all());
        return response()->json($flightDetails, 201);
    }

    public function show($id)
    {
        return FlightDetails::with(['sourceAirport', 'destinationAirport'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $flightDetails = FlightDetails::findOrFail($id);

        $request->validate([
            'Source_Airport_ID' => 'sometimes|required|exists:airport,Airport_ID',
            'Destination_Airport_ID' => 'sometimes|required|exists:airport,Airport_ID',
            'Departure_Date_Time' => 'sometimes|required|date',
            'Arrival_Date_Time' => 'sometimes|required|date|after:Departure_Date_Time',
            'Airplane_Type' => 'sometimes|required|string',
        ]);

        $flightDetails->update($request->all());
        return response()->json($flightDetails, 200);
    }

    public function destroy($id)
    {
        FlightDetails::destroy($id);
        return response()->json(null, 204);
    }
}
