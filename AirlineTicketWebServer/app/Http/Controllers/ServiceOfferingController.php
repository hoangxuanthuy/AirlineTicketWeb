<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceOffering;
class ServiceOfferingController
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceOfferings = ServiceOffering::all();
        return response()->json($serviceOfferings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Travel_Class_ID' => 'required|exists:Travel_Class,Travel_Class_ID',
            'Service_ID' => 'required|exists:Flight_Service,Service_ID',
            'Offered_YN' => 'required|boolean',
            'From_Month' => 'required|string',
            'To_Month' => 'required|string',
        ]);

        $serviceOffering = new ServiceOffering($request->all());
        $serviceOffering->save();

        return response()->json($serviceOffering, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $travelClassId, string $serviceId)
    {
        $serviceOffering = ServiceOffering::where('Travel_Class_ID', $travelClassId)
                                          ->where('Service_ID', $serviceId)
                                          ->firstOrFail();
        return response()->json($serviceOffering);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $travelClassId, string $serviceId)
    {
        $request->validate([
            'Offered_YN' => 'sometimes|required|boolean',
            'From_Month' => 'sometimes|required|string',
            'To_Month' => 'sometimes|required|string',
        ]);

        $serviceOffering = ServiceOffering::where('Travel_Class_ID', $travelClassId)
                                          ->where('Service_ID', $serviceId)
                                          ->firstOrFail();
        $serviceOffering->update($request->all());

        return response()->json($serviceOffering);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $travelClassId, string $serviceId)
    {
        $serviceOffering = ServiceOffering::where('Travel_Class_ID', $travelClassId)
                                          ->where('Service_ID', $serviceId)
                                          ->firstOrFail();
        $serviceOffering->delete();

        return response()->json(null, 204);
    }
}
