<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Revenue::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $revenue = Revenue::create($request->all());
        return response()->json($revenue, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Revenue::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $revenue = Revenue::findOrFail($id);
        $revenue->update($request->all());
        return response()->json($revenue, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Revenue::destroy($id);
        return response()->json(null, 204);
    }

    public function getRevenueByMonth($year, $month)
    {
        try {
            $revenues = DB::table('revenue')
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();

            return response()->json($revenues);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Check database connection.
     */
    public function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['message' => 'Database connection is successful'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Could not connect to the database. Please check your configuration.'], 500);
        }
    }
}