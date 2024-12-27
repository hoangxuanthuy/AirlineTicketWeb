<?php

namespace App\Http\Controllers\Luggage;

use App\Business\LuggageBiz\LuggageBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class LuggageController
{
    protected LuggageBusiness $luggageBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->luggageBusiness = new LuggageBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }
    public function countLuggage(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Luggage";
    
            $permission = $this->permissionBiz->getPermission($pageName, $userId);
    
            if ($permission) {
                $search = $request->get('search', null);
    
                $totalLuggage = $this->luggageBusiness->countLuggage($search);
    
                return response()->json(['totalCount' => $totalLuggage]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách hành lý.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getAllLuggage(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Luggage";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $luggage = $this->luggageBusiness->getAllLuggage($limit, $offset, $search);
                return response()->json($luggage);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách hành lý.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    
    // Thêm hành lý mới
    public function createLuggage(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Luggage";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->luggageBusiness->createLuggage($request->all());
                return response()->json(['message' => 'Thêm hành lý thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền thêm hành lý.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật thông tin hành lý
    public function updateLuggage(Request $request, int $luggageId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Luggage";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->luggageBusiness->updateLuggage($luggageId, $request->all());
                return response()->json(['message' => 'Cập nhật hành lý thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật hành lý.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa hành lý
    public function deleteLuggage(int $luggageId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Luggage";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->luggageBusiness->deleteLuggage($luggageId);
                return response()->json(['message' => 'Xóa hành lý thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xóa hành lý.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
