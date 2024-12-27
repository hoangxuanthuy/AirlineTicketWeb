<?php

namespace App\Http\Controllers\Gate;

use App\Business\GateBiz\GateBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GateController
{
    protected GateBusiness $gateBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->gateBusiness = new GateBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }
    public function countGates(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Gates";
    
            $permission = $this->permissionBiz->getPermission($pageName, $userId);
    
            if ($permission) {
                $search = $request->get('search', null);
    
                $totalGates = $this->gateBusiness->countGates($search);
    
                return response()->json(['totalCount' => $totalGates]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách cổng bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getAllGates(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Gates";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $gates = $this->gateBusiness->getAllGates($limit, $offset, $search);
                return response()->json($gates);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách cổng bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    // Lấy tất cả cổng bay
    
    // Thêm cổng bay
    public function createGate(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Gates";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $gateId = $this->gateBusiness->createGate($request->all());
                return response()->json(['message' => 'Thêm cổng bay thành công', 'gate_id' => $gateId]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền thêm cổng bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật cổng bay
    public function updateGate(Request $request, int $gateId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Gates";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->gateBusiness->updateGate($gateId, $request->all());
                return response()->json(['message' => 'Cập nhật cổng bay thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật cổng bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa cổng bay
    public function deleteGate(int $gateId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Gates";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->gateBusiness->deleteGate($gateId);
                return response()->json(['message' => 'Xóa cổng bay thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xóa cổng bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
