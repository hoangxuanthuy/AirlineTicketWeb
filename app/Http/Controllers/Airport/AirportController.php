<?php

namespace App\Http\Controllers\Airport;

use App\Business\AirportBiz\AirportBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class AirportController
{
    protected AirportBusiness $airportBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->airportBusiness = new AirportBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }

    public function countAirports(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Airports";
    
            $permission = $this->permissionBiz->getPermission($pageName, $userId);
    
            if ($permission) {
                $search = $request->get('search', null);
    
                $totalAirports = $this->airportBusiness->countAirports($search);
    
                return response()->json(['totalCount' => $totalAirports]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách máy bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getAllAirports(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Airports";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $accounts = $this->airportBusiness->getAllAirports($limit, $offset, $search);
                return response()->json($accounts);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách máy bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Thêm sân bay mới
    public function createAirport(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Airports";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $airportId = $this->airportBusiness->createAirport($request->all());
                return response()->json(['message' => 'Thêm sân bay thành công', 'airport_id' => $airportId]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền thêm sân bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật sân bay
    public function updateAirport(Request $request, int $airportId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Airports";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->airportBusiness->updateAirport($airportId, $request->all());
                return response()->json(['message' => 'Cập nhật sân bay thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật sân bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa sân bay
    public function deleteAirport(int $airportId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Airports";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->airportBusiness->deleteAirport($airportId);
                return response()->json(['message' => 'Xóa sân bay thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xóa sân bay.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
