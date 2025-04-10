<?php

namespace App\Business\GateBiz;

use App\Business\GateBiz\SqlGate;
use Exception;
use Illuminate\Http\Request;

class GateBusiness
{
    protected SqlGate $sqlGate;

    public function __construct()
    {
        $this->sqlGate = new SqlGate();
    }

    // Lấy tất cả cổng bay
    public function getAllGates(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        return $this->sqlGate->getAllGates($limit, $offset, $search);
    }
    public function countGates(?string $search = null)
    {
        return $this->sqlGate->countGates($search);
    }   

    // Tạo mới cổng bay
    public function createGate(array $data)
    {
        try {
            return $this->sqlGate->createGate($data);
        } catch (Exception $e) {
            throw new Exception("Không thể thêm cổng bay mới: " . $e->getMessage());
        }
    }
// Cập nhật cổng bay
public function updateGate(int $gateId, array $data)
{
    try {
        $this->sqlGate->updateGate($gateId, $data);
    } catch (Exception $e) {
        throw new Exception("Không thể cập nhật cổng bay: " . $e->getMessage());
    }
}
    // Xóa cổng bay
    public function deleteGate(int $gateId)
    {
        try {
            $this->sqlGate->deleteGate($gateId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa cổng bay: " . $e->getMessage());
        }
    }
}
