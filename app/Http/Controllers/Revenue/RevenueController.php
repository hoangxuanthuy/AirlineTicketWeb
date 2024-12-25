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
            $month = $request->query('month'); // Tùy chọn

            if (!$year) {
                return response()->json(['message' => 'Vui lòng cung cấp năm'], 400);
            }

            $data = $this->revenueBusiness->getMonthlyRevenue($year, $month);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    // API lấy báo cáo năm
    public function getYearlyReport(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Revenue";

            // Kiểm tra quyền
            if (!$this->permissionBiz->getPermission($pageName, $userId)) {
                return response()->json(['message' => 'Bạn không có quyền xem báo cáo năm.'], 403);
            }

            $year = $request->query('year');
            if (!$year) {
                return response()->json(['message' => 'Vui lòng cung cấp năm.'], 400);
            }

            $reportData = $this->revenueBusiness->getYearlyReport($year);
            return response()->json($reportData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // API lấy báo cáo tháng
    public function getMonthlyReport(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Revenue";

            // Kiểm tra quyền
            if (!$this->permissionBiz->getPermission($pageName, $userId)) {
                return response()->json(['message' => 'Bạn không có quyền xem báo cáo tháng.'], 403);
            }

            $month = $request->query('month');
            $year = $request->query('year');
            if (!$month || !$year) {
                return response()->json(['message' => 'Vui lòng cung cấp đầy đủ tháng và năm.'], 400);
            }

            $reportData = $this->revenueBusiness->getMonthlyReport($month, $year);
            return response()->json($reportData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
