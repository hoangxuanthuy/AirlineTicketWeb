<?php

namespace App\Http\Controllers\Booking;

use App\Business\TicketBiz\TicketBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    protected TicketBusiness $ticketBusiness;

    public function __construct()
    {
        $this->ticketBusiness = new TicketBusiness();
    }

    public function createBooking(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'client_id' => 'required|integer',
            'seat_id' => 'required|integer',
            'flight_id' => 'required|integer',
            'from_airport_id' => 'required|integer',
            'to_airport_id' => 'required|integer',
            'luggage_id' => 'required|integer',
        ]);

        try {
            // Find the ticket with flight_id and seat_id
            $ticket = $this->ticketBusiness->findTicket($validated['flight_id'], $validated['seat_id']);

            if (!$ticket) {
                return response()->json(['message' => 'Ticket not found'], 404);
            }

            // Change status to booked
            $this->ticketBusiness->updateTicket($ticket->ticket_id, [ // Changed from $ticket->id to $ticket->ticket_id
                'status' => 'booked',
                'client_id' => $validated['client_id'],
                'luggage_id' => $validated['luggage_id'],
                'seat_id' => $ticket->seat_id, // Added seat_id
                'flight_id' => $ticket->flight_id, // Added flight_id
                'ticket_issuance_date' => date('Y-m-d H:i:s'),
                'promotion_id' => $ticket->promotion_id

            ]);
        

            return response()->json(['message' => 'Booking created successfully' ] ,201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating booking', 'error' => $e->getMessage()], 500);
        }
    }
}