<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController  
{
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $client = Client::create($request->all());
        return response()->json($client, 201);
    }

    public function show(string $id)
    {
        return Client::find($id);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->all());
        return response()->json($client, 200);
    }

    public function destroy(string $id)
    {
        Client::destroy($id);
        return response()->json(null, 204);
    }
}
