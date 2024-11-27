<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController 
{
    public function index()
    {
        return Ticket::all();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $ticket = Ticket::create($request->all());
        return response()->json($ticket, 201);
    }

    public function show(string $id)
    {
        return Ticket::find($id);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->all());
        return response()->json($ticket, 200);
    }

    public function destroy(string $id)
    {
        Ticket::destroy($id);
        return response()->json(null, 204);
    }

    public function getTicketById(string $id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            return response()->json($ticket, 200);
        } else {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
    }

    public function updateTicketInfo(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->all());
        return response()->json($ticket, 200);
    }
}
