<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
class CalendarController
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calendars = Calendar::all();
        return response()->json($calendars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Day_Date' => 'required|date|unique:Calendar,Day_Date',
            'Business_Day_YN' => 'required|boolean',  // Assuming 1 for yes and 0 for no
        ]);

        $calendar = Calendar::create($request->all());

        return response()->json($calendar, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $calendar = Calendar::findOrFail($id);
        return response()->json($calendar);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Business_Day_YN' => 'sometimes|required|boolean',
        ]);

        $calendar = Calendar::findOrFail($id);
        $calendar->update($request->all());

        return response()->json($calendar);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calendar = Calendar::findOrFail($id);
        $calendar->delete();

        return response()->json(null, 204);
    }
}
