<?php

namespace App\Business\AirplaneBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlAirplane
{
    // Lấy danh sách tất cả các máy bay
    public function getAllAirplanes()
    {
        $query = "SELECT * FROM Plane WHERE IsDeleted = 0";
        return DB::select($query);
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
