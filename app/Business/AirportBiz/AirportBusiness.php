<?php

namespace App\Business\AirportBiz;

use App\Business\AirportBiz\SqlAirport;
use Exception;
use Illuminate\Http\Request;

class AirportBusiness
{
    protected SqlAirport $sqlAirport;

    public function __construct()
    {
        $this->sqlAirport = new SqlAirport();
    }

    /**
     * Lấy danh sách tất cả sân bay
     *
     * @return array
     */
    public function getAllAirports(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        return $this->sqlAirport->getAllAirports($limit, $offset, $search);
    }
    public function countAirports(?string $search = null)
    {
        return $this->sqlAirport->countAirports($search);
    }
    /**
     * Thêm sân bay mới
     *
     * @param array $data
     * @return int
     */
    public function createAirport(array $data)
    {
        try {
            return $this->sqlAirport->createAirport($data);
        } catch (Exception $e) {
            throw new Exception("Không thể thêm sân bay: " . $e->getMessage());
        }
    }

    /**
     * Cập nhật thông tin sân bay
     *
     * @param int $airportId
     * @param array $data
     * @return void
     */
    public function updateAirport(int $airportId, array $data)
    {
        try {
            $this->sqlAirport->updateAirport($airportId, $data);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật sân bay: " . $e->getMessage());
        }
    }

    /**
     * Xóa mềm sân bay
     *
     * @param int $airportId
     * @return void
     */
    public function deleteAirport(int $airportId)
    {
        try {
            $this->sqlAirport->deleteAirport($airportId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa sân bay: " . $e->getMessage());
        }
    }
}
