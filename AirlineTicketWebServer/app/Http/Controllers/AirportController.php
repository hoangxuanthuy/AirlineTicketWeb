<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;
class AirportController
{
   
   public function index()
   {
       $airports = Airport::all();
       return response()->json($airports);
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
       $request->validate([
           'AirportName' => 'required|string|max:255',
           'AirportCity' => 'required|string|max:255',
           'AirportCountry' => 'required|string|max:255',
       ]);

       $airport = Airport::create($request->all());

       return response()->json($airport, 201);
   }

   /**
    * Display the specified resource.
    */
   public function show(string $id)
   {
       $airport = Airport::findOrFail($id);
       return response()->json($airport);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
       $request->validate([
           'AirportName' => 'sometimes|required|string|max:255',
           'AirportCity' => 'sometimes|required|string|max:255',
           'AirportCountry' => 'sometimes|required|string|max:255',
       ]);

       $airport = Airport::findOrFail($id);
       $airport->update($request->all());

       return response()->json($airport);
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
       $airport = Airport::findOrFail($id);
       $airport->delete();

       return response()->json(null, 204);
   }
}
