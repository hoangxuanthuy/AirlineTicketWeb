<?php

namespace App\Http\Controllers\Seat;

use App\Business\SeatBiz\SeatBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class SeatController extends Controller
{
    protected SeatBusiness $seatBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->seatBusiness = new SeatBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }

    public function countSeat(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Seat";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $search = $request->get('search', null);

                $totalSeat = $this->seatBusiness->countSeat($search);

                return response()->json(['totalCount' => $totalSeat]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách ghế.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    public function getAllSeat(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Seat";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $seats = $this->seatBusiness->getAllSeat($limit, $offset, $search);
                return response()->json($seats);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách ghế.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    public function createSeat(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Seat";

            if ($this->permissionBiz->getPermission($pageName, $userId)) {
                $seatId = $this->seatBusiness->createSeat($request->all());
                return response()->json(['message' => 'Thêm ghế thành công.', 'seat_id' => $seatId]);
            }

            return response()->json(['message' => 'Bạn không có quyền thêm ghế.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateSeat(Request $request, int $seatId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Seat";

            if ($this->permissionBiz->getPermission($pageName, $userId)) {
                $this->seatBusiness->updateSeat($seatId, $request->all());
                return response()->json(['message' => 'Cập nhật ghế thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền cập nhật ghế.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteSeat(int $seatId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Seat";

            if ($this->permissionBiz->getPermission($pageName, $userId)) {
                $this->seatBusiness->deleteSeat($seatId);
                return response()->json(['message' => 'Xóa ghế thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền xóa ghế.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }
}
