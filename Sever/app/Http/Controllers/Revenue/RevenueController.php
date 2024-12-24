<?php

namespace App\Http\Controllers\Revenue;

use App\Business\RevenueBiz\RevenueBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class RevenueController
{
    protected RevenueBusiness $revenueBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->revenueBusiness = new RevenueBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }

    // Lấy thông tin thống kê doanh thu
    public function getRevenueStatistics()
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Revenue";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $revenueData = $this->revenueBusiness->getRevenueStatistics();
                return response()->json($revenueData);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem thống kê doanh thu.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
