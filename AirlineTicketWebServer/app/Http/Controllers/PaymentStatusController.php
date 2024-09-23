<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentStatus;
class PaymentStatusController
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentStatuses = PaymentStatus::all();
        return response()->json($paymentStatuses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|max:255', // Adjust according to your actual column name
        ]);

        $paymentStatus = PaymentStatus::create($request->all());

        return response()->json($paymentStatus, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentStatus = PaymentStatus::findOrFail($id);
        return response()->json($paymentStatus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'sometimes|required|string|max:255', // Adjust according to your actual column name
        ]);

        $paymentStatus = PaymentStatus::findOrFail($id);
        $paymentStatus->update($request->all());

        return response()->json($paymentStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paymentStatus = PaymentStatus::findOrFail($id);
        $paymentStatus->delete();

        return response()->json(null, 204);
    }
}
