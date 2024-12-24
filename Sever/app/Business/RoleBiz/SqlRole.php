<?php
namespace App\Business\RoleBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlRole
{
    // Tìm vai trò theo ID
    public function findRoleById(int $roleId)
{
    $query = "SELECT * FROM Roles WHERE RoleID = :roleId AND IsDeleted = 0";
    return DB::selectOne($query, ['roleId' => $roleId]);
}

    // Tạo role mới
    public function createRole(string $RoleName)
    {
        $query = "INSERT INTO Roles (RoleName, IsDeleted) VALUES (:RoleName, 0)";
        DB::insert($query, ['RoleName' => $RoleName]);
    }

    // Cập nhật thông tin role
    public function updateRole(int $roleId, string $roleName)
    {
        $query = "UPDATE Roles SET RoleName = :roleName WHERE RoleID = :roleId AND IsDeleted = 0";
        DB::update($query, ['roleName' => $roleName, 'roleId' => $roleId]);
    }

    // Cập nhật IsDeleted = 1 để "xóa mềm" role
    public function softDeleteRole(int $roleId)
    {
        $query = "UPDATE Roles SET IsDeleted = 1 WHERE RoleID = :roleId";
        DB::update($query, ['roleId' => $roleId]);
    }
}

