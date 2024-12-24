<?php

namespace App\Http\Controllers\Client;

use App\Business\ClientBiz\ClientBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    protected ClientBusiness $clientBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->clientBusiness = new ClientBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }

    // Lấy danh sách khách hàng
    public function countCustomers(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Customers";
    
            $permission = $this->permissionBiz->getPermission($pageName, $userId);
    
            if ($permission) {
                $search = $request->get('search', null);
                $country = $request->get('country', null);
    
                $totalCustomers = $this->clientBusiness->countCustomers($search, $country);
    
                return response()->json(['totalCount' => $totalCustomers]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách khách hàng.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function searchCustomer(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Customers";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);
                $country = $request->get('country', null);

                $clients = $this->clientBusiness->searchCustomer($limit, $offset, $search, $country);
                return response()->json($clients);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách khách hàng.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    // Thêm khách hàng
    public function createClient(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Customers";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $clientId = $this->clientBusiness->createClient($request->all());
                return response()->json(['message' => 'Thêm khách hàng thành công', 'client_id' => $clientId]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền thêm khách hàng.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật khách hàng
    public function updateClient(Request $request, int $clientId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Customers";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->clientBusiness->updateClient($clientId, $request->all());
                return response()->json(['message' => 'Cập nhật khách hàng thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật khách hàng.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa khách hàng
    public function deleteClient(int $clientId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Customers";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->clientBusiness->deleteClient($clientId);
                return response()->json(['message' => 'Xóa khách hàng thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xóa khách hàng.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}