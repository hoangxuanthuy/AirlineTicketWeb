<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:Account,email',
            'password' => 'required|min:6',
            'account_name' => 'required',
            'citizen_id' => 'required|unique:Account,citizen_id',
            'phone' => 'required|unique:Account,phone',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = Account::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_name' => $request->account_name,
            'citizen_id' => $request->citizen_id,
            'phone' => $request->phone,
        ]);

        return response()->json(['message' => 'Account created successfully', 'account' => $account], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = Account::where('email', $request->email)->first();

        if (!$account || !Hash::check($request->password, $account->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate authentication token
        $token = 'user_' . $account->generateToken('auth_token');

        // Return response with token
        return response()->json([
            'message' => 'Login successful',
            'account' => $account,
            'token' => $token,
        ], 200);
    }
}
