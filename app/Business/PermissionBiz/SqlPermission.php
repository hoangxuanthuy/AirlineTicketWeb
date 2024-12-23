<?php
namespace App\Business\PermissionBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
/**
 * Sql Permission
 * 
 * @auth: Nguyen Minh Nhut
 */
class SqlPermission
{
    // Get All Students
    public function getPermission(string $permissionName, int $userId)
    {
        // Query
        $query = 
            " SELECT PermissionName".
            " FROM".
                " users".
            " INNER JOIN UserRoles".
                " ON UserRoles.UserID = users.id".
            " INNER JOIN Roles".
                " ON UserRoles.RoleID = Roles.RoleID".
            " INNER JOIN RolePermissions".
                " ON RolePermissions.RoleID = Roles.RoleID".
            " INNER JOIN Permissions".
                " ON Permissions.PermissionID = RolePermissions.PermissionID".
            " WHERE users.id = :userId".
                " AND Permissions.PermissionName = :permissionName";

         // Bindings cho các tham số
        $bindings = [
            'userId' => $userId,
            'permissionName' => $permissionName,
        ];

        // Thực thi câu lệnh SQL và trả về kết quả
        $result = DB::select($query, $bindings);
        
        return $result;  
    }
}