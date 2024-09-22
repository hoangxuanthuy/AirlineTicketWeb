<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    // Display a listing of airports
    public function index()
    {
        $airports = Airport::all(['airport_id', 'airport_name', 'address']);
        return response()->json($airports);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $airport = Airport::create($request->all());
        return response()->json($airport, 201); // 201 Created status
    }

    public function show($id)
    {
        $airport = Airport::find($id);

        if (!$airport) {
            return response()->json(['message' => 'Airport not found'], 404);
        }

        return response()->json($airport);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $airport = Airport::find($id);

        if (!$airport) {
            return response()->json(['message' => 'Airport not found'], 404);
        }

        $airport->update($request->all());
        return response()->json($airport);
    }

    public function destroy($id)
    {
        $airport = Airport::find($id);

        if (!$airport) {
            return response()->json(['message' => 'Airport not found'], 404);
        }

        $airport->delete();
        return response()->json(['message' => 'Airport deleted successfully']);
    }
}
