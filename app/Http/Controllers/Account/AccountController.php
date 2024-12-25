<?php

namespace App\Http\Controllers\Account;

use App\Business\AccountBiz\AccountBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class AccountController
{
    protected AccountBusiness $accountBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->accountBusiness = new AccountBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }

    // Lấy danh sách khách hàng
    public function countAccounts(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Accounts";
    
            $permission = $this->permissionBiz->getPermission($pageName, $userId);
    
            if ($permission) {
                $search = $request->get('search', null);
    
                $totalAccounts = $this->accountBusiness->countAccounts($search);
    
                return response()->json(['totalCount' => $totalAccounts]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách tài khoản.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getAllAccounts(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Accounts";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $accounts = $this->accountBusiness->getAllAccounts($limit, $offset, $search);
                return response()->json($accounts);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách tài khoản.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Thêm tài khoản mới
    public function createAccount(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Accounts";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $accountId = $this->accountBusiness->createAccount($request->all());
                return response()->json(['message' => 'Tạo tài khoản thành công', 'account_id' => $accountId]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền thêm tài khoản.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật tài khoản
    public function updateAccount(Request $request, int $accountId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Accounts";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->accountBusiness->updateAccount($accountId, $request->all());
                return response()->json(['message' => 'Cập nhật tài khoản thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật tài khoản.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa tài khoản
    public function deleteAccount(int $accountId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Accounts";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->accountBusiness->deleteAccount($accountId);
                return response()->json(['message' => 'Xóa tài khoản thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xóa tài khoản.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}
