<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    // Fetch and return all flights
    public function index()
    {
        // Retrieve all flights with specified columns
        $flights = Flight::all(['id', 'plane_id', 'start_airport_id', 'end_airport_id', 'time_start', 'time_end', 'flight_time']);
    
        return response()->json($flights);
    }

    // Show a specific flight by ID
    public function show($id)
    {
        // Find the flight by its ID
        $flight = Flight::find($id);

        // If flight not found, return 404
        if (!$flight) {
            return response()->json(['message' => 'Flight not found'], 404);
        }

        // Return the flight details
        return response()->json($flight);
    }

    // Store a new flight
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'plane_id' => 'required|string',
            'start_airport_id' => 'required|string',
            'end_airport_id' => 'required|string',
            'time_start' => 'required|date',
            'time_end' => 'required|date',
            'flight_time' => 'required|numeric',
        ]);

        // Create a new flight
        $flight = Flight::create($validated);

        // Return the created flight with a 201 status code
        return response()->json($flight, 201);
    }

    // Update flight details by ID
    public function update(Request $request, $id)
    {
        // Find the flight by its ID
        $flight = Flight::find($id);

        // If flight not found, return 404
        if (!$flight) {
            return response()->json(['message' => 'Flight not found'], 404);
        }

        // Validate the request data
        $validated = $request->validate([
            'plane_id' => 'sometimes|required|string',
            'start_airport_id' => 'sometimes|required|string',
            'end_airport_id' => 'sometimes|required|string',
            'time_start' => 'sometimes|required|date',
            'time_end' => 'sometimes|required|date',
            'flight_time' => 'sometimes|required|numeric',
        ]);

        // Update the flight with the validated data
        $flight->update($validated);

        // Return the updated flight
        return response()->json($flight);
    }

    // Delete a flight by ID
    public function destroy($id)
    {
        // Find the flight by its ID
        $flight = Flight::find($id);

        // If flight not found, return 404
        if (!$flight) {
            return response()->json(['message' => 'Flight not found'], 404);
        }

        // Delete the flight
        $flight->delete();

        // Return a success message
        return response()->json(['message' => 'Flight deleted successfully']);
    }
}
