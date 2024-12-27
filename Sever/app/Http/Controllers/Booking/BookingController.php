<?php

namespace App\Http\Controllers\Booking;

use App\Business\TicketBiz\TicketBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Business\BookingBiz\BookingBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Support\Facades\Validator;
use App\Business\ClientBiz\ClientBusiness;
class BookingController extends Controller
{
    protected TicketBusiness $ticketBusiness;
    protected BookingBusiness $bookingBusiness;
    protected ClientBusiness $clientBusiness;
    protected PersmissionBusiness $permissionBusiness;
    public function __construct()
    {
        $this->ticketBusiness = new TicketBusiness();
        $this->bookingBusiness = new BookingBusiness();
        $this->permissionBusiness = new PersmissionBusiness();
        $this->clientBusiness = new ClientBusiness();
    }

        


    public function createBooking(Request $request)
    {
        
        // Validate request data
        $validated = $request->validate([
            'seat_id' => 'required|integer',
            'flight_id' => 'required|integer',
            'luggage_id' => 'required|integer',
            'client_name' => 'required|string',
            'citizen_id' => 'required|string|unique:Client,citizen_id',
            'phone' => 'required|string',
            'gender' => 'nullable|string',
            'birth_day' => 'nullable|date',
            'country' => 'nullable|string',
            'client_id' => 'nullable|integer',
        ]);
    
        if (!$validated) {
            return response()->json(['message' => 'Invalid data'], 400);
        }
        try {
            // Create a new client and retrieve 
            
            //fix tam thoi, todo: check neu khong tao duoc client thi sao??
            $clientId = -1;;
            try{
                $clientId = $this->clientBusiness->createClient([
                    'client_name' => $validated['client_name'],
                    'citizen_id' => $validated['citizen_id'],
                    'phone' => $validated['phone'],
                    'gender' => $validated['gender'] ?? null,
                    'birth_day' => $validated['birth_day'] ?? null,
                    'country' => $validated['country'] ?? null,
                ]);
            
            }catch(\Exception $e){
                $clientId = $validated['client_id'];
            }

            // Find the ticket with flight_id and seat_id
            $ticket = $this->ticketBusiness->findTicket($validated['flight_id'], $validated['seat_id']); // Changed method and added seat_id

            if (!$ticket) {
                return response()->json(['message' => 'Ticket not found'], 404);
            }

            // Change status to booked
            $this->ticketBusiness->updateTicketData($ticket->ticket_id, [
                'seat_id' => $ticket->seat_id,
                'status' => 'Confirmed',
                'client_id' => $clientId,
                'luggage_id' => $validated['luggage_id'],
                'flight_id' => $ticket->flight_id,
                'ticket_issuance_date' => now(),
                'promotion_id' => $ticket->promotion_id,
            ]);

            return response()->json(['message' => 'Booking created successfully' ] ,201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating booking', 'error' => $e->getMessage()], 500);
        }
    }
    public function countBookings(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Bookings";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $search = $request->get('search', null);
                $totalBookings = $this->bookingBusiness->countBookings($search);

                return response()->json(['totalCount' => $totalBookings]);
            }

            return response()->json(['message' => 'Bạn không có quyền xem danh sách Booking.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function getAllBookings(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Bookings";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $bookings = $this->bookingBusiness->getAllBookings($limit, $offset, $search);
                return response()->json($bookings);
            }

            return response()->json(['message' => 'Bạn không có quyền xem danh sách Booking.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function exportBooking(int $bookingId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Add Booking";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $this->bookingBusiness->exportBooking($bookingId);
                return response()->json(['message' => 'Xuất vé Booking thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền cập nhật Booking.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateBooking( int $bookingId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Update Booking";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $this->bookingBusiness->updateBooking($bookingId);
                return response()->json(['message' => 'Cập nhật Booking thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền cập nhật Booking.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteBooking(int $bookingId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Delete Booking";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $this->bookingBusiness->deleteBooking($bookingId);
                return response()->json(['message' => 'Xóa Booking thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền xóa Booking.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }
}
