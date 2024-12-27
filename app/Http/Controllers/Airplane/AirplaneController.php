<?php

namespace App\Http\Controllers\Airplane;

use App\Business\AirplaneBiz\AirplaneBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class AirplaneController
{
    protected AirplaneBusiness $airplaneBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->airplaneBusiness = new AirplaneBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }

    public function countAirplanes(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Airplanes";
    
            $permission = $this->permissionBiz->getPermission($pageName, $userId);
    
            if ($permission) {
                $search = $request->get('search', null);
    
                $totalAirplanes = $this->airplaneBusiness->countAirplanes($search);
    
                return response()->json(['totalCount' => $totalAirplanes]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách máy bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getAllAirplanes(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Airplanes";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $airplane = $this->airplaneBusiness->getAllAirplanes($limit, $offset, $search);
                return response()->json($airplane);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách máy bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    // Thêm máy bay
    public function createAirplane(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Airplanes";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $airplaneId = $this->airplaneBusiness->createAirplane($request->all());
                return response()->json(['message' => 'Thêm máy bay thành công', 'airplane_id' => $airplaneId]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền thêm máy bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật máy bay
    public function updateAirplane(Request $request, int $airplaneId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Airplanes";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->airplaneBusiness->updateAirplane($airplaneId, $request->all());
                return response()->json(['message' => 'Cập nhật máy bay thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật máy bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa máy bay
    public function deleteAirplane(int $airplaneId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Airplanes";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->airplaneBusiness->deleteAirplane($airplaneId);
                return response()->json(['message' => 'Xóa máy bay thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xóa máy bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
