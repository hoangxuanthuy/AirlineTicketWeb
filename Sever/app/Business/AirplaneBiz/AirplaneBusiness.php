<?php

namespace App\Business\AirplaneBiz;

use App\Business\AirplaneBiz\SqlAirplane;
use Exception;
use Illuminate\Http\Request;
class AirplaneBusiness
{
    protected SqlAirplane $sqlAirplane;

    public function __construct()
    {
        $this->sqlAirplane = new SqlAirplane();
    }

    // Lấy danh sách tất cả máy bay
    public function getAllAirplanes()
    {
        return $this->sqlAirplane->getAllAirplanes();
    }

    // Lấy thông tin máy bay theo ID
    public function getAirplaneById(int $airplaneId)
    {
        $airplane = $this->sqlAirplane->getAirplaneById($airplaneId);
        if (!$airplane) {
            throw new Exception("Máy bay không tồn tại");
        }
        return $airplane;
    }

    // Thêm máy bay mới
    public function createAirplane(array $data)
    {
        if (empty($data['plane_name']) || empty($data['airline_id'])) {
            throw new Exception("Tên máy bay và mã hãng bay không được để trống");
        }
        return $this->sqlAirplane->createAirplane($data);
    }

    // Cập nhật thông tin máy bay
    public function updateAirplane(int $airplaneId, array $data)
    {
        $updatedRows = $this->sqlAirplane->updateAirplane($airplaneId, $data);
        if ($updatedRows === 0) {
            throw new Exception("Cập nhật thất bại hoặc không tìm thấy máy bay");
        }
    }

    // Xóa máy bay
    public function deleteAirplane(int $airplaneId)
    {
        $deletedRows = $this->sqlAirplane->deleteAirplane($airplaneId);
        if ($deletedRows === 0) {
            throw new Exception("Xóa thất bại hoặc không tìm thấy máy bay");
        }
    }
}
