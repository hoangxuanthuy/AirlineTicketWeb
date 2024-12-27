<?php

namespace App\Business\AccountBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class SqlAccount
{
    public function countAccounts(?string $search = null)
    {
        $query = "SELECT COUNT(*) as total 
                  FROM Account
                  LEFT JOIN UserRoles ON Account.UserID = UserRoles.UserID
                  LEFT JOIN Roles ON UserRoles.RoleID = Roles.RoleID
                  WHERE Account.IsDeleted = 0 
                    AND (Roles.RoleName = 'Customer' OR Roles.RoleName = 'Staff')";

        $bindings = [];

        // Thêm điều kiện tìm kiếm nếu có
        // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND (Account.account_name LIKE :search1 
                      OR Account.email LIKE :search2 
                      OR Account.phone LIKE :search3 
                      OR Account.citizen_id LIKE :search4)";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
        $bindings['search3'] = '%' . $search . '%';
        $bindings['search4'] = '%' . $search . '%';
    }

        // Thực thi query
        $result = DB::select($query, $bindings);
        return $result[0]->total ?? 0;
    }

    public function getAllAccounts(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "
            SELECT 
                Account.*, 
                Roles.RoleName AS role_name
            FROM 
                Account
            LEFT JOIN 
                UserRoles ON Account.UserID = UserRoles.UserID
            LEFT JOIN 
                Roles ON UserRoles.RoleID = Roles.RoleID
            WHERE 
                Account.IsDeleted = 0 
                AND (Roles.RoleName = 'Customer' OR Roles.RoleName = 'Staff')";

        $bindings = [];

        // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND (Account.account_name LIKE :search1 
                      OR Account.email LIKE :search2 
                      OR Account.phone LIKE :search3 
                      OR Account.citizen_id LIKE :search4)";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
        $bindings['search3'] = '%' . $search . '%';
        $bindings['search4'] = '%' . $search . '%';
    }

        // Thêm giới hạn và phân trang
        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }
    


    // Tạo tài khoản mới (gồm 3 bảng)
    public function createAccount(array $data)
    {
        DB::beginTransaction();
    
        try {
            $validRoles = [3, 4]; // Danh sách RoleID hợp lệ (3 = Customer, 4 = Staff)
        if (!isset($data['role_id']) || !in_array($data['role_id'], $validRoles)) {
            throw new \Exception("RoleID không hợp lệ. RoleID chỉ có thể là 3 (Customer) hoặc 4 (Staff).");
        }
            // Tạo tài khoản trong bảng users (Laravel mặc định)
            $userId = DB::table('users')->insertGetId([
                'name' => $data['account_name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']), // Mã hóa mật khẩu
            ]);
    
            // Tạo tài khoản trong bảng Client
            $clientId = DB::table('Client')->insertGetId([
                'client_name' => $data['account_name'],
                'citizen_id' => $data['citizen_id'],
                'phone' => $data['phone'],
                'gender' => $data['gender'] ?? null, // nếu không có gender trong request, thì để null
                'birth_day' => $data['birth_day'] ?? null, // nếu không có birth_day trong request, thì để null
                'country' => $data['country'] ?? null, // nếu không có country trong request, thì để null
                'IsDeleted' => 0
            ]);
    
            // Tạo tài khoản trong bảng Account
            $accountId = DB::table('Account')->insertGetId([
                'email' => $data['email'],
                'password' => bcrypt($data['password']), // Mã hóa mật khẩu
                'account_name' => $data['account_name'],
                'citizen_id' => $data['citizen_id'],
                'phone' => $data['phone'],
                'UserID' => $userId, // Sử dụng ID từ bảng `users`
                'IsDeleted' => 0
            ]);
            
            // Gán quyền (RoleID = 4 - khách hàng) trong bảng UserRoles
            DB::table('UserRoles')->insert([
                'UserID' => $userId,
                'RoleID' => $data['role_id'], 
                'IsDeleted' => 0
            ]);
    
            DB::commit();
    
            return [
                'account_id' => $accountId,
                'user_id' => $userId,
                'client_id' => $clientId
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Không thể tạo tài khoản: " . $e->getMessage());
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
