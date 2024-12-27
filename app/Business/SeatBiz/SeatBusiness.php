<?php

namespace App\Business\SeatBiz;

use App\Business\SeatBiz\SqlSeat;
use Exception;
use Illuminate\Http\Request;
class SeatBusiness
{
    protected SqlSeat $sqlSeat;

    public function __construct()
    {
        $this->sqlSeat = new SqlSeat();
    }

    public function getAllSeat(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        return $this->sqlSeat->getAllSeat($limit, $offset, $search);
    }

    public function countSeat(?string $search = null)
    {
        return $this->sqlSeat->countSeat($search);
    }

    public function createSeat(array $data)
    {
        try {
            return $this->sqlSeat->createSeat($data);
        } catch (Exception $e) {
            throw new Exception("Không thể thêm ghế mới: " . $e->getMessage());
        }
    }

    public function updateSeat(int $seatId, array $data)
    {
        try {
            $this->sqlSeat->updateSeat($seatId, $data);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật ghế: " . $e->getMessage());
        }
    }

    public function deleteSeat(int $seatId)
    {
        try {
            $this->sqlSeat->deleteSeat($seatId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa ghế: " . $e->getMessage());
        }
    }
}
