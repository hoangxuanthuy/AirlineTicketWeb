<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Business\RoleBiz\RoleBusiness;
use Illuminate\Http\Request; // Thêm Request
use Illuminate\Support\Facades\Validator;


/**
 * Role Controller
 *
 * @auth: Nguyen Minh Nhut
 */
class RoleController extends Controller
{
    protected RoleBusiness $roleBusiness;

    /**
     * Constructor
     */
    public function __construct()
{
    $this->roleBusiness = new RoleBusiness();
}

    // Tạo role mới
    public function createRole(Request $request)
    {
        $request->validate([
            'RoleName' => 'required|string|max:100',
        ]);

        try {
            $this->roleBusiness->createRole($request->RoleName);
            return response()->json(['message' => 'Role created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Cập nhật Role
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'roleName' => 'required|string|max:100',
        ]);
    
        try {
            // Kiểm tra xem vai trò có bị xóa hay không
            $role = $this->roleBusiness->findRoleById((int) $id);
            
            if (!$role) {
                return response()->json([
                    'message' => 'Vai trò không tồn tại hoặc đã bị xóa.'
                ], 404);
            }
    
            // Gọi phương thức cập nhật vai trò
            $this->roleBusiness->updateRole((int)$id, $request->input('roleName'));
    
            return response()->json([
                'message' => 'Vai trò đã được cập nhật thành công.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa mềm Role
     */
    public function destroyRole($id)
    {
        try {
            // Kiểm tra xem vai trò có bị xóa hay không
            $role = $this->roleBusiness->findRoleById((int) $id);
            
            if (!$role) {
                return response()->json([
                    'message' => 'Vai trò không tồn tại hoặc đã bị xóa.'
                ], 404);
            }
    
            // Gọi phương thức xóa mềm role
            $this->roleBusiness->deleteRole((int)$id);
    
            return response()->json([
                'message' => 'Vai trò đã được xóa thành công.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
