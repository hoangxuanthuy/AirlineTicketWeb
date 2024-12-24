<?php

namespace App\Business\ParameterBiz;

use App\Business\ParameterBiz\SqlParameter;
use Exception;
use Illuminate\Http\Request;
class ParameterBusiness
{
    protected SqlParameter $sqlParameter;

    public function __construct()
    {
        $this->sqlParameter = new SqlParameter();
    }

    // Lấy danh sách tham số hệ thống
    public function getAllParameters()
    {
        try {
            return $this->sqlParameter->getAllParameters();
        } catch (Exception $e) {
            throw new Exception("Không thể lấy danh sách tham số: " . $e->getMessage());
        }
    }

    // Cập nhật tham số theo ID
    public function updateParameter(int $parameterId, array $data)
    {
        try {
            $this->sqlParameter->updateParameter($parameterId, $data);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật tham số: " . $e->getMessage());
        }
    }
}
