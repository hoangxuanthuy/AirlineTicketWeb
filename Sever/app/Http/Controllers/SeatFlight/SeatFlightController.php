<?php

namespace App\Http\Controllers\SeatFlight;

use App\Business\SeatFlightBiz\SeatFlightBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class SeatFlightController extends Controller
{
    protected SeatFlightBusiness $seatFlightBusiness;
    protected PersmissionBusiness $permissionBusiness;

    public function __construct()
    {
        $this->seatFlightBusiness = new SeatFlightBusiness();
        $this->permissionBusiness = new PersmissionBusiness();
    }

    public function countSeatFlights(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View SeatFlight";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $search = $request->get('search', null);
                $totalSeatFlights = $this->seatFlightBusiness->countSeatFlights($search);

                return response()->json(['totalCount' => $totalSeatFlights]);
            }

            return response()->json(['message' => 'Bạn không có quyền xem danh sách SeatFlight.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function getAllSeatFlights(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View SeatFlight";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $seatFlights = $this->seatFlightBusiness->getAllSeatFlights($limit, $offset, $search);
                return response()->json($seatFlights);
            }

            return response()->json(['message' => 'Bạn không có quyền xem danh sách SeatFlight.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function createSeatFlight(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage SeatFlight";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $seatFlightId = $this->seatFlightBusiness->createSeatFlight($request->all());
                return response()->json(['message' => 'Thêm SeatFlight thành công.', 'seat_flight_id' => $seatFlightId]);
            }

            return response()->json(['message' => 'Bạn không có quyền thêm SeatFlight.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateSeatFlight(Request $request, int $seatId, int $flightId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage SeatFlight";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $this->seatFlightBusiness->updateSeatFlight($seatId, $flightId, $request->all());
                return response()->json(['message' => 'Cập nhật SeatFlight thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền cập nhật SeatFlight.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteSeatFlight(int $seatId, int $flightId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage SeatFlight";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $this->seatFlightBusiness->deleteSeatFlight($seatId, $flightId);
                return response()->json(['message' => 'Xóa SeatFlight thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền xóa SeatFlight.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }
}
