<?php

namespace App\Business\AccountBiz;

use App\Business\AccountBiz\SqlAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class AccountBusiness
{
    protected SqlAccount $sqlAccount;

    public function __construct()
    {
        $this->sqlAccount = new SqlAccount();
    }

    // Lấy danh sách tài khoản
    public function getAllAccounts()
    {
        return $this->sqlAccount->getAllAccounts();
    }

    // Thêm tài khoản mới
    public function createAccount(array $data)
    {
        return $this->sqlAccount->createAccount($data);
    }

    // Cập nhật tài khoản
    public function updateAccount(int $accountId, array $data)
    {
        $updatedRows = $this->sqlAccount->updateAccount($accountId, $data);
        if ($updatedRows === 0) {
            throw new \Exception("Không tìm thấy tài khoản hoặc cập nhật thất bại");
        }
    }

    // Xóa tài khoản
    public function deleteAccount(int $accountId)
    {
        $deletedRows = $this->sqlAccount->deleteAccount($accountId);
        if ($deletedRows === 0) {
            throw new \Exception("Không tìm thấy tài khoản hoặc xóa thất bại");
        }
    }
}
