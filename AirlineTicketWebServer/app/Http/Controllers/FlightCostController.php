<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlightCost;
class FlightCostController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flightCosts = FlightCost::all();
        return response()->json($flightCosts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Seat_ID' => 'required|integer',
            'Valid_From_Date' => 'required|date',
            'Valid_To_Date' => 'required|date|after_or_equal:Valid_From_Date',
            'Cost' => 'required|numeric|min:0',
        ]);

        $flightCost = FlightCost::create($request->all());

        return response()->json($flightCost, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flightCost = FlightCost::findOrFail($id);
        return response()->json($flightCost);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Valid_To_Date' => 'sometimes|required|date|after_or_equal:Valid_From_Date',
            'Cost' => 'sometimes|required|numeric|min:0',
        ]);

        $flightCost = FlightCost::findOrFail($id);
        $flightCost->update($request->all());

        return response()->json($flightCost);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $flightCost = FlightCost::findOrFail($id);
        $flightCost->delete();

        return response()->json(null, 204);
    }
}
