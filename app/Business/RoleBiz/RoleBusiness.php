<?php

namespace App\Business\RoleBiz;

use App\Business\RoleBiz\SqlRole;
use Exception;
use Illuminate\Http\Request;
class RoleBusiness
{
    protected SqlRole $sqlRole;

    public function __construct()
    {
        $this->sqlRole = new SqlRole();
    }
    // Tìm vai trò theo ID
    public function findRoleById(int $roleId)
    {
        try {
            return $this->sqlRole->findRoleById($roleId);
        } catch (Exception $e) {
            throw new Exception("Không thể tìm thấy vai trò: " . $e->getMessage());
        }
    }
    // Tạo role mới
    public function createRole(string $roleName)
    {
        try {
            // Gọi hàm tạo role từ SqlRole
            $this->sqlRole->createRole($roleName);
        } catch (Exception $e) {
            throw new Exception("Không thể tạo vai trò mới: " . $e->getMessage());
        }
    }

    // Cập nhật role
    public function updateRole(int $roleId, string $roleName)
    {
        try {
            // Gọi hàm cập nhật role từ SqlRole
            $this->sqlRole->updateRole($roleId, $roleName);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật vai trò: " . $e->getMessage());
        }
    }

    // Xóa mềm role
    public function deleteRole(int $roleId)
    {
        try {
            // Gọi hàm xóa mềm role từ SqlRole
            $this->sqlRole->softDeleteRole($roleId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa vai trò: " . $e->getMessage());
        }
    }
}
