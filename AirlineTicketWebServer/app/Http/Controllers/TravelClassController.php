<?php

namespace App\Http\Controllers;
use App\Models\TravelClass;
use Illuminate\Http\Request;

class TravelClassController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $travelClasses = TravelClass::all();
        return response()->json($travelClasses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Travel_Class_Name' => 'required|string|max:255',
            'Travel_Class_Capacity' => 'required|integer|min:1',
        ]);

        $travelClass = TravelClass::create($request->all());

        return response()->json($travelClass, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $travelClass = TravelClass::findOrFail($id);
        return response()->json($travelClass);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Travel_Class_Name' => 'sometimes|required|string|max:255',
            'Travel_Class_Capacity' => 'sometimes|required|integer|min:1',
        ]);

        $travelClass = TravelClass::findOrFail($id);
        $travelClass->update($request->all());

        return response()->json($travelClass);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $travelClass = TravelClass::findOrFail($id);
        $travelClass->delete();

        return response()->json(null, 204);
    }
}
