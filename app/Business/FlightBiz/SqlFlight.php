<?php

namespace App\Business\FlightBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlFlight
{
    // Lấy danh sách tất cả các chuyến bay
    public function getAllFlights()
    {
        $query = "SELECT * FROM Flight WHERE IsDeleted = 0";
        return DB::select($query);
    }

    // Lấy chi tiết chuyến bay theo ID
    public function getFlightById(int $flightId)
    {
        $query = "SELECT * FROM Flight WHERE flight_id = :flight_id AND IsDeleted = 0";
        return DB::selectOne($query, ['flight_id' => $flightId]);
    }

    // Thêm mới chuyến bay
    public function createFlight(array $data)
    {
        $query = "INSERT INTO Flight (plane_id, departure_airport_id, arrival_airport_id, gate_id, flight_time, departure_date_time, unit_price, IsDeleted) 
                  VALUES (:plane_id, :departure_airport_id, :arrival_airport_id, :gate_id, :flight_time, :departure_date_time, :unit_price, 0)";
        DB::insert($query, [
            'plane_id' => $data['plane_id'],
            'departure_airport_id' => $data['departure_airport_id'],
            'arrival_airport_id' => $data['arrival_airport_id'],
            'gate_id' => $data['gate_id'],
            'flight_time' => $data['flight_time'],
            'departure_date_time' => $data['departure_date_time'],
            'unit_price' => $data['unit_price']
        ]);
        return DB::getPdo()->lastInsertId();
    }

    // Cập nhật thông tin chuyến bay theo ID
    public function updateFlight(int $flightId, array $data)
    {
        $query = "UPDATE Flight 
                  SET plane_id = :plane_id, departure_airport_id = :departure_airport_id, arrival_airport_id = :arrival_airport_id, 
                      gate_id = :gate_id, flight_time = :flight_time, departure_date_time = :departure_date_time, unit_price = :unit_price 
                  WHERE flight_id = :flight_id AND IsDeleted = 0";
        return DB::update($query, [
            'plane_id' => $data['plane_id'],
            'departure_airport_id' => $data['departure_airport_id'],
            'arrival_airport_id' => $data['arrival_airport_id'],
            'gate_id' => $data['gate_id'],
            'flight_time' => $data['flight_time'],
            'departure_date_time' => $data['departure_date_time'],
            'unit_price' => $data['unit_price'],
            'flight_id' => $flightId
        ]);
    }

    // Xóa chuyến bay theo ID (xóa mềm)
    public function deleteFlight(int $flightId)
    {
        $query = "UPDATE Flight SET IsDeleted = 1 WHERE flight_id = :flight_id";
        return DB::update($query, ['flight_id' => $flightId]);
    }
}
