<?php

namespace App\Business\AccountBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class SqlAccount
{
    // Lấy danh sách tài khoản
    public function getAllAccounts()
    {
        $query = "SELECT * FROM Account WHERE IsDeleted = 0";
        return DB::select($query);
    }

    // Tạo tài khoản mới (gồm 3 bảng)
    public function createAccount(array $data)
    {
        DB::beginTransaction();

        try {
            // Tạo tài khoản trong bảng Account
            $accountQuery = "INSERT INTO Account (email, password, account_name, citizen_id, phone, IsDeleted) 
                             VALUES (:email, :password, :account_name, :citizen_id, :phone, 0)";
            DB::insert($accountQuery, [
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'account_name' => $data['account_name'],
                'citizen_id' => $data['citizen_id'],
                'phone' => $data['phone'],
            ]);
            $accountId = DB::getPdo()->lastInsertId();

            // Tạo tài khoản trong bảng users (Laravel mặc định)
            $userQuery = "INSERT INTO users (name, email, password) 
                          VALUES (:name, :email, :password)";
            DB::insert($userQuery, [
                'name' => $data['account_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $userId = DB::getPdo()->lastInsertId();

            // Gán quyền trong bảng UserRoles
            $roleQuery = "INSERT INTO UserRoles (UserID, RoleID, IsDeleted) 
                          VALUES (:user_id, :role_id, 0)";
            DB::insert($roleQuery, [
                'user_id' => $userId,
                'role_id' => $data['role_id'], // RoleID từ request (2, 3, 4)
            ]);

            DB::commit();
            return $accountId;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Cập nhật tài khoản
    public function updateAccount(int $accountId, array $data)
    {
        $query = "UPDATE Account 
                  SET email = :email, account_name = :account_name, citizen_id = :citizen_id, phone = :phone 
                  WHERE account_id = :account_id AND IsDeleted = 0";
        return DB::update($query, [
            'email' => $data['email'],
            'account_name' => $data['account_name'],
            'citizen_id' => $data['citizen_id'],
            'phone' => $data['phone'],
            'account_id' => $accountId,
        ]);
    }

    // Xóa tài khoản
    public function deleteAccount(int $accountId)
    {
        $query = "UPDATE Account SET IsDeleted = 1 WHERE account_id = :account_id";
        return DB::update($query, ['account_id' => $accountId]);
    }
}
