<?php

namespace App\Business\SeatFlightBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlSeatFlight
{
    public function countSeatFlights(?string $search = null)
    {
        $query = "SELECT COUNT(*) as total FROM SeatFlight WHERE IsDeleted = 0";
        $bindings = [];

        if (!empty($search)) {
            $query .= " AND (seat_id LIKE :search1 OR flight_id LIKE :search2)";
            $bindings['search1'] = '%' . $search . '%';
            $bindings['search2'] = '%' . $search . '%';
        }

        $result = DB::select($query, $bindings);
        return $result[0]->total ?? 0;
    }

    public function getAllSeatFlights(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT * FROM SeatFlight WHERE IsDeleted = 0";
        $bindings = [];

        if (!empty($search)) {
            $query .= " AND (seat_id LIKE :search1 OR flight_id LIKE :search2)";
            $bindings['search1'] = '%' . $search . '%';
            $bindings['search2'] = '%' . $search . '%';
        }

        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }

    public function createSeatFlight(array $data)
    {
        $query = "INSERT INTO SeatFlight (seat_id, flight_id, status, IsDeleted) VALUES (:seat_id, :flight_id, :status, 0)";
        DB::insert($query, [
            'seat_id' => $data['seat_id'],
            'flight_id' => $data['flight_id'],
            'status' => $data['status']
        ]);

        return DB::getPdo()->lastInsertId();
    }

    public function updateSeatFlight(int $seatId, int $flightId, array $data)
    {
        $query = "UPDATE SeatFlight SET status = :status WHERE seat_id = :seat_id AND flight_id = :flight_id AND IsDeleted = 0";
        DB::update($query, [
            'status' => $data['status'],
            'seat_id' => $seatId,
            'flight_id' => $flightId
        ]);
    }

    public function deleteSeatFlight(int $seatId, int $flightId)
    {
        $query = "UPDATE SeatFlight SET IsDeleted = 1 WHERE seat_id = :seat_id AND flight_id = :flight_id";
        DB::update($query, ['seat_id' => $seatId, 'flight_id' => $flightId]);
    }
}
