<?php

namespace App\Http\Controllers\Parameter;

use App\Business\ParameterBiz\ParameterBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ParameterController
{
    protected ParameterBusiness $parameterBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->parameterBusiness = new ParameterBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }

    // Lấy danh sách các tham số hệ thống
    public function getAllParameters()
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Parameters";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);
            
            if ($permission) {
                $parameters = $this->parameterBusiness->getAllParameters();
                return response()->json($parameters);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách tham số hệ thống.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật tham số theo ID
    public function updateParameter(Request $request, int $parameterId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Parameters";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->parameterBusiness->updateParameter($parameterId, $request->all());
                return response()->json(['message' => 'Cập nhật tham số thành công!']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật tham số hệ thống.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
