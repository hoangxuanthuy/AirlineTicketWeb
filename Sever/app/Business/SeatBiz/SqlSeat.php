<?php

namespace App\Business\SeatBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlSeat
{
    public function countSeat(?string $search = null)
    {
        $query = "SELECT COUNT(*) as total FROM Seat WHERE IsDeleted = 0";

        $bindings = [];

        if (!empty($search)) {
            $query .= " AND plane_id = :plane_id";
            $bindings['plane_id'] = $search;
        }

        $result = DB::select($query, $bindings);
        return $result[0]->total ?? 0;
    }

    public function getAllSeat(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT * FROM Seat WHERE IsDeleted = 0";

        $bindings = [];

        if (!empty($search)) {
            $query .= " AND plane_id = :plane_id";
            $bindings['plane_id'] = $search;
        }

        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }

    public function createSeat(array $data)
    {
        $query = "INSERT INTO Seat (seat_class_id, plane_id, IsDeleted) VALUES (:seat_class_id, :plane_id, 0)";
        DB::insert($query, [
            'seat_class_id' => $data['seat_class_id'],
            'plane_id' => $data['plane_id']
        ]);

        return DB::getPdo()->lastInsertId();
    }

    public function updateSeat(int $seatId, array $data)
    {
        $query = "UPDATE Seat SET seat_class_id = :seat_class_id, plane_id = :plane_id WHERE seat_id = :seat_id AND IsDeleted = 0";
        DB::update($query, [
            'seat_class_id' => $data['seat_class_id'],
            'plane_id' => $data['plane_id'],
            'seat_id' => $seatId
        ]);
    }

    public function deleteSeat(int $seatId)
    {
        $query = "UPDATE Seat SET IsDeleted = 1 WHERE seat_id = :seat_id";
        DB::update($query, ['seat_id' => $seatId]);
    }
}
