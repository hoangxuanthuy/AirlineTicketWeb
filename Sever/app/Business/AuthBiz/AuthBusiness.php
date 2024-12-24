<?php

namespace App\Business\AuthBiz;

use App\Business\AuthBiz\SqlAuth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Http\Request;
class AuthBusiness
{
    protected SqlAuth $sqlAuth;

    public function __construct()
    {
        $this->sqlAuth = new SqlAuth();
    }

    /**
     * Tạo tài khoản mới
     *
     * @param  array  $data
     * @return array
     */
    public function createAccount(array $data)
    {
        try {
            // Mã hóa mật khẩu trước khi lưu vào database
            $data['password'] = Hash::make($data['password']);
            $account = $this->sqlAuth->createAccount($data);
            return $account;
        } catch (Exception $e) {
            throw new Exception("Không thể tạo tài khoản mới: " . $e->getMessage());
        }
    }

    public function getAccountByEmail(string $email)
    {
        $query = "SELECT * FROM Account WHERE email = :email AND IsDeleted = 0";
        return DB::selectOne($query, ['email' => $email]);
    }
}
