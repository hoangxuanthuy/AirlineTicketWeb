<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passenger;
class PassengerController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $passengers = Passenger::all();
        return response()->json($passengers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'P_FirstName' => 'required|string|max:255',
            'P_LastName' => 'required|string|max:255',
            'P_Email' => 'required|email|max:255|unique:Passenger,P_Email',
            'P_PhoneNumber' => 'required|string|max:15',
            'P_Address' => 'nullable|string|max:255',
            'P_City' => 'nullable|string|max:100',
            'P_State' => 'nullable|string|max:100',
            'P_Zipcode' => 'nullable|string|max:20',
            'P_Country' => 'nullable|string|max:100',
        ]);

        $passenger = Passenger::create($request->all());

        return response()->json($passenger, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $passenger = Passenger::findOrFail($id);
        return response()->json($passenger);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'P_FirstName' => 'sometimes|required|string|max:255',
            'P_LastName' => 'sometimes|required|string|max:255',
            'P_Email' => 'sometimes|required|email|max:255|unique:Passenger,P_Email,' . $id . ',Passenger_ID',
            'P_PhoneNumber' => 'sometimes|required|string|max:15',
            'P_Address' => 'nullable|string|max:255',
            'P_City' => 'nullable|string|max:100',
            'P_State' => 'nullable|string|max:100',
            'P_Zipcode' => 'nullable|string|max:20',
            'P_Country' => 'nullable|string|max:100',
        ]);

        $passenger = Passenger::findOrFail($id);
        $passenger->update($request->all());

        return response()->json($passenger);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $passenger = Passenger::findOrFail($id);
        $passenger->delete();

        return response()->json(null, 204);
    }
}
