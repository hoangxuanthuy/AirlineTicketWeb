<?php

namespace App\Http\Controllers\Flight;

use App\Business\FlightBiz\FlightBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    protected FlightBusiness $flightBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->flightBusiness = new FlightBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }

    // Lấy danh sách chuyến bay
    public function getAllFlights()
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Flights";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $flights = $this->flightBusiness->getAllFlights();
                return response()->json($flights);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách chuyến bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Thêm chuyến bay mới
    public function createFlight(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Flights";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $flightId = $this->flightBusiness->createFlight($request->all());
                return response()->json(['message' => 'Thêm chuyến bay thành công', 'flight_id' => $flightId]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền thêm chuyến bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật thông tin chuyến bay
    public function updateFlight(Request $request, int $flightId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Flights";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->flightBusiness->updateFlight($flightId, $request->all());
                return response()->json(['message' => 'Cập nhật chuyến bay thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật chuyến bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa chuyến bay
    public function deleteFlight(int $flightId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Flights";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->flightBusiness->deleteFlight($flightId);
                return response()->json(['message' => 'Xóa chuyến bay thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xóa chuyến bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
