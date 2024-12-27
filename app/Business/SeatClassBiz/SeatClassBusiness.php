<?php

namespace App\Business\SeatClassBiz;

use App\Business\SeatClassBiz\SqlSeatClass;
use Exception;
use Illuminate\Http\Request;
class SeatClassBusiness
{
    protected SqlSeatClass $sqlSeatClass;

    public function __construct()
    {
        $this->sqlSeatClass = new SqlSeatClass();
    }

    public function getAllSeatClass(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        return $this->sqlSeatClass->getAllSeatClass($limit, $offset, $search);
    }
    public function countSeatClass(?string $search = null)
    {
        return $this->sqlSeatClass->countSeatClass($search);
    }
    public function createSeatClass(array $data)
    {
        try {
            return $this->sqlSeatClass->createSeatClass($data);
        } catch (Exception $e) {
            throw new Exception("Không thể thêm hạng ghế mới: " . $e->getMessage());
        }
    }

    public function updateSeatClass(int $seatClassId, array $data)
    {
        try {
            $this->sqlSeatClass->updateSeatClass($seatClassId, $data);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật hạng ghế: " . $e->getMessage());
        }
    }

    public function deleteSeatClass(int $seatClassId)
    {
        try {
            $this->sqlSeatClass->deleteSeatClass($seatClassId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa hạng ghế: " . $e->getMessage());
        }
    }
}
