<?php

namespace App\Business\FlightBiz;

use App\Business\FlightBiz\SqlFlight;
use Exception;
use Illuminate\Http\Request;
class FlightBusiness
{
    protected SqlFlight $sqlFlight;

    public function __construct()
    {
        $this->sqlFlight = new SqlFlight();
    }

    // Lấy danh sách tất cả chuyến bay
    public function getAllFlights(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        return $this->sqlFlight->getAllFlights($limit, $offset, $search);
    }

    public function countFlights(?string $search = null)
    {
        return $this->sqlFlight->countFlights($search);
    }

    // Lấy thông tin chuyến bay theo ID
    public function getFlightById(int $flightId)
    {
        $flight = $this->sqlFlight->getFlightById($flightId);
        if (!$flight) {
            throw new Exception("Chuyến bay không tồn tại");
        }
        return $flight;
    }

    // Thêm chuyến bay mới
    public function createFlight(array $data)
    {
        if (empty($data['plane_id']) || empty($data['departure_airport_id']) || empty($data['arrival_airport_id'])) {
            throw new Exception("Dữ liệu chuyến bay không được để trống");
        }
        return $this->sqlFlight->createFlight($data);
    }

    // Cập nhật thông tin chuyến bay
    public function updateFlight(int $flightId, array $data)
    {
        $updatedRows = $this->sqlFlight->updateFlight($flightId, $data);
        if ($updatedRows === 0) {
            throw new Exception("Cập nhật thất bại hoặc không tìm thấy chuyến bay");
        }
    }

    // Xóa chuyến bay
    public function deleteFlight(int $flightId)
    {
        $deletedRows = $this->sqlFlight->deleteFlight($flightId);
        if ($deletedRows === 0) {
            throw new Exception("Xóa thất bại hoặc không tìm thấy chuyến bay");
        }
    }
}
