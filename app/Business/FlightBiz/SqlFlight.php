<?php

namespace App\Business\FlightBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlFlight
{
    public function getFlights(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT * FROM Flight WHERE IsDeleted = 0";
        $bindings = [];

        if (!empty($search)) {
            $query .= " AND (flight_id LIKE :search OR plane_id LIKE :search OR departure_airport_id LIKE :search OR arrival_airport_id LIKE :search)";
            $bindings['search'] = '%' . $search . '%';
        }

        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }
    // Lấy danh sách tất cả các chuyến bay
    public function countFlights(?string $search = null)
{
    $query = "SELECT COUNT(*) as total 
              FROM Flight F
              JOIN Airport DA ON F.departure_airport_id = DA.airport_id
              JOIN Airport AA ON F.arrival_airport_id = AA.airport_id
              WHERE F.IsDeleted = 0";
    $bindings = [];

    if (!empty($search)) {
        $query .= " AND (
            F.flight_id LIKE :search1 OR
            DA.airport_name LIKE :search2 OR
            AA.airport_name LIKE :search3
        )";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
        $bindings['search3'] = '%' . $search . '%';
    }
    

    $result = DB::select($query, $bindings);
    return $result[0]->total ?? 0;
}

public function getAllFlights(int $limit = 10, int $offset = 0, ?string $search = null)
{
    $query = "
        SELECT 
            F.flight_id AS 'flight_id',
            F.plane_id AS 'plane_id',
            F.departure_airport_id AS 'departure_airport_id',
            F.arrival_airport_id AS 'arrival_airport_id',
            F.gate_id AS 'gate_id',
            F.departure_date_time AS 'departure_date_time',
            DA.airport_name AS 'departure_airport',
            AA.airport_name AS 'arrival_airport',
            F.flight_time AS 'flight_time',
            F.unit_price AS 'unit_price',
            P.first_class_seats AS 'first_class_seats',
            P.second_class_seats AS 'second_class_seats'
        FROM 
            Flight F
        JOIN 
            Airport DA ON F.departure_airport_id = DA.airport_id
        JOIN 
            Airport AA ON F.arrival_airport_id = AA.airport_id
        JOIN 
            Plane P ON F.plane_id = P.plane_id
        WHERE 
            F.IsDeleted = 0
    ";
    $bindings = [];

    if (!empty($search)) {
        $query .= " AND (
            F.flight_id LIKE :search1 OR
            DA.airport_name LIKE :search2 OR
            AA.airport_name LIKE :search3
        )";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
        $bindings['search3'] = '%' . $search . '%';
    }
    

    $query .= " LIMIT :limit OFFSET :offset";
    $bindings['limit'] = $limit;
    $bindings['offset'] = $offset;

    return DB::select($query, $bindings);
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
