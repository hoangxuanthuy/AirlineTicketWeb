<?php

namespace App\Business\AuthBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlAuth
{
    /**
     * Tạo tài khoản mới trong bảng Account và bảng users
     *
     * @param  array  $data
     * @return array
     */
    /**
     * Tạo tài khoản mới trong bảng Account, users và UserRoles
     *
     * @param  array  $data
     * @return array
     */
    public function createAccount(array $data)
    {
        DB::beginTransaction();

        try {
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
                'password' => $data['password'],
                'account_name' => $data['account_name'],
                'citizen_id' => $data['citizen_id'],
                'phone' => $data['phone'],
                'UserID' => $clientId,
                'IsDeleted' => 0
            ]);

            // Tạo tài khoản trong bảng users (Laravel mặc định)
            $userId = DB::table('users')->insertGetId([
                'name' => $data['account_name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            // Gán quyền (RoleID = 4 - khách hàng) trong bảng UserRoles
            DB::table('UserRoles')->insert([
                'UserID' => $userId,
                'RoleID' => 4, // Mặc định RoleID = 4 (khách hàng)
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


    /**
     * Lấy thông tin tài khoản bằng email
     *
     * @param  string  $email
     * @return object|null
     */
    public function getAccountByEmail(string $email)
    {
        $query = "SELECT * FROM Account WHERE email = :email AND IsDeleted = 0";
        return DB::selectOne($query, ['email' => $email]);
    }
}
