<?php

namespace App\Http\Controllers\Intermediate;

use App\Business\IntermediateBiz\IntermediateBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class IntermediateController extends Controller
{
    protected IntermediateBusiness $intermediateBusiness;
    protected PersmissionBusiness $permissionBusiness;

    public function __construct()
    {
        $this->intermediateBusiness = new IntermediateBusiness();
        $this->permissionBusiness = new PersmissionBusiness();
    }
    public function countIntermediates(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Intermediate";
    
            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $flightId = $request->get('flight_id', null);
    
                if (is_null($flightId)) {
                    return response()->json(['message' => 'Mã chuyến bay không được để trống.'], 400);
                }
    
                $totalCount = $this->intermediateBusiness->countIntermediates($flightId);
                return response()->json(['totalCount' => $totalCount]);
            }
    
            return response()->json(['message' => 'Bạn không có quyền xem tổng số sân bay trung gian.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function getAllIntermediates(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Intermediate";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $flightId = $request->get('flight_id', null);
                $intermediates = $this->intermediateBusiness->getAllIntermediates($flightId);
                return response()->json($intermediates);
            }

            return response()->json(['message' => 'Bạn không có quyền xem danh sách sân bay trung gian.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function createIntermediate(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Intermediate";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $this->intermediateBusiness->createIntermediate($request->all());
                return response()->json(['message' => 'Thêm sân bay trung gian thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền thêm sân bay trung gian.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateIntermediate(Request $request, int $flightId, int $airportId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Intermediate";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $this->intermediateBusiness->updateIntermediate($flightId, $airportId, $request->all());
                return response()->json(['message' => 'Cập nhật sân bay trung gian thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền cập nhật sân bay trung gian.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteIntermediate(int $flightId, int $airportId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Intermediate";

            if ($this->permissionBusiness->getPermission($pageName, $userId)) {
                $this->intermediateBusiness->deleteIntermediate($flightId, $airportId);
                return response()->json(['message' => 'Xóa sân bay trung gian thành công.']);
            }

            return response()->json(['message' => 'Bạn không có quyền xóa sân bay trung gian.'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi.', 'error' => $e->getMessage()], 500);
        }
    }
}
