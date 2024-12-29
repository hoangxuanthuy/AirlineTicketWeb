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
    public function getMonthlyRevenue(Request $request)
{
    try {
        $user = Auth::user();
        $userId = $user->id;
        $pageName = "View Revenue";

        // Kiểm tra quyền
        $hasPermission = $this->permissionBiz->getPermission($pageName, $userId);
        if (!$hasPermission) {
            return response()->json(['message' => 'Bạn không có quyền xem thống kê doanh thu.'], 403);
        }

        $year = $request->query('year');
        $month = $request->query('month'); // Tháng có thể tùy chọn

        if (!$year) {
            return response()->json(['message' => 'Vui lòng cung cấp năm'], 400);
        }

        $data = $this->revenueBusiness->getMonthlyRevenue($year, $month);

        return response()->json($data);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
    }
}


    // Lấy báo cáo doanh thu năm
    public function getYearlyRevenue(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Revenue";

            // Kiểm tra quyền
            $hasPermission = $this->permissionBiz->getPermission($pageName, $userId);
            if (!$hasPermission) {
                return response()->json(['message' => 'Bạn không có quyền xem báo cáo năm.'], 403);
            }

            $year = $request->query('year');
            if (!$year) {
                return response()->json(['message' => 'Vui lòng cung cấp năm'], 400);
            }

            $data = $this->revenueBusiness->getYearlyRevenue($year);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getYearly(Request $request)
    {
        $year = $request->query('year');

        if (!$year) {
            return response()->json(['message' => 'Vui lòng cung cấp năm!'], 400);
        }

        try {
            $data = $this->revenueBusiness->getYearlyRevenueByMonth($year);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getMonthly(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');

        if (!$month || !$year) {
            return response()->json(['message' => 'Vui lòng cung cấp tháng và năm!'], 400);
        }

        try {
            $data = $this->revenueBusiness->getMonthlyRevenueByAirline($year, $month);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
