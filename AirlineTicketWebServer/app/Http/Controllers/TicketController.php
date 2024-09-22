<?php

namespace App\Http\Controllers;

use App\Models\Ticket; 
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // List all tickets
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json($tickets);
    }

    // Get a specific ticket
    public function show($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        return response()->json($ticket);
    }

    // Create a new ticket
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|string|unique:tickets',
            'flight_id' => 'required|exists:flights,id',
            'seat_id' => 'required|string',
            'luggage_id' => 'required|string',
            'status' => 'required|string',
        ]);

        $ticket = Ticket::create($request->all());
        return response()->json($ticket, 201);
    }

    // Update a ticket
    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $request->validate([
            'ticket_id' => 'string|unique:tickets,ticket_id,' . $ticket->id,
            'flight_id' => 'exists:flights,id',
            'seat_id' => 'string',
            'luggage_id' => 'string',
            'status' => 'string',
        ]);

        $ticket->update($request->all());
        return response()->json($ticket);
    }

    // Delete a ticket
    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted successfully']);
    }
}
