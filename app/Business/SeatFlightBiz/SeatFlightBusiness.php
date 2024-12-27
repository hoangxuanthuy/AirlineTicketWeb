<?php

namespace App\Business\SeatFlightBiz;

use App\Business\SeatFlightBiz\SqlSeatFlight;
use Exception;
use Illuminate\Http\Request;
class SeatFlightBusiness
{
    protected SqlSeatFlight $sqlSeatFlight;

    public function __construct()
    {
        $this->sqlSeatFlight = new SqlSeatFlight();
    }

    public function getAllSeatFlights(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        return $this->sqlSeatFlight->getAllSeatFlights($limit, $offset, $search);
    }

    public function countSeatFlights(?string $search = null)
    {
        return $this->sqlSeatFlight->countSeatFlights($search);
    }

    public function createSeatFlight(array $data)
    {
        try {
            return $this->sqlSeatFlight->createSeatFlight($data);
        } catch (Exception $e) {
            throw new Exception("Không thể thêm SeatFlight: " . $e->getMessage());
        }
    }

    public function updateSeatFlight(int $seatId, int $flightId, array $data)
    {
        try {
            $this->sqlSeatFlight->updateSeatFlight($seatId, $flightId, $data);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật SeatFlight: " . $e->getMessage());
        }
    }

    public function deleteSeatFlight(int $seatId, int $flightId)
    {
        try {
            $this->sqlSeatFlight->deleteSeatFlight($seatId, $flightId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa SeatFlight: " . $e->getMessage());
        }
    }
}
