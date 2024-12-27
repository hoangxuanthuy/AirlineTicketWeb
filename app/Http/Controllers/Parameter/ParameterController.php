<?php

namespace App\Http\Controllers\Parameter;

use App\Business\ParameterBiz\ParameterBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ParameterController extends Controller
{
    protected ParameterBusiness $parameterBusiness;
    protected PersmissionBusiness $permissionBusiness;

    public function __construct()
    {
        $this->parameterBusiness = new ParameterBusiness();
        $this->permissionBusiness = new PersmissionBusiness();
    }

    public function getParameter(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Parameters";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $parameters = $this->parameterBusiness->getParameter();
                return response()->json($parameters);
            }

            return response()->json(['message' => 'Bạn không có quyền xem tham số.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateParameter(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Parameters";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $this->parameterBusiness->updateParameter($request->all());
                return response()->json(['message' => 'Cập nhật tham số thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền cập nhật tham số.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }
}
