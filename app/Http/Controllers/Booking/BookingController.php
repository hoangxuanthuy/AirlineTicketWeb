<?php

namespace App\Http\Controllers\Booking;

use App\Business\BookingBiz\BookingBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    protected BookingBusiness $bookingBusiness;
    protected PersmissionBusiness $permissionBusiness;

    public function __construct()
    {
        $this->bookingBusiness = new BookingBusiness();
        $this->permissionBusiness = new PersmissionBusiness();
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

    public function createBooking(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Add Booking";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $bookingId = $this->bookingBusiness->createBooking($request->all());
                return response()->json(['message' => 'Thêm Booking thành công.', 'booking_id' => $bookingId]);
            }

            return response()->json(['message' => 'Bạn không có quyền thêm Booking.'], 403);
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
