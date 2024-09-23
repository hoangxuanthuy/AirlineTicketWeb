<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlightService;
class FlightServiceController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flightServices = FlightService::all();
        return response()->json($flightServices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Service_Name' => 'required|string|max:255',
        ]);

        $flightService = FlightService::create($request->all());

        return response()->json($flightService, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flightService = FlightService::findOrFail($id);
        return response()->json($flightService);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Service_Name' => 'sometimes|required|string|max:255',
        ]);

        $flightService = FlightService::findOrFail($id);
        $flightService->update($request->all());

        return response()->json($flightService);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $flightService = FlightService::findOrFail($id);
        $flightService->delete();

        return response()->json(null, 204);
    }
}
