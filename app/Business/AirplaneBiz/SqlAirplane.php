<?php

namespace App\Business\AirplaneBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlAirplane
{
    // Lấy danh sách tất cả các máy bay
    public function countAirplanes(?string $search = null)
{
    $query = "SELECT COUNT(*) as total FROM Plane WHERE IsDeleted = 0";

    $bindings = [];

    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND (plane_name LIKE :search1 )";
        $bindings['search1'] = '%' . $search . '%';
    }
    // Thực thi query
    $result = DB::select($query, $bindings);
    return $result[0]->total ?? 0;
}
    public function getAllAirplanes(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT *
                FROM Plane
                WHERE IsDeleted = 0";

        $bindings = [];

        if (!empty($search)) {
            $query .= " AND (plane_name LIKE :search1 )";
            $bindings['search1'] = '%' . $search . '%';
        }

        // Thêm giới hạn và phân trang
        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }

    // Lấy chi tiết máy bay theo ID
    public function getAirplaneById(int $airplaneId)
    {
        $query = "SELECT * FROM Plane WHERE plane_id = :plane_id AND IsDeleted = 0";
        return DB::selectOne($query, ['plane_id' => $airplaneId]);
    }


    // Thêm mới máy bay
    public function createAirplane(array $data)
    {
        $query = "INSERT INTO Plane (plane_name, airline_id, first_class_seats, second_class_seats, IsDeleted) 
                  VALUES (:plane_name, :airline_id, :first_class_seats, :second_class_seats, 0)";
        DB::insert($query, [
            'plane_name' => $data['plane_name'],
            'airline_id' => $data['airline_id'],
            'first_class_seats' => $data['first_class_seats'],
            'second_class_seats' => $data['second_class_seats']
        ]);
        return DB::getPdo()->lastInsertId();
    }

    // Cập nhật thông tin máy bay theo ID
    public function updateAirplane(int $airplaneId, array $data)
    {
        $query = "UPDATE Plane 
                  SET plane_name = :plane_name, airline_id = :airline_id, first_class_seats = :first_class_seats, second_class_seats = :second_class_seats 
                  WHERE plane_id = :plane_id AND IsDeleted = 0";
        return DB::update($query, [
            'plane_name' => $data['plane_name'],
            'airline_id' => $data['airline_id'],
            'first_class_seats' => $data['first_class_seats'],
            'second_class_seats' => $data['second_class_seats'],
            'plane_id' => $airplaneId
        ]);
    }

    // Xóa máy bay theo ID (xóa mềm)
    public function deleteAirplane(int $airplaneId)
    {
        $query = "UPDATE Plane SET IsDeleted = 1 WHERE plane_id = :plane_id";
        return DB::update($query, ['plane_id' => $airplaneId]);
    }
}
