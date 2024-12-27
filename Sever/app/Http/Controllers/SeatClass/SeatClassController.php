<?php

namespace App\Http\Controllers\SeatClass;

use App\Business\SeatClassBiz\SeatClassBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class SeatClassController
{
    protected SeatClassBusiness $seatClassBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->seatClassBusiness = new SeatClassBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }
    public function countSeatClass(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View SeatClass";
    
            $permission = $this->permissionBiz->getPermission($pageName, $userId);
    
            if ($permission) {
                $search = $request->get('search', null);
    
                $totalSeatClass = $this->seatClassBusiness->countSeatClass($search);
    
                return response()->json(['totalCount' => $totalSeatClass]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách hạng ghế.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getAllSeatClass(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View SeatClass";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $seatclass = $this->seatClassBusiness->getAllSeatClass($limit, $offset, $search);
                return response()->json($seatclass);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách hạng ghế.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Thêm hạng ghế mới
    public function createSeatClass(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage SeatClass";

            if ($this->permissionBiz->getPermission($pageName, $userId)) {
                $seatClassId = $this->seatClassBusiness->createSeatClass($request->all());
                return response()->json(['message' => 'Thêm hạng ghế thành công.', 'seat_class_id' => $seatClassId]);
            }

            return response()->json(['message' => 'Bạn không có quyền thêm hạng ghế.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật thông tin hạng ghế
    public function updateSeatClass(Request $request, int $seatClassId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage SeatClass";

            if ($this->permissionBiz->getPermission($pageName, $userId)) {
                $this->seatClassBusiness->updateSeatClass($seatClassId, $request->all());
                return response()->json(['message' => 'Cập nhật hạng ghế thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền cập nhật hạng ghế.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa hạng ghế
    public function deleteSeatClass(int $seatClassId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage SeatClass";

            if ($this->permissionBiz->getPermission($pageName, $userId)) {
                $this->seatClassBusiness->deleteSeatClass($seatClassId);
                return response()->json(['message' => 'Xóa hạng ghế thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền xóa hạng ghế.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }
}
