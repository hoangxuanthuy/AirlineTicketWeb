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

    public function getAllSeatClasses()
    {
        try {
            return $this->sqlSeatClass->getAllSeatClasses();
        } catch (Exception $e) {
            throw new Exception("Không thể lấy danh sách hạng ghế: " . $e->getMessage());
        }
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
